<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\LoyaltyService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Transaction::query()
            ->with(['user:id,username', 'payment'])
            ->latest('created_at');

        if ($s = $request->string('s')->trim()->value()) {
            $q->where(function ($qq) use ($s) {
                $qq->where('order_number', 'like', "%{$s}%")
                ->orWhereHas('user', fn ($u) => $u->where('username', 'like', "%{$s}%"));
            });
        }

        if ($status = $request->get('status')) {
            $q->where('status', $status);
        }

        if ($pay = $request->get('payment_status')) {
            $q->where('payment_status', $pay);
        }

        $orders = $q->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $order = new Transaction();
        $customers = User::where('role', 'customer')
            ->orderBy('username')
            ->get(['id','username','fname','lname']);

        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get(['id','name','unit','price','image_url']);

        return view('admin.orders.form', compact('order','customers','products'));
    }

    public function show(Transaction $order)
    {
        $order->load(['user','items.product','payment']);

        $customers = User::where('role', 'customer')
            ->orderBy('username')
            ->get(['id','username','fname','lname']);

        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get(['id','name','unit','price','image_url']);

        return view('admin.orders.form', compact('order','customers','products'));
    }

    public function edit(Transaction $order)
    {
        return $this->show($order);
    }

    public function store(Request $request, LoyaltyService $loyalty)
    {
        $data = $request->validate([
            'user_id'                 => ['required','exists:users,id'],
            'items'                   => ['required','array','min:1'],
            'items.*.product_id'      => ['required','exists:products,id'],
            'items.*.quantity'        => ['required','integer','min:1'],
            'items.*.unit_price'      => ['required','numeric','min:0'],
            'items.*.unit'            => ['required','string','max:50'],

            'payment.method'          => ['nullable', Rule::in(['cash','gcash'])],
            'payment.amount'          => ['nullable','numeric','min:0'],
            'payment.provider_ref'    => ['nullable','string','max:100'],
            'payment.receipt_image'   => ['nullable','image','max:4096'],
            'mark_paid_now'           => ['nullable','boolean'],
            'notes'                   => ['nullable','string','max:500'],
        ]);

        $isCustomer = User::whereKey($data['user_id'])->where('role','customer')->exists();
        abort_unless($isCustomer, 422, 'Selected user is not a customer.');

        $subtotal = 0.0;
        $lineItems = [];

        foreach ($data['items'] as $row) {
            $qty   = (int) $row['quantity'];
            $price = round((float) $row['unit_price'], 2);
            $total = round($qty * $price, 2);
            $subtotal += $total;

            $product = Product::findOrFail($row['product_id']);
            $lineItems[] = [
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'unit'         => $row['unit'],
                'unit_price'   => $price,
                'quantity'     => $qty,
                'line_total'   => $total,
            ];
        }

        $subtotal = round($subtotal, 2);
        $grand    = $subtotal;

        DB::transaction(function () use ($request, $data, $lineItems, $subtotal, $grand, $loyalty) {
            $order = Transaction::create([
                'user_id'        => $data['user_id'],
                'cart_id'        => null,
                'order_number'   => $this->generateOrderNumber(),
                'subtotal'       => $subtotal,
                'grand_total'    => $grand,
                'status'         => 'pending',
                'payment_status' => 'unpaid',
                'notes'          => $data['notes'] ?? null,
            ]);

            $order->items()->createMany($lineItems);

            $pm = $data['payment']['method'] ?? null;
            if ($pm) {
                $amount = (array_key_exists('payment', $data) && array_key_exists('amount', $data['payment']))
                    ? (float) $data['payment']['amount']
                    : $grand;

                $status = $pm === 'cash'
                    ? ($request->boolean('mark_paid_now') ? 'accepted' : 'pending')
                    : 'pending';

                $receiptUrl = null;
                if ($pm === 'gcash' && $request->file('payment.receipt_image')) {
                    $path = $request->file('payment.receipt_image')->store('receipts', 'public');
                    $receiptUrl = Storage::disk('public')->url($path);
                }

                $order->payment()->create([
                    'method'            => $pm,
                    'amount'            => $amount,
                    'status'            => $status,
                    'provider_ref'      => $data['payment']['provider_ref'] ?? null,
                    'receipt_image_url' => $receiptUrl,
                ]);

                if ($pm === 'cash' && $status === 'accepted') {
                    $order->update(['status' => 'paid', 'payment_status' => 'paid']);
                    $loyalty->awardIfEligible($order);
                }
            }

            session()->flash('ok', 'Order created.');
            session()->flash('order_number', $order->order_number);
        });

        return redirect()->route('admin.orders.index');
    }

    public function update(Request $request, Transaction $order, LoyaltyService $loyalty)
    {
        abort_unless(in_array($order->status, ['pending']), 403, 'Only pending orders can be updated.');

        $data = $request->validate([
            'user_id'                 => ['required','exists:users,id'],
            'items'                   => ['required','array','min:1'],
            'items.*.product_id'      => ['required','exists:products,id'],
            'items.*.quantity'        => ['required','integer','min:1'],
            'items.*.unit_price'      => ['required','numeric','min:0'],
            'items.*.unit'            => ['required','string','max:50'],
            'payment.method'          => ['nullable', Rule::in(['cash','gcash'])],
            'payment.amount'          => ['nullable','numeric','min:0'],
            'payment.provider_ref'    => ['nullable','string','max:100'],
            'payment.receipt_image'   => ['nullable','image','max:4096'],
            'mark_paid_now'           => ['nullable','boolean'],
            'notes'                   => ['nullable','string','max:500'],
        ]);

        $isCustomer = User::whereKey($data['user_id'])->where('role','customer')->exists();
        abort_unless($isCustomer, 422, 'Selected user is not a customer.');

        $subtotal = 0.0;
        $lineItems = [];
        foreach ($data['items'] as $row) {
            $qty   = (int) $row['quantity'];
            $price = round((float) $row['unit_price'], 2);
            $total = round($qty * $price, 2);
            $subtotal += $total;

            $product = Product::findOrFail($row['product_id']);
            $lineItems[] = [
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'unit'         => $row['unit'],
                'unit_price'   => $price,
                'quantity'     => $qty,
                'line_total'   => $total,
            ];
        }
        $subtotal = round($subtotal, 2);
        $grand    = $subtotal;

        DB::transaction(function () use ($request, $data, $lineItems, $subtotal, $grand, $loyalty, $order) {

            $order->update([
                'user_id'     => $data['user_id'],
                'subtotal'    => $subtotal,
                'grand_total' => $grand,
                'notes'       => $data['notes'] ?? null,
            ]);

            $order->items()->delete();
            $order->items()->createMany($lineItems);

            $pm         = $data['payment']['method'] ?? null;
            $oldPayment = $order->payment; 
            $shouldBePaid = false;

            if ($pm) {
                $amount = (array_key_exists('payment', $data) && array_key_exists('amount', $data['payment']))
                    ? (float) $data['payment']['amount']
                    : $grand;

                $newPaymentStatus = 'pending';
                if ($pm === 'cash' && $request->boolean('mark_paid_now')) {
                    $newPaymentStatus = 'accepted';
                    $shouldBePaid = true;
                } elseif ($pm === 'gcash' && $oldPayment && $oldPayment->method === 'gcash') {
                    $newPaymentStatus = $oldPayment->status;
                    $shouldBePaid = $newPaymentStatus === 'accepted';
                }

                $receiptUrl = $oldPayment?->receipt_image_url ?? null;

                if ($pm === 'gcash' && $request->file('payment.receipt_image')) {
                    if ($oldPayment?->receipt_image_url) {
                        $path = Str::after(parse_url($oldPayment->receipt_image_url, PHP_URL_PATH), '/storage/');
                        if ($path) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                    $path = $request->file('payment.receipt_image')->store('receipts', 'public');
                    $receiptUrl = Storage::disk('public')->url($path);
                }

                $order->payment()->updateOrCreate([], [
                    'method'            => $pm,
                    'amount'            => $amount,
                    'status'            => $newPaymentStatus,
                    'provider_ref'      => $data['payment']['provider_ref'] ?? null,
                    'receipt_image_url' => $receiptUrl,
                ]);
            } else {
                if ($order->payment) {
                    if ($order->payment->receipt_image_url) {
                        $path = Str::after(parse_url($order->payment->receipt_image_url, PHP_URL_PATH), '/storage/');
                        if ($path) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                }
                $order->payment()->delete();
            }

            $order->update([
                'status'          => $shouldBePaid ? 'paid' : 'pending',
                'payment_status'  => $shouldBePaid ? 'paid' : 'unpaid',
            ]);

            if ($shouldBePaid) {
                $loyalty->awardIfEligible($order);
            }
        });

        return redirect()->route('admin.orders.show', $order)->with('ok', 'Order updated successfully.');
    }

    public function markPaidCash(Transaction $order, LoyaltyService $loyalty)
    {
        abort_unless($order->payment_status === 'unpaid', 403);

        $order->update([
            'status'          => 'paid',
            'payment_status'  => 'paid',
        ]);

        $order->payment()->updateOrCreate([], [
            'method'       => 'cash',
            'amount'       => $order->grand_total,
            'status'       => 'accepted',
            'provider_ref' => null,
        ]);

        $loyalty->awardIfEligible($order);

        return back()->with('ok', 'Order marked as paid (cash).');
    }

    public function acceptPayment(Transaction $order, LoyaltyService $loyalty)
    {
        $payment = $order->payment;
        abort_unless($payment && $payment->method === 'gcash' && $payment->status === 'pending', 403);

        $payment->update(['status' => 'accepted']);
        $order->update(['status' => 'paid', 'payment_status' => 'paid']);

        $loyalty->awardIfEligible($order);

        return back()->with('ok', 'GCash payment accepted.');
    }

    public function rejectPayment(Transaction $order)
    {
        $payment = $order->payment;
        abort_unless($payment && $payment->method === 'gcash' && $payment->status === 'pending', 403);

        $payment->update(['status' => 'rejected']);
        $order->update(['status' => 'pending', 'payment_status' => 'unpaid']);

        return back()->with('ok', 'GCash payment rejected.');
    }

    public function cancel(Transaction $order)
    {
        abort_unless($order->status === 'pending', 403);

        $order->update(['status' => 'cancelled']);
        return back()->with('ok', 'Order cancelled.');
    }

    protected function generateOrderNumber(): string
    {
        return 'PV-' . now()->format('Ymd-His') . '-' . random_int(100, 999);
    }
}
