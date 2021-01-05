<?php

namespace App\Http\Controllers\Procurement\Tender;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Procurement\Pakets;
use App\Models\Procurement\RekananSubmitHargaPenawaran;
use App\Models\Procurement\Einbox;
use App\Mail\InboxMail;
use Mail;
use Alert;
use Crypt;
use Auth;
use PDF;
use Terbilang;
class PengendaliKualitasController extends Controller
{
	//Pindah Ke PengendaliKulitasController
    public function storeDiteruskan(Request $request)
    {

        foreach ($request->pengendali_kualitas_id as $key => $value) {
            \DB::table('e_paket_diteruskan')->insert([
                'id'    => \Uuid::generate(),
                'paket_id' => $request->paket_id,
                'pengendali_kualitas_id' => $request->pengendali_kualitas_id[$key],
                'tanggal' => $request->tanggal,
                'userid_created' => Auth::user()->name,
                'userid_updated' => Auth::user()->name
            ]);
		$update = Pakets::find($request->paket_id);
		$update->status_paket = Pakets::StatusPaketSudahDiTeruskan;
		$update->save();

            //Email Ke Pengendali Kualitas
            $paket = \DB::table('e_paket')->select('e_paket.nama','users.id','users.email')->join('e_paket_diteruskan','e_paket_diteruskan.paket_id','=','e_paket.id')->join('users','e_paket_diteruskan.pengendali_kualitas_id','=','users.id')->where('e_paket_diteruskan.pengendali_kualitas_id','=',$request->pengendali_kualitas_id[$key])->where('e_paket.id','=',$request->paket_id)->first();
            $dataMail= array();
            $dataMail['title'] = 'Pemberitahuan Inbox Pengendali Kualitas'; 
            $dataMail['user'] = 'Pengendali Kualitas '.$paket->nama; 
            $dataMail['user_id'] = Auth::user()->id; 
            $dataMail['message'] = 'Mohon Lakukan Pemeriksaan '.$paket->nama.'.<br><br>Terima kasih';
            $dataMail['subject'] = 'Pemeriksaan '.$paket->nama;
            $dataMail['is_read'] = 0;
            $dataMail['user_to_id'] = $paket->id;
            Einbox::create($dataMail);
            Mail::to($paket->email)->send(new InboxMail($dataMail));
        }
        
        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect(\URL::to('home'));
    }
	public function createChecklist($paket_id)
    {
        $paket = \DB::table('e_rekanan_submit_harga_penawaran')
                ->select('e_rekanan_submit_harga_penawaran.id','e_paket_hps_detail.jenis_barang_jasa as pekerjaan','e_paket_hps_detail.qty','e_paket_hps_detail.satuan','e_rekanan_submit_harga_penawaran.paket_id','mt_rekanan.nama as nama_rekanan','e_rekanan_submit_harga_penawaran.is_check')->join('e_paket_hps_detail','e_paket_hps_detail.id','=','e_rekanan_submit_harga_penawaran.paket_hps_id')
                ->join('e_paket_rekanan','e_paket_rekanan.mt_rekanan_id','=','e_rekanan_submit_harga_penawaran.mt_rekanan_id')
                ->join('mt_rekanan','mt_rekanan.id','=','e_rekanan_submit_harga_penawaran.mt_rekanan_id')
                ->where('e_paket_rekanan.is_winner','=',1)
                ->where('e_rekanan_submit_harga_penawaran.paket_id','=',Crypt::decrypt($paket_id))
                ->get();
        
        // echo "<pre>";
        // print_r($paket);
        // print_r($dcrypt);
        // echo "</pre>";
        return view('procurement.tenders.checklist-bbapp',compact('paket','paket_id'))->withTitle('Checklist Barang');
    }

    
    public function storeChecklist(Request $request)
    {
    	foreach ($request->checklist as $key => $value) {
    		$paket = RekananSubmitHargaPenawaran::find($request->checklist[$key]);
    		$paket->is_check = 1;
    		$paket->save();
    		
        }

        $paketditeruskan = \DB::table('e_paket_diteruskan')
                        ->where('paket_id', $paket->paket_id)
                        ->update([
                            'status_paket' => $request->status_paket,
                            'notes' => $request->notes,
                            'userid_updated' => Auth::user()->name,
                        ]);
        $count = RekananSubmitHargaPenawaran::where('paket_id','=',$paket->paket_id);
		$data = $count->first();
		if (count($request->checklist) == $count->count()) {
		    $update = Pakets::find($data->paket_id);
		    $update->status_paket = $request->status_paket;
		    $update->save();
		}
    	$paket = \DB::table('e_paket')->select('e_paket.nama','users.id','users.email','users.name','e_paket_diteruskan.userid_created')->join('e_paket_diteruskan','e_paket_diteruskan.paket_id','=','e_paket.id')->join('users','e_paket_diteruskan.pengendali_kualitas_id','=','users.id')->where('e_paket.id','=',$data->paket_id)->first();
        $dataMail= array();
        $dataMail['title'] = 'Pemberitahuan Inbox PPK'; 
        $dataMail['user'] = @$paket->userid_created; 
        $dataMail['user_id'] = Auth::user()->id; 
        $dataMail['message'] = 'Paket '.$paket->nama.'. Telah di Periksa, Silakan masuk ke Website Simbajanesa<br><br>Terima kasih';
        $dataMail['subject'] = 'Hasil Pemeriksaan '.@$paket->nama.' Oleh '.@$paket->name;
        $dataMail['is_read'] = 0;
        $dataMail['user_to_id'] = @$paket->id;
        Einbox::create($dataMail);
        Mail::to(@$paket->email)->send(new InboxMail($dataMail));

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect(\URL::to('home'));
    }
    public function printeChecklist($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id))
                ->join('e_paket_lokasi', 'e_paket_lokasi.paket_id', '=', 'e_paket.id')
                ->join('mt_provinsi', 'e_paket_lokasi.provinsi_id', '=', 'mt_provinsi.id')
                ->join('mt_kota', 'e_paket_lokasi.kota_id', '=', 'mt_kota.id')
                ->join('e_satuankerja', 'e_paket.satuankerja_id', '=', 'e_satuankerja.id')
                ->join('e_klpd', 'e_paket.klpd_id', '=', 'e_klpd.id')
                ->leftJoin('e_paket_rekanan', 'e_paket.id', '=', 'e_paket_rekanan.paket_id')
                ->leftJoin('mt_rekanan', 'e_paket_rekanan.mt_rekanan_id', '=', 'mt_rekanan.id')
                ->leftJoin('e_kontrak_spk', 'e_kontrak_spk.paket_id', '=', 'e_paket.id')
                ->selectRaw('e_paket.nama , e_paket.kode_rup ,
                        e_paket.created_at, e_klpd.klpd ,
                        e_paket.id, e_paket_lokasi.alamat , 
                        mt_provinsi.nama as prov , mt_kota.nama as kota,
                        e_satuankerja.satuankerja, mt_rekanan.nama as pt, e_kontrak_spk.spk_no,
                        e_kontrak_spk.spk_tanggal_mulai_kerja , e_kontrak_spk.spk_wkt_penyelesaian,
                        e_kontrak_spk.spk_tanggal, e_kontrak_spk.spk_wkt_penyelesaian,
                        e_kontrak_spk.spk_tanggal_mulai_kerja'
                )
                ->where('e_paket_rekanan.is_winner', 1)
                ->first();
        
        $dt = \DB::table('e_rekanan_submit_harga_penawaran')
            ->select('e_rekanan_submit_harga_penawaran.id','e_paket_hps_detail.jenis_barang_jasa as pekerjaan','e_paket_hps_detail.qty','e_paket_hps_detail.satuan','e_rekanan_submit_harga_penawaran.paket_id','mt_rekanan.nama as nama_rekanan','e_rekanan_submit_harga_penawaran.is_check')
            ->join('e_paket_hps_detail','e_paket_hps_detail.id','=','e_rekanan_submit_harga_penawaran.paket_hps_id')
            ->join('e_paket_rekanan','e_paket_rekanan.mt_rekanan_id','=','e_rekanan_submit_harga_penawaran.mt_rekanan_id')
            ->join('mt_rekanan','mt_rekanan.id','=','e_rekanan_submit_harga_penawaran.mt_rekanan_id')->where('e_paket_rekanan.is_winner','=',1)
            ->where('e_rekanan_submit_harga_penawaran.paket_id','=',Crypt::decrypt($paket_id))
            ->get();
    	$pdf = PDF::loadView('procurement.tenders.print.print-bbapp', compact('paket', 'dt'));
		return $pdf->stream();
    }

}
