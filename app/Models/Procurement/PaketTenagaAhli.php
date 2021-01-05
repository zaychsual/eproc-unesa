<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketTenagaAhli extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_lembar_kualifikasi_ta';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'jenis_keahlian',
        'keahlian',
        'pengalaman',
        'userid_created',
        'userid_updated',
    ];
}