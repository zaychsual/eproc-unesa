<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Klarifikasi extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'mt_klarifikasi';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'klarifikasi',
        'is_metode',
        'userid_created',
        'userid_updated',
    ];
}