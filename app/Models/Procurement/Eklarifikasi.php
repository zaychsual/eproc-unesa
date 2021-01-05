<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Eklarifikasi extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_klarifikasi';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'mt_klarifikasi_id',
        'hasil_klarifikasi',
        'userid_created',
        'userid_updated',
    ];

    public function getklarifikasi()
    {
        return $this->belongsTo(\App\Models\Procurement\Klarifikasi::class,'mt_klarifikasi_id');
    }
}