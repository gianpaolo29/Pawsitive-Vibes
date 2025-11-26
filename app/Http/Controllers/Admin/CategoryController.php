<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $req)
    {
        $q = $req->string('q')->toString();

        $categories = Category::query()
            ->withCount('products')
            ->when($q, fn($qr) => $qr->where('name', 'like', "%{$q}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', [
            'categories' => $categories,
            'q'          => $q
        ]);
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'name' => ['required', 'string', 'max:150', 'unique:categories,name'],
        ]);

        Category::create($validated);

        return back()->with('success', 'Category created successfully!');
    }

    public function update(Request $req, Category $category)
    {
        $validated = $req->validate([
            'name' => ['required', 'string', 'max:150', 'unique:categories,name,' . $category->id],
        ]);

        $category->update($validated);

        return back()->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Cannot delete: category still has products assigned.');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
}
