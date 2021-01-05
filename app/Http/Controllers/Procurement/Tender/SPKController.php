<?php

namespace App\Http\Controllers\Procurement\Tender;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Procurement\Pakets;
use App\Models\Procurement\JenisKontraks;
use App\Models\Procurement\Rekanans;
use App\Models\Procurement\EKontrakSpk;
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
use Terbilang;
use PDF;

class SPKController extends Controller
{
    /* private $ProvinsiRepo;

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
 */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($paket_id)
    {
        $jeniskontrak_id = JenisKontraks::where('is_active', '1')->orderBy('jeniskontrak', 'ASC')->pluck('jeniskontrak', 'id');
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $data = [
            'paket_id' => $paket,
            'jeniskontrak_id' => $jeniskontrak_id
        ];
    
        return view('procurement.spk.create', compact('data','paket','paket_id'))->withTitle('SPK');
    }
    public function PrintSPK($paket_id)
    {
        $paket = \DB::table('e_kontrak_sppbj')->join('e_paket','e_paket.id','=','e_kontrak_sppbj.paket_id')
                ->join('v_penawaran_rekanan','e_paket.id','=','v_penawaran_rekanan.paket_id')
                ->join('e_kontrak','e_paket.id','=','e_kontrak.paket_id')
                ->select('v_penawaran_rekanan.nama as namacv', 'e_kontrak_sppbj.sppbj_no as no_sppbj',
                        'e_paket.nama as namapaket','e_kontrak_sppbj.sppbj_harga_final as harga',
                        'e_kontrak_sppbj.sppbj_kota as alamat','e_kontrak_sppbj.sppbj_tanggal as tanggal',
                        'e_kontrak_sppbj.userid_created as pembuat', 'e_kontrak.kontrak_unit_kerja as unit'
                )->where('e_kontrak_sppbj.paket_id',Crypt::decrypt($paket_id))
                ->get()
                ->first();
        $harga = Terbilang::make(@$paket->harga, ' rupiah');
       
        // echo "<pre>";
        // print_r($paket);exit;
        // echo "</pre>";
        $pdf = PDF::loadView('procurement.spk.print.print-spk',compact('paket','harga'));
        return $pdf->stream();
    }
    public function PrintPembayaran($paket_id)
    {
        $paket = \DB::table('e_kontrak_sppbj')->join('e_paket','e_paket.id','=','e_kontrak_sppbj.paket_id')->join('v_penawaran_rekanan','e_paket.id','=','v_penawaran_rekanan.paket_id')->join('e_kontrak','e_paket.id','=','e_kontrak.paket_id')->select('v_penawaran_rekanan.nama as namacv', 'e_kontrak_sppbj.sppbj_no as no_sppbj','e_paket.nama as namapaket','e_kontrak_sppbj.sppbj_harga_final as harga','e_kontrak_sppbj.sppbj_kota as alamat','e_kontrak_sppbj.sppbj_tanggal as tanggal','e_kontrak_sppbj.userid_created as pembuat')->where('e_kontrak_sppbj.paket_id',Crypt::decrypt($paket_id))->get()->first();
        $harga = Terbilang::make($paket->harga, ' rupiah');
        $pdf = PDF::loadView('procurement.spk.print.lampiran-pembayaran',compact('paket','harga'));
        return $pdf->stream();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        
        // if ($request->hasFile('link_file_dok_pengadaan')) {
        //     $uuid = Uuid::generate();
        //     $newFilename = "";
        //     $newExtension = "";
        //     $newSizeDok = "";
        //     for ($i = 0; $i < count($request['link_file_dok_pengadaan']); $i++) {
        //         $cover = $request->file('link_file_dok_pengadaan')[$i];
        //         $extension = $cover->guessClientExtension();
        //         $size_dok = $cover->getSize();
        //         $filename = $uuid . '-' . $i . '.' . $extension;
        //         // sementara
        //         // Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/dok_pengadaan/' . $filename, file_get_contents($cover->getRealPath()));
        //         if ($i == 0) {
        //             $newFilename = $filename;
        //             $newExtension = $extension;
        //             $newSizeDok = $size_dok;
        //         } else {
        //             $newFilename = $newFilename . '###' . $filename;
        //             $newExtension = $newExtension . '###' . $extension;
        //             $newSizeDok = $newSizeDok . '###' . $size_dok;
        //         }
        //     }
        //     $data['link_file_dok_pengadaan'] = $newFilename;
        //     $data['tipe_file_dok'] = $newExtension;
        //     $data['ukuran_file_dok'] = $newSizeDok;
        // }

        $uuidspk = Uuid::generate();
        $array['id']                          = $request->uuidspk;
        $array['paket_id']                    = $request->paket_id;
        $array['spk_no']                      = $request->no_spk;
        $array['spk_kota']                    = $request->kota;
        $array['spk_tanggal']                 = $request->date_in;
        $array['nama_bank']                   = $request->bank;
        $array['no_rek']                      = $request->no_rek;
        $array['nama_ppk']                    = $request->nama_ppk;
        $array['satuan_kerja']                = $request->nama_satuan_kerja;
        $array['nama_penyedia']               = $request->nama_penyedia;
        $array['alamat_penyedia']             = $request->alamat_penyedia;
        $array['spk_wakil_sah_penyedia']      = $request->wakil_penyedia;
        $array['spk_jabatan_wakil_penyedia']  = $request->jabatan_penyedia;
        $array['spk_nilai_kotrak']            = $request->nilai_kontrak;
        $array['kotrak_id']                   = $request->jeniskontrak_id;
        $array['spk_tanggal_mulai_kerja']     = $request->start_date;
        $array['spk_wkt_penyelesaian']        = $request->end_date;
        $array['userid_created']              = Auth::user()->name;
        //gercep mau kesurabaya
        $array['mt_rekanan_id']               = 'a3fa5020-b6f0-11ea-9f9e-2988968a7247';
        $array['spk_file']                    = 'no_file.jpg';
        EKontrakSpk::create($array);

        Alert::success('SPK berhasil disimpan')->persistent('Ok');

        $successmessage = 'Proses Tambah SPK Berhasil !!';
        return redirect()->route('pakets.index')->with('successMessage', $successmessage);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
