<?php

namespace App\Http\Controllers\Webprofile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\InseoHelper;
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
        $setting = InseoHelper::setting();
        // dd($setting);
        return view('webprofile.home');
    }
}
