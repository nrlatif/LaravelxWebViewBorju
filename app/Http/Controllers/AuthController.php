<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Show register page
     */
    public function showRegister()
    {
        return view('register');
    }

    /**
     * Show dashboard page (protected route)
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
