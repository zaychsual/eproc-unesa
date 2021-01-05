<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dbriefing extends Model
{

    use SoftDeletes;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_debriefing';
    protected $fillable = [
        'paket_id',
        'author',
        'mt_rekanan_id',
        'pesan',
        'lampiran'
    ];

    public static $rules = [
        'dokumen' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];
}

