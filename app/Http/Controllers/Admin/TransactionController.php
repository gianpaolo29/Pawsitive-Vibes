<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Notifications\LowStockNotification;
use App\Notifications\GcashPaymentPendingNotification;
use Illuminate\Support\Facades\Notification;

class TransactionController extends Controller
{
    /**
     * MAIN INDEX – Transactions Overview + filters + stats
     */
    public function index(Request $request)
    {
        $search        = $request->string('s')->trim()->value();
        $status        = $request->string('status')->toString();          // pending / paid / cancelled / refunded
        $paymentStatus = $request->string('payment_status')->toString();  // unpaid / paid / refunded
        $dateFilter    = $request->string('date')->toString();            // today / last_7_days / last_30_days

        $ordersQuery = Transaction::query()
            ->with(['user:id,username,email', 'items', 'payment'])
            ->latest('created_at');

        // Search by order number or customer
        if ($search) {
            $ordersQuery->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by order status
        if ($status) {
            $ordersQuery->where('status', $status);
        }

        // Filter by payment status
        if ($paymentStatus) {
            $ordersQuery->where('payment_status', $paymentStatus);
        }

        // Date filters
        if ($dateFilter === 'today') {
            $ordersQuery->whereDate('created_at', now()->toDateString());
        } elseif ($dateFilter === 'last_7_days') {
            $ordersQuery->whereBetween('created_at', [now()->subDays(7), now()]);
        } elseif ($dateFilter === 'last_30_days') {
            $ordersQuery->whereBetween('created_at', [now()->subDays(30), now()]);
        }

        $orders = $ordersQuery->paginate(15)->withQueryString();

        // === DASHBOARD STATS ===
        $totalOrders = Transaction::count();

        $pendingValidationCount = Payment::where('method', 'gcash')
            ->where('status', 'pending')
            ->count();

        $monthlyRevenue = Transaction::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('grand_total');

        // For now, treat "ready for pickup" as status = 'paid'
        $readyForPickupCount = Transaction::where('status', 'paid')->count();



        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingValidationCount',
            'monthlyRevenue',
            'readyForPickupCount'
        ));
    }

    public function pending(Request $request)
    {
        $orders = Transaction::with(['user:id,username,email', 'items', 'payment'])
            ->where('status', 'pending')
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.pending-orders', compact('orders'));
    }

    public function completed(Request $request)
    {
        $orders = Transaction::with(['user:id,username,email', 'items', 'payment'])
            ->where(function ($q) {
                $q->where('status', 'paid')
                    ->orWhere('status', 'completed');
            })
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.completed-orders', compact('orders'));
    }

    public function create()
    {
        $walkInUserId = null;

        $products = Product::select('id', 'name', 'price', 'unit', 'stock', 'image_url')
            ->where('is_active', 1)
            ->orderBy('name')
            ->get()
            ->map(function ($p) {
                $p->image_url = $p->image_url
                    ? \Illuminate\Support\Facades\Storage::url($p->image_url)
                    : null;
                return $p;
            });

        $registeredCustomers = User::where('role', 'customer')
            ->orderBy('fname')
            ->get(['id', 'fname', 'lname', 'email']);

        return view('admin.orders.form', [
            'walkInUserId'        => $walkInUserId,
            'products'            => $products,
            'registeredCustomers' => $registeredCustomers,
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'            => ['nullable', 'integer', 'exists:users,id'],
            'subtotal'           => ['required', 'numeric', 'min:0'],
            'grand_total'        => ['required', 'numeric', 'min:0'],
            'payment.method'     => ['required', Rule::in(['cash', 'gcash'])],
            'items'              => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity'   => ['required', 'integer', 'min:1'],
        ]);

        return DB::transaction(function () use ($data) {
            $itemsInput     = $data['items'];
            $recalcSubtotal = 0;
            $lineItems      = [];

            foreach ($itemsInput as $row) {
                /** @var Product $p */
                $p = Product::lockForUpdate()->findOrFail($row['product_id']);

                if ($p->stock < $row['quantity']) {
                    abort(422, "Insufficient stock for {$p->name} (available: {$p->stock}).");
                }

                $unitPrice = (float) $p->price;
                $qty       = (int) $row['quantity'];
                $lineTotal = $unitPrice * $qty;

                $recalcSubtotal += $lineTotal;

                $lineItems[] = [
                    'product_id'   => $p->id,
                    'product_name' => $p->name,
                    'unit'         => $p->unit,
                    'unit_price'   => $unitPrice,
                    'quantity'     => $qty,
                    'line_total'   => $lineTotal,
                ];
            }

            $grand = $recalcSubtotal;


            $order = new Transaction();
            $order->user_id        = $data['user_id'] ?? null;
            $order->order_number   = $this->generateOrderNo();
            $order->subtotal       = $recalcSubtotal;
            $order->grand_total    = $grand;
            $order->status         = 'pending';
            $order->payment_status = 'unpaid';
            $order->save();

            // 🔔 collect admins once for notifications
            $admins = User::where('role', 'admin')->get();

            // Items + stock decrement + low-stock notifications
            foreach ($lineItems as $li) {
                TransactionItem::create([
                    'transaction_id' => $order->id,
                    'product_id'     => $li['product_id'],
                    'product_name'   => $li['product_name'],
                    'unit'           => $li['unit'],
                    'unit_price'     => $li['unit_price'],
                    'quantity'       => $li['quantity'],
                    'line_total'     => $li['line_total'],
                ]);

                // Decrement stock & handle low stock notification
                $product = Product::lockForUpdate()->find($li['product_id']);
                if ($product) {
                    $product->stock = max(0, $product->stock - $li['quantity']);

                    // Auto-inactivate if stock is now 0
                    if ($product->stock <= 0) {
                        $product->is_active = false;
                    }

                    $product->save();

                    // 🔔 LOW STOCK NOTIFICATION (threshold = 5)
                    if ($product->stock <= 5 && $admins->isNotEmpty()) {
                        Notification::send($admins, new LowStockNotification($product));
                    }
                }
            }

            // Payment row
            $method = $data['payment']['method'];

            $payment = new Payment();
            $payment->transaction_id = $order->id;
            $payment->method         = $method;
            $payment->amount         = $grand;

            if ($method === 'cash') {
                $payment->status       = 'accepted';
                $order->status         = 'completed';
                $order->payment_status = 'accepted';
                $order->save();
            } else {
                // GCash → pending validation
                $payment->status = 'pending';

                // 🔔 NEW PENDING GCASH PAYMENT – notify admins
                if ($admins->isNotEmpty()) {
                    Notification::send($admins, new GcashPaymentPendingNotification($order));
                }
            }

            $payment->save();

            return redirect()
                ->route('admin.orders.index')
                ->with('ok', "Transaction #{$order->order_number} created.");
        });
    }

    /**
     * SHOW – Single transaction details
     */
    public function show(Transaction $order)
    {
        $order->load(['items', 'payment', 'user']);

        return view('admin.orders.show', compact('order'));
    }

    public function edit(Transaction $order)
    {
        $order->load(['items', 'payment', 'user']);

        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Transaction $order)
    {
        $data = $request->validate([
            'status'         => ['required', Rule::in(['pending', 'paid', 'cancelled', 'refunded'])],
            'payment_status' => ['required', Rule::in(['unpaid', 'paid', 'refunded'])],
        ]);

        $order->update($data);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('ok', 'Transaction updated.');
    }

    public function destroy(Transaction $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('ok', 'Transaction deleted.');
    }

    public function markPaidCash(Transaction $order)
    {
        DB::transaction(function () use ($order) {
            $payment = $order->payment;

            if (!$payment) {
                $payment = new Payment();
                $payment->transaction_id = $order->id;
                $payment->method = 'cash';
                $payment->amount = $order->grand_total;
            }

            $payment->method = 'cash';
            $payment->status = 'accepted';
            $payment->save();

            $order->status         = 'paid';
            $order->payment_status = 'paid';
            $order->save();
        });

        return back()->with('ok', "Transaction #{$order->order_number} marked as paid (cash).");
    }

    public function acceptPayment(Transaction $order)
    {
        DB::transaction(function () use ($order) {
            $payment = $order->payment;

            if (!$payment) {
                return;
            }

            $payment->status = 'accepted';
            $payment->save();

            $order->status         = 'completed';
            $order->payment_status = 'paid';
            $order->save();
        });

        return back()->with('ok', "GCash payment for #{$order->order_number} accepted.");
    }

    public function rejectPayment(Transaction $order, Request $request)
    {
        $reason = $request->input('reason', 'Payment rejected');

        DB::transaction(function () use ($order, $reason) {
            $payment = $order->payment;

            if ($payment) {
                $payment->status  = 'rejected';
                $payment->save();
            }

            $order->payment_status = 'unpaid';
            $order->status         = 'cancelled';
            $order->save();
        });

        return back()->with('ok', "GCash payment for #{$order->order_number} rejected.");
    }

    public function cancel(Transaction $order, Request $request)
    {
        $reason = $request->input('reason');

        DB::transaction(function () use ($order, $reason) {

            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += (int) $item->quantity;

                    if ($product->stock > 0 && !$product->is_active) {
                        $product->is_active = true;
                    }
                    $product->save();
                }
            }

            $order->status = 'cancelled';
            $order->save();

            if ($order->payment) {
                $order->payment->status = 'voided';
                $order->payment->save();
            }
        });

        return back()->with('ok', "Transaction #{$order->order_number} cancelled.");
    }

    protected function generateOrderNo(): string
    {
        do {
            $candidate = 'POS-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (Transaction::where('order_number', $candidate)->exists());

        return $candidate;
    }
}
