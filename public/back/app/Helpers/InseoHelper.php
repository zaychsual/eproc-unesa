<?php

namespace App\Helpers;

use DB;
use Session;
use App\Models\Webprofile\Setting;
use App\Models\Periodewisuda;
use App\Models\Webprofile\Newmenu;
use App\Models\Webprofile\Design;

use Auth;
use Crypt;
use File;
use Redirect;
use Hash;
use Uuid;

class InseoHelper
{
    public static function tglbulanindo2($waktu, $tipe = '')
    {
        $menit = substr($waktu, 14, 2);
        $jam = substr($waktu, 11, 2);
        $tgl = substr($waktu, 8, 2);
        $bln = substr($waktu, 5, 2);
        $thn = substr($waktu, 0, 4);
        $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
        $idxhari = date('N', strtotime($waktu));

        switch ($tipe) {
          case 1:$full = $tgl.' '.$bulan[(int) $bln - 1].' '.$thn;
              break;
          case 2:$full = $tgl.'/'.$bln.'/'.$thn;
              break;
          default:$full = "$tgl ".$bulan[(int) $bln - 1]." $thn";
        }

        return $full;
    }

    public static function tgl($waktu)
    {
        $tgl = substr($waktu, 8, 2);
        $bln = substr($waktu, 5, 2);
        $thn = substr($waktu, 0, 4);

        $full = $tgl.' - '.$bln.' - '.$thn;

        return $full;
    }

    public static function email()
    {
        $email = Setting::where('name_setting', 'email')->first();

        return $email->value_setting;
    }

    public static function webtitle()
    {
        $title = Setting::where('name_setting', 'web_title')->first();

        return $title->value_setting;
    }

    public static function post_per_page()
    {
        $page = Setting::where('name_setting', 'post_per_page')->first();

        return $page->value_setting;
    }

    public static function logo()
    {
        $page = Setting::where('name_setting', 'logo')->first();

        return $page->value_setting;
    }

    public static function namadosen($id_sdm)
    {
        $url = "https://siakadu.unesa.ac.id/api/apiunggun";
        $data = array('id_sdm'=>$id_sdm, 'kondisi'=>"nama_dosen");
        $x= kirim_data($url, 'post', $data);
        $namadosen = unserialize($x['isi']);

        return $namadosen['nama'];
    }

    public static function nipdosen($id_sdm)
    {
        $url = "https://siakadu.unesa.ac.id/api/apiunggun";
        $data = array('id_sdm'=>$id_sdm, 'kondisi'=>"nama_dosen");
        $x= kirim_data($url, 'post', $data);
        $namadosen = unserialize($x['isi']);

        return $namadosen['nip'];
    }

    public static function fakultas()
    {
        $fak = [
        'Ilmu Pendidikan' => 'Fak. Ilmu Pendidikan',
        'Bahasa dan Seni' => 'Fak. Bahasa & Seni',
        'Matematika dan Ilmu Pengetahuan Alam' => 'Fak. Matematika dan Ilmu Pengetahuan Alam',
        'Ilmu Sosial dan Hukum' => 'Fak. Ilmu Sosial & Hukum',
        'Teknik' => 'Fak. Teknik',
        'Ilmu Keolahragaan' => 'Fak. Ilmu Keolahragaan',
        'Ekonomi' => 'Fak. Ekonomi',
        'Pascasarjana' => 'Pascasarjana'
      ];

        return $fak;
    }

    public static function login_sso($email)
    {
        $url = "https://siakadu.unesa.ac.id/api/apiunggun";
        $data = array('kondisi'=>"login_sso",'email'=>$email);
        $x= kirim_data($url, 'post', $data);
        $tampil = unserialize($x['isi']);
        return $tampil;
    }

    public static function cek_periode_siyu()
    {
        // $periode = '90';
        $dbperiode = Periodewisuda::where('isaktif', 1)->first();
        $periode = $dbperiode->periodewisuda;

        return $periode;
    }

    public static function reg_tracer()
    {
        $reg_tracer = Setting::where('name_setting', 'reg_tracer')->first();

        return $reg_tracer->value_setting;
    }

    public static function salt()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; ++$i) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function inseoencrypt($str)
    {
        $kunci = '2cax5nhy6czo9hex3usy8nziz';
        $hasil = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $karakter = substr($str, $i, 1);
            $kuncikarakter = substr($kunci, ($i % strlen($kunci))-1, 1);
            $karakter = chr(ord($karakter)+ord($kuncikarakter));
            $hasil .= $karakter;
        }
        return urlencode(base64_encode($hasil));
    }

    public static function inseodecrypt($str)
    {
        $str = base64_decode(urldecode($str));
        $hasil = '';
        $kunci = '2cax5nhy6czo9hex3usy8nziz';
        for ($i = 0; $i < strlen($str); $i++) {
            $karakter = substr($str, $i, 1);
            $kuncikarakter = substr($kunci, ($i % strlen($kunci))-1, 1);
            $karakter = chr(ord($karakter)-ord($kuncikarakter));
            $hasil .= $karakter;
        }
        return $hasil;
    }

    public static function setting()
    {
        $setting = Setting::orderBy('name_setting', 'asc')->get();

        $arr = [];
        foreach ($setting as $value) {
            $arr[$value->name_setting] = $value->value_setting;
        }

        Session::put('ss_setting', $arr);
    }

    public static function maxmenu($lvl, $parentid)
    {
        $hnewmenu = Newmenu::where('parent', $parentid)->where('level', $lvl)->max('urutan');

        return $hnewmenu;
    }

    public static function jumchild($lvl, $parentid)
    {
        $hnewmenu = Newmenu::where('parent', $parentid)->where('level', $lvl)->count();

        return $hnewmenu;
    }

    public static function prodisetting($wildcard)
    {
        $setting = Setting::where('wildcard', $wildcard)->orderBy('name_setting', 'asc')->get();
        // dd($setting);
        $arr = [];
        foreach ($setting as $value) {
            $arr[$value->name_setting] = $value->value_setting;
        }

        Session::put('ss_setting', $arr);
    }

    public static function footer()
    {
        $footer = Design::whereIn('name_design', ['footer_row_1', 'footer_row_2','footer_row_3', 'footer_row_4'])->orderBy('name_design', 'asc')->get();

        if (count($footer)) {
            foreach ($footer as $value) {
                $foot[$value->name_design] = $value->value_design;
            }
        } else {
            $foot[] = '';
        }

        return $foot;
    }

    //sso

    public static function safe_b64encode($string) {

        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public static function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public static function decode($value){
        $skey   = "!SysT3mSeCuR1Ty\0"; 
        if(!$value) {
            return false;
        }
        $crypttext = Self::safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        
        return trim($decrypttext);
    }
}
