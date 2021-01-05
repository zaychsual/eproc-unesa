<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketTahapans extends Model
{
    use UuidTrait;
    public const tender = 2;

    public const nontender = 1;
    public $incrementing = false;
    protected $table = 'e_paket_tahapan';

    public static $rules = [
        'paket_id' => 'required',
    ];
    

    protected $fillable = [
        'paket_id',
        'tahapan_id',
        'waktu_mulai',
        'waktu_selesai',
        'userid_created',
        'userid_updated',
    ];


    public static function getjadwalTender($paket_id)
    {
        return PaketTahapans::where('paket_id', $paket_id)
            ->join('e_tahap','e_tahap.id','=','e_paket_tahapan.tahapan_id')
            ->where('type',self::tender)
            ->get()
            ->toArray();
    }

    public static function getjadwalNonTender($paket_id)
    {
        return PaketTahapans::where('paket_id', $paket_id)
            ->join('e_tahap','e_tahap.id','=','e_paket_tahapan.tahapan_id')
            ->where('type',self::nontender)
            ->get()
            ->toArray();
    }


    public static function getTahapan($paket_id)
    {
        return PaketTahapans::where('paket_id', $paket_id)
            ->join('e_tahap','e_tahap.id','=','e_paket_tahapan.tahapan_id')
            ->where('type',self::tender)
            ->get()
            ->toArray();
    }

    public static function getTahapanKirimPenawaran($paket_id)
    {
        return PaketTahapans::where('paket_id', $paket_id)
            ->join('e_tahap','e_tahap.id','=','e_paket_tahapan.tahapan_id')
            ->where('type',self::tender)
            ->where('nama','Pemasukan Dokumen Penawaran')
            ->first();
    }

    public static function getTahapans($paket_id)
    {
        return PaketTahapans::where('paket_id', $paket_id)
            ->join('e_tahap','e_tahap.id','=','e_paket_tahapan.tahapan_id')
            ->where('type',self::tender)
            ->where('waktu_mulai','<=', date('Y-m-d H:i:s'))
            ->where('waktu_selesai','>=', date('Y-m-d H:i:s'))
            ->first();
    }

    public static function getTahapanNontender($paket_id)
    {
        return PaketTahapans::where('paket_id', $paket_id)
            ->join('e_tahap','e_tahap.id','=','e_paket_tahapan.tahapan_id')
            ->where('type',self::nontender)
            ->where('waktu_mulai','<=', date('Y-m-d H:i:s'))
            ->where('waktu_selesai','>=', date('Y-m-d H:i:s'))
            ->first();
    }
}