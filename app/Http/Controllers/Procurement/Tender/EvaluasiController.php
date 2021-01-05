<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\Evaluasis;
use App\Models\Procurement\EvaluasiAdministrasi;
use App\Models\Procurement\EvaluasiKualifikasi;
use App\Models\Procurement\EvaluasiTeknis;
use App\Models\Procurement\EvaluasiHarga;
use App\Models\Procurement\EvaluasiPenilaian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class EvaluasiController extends Controller
{
    const Administrasi = 1;
    const Kualifikasi = 2;
    const Teknis = 3;
    const Harga = 4;

    public function index(){}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function proses($paket_id, $rekanan_id, $is_tender)
    {
        $paket      = \App\Models\Procurement\Pakets::find($paket_id);
        $rekanan    = \App\Models\Procurement\Rekanans::find($rekanan_id);
        $paketDok   = \App\Models\Procurement\PaketDokumenPenawarans::where('paket_id', $paket_id)
                    ->join('mt_dokumen_penawaran','mt_dokumen_penawaran.id','=','e_paket_dokumen_penawaran.mt_dokumen_penawaran_id')
                    ->get();
                    
        $paketKualifikasi = \App\Models\Procurement\PaketLembarKualifikasi::where('paket_id', $paket_id)
                    ->join('mt_kualifikasi','mt_kualifikasi.id','=','e_paket_kualifikasi.mt_kualifikasi_id')
                    ->get();


        if( $is_tender ) {
            return view('procurement.evaluasi.tender.proses',compact('paket','rekanan','paketDok','paketKualifikasi','is_tender'))->withTitle('Evaluasi');
        } else {
            return view('procurement.evaluasi.nontender.proses',compact('paket','rekanan','paketDok','paketKualifikasi','is_tender'))->withTitle('Evaluasi');
        }
    }

    /**
     * Store data.
     * @param $request
     * @author didi gantengs
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            
            if( $request->has('is_doc_type') == Self::Kualifikasi ) {
                foreach( $request->mt_kualifikasi_id as $key => $value ) {
                    \App\Models\Procurement\EvaluasiKualifikasi::create([
                        'paket_id' => $request->paket_id,
                        'mt_rekanan_id' => $request->rekanan_id,
                        'mt_kualifikasi_id' => $value,
                        'memenuhi'  => $request->memenuhi_kualifikasi,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }

                //kualifikasi
                EvaluasiPenilaian::create([
                    'is_lulus' => $request->is_lulus_kualifikasi,
                    'is_doc_type' => Self::Kualifikasi,
                    'alasan_tidak_lulus' => $request->alasan_tidak_lulus_kualifikasi ?? '',
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);    
            }

            if( $request->has('is_doc_type') == Self::Administrasi ) {
                foreach( $request->mt_kualifikasi_id as $key => $value ) {
                    \App\Models\Procurement\EvaluasiKualifikasi::create([
                        'paket_id' => $request->paket_id,
                        'mt_rekanan_id' => $request->rekanan_id,
                        'mt_kualifikasi_id' => $value,
                        'memenuhi'  => $request->memenuhi_dok_penawaran,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
                //adminstrasi
                EvaluasiPenilaian::create([
                    'is_lulus' => $request->is_lulus_administrasi,
                    'is_doc_type' => Self::Adminstrasi,
                    'alasan_tidak_lulus' => $request->alasan_tidak_lulus_administrasi ?? '',
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name
                ]);
                
            }

            if( $request->has('is_doc_type') == Self::Teknis ) {
                foreach( $request->mt_kualifikasi_id as $key => $value ) {
                    \App\Models\Procurement\EvaluasiKualifikasi::create([
                        'paket_id' => $request->paket_id,
                        'mt_rekanan_id' => $request->rekanan_id,
                        'mt_kualifikasi_id' => $value,
                        'memenuhi'  => $request->memenuhi_dok_penawaran,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }

                //teknis
                EvaluasiPenilaian::create([
                    'is_lulus' => $request->is_lulus_teknis,
                    'is_doc_type' => Self::Teknis,
                    'alasan_tidak_lulus' => $request->alasan_tidak_lulus_teknis ?? '',
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);
            }

            if( $request->has('is_doc_type') == Self::Harga ) {
                foreach( $request->mt_kualifikasi_id as $key => $value ) {
                    \App\Models\Procurement\EvaluasiKualifikasi::create([
                        'paket_id' => $request->paket_id,
                        'mt_rekanan_id' => $request->rekanan_id,
                        'mt_kualifikasi_id' => $value,
                        'memenuhi'  => $request->memenuhi_dok_penawaran,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
                
                //harga
                EvaluasiPenilaian::create([
                    'is_lulus' => $request->is_lulus_harga,
                    'is_doc_type' => Self::Harga,
                    'alasan_tidak_lulus' => $request->alasan_tidak_lulus_harga ?? '',
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);
            }
            
            
            //jka harga di koreksi . update ke table rekanan harga
            if( $request->has('harga_terekoreksi') ) {
                \App\Models\Procurement\RekananSubmitHargaPenawaran::where('paket_id',$request->paket_id)
                ->where('mt_rekanan_id', $request->rekanan_id)
                ->update([
                    'harga_terkoreksi' => $request->harga_terkoreksi
                ]);
            }
            \DB::commit();

            Alert::success('Data berhasil disimpan')->persistent('Ok');
            return redirect()->route('show-paket', ['data'=>Crypt::encrypt($request->paket_id)]); 
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }
}