<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\BentukUsahas;
use App\Models\Webprofile\JenisPengadaans;

class Rekanans extends Model
{
  public $incrementing = false;
  // protected $connection = 'pgsql2';
  protected $table = 'mt_rekanan';

  public static $rules = [
    'nama' => 'required',
  ];

  public static $errormessage = [
    'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

  protected $fillable = [
    'id', 'kode', 'nama', 'mt_bentuk_usaha_id', 'alamat', 'kode_pos', 'provinsi_id', 'kota_id', 'is_kantor_cabang', 'npwp', 'nomor_pkp', 'telepon', 'fax', 'hp', 'website', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'is_syarat','is_npwp','is_ket','is_active','mt_jenis_pengadaan_id','userid_verifikasi','tgl_verifikasi','ip',
  ];

  public function rRekanan()
  {
    return $this->belongsTo(\App\User::class, 'id', 'mt_rekanan_id');
  }

  public function rBentukUsahas()
  {
    return $this->belongsTo(BentukUsahas::class, 'mt_bentuk_usaha_id');
  }

   public function rJenisPengadaans()
  {
    return $this->belongsTo(JenisPengadaans::class, 'mt_jenis_pengadaan_id');
  }


}
