<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EkontrakSpp extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_kontrak_spp';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'kotrak_id',
        'spp_no',
        'spp_tanggal',
        'spp_wakil_sah_penyedia',
        'spp_jabatan_wakil_penyedia',
        'spp_tgl_brg_diterima',
        'spp_waktu_penyelesaian',
        'spp_tgl_pekerjaan_selesai',
        'spp_alamat_pengiriman',
        'spp_kota',
        'spp_jaminan_cacat',
        'userid_created',
        'userid_updated',
    ];
}
 