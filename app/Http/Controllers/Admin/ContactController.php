<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'read', 'replied'])) {
            $query->where('status', $request->status);
        }

        $contacts = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,read,replied',
        ]);

        $contact->update($validated);

        return back()->with('success', 'Contact status updated successfully!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Contact deleted successfully!');
    }
}
