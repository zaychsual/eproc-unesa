<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketSyaratLainnya extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_lembar_kualifikasi_lainnya';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'syarat',
        'userid_created',
        'userid_updated',
    ];
}