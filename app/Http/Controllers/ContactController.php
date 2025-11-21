<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Front/Contact/Index');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject'   => 'required',
            'message' => 'required|string|min:5',
        ]);

        // Example sending email
        // Mail::to('admin@example.com')->send(new ContactMail($validated));
        

        return back()->with('success', 'Your message has been sent!');
    }
}
