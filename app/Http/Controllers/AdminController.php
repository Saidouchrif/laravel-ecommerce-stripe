<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check if the user is the admin
        if ($user && $user->email === 'saidouchrif16@gmail.com') {
            return view('admin.index');
        }
        
        // Redirect to home if not authorized
        return redirect('/')->with('error', 'Access denied.');
    }
}
