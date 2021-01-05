<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisPengadaans extends Model
{

    use SoftDeletes;
    public const Active = 1;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_jenispengadaan';

    public static $rules = [
        'jenispengadaan' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','jenispengadaan','userid_created','userid_updated',
    ];
}

