<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EkontrakUndangan extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_kontrak_undangan';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'undangan_waktu_mulai',
        'undangan_waktu_selesai',
        'undangan_tempat',
        'undangan_yg_dibawa',
        'undangan_yg_harus_hadir',
        'userid_created',
        'userid_updated',
    ];

    public function getRk()
    {
        return $this->belongsTo(\App\Models\Procurement\Rekanans::class,'mt_rekanan_id');
    }
}