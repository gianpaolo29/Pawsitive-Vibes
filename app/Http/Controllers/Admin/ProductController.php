<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $req)
    {
        $q           = $req->string('q')->toString();
        $category_id = $req->integer('category_id');
        $status      = $req->string('status')->toString();
        $stock_status= $req->string('stock_status')->toString();

        $lowStock = 10;

        $stats = [
            'total_products'  => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'low_stock'       => Product::where('stock', '>', 0)
                                        ->where('stock', '<', $lowStock)
                                        ->count(),
            'categories'      => Category::count(),
        ];

        $sort = in_array($req->get('sort'), ['name','price','stock','is_active'])
            ? $req->get('sort')
            : 'name';

        $dir  = $req->get('dir') === 'desc' ? 'desc' : 'asc';

        $products = Product::query()
            ->with('category:id,name')
            ->when($q, fn($qr) => $qr->where(function($w) use ($q) {
                $w->where('name','like',"%{$q}%")
                ->orWhere('description','like',"%{$q}%");
            }))
            ->when($category_id, fn($qr) => $qr->where('category_id', $category_id))
            ->when($status === 'active', fn($qr) => $qr->where('is_active', true))
            ->when($status === 'inactive', fn($qr) => $qr->where('is_active', false))
            ->when($stock_status === 'out',    fn($qr) => $qr->where('stock', 0))
            ->when($stock_status === 'low',    fn($qr) => $qr->whereBetween('stock', [1, 9]))
            ->when($stock_status === 'normal', fn($qr) => $qr->where('stock', '>=', 10))
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get(['id','name']);

        return view('admin.products.index', compact(
            'products','categories','q','category_id','status','stock_status','sort','dir','stats','lowStock'
        ));
    }

    public function create()
    {
        $product    = new Product(['is_active' => true, 'stock' => 0, 'unit' => 'pc']);
        $categories = Category::orderBy('name')->get(['id','name']);

        return view('admin.products.form', compact('product','categories'));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'name'        => ['required','string','max:180'],
            'category_id' => ['required', Rule::exists('categories','id')],
            'description' => ['nullable','string'],
            'price'       => ['required','numeric','min:0','max:9999999.99'],
            'cost_price'  => ['required','numeric','min:0','max:9999999.99'],
            'unit'        => ['required','string','max:30'],
            'stock'       => ['required','integer','min:0'],
            'is_active'   => ['boolean'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        $path = null;
        if ($req->hasFile('image')) {
            $path = $req->file('image')->store('products', 'public');
        }

        $stock           = (int)($validated['stock'] ?? 0);
        $requestedActive = (bool)($validated['is_active'] ?? false);
        $isActive        = $stock > 0 ? $requestedActive : false;

        $product = Product::create([
            ...$validated,
            'image_url' => $path,
            'is_active' => $isActive,
        ]);

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
        $validated = $req->validate([
            'name'        => ['required','string','max:180'],
            'category_id' => ['required', Rule::exists('categories','id')],
            'description' => ['nullable','string'],
            'price'       => ['required','numeric','min:0','max:9999999.99'],
            'cost_price'  => ['required','numeric','min:0','max:9999999.99'],
            'unit'        => ['required','string','max:30'],
            'stock'       => ['required','integer','min:0'],
            'is_active'   => ['boolean'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        if ($req->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $product->image_url = $req->file('image')->store('products','public');
        }

        $stock           = (int)($validated['stock'] ?? 0);
        $requestedActive = (bool)($validated['is_active'] ?? false);
        $isActive        = $stock > 0 ? $requestedActive : false;

        $product->fill([
            ...$validated,
            'is_active' => $isActive,
        ])->save();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Changes saved.');
    }

    public function destroy(Product $product)
    {
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return back()->with('ok','Product deleted.');
    }

    public function toggle(Product $product)
    {
        if (!$product->is_active && $product->stock <= 0) {
            return back()->with('error', 'Please add stock first.');
        }

        $product->update([
            'is_active' => ! $product->is_active,
        ]);

        return back()->with('ok','Status updated.');
    }
}
