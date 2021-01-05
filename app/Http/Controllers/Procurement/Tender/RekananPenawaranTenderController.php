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
use App\Models\Procurement\RekananSubmitDokumenPenawarans;
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

class RekananPenawaranTenderController extends Controller
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
        $paketDokPenawran = \App\Models\Procurement\PaketDokumenPenawarans::where('paket_id', Crypt::decrypt($id))->get();

        return view('procurement.rekananpenawaran.tender.input-penawaran', compact('paket','paketHps','paketDokPenawran'))->withTitle('input penawaran Paket');
    }

    public function show($id)
    {
        // dd(Crypt::decrypt($id));
        $paket = Pakets::find(Crypt::decrypt($id));
        $paketJadwal = \App\Models\Procurement\PaketJadwalPengadaan::where('paket_id',Crypt::decrypt($id))->first();
        $paketDokPemilihan = \App\Models\Procurement\PaketDokumen::where('paket_id',Crypt::decrypt($id))->first();
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

        return view('procurement.rekananpenawaran.tender.show', compact(
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
        
        

        return view('procurement.rekananpenawaran.tender.input-kualifikasi', compact(
            'paket',
            'ijinUsaha',
            'pajak',
            'akta',
            'pengalaman',
            'peralatans',
            'tenagaahli'
        ))->withTitle('Input kualifikasi Paket');
    }

    public function storePertanyaan(Request $request)
    {
        \App\Models\Procurement\PemberianPenjelasanPertanyaan::create([
            'paket_id' => Crypt::decrypt($request->paket_id),
            'mt_rekanan_id' => Auth::user()->mt_rekanan_id,
            'author'        => 'pokja',
            'uraian'    => $request->pertanyaan,
            'bab'           => $request->bab ?? "" ,
            'dokumen'       => $request->dokumen ?? "",
            'userid_created' => Auth::user()->name,
            'userid_updated' => Auth::user()->name,
            'is_jawaban'     => 'NO'
        ]);

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return \redirect()->route('laman-tender.create',$request->paket_id)->withTitle('Informasi Paket');
    }

    /** 
     * store kualifikasi
     * @author didi gantengs
     * @param array $request
     */
    public function storeDatakualifikasi(Request $request)
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

            return redirect()->route('laman-tender.show',Crypt::encrypt($request->paket_id));
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
    public function storeDatapenawaran(Request $request) 
    {
        $paketDokPenawran = \App\Models\Procurement\PaketDokumenPenawarans::where('paket_id', Crypt::decrypt($request->paket_id))->get();
        // dd($paketDokPenawran[0]->id);
        // dd($request->input('files_'.$paketDokPenawran[0]->id));
        if( $request->has('paket_dokumen_penawaran_id') ) {
            foreach( $request->paket_dokumen_penawaran_id as $key => $value ) {
                // dd($paketDokPenawran[$key]->id);
                if(  $request->has('files_'.$paketDokPenawran[$key]->id) ) {
                    $file = $request->file('files_'.$paketDokPenawran[$key]->id);
                    $size = $file->getClientSize();

                    $ext         = $file->getClientOriginalExtension();
                    $newFileName = rand(100000,1001238912).".".$ext;
                    $file->move('uploads/file',$newFileName);

                    RekananSubmitDokumenPenawarans::create([
                        'paket_id'              => Crypt::decrypt($request->paket_id),//$request->paket_id,
                        'mt_rekanan_id'         => Auth::user()->mt_rekanan_id,
                        'dokumen_penawaran_id'  => $request->paket_dokumen_penawaran_id[$key],
                        'file_size'             => $size,
                        'file'                  => $newFileName,
                        'file_path'             => 'uploads/file',
                        'userid_created'        => Auth::user()->name,
                        'userid_updated'        => Auth::user()->name
                    ]);
                } else {
                    echo "aink pendukung persib";die;
                }
            }
        } else {
            echo "eweh";die;
        }
        
        //save harga penawran
        if($request->has('harga_penawaran') ) {
            $total = 0;
            foreach( $request->harga_penawaran as $key => $value ) {
                // dd($value);
                $total += ($value) ?? 0;
                \App\Models\Procurement\RekananSubmitHargaPenawaran::create([
                    'mt_rekanan_id'  => Auth::user()->mt_rekanan_id,
                    'paket_id'       => Crypt::decrypt($request->paket_id),
                    'paket_hps_id' => $request->paket_hps_id[$key],
                    'harga_penawaran' => ($value) ?? 0,
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name
                ]);
            }
        }

        $filePenawaran    = '';
        if( $request->has('file_penawaran')) {
            $file = $request->file('file_penawaran');
            // dd($file);
            $ext = $file->getClientOriginalExtension();
            $filePenawaran = rand(100000,1001238912).".".$ext;
            $file->move('uploads/file',$filePenawaran);
        }

        //total penawaran
        \App\Models\Procurement\RekananSubmitPenawaran::create([
            'mt_rekanan_id'         => Auth::user()->mt_rekanan_id,
            'paket_id'              => Crypt::decrypt($request->paket_id),
            'is_setuju'             => $request->is_setuju,
            'masa_berlaku'          => $request->masa_berlaku,
            'file_penawaran'        => $filePenawaran,
            'total_harga_penawaran' => $total,
            'userid_created'        => Auth::user()->name,
            'userid_updated'        => Auth::user()->name
        ]);

        Alert::success('Data berhasil disimpan')->persistent('Ok');

        return redirect()->route('laman-tender.show',$request->paket_id);
    }
}