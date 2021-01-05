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
use App\Models\Procurement\PaketDokumenPenawarans;
use App\Models\Procurement\EkontrakUndangan;
use App\Models\Webprofile\BentukUsahas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;
use Redirect,PDF;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ProvinsiRepository;
use App\Repositories\RekananRepository;

class PembelianBarangBekasController extends Controller
{
    const PokjaApproved = 1;
    public const Administrasi = 1;
    public const Kualifikasi = 2;
    public const Teknis = 3;
    public const Harga = 4;
    const Active = 1;

    private $ProvinsiRepo;

    public function __construct(
        ProvinsiRepository $ProvinsiRepo,
        RekananRepository $RekananRepo
    ) {
        $this->ProvinsiRepo = $ProvinsiRepo;
        $this->RekananRepo = $RekananRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       
    }

    /**
     * create pembelian langsung [pp]
     * @author didi gantengs
     */
    public function create($paket_id)
    {
        $rekananPenawaran   = \DB::table('v_new_penawaran_rekanan')->where('paket_id', Crypt::decrypt($paket_id))->get();
        // dd($rekananPenawaran);
        $bap                = \App\Models\Procurement\Ebap::where('paket_id',Crypt::decrypt($paket_id))->first();
        $paket              = Pakets::find(Crypt::decrypt($paket_id));
        $rekanan            = \App\Models\Procurement\PaketRekanan::where('paket_id',Crypt::decrypt($paket_id))->first();
        $penawaran          = \App\Models\Procurement\RekananSubmitPenawaran::where('paket_id',Crypt::decrypt($paket_id))->get();

        return view('procurement.pembelianbarangbekas.create',compact(
            'paket',
            'rekanan',
            'penawaran',
            'rekananPenawaran',
            'bap'
        ))
        ->withTitle('Pembelian barang bekas');
    }
    
    /**
     * Pilih rekanan
     * 
     * @param  string  $paket_id
     * @return \Illuminate\Http\Response
     * @author didi gantengs
    */
    public function createRekanan($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $rekanan = Rekanans::orderBy('mt_jenis_pengadaan_id', 'ASC')->where('is_active',Self::Active) ->get();

        return view('procurement.pembelianbarangbekas.create-rekanan',compact('paket','rekanan'))->withTitle('Pilih Rekanan');
    }

    /**
     * input rekanan
     * @param  string  $paket_id
     * @return \Illuminate\Http\Response
     * @author didi gantengs
    */
    public function createRekananInput($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $bentuk_usaha = BentukUsahas::pluck('name', 'id');
        $jenis_pengadaan = JenisPengadaans::pluck('jenispengadaan', 'id');

        $provinsi = $this->ProvinsiRepo->provinsi('noajax');
        $paketHps = \App\Models\Procurement\PaketDetailHps::where('paket_id', Crypt::decrypt($paket_id))->get();

        $data = [
            'bentuk_usaha' => $bentuk_usaha,
            'jenis_pengadaan' => $jenis_pengadaan,
            'provinsi' => $provinsi,
        ];

        return view('procurement.pembelianbarangbekas.create-rekanan-input',compact('paket','data','paketHps'))->withTitle('Pilih Rekanan');
    }

    /**
     * create negoisasi
     * fitur ini jika dbutuhkan saja
     * @return \Illuminate\Http\Response
     * @param string $paket_id
     * @author didi gantengs
    */
    public function createNegoisasi($paket_id, $rekanan_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));

        $paketHps = \App\Models\Procurement\PaketDetailHps::where('paket_id', Crypt::decrypt($paket_id))->get();

        return view('procurement.pembelianbarangbekas.create-negoisasi',compact('paket','paketHps','rekanan_id'))->withTitle('Input Negoisasi');
    }

     /**
     * create evaluasi
     * fitur ini jika dbutuhkan saja
     * @return \Illuminate\Http\Response
     * @param string $paket_id
     * @author didi gantengs
    */
    public function createEvaluasi($paket_id, $rekanan_id)
    {
        $paket      = Pakets::find($paket_id);
        $paketDok   = \App\Models\Procurement\PaketDokumenPenawarans::where('paket_id', $paket_id)
                    ->join('mt_dokumen_penawaran','mt_dokumen_penawaran.id','=','e_paket_dokumen_penawaran.mt_dokumen_penawaran_id')
                    ->get();
        // dd($paketDok);
        $rekanan    = \App\Models\Procurement\Rekanans::find($rekanan_id);

        return view('procurement.pembelianbarangbekas.evaluasi',compact('paket','paketDok','rekanan'))->withTitle('Input Evaluasi');
    }

     /**
     * create ba negoisasi
     * fitur ini jika dbutuhkan saja
     * @return \Illuminate\Http\Response
     * @param string $paket_id
     * @author didi gantengs
    */
    public function createBaNegoisasi($paket_id)
    {
        $paket      = Pakets::find(Crypt::decrypt($paket_id));
        $paketRekanan = \App\Models\Procurement\PaketRekanan::where('paket_id', Crypt::decrypt($paket_id))
            ->where('is_winner', \App\Models\Procurement\PaketRekanan::Pemenang)
            ->first();

        return view('procurement.pembelianbarangbekas.create-bap-negoisasi',compact('paket','paketRekanan'))->withTitle('Buat Berita Acara Negoisasi');
    }

    /**
     * create klarifikasi
     * fitur ini jika dbutuhkan saja
     * @return \Illuminate\Http\Response
     * @param string $paket_id
     * @author didi gantengs
    */
    public function createKlarifikasi($paket_id)
    {
        $barangBekas = 3;
        $paket      = Pakets::find(Crypt::decrypt($paket_id));
        $klarifikasi = \App\Models\Procurement\Klarifikasi::where('is_metode', $barangBekas)->get();

        return view('procurement.pembelianbarangbekas.create-klarifikasi',compact('paket','klarifikasi'))->withTitle('Klarifikasi');
    }

    /**
     * create klarifikasi
     * fitur ini jika dbutuhkan saja
     * @return \Illuminate\Http\Response
     * @param string $paket_id
     * @author didi gantengs
    */
    public function viewKlarifikasi($paket_id)
    {
        $klarifikasi = \App\Models\Procurement\EKlarifikasi::where('paket_id', Crypt::decrypt($paket_id))->get();

        return view('procurement.pembelianbarangbekas.view-klarifikasi',compact('klarifikasi'))->withTitle('Klarifikasi');
    }


    /**
     * store pemilihan rekanan
     * @return \Illuminate\Http\Response
     * @author didi gantengs
    */
    public function storePemilihanRekanan(Request $request)
    {
        if( $request->has('rekanan_id') ) {
            foreach( $request->rekanan_id as $key => $rows ) {
                \App\Models\Procurement\PaketRekanan::create([
                    'paket_id'          => $request->paket_id,
                    'mt_rekanan_id'     => $rows,
                    'is_winner'         => \App\Models\Procurement\PaketRekanan::Pemenang, //ini doi menang
                    'status'            => \App\Models\Procurement\PaketRekanan::Pemenang,
                    'userid_created'    => Auth::user()->name,
                    'userid_updated'    => Auth::user()->name,
                ]);
            }
        }

        \App\Models\Procurement\Pakets::where('id', $request->paket_id)
            ->update([
                'is_dpt' => $request->is_dpt,
                'is_public' => \App\Models\Procurement\Pakets::PublishPaket
            ]);

        $dokBarangBekas = 3;
        $tipeDok        = 3;
        $getDokPenawaran = \DB::table('mt_dokumen_penawaran')
                ->where('type', $dokBarangBekas)
                ->where('is_doc_type', $tipeDok)
                ->get();
        foreach( $getDokPenawaran as $key => $value ) {
            \App\Models\Procurement\PaketDokumenPenawarans::create([
                'paket_id'                  => $request->paket_id,
                'mt_dokumen_penawaran_id'   => $value->id,
                'userid_created'            => Auth::user()->name,
                'userid_updated'            => Auth::user()->name
            ]);
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('pembelian-barang-bekas.create',Crypt::encrypt($request->paket_id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author didi gantengs
     */
    public function storeRekananInput(Request $request)
    {
        $getMax = $this->RekananRepo->getMax();

        $data = $request->except(array('_token', 'email'));
        $uuid = Uuid::generate();
        $data['id'] = $uuid;
        $data['kode'] = $getMax;
        $data['mt_bentuk_usaha_id'] = $data['bentuk_usaha'];
        $data['mt_jenis_pengadaan_id'] = $data['jenis_pengadaan'];
        $data['userid_created']         = Auth::user()->name;
        $data['userid_updated']         = Auth::user()->name;
        $id = Rekanans::create($data)->id;

        //setelah table rekanan sukses tersimpan
        //selanjutnya masuk ke relate paket
        // set winner langsung
        \App\Models\Procurement\PaketRekanan::create([
            'paket_id'          => $request->paket_id,
            'mt_rekanan_id'     => $id,
            'is_winner'         => \App\Models\Procurement\PaketRekanan::Pemenang, //ini doi menang
            'status'            => \App\Models\Procurement\PaketRekanan::Pemenang,
            'userid_created'    => Auth::user()->name,
            'userid_updated'    => Auth::user()->name
        ]);

        //update is_dpt 
        \App\Models\Procurement\Pakets::where('id', $request->paket_id)
            ->update([
                'is_dpt' => $request->is_dpt,
                'is_public' => \App\Models\Procurement\Pakets::PublishPaket
            ]);

        //save harga penawran
        if($request->has('harga_penawaran') ) {
            $total = 0;
            foreach( $request->harga_penawaran as $key => $value ) {
                $total += trim($value);
                \App\Models\Procurement\RekananSubmitHargaPenawaran::create([
                    'mt_rekanan_id'     => $id,
                    'paket_id'          => $request->paket_id,
                    'paket_hps_id'      => $request->paket_hps_id[$key],
                    'harga_penawaran'   => trim($value),
                    'userid_created'    => Auth::user()->name,
                    'userid_updated'    => Auth::user()->name
                ]);
            }
        }

        //total penawaran
        //ini agar mempermudah mencari total penawran dari penyedia
        \App\Models\Procurement\RekananSubmitPenawaran::create([
            'mt_rekanan_id'         => $id,
            'paket_id'              => $request->paket_id,
            'is_setuju'             => $request->is_setuju ?? 1,
            'masa_berlaku'          => 30,//set default 30 hri krena ga tau nih klo pembelian langsung
            'total_harga_penawaran' => $total,
            'userid_created'        => Auth::user()->name,
            'userid_updated'        => Auth::user()->name
        ]);

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        $successmessage = "Proses Pendaftaran Rekanan Berhasil !!";
        return redirect()->route('pembelian-barang-bekas.create',Crypt::encrypt($request->paket_id))->with('successMessage', $successmessage);
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
        //save harga penawran
        if($request->has('harga_penawaran') ) {
            $total = 0;
            foreach( $request->harga_penawaran as $key => $value ) {
                $total += trim($value);
                \App\Models\Procurement\RekananSubmitHargaPenawaran::where('paket_id', $request->paket_id)
                    ->where('mt_rekanan_id', $request->rekanan_id)
                    ->update([
                        'mt_rekanan_id'     => $request->rekanan_id,
                        'paket_id'          => $request->paket_id,
                        'paket_hps_id'      => $request->paket_hps_id[$key],
                        'harga_penawaran'   => trim($value),
                        'userid_created'    => Auth::user()->name,
                        'userid_updated'    => Auth::user()->name
                    ]);
            }

            //update di isnegoisasi
            // dan masukan harga negoisasi
            \App\Models\Procurement\RekananSubmitPenawaran::where('mt_rekanan_id',$request->rekanan_id)
                ->where('paket_id',$request->paket_id)
                ->update([
                'harga_negoisasi'       => $total,
                'is_negoisasi'          => \App\Models\Procurement\RekananSubmitPenawaran::SudahDiNego,
                'userid_updated'        => Auth::user()->name
            ]);
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('pembelian-barang-bekas.create',Crypt::encrypt($request->paket_id));
    }

    /**
     * store undangan
     */
    public function storeUndangan(Request $request)
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
        // $paket = \DB::table('e_paket')->select('e_paket.nama','mt_rekanan.nama as nama_peyedia','mt_rekanan.npwp','users.id','users.email')->join('mt_rekanan','e_paket.mt_rekanan_id','=','mt_rekanan.id')->join('users','mt_rekanan.id','=','users.id')->where('e_paket.id','=',$request->paket_id)->first();
        // $dataMail= array();
        // $dataMail['title'] = 'Pemberitahuan Inbox Pengendali Kualitas'; 
        // $dataMail['user'] = 'Pimpinan '.$paket->nama_peyedia.'<br>Npwp: '. $paket->npwp; 
        // $dataMail['user_id'] = Auth::user()->id; 
        // $dataMail['message'] = 'Anda terpilih untuk mengikuti pengadaan '.$paket->nama.' Silahkan masuk melalui simbajanesa.ac.id , klik konfirmasi untuk mengikuti pengadaan tersebut.<br><br>Terima kasih';
        // $dataMail['subject'] = 'Undangan '.$paket->nama;
        // $dataMail['is_read'] = 0;
        // $dataMail['user_to_id'] = $paket->id;
        // Einbox::create($dataMail);
        // Mail::to($paket->email)->send(new InboxMail($dataMail));
        
        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('pembelian-barang-bekas.create',Crypt::encrypt($request->paket_id));
    }

    /**
     * store evaluasi
     */
    public function storeEvaluasi(Request $request)
    {
        \DB::beginTransaction();
        try {

            if( $request->has('is_doc_type') == Self::Harga ) {
                foreach( $request->mt_dokumen_penawaran_id as $key => $value ) {
                    \App\Models\Procurement\EvaluasiDokumenPenawaran::create([
                        'paket_id'                    => $request->paket_id,
                        'mt_rekanan_id'               => $request->rekanan_id,
                        'mt_dokumen_penawaran_id'     => $request->mt_dokumen_penawaran_id[$key],
                        'memenuhi'                    => $request->memenuhi_dok_penawaran[$key],
                        'userid_created'              => Auth::user()->name,
                        'userid_updated'              => Auth::user()->name
                    ]);
                }
                
                //harga
                \App\Models\Procurement\EvaluasiPenilaian::create([
                    'paket_id'              => $request->paket_id,
                    'mt_rekanan_id'         => $request->rekanan_id,
                    'is_lulus'              => $request->is_lulus_harga,
                    'is_doc_type'           => Self::Harga,
                    'alasan_tidak_lulus'    => $request->alasan_tidak_lulus_harga ?? '',
                    'userid_created'        => Auth::user()->name,
                    'userid_updated'        => Auth::user()->name,
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
            return redirect()->route('pembelian-barang-bekas.create',Crypt::encrypt($request->paket_id));
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

     /**
     * store baps
     */
    public function storeBap(Request $request)
    {
        try {
            \App\Models\Procurement\Ebap::create([
                'paket_id'          => $request->paket_id,
                'mt_rekanan_id'     => $request->rekanan_id,
                'bap_no'            => $request->bap_no,
                'bap_tanggal'       => $request->bap_tanggal,
                'bap_mulai'         => \convert_date_time_picker($request->bap_mulai),
                'bap_selesai'       => \convert_date_time_picker($request->bap_selesai),
                'bap_tempat'        => $request->bap_tempat,
                'userid_created'    => Auth::user()->name,
                'userid_updated'    => Auth::user()->name,
            ]);
            
            Alert::success('Data berhasil disimpan')->persistent('Ok');
            return redirect()->route('pembelian-barang-bekas.create',Crypt::encrypt($request->paket_id));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

     /**
     * store klarifikasi
     */
    public function storeKlarifikasi(Request $request)
    {
        try {
            $getRekananMenang = \App\Models\Procurement\PaketRekanan::where('paket_id',$request->paket_id)
                            ->where('is_winner', \App\Models\Procurement\PaketRekanan::Pemenang)
                            ->first();

            foreach( $request->mt_klarifikasi_id as $key => $val) {
                \App\Models\Procurement\Eklarifikasi::create([
                    'mt_klarifikasi_id' => $val,
                    'hasil_klarifikasi' => $request->hasil_klarifikasi[$key],
                    'paket_id'          => $request->paket_id,
                    'mt_rekanan_id'     => $getRekananMenang->mt_rekanan_id
                ]);
            }
            
            Alert::success('Data berhasil disimpan')->persistent('Ok');
            return redirect()->route('pembelian-barang-bekas.create',Crypt::encrypt($request->paket_id));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function printBaNegoisasi($id)
    {
        $bap = \App\Models\Procurement\Ebap::find($id);
        $paket = Pakets::find($bap->paket_id);
        
        $pdf = PDF::loadView('procurement.pembelianbarangbekas.print-bapnegoisasi',compact('bap','paket'));
        return $pdf->stream();
    }
}
