<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\Listpakets;
use App\Models\Procurement\Klpds;
use App\Models\Procurement\SatuanKerjas;
use App\Models\Procurement\Tahuns;
use App\Models\Procurement\JenisPengadaans;
use App\Models\Procurement\Kualifikasis;
use App\Models\Procurement\MetodeKualifikasis;
use App\Models\Procurement\Pemenangs;
use App\Models\Procurement\JenisKontraks;
use App\Models\Procurement\Paketanggarans;
use App\Models\Procurement\Paketlokasis;
use App\Models\Procurement\PaketJadwalPengadaan;
use App\Models\Procurement\PaketLembarKualifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use App\Models\Procurement\Pakets;
use App\Models\Procurement\PaketRekanan;
use App\Repositories\Procurement\Tender\PaketRekananRepository;
use Session;
use Crypt;
use Auth;
use Storage;
use DB;
use InseoHelper;
use App\Repositories\ProvinsiRepository;
use App\Repositories\KotaRepository;
use App\Repositories\PaketRepository;

class PenawaranController extends Controller
{
    const Active = 1;
    const Submit = 1;

    public function __construct(
        ProvinsiRepository $ProvinsiRepo,
        KotaRepository $KotaRepo,
        PaketRepository $PaketRepo
    ) {
        $this->ProvinsiRepo = $ProvinsiRepo;
        $this->KotaRepo = $KotaRepo;
        $this->PaketRepo = $PaketRepo;
    }

    public function index() {}

    public function inputPenawaran($id)
    {
        $paket = Pakets::find(Crypt::decrypt($id));
        $paketHps = \App\Models\Procurement\PaketDetailHps::where('paket_id', Crypt::decrypt($id))->get();

        return view('procurement.penawaran.input-penawaran', compact('paket','paketHps'))->withTitle('input penawaran Paket');
    }

    public function show($id)
    {
        $paket = Pakets::find(Crypt::decrypt($id));
        $paketDokPemilihan = \App\Models\Procurement\PaketDokumen::where('paket_id',Crypt::decrypt($id))->first();
        $paketJadwal = \App\Models\Procurement\PaketJadwalPengadaan::where('paket_id',Crypt::decrypt($id))->first();
        $submitKualifikasi =  \DB::table('e_rekanan_submit_kualifikasi')
            ->where('paket_id',Crypt::decrypt($id))
            ->where('mt_rekanan_id', Auth::user()->mt_rekanan_id)
            ->first();

        $isSubmit = false;
        if( null != $submitKualifikasi) {
            if( Self::Submit == $submitKualifikasi->submit_kualifikasi ) {
                $isSubmit = true;
            }
        }

        return view('procurement.penawaran.show', compact(
            'paket',
            'paketDokPemilihan',
            'paketJadwal',
            'isSubmit',
        ))
        ->withTitle('Informasi Paket');
    }

    public function inputKualifikasi($id)
    {
        $paket = Pakets::find(Crypt::decrypt($id));
        $ijinUsaha = \App\Models\Webprofile\Ijinusahas::where('mt_rekanan_id' ,Auth::user()->mt_rekanan_id)
            ->get();
            // dd();
        $pajak = \App\Models\Webprofile\Pajaks::where('mt_rekanan_id' ,Auth::user()->mt_rekanan_id)
            ->get();
        $akta = \App\Models\Webprofile\Aktas::where('mt_rekanan_id' ,Auth::user()->mt_rekanan_id)
            ->first();

        $pengalaman = \App\Models\Webprofile\Pengalamans::where('mt_rekanan_id' ,Auth::user()->mt_rekanan_id)
            ->get();

        $peralatans = \App\Models\Webprofile\Peralatans::where('mt_rekanan_id' ,Auth::user()->mt_rekanan_id)
            ->get();

        $tenagaahli = \App\Models\Webprofile\TenagaAhlis::where('mt_rekanan_id' ,Auth::user()->mt_rekanan_id)
            ->leftJoin('mt_tenaga_ahli_pendidikan','mt_tenaga_ahli_pendidikan.mt_tenaga_ahli_id','=','mt_tenaga_ahli.id')
            ->leftJoin('mt_tenaga_ahli_pengalaman','mt_tenaga_ahli_pengalaman.mt_tenaga_ahli_id','=','mt_tenaga_ahli.id')
            ->leftJoin('mt_tenaga_ahli_sertifikat','mt_tenaga_ahli_pengalaman.mt_tenaga_ahli_id','=','mt_tenaga_ahli.id')
            ->select(
                'mt_tenaga_ahli.id',
                'mt_tenaga_ahli.nama',
                'mt_tenaga_ahli.keahlian',
                'mt_tenaga_ahli.pengalaman_kerja',
                'mt_tenaga_ahli_pengalaman.uraian as pengalaman',
                'mt_tenaga_ahli_sertifikat.uraian as sertifikat',
                'mt_tenaga_ahli_pendidikan.uraian as pendidikan'
            )
            ->get();
        
        

        return view('procurement.penawaran.input-kualifikasi', compact(
            'paket',
            'ijinUsaha',
            'pajak',
            'akta',
            'pengalaman',
            'peralatans',
            'tenagaahli'
        ))->withTitle('Input kualifikasi Paket');
    }

    /** 
     * store kualifikasi
     * @author didi gantengs
     * @param array $request
     */
    public function store_data_kualifikasi(Request $request)
    {
        try {
            \DB::beginTransaction();
            //store ijin usaha
            if( $request->has('ijin_usaha_id') ) {
                foreach( $request->ijin_usaha_id as $key => $value ) {
                    \App\Models\Procurement\RekananSubmitKualifikasiIzinUsaha::create([
                        'ijin_usaha_id' => $value,
                        'mt_rekanan_id' => Auth::user()->mt_rekanan_id,
                        'paket_id'      => $request->paket_id,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name,
                    ]);
                }
            }

            //store pajak
            if( $request->has('pajak_id') ) {
                foreach( $request->pajak_id as $key => $value ) {
                    \App\Models\Procurement\RekananSubmitKualifikasiPajak::create([
                        'pajak_id'       => $value,
                        'mt_rekanan_id'  => Auth::user()->mt_rekanan_id,
                        'paket_id'       => $request->paket_id,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name,
                    ]);
                }
            }

            $newName    = '';
            if( $request->has('file_bukti_dukungan_bank')) {
                $file = $request->file('file_bukti_dukungan_bank');
                // dd($file);
                $ext = $file->getClientOriginalExtension();
                $newName = rand(100000,1001238912).".".$ext;
                $file->move('uploads/file',$newName);
            }

            //store dukungan bank
            \App\Models\Procurement\RekananSubmitKualifikasiDukunganBank::create([
                'nama_bank'       => $request->nama_bank,
                'nomor_surat'    => $request->nomor_surat,
                'tanggal'        => $request->tanggal,
                'nilai'          => $request->nilai,
                'file_bukti_dukungan_bank' => $newName,
                'mt_rekanan_id'  => Auth::user()->mt_rekanan_id,
                'paket_id'       => $request->paket_id,
                'userid_created' => Auth::user()->name,
                'userid_updated' => Auth::user()->name,
            ]);
            
            //store akta
            if( $request->has('akta_id') ) {
                \App\Models\Procurement\RekananSubmitKualifikasiAkta::create([
                    'mt_rekanan_id'  => Auth::user()->mt_rekanan_id,
                    'paket_id'       => $request->paket_id,
                    'akta_id'         => $request->akta_id,
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);
            }

            //store tenaga_ahl
            if( $request->has('mt_tenaga_ahli_id') ) {
                foreach( $request->mt_tenaga_ahli_id as $key => $value ) {
                    \App\Models\Procurement\RekananSubmitKualifikasiTa::create([
                        'mt_tenaga_ahli_id'       => $value,
                        'mt_rekanan_id'    => Auth::user()->mt_rekanan_id,
                        'paket_id'       => $request->paket_id,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name,
                    ]);
                }
            }

            //store pengalaman
            if( $request->has('mt_pengalaman_id') ) {
                foreach( $request->mt_pengalaman_id as $key => $value ) {
                    \App\Models\Procurement\RekananSubmitKualifikasiPengalaman::create([
                        'mt_pengalaman_id'       => $value,
                        'mt_rekanan_id'    => Auth::user()->mt_rekanan_id,
                        'paket_id'       => $request->paket_id,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name,
                    ]);
                }
            }

            //store pengalaman
            if( $request->has('mt_peralatan_id') ) {
                foreach( $request->mt_peralatan_id as $key => $value ) {
                    \App\Models\Procurement\RekananSubmitKualifikasiPeralatan::create([
                        'mt_peralatan_id'       => $value,
                        'mt_rekanan_id'    => Auth::user()->mt_rekanan_id,
                        'paket_id'       => $request->paket_id,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name,
                    ]);
                }
            }

            $newNameSy    = '';
            if( $request->has('file_syarat_lain')) {
                $file = $request->file('file_syarat_lain');
                // dd($file);
                $ext = $file->getClientOriginalExtension();
                $newNameSy = rand(100000,1001238912).".".$ext;
                $file->move('uploads/file',$newNameSy);
            }

            //store akta
            \App\Models\Procurement\RekananSubmitKualifikasiSyaratLains::create([
                'mt_rekanan_id'  => Auth::user()->mt_rekanan_id,
                'paket_id'       => $request->paket_id,
                'file_syarat_lain'         => $newNameSy,
                'userid_created' => Auth::user()->name,
                'userid_updated' => Auth::user()->name,
            ]);

            \DB::table('e_rekanan_submit_kualifikasi')->insert([
                'id' => Uuid::generate(),
                'mt_rekanan_id'  => Auth::user()->mt_rekanan_id,
                'paket_id'       => $request->paket_id,
                'submit_kualifikasi' => Self::Submit,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'userid_created' => Auth::user()->name,
                'userid_updated' => Auth::user()->name,
            ]);

            \DB::commit();
            Alert::success('Data berhasil disimpan')->persistent('Ok');

            return redirect()->route('penawaran.show',Crypt::encrypt($request->paket_id));
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
        
    }

    /**
     * store data
     * @author didi gantengs
     * @param array $request
     */
    public function store_data_penawaran(Request $request) 
    {
        $newNameFileJadwal   = '';
        $newNameFileBrosur   = '';
        $newNameFileTenagaTeknis   = '';
        if( $request->has('file_syarat_lain')) {
            $file = $request->file('file_syarat_lain');
            // dd($file);
            $ext = $file->getClientOriginalExtension();
            $newNameFileJadwal = rand(100000,1001238912).".".$ext;
            $file->move('uploads/file',$newNameFileJadwal);
        }

        if( $request->has('file_syarat_lain')) {
            $file = $request->file('file_syarat_lain');
            // dd($file);
            $ext = $file->getClientOriginalExtension();
            $newNameFileBrosur = rand(100000,1001238912).".".$ext;
            $file->move('uploads/file',$newNameFileBrosur);
        }

        if( $request->has('file_syarat_lain')) {
            $file = $request->file('file_syarat_lain');
            // dd($file);
            $ext = $file->getClientOriginalExtension();
            $newNameFileTenagaTeknis = rand(100000,1001238912).".".$ext;
            $file->move('uploads/file',$newNameFileTenagaTeknis);
        }

        \App\Models\Procurement\RekananSubmitPenawaran::create([
            'mt_rekanan_id'  => Auth::user()->mt_rekanan_id,
            'paket_id'       => $request->paket_id,
            'file_jadwal_penyerahan' => $newNameFileJadwal,
            'is_setuju' => $request->is_setuju,
            'file_brosur' => $newNameFileBrosur,
            'file_tenaga_teknis' => $newNameFileTenagaTeknis,
            'masa_berlaku' => $request->masa_berlaku,
            'userid_created' => Auth::user()->name,
            'userid_updated' => Auth::user()->name
        ]);
        
        //save harga penawran
        if($request->has('harga_penawaran') ) {
            foreach( $request->harga_penawaran as $key => $value ) {
                \App\Models\Procurement\RekananSubmitHargaPenawaran::create([
                    'mt_rekanan_id'  => Auth::user()->mt_rekanan_id,
                    'paket_id'       => $request->paket_id,
                    'paket_hps_id' => $request->paket_hps_id[$key],
                    'harga_penawaran' => trim($value),
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name
                ]);
            }
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');

        return redirect()->route('penawaran.show',Crypt::encrypt($request->paket_id));
    }
}