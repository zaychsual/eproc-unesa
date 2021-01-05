<?php

namespace App\Http\Controllers\Procurement\tender;

use App\Models\Procurement\Pakets;
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
use App\Models\Procurement\Einbox;
use Illuminate\Http\Request;
use App\Models\Procurement\ValidasiPaket;
use App\Http\Controllers\Controller;
use App\Models\Procurement\Rekanans;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;
use App\Repositories\ProvinsiRepository;
use App\Repositories\KotaRepository;
use App\Repositories\PaketRepository;
use Storage;
use User;
use App\Mail\InboxMail;
use Mail;

class PaketsController extends Controller
{
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

    public const FileKak = 10;
    public const FileRancangan = 20;
    public const FileDukungDataHps = 30;
    public const Active = 1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $jenispengadaan = Auth::user()->id_jenis_pengadaan;

        if (!empty($jenispengadaan)) {
            $data  = Pakets::orderBy('created_at', 'DESC')->where('jenispengadaan_id', $jenispengadaan)->get();
        } else {
            $data  = Pakets::orderBy('created_at', 'DESC')->get();
        }

        return view('procurement.pakets.index', compact('data'))->withTitle('Daftar Paket');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) 
    {
        $klpd_id = Klpds::where('is_active', Self::Active)->orderBy('klpd', 'ASC')->pluck('klpd', 'id');
        $satuankerja_id = SatuanKerjas::where('is_active', Self::Active)->orderBy('satuankerja', 'ASC')->pluck('satuankerja', 'id');
        $provinsi = $this->ProvinsiRepo->provinsi('noajax');
        $tahun_id = Tahuns::where('is_active', Self::Active)->orderBy('tahun', 'ASC')->pluck('tahun', 'id');
        $kualifikasi_id = Kualifikasis::where('is_active', Self::Active)->orderBy('kualifikasi', 'ASC')->pluck('kualifikasi', 'id');
        $mtd_kualifikasi_id = MetodeKualifikasis::where('is_active', Self::Active)->orderBy('metode_kualifikasi', 'ASC')->pluck('metode_kualifikasi', 'id');
        $pemenang_id = Pemenangs::where('is_active', Self::Active)->orderBy('pemenang', 'ASC')->pluck('pemenang', 'id');
        $jeniskontrak_id = JenisKontraks::where('is_active', Self::Active)->orderBy('jeniskontrak', 'ASC')->pluck('jeniskontrak', 'id');
        $category = \DB::table('e_paket_category')->pluck('name', 'id');
        $rekanan_id = Rekanans::where('is_active', Self::Active)->orderBy('nama', 'ASC')->pluck('nama', 'id');


        $jenispengadaan = Auth::user()->id_jenis_pengadaan;
        if (!empty($jenispengadaan)) {
            $jenispengadaan_id = JenisPengadaans::where('is_active', Self::Active)->where('id', $jenispengadaan)->orderBy('jenispengadaan', 'ASC')->pluck('jenispengadaan', 'id');
        } else {
            $jenispengadaan_id = JenisPengadaans::where('is_active', Self::Active)->orderBy('jenispengadaan', 'ASC')->pluck('jenispengadaan', 'id');
        }

        $isPaket = $request->get('is_paket');
        $pejabat_pengadaan = \App\User::where('role','pejabatpengadaan')->pluck('name','id');
        $data = [
            'klpd_id' => $klpd_id,
            'satuankerja_id' => $satuankerja_id,
            'provinsi' => $provinsi,
            'tahun_id' => $tahun_id,
            'jenispengadaan_id' => $jenispengadaan_id,
            'kualifikasi_id' => $kualifikasi_id,
            'mtd_kualifikasi_id' => $mtd_kualifikasi_id,
            'pemenang_id' => $pemenang_id,
            'jeniskontrak_id' => $jeniskontrak_id,
            'category'  => $category,
            'is_paket' => $isPaket,
            'pejabat_id' => $pejabat_pengadaan,
            'rekanan_id' => $rekanan_id
        ];
        
        if( $isPaket == 'tender' ) {
            return view('procurement.pakets.create-tender', compact('data'))->withTitle('Create Paket Tender');
        } else if( $isPaket == 'pembelianlangsung' ) {
            return view('procurement.pakets.create-pembelianlangsung', compact('data'))->withTitle('Create Paket Pembelian Langsung');
        } else if( $isPaket == 'epurchasing' ) {
            return view('procurement.pakets.create-epurchasing', compact('data'))->withTitle('Create Paket Epurchasing');
        } else if( $isPaket == 'quotation' ) {
            return view('procurement.pakets.create-quotation', compact('data'))->withTitle('Create Paket quotation');
        } else if( $isPaket == 'penunjukanlangsung' ) {
            return view('procurement.pakets.create-penunjukanlangsung', compact('data'))->withTitle('Create Paket penunjukan langsung');
        } else if( $isPaket == 'pembelianbarangbekas' ) {
            return view('procurement.pakets.create-pembelianbarangbekas', compact('data'))->withTitle('Create Paket pembelian barang bekas');
        }
    }

    public function showSPK()
    {   
        $klpd_id = Klpds::where('is_active', Self::Active)->orderBy('klpd', 'ASC')->pluck('klpd', 'id');
        $satuankerja_id = SatuanKerjas::where('is_active', Self::Active)->orderBy('satuankerja', 'ASC')->pluck('satuankerja', 'id');
        $provinsi = $this->ProvinsiRepo->provinsi('noajax');
        $tahun_id = Tahuns::where('is_active', Self::Active)->orderBy('tahun', 'ASC')->pluck('tahun', 'id');
        $kualifikasi_id = Kualifikasis::where('is_active', Self::Active)->orderBy('kualifikasi', 'ASC')->pluck('kualifikasi', 'id');
        $mtd_kualifikasi_id = MetodeKualifikasis::where('is_active', Self::Active)->orderBy('metode_kualifikasi', 'ASC')->pluck('metode_kualifikasi', 'id');
        $pemenang_id = Pemenangs::where('is_active', Self::Active)->orderBy('pemenang', 'ASC')->pluck('pemenang', 'id');
        $jeniskontrak_id = JenisKontraks::where('is_active', Self::Active)->orderBy('jeniskontrak', 'ASC')->pluck('jeniskontrak', 'id');
        $category = \DB::table('e_paket_category')->pluck('name', 'id');
        $rekanan_id = Rekanans::where('is_active', Self::Active)->orderBy('nama', 'ASC')->pluck('nama', 'id');

        $jenispengadaan = Auth::user()->id_jenis_pengadaan;
        if (!empty($jenispengadaan)) {
            $jenispengadaan_id = JenisPengadaans::where('is_active', Self::Active)->where('id', $jenispengadaan)->orderBy('jenispengadaan', 'ASC')->pluck('jenispengadaan', 'id');
        } else {
            $jenispengadaan_id = JenisPengadaans::where('is_active', Self::Active)->orderBy('jenispengadaan', 'ASC')->pluck('jenispengadaan', 'id');
        }


        $data = [
            'klpd_id' => $klpd_id,
            'satuankerja_id' => $satuankerja_id,
            'provinsi' => $provinsi,
            'tahun_id' => $tahun_id,
            'rekanan_id' => $rekanan_id,
            'jenispengadaan_id' => $jenispengadaan_id,
            'kualifikasi_id' => $kualifikasi_id,
            'mtd_kualifikasi_id' => $mtd_kualifikasi_id,
            'pemenang_id' => $pemenang_id,
            'jeniskontrak_id' => $jeniskontrak_id,
            'category'  => $category
        ];
        // return view('procurement.pakets.try');
        return view('procurement.pakets.spk.create', compact('data'))->withTitle('SPK');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, Pakets::$rules, Pakets::$errormessage);

        $getMax = $this->PaketRepo->getMax();
        // dd(Storage::disk('uploads'));
        if ($validator->fails()) {
            $errormessage = $validator->messages();

            return redirect()->route('pakets.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $uuid = Uuid::generate();
            $getMax = $this->PaketRepo->getMax();
            if ($request->hasFile('link_file_dok_pengadaan')) {
                $newFilename = "";
                $newExtension = "";
                $newSizeDok = "";
                for ($i = 0; $i < count($request['link_file_dok_pengadaan']); $i++) {
                    $cover = $request->file('link_file_dok_pengadaan')[$i];
                    $extension = $cover->guessClientExtension();
                    $size_dok = $cover->getSize();
                    $filename = $uuid . '-' . $i . '.' . $extension;
                    // sementara
                    // Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/dok_pengadaan/' . $filename, file_get_contents($cover->getRealPath()));

                    if ($i == 0) {
                        $newFilename = $filename;
                        $newExtension = $extension;
                        $newSizeDok = $size_dok;
                    } else {
                        $newFilename = $newFilename . '###' . $filename;
                        $newExtension = $newExtension . '###' . $extension;
                        $newSizeDok = $newSizeDok . '###' . $size_dok;
                    }
                }

                $data['link_file_dok_pengadaan'] = $newFilename;
                $data['tipe_file_dok'] = $newExtension;
                $data['ukuran_file_dok'] = $newSizeDok;
            }

            if ($request->hasFile('link_file_syarat_pengadaan')) {
                $newFilename = "";
                $newExtension = "";
                $newSizeDok = "";
                for ($i = 0; $i < count($request['link_file_syarat_pengadaan']); $i++) {
                    $cover = $request->file('link_file_syarat_pengadaan')[$i];
                    $extension_syarat = $cover->guessClientExtension();
                    $size_syarat = $cover->getSize();
                    $filename = $uuid . '-' . $i . '.' . $extension_syarat;
                     // sementara
                    // Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/syarat_pengadaan/' . $filename, file_get_contents($cover->getRealPath()));

                    if ($i == 0) {
                        $newFilename = $filename;
                        $newExtension = $extension_syarat;
                        $newSizeDok = $size_syarat;
                    } else {
                        $newFilename = $newFilename . '###' . $filename;
                        $newExtension = $newExtension . '###' . $extension_syarat;
                        $newSizeDok = $newSizeDok . '###' . $size_syarat;
                    }
                }

                $data['link_file_syarat_pengadaan'] = $newFilename;
                $data['tipe_file_syarat'] = $newExtension;
                $data['ukuran_file_syarat'] = $newSizeDok;
            }

            $data['id'] = $uuid;
            $data['kode'] = $getMax;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;
            // $data['category_id']    = $request->category_id;

            $id = Pakets::create($data)->id;

            logApp('create', 'Membuat paket dengan nama ' . $data['nama'] . ' dengan anggaran ' . $data['pagu']);

            $sumber_dana = $data['sumber_dana'];
            $kode_anggaran = $data['kode_anggaran'];
            $nilai = $data['nilai'];
            for ($i = 0; $i < count($sumber_dana); ++$i) {
                if ($sumber_dana[$i] == '') { } else {
                    $uuidSumberdana = Uuid::generate();
                    $dataSumberdana['id'] = $uuidSumberdana;
                    $dataSumberdana['paket_id'] = $id;
                    $dataSumberdana['sumber_dana'] = $sumber_dana[$i];
                    $dataSumberdana['kode_anggaran'] = $kode_anggaran[$i];
                    $dataSumberdana['nilai'] = $nilai[$i];
                    $dataSumberdana['userid_created'] = Auth::user()->name;
                    Paketanggarans::create($dataSumberdana);
                    logApp('create', 'Sumber dana ' . $sumber_dana[$i] . ' dengan kode anggaran ' . $kode_anggaran[$i] . ' dengan anggaran ' . $nilai[$i]);
                }
            }

            $provinsi_id = $data['provinsi_id'];
            $kota_id = $data['kota_id'];
            $alamat = $data['alamat'];
            for ($i = 0; $i < count($provinsi_id); ++$i) {
                if ($provinsi_id[$i] == '') { } else {
                    $uuidLokasi = Uuid::generate();
                    $datalokasi['id'] = $uuidLokasi;
                    $datalokasi['paket_id'] = $id;
                    $datalokasi['provinsi_id'] = $provinsi_id[$i];
                    $datalokasi['kota_id'] = $kota_id[$i];
                    $datalokasi['alamat'] = $alamat[$i];
                    $datalokasi['userid_created'] = Auth::user()->name;
                    Paketlokasis::create($datalokasi);
                    logApp('create', 'Lokasi dengan kode provinsi ' . $provinsi_id[$i] . ', kode kota ' . $kota_id[$i] . ', alamat ' . $alamat[$i]);
                }
            }

            if( $request->has('jenis_barang_jasa') ) {
                foreach( $data['jenis_barang_jasa'] as $key => $value ) {
                    \App\Models\Procurement\PaketDetailHps::create([
                        'paket_id'          => $id,
                        'jenis_barang_jasa' => $value,
                        'satuan'            => $data['satuan'][$key],
                        'qty'               => $data['qty'][$key],
                        'harga'             => $data['harga'][$key],
                        'pajak'             => $data['pajak'][$key],
                        'keterangan'        => $data['keterangan'][$key],
                        'userid_created'    => Auth::user()->name
                    ]);
                }
            }

            //jika dia pembelian langsung trus pilih rekanan
            if( $request->has('rekanan_id') ) {
                \App\Models\Procurement\PaketRekanan::create([
                    'paket_id'          => $id,
                    'mt_rekanan_id'     => $request->rekanan_id,
                    'is_winner'         => \App\Models\Procurement\PaketRekanan::Pemenang,
                    'userid_created'    => Auth::user()->name,
                    'userid_updated'    => Auth::user()->name,
                    'status'            => Self::Active
                ]);
            }

            if ($request->hasFile('files_kak')) {
                $newFilename = "";
                $newExtension = "";
                $newSizeDok = "";

                $file = $request->file('files_kak');
                $ext = $file->getClientOriginalExtension();
                $newFilename = rand(100000,1001238912).".".$ext;
                $file->move('uploads/file',$newFilename);
            
                $newExtension = 0;
                $newSizeDok   = 0;

                // sementara
                // Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/dok_pengadaan/' . $filename, file_get_contents($cover->getRealPath()));

                \App\Models\Procurement\PaketFile::create([
                    'files' => $newFilename,
                    'paket_id' => $id,
                    'tipe_file_dok' => $newExtension,
                    'tanggal_upload' => $request->tanggal_upload_kak,
                    'ukuran_file_dok' => $newSizeDok,
                    'userid_created'    => Auth::user()->name,
                    'tipe'      => Self::FileKak
                ]);
            }

            if ($request->hasFile('files_rancangan_kontrak')) {
                $newFilename = "";
                $newExtension = "";
                $newSizeDok = "";
                $file = $request->file('files_rancangan_kontrak');
                $ext = $file->getClientOriginalExtension();
                $newFilename = rand(100000,1001238912).".".$ext;
                $file->move('uploads/file',$newFilename);
            
                $newExtension = 0;
                $newSizeDok   = 0;


                \App\Models\Procurement\PaketFile::create([
                    'files' => $newFilename,
                    'paket_id' => $id,
                    'tipe_file_dok' => $newExtension,
                    'tanggal_upload' => $request->tanggal_upload_rancangan,
                    'ukuran_file_dok' => $newSizeDok,
                    'userid_created'    => Auth::user()->name,
                    'tipe'      => Self::FileRancangan
                ]);
            }

            if ($request->hasFile('files_data_dukung')) {
                $newFilename = "";
                $newExtension = "";
                $newSizeDok = "";

                $file = $request->file('files_data_dukung');
                $ext = $file->getClientOriginalExtension();
                $newFilename = rand(100000,1001238912).".".$ext;
                $file->move('uploads/file',$newFilename);
                $newExtension = 0;
                $newSizeDok   = 0;

                \App\Models\Procurement\PaketFile::create([
                    'files' => $newFilename,
                    'paket_id' => $id,
                    'tipe_file_dok' => $newExtension,
                    'ukuran_file_dok' => $newSizeDok,
                    'tanggal_upload' => $request->tanggal_upload_data_dukung,
                    'userid_created'    => Auth::user()->name,
                    'tipe'      => Self::FileDukungDataHps
                ]);
            }

            //Email ke KAUKPBJ

            $dataPaket = Pakets::find($id);
            $user = \DB::table('users')->where('role','=','kaukpbj')->first();
            $dataMail= array();
            $dataMail['title'] = 'Pemberitahuan Kepala UKPBJ'; 
            $dataMail['user'] = 'Kepala UKPBJ'; 
            $dataMail['user_id'] = Auth::user()->id; 
            $dataMail['message'] = Auth::user()->name.' dengan paket :  '.$dataPaket->nama.' Hps :  '.$dataPaket->nilai_hps.' & Kode '.$dataPaket->kode_rup.'. Mohon agar dilakukan pokja<br>pemilihan.<br><br><br>Terima kasih';
            $dataMail['subject'] = 'Pemilihan Pokja '.$dataPaket->nama;
            $dataMail['is_read'] = 0;
            $dataMail['user_to_id'] = $user->id;
            Einbox::create($dataMail);
            Mail::to($user->email)->send(new InboxMail($dataMail));

            Alert::success('Paket berhasil disimpan')->persistent('Ok');

            $successmessage = 'Proses Tambah Paket Berhasil !!';

            return redirect()->route('pakets.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Info $info
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Info $info)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Info $info
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $paket = Pakets::find(Crypt::decrypt($id));

            $klpd_id = Klpds::where('is_active', Self::Active)->orderBy('klpd', 'ASC')->pluck('klpd', 'id');
            $satuankerja_id = SatuanKerjas::where('is_active', Self::Active)->orderBy('satuankerja', 'ASC')->pluck('satuankerja', 'id');
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

            $data = [
                'klpd_id' => $klpd_id,
                'satuankerja_id' => $satuankerja_id,
                'provinsi' => $provinsi,
                'kota' => $kota,
                'tahun_id' => $tahun_id,
                'jenispengadaan_id' => $jenispengadaan_id,
                'kualifikasi_id' => $kualifikasi_id,
                'mtd_kualifikasi_id' => $mtd_kualifikasi_id,
                'pemenang_id' => $pemenang_id,
                'jeniskontrak_id' => $jeniskontrak_id,
                'sumberdana' => $sumberdana,
                'lokasi' => $lokasi,
                'paket' => $paket,
            ];

            return view('procurement.pakets.edit', compact('paket', 'data'))->withTitle('Tender');
        } catch (\Exception $id) {
            return redirect()->route('pakets.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Info         $info
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, Pakets::$rules, Pakets::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pakets = Pakets::findOrFail($id);

        if ($request->hasFile('link_file_dok_pengadaan')) {
            $newFilename = "";
            $newExtension = "";
            $newSizeDok = "";
            for ($i = 0; $i < count($request['link_file_dok_pengadaan']); $i++) {
                $cover = $request->file('link_file_dok_pengadaan')[$i];
                $extension = $cover->guessClientExtension();
                $size_dok = $cover->getSize();
                $filename = $id . '-' . $i . '.' . $extension;

                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/dok_pengadaan/' . $filename, file_get_contents($cover->getRealPath()));

                if ($i == 0) {
                    $newFilename = $filename;
                    $newExtension = $extension;
                    $newSizeDok = $size_dok;
                } else {
                    $newFilename = $newFilename . '###' . $filename;
                    $newExtension = $newExtension . '###' . $extension;
                    $newSizeDok = $newSizeDok . '###' . $size_dok;
                }
            }

            $data['link_file_dok_pengadaan'] = $newFilename;
            $data['tipe_file_dok'] = $newExtension;
            $data['ukuran_file_dok'] = $newSizeDok;
        }

        if ($request->hasFile('link_file_syarat_pengadaan')) {
            $newFilename = "";
            $newExtension = "";
            $newSizeDok = "";
            for ($i = 0; $i < count($request['link_file_syarat_pengadaan']); $i++) {
                $cover = $request->file('link_file_syarat_pengadaan')[$i];
                $extension_syarat = $cover->guessClientExtension();
                $size_syarat = $cover->getSize();
                $filename = $pakets->$id . '-' . $i . '.' . $extension_syarat;

                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/syarat_pengadaan/' . $filename, file_get_contents($cover->getRealPath()));

                if ($i == 0) {
                    $newFilename = $filename;
                    $newExtension = $extension_syarat;
                    $newSizeDok = $size_syarat;
                } else {
                    $newFilename = $newFilename . '###' . $filename;
                    $newExtension = $newExtension . '###' . $extension_syarat;
                    $newSizeDok = $newSizeDok . '###' . $size_syarat;
                }
            }

            $data['link_file_syarat_pengadaan'] = $newFilename;
            $data['tipe_file_syarat'] = $newExtension;
            $data['ukuran_file_syarat'] = $newSizeDok;
        }

        $data['userid_updated'] = Auth::user()->name;
        $pakets->update($data);
        //dd($data);
        $sumber_dana = $data['sumber_dana'];
        $kode_anggaran = $data['kode_anggaran'];
        $nilai = $data['nilai'];
        for ($i = 0; $i < count($sumber_dana); ++$i) {
            if ($sumber_dana[$i] == '') { } else {
                $dataSumberdana['paket_id'] = $id;
                $dataSumberdana['sumber_dana'] = $sumber_dana[$i];
                $dataSumberdana['kode_anggaran'] = $kode_anggaran[$i];
                $dataSumberdana['nilai'] = $nilai[$i];
                $dataSumberdana['userid_created'] = Auth::user()->name;
                Paketanggarans::updateOrCreate(
                    [
                        'paket_id' => $dataSumberdana['paket_id'],
                        'sumber_dana' => $dataSumberdana['sumber_dana'],
                        'kode_anggaran' => $dataSumberdana['kode_anggaran'],
                    ],
                    $dataSumberdana
                );
            }
        }

        $provinsi_id = $data['provinsi_id'];
        $kota_id = $data['kota_id'];
        $alamat = $data['alamat'];
        for ($i = 0; $i < count($provinsi_id); ++$i) {
            if ($provinsi_id[$i] == '') { } else {
                $datalokasi['paket_id'] = $id;
                $datalokasi['provinsi_id'] = $provinsi_id[$i];
                $datalokasi['kota_id'] = $kota_id[$i];
                $datalokasi['alamat'] = $alamat[$i];
                $datalokasi['userid_created'] = Auth::user()->name;
                Paketlokasis::updateOrCreate(
                    [
                        'paket_id' => $datalokasi['paket_id'],
                    ],
                    $datalokasi
                );
            }
        }

        Alert::success('Data berhasil diubah')->persistent('Ok');

        return redirect()->route('pakets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Info $info
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Pakets::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));
            Paketlokasis::where('paket_id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));
            Paketanggarans::where('paket_id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('pakets.index');
        } catch (\Exception $id) {
            return redirect()->route('pakets.index');
        }
    }

    public function lokasiPage()
    {
        $provinsi = $this->ProvinsiRepo->provinsi('noajax');
        $data = [
            'provinsi' => $provinsi,
        ];

        return view('procurement.pakets.lokasi', compact('data'));
    }

    /*
    * init save file 
    */
    private function _save_file($datas = [])
    {
        if( $datas->hasFile('files_kak') ) {

        }
    }

    /* 
       * Tambah Belilangsung 
     */
    public function beliLangsung()
    {

        $klpd_id = Klpds::where('is_active', Self::Active)->orderBy('klpd', 'ASC')->pluck('klpd', 'id');
        $satuankerja_id = SatuanKerjas::where('is_active', Self::Active)->orderBy('satuankerja', 'ASC')->pluck('satuankerja', 'id');
        $provinsi = $this->ProvinsiRepo->provinsi('noajax');
        $tahun_id = Tahuns::where('is_active', Self::Active)->orderBy('tahun', 'ASC')->pluck('tahun', 'id');
        $kualifikasi_id = Kualifikasis::where('is_active', Self::Active)->orderBy('kualifikasi', 'ASC')->pluck('kualifikasi', 'id');
        $mtd_kualifikasi_id = MetodeKualifikasis::where('is_active', Self::Active)->orderBy('metode_kualifikasi', 'ASC')->pluck('metode_kualifikasi', 'id');
        $pemenang_id = Pemenangs::where('is_active', Self::Active)->orderBy('pemenang', 'ASC')->pluck('pemenang', 'id');
        $jeniskontrak_id = JenisKontraks::where('is_active', Self::Active)->orderBy('jeniskontrak', 'ASC')->pluck('jeniskontrak', 'id');
        $category = \DB::table('e_paket_category')->pluck('name', 'id');
        $rekanan_id = Rekanans::where('is_active', Self::Active)->orderBy('nama', 'ASC')->pluck('nama', 'id');

        $jenispengadaan = Auth::user()->id_jenis_pengadaan;
        if (!empty($jenispengadaan)) {
            $jenispengadaan_id = JenisPengadaans::where('is_active', Self::Active)->where('id', $jenispengadaan)->orderBy('jenispengadaan', 'ASC')->pluck('jenispengadaan', 'id');
        } else {
            $jenispengadaan_id = JenisPengadaans::where('is_active', Self::Active)->orderBy('jenispengadaan', 'ASC')->pluck('jenispengadaan', 'id');
        }


        $data = [
            'klpd_id' => $klpd_id,
            'satuankerja_id' => $satuankerja_id,
            'provinsi' => $provinsi,
            'tahun_id' => $tahun_id,
            'jenispengadaan_id' => $jenispengadaan_id,
            'kualifikasi_id' => $kualifikasi_id,
            'rekanan_id'   => $rekanan_id,
            'mtd_kualifikasi_id' => $mtd_kualifikasi_id,
            'pemenang_id' => $pemenang_id,
            'jeniskontrak_id' => $jeniskontrak_id,
            'category'  => $category
        ];

        return view('procurement.pakets.beli-langsung.create', compact('data'))->withTitle('Pembelian Langsung');
    }

    public function paketPengecekan($paket_id)
    {
        return view('procurement.pakets.detail-pengecekan')->withTitle('pengecekan paket');
    }
}
