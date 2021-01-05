<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EkontrakSskk extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_kontrak_sskk';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'file_sskk',
        'cara_pembayaran',
        'userid_created',
        'userid_updated',
    ];

    public function getRk()
    {
        return $this->belongsTo(\App\Models\Procurement\Rekanans::class,'mt_rekanan_id');
    }
}