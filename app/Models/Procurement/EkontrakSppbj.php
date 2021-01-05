<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EkontrakSppbj extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_kontrak_sppbj';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'kontrak_id',
        'sppbj_no',
        'sppbj_lampiran',
        'sppbj_kota',
        'sppbj_tanggal',
        'sppbj_harga_final',
        'sppbj_nilai_jaminan',
        'sppbj_tembusan',
        'userid_created',
        'userid_updated',
        'ppk_id'
    ];

    public function getRk()
    {
        return $this->belongsTo(\App\Models\Procurement\Rekanans::class,'mt_rekanan_id');
    }
}