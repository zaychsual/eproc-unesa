<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EvaluasiKriterias extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'mt_evaluasi_kriteria';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'daftar_kuantitas_n_harga',
        'penilaian',
        'harga_terkoreksi',
        'alasan_tidak_lulus',
        'userid_created',
        'userid_updated',
    ];
}