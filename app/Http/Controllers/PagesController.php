<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function Index ()
    {
        return view('pages.index');
    }

    public function Dashboard ()
    {
        return view('pages.dashboard');
    }
}
