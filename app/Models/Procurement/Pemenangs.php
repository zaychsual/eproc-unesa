<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemenangs extends Model
{

    use SoftDeletes;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_pemenang';

    public static $rules = [
        'pemenang' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','pemenang','userid_created','userid_updated',
    ];
}

