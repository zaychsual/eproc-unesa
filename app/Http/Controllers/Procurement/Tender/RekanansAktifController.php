<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\Rekanans;
use App\Models\Webprofile\BentukUsahas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class RekanansAktifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Rekanans::orderBy('mt_jenis_pengadaan_id', 'ASC')->where('is_active','1') ->get();
        
        return view('procurement.rekananaktif.index', compact('data'))->withTitle('Penyedia (Aktif)');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
