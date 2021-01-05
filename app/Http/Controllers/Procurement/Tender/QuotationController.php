<?php

namespace App\Http\Controllers\Procurement\tender;
use App\User;
use App\Models\Procurement\Pakets;
use App\Models\Procurement\Rekanans;
use App\Models\Procurement\Listpakets;
use App\Models\Procurement\Klpds;
use App\Models\Procurement\SatuanKerjas;
use App\Models\Procurement\Tahuns;
use App\Models\Procurement\Tahaps;
use App\Models\Procurement\PaketTahapans;
use App\Models\Procurement\JenisPengadaans;
use App\Models\Procurement\Kualifikasis;
use App\Models\Procurement\MetodeKualifikasis;
use App\Models\Procurement\Pemenangs;
use App\Models\Procurement\JenisKontraks;
use App\Models\Procurement\Paketanggarans;
use App\Models\Procurement\Paketlokasis;
use App\Models\Procurement\DokumenPenawarans;
use App\Models\Procurement\PaketJadwalPengadaan;
use App\Models\Procurement\PaketDokumenPenawarans;
use App\Models\Procurement\PaketLembarKualifikasi;
use App\Models\Procurement\EvaluasiPenilaian;
use App\Models\Procurement\EvaluasiKualifikasi;
use App\Models\Procurement\EvaluasiDokumenPenawaran;
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

class PenunjukanLangsungController extends Controller
{
    const PokjaApproved = 1;
    public const Administrasi = 1;
    public const Kualifikasi = 2;
    public const Teknis = 3;
    public const Harga = 4;
    const Active = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       
    }

    /**
     * create tender [pokja]
     * @author didi
     */
    public function create($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $jadwal = PaketTahapans::getjadwalNonTender(Crypt::decrypt($paket_id));
        // dd($jadwal);
        $lembarKualifikasi = PaketLembarKualifikasi::where('paket_id', Crypt::decrypt($paket_id))->first();
        $getFileKak = \App\Models\Procurement\PaketFile::where('tipe',\App\Models\Procurement\PaketFile::FileKak)
                    ->where('paket_id', Crypt::decrypt($paket_id))
                    ->first();

        $rekanan     = \App\Models\Procurement\PaketRekanan::where('paket_id',Crypt::decrypt($paket_id))->get();
        $getApproval = \DB::table('e_paket_approval')->where('paket_id',Crypt::decrypt($paket_id))
                        ->join('users','users.id','=','e_paket_approval.pokja_id')
                        ->get();

        $penawaran          = \App\Models\Procurement\RekananSubmitPenawaran::where('paket_id',Crypt::decrypt($paket_id))->get();
        $rekananPenawaran   = \DB::table('v_new_penawaran_rekanan')->where('paket_id', Crypt::decrypt($paket_id))->get();
        $kriteria           = \App\Models\Procurement\EvaluasiKriterias::where('id', $paket->evaluasi_kriteria_id)->first();
        $pembukaan          = \App\Models\Procurement\PemberianPenjelasanPembukaan::where('paket_id', Crypt::decrypt($paket_id))->first();
        $getTahapan         = \App\Models\Procurement\PaketTahapans::where('paket_id',Crypt::decrypt($paket_id))
                                ->where('waktu_mulai','<=', date('Y-m-d H:i:s'))
                                ->where('waktu_selesai','>=', date('Y-m-d H:i:s'))
                                ->first();
        // dd($getTahapan);
        return view('procurement.quotations.create',compact(
            'paket',
            'jadwal',
            'lembarKualifikasi',
            'getFileKak',
            'rekanan',
            'getApproval',
            'penawaran',
            'rekananPenawaran',
            'kriteria',
            'pembukaan',
            'getTahapan'
            ))
        ->withTitle('Penunjukan Langsung');
    }

    /**
     * edit tender pangadaan [pokja]
     * @author didi
     */
    public function editPengadaan($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $jenispengadaan = Auth::user()->id_jenis_pengadaan;
        $jenisPengadaan = JenisPengadaans::where('is_active', JenisPengadaans::Active)->where('id', $jenispengadaan)->orderBy('jenispengadaan', 'ASC')->pluck('jenispengadaan', 'id');
        $mtd_kualifikasi_id = MetodeKualifikasis::where('is_active', MetodeKualifikasis::Active)->orderBy('metode_kualifikasi', 'ASC')->pluck('metode_kualifikasi', 'id');
        $evaluasiKriteria  = \App\Models\Procurement\EvaluasiKriterias::all()->pluck('name','id');

        return view('procurement.quotations.edit-pengadaan',compact('paket','jenisPengadaan','mtd_kualifikasi_id','evaluasiKriteria'))->withTitle('Tender Edit Pengadaan');
    }

    /**
     * create jadwal tender
     * @author didi
     * @param string $paket_id
     */
    public function createJadwalPenunjukan($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $paketTahaps = Tahaps::where('type',Tahaps::NonTender)
            ->where('keterangan','Penunjukan Langsung')
            ->get();
        // dd($paketTahaps);
        return view('procurement.quotations.create-jadwal',compact('paket','paketTahaps'))->withTitle('Jadwal Non Tender');
    }

    /**
     * create dok penawaran
     * @author didi
     * @param string $paket_id
     */
    public function createDokumenPenawaran($paket_id)
    {
        $paket          = Pakets::find(Crypt::decrypt($paket_id));
        $dokPenawaran   = DokumenPenawarans::where('type',DokumenPenawarans::NonTender)
                        ->get();

        return view('procurement.quotations.create-dokumen-penawaran',compact('paket','dokPenawaran'))->withTitle('Dokumen Penawaran');
    }

    /**
     * create kualifikasi
     * @author didi
     * @param string $paket_id
     */
    public function createKualifikasi($paket_id)
    {
        $nontender = 1;
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $mkualfikasi = \App\Models\Procurement\MtKualifikasi::where('type', $nontender)->get();

        return view('procurement.quotations.create-kualifikasi',compact('paket','mkualfikasi'))->withTitle('Dokumen Penawaran');
    }

    /**
     * show data 
     * input data kualifikasi
     * 
     * @param  string  $paket_id
     * @return \Illuminate\Http\Response
    */
    public function createDokPemilihan($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));

        return view('procurement.quotations.create-dok-pemilihan',compact('paket'))->withTitle('Upload dokumen pemilihan');
    }

    /**
     * show data 
     * input data kualifikasi
     * 
     * @param  string  $paket_id
     * @return \Illuminate\Http\Response
    */
    public function createRekanan($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $rekanan = Rekanans::orderBy('mt_jenis_pengadaan_id', 'ASC')->where('is_active',Self::Active) ->get();

        return view('procurement.quotations.create-rekanan',compact('paket','rekanan'))->withTitle('Pilih Rekanan');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createEvaluasi($paket_id, $rekanan_id)
    {
        $paket      = \App\Models\Procurement\Pakets::find($paket_id);
        $rekanan    = \App\Models\Procurement\Rekanans::find($rekanan_id);
        $paketDok   = \App\Models\Procurement\PaketDokumenPenawarans::where('paket_id', $paket_id)
                    ->join('mt_dokumen_penawaran','mt_dokumen_penawaran.id','=','e_paket_dokumen_penawaran.mt_dokumen_penawaran_id')
                    ->get();
                    
        $paketKualifikasi = \App\Models\Procurement\PaketLembarKualifikasi::where('paket_id', $paket_id)
                    ->join('mt_kualifikasi','mt_kualifikasi.id','=','e_paket_kualifikasi.mt_kualifikasi_id')
                    ->get();


        return view('procurement.quotations.create-evaluasi',compact('paket','rekanan','paketDok','paketKualifikasi'))->withTitle('Evaluasi');
    }

    public function createPemenang($paket_id)
    {
        $paket = Pakets::find($paket_id);
        $rekanan = \App\Models\Procurement\PaketRekanan::where('e_paket_rekanan.paket_id', $paket_id)
                    ->leftJoin('e_rekanan_submit_harga_penawaran', 'e_paket_rekanan.mt_rekanan_id','=','e_rekanan_submit_harga_penawaran.mt_rekanan_id')
                    ->join('mt_rekanan','mt_rekanan.id','=','e_paket_rekanan.mt_rekanan_id')
                    ->select(
                        'mt_rekanan.id',
                        'mt_rekanan.nama',
                        'e_rekanan_submit_harga_penawaran.harga_penawaran',
                        'e_rekanan_submit_harga_penawaran.harga_terkoreksi',
                    )
                    ->get();

        return view('procurement.quotations.create-pemenang',compact('paket','rekanan'))->withTitle('Penetapan Pemenang');
    }

    /**
     * create negoisasi
     * @author didi
     */
    public function createNegoisasi($paket_id)
    {
        $paket = Pakets::find($paket_id);
        $paketHps = \App\Models\Procurement\PaketDetailHps::where('paket_id',$paket_id)->get();

        return view('procurement.quotations.create-negoisasi',compact('paket','paketHps'))->withTitle('Input negoisasi');
    }


    /**
     * store kualifikasi
     * @author didi
     */
    public function storeKualifikasi(Request $request)
    {
        \DB::beginTransaction();
        try {
            //insert jenis izin 
            if( $request->has('jenis_izin') ) {
                foreach( $request->input('jenis_izin') as $key => $jenis_izin ) {
                    \App\Models\Procurement\PaketJenisIzin::create([
                        'paket_id' => $request->paket_id,
                        'jenis_izin' => $request->jenis_izin[$key],
                        'klasifikasi' => $request->klasifikasi[$key],
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
            }

            //insert paket lembar kualifikasi
            $tender = 2;
            if( $request->has('mt_kualifikasi_id') ) {
                foreach($request->mt_kualifikasi_id as $k => $rows ) {
                    \App\Models\Procurement\PaketLembarKualifikasi::create([
                        'mt_kualifikasi_id' => $rows,
                        'paket_id' =>$request->paket_id,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
            }

            //tenaga ahli
            if( $request->has('tenaga_ahli') ) {
                foreach( $request->input('jenis_keahlian') as $key => $ta ) {
                    \App\Models\Procurement\PaketTenagaAhli::create([
                        'paket_id' => $request->paket_id,
                        'jenis_keahlian' => $request->jenis_keahlian[$key],
                        'keahlian' => $request->keahlian[$key],
                        'pengalaman' => $request->pengalaman[$key],
                        'kemampuan_manajerial' => $request->kemampuan_manajerial[$key],
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
            }

            //tenaga teknis
            if( $request->has('tenaga_teknis') ) {
                foreach( $request->input('jenis_kemampuan') as $key => $tk ) {
                    \App\Models\Procurement\PaketTenagaAhli::create([
                        'paket_id' => $request->paket_id,
                        'jenis_kemampuan' => $tk,
                        'kemampuan_teknis' => $request->kemampuan_teknis[$key],
                        'pengalaman' => $request->pengalaman[$key],
                        'kemampuan_manajerial' => $request->kemampuan_manajerial[$key],
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
            }

            //tenaga teknis
            if( $request->has('kemampuan') ) {
                foreach( $request->input('nama') as $key => $k ) {
                    \App\Models\Procurement\PaketKemampuan::create([
                        'paket_id' => $request->paket_id,
                        'nama' => $k,
                        'spesifikasi' => $request->spesifikasi[$key],
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
            }

            if( $request->has('syarat') ) {
                foreach( $request->input('syarat') as $key => $sy ) {
                    \App\Models\Procurement\PaketSyaratLainnya::create([
                        'paket_id' => $request->paket_id,
                        'syarat'   => $sy,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
            }

            \DB::commit();
            Alert::success('Data berhasil disimpan')->persistent('Ok');
            return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));

        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    /**
     * store jadwal tender
     * @author didi
     */
    public function storeJadwalPenunjukan(Request $request)
    {
        if($request->has('tahapan_id') ) {
            foreach( $request->tahapan_id as $key => $rows ) {
                PaketTahapans::create([
                    'paket_id' => $request->paket_id,
                    'tahapan_id' => $request->tahapan_id[$key],
                    'waktu_mulai' => \convert_date_time_picker($request->waktu_mulai[$key]),
                    'waktu_selesai' => \convert_date_time_picker($request->waktu_selesai[$key]),
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name
                ]);
            }
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
    }

    /**
     * store pengadaan edit
     * @author didi
     */
    public function storeEditPengadaan(Request $request)
    {
        $paket = Pakets::find($request->paket_id);
        $paket->jenispengadaan_id = $request->jenispengadaan_id;
        $paket->mtd_kualifikasi_id = $request->mtd_kualifikasi_id;
        $paket->is_metode_dokumen = $request->is_metode_dokumen;
        $paket->evaluasi_kriteria_id = $request->evaluasi_kriteria_id;

        $paket->update();

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
    }

     /**
     * store Dokumen pemawaran
     * @author didi
     */
    public function storeDokPenawaran(Request $request)
    {
        if($request->has('paket_id')) {
            foreach( $request->mt_dokumen_penawaran_id as $key => $value ) {
                PaketDokumenPenawarans::create([
                    'paket_id' => $request->paket_id,
                    'mt_dokumen_penawaran_id' => $value,
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name
                ]);
            }
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
    }

    /**
     * store pemilihan rekanan
     * @return \Illuminate\Http\Response
    */
    public function storePemilihanRekanan(Request $request)
    {
        if( $request->has('rekanan_id') ) {
            foreach( $request->rekanan_id as $key => $rows ) {

                \App\Models\Procurement\PaketRekanan::create([
                    'paket_id' => $request->paket_id,
                    'mt_rekanan_id' => $rows,
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);
            }
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
    }

    /**
     * store dokumen pemilihan
     * @return \Illuminate\Http\Response
    */
    public function storeDokPemilihan(Request $request)
    {
        $file = "";
        
        if( $request->has('dokumen')) {
            $file = $request->file('dokumen');
            // dd($file);
            $ext = $file->getClientOriginalExtension();
            $newName = rand(100000,1001238912).".".$ext;
            $file->move('uploads/file',$newName);
        }

        \App\Models\Procurement\PaketDokumen::create([
            'paket_id' => $request->paket_id,
            'nomor_dokumen' => $request->nomor_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'dokumen' => $newName,
        ]);

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
    }

    /**
     * store pemilihan rekanan
     * @return \Illuminate\Http\Response
    */
    public function storeApproval(Request $request)
    {
        $message['is_error']   = true;
        $message['success_msg'] = "";

        // dd($request);
        if( $request->paket_id ) {
            if( $request->status == Pakets::Approve ) {
                \DB::table('e_paket_approval')->where('paket_id', $request->paket_id)
                    ->where('pokja_id',Auth::user()->id)
                    ->update([
                        'status'        => Pakets::Approve,
                        'approval_date' => date('Y-m-d H:i:s'),
                    ]);
                $check = DB::table('e_paket_approval')->where('paket_id',$request->paket_id)
                        ->where('status', Self::PokjaApproved)
                        ->count();

                //jika pokja approved 50% + 1
                //publis paket 
                if( $check > 3 ) {
                    $paket = Pakets::find($request->paket_id);
                    $paket->is_public           = Pakets::PublishPaket;
                    $paket->status_paket        = Pakets::StatusPaketPublish; 
                    $paket->status_tahap_paket  = Pakets::TahapanPengumuman;
                    $paket->update();
                }
                
            } else {
                \DB::table('e_paket_approval')->where('paket_id',$request->paket_id)
                    ->where('pokja_id',Auth::user()->id)
                    ->update([
                        'status'        => Pakets::Reject,
                        'approval_date' => date('Y-m-d H:i:s'),
                        'reason'        => $request->reason
                    ]);

                $paket = Pakets::find($request->paket_id);
                $paket->is_public           = Pakets::Waiting;
                $paket->status_paket        = Pakets::Reject; 
                $paket->status_tahap_paket  = Pakets::Reject;
                $paket->update();
            }

            $message['is_error']   = false;
            $message['success_msg'] = "Data berhasil disimpan";
        }


        return response()->json($message, 200);
    }

    /**
     * store pembukaan
     * @author didi
     */
    public function storePembukaan(Request $request)
    {   
        // dd($request);
        \App\Models\Procurement\PemberianPenjelasanPembukaan::create([
            'paket_id' => $request->paket_id,
            'pembukaan' => $request->pembukaan,
            'userid_created' => Auth::user()->name,
            'userid_updated' => Auth::user()->name
        ]);

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
    }

    public function storeJawaban(Request $request)
    {
         // dd($request);
         \App\Models\Procurement\PemberianPenjelasanPertanyaan::create([
            'paket_id' =>$request->paket_id,
            'mt_rekanan_id' => $request->rekanan_id,
            'to_rekanan_id' => $request->rekanan_id,
            'author'        => 'pokja',
            'uraian'        => $request->uraian,
            'bab'           => $request->bab,
            'dokumen'       => $request->dokumen,
            'is_jawaban'     => 'YES',
            'userid_created' => Auth::user()->name,
            'userid_updated' => Auth::user()->name
        ]);

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
    }

    /**
     * Store data.
     * @param $request
     * @author didi gantengs
     * @return \Illuminate\Http\Response
     */
    public function storeEvaluasi(Request $request)
    {
        \DB::beginTransaction();
        try {
            // dd($request);
            if( $request->has('is_doc_type_kualifikasi') == Self::Kualifikasi ) {
                foreach( $request->is_doc_type_kualifikasi as $key => $value ) {
                    // dd($value);
                    \App\Models\Procurement\EvaluasiKualifikasi::create([
                        'paket_id' => $request->paket_id,
                        'mt_rekanan_id' => $request->rekanan_id,
                        'mt_kualifikasi_id' => $request->mt_kualifikasi_id[$key],
                        'memenuhi'  => $request->memenuhi_kualifikasi[$key],
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }

                //kualifikasi
                EvaluasiPenilaian::create([
                    'paket_id' => $request->paket_id,
                    'mt_rekanan_id' => $request->rekanan_id,
                    'is_lulus' => $request->is_lulus_kualifikasi,
                    'is_doc_type' => Self::Kualifikasi,
                    'alasan_tidak_lulus' => $request->alasan_tidak_lulus_kualifikasi ?? '',
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);    
            }

            if( $request->has('is_doc_type_administrasi') == Self::Administrasi ) {
                foreach( $request->is_doc_type_administrasi as $key => $value ) {
                    \App\Models\Procurement\EvaluasiDokumenPenawaran::create([
                        'paket_id' => $request->paket_id,
                        'mt_rekanan_id' => $request->rekanan_id,
                        'mt_dokumen_penawaran_id' => $request->mt_dokumen_penawaran_id[$key],
                        'memenuhi'  => $request->memenuhi_administrasi[$key] ?? 0,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
                //adminstrasi
                EvaluasiPenilaian::create([
                    'paket_id' => $request->paket_id,
                    'mt_rekanan_id' => $request->rekanan_id,
                    'is_lulus' => $request->is_lulus_administrasi,
                    'is_doc_type' => Self::Administrasi,
                    'alasan_tidak_lulus' => $request->alasan_tidak_lulus_administrasi ?? '',
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name
                ]);
                
            }

            if( $request->has('is_doc_type_teknis') == Self::Teknis ) {
                foreach( $request->is_doc_type_teknis as $key => $value ) {
                    \App\Models\Procurement\EvaluasiDokumenPenawaran::create([
                        'paket_id' => $request->paket_id,
                        'mt_rekanan_id' => $request->rekanan_id,
                        'mt_dokumen_penawaran_id' => $request->mt_dokumen_penawaran_id[$key],
                        'memenuhi'  => $request->memenuhi_teknis[$key] ?? 0,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }

                //teknis
                EvaluasiPenilaian::create([
                    'paket_id' => $request->paket_id,
                    'mt_rekanan_id' => $request->rekanan_id,
                    'is_lulus' => $request->is_lulus_teknis,
                    'is_doc_type' => Self::Teknis,
                    'alasan_tidak_lulus' => $request->alasan_tidak_lulus_teknis ?? '',
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);
            }

            if( $request->has('is_doc_type_harga') == Self::Harga ) {
                foreach( $request->is_doc_type_harga as $key => $value ) {
                    \App\Models\Procurement\EvaluasiDokumenPenawaran::create([
                        'paket_id' => $request->paket_id,
                        'mt_rekanan_id' => $request->rekanan_id,
                        'mt_dokumen_penawaran_id' => $request->mt_dokumen_penawaran_id[$key],
                        'memenuhi'  => $request->memenuhi_harga[$key] ?? 0,
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                }
                
                //harga
                EvaluasiPenilaian::create([
                    'paket_id' => $request->paket_id,
                    'mt_rekanan_id' => $request->rekanan_id,
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
            return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    public function storeRekanan(Request $request) 
    {
        if( $request->has('rekanan_id') ) {
            foreach( $request->rekanan_id as $key => $rows ) {

                \App\Models\Procurement\PaketRekanan::create([
                    'paket_id' => $request->paket_id,
                    'mt_rekanan_id' => $rows,
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);
            }
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
    }

    public function storePemenang(Request $request)
    {
        if( $request->has('rekanan_id')) {
            foreach( $request->rekanan_id as $key => $val ) {
                \App\Models\Procurement\PaketRekanan::where('paket_id', $request->paket_id)
                ->where('mt_rekanan_id', $val)
                ->update([
                    'is_winner' => \App\Models\Procurement\PaketRekanan::Pemenang,
                    'urutan_pemenang' => 1
                ]);
            }

            Pakets::where('id', $request->paket_id)
                ->update([
                    'status_paket' => Pakets::PaketPenetapanPemanang
                ]);
        }
        
        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id));
    }

    /**
     * Store negoisasi harga
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author didi gantengs
     */
    public function storeNegoisasi(Request $request)
    {
        $getRekananMenang = \App\Models\Procurement\PaketRekanan::where('paket_id',$request->paket_id)
                        ->where('is_winner', \App\Models\Procurement\PaketRekanan::Pemenang)
                        ->first();
        //save harga penawran
        if($request->has('harga_penawaran') ) {
            $total = 0;
            foreach( $request->harga_penawaran as $key => $value ) {
                $total += trim($value);
                \App\Models\Procurement\RekananSubmitHargaPenawaran::where('paket_id', $request->paket_id)
                    ->where('mt_rekanan_id', $request->rekanan_id)
                    ->update([
                        'mt_rekanan_id'     => $getRekananMenang->mt_rekanan_id,
                        'paket_id'          => $request->paket_id,
                        'paket_hps_id'      => $request->paket_hps_id[$key],
                        'harga_penawaran'   => trim($value),
                        'userid_created'    => Auth::user()->name,
                        'userid_updated'    => Auth::user()->name
                    ]);
            }

            //update di isnegoisasi
            // dan masukan harga negoisasi
            \App\Models\Procurement\RekananSubmitPenawaran::where('mt_rekanan_id', $getRekananMenang->mt_rekanan_id)
                ->where('paket_id',$request->paket_id)
                ->update([
                'harga_negoisasi'       => $total,
                'is_negoisasi'          => \App\Models\Procurement\RekananSubmitPenawaran::SudahDiNego,
                'userid_updated'        => Auth::user()->name
            ]);
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('quotation.create-quotation',Crypt::encrypt($request->paket_id)); 
    }
}
