<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EvaluasiTeknis extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_evaluasi_teknis';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'spesifikasi_teknis_identitas',
        'alasan_tidak_lulus',
        'userid_created',
        'userid_updated',
    ];
}