<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;

class Tenders extends Model
{
    public $incrementing = false;
    protected $table = 'e_tender';

    public static $rules = [
        'kode' => 'required',
        'nama' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','paket_id','kode','nama','tanggal','keterangan','jenis_pengadaan','metode_pemilihan','metode_kualifikasi','metode_dokumen','metode_evaluasi','kualifikasi_usaha','penetapan_pemenang','link_file_persyaratan_kualifikasi','userid_created','userid_updated',
    ];
}

