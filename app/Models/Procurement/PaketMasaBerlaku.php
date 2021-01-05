<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketMasaBerlaku extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_masa_berlaku';
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'paket_id', 'masa_berlaku', 'userid_created', 'userid_updated',
    ];
}