<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketLembarKualifikasi extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_paket_kualifikasi';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'id',
        'mt_kualifikasi_id',
        'paket_id',
        'userid_created','userid_updated'
    ];
}