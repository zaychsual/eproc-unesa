<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetodeKualifikasis extends Model
{

    use SoftDeletes;
    public const Active = 1;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_mtd_kualifikasi';

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

