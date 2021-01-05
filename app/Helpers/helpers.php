<?php

/* TGL INDO */

use App\Models\Procurement\LogsApp;
use App\Repositories\LogsAppRepository;

function tglindo($waktu, $tipe = '')
{
    $tgl = substr($waktu, 8, 2);
    $bln = substr($waktu, 5, 2);
    $thn = substr($waktu, 0, 4);
    $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
    $idxhari = date('N', strtotime($waktu));

    switch ($tipe) {
        case 1:$full = $tgl.' '.$bulan[(int) $bln - 1].' '.$thn;
            break;
        case 2:$full = $tgl.'/'.$bln.'/'.$thn;
            break;
        default:$full = $hari[$idxhari - 1].", $tgl ".$bulan[(int) $bln - 1]." $thn";
    }

    return $full;
}

function hari_ini($val)
{
    // $hari = date ("D");

    switch($val){
        case 'Sun':
            $hari_ini = "Minggu";
        break;

        case 'Mon':			
            $hari_ini = "Senin";
        break;

        case 'Tue':
            $hari_ini = "Selasa";
        break;

        case 'Wed':
            $hari_ini = "Rabu";
        break;

        case 'Thu':
            $hari_ini = "Kamis";
        break;

        case 'Fri':
            $hari_ini = "Jumat";
        break;

        case 'Sat':
            $hari_ini = "Sabtu";
        break;
        
        default:
            $hari_ini = "Tidak di ketahui";		
        break;
    }

    return $hari_ini;
}

function bulan_ini($val)
{
    // $bulan = date ("M");

    switch($val){
        case 'Jan':
            $bulan_ini = "Januari";
        break;

        case 'Feb':			
            $bulan_ini = "Februari";
        break;

        case 'Mar':
            $bulan_ini = "Maret";
        break;
        case 'Apr':
            $bulan_ini = "April";
        break;

        case 'May':
            $bulan_ini = "Mei";
        break;

        case 'Jun':
            $bulan_ini = "Juni";
        break;
        case 'Jul':
            $bulan_ini = "Juli";
        break;

        case 'Aug':
            $bulan_ini = "Agustus";
        break;
        case 'Sep':
            $bulan_ini = "September";
        break;

        case 'Oct':
            $bulan_ini = "Oktober";
        break;
        case 'Nov':
            $bulan_ini = "November";
        break;
        case 'Dec':
            $bulan_ini = "Desember";
        break;
        
        default:
            $bulan_ini = "Tidak di ketahui";		
        break;
    }

    return  $bulan_ini;
    
}

function logApp($status, $message)
{
    $mdl = new LogsApp();
    $logRepo = new LogsAppRepository($mdl);

    return $logRepo->log($status, $message);
}

function getMetodePemilihan($categoryId)
{
    return \DB::table('e_paket_category')->find($categoryId);
}

function checkKirimDatapenawaran($paket_id, $rekanan_id)
{
    // dd($paket_id);
    // dd($rekanan_id);
    return \DB::table('e_rekanan_submit_penawaran')
        ->where('paket_id', $paket_id)
        ->where('mt_rekanan_id', $rekanan_id)
        ->count();

}

function countTotalPenawaran($paket_id, $rekanan_id)
{
    $d =  \DB::table('e_rekanan_submit_harga_penawaran')
    ->select(\DB::raw("sum(harga_penawaran) as totalPenawaran"))
    ->where('paket_id', $paket_id)
    ->where('mt_rekanan_id', $rekanan_id)
    ->first();
    // dd($d);
    return $d;
}

function checkDokKualifikasi($paket_id, $rekanan_id)
{

}


function convert_date_time_picker($datetime)
{
    $date = date('Y-m-d H:i', strtotime($datetime));

    return $date;
}

function checkApprovePokja($pokja_id, $paket_id)
{
    $datas = \DB::table('e_paket_approval')
        ->where('pokja_id', $pokja_id)
        ->where('paket_id', $paket_id)
        ->first();
    return $datas;
}

function checkPokjaAkses($pokja_id)
{
    $pokjas = \DB::table('e_paket_approval')
        ->where('');
}

function pemisahDate($date)
{
    return [
        0 => date('d', strtotime($date)),
        1 => date('m', strtotime($date)),
        2 => date('Y', strtotime($date))
    ];
}

function hari_ini_yes($date){
    $hari = date('D', strtotime($date));
    
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini;
 
}