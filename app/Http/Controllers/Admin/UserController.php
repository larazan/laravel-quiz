<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $users = User::when($request->q, function($query, $q){
            $query->where('first_name', 'like', '%'.$q.'%')
            ->orWhere('last_name', 'like', '%'.$q.'%');
        })
        // ->when(request('sort'), function ($q) {
        //     $direction = request('direction', 'asc');
        //     $q->orderBy(request('sort'), $direction);
        // })
        ->paginate(5)
        ->withQueryString();

        return Inertia::render('Admin/User/Index', [
            'menuTasks' => 'active',
            'users' => $users,
            'search' => $request->only('q'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'username' => 'required',
            'email' => 'required',
        ]);

        $user = User::find($id);

        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->username = $request->username;
        $user->email = $request->email;

        $user->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
