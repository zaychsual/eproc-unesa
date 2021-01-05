<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\BentukUsahas;
use App\Models\Webprofile\JenisPengadaans;
use App\Http\Traits\UuidTrait;

class RekananSubmitDokumenPenawarans extends Model
{
    use UuidTrait;
    public $incrementing = false;
    protected $table = 'e_rekanan_submit_dokumen_penawaran';

    public static $rules = [
        'paket_id' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'dokumen_penawaran_id',
        'file',
        'file_size',
        'file_path',
        'is_dokumen',
        'userid_created',
        'userid_updated'
    ];

}