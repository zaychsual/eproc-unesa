<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Rekanans;

class TenagaAhlis extends Model
{
  public $incrementing = false;
  protected $table = 'mt_tenaga_ahli';

  public static $rules = [
    'nama' => 'required',
    'tanggal_lahir' => 'required',
    'alamat' => 'required',
    'pendidikan_terakhir' => 'required',
    'keahlian' => 'required',
    'jenis_kelamin' => 'required',
    'pengalaman_kerja' => 'required',
    'status_kepegawaian' => 'required',
  ];

  public static $errormessage = [
    'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

  protected $fillable = [
    'id', 'mt_rekanan_id', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'kewarganegaraan', 'alamat', 'pengalaman_kerja', 'pendidikan_terakhir', 'status_kepegawaian', 'email', 'jabatan', 'keahlian', 'userid_created', 'userid_updated',
  ];

  public function rekanan()
  {
    return $this->hasMany(Rekanans::class, 'id', 'tenagaahlis');
  }
}
