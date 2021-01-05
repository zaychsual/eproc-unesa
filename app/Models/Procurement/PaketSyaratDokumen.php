<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketSyaratDokumen extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_persyaratan_dokumen';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'masa_berlaku',
        'penawaran',
        'jaminan',
        'pengiriman_barang',
        'brosur',
        'jaminan_purnajual',
        'tenaga_teknis',
        'tipe',
        'userid_created',
        'userid_updated',
    ];
}