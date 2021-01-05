<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketDokumen extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_dokumen_pemilihan';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'nomor_dokumen',
        'tanggal_dokumen',
        'dokumen',
        'userid_created',
        'userid_updated',
    ];
}