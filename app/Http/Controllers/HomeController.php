<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        return view('home', compact('profile'));
    }
} 