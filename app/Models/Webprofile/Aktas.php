<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Rekanans;

class Aktas extends Model
{
    public $incrementing = false;
    protected $table = 'mt_akta';

    public static $rules = [
      'pendirian_nomor' => 'required',
      'pendirian_tanggal' => 'required',
      'pendirian_notaris' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'mt_rekanan_id', 'pendirian_nomor', 'pendirian_tanggal', 'pendirian_notaris', 'pendirian_link_file', 'perubahan_nomor', 'perubahan_tanggal', 'perubahan_notaris', 'perubahan_link_file', 'userid_created', 'userid_updated', 'is_terisi',
  ];

    public function rekanan()
    {
        return $this->hasMany(Rekanans::class, 'id', 'aktas');
    }
}
