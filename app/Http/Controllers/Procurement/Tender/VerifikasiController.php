<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\Verifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class VerifikasiController extends Controller
{
    
    public function index()
    {
        // return view('procurement.tender.penawaran.input-penawaran', compact('paket','paketHps'))->withTitle('input penawaran Paket');
    }

    /**
     * proses verifikasi , display ui
     * @author didi gantengs
     * @param string $paket_id
     * @param string $rekanan_id
     */
    public function proses($paket_id, $rekanan_id)
    {
        $paket = \App\Models\Procurement\Pakets::find($paket_id);
        $rekanan = \App\Models\Procurement\Rekanans::find($rekanan_id);

        return view('procurement.verifikasi.proses', compact('paket','rekanan'))->withTitle('input verifikasi');
    }

    public function store(Request $request)
    {
        $request['userid_created'] = Auth::user()->name;
        $request['userid_updated'] = Auth::user()->name;

        Verifikasi::create($request->all());

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        // dd($request);
        return redirect()->route('show-paket',Crypt::encrypt($request->paket_id));
    }
}