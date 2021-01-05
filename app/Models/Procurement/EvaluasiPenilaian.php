<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EvaluasiPenilaian extends Model
{
    use UuidTrait;

    public const Administrasi = 1;
    public const Kualifikasi = 2;
    public const Teknis = 3;
    public const Harga = 4;
    public const Lulus = 1;
    public const TidakLulus = 0;

    public $incrementing = false;
    protected $table = 'e_evaluasi_penilaian';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'is_lulus',
        'is_doc_type',
        'alasan_tidak_lulus',
        'userid_created',
        'userid_updated',
    ];
}