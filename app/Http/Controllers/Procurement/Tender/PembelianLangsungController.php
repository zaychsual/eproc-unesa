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
use Redirect;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ProvinsiRepository;
use App\Repositories\RekananRepository;

class PembelianLangsungController extends Controller
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
        $paket          = Pakets::find(Crypt::decrypt($paket_id));
        $rekanan        = \App\Models\Procurement\PaketRekanan::where('paket_id',Crypt::decrypt($paket_id))->first();
        $penawaran      = \App\Models\Procurement\RekananSubmitPenawaran::where('paket_id',Crypt::decrypt($paket_id))->get();
        $bap                = \App\Models\Procurement\Ebap::where('paket_id',Crypt::decrypt($paket_id))->first();

        return view('procurement.pembelianlangsung.create',compact(
            'paket',
            'rekanan',
            'penawaran',
            'bap'
        ))
        ->withTitle('Pembelian Langsung');
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

        return view('procurement.pembelianlangsung.create-rekanan',compact('paket','rekanan'))->withTitle('Pilih Rekanan');
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

        return view('procurement.pembelianlangsung.create-rekanan-input',compact('paket','data','paketHps'))->withTitle('Pilih Rekanan');
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

        return view('procurement.pembelianlangsung.create-negoisasi',compact('paket','paketHps','rekanan_id'))->withTitle('Input Negoisasi');
    }

    /**
     * create ba negoisasi
     * @return \Illuminate\Http\Response
     * @param string $paket_id
     * @author didi gantengs
    */
    public function createBaNegoisasi($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));

        return view('procurement.pembelianlangsung.create-ba-negoisasi',compact('paket'))->withTitle('Buat BA Negoisasi');
    }

    /**
     * create ba negoisasi
     * @return \Illuminate\Http\Response
     * @param string $paket_id
     * @author didi gantengs
    */
    public function createSuratPesanan($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));

        return view('procurement.pembelianlangsung.create-surat-pesanan',compact('paket'))->withTitle('Buat Surat Pesanan');
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
                    'paket_id' => $request->paket_id,
                    'mt_rekanan_id' => $rows,
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);
            }
        }

        \App\Models\Procurement\Pakets::where('id', $request->paket_id)
            ->update([
                'is_dpt' => $request->is_dpt,
                'is_public' => \App\Models\Procurement\Pakets::PublishPaket
            ]);

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('pemebelianlangsung.create',Crypt::encrypt($request->paket_id));
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
        return redirect()->route('pembelian-langsung.create',Crypt::encrypt($request->paket_id))->with('successMessage', $successmessage);
    }

     /**
     * Store negoisasi harga
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author didi gantengs
     */
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
        return redirect()->route('pembelian-langsung.create',Crypt::encrypt($request->paket_id));
    }

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
        return redirect()->route('pembelian-langsung.create',Crypt::encrypt($request->paket_id));
    }
}
