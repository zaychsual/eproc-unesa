<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketRekanan extends Model
{
    use UuidTrait;

    public const Pemenang = 1;
    public const TahapanDownloadDokumenPemilihan = 12;
    // public const TahapanPemasukanDokumenPenawaran = 13;
    // public const TahapanPembukaanDokumenPenawaran = 14;
    // public const EvaluasiDokumenPenawaran = 14;
    // public const KlarifikasiDanNegoisasi = 14;
    // public const PenetapanPemenang = 14;
    // public const PembuatanBeritaAcara = 14;

    public $incrementing = false;
    protected $table = 'e_paket_rekanan';
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'paket_id', 'mt_rekanan_id', 'userid_created', 'userid_updated','is_winner','urutan_pemenang','status_tahapan',
        'is_negoisasi','is_kirim_undangan'
    ];

    public const Approved = 1;
    public const SudahKirim = 1;

    public function get_paket()
    {
        return $this->belongsTo(\App\Models\Procurement\Pakets::class,'paket_id','id');
    }

    public function getMtRekanan()
    {
        return $this->belongsTo(\App\Models\Procurement\Rekanans::class,'mt_rekanan_id');
    }

    public static function getPemenang($paket_id, $rekanan_id)
    {
        return PaketRekanan::where('paket_id', $paket_id)
        ->where('mt_rekanan_id', $rekanan_id)
        ->where('is_winner',Self::Pemenang)
        ->first();
    }
}