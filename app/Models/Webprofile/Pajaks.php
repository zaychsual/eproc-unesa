<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Rekanans;

class Pajaks extends Model
{
    public $incrementing = false;
    protected $table = 'mt_pajak';

    public static $rules = [
      'jenis' => 'required',
      'masa_pajak_tahun' => 'required',
      'nomor_bukti' => 'required',
      'tanggal_bukti' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'mt_rekanan_id', 'jenis', 'masa_pajak_tahun', 'nomor_bukti', 'tanggal_bukti', 'thumbnail', 'userid_created', 'userid_updated',
  ];

    public function rekanan()
    {
        return $this->hasMany(Rekanans::class, 'id', 'pajaks');
    }
}
