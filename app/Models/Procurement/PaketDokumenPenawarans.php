<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketDokumenPenawarans extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_paket_dokumen_penawaran';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_dokumen_penawaran_id',
        'userid_created',
        'userid_updated',
    ];

    public const Administrasi = 1;
    public const Teknis = 2;
    public const Harga = 3;

    public function getDokPenawaran()
    {
        return $this->belongsTo(\App\Models\Procurement\DokumenPenawarans::class,'mt_dokumen_penawaran_id');
    }
}