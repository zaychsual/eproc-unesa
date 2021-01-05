<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EKontrakSpk extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_kontrak_spk';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'kotrak_id',
        'spk_no',
        'spk_kota',
        'spk_tanggal',
        'spk_wakil_sah_penyedia',
        'spk_jabatan_wakil_penyedia',
        'spk_nilai_kotrak',
        'spk_tanggal_mulai_kerja',
        'spk_wkt_penyelesaian',
        'nama_bank',
        'no_rek',
        'nama_ppk',
        'satuan_kerja',
        'nama_penyedia',
        'alamat_penyedia',
        'spk_file',
        'created_at',
        'updated_at',
    ];

    public function getRk()
    {
        return $this->belongsTo(\App\Models\Procurement\Rekanans::class,'mt_rekanan_id');
    }
}
