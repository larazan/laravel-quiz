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
            'catParent' => $catParent,
            'search' => $request->only('q'),
        ]);
    }

    public function store(Request $request)
    {
        //
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
    }

    public function destroy(string $id)
    {
        //
        $category = Category::find($id);
        $category->delete();
    }
}
