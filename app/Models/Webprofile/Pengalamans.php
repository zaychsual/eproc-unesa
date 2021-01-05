<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Rekanans;

class Pengalamans extends Model
{
  public $incrementing = false;
  protected $table = 'mt_pengalaman';

  public static $rules = [
    'nama' => 'required',
    'lokasi' => 'required',
    'instansi' => 'required',
    'nilai_kontrak' => 'required',
    'persen_pelaksanaan' => 'required',
  ];

  public static $errormessage = [
    'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

  protected $fillable = [
    'id', 'mt_rekanan_id', 'nama', 'lokasi', 'instansi', 'alamat', 'telepon', 'no_kontrak', 'nilai_kontrak', 'tanggal_pelaksanaan', 'persen_pelaksanaan', 'tanggal_selesai', 'tanggal_serah_terima', 'keterangan', 'userid_created', 'userid_updated',
  ];

  public function rekanan()
  {
    return $this->hasMany(Rekanans::class, 'id', 'pengalamans');
  }
}
