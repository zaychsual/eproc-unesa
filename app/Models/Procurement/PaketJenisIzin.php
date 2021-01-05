<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketJenisIzin extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_lembar_kualifikasi_izin_usaha';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'jenis_izin',
        'klasifikasi',
        'userid_created',
        'userid_updated',
    ];
}