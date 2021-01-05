<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\BentukUsahas;
use App\Models\Webprofile\JenisPengadaans;
use App\Http\Traits\UuidTrait;

class RekananSubmitHargaPenawaran extends Model
{
    use UuidTrait;
    public $incrementing = false;
    protected $table = 'e_rekanan_submit_harga_penawaran';

    public static $rules = [
        'paket_id' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'paket_hps_id',
        'harga_penawaran',
        'harga_terkoreksi',
        'harga_negoisasi',
        'userid_created',
        'userid_updated'
    ];


    public function getPaket()
    {
        return $this->belongsTo(\App\Models\Procurement\Pakets::class,'paket_id');
    }

    public function getRekanan()
    {
        return $this->belongsTo(\App\Models\Procurement\Rekanans::class,'mt_rekanan_id');
    }

    public function getHpsDetail()
    {
        return $this->belongsTo(\App\Models\Procurement\PaketDetailHps::class,'paket_hps_id');
    }
}