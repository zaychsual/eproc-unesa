<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EvaluasiDokumenPenawaran extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_evaluasi_dokumen_penawarans';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'mt_dokumen_penawaran_id',
        'memenuhi',
        'userid_created',
        'userid_updated',
    ];
}