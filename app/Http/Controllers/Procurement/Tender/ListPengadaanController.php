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
use App\Models\Procurement\Einbox;
use Illuminate\Http\Request;
use App\Models\Procurement\Rekanans;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use App\Models\Procurement\Pakets;
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
use App\Mail\InboxMail;
use Mail;

class ListPengadaanController extends Controller
{

    const PL = 'PL';//pembelian langsung
    const EP = 'EP';//e-purchasing
    const QU = 'QU';//quotation
    const TE = 'TE';//tender
    const PLA = 'PLA';//penunjukan langsung
    const PBB = 'PBB';//Pembelian barang bekas
    const Active = 1;
    private $ProvinsiRepo;

    public function __construct(
        ProvinsiRepository $ProvinsiRepo,
        KotaRepository $KotaRepo,
        PaketRepository $PaketRepo
    ) {
        $this->ProvinsiRepo = $ProvinsiRepo;
        $this->KotaRepo = $KotaRepo;
        $this->PaketRepo = $PaketRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pokjaJenis = Auth::user()->id_jenis_pengadaan;
        // $jenispengadaan_id = Auth::user()-
        if( Auth::user()->role == 'pokja' ) {
            $data = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                ->where('e_paket_category.code',Self::PL)
                ->where('pokja_id', $pokjaJenis)
                ->where('is_pic',Pakets::picPokja)
                ->select(
                    'e_paket_category.name',
                    'e_paket.*'
                )
                ->get();
        } else {
            $data = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                ->where('e_paket_category.code',Self::PL)
                ->select(
                    'e_paket_category.name',
                    'e_paket.*'
                )
                ->get();
        }

        return view('procurement.listpengadaan.index-pembelian-langsung', compact('data'))->withTitle('Pembelian Langsung');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function e_purchasing()
    {
        if( Auth::user()->role == 'pokja' ) {
            $data = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                ->where('e_paket_category.code',Self::EP)
                ->where('pokja_id', Auth::user()->id)
                ->where('is_pic',Pakets::picPokja)
                ->select(
                    'e_paket_category.name',
                    'e_paket.*'
                )
                ->get();
        } else {
            
            $data = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
            ->where('e_paket_category.code',Self::EP)
            ->get();
        }

        return view('procurement.listpengadaan.index-epurchasing', compact('data'))->withTitle('E-Purchasing');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quotation()
    {
        if( Auth::user()->role == 'pokja' ) {
            $data = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                ->where('e_paket_category.code',Self::QU)
                ->where('pokja_id', Auth::user()->id)
                ->where('is_pic',Pakets::picPokja)
                ->select(
                    'e_paket_category.name',
                    'e_paket.*'
                )
                ->get();
        } else {
            $data = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                ->where('e_paket_category.code',Self::QU)
                ->where('pokja_id', Auth::user()->id)
                ->where('is_pic',Pakets::picPokja)
                ->select(
                    'e_paket_category.name',
                    'e_paket.*'
                )
                ->get();
        }

        return view('procurement.listpengadaan.index-quotation', compact('data'))->withTitle('Quotation');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tender()
    {
        $pokjaJenis = Auth::user()->id_jenis_pengadaan;

        if( Auth::user()->role == 'pokja' ) {
            $data = DB::table('v_pokja_paket')
                ->where('kode_metode', Self::TE)
                ->where('pokja_id',Auth::user()->id)
                ->get();
        }  else {
            $data =  Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                ->where('e_paket_category.code',Self::TE)
                ->select(
                    'e_paket_category.name',
                    'e_paket.*'
                )
                ->orderBy('e_paket.created_at','desc')
                ->get();
        }

        // dd($data);

        return view('procurement.listpengadaan.index-tender', compact('data'))->withTitle('Tender');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penunjukan_langsung()
    {
        $pokjaJenis = Auth::user()->id_jenis_pengadaan;

        if( Auth::user()->role == 'pokja' ) {
            $data = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                ->where('e_paket_category.code',Self::PLA)
                ->where('pokja_id', $pokjaJenis)
                ->where('is_pic',Pakets::picPokja)
                ->select(
                    'e_paket_category.name',
                    'e_paket.*'
                )
                ->get();
        }  else {
            $data =  Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                    ->where('e_paket_category.code',Self::PLA)
                    ->select(
                        'e_paket_category.name',
                        'e_paket.*'
                    )
                    ->get();
        }

        return view('procurement.listpengadaan.index-penunjukan-langsung', compact('data'))->withTitle('Penunjukan Langsung');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pembelian_barang_bekas()
    {
        if( Auth::user()->role == 'pokja' ) {
            $data = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                ->where('e_paket_category.code',Self::PBB)
                ->where('pokja_id', Auth::user()->id)
                ->where('is_pic',Pakets::picPokja)
                ->select(
                    'e_paket_category.name',
                    'e_paket.*'
                )
                ->get();
        }  else {
            $data = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
                ->where('e_paket_category.code',Self::PBB)
                ->select(
                    'e_paket_category.name',
                    'e_paket.*'
                )
                ->get();
        }

        return view('procurement.listpengadaan.index-pembelian-barang-bekas', compact('data'))->withTitle('Pembelian Barang Bekas');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Info $info
     *
     * @return \Illuminate\Http\Response
     */
    public function send_pic($id)
    {
        try {
            $paket = Pakets::find(Crypt::decrypt($id));
            // dd($paket);

            $klpd_id = Klpds::where('is_active', Self::Active)->orderBy('klpd', 'ASC')->pluck('klpd', 'id');
            $satuankerja_id = SatuanKerjas::where('is_active', Self::Active)->orderBy('satuankerja', 'ASC')->pluck('satuankerja', 'id');
            $category_id = \DB::table('e_paket_category')->pluck('name', 'id');
            $provinsi = $this->ProvinsiRepo->provinsi('noajax');
            $kota = $this->KotaRepo->kota($paket->provinsi_id, 'noajax');
            $tahun_id = Tahuns::where('is_active', Self::Active)->orderBy('tahun', 'ASC')->pluck('tahun', 'id');

            $kualifikasi_id = Kualifikasis::where('is_active', Self::Active)->orderBy('kualifikasi', 'ASC')->pluck('kualifikasi', 'id');
            $mtd_kualifikasi_id = MetodeKualifikasis::where('is_active', Self::Active)->orderBy('metode_kualifikasi', 'ASC')->pluck('metode_kualifikasi', 'id');
            $pemenang_id = Pemenangs::where('is_active', Self::Active)->orderBy('pemenang', 'ASC')->pluck('pemenang', 'id');
            $jeniskontrak_id = JenisKontraks::where('is_active', Self::Active)->orderBy('jeniskontrak', 'ASC')->pluck('jeniskontrak', 'id');
            $sumberdana = Paketanggarans::where('paket_id', Crypt::decrypt($id))->get();
            $lokasi = Paketlokasis::where('paket_id', Crypt::decrypt($id))->get();


            $jenispengadaan = Auth::user()->id_jenis_pengadaan;
            if (!empty($jenispengadaan)) {
                $jenispengadaan_id = JenisPengadaans::where('is_active', Self::Active)->where('id', $jenispengadaan)->orderBy('jenispengadaan', 'ASC')->pluck('jenispengadaan', 'id');
            } else {
                $jenispengadaan_id = JenisPengadaans::where('is_active', Self::Active)->orderBy('jenispengadaan', 'ASC')->pluck('jenispengadaan', 'id');
            }

            $pokja = \App\User::where('role','pokja')->pluck('name','id');
            $pejabat_pengadaan = \App\User::where('role','pejabat_pengadaan')->pluck('name','id');

            $data = [
                'klpd_id' => $klpd_id,
                'satuankerja_id' => $satuankerja_id,
                'provinsi' => $provinsi,
                'kota' => $kota,
                'tahun_id' => $tahun_id,
                'category_id' => $category_id,
                'jenispengadaan_id' => $jenispengadaan_id,
                'kualifikasi_id' => $kualifikasi_id,
                'mtd_kualifikasi_id' => $mtd_kualifikasi_id,
                'pemenang_id' => $pemenang_id,
                'jeniskontrak_id' => $jeniskontrak_id,
                'sumberdana' => $sumberdana,
                'lokasi' => $lokasi,
                'paket' => $paket,
                'pokja_id' => $pokja,
                'pejabat_id' => $pejabat_pengadaan
            ];

            return view('procurement.listpengadaan.send-pic', compact('paket','data'))->withTitle('Tender');
        } catch (\Exception $id) {
            throw $id;
            // return redirect()->route('pakets.index');
        }
    }

    /**
     * store validate 
     *      
     * @param  array  $request
     * @return \Illuminate\Http\Response\Json
    */
    public function proses_send_pic(Request $request)
    {
        // dd($request);
        $message['is_error']   = true;
        $message['error_msg' ] = "";
        $message['success_msg'] = "";

        if( $request->id == "" ) {
            $message['is_error']   = true;
            $message['error_msg'] = "ID not found";
            return response()->json($message, 200);
        } else {
            $paket = Pakets::find($request->id);
            $paket->is_pic = $request->is_pic;
            $paket->pokja_id = $request->pokja_id;
            $paket->pejabat_id = $request->pejabat_id;
            $paket->status_paket = Pakets::PaketSend;

            if( $request->is_pic == Pakets::picPokja ) {
                // $getPokja = \App\User::where('id_jenis_pengadaan', $paket->pokja_id)->get();
                foreach($request->pokja_anggota_id as $k => $row ) {
                    \DB::table('e_paket_approval')->insert([
                        'id' => strtoupper(Uuid::generate()),
                        'paket_id' => $paket->id,
                        'pokja_id' => $request->pokja_anggota_id[$k],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'userid_created' => Auth::user()->name,
                        'userid_updated' => Auth::user()->name
                    ]);
                    //Email ke POJKA
                    $user = \DB::table('users')->where('id','=',$request->pokja_anggota_id[$k])->first();
                    $dataMail= array();
                    $dataMail['title'] = 'Pemberitahuan Inbox Pokja'; 
                    $dataMail['user'] = $user->name; 
                    $dataMail['user_id'] = Auth::user()->id; 
                    $dataMail['message'] = 'Ka ukpbj Menunjuk '.@$user->name.' untuk melaksanakan '.@$paket->nama.' hps : '.$paket->nilai_hps.' <br><br><br>Mohon periksa email anda.<br>Terima kasih';
                    $dataMail['subject'] = 'Pelaksanaan '.$paket->nama;
                    $dataMail['is_read'] = 0;
                    $dataMail['user_to_id'] = $user->id;
                    Einbox::create($dataMail);
                    Mail::to($user->email)->send(new InboxMail($dataMail));
                }
            }
            
            $paket->update();

            $message['is_error']   = false;
            $message['success_msg'] = "Data berhasil disimpan";
        }
        
        return response()->json($message, 200);
    }

    /**
     * show data 
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $paket = Pakets::find(Crypt::decrypt($id));
        $jadwal = PaketJadwalPengadaan::where('paket_id', Crypt::decrypt($id))->first();
        $lembarKualifikasi = PaketLembarKualifikasi::where('paket_id', Crypt::decrypt($id))->first();
        $getFileKak = \App\Models\Procurement\PaketFile::where('tipe',\App\Models\Procurement\PaketFile::FileKak)
            ->where('paket_id', Crypt::decrypt($id))
            ->first();

        $rekanan     = \App\Models\Procurement\PaketRekanan::where('paket_id',Crypt::decrypt($id))->get();
        $getApproval = \DB::table('e_paket_approval')->where('paket_id',Crypt::decrypt($id))
            ->join('users','users.id','=','e_paket_approval.pokja_id')
            ->get();
        $penawaran = \App\Models\Procurement\RekananSubmitPenawaran::where('paket_id',Crypt::decrypt($id))->get();
        $rekananPenawaran = \DB::table('v_penawaran_rekanan')->where('paket_id', Crypt::decrypt($id))->get();
        // $penawaranHarga = \App\Models\Procurement\RekananSubmitPenawaranHarga::where('paket_id',Crypt::decrypt($id))->get();
        // dd($penawaran);
        return view('procurement.listpengadaan.show',compact(
            'paket',
            'jadwal',
            'lembarKualifikasi',
            'getFileKak',
            'rekanan',
            'getApproval',
            'penawaran',
            'rekananPenawaran'
            // 'penawaranHarga'
        ))->withTitle('Detail Paket');
    }

    /**
     * show data 
     * input data kualifikasi
     * 
     * @param  string  $paket_id
     * @return \Illuminate\Http\Response
    */
    public function input_kualifikasi($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));

        return view('procurement.listpengadaan.input-kualifikasi',compact('paket'))->withTitle('Input kualifikasi');
    }

     /**
     * show data 
     * input data kualifikasi
     * 
     * @param  string  $paket_id
     * @return \Illuminate\Http\Response
    */
    public function input_syarat_dokumen($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));

        return view('procurement.listpengadaan.input-syarat-dok',compact('paket'))->withTitle('Input syarat dokumen');
    }

     /**
     * show data 
     * input data kualifikasi
     * 
     * @param  string  $paket_id
     * @return \Illuminate\Http\Response
    */
    public function upload_dok_pemilihan($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));

        return view('procurement.listpengadaan.upload-dok-pemilihan',compact('paket'))->withTitle('Upload dokumen pemilihan');
    }

     /**
     * show data 
     * input data kualifikasi
     * 
     * @param  string  $paket_id
     * @return \Illuminate\Http\Response
    */
    public function pilih_rekanan($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $rekanan = Rekanans::orderBy('mt_jenis_pengadaan_id', 'ASC')->where('is_active',Self::Active) ->get();

        return view('procurement.listpengadaan.pilih-rekanan',compact('paket','rekanan'))->withTitle('Pilih Rekanan');
    }

    /**
     * store masa berlaki
     * @return \Illuminate\Http\Response
    */
    public function store_masa_berlaku(Request $request)
    {
        $message['is_error'] = true;
        $message['error_msg'] = "";

        if( $request->paket_id == "" ) {
            $message['is_error']   = true;
            $message['error_msg'] = "ID not found";
            return response()->json($message, 404);
        } else {
            $request['userid_created'] = Auth::user()->name;
            $request['userid_updated'] = Auth::user()->name;
            \App\Models\Procurement\PaketMasaBerlaku::create($request->all());
            
            $message['is_error']   = false;
            $message['error_msg'] = "";

            return response()->json($message, 200);
        }
    }

    public function store_kualifikasi(Request $request)
    {
        try {
            // dd($request);
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
            \App\Models\Procurement\PaketLembarKualifikasi::create([
                'paket_id' => $request->paket_id,
                'memiliki_npwp' => $request->memiliki_npwp,
                'melunasi_pajak_akhir_tahun' => $request->melunasi_pajak_akhir_tahun,
                'pajak_tahun_terakhir' => $request->pajak_tahun_terakhir,
                'dalam_pengawasan' => $request->dalam_pengawasan,
                'daftar_hitam' => $request->daftar_hitam,
                'pengalaman_kerja' => $request->pengalaman_kerja,
                'pengalaman_kerja_detail' => $request->pengalaman_kerja_detail,
                'tenaga_ahli' => $request->tenaga_ahli ?? 0,
                'tenaga_teknis' => $request->tenaga_teknis ?? 0,
                'kemampuan' => $request->kemampuan ?? 0,
                'userid_created' => Auth::user()->name,
                'userid_updated' => Auth::user()->name
            ]); 

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

            Alert::success('Data berhasil disimpan')->persistent('Ok');
            return redirect()->route('show-paket', ['data'=>Crypt::encrypt($request->paket_id)]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * store masa berlaki
     * @return \Illuminate\Http\Response
    */
    public function store_jadwal_pengadaans(Request $request)
    {
        $message['is_error'] = true;
        $message['error_msg'] = "";
        // dd($request->paket_id);
        if( $request->paket_id == "" ) {
            $message['is_error']   = true;
            $message['error_msg'] = "ID not found";
            return response()->json($message, 404);
        } else {
            $data = [
                'paket_id' => $request->paket_id,
                'dok_penawaran_mulai' => \convert_date_time_picker($request->dok_penawaran_mulai),
                'dok_penawaran_selesai' => \convert_date_time_picker($request->dok_penawaran_selesai),
                'dok_pembukaan_penawaran_mulai' => \convert_date_time_picker($request->dok_pembukaan_penawaran_mulai),
                'dok_pembukaan_penawaran_selesai' => \convert_date_time_picker($request->dok_pembukaan_penawaran_selesai),
                'dok_evaluasi_penawaran_mulai' => \convert_date_time_picker($request->dok_evaluasi_mulai),
                'dok_evaluasi_penawaran_selesai' => \convert_date_time_picker($request->dok_evaluasi_selesai),
                'dok_klarifikasi_teknis_mulai' => \convert_date_time_picker($request->dok_klarifikasi_teknis_mulai),
                'dok_klarifikasi_teknis_selesai' => \convert_date_time_picker($request->dok_klarifikasi_teknis_selesai),
                'dok_ttd_kontrak_mulai' => \convert_date_time_picker($request->dok_ttd_kontrak_mulai),
                'dok_ttd_kontrak_selesai' => \convert_date_time_picker($request->dok_ttd_kontrak_selesai)
            ];
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;
            \App\Models\Procurement\PaketJadwalPengadaan::create($data);
            
            $message['is_error']   = false;
            $message['error_msg'] = "";

            return response()->json($message, 200);
        }
    }


    /**
     * store dokumen pemilihan
     * @return \Illuminate\Http\Response
    */
    public function store_dokumen_pemilihan(Request $request)
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
        return redirect()->route('show-paket', ['data'=>Crypt::encrypt($request->paket_id)]);
    }

    public function store_syarat_dokumen(Request $request)
    {
        \App\Models\Procurement\PaketSyaratDokumen::create($request->all());

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('show-paket', ['data'=>Crypt::encrypt($request->paket_id)]);
    }

    /**
     * store pemilihan rekanan
     * @return \Illuminate\Http\Response
    */
    public function store_pemilihan_rekanan(Request $request)
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
        return redirect()->route('show-paket', ['data'=>Crypt::encrypt($request->paket_id)]); 
    }

    /**
     * store pemilihan rekanan
     * @return \Illuminate\Http\Response
    */
    public function store_approval(Request $request)
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
            } else {
                \DB::table('e_paket_approval')->where('paket_id',$request->paket_id)
                    ->where('pokja_id',Auth::user()->id)
                    ->update([
                        'status'        => Pakets::Reject,
                        'approval_date' => date('Y-m-d H:i:s'),
                        'reason'        => $request->reason
                    ]);
            }

            $message['is_error']   = false;
            $message['success_msg'] = "Data berhasil disimpan";
        }


        return response()->json($message, 200);
    }

     /**
     * Dispaly detail harga penawaran
     * @param string $paket_id
     * @param string $rekanan_id
     * @return \Illuminate\Http\Response
    */
    public function detailhargapenawaran($paket_id,$rekanan_id)
    {
        $paket = Pakets::find($paket_id);
        $penawaran = \App\Models\Procurement\RekananSubmitHargaPenawaran::where('paket_id',$paket_id)
            ->where('mt_rekanan_id', $rekanan_id)
            ->get();
        $rekanan = \App\Models\Procurement\Rekanans::find($rekanan_id);

        return view('procurement.listpengadaan.detail-harga-penawaran',compact('penawaran','paket','rekanan'))->withTitle('Detail penawaran');
    }

    /**
     * Dispaly detail surat
     * @param string $paket_id
     * @param string $rekanan_id
     * @return \Illuminate\Http\Response
    */
    public function detailsuratpenawaran($paket_id,$rekanan_id)
    {
        $penawaran = \App\Models\Procurement\RekananSubmitPenawaran::where('paket_id',$paket_id)
            ->where('mt_rekanan_id', $rekanan_id)
            ->get();
        $paket = Pakets::find($paket_id);
        $rekanan = \App\Models\Procurement\Rekanans::find($rekanan_id);

        return view('procurement.listpengadaan.detail-surat-penawaran',compact('penawaran','rekanan','paket'))->withTitle('Detail penawaran');
    }

    public function detailkualifikasi($paket_id,$rekanan_id)
    {
        $ijinUsaha = \App\Models\Webprofile\Ijinusahas::where('mt_rekanan_id' ,$rekanan_id)
            ->get();
        $pajak = \App\Models\Webprofile\Pajaks::where('mt_rekanan_id' ,$rekanan_id)
            ->get();
        $akta = \App\Models\Webprofile\Aktas::where('mt_rekanan_id' ,$rekanan_id)
            ->first();

        $pengalaman = \App\Models\Webprofile\Pengalamans::where('mt_rekanan_id' ,$rekanan_id)
            ->get();

        $peralatans = \App\Models\Webprofile\Peralatans::where('mt_rekanan_id' ,$rekanan_id)
            ->get();

        $tenagaahli = \App\Models\Webprofile\TenagaAhlis::where('mt_rekanan_id' ,$rekanan_id)
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
        
        $penawaran = \App\Models\Procurement\RekananSubmitPenawaran::where('paket_id',$paket_id)
            ->where('mt_rekanan_id', $rekanan_id)
            ->get();
        $paket = Pakets::find($paket_id);
        $rekanan = \App\Models\Procurement\Rekanans::find($rekanan_id);
        

        return view('procurement.listpengadaan.detail-kualifikasi',
            compact(
                'penawaran',
                'rekanan',
                'paket',
                'ijinUsaha',
                'pajak',
                'akta',
                'pengalaman',
                'peralatans',
                'tenagaahli',
            ))->withTitle('Detail penawaran');
    }

    public function penetapanPemenang($paket_id)
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
                    // dd($rekanan);

        return view('procurement.listpengadaan.penetapan-pemenang',compact('paket','rekanan'))->withTitle('Penetapan Pemenang');
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
        return redirect()->route('show-paket', ['data'=>Crypt::encrypt($request->paket_id)]); 
    }
}