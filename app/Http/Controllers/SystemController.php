<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{
    //
    public function isAuthenticated()
    {
        return Auth::check() ? response()->json(['status' => 'authenticated']) : response()->redirectTo('/login');
    }
}
