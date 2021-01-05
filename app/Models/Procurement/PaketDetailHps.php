<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketDetailHps extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_paket_hps_detail';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'jenis_barang_jasa',
        'satuan',
        'qty',
        'harga',
        'pajak',
        'keterangan',
        'userid_created',
        'userid_updated',
    ];
}