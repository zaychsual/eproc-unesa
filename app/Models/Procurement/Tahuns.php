<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tahuns extends Model
{

    use SoftDeletes;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_tahun';

    public static $rules = [
        'tahun' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','tahun','userid_created','userid_updated',
    ];
}

