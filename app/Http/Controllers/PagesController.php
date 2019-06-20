<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function Index ()
    {
        if (Auth::check())
        {
            return redirect('dashboard');
        } else {
            return view('pages.index');
        }
    }

    public function Dashboard ()
    {
        return view('pages.dashboard');
    }
}
