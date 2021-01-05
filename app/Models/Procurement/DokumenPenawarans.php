<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumenPenawarans extends Model
{

    public const Tender = 2;
    public const Administrasi = 1;
    public const Teknis = 2;
    public const Harga = 3;
    public const NonTender = 1;
    
    public $incrementing = false;
    protected $table = 'mt_dokumen_penawaran';

    public static $rules = [
        'dokumen' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','name','type','userid_created','userid_updated',
    ];
}

