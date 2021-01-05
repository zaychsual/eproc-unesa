<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Posts;

class BentukUsahas extends Model
{
  public $incrementing = false;
  protected $table = 'mt_bentuk_usaha';

  public static $rules = [
    'name' => 'required',
  ];

  public static $errormessage = [
    'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

  protected $fillable = [
    'id', 'name', 'userid_created', 'userid_updated', 'is_active',
  ];
}
