<?php

namespace App\Http\Controllers\Procurement\Tender;


use App\Models\Procurement\LogsApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = LogsApp::orderBy('created_at', 'desc')->get();

        return view('procurement.logbook.index', compact('data'))->withTitle('Logbook');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
