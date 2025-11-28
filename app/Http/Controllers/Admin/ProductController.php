<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected int $lowStock = 10;

    /**
     * Check if a product is involved in any transactions (e.g., order items).
     * You MUST ensure the Product model has the appropriate relationship (e.g., 'orderItems').
     */
    protected function productHasTransactions(Product $product): bool
    {
        // 🚨 IMPORTANT: Replace 'orderItems' with the actual name of your relationship
        // e.g., if Product hasMany OrderItem, use $product->orderItems()->exists();
        // If the relationship is not defined, this will fail.
        return $product->orderItems()->exists(); 
    }

    public function index(Request $req)
    {
        $q           = $req->string('q')->toString();
        $category_id = $req->integer('category_id');
        $status      = $req->string('status')->toString();
        $stockStatus = $req->string('stock_status')->toString();

        // --- Stats ---
        $stats = [
            'total_products'  => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'low_stock'       => Product::where('stock', '>', 0)
                                         ->where('stock', '<', $this->lowStock)
                                         ->count(),
            'categories'      => Category::count(),
        ];

        // --- Sorting ---
        $sort = $req->get('sort', 'name');
        $dir  = $req->get('dir') === 'desc' ? 'desc' : 'asc';

        if (!in_array($sort, ['name','price','stock','is_active'])) {
            $sort = 'name';
        }

        // --- Query ---
        $products = Product::query()
            ->with('category:id,name')
            ->when($q, function ($qr) use ($q) {
                $qr->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->when($category_id, fn($qr) => $qr->where('category_id', $category_id))
            ->when($status === 'active', fn($qr) => $qr->where('is_active', true))
            ->when($status === 'inactive', fn($qr) => $qr->where('is_active', false))
            ->when($stockStatus === 'out', fn($qr) => $qr->where('stock', 0))
            ->when($stockStatus === 'low', fn($qr) => $qr->whereBetween('stock', [1, $this->lowStock - 1]))
            ->when($stockStatus === 'normal', fn($qr) => $qr->where('stock', '>=', $this->lowStock))
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('admin.products.index', [
        'products'     => $products,
        'categories'   => $categories,
        'q'            => $q,
        'category_id'  => $category_id,
        'status'       => $status,
        'stockStatus'  => $stockStatus,
        'sort'         => $sort,
        'dir'          => $dir,
        'stats'        => $stats,
        'lowStock'     => $this->lowStock,
    ]);

    }

    public function create()
    {
        $product = new Product([
            'is_active' => true,
            'stock'     => 0,
            'unit'      => 'pc'
        ]);

        $categories = Category::orderBy('name')->get(['id','name']);

        return view('admin.products.form', compact('product', 'categories'));
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'name'        => ['required','string','max:180'],
            'category_id' => ['required', Rule::exists('categories','id')],
            'description' => ['nullable','string'],
            'price'       => ['required','numeric','min:0'],
            'cost_price'  => ['required','numeric','min:0'],
            'unit'        => ['required','string','max:30'],
            'stock'       => ['required','integer','min:0'],
            'is_active'   => ['boolean'],
            'image'       => ['nullable','image','max:2048'],
        ]);

        if ($req->hasFile('image')) {
            $data['image_url'] = $req->file('image')->store('products', 'public');
        }

        // Disable active status if no stock
        $data['is_active'] = $data['stock'] > 0 ? ($data['is_active'] ?? false) : false;

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get(['id','name']);
        return view('admin.products.form', compact('product','categories'));
    }

    public function update(Request $req, Product $product)
    {
        $data = $req->validate([
            'name'        => ['required','string','max:180'],
            'category_id' => ['required', Rule::exists('categories','id')],
            'description' => ['nullable','string'],
            'price'       => ['required','numeric','min:0'],
            'cost_price'  => ['required','numeric','min:0'],
            'unit'        => ['required','string','max:30'],
            'stock'       => ['required','integer','min:0'],
            'is_active'   => ['boolean'],
            'image'       => ['nullable','image','max:2048'],
        ]);

        if ($req->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $data['image_url'] = $req->file('image')->store('products','public');
        }

        // Smart active toggle
        $data['is_active'] = $data['stock'] > 0 ? ($data['is_active'] ?? false) : false;

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Changes saved.');
    }

    /**
     * Delete the product with SweetAlert confirmation logic based on transactions.
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // 1. Check for transactions/relationships
        if ($this->productHasTransactions($product)) {
            // Cannot delete product with transactions. Redirect with SweetAlert error.
            return back()->with('error', 
                "Cannot delete product '{$product->name}'. It is linked to existing transactions/orders."
            );
        }
        
        // 2. No transactions, proceed with deletion
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        // SweetAlert success message
        return back()->with('ok', "Product '{$product->name}' deleted successfully.");
    }

    /**
     * Toggle the product's active status with SweetAlert confirmation.
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Product $product)
    {
        if (!$product->is_active && $product->stock <= 0) {
            // SweetAlert error message for validation failure
            return back()->with('error', 'Cannot activate: Please add stock first.');
        }

        $product->update([
            'is_active' => ! $product->is_active
        ]);

        $status = $product->is_active ? 'activated' : 'deactivated';

        // SweetAlert success message
        return back()->with('ok', "Product '{$product->name}' has been {$status}.");
    }
}