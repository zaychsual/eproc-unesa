<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;

class Newmenu extends Model
{
    public $incrementing = false;
    protected $table = 'swp_newmenu';

    public static $rules = [
      // 'name' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'name', 'url', 'mode', 'status', 'userid_created', 'userid_updated', 'parent', 'urutan', 'level', 'parentlevel',
  ];
}
