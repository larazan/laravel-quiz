<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request, User $user)
    {
        if ($user) {
            $articles = $user->latestArticles(3);

            return view('users.profile', compact('user', 'articles'));
        }

        if ($request->user()) {
            return redirect()->route('profile', $request->user()->username());
        }

        abort(404);
    }

   
}
