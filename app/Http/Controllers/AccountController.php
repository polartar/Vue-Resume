<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function logout()
    {
        auth()->logout();

        return redirect()->route('login')->with('flash_message_success', "You've been logged out!");
    }
}
