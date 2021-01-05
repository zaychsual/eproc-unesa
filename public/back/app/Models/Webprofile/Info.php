<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    public $incrementing = false;
    protected $table = 'swp_info';

    public static $rules = [
      'title' => 'required',
      'content' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'title', 'content', 'info_status', 'viewer', 'slug', 'userid_created', 'userid_updated', 'event_date'
  ];
}
