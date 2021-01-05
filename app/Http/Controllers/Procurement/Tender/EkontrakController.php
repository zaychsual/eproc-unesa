<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\Pakets;
use App\Models\Procurement\EkontrakSppbj;
use App\Models\Procurement\EkontrakUndangan;
use App\Models\Procurement\EkontrakSpp;
use App\Models\Procurement\Ekontrak;
use App\Models\Procurement\EkontrakSskk;
use App\Models\Procurement\EkontrakBap;
use App\Models\Procurement\EkontrakTermin;
use App\Models\Procurement\Einbox;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;
use PDF;
use Terbilang;
use App\Mail\InboxMail;
use Mail;

class EkontrakController extends Controller
{
    /**
     * 
     * 
     */
    public function index()
    {
        return  view('procurement.ekontrak.index');
    }

    public function proses($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));

        return view('procurement.ekontrak.proses',compact('paket'))->withTitle('Dokumen');
    } 

    public function eSppbj($paket_id)
    {
        $eSppbj = EkontrakSppbj::where('paket_id', Crypt::decrypt($paket_id))->get();
        // dd($eSppbj);
        
        return view('procurement.ekontrak.e-sppbj',compact('eSppbj','paket_id'))->withTitle('E-SPPBJ');
    }

    public function eSppbjCreate($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $rekanan = \DB::table('v_penawaran_rekanan')->where('paket_id', Crypt::decrypt($paket_id))
            ->get();

        $ppk = \App\User::where('name',$paket->userid_created)->first();
        $satuanKerja = \App\Models\Procurement\SatuanKerjas::where('id', $paket->satuankerja_id)->first();
        $eSppbj = EkontrakSppbj::where('paket_id', Crypt::decrypt($paket_id))->first();
        $rekananWin = \App\Models\Procurement\PaketRekanan::where('paket_id', Crypt::decrypt($paket_id))
            ->where('is_winner', \App\Models\Procurement\PaketRekanan::Pemenang)
            ->first();

        return view('procurement.ekontrak.create-sppbj',compact(
            'paket',
            'rekanan',
            'ppk',
            'satuanKerja',
            'eSppbj',
            'rekananWin',
            'paket_id'
        ))->withTitle('E-SPPBJ');
    }

    public function ringkasanKontrak($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $rekanan = \DB::table('v_penawaran_rekanan')->where('paket_id', Crypt::decrypt($paket_id))
            ->get();

        $ppk = \App\User::where('name',$paket->userid_created)->first();
        $satuanKerja = \App\Models\Procurement\SatuanKerjas::where('id', $paket->satuankerja_id)->first();
        $eSppbj = EkontrakSppbj::where('paket_id', Crypt::decrypt($paket_id))->first();
        $rekananWin = \App\Models\Procurement\PaketRekanan::where('paket_id', Crypt::decrypt($paket_id))
            ->where('is_winner', \App\Models\Procurement\PaketRekanan::Pemenang)
            ->first();

        return view('procurement.ekontrak.ringkasan-kontrak',compact(
            'paket',
            'rekanan',
            'ppk',
            'satuanKerja',
            'eSppbj',
            'rekananWin',
            'paket_id'
        ))->withTitle('Ringkasan Kontrak');
    }

    public function storeSppbj(Request $request)
    { 
        $request['userid_created'] = Auth::user()->name;
        $request['userid_updated'] = Auth::user()->name;

        EkontrakSppbj::create($request->all());
  
        Alert::success('Data berhasil disimpan')->persistent('Ok');
        
        return redirect()->route('e-kontrak.sppbj-create',Crypt::encrypt($request->paket_id));
    }

    public function storeUndanganKontrak(Request $request)
    {
        $request['userid_created'] = Auth::user()->name;
        $request['userid_updated'] = Auth::user()->name;

        EkontrakUndangan::create($request->all());
        
        //update flag is kirim undangan =1
        \App\Models\Procurement\PaketRekanan::where('paket_id', $request->paket_id)
            ->where('mt_rekanan_id', $request->mt_rekanan_id)
            ->update([
                'is_kirim_undangan' => \App\Models\Procurement\PaketRekanan::SudahKirim
            ]);

        //email Undangan Pokja ke penyedia
        $paket = \DB::table('e_paket')->select('e_paket.nama','mt_rekanan.nama as nama_penyedia','mt_rekanan.npwp','users.id','users.email')->join('e_paket_rekanan','e_paket_rekanan.paket_id','=','e_paket.id')->join('mt_rekanan','e_paket_rekanan.mt_rekanan_id','=','mt_rekanan.id')->join('users','mt_rekanan.id','=','users.mt_rekanan_id')->where('e_paket.id','=',$request->paket_id)->first();
        $dataMail= array();
        $dataMail['title'] = 'Pemberitahuan Inbox Pengendali Kualitas'; 
        $dataMail['user'] = 'Pimpinan '.@$paket->nama_penyedia.'<br>Npwp: '. @$paket->npwp; 
        $dataMail['user_id'] = Auth::user()->id; 
        $dataMail['message'] = 'Anda terpilih untuk mengikuti pengadaan '.$paket->nama.' Silahkan masuk melalui simbajanesa.ac.id , klik konfirmasi untuk mengikuti pengadaan tersebut.<br><br>Terima kasih';
        $dataMail['subject'] = 'Undangan '.$paket->nama;
        $dataMail['is_read'] = 0;
        $dataMail['user_to_id'] = $paket->id;
        Einbox::create($dataMail);
        Mail::to($paket->email)->send(new InboxMail($dataMail));
        
        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('e-kontrak.sppbj',Crypt::encrypt($request->paket_id));
    }

    public function eKontrak($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $ppk = \App\User::where('name',$paket->userid_created)->first();
        $rekanan = \App\Models\Procurement\PaketRekanan::where('paket_id', Crypt::decrypt($paket_id))
            ->where('is_winner', \App\Models\Procurement\PaketRekanan::Pemenang)
            ->join('mt_rekanan','mt_rekanan.id','=','e_paket_rekanan.mt_rekanan_id')
            ->first();
        return view('procurement.ekontrak.create-kontrak',compact('paket','ppk','rekanan','paket_id'))->withTitle('Kontrak');
    }

    public function storeKontrak(Request $request)
    {
        Ekontrak::create($request->all());

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        
        return redirect()->route('e-kontrak.sppbj',Crypt::encrypt($request->paket_id));
    }

    public function eKontrakSskk($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $rekanan = \App\Models\Procurement\PaketRekanan::where('paket_id', Crypt::decrypt($paket_id))
            ->where('is_winner', \App\Models\Procurement\PaketRekanan::Pemenang)
            ->first();

        return view('procurement.ekontrak.create-sskk',compact('paket','rekanan'))->withTitle('SSKK');
    }
    public function storeSskk(Request $request)
    {
        $file = "";
        if( $request->has('file_sskk')) {
            $file = $request->file('file_sskk');
            // dd($file);
            $ext = $file->getClientOriginalExtension();
            $newName = rand(100000,1001238912).".".$ext;
            $file->move('uploads/file',$newName);
        }

        EkontrakSskk::create([
            'paket_id' => $request->paket_id,
            'mt_rekanan_id' => $request->rekanan_id,
            'file_sskk' => $newName,
            'userid_created' => Auth::user()->name,
            'userid_updated' => Auth::user()->name
        ]);

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        
        return redirect()->route('e-kontrak.create-spp',Crypt::encrypt($request->paket_id));
    }
    public function eKontrakSpp($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $rekanan = \App\Models\Procurement\PaketRekanan::where('paket_id', Crypt::decrypt($paket_id))
            ->where('is_winner', \App\Models\Procurement\PaketRekanan::Pemenang)
            ->join('mt_rekanan','mt_rekanan.id','=','e_paket_rekanan.mt_rekanan_id')
            ->first();
        $ppk = \App\User::where('name',$paket->userid_created)->first();
        $kontrak = Ekontrak::where('paket_id', Crypt::decrypt($paket_id))->first();
        $spp = eKontrakSpp::where('paket_id', Crypt::decrypt($paket_id))->first();
        return view('procurement.ekontrak.create-spp',compact('paket','ppk','rekanan','paket_id','kontrak','spp'))->withTitle('SPP');
    }
    public function storeSpp(Request $request)
    {


        $request['userid_created'] = Auth::user()->name;
        $request['userid_updated'] = Auth::user()->name;

        eKontrakSpp::create($request->all());

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        
        return redirect()->route('e-kontrak.create-spp',Crypt::encrypt($request->paket_id));
    }
    public function paketDiteruskan($paket_id)
    {
        $paket = \App\Models\Procurement\Pakets::find(Crypt::decrypt($paket_id));
        $pengendaliKualitas = \App\User::where('role', 'pengendalikualitas')->pluck('name','id');

        return view('procurement.ekontrak.proses-diteruskan', compact('paket','pengendaliKualitas'))->withTitle('Proses Diteruskan');
    }

    public function Pembayaran($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $pembayaran = EkontrakBap::where('paket_id',Crypt::decrypt($paket_id))->get();
        return view('procurement.ekontrak.pembayaran',compact('paket','pembayaran','paket_id'))->withTitle('Pembayaran');
    }

    public function createPembayaran($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $ppk = \App\User::where('name',$paket->userid_created)->first();
        $rekanan = \App\Models\Procurement\PaketRekanan::where('paket_id', Crypt::decrypt($paket_id))
            ->join('mt_rekanan','mt_rekanan.id','=','e_paket_rekanan.mt_rekanan_id')
            ->first();
        return view('procurement.ekontrak.create-bap',compact('paket','paket_id','rekanan'))->withTitle('BAP');
    }

    public function storeBap(Request $request)
    {
        $filebap = "";
        if( $request->has('bap_file_upload')) {
            $filebap = $request->file('bap_file_upload');
            // dd($file);
            $ext = $filebap->getClientOriginalExtension();
            $newName = rand(100000,1001238912).".".$ext;
            $filebap->move('uploads/file',$newName);
        }
        $filebast = "";
        if( $request->has('bast_file')) {
            $filebast = $request->file('bast_file');
            // dd($file);
            $ext = $filebast->getClientOriginalExtension();
            $newName = rand(100000,1001238912).".".$ext;
            $filebast->move('uploads/file',$newName);
        }
        $request['bast_file'] = $filebast;
        $request['bap_file_upload'] = $filebap;
        $request['userid_created'] = Auth::user()->name;
        $request['userid_updated'] = Auth::user()->name;

        //
        EkontrakBap::create($request->all());
        EkontrakTermin::create($request->all());

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        
        return redirect()->route('e-kontrak.create-pembayaran',Crypt::encrypt($request->paket_id));
    }
    public function printSppbj($paket_id)
    { 
        $paket = \DB::table('e_kontrak_sppbj')->join('e_paket','e_paket.id','=','e_kontrak_sppbj.paket_id')
                ->join('v_penawaran_rekanan','e_paket.id','=','v_penawaran_rekanan.paket_id')
                ->select('v_penawaran_rekanan.nama as namacv', 'e_kontrak_sppbj.sppbj_no as no_sppbj',
                        'e_paket.nama as namapaket','e_kontrak_sppbj.sppbj_harga_final as harga',
                        'e_kontrak_sppbj.sppbj_kota as alamat','e_kontrak_sppbj.sppbj_tanggal as tanggal',
                        'e_kontrak_sppbj.userid_created as pembuat'
                )
                ->where('e_kontrak_sppbj.paket_id',Crypt::decrypt($paket_id))
                ->first();
        $harga = Terbilang::make($paket->harga, ' rupiah');
        $pdf = PDF::loadView('procurement.ekontrak.print.print-sppbj',compact('paket','harga'));
        return $pdf->stream();
    }
    public function printRingkasanKontrak($paket_id)
    { 
        $paket = \DB::table('e_kontrak_sppbj')->join('e_paket','e_paket.id','=','e_kontrak_sppbj.paket_id')
                ->join('v_penawaran_rekanan','e_paket.id','=','v_penawaran_rekanan.paket_id')
                ->select('v_penawaran_rekanan.nama as namacv', 'e_kontrak_sppbj.sppbj_no as no_sppbj',
                        'e_paket.nama as namapaket','e_kontrak_sppbj.sppbj_harga_final as harga',
                        'e_kontrak_sppbj.sppbj_kota as alamat','e_kontrak_sppbj.sppbj_tanggal as tanggal',
                        'e_kontrak_sppbj.userid_created as pembuat'
                )
                ->where('e_kontrak_sppbj.paket_id',Crypt::decrypt($paket_id))
                ->first();
        $harga = Terbilang::make($paket->harga, ' rupiah');
        $pdf = PDF::loadView('procurement.ekontrak.print.print-ringkasan-kontrak',compact('paket','harga'));
        return $pdf->stream();
    }
    public function printSpp($paket_id)
    { 
        $paket = \DB::table('e_kontrak_sppbj')->join('e_paket','e_paket.id','=','e_kontrak_sppbj.paket_id')->join('v_penawaran_rekanan','e_paket.id','=','v_penawaran_rekanan.paket_id')->select('v_penawaran_rekanan.nama as namacv', 'e_kontrak_sppbj.sppbj_no as no_sppbj','e_paket.nama as namapaket','e_kontrak_sppbj.sppbj_harga_final as harga','e_kontrak_sppbj.sppbj_kota as alamat','e_kontrak_sppbj.sppbj_tanggal as tanggal','e_kontrak_sppbj.userid_created as pembuat')->where('e_kontrak_sppbj.paket_id',Crypt::decrypt($paket_id))->first();
        $harga = Terbilang::make($paket->harga, ' rupiah');
        $pdf = PDF::loadView('procurement.ekontrak.print.print-sppbj',compact('paket','harga'));
        return $pdf->stream();
    }
    public function printBAST($paket_id)
    { 
        
        $pdf = PDF::loadView('procurement.ekontrak.print.print-bast');
        return $pdf->stream();
    }
    public function printBap($paket_id)
    { 
        $pdf = PDF::loadView('procurement.ekontrak.print.print-bap');
        return $pdf->stream();
    }
}
