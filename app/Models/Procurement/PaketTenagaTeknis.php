<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketTenagaTeknis extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_lembar_kualifikasi_tk';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'jenis_kemampuan',
        'kemampuan_teknis',
        'kemampuan_manajerial',
        'pengalaman',
        'userid_created',
        'userid_updated',
    ];
}