<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\BentukUsahas;
use App\Models\Webprofile\JenisPengadaans;
use App\Http\Traits\UuidTrait;

class Verifikasi extends Model
{
    use UuidTrait;
    public $incrementing = false;
    protected $table = 'e_rekanan_verifikasi';

    public static $rules = [
        'paket_id' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'mulai',
        'selesai',
        'tempat',
        'yang_harus_dibawa',
        'yang_harus_hadir',
        'userid_created',
        'userid_updated'
    ];
}