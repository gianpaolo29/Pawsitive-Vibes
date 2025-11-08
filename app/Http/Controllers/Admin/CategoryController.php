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

        return view('admin.categories.index', compact('categories', 'q'));
    }

    public function create()
    {
        $category = new Category();
        return view('admin.categories.form', compact('category'));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'name' => ['required','string','max:150','unique:categories,name'],
        ]);

        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('ok','Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $req, Category $category)
    {
        $validated = $req->validate([
            'name' => ['required','string','max:150','unique:categories,name,'.$category->id],
        ]);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('ok','Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('err','Cannot delete: category still has products.');
        }

        $category->delete();
        return back()->with('ok','Category deleted.');
    }
}
