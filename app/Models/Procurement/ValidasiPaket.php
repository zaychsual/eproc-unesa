<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;

class ValidasiPaket extends Model
{
    protected $table = 'validasi_pakets';

    protected $fillable = [
        'id',
        'category_id',
        'jenis_pengadaan_id',
        'nilai_hps',
        'is_active',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at'
    ];

    public function getCategory()
    {
        return $this->belongsTo(\App\Models\Procurement\EPaketCategory::class, 'category_id');
    }

    public function getPengadaan()
    {
        return $this->belongsTo(\App\Models\Procurement\JenisPengadaan::class, 'jenis_pengadaan_id');
    }
}
