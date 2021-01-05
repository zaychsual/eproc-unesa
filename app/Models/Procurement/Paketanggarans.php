<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Paketanggarans extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_paket_anggaran';

    public static $rules = [
        'sumber_dana' => 'required',
        'kode_anggaran' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','sumber_dana','kode_anggaran','nilai','userid_created','userid_updated','paket_id'
    ];
}

