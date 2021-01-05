<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Posts;

class Kotas extends Model
{
  public $incrementing = false;
  protected $table = 'mt_kota';

  public static $rules = [
    'name' => 'required',
  ];

  public static $errormessage = [
    'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

  protected $fillable = [
    'id', 'provinsi_id', 'nama',
  ];
}
