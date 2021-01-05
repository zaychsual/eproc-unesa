<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Rekanans;

class Pengurus extends Model
{
    public $incrementing = false;
    protected $table = 'mt_pengurus';

    public static $rules = [
      'nama' => 'required',
      'ktp' => 'required',
      'jabatan' => 'required',
      'tanggal_awal' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'mt_rekanan_id', 'nama', 'ktp', 'alamat', 'jabatan', 'tanggal_awal', 'tanggal_akhir', 'userid_created', 'userid_updated',
  ];

    public function rekanan()
    {
        return $this->hasMany(Rekanans::class, 'id', 'pengurus');
    }
}
