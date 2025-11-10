<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TypeController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        $types = Type::when($request->q, function($query, $q){
            $query->where('name', 'like', '%'.$q.'%');
        })
        // ->when(request('sort'), function ($q) {
        //     $direction = request('direction', 'asc');
        //     $q->orderBy(request('sort'), $direction);
        // })
        ->paginate(5)
        ->withQueryString();

        return Inertia::render('Admin/Type/Index', [
            'menuTasks' => 'active',
            'types' => $types,
            'search' => $request->only('q'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
        ]);

        $name = $request->firstName;
        Type::create([
            'name' => $name,
        ]);

        return redirect()->route('admin.type.index')->with('success', 'Type created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
        ]);

        $type = Type::find($id);

        $type->name = $request->name;

        $type->update();
        return redirect()->route('admin.type.index')->with('success', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $type = Type::find($id);
        $type->delete();
        return redirect()->back()->with('success', 'Type deleted successfully.');
    }

    public function toggle(Type $type, Request $request)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $type->update(['is_active' => $request->is_active]);

        return back()->with('success', 'Type status updated successfully!');
    }
}
