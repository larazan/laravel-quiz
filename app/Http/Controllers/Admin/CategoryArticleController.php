<?php

namespace App\Http\Controllers\Admin;

use App\Models\CategoryArticle as Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryArticleController extends Controller
{
    //
    public function index(Request $request)
    {
        $categories = Category::when($request->q, function($query, $q){
            $query->where('name', 'like', '%'.$q.'%');
        })
        // ->when(request('sort'), function ($q) {
        //     $direction = request('direction', 'asc');
        //     $q->orderBy(request('sort'), $direction);
        // })
        ->paginate(5)
        ->withQueryString();

        $catParent = Category::whereNull('parent_id')->get();

        return Inertia::render('Admin/Category/Index', [
            'menuTasks' => 'active',
            'categories' => $categories,
            'parentOption' => $catParent,
            'search' => $request->only('q'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $name = $request->firstName;
        $parentId = $request->parentId;
        $status = $request->status;

        Category::create([
            'name' => $name,
            'parent_id' => $parentId,
            'status' => $status,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->parentId = $request->parent_id;
        $category->status = $request->status;

        $category->update();
        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        //
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
