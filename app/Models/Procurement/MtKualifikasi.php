<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MtKualifikasi extends Model
{

    public const Active = 1;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'mt_kualifikasi';

    public static $rules = [
        'metode_kualifikasi' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','metode_kualifikasi','userid_created','userid_updated',
    ];
}

