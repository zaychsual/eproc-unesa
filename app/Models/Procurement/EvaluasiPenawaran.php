<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EvaluasiPenawaran extends Model
{
    use UuidTrait;

    public $incrementing = false;

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'dokumen_penawaran_id',
        'is_penawaran',
        'is_lulus',
        'alasan_tidak_lulus',
        'userid_created',
        'userid_updated',
    ];
}