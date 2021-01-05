<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\TenagaAhlis;

class TenagaAhliBahasas extends Model
{
  public $incrementing = false;
  protected $table = 'mt_tenaga_ahli_bahasa';

  public static $rules = [];

  public static $errormessage = [
    'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

  protected $fillable = [
    'id', 'mt_tenaga_ahli_id', 'uraian', 'userid_created', 'userid_updated',
  ];

  public function rekanan()
  {
    return $this->hasMany(TenagaAhlis::class, 'id', 'tenagaahlibahasas');
  }
}
