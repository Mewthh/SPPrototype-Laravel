<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the SPP home page.
     */
    public function index(Request $request): View
    {
        return view('welcome');
    }
}
