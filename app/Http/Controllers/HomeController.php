<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if(is_null($user->profile)) {
            return redirect()->route('profile.create');
        }

        if ($user->hasRole('writer')) { 
            return view('dashboards.writer');
        }
        if ($user->hasRole('publisher')) { 
            return view('dashboards.publisher');
        }
        if ($user->hasRole('agent')) { 
            return view('dashboards.agent');
        }
        
        
    }
}
