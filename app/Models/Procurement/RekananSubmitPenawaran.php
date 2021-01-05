<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\BentukUsahas;
use App\Models\Webprofile\JenisPengadaans;
use App\Http\Traits\UuidTrait;

class RekananSubmitPenawaran extends Model
{
    use UuidTrait;
    public $incrementing = false;
    protected $table = 'e_rekanan_submit_penawaran';

    public static $rules = [
        'paket_id' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'masa_berlaku',
        'is_setuju',
        'file_penawaran',
        'total_harga_penawaran',
        'harga_terkoreksi',
        'harga_negoisasi',
        'is_negoisasi',
        'userid_created',
        'userid_updated'
    ];

    public const BelumDiNego = 0;
    public const SudahDiNego = 1;

    public function getRekanan()
    {
        return $this->belongsTo(\App\Models\Procurement\Rekanans::class,'mt_rekanan_id');
    }

    public static function firstData($paket_id)
    {
        return RekananSubmitPenawaran::where('paket_id', $paket_id)
            ->where('mt_rekanan_id', \Auth::user()->mt_rekanan_id)
            ->first();
    }
}