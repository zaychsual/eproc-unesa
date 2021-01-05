<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Rekanans;

class Ijinusahas extends Model
{
    public $incrementing = false;
    protected $table = 'mt_ijin_usaha';

    public static $rules = [
      'jenis_ijin' => 'required',
      'berlaku_sampai' => 'required',
      'nomor_surat' => 'required',
      'instansi' => 'required',
      'kualifikasi' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'mt_rekanan_id', 'jenis_ijin', 'nomor_surat', 'berlaku_sampai', 'instansi', 'klasifikasi', 'kualifikasi', 'link_file', 'userid_created', 'userid_updated',
  ];

    public function rekanan()
    {
        return $this->hasMany(Rekanans::class, 'id', 'ijinusahas');
    }
}
