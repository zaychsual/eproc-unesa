<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\WebProfile\Rekanans;
use App\Models\Webprofile\BentukUsahas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class RekanansNonAktifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Rekanans::orderBy('mt_jenis_pengadaan_id', 'ASC')->where('userid_verifikasi',NULL) ->get();

        return view('procurement.rekanannonaktif.index', compact('data'))->withTitle('Penyedia (Non Aktif)');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
