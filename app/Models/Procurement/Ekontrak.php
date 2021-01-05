<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Ekontrak extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_kontrak';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'kontrak_no',
        'kontrak_tanggal',
        'kontrak_unit_kerja',
        'kontrak_satuan_kerja_id',
        'kontrak_alamat_satker',
        'kontrak_jabatan_satker',
        'kontrak_no_sk_ppk',
        'kontrak_wakil_sah_penyedia',
        'kontrak_jabatan_wakil_penyedia',
        'kontrak_nama_bank',
        'kontrak_no_rekening_bank',
        'kontrak_nilai_kontrak',
        'kontrak_informasi_lainnya',
        'kontrak_dokumen',
        'ppk_id',
        'userid_created',
        'userid_updated'
    ];

    public function getRk()
    {
        return $this->belongsTo(\App\Models\Procurement\Rekanans::class,'mt_rekanan_id');
    }
}