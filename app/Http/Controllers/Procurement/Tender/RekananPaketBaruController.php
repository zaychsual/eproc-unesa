<?php

namespace App\Http\Controllers\Procurement\tender;

use App\Models\Procurement\Listpakets;
use App\Models\Procurement\Klpds;
use App\Models\Procurement\SatuanKerjas;
use App\Models\Procurement\Tahuns;
use App\Models\Procurement\JenisPengadaans;
use App\Models\Procurement\Kualifikasis;
use App\Models\Procurement\MetodeKualifikasis;
use App\Models\Procurement\Pemenangs;
use App\Models\Procurement\JenisKontraks;
use App\Models\Procurement\PaketRekanan;
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

class RekananPaketBaruController extends Controller
{
    const Active = 1;

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
        
        $tender = Pakets::join('e_paket_category','e_paket_category.id','=','e_paket.category_id')
            ->where('is_public',Listpakets::Publish)
            ->where('code','TE')
            ->orderBy('created_at','desc')
            ->select('e_paket.*','e_paket_category.name','e_paket_category.code')
            ->get();
            
        $nontender = \DB::table('v_paket_rekanan')->where('is_public',Listpakets::Publish)
            ->where('rekanan_id',Auth::user()->mt_rekanan_id)
            ->whereNotIn('code',['TE'])
            ->get();
        // dd($nontender);
        return view('procurement.rekananpaketbaru.index', compact('tender','nontender'))->withTitle('Paket Baru');

    }

    public function show($id)
    {
        $paket = Pakets::where('id', Crypt::decrypt($id))->first();
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

        $lembarKualifikasi = \App\Models\Procurement\PaketLembarKualifikasi::where('paket_id',Crypt::decrypt($id))->first();
        $lembarIzin = \App\Models\Procurement\PaketJenisIzin::where('paket_id',Crypt::decrypt($id))->get();
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
            'pejabat_id' => $pejabat_pengadaan,
            'lembarIzin' => $lembarIzin,
            'lembarKualifikasi' => $lembarKualifikasi
        ];
        return view('procurement.rekananpaketbaru.show',compact('paket','data'))->withTitle('Informasi Paket');
    }

    public function showPaket($id, $is_tender)
    {
        $paket = Pakets::where('id', Crypt::decrypt($id))->first();
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

        $lembarKualifikasi = \App\Models\Procurement\PaketLembarKualifikasi::where('paket_id',Crypt::decrypt($id))->first();
        $lembarIzin = \App\Models\Procurement\PaketJenisIzin::where('paket_id',Crypt::decrypt($id))->get();
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
            'pejabat_id' => $pejabat_pengadaan,
            'lembarIzin' => $lembarIzin,
            'lembarKualifikasi' => $lembarKualifikasi,
            'is_tender' => $is_tender
        ];
        return view('procurement.rekananpaketbaru.show',compact('paket','data'))->withTitle('Informasi Paket');
    }

    /**
     * rekanan mengikuti paket
     * @author didi
     */
    public function storeIkutPaket(Request $request)
    {
        $paket = Pakets::find($request->paket_id);

        $paket->status_paket = Pakets::PaketApproveRekanan;
        $paket->update();
        
        // dd($request);
        if( $request->is_tender == 'nontender' ) {
            // dd(1);
            $paketRekanan = PaketRekanan::where('paket_id', $request->paket_id)
                ->where('mt_rekanan_id', Auth::user()->mt_rekanan_id)
                ->update([
                    'status' => PaketRekanan::Approved,
                    'status_tahapan' => PaketRekanan::TahapanDownloadDokumenPemilihan
                ]);
        } else {
            // dd(2);
            $paketRekanan = PaketRekanan::create([
                'paket_id' => $request->paket_id,
                'mt_rekanan_id' => Auth::user()->mt_rekanan_id,
                'status' => PaketRekanan::Approved,
                'status_tahapan' => PaketRekanan::TahapanDownloadDokumenPemilihan,
                'userid_created' => Auth::user()->name,
                'userid_updated' => Auth::user()->name
            ]);
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('paket-baru.index');
    }
}