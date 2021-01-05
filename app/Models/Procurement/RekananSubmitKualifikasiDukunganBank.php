<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\BentukUsahas;
use App\Models\Webprofile\JenisPengadaans;
use App\Http\Traits\UuidTrait;

class RekananSubmitKualifikasiDukunganBank extends Model
{
    use UuidTrait;
    public $incrementing = false;
    protected $table = 'e_rekanan_submit_kualifikasi_dukungan_bank';

    public static $rules = [
        'paket_id' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'nama_bank',
        'nomor_surat',
        'tanggal',
        'nilai',
        'file_bukti_dukungan_bank',
        'userid_created',
        'userid_updated'
    ];
}