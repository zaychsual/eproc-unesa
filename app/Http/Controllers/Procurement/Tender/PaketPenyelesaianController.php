<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Rekanans;
use App\Models\Webprofile\BentukUsahas;
use App\Models\Webprofile\JenisPengadaans;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;
use Redirect;
use DB;
use Illuminate\Support\Facades\Hash;

use App\Repositories\ProvinsiRepository;
use App\Repositories\KotaRepository;
use App\Repositories\RekananRepository;
use App\Repositories\JenisPengadaanRepository;

class PaketPenyelesaianController extends Controller
{
    public function index()
    {

    }

    public function proses($paket_id)
    {
        $paket = \App\Models\Procurement\Pakets::find(Crypt::decrypt($paket_id));

        return view('procurement.pakets.beli-langsung.create', compact('paket'));
    }
}