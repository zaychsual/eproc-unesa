<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Ebap extends Model
{
    use UuidTrait;

    public $incrementing = false;
    public $table = 'e_baps';

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'bap_no',
        'bap_tanggal',
        'bap_mulai',
        'bap_selesai',
        'bap_tempat',
        'userid_created',
        'userid_updated'
    ];
}
