<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    //
    public function index(Request $request)
    {
        $contacts = Contact::when($request->q, function($query, $q){
            $query->where('name', 'like', '%'.$q.'%');
        })
        // ->when(request('sort'), function ($q) {
        //     $direction = request('direction', 'asc');
        //     $q->orderBy(request('sort'), $direction);
        // })
        ->paginate(5)
        ->withQueryString();

        return Inertia::render('Admin/Contact/Index', [
            'menuTasks' => 'active',
            'contacts' => $contacts,
            'search' => $request->only('q'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $message = $request->message;

        Contact::create([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ]);

        return redirect()->route('admin.contact.index')->with('success', 'Contact created successfully.');
    }

    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $contact = Contact::find($id);

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;

        $contact->update();
        return redirect()->route('admin.contact.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(string $id)
    {
        //
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->back()->with('success', 'Contact deleted successfully.');
    }
}
