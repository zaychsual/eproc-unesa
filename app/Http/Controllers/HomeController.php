<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Procurement\PaketRekanan;
use App\Models\Webprofile\Rekanans;
use App\Models\Procurement\Pakets;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = 1;
        $cek  = Rekanans::where('id', Auth::user()->mt_rekanan_id)->first();
        if(Auth::user()->role == 'admin') {
            return view('dashboard');
        }elseif( 'pejabatpengadaan' == Auth::user()->role) {

            $paket  = \DB::table('v_pejabat_paket')
                        ->where('pokja_id',Auth::user()->id)
                        ->where('is_public',\App\Models\Procurement\Pakets::PublishPaket)
                        ->get();

            return view('home',compact('paket'));
        }elseif (Auth::user()->role == 'pokja') {
            $tender     = \DB::table('v_pokja_paket')
                        ->where('kode_metode', 'TE')
                        ->where('pokja_id',Auth::user()->id)
                        ->where('is_public',\App\Models\Procurement\Pakets::PublishPaket)
                        ->get();

            $nontender  = \DB::table('v_pokja_paket')
                        ->whereNotIn('kode_metode', ['TE'])
                        ->where('pokja_id',Auth::user()->id)
                        ->where('is_public',\App\Models\Procurement\Pakets::PublishPaket)
                        ->get();
            // echo "<pre>";
            //     print_r($tender);
            //     print_r($nontender);
            // echo "</pre>";
            return view('home',compact('tender','nontender'));
        }elseif (Auth::user()->role == 'ppk') {
            $tender     = \DB::table('v_ppk_paket')
                        ->where('kode_metode', 'TE')
                        ->where('userid_created', Auth::user()->name)
                        ->where('is_public',\App\Models\Procurement\Pakets::PublishPaket)
                        ->get();
            $nontender  = \DB::table('v_ppk_paket')
                        ->whereNotIn('kode_metode', ['TE'])
                        ->where('userid_created', Auth::user()->name)
                        ->where('is_public',\App\Models\Procurement\Pakets::PublishPaket)
                        ->get();
                        // dd($nontender);
            return view('home',compact('tender','nontender'));
            
        }elseif (Auth::user()->role == 'laman'  && $cek->is_active == $active) {
            $tender = \DB::table('v_paket_rekanan') 
                    ->where('rekanan_id',Auth::user()->mt_rekanan_id)
                    ->where('code','TE')
                    ->get();
            $nontender = \DB::table('v_paket_rekanan') 
                    ->where('rekanan_id',Auth::user()->mt_rekanan_id)
                    ->whereNotIn('code',['TE'])
                    ->get();
            // dd($data);

            return view('welcome',\compact('tender','nontender') );
        }elseif(Auth::user()->role == 'kaukpbj') {
            return view('home');
        } elseif( Auth::user()->role == 'pengendalikualitas') {
            $paket = \DB::table('e_paket_diteruskan')->where('pengendali_kualitas_id',Auth::user()->id)
                ->join('e_paket','e_paket.id','=','e_paket_diteruskan.paket_id')
                ->where('e_paket_diteruskan.status_paket', Pakets::PaketBelumSelesai)
                ->orderBy('e_paket_diteruskan.updated_at', 'DESC')
                ->get();

            return view('home',compact('paket'));
        }else{
           return redirect('Login');
        }
        //return view('home');
    }

    public function Login()
    {
         return view('auth.login');
    }



}
