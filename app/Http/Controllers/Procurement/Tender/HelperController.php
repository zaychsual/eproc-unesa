<?php

namespace App\Http\Controllers\Procurement\Tender;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Procurement\Rekanans;
use App\Models\Procurement\ValidasiPaket;

class HelperController extends Controller
{
    public function detailRekanan(Request $request)
    {
        $data = Rekanans::join('users', 'mt_rekanan.id', '=', 'users.mt_rekanan_id')
            ->select('mt_rekanan.kode', 'mt_rekanan.nama', 'users.email', 'mt_rekanan.npwp', 'mt_rekanan.telepon', 'mt_rekanan.hp', 'mt_rekanan.alamat')
            ->first();
        
        return \Response::json($data);
    }

    public function getPokja(Request $request)
    {
        // dd($request);
        $data = \App\User::where('role','pokja')
            ->where('id_jenis_pengadaan',$request->pengadaan_id)
            ->get();

        return \Response::json($data);
    }
    public function getPengendaliKualitas(Request $request)
    {
        // dd($request);
        $data = \App\User::where('role','pengendalikualitas')
            ->get();

        return \Response::json($data);
    }
    
    public function validasiPaket(Request $request)
    {
        $data = ValidasiPaket::where('category_id', $request->category_id)
                ->where('jenis_pengadaan_id', $request->jenis_pengadaan)
                ->select('nilai_hps')
                ->first();
        
        return \Response::json($data);
    }   
}
