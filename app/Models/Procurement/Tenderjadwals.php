<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;

class Tenderjadwals extends Model
{
    public $incrementing = false;
    protected $table = 'e_tender_jadwal';

    public static $rules = [
        'title' => 'required',
        'images' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','tender_id','e_tahap_id','tanggal_awal','tanggal_akhir','status_hapus','userid_created','userid_updated',
    ];
}

