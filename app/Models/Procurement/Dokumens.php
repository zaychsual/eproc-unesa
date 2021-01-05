<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumens extends Model
{

    use SoftDeletes;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_dokumen';

    public static $rules = [
        'dokumen' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','dokumen','userid_created','userid_updated',
    ];
}

