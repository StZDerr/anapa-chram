<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        return view('about'); // view resources/views/about.blade.php
    }
}
