<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klpds extends Model
{

    use SoftDeletes;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_klpd';

    public static $rules = [
        'klpd' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','klpd','userid_created','userid_updated',
    ];
}

