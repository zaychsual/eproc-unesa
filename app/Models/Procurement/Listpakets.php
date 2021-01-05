<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;

class Listpakets extends Model
{
    public $incrementing = false;
    protected $table = 'v_paket';
    public const Publish = 1;
    public const Draft = 0;

    // public const TypeStatus = 

    public static $rules = [
      'id' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'kode', 'nama_paket', 'tanggal', 'pagu', 'nilai_hps', 'link_file_kak', 'link_file_kontrak', 'link_file_lainnya', 'created_at', 'status', 'satuankerja', 'tahun', 'jenispengadaan', 'kualifikasi', 'pemenang', 'jeniskontrak', 'klpd','link', 'kode_rup','prop','kota','alamat',
      'link','setting_unduh_buka','setting_unduh_tutup',
  ];

    public function rekanan()
    {
        return $this->hasMany(Pakets::class, 'id', 'nama');
    }

    public function rRekanan()
    {
        return $this->belongsTo(PaketRekanan::class, 'id', 'paket_id');
    }
}
