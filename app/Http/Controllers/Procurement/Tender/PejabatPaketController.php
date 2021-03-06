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

class PejabatPaketController extends Controller
{
    const Draft = NULL;
    public function index()
    {
        $tender  = \DB::table('v_pejabat_paket')
                    ->where('kode_metode', 'TE')
                    ->where('pokja_id',Auth::user()->id)
                    ->whereNull('is_public')
                    ->get();

        $nontender  = \DB::table('v_pejabat_paket')
                    ->whereNotIn('kode_metode', ['TE'])
                    ->where('is_public')
                    ->where('pokja_id',Auth::user()->id)
                    ->get();

        return view('procurement.listpakets.pp.index',\compact('tender','nontender'))->withTitle('Daftar paket');
    }
}