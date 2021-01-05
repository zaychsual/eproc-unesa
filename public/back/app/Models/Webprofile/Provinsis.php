<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Posts;

class Provinsis extends Model
{
  public $incrementing = false;
  protected $table = 'mt_provinsi';

  public static $rules = [
    'name' => 'required',
  ];

  public static $errormessage = [
    'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

  protected $fillable = [
    'id', 'nama',
  ];
}
