<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\Pakets;
use App\Models\Procurement\EkontrakSppbj; 
use App\Models\Procurement\EkontrakUndangan;
use App\Models\Procurement\Ekontrak;
use App\Models\Procurement\EkontrakSskk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class PembayaranController extends Controller
{
    function createPembayaran($paket_id)
    {
    	$paket = Pakets::find(Crypt::decryprt($paket_id));
    	return view('procurement.pembayaran.create',compact('paket'));
    }
}
