<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Paketlokasis extends Model
{
    use UuidTrait;
    
    public $incrementing = false;
    protected $table = 'e_paket_lokasi';

    public static $rules = [
        'paket_id' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','paket_id','provinsi_id','kota_id','alamat','userid_created','userid_updated',
    ];
}


