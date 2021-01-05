<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketJadwalPengadaan extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_paket_jadwal_pengadaan';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'id','paket_id','dok_penawaran_mulai','dok_penawaran_selesai',
        'dok_pembukaan_penawaran_mulai','dok_pembukaan_penawaran_selesai',
        'dok_evaluasi_penawaran_mulai','dok_evaluasi_penawaran_selesai',
        'dok_klarifikasi_teknis_mulai','dok_klarifikasi_teknis_selesai',
        'dok_ttd_kontrak_mulai','dok_ttd_kontrak_selesai','userid_created','userid_updated'
    ];
}