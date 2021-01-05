<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'admin') {
            return view('dashboard');
        }elseif (Auth::user()->role == 'laman') {
            return view('home');
        }elseif (Auth::user()->role == 'verifikator') {
            return view('beranda');
        }
        //return view('home');
    }
}
