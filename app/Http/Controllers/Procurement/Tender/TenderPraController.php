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
use App\Models\Procurement\Einbox;
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
use PDF;
use Illuminate\Support\Facades\Hash;

class TenderPraController extends Controller
{
    const PokjaApproved = 1;
    const Active = 1;
    public const Administrasi = 1;
    public const Kualifikasi = 2;
    public const Teknis = 3;
    public const Harga = 4;

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
    public function createPra($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $jadwal = PaketTahapans::getjadwalTender(Crypt::decrypt($paket_id));
        // dd($jadwal);
        $lembarKualifikasi = PaketLembarKualifikasi::where('paket_id', Crypt::decrypt($paket_id))->first();
        $getFileKak = \App\Models\Procurement\PaketFile::where('tipe',\App\Models\Procurement\PaketFile::FileKak)
                    ->where('paket_id', Crypt::decrypt($paket_id))
                    ->first();

        $rekanan     = \App\Models\Procurement\PaketRekanan::where('paket_id',Crypt::decrypt($paket_id))->get();
        $getApproval = \DB::table('e_paket_approval')->where('paket_id',Crypt::decrypt($paket_id))
                        ->join('users','users.id','=','e_paket_approval.pokja_id')
                        ->get();

        $kriteria           = \App\Models\Procurement\EvaluasiKriterias::where('id', $paket->evaluasi_kriteria_id)->first();
        $getTahapan         = \App\Models\Procurement\PaketTahapans::getTahapans(Crypt::decrypt($paket_id));

        return view('procurement.tenderpra.kualifikasi.create',compact(
            'paket',
            'jadwal',
            'lembarKualifikasi',
            'getFileKak',
            'rekanan',
            'getApproval',
            'getTahapan',
            'paket_id'))
        ->withTitle('Tender (prakualifikasi)');
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

        return view('procurement.tenderpra.kualifikasi.create-rekanan',compact('paket','rekanan'))->withTitle('Pilih Rekanan');
    }

    /**
     * create kualifikasi
     * @author didi
     * @param string $paket_id
     */
    public function createKualifikasi($paket_id)
    {
        $paket = Pakets::find(Crypt::decrypt($paket_id));
        $mkualfikasi = \App\Models\Procurement\MtKualifikasi::get();

        return view('procurement.tenders.create-kualifikasi',compact('paket','mkualfikasi'))->withTitle('Dokumen Penawaran');
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
            return redirect()->route('tender.create-tender-pra',Crypt::encrypt($request->paket_id));

        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    public function storePemilihanRekanan(Request $request) 
    {
        if( $request->has('rekanan_id') ) {
            foreach( $request->rekanan_id as $key => $rows ) {

                $belumKualifikasi = 0;
                \App\Models\Procurement\PaketRekanan::create([
                    'paket_id' => $request->paket_id,
                    'mt_rekanan_id' => $rows,
                    'lulus_kualifikasi' => $belumKualifikasi,
                    'userid_created' => Auth::user()->name,
                    'userid_updated' => Auth::user()->name,
                ]);
            }
        }

        Alert::success('Data berhasil disimpan')->persistent('Ok');
        return redirect()->route('tender.create-tender-pra',Crypt::encrypt($request->paket_id));
    }
}
