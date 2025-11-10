<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
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
        Category::create([
            'name' => $name,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::find($id);

        $category->name = $request->name;
        $category->parentId = $request->parent_id;

        $category->update();
        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        //
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
    
    public function toggle(Category $category, Request $request)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $category->update(['is_active' => $request->is_active]);

        return back()->with('success', 'Category status updated successfully!');
    }
}
