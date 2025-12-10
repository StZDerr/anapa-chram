<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function test()
    {
        return 'TEST WORKS! Auth: '.(auth()->check() ? 'YES' : 'NO');
    }
}
