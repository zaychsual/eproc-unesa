<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $incrementing = false;
    protected $table = 'swp_setting';

    public static $rules = [
      'name_setting' => 'required',
      'value_setting' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'name_setting', 'value_setting', 'userid_created', 'userid_updated',
  ];
}
