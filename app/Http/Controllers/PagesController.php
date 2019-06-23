<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function Index ()
    {
        if (!Auth::guest())
        {
            return redirect('dashboard');
        }
        return view('pages.index');

    }

    public function Dashboard ()
    {   
        if (Auth::guest())
        {
            return redirect('/');
        }
        return view('pages.dashboard');  
    }
}
