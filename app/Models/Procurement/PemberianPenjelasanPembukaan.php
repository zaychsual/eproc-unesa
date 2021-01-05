<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\UuidTrait;

class PemberianPenjelasanPembukaan extends Model
{

    use UuidTrait;
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_pemberian_penjelasan_pembukaan';

    public static $rules = [
        'pemenang' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','pembukaan','paket_id','userid_created','userid_updated',
    ];
}

