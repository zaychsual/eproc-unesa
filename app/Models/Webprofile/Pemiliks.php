<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Rekanans;

class Pemiliks extends Model
{
    public $incrementing = false;
    protected $table = 'mt_pemilik';

    public static $rules = [
      'nama' => 'required',
      'ktp' => 'required',
      'alamat' => 'required',
      'saham' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'mt_rekanan_id', 'nama', 'ktp', 'alamat', 'saham', 'satuan', 'userid_created', 'userid_updated',
  ];

    public function rekanan()
    {
        return $this->hasMany(Rekanans::class, 'id', 'pemiliks');
    }
}
