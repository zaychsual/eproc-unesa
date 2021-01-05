<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Peralatans;

class Statusmiliks extends Model
{
  public $incrementing = false;
  protected $table = 'mt_stts_kepemilikan';

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
