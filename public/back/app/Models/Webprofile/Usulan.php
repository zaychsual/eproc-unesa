<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;

class Usulan extends Model
{
    public $incrementing = false;
    protected $table = 'swp_usulan';

    public static $rules = [
      'nama' => 'required',
      'nim' => 'required',
      'judul' => 'required',
      'alasan' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'nama', 'nim', 'judul', 'pengarang', 'penerbit', 'tahunterbit', 'alasan', 'status', 'tgl_setuju', 'userid_created', 'userid_updated',
  ];
}
