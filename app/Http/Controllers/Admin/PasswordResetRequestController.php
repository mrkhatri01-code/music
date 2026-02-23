<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordResetRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $requests = \App\Models\PasswordResetRequest::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.password_requests.index', compact('requests'));
    }

    public function resolve($id)
    {
        $request = \App\Models\PasswordResetRequest::findOrFail($id);
        $request->update(['status' => 'resolved']);
        return back()->with('success', 'Request marked as resolved.');
    }

    public function destroy($id)
    {
        $request = \App\Models\PasswordResetRequest::findOrFail($id);
        $request->delete();
        return back()->with('success', 'Request deleted successfully.');
    }
}
