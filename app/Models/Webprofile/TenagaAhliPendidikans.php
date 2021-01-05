<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\TenagaAhlis;

class TenagaAhliPendidikans extends Model
{
  public $incrementing = false;
  protected $table = 'mt_tenaga_ahli_pendidikan';

  public static $rules = [];

  public static $errormessage = [
    'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

  protected $fillable = [
    'id', 'mt_tenaga_ahli_id', 'tahun', 'uraian', 'userid_created', 'userid_updated',
  ];

  public function rekanan()
  {
    return $this->hasMany(TenagaAhlis::class, 'id', 'tenagaahlipendidikans');
  }
}
