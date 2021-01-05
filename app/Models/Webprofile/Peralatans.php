<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Rekanans;
use App\Models\Webprofile\Statusmiliks;

class Peralatans extends Model
{
    public $incrementing = false;
    protected $table = 'mt_peralatan';

    public static $rules = [
      'nama' => 'required',
      'jumlah' => 'required',
      'tahun_pembuatan' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'mt_rekanan_id', 'nama', 'jumlah', 'kapasitas', 'merk', 'tahun_pembuatan', 'kondisi', 'lokasi', 'status_kepemilikan', 'bukti', 'link_file', 'userid_created', 'userid_updated',
  ];

    public function rekanan()
    {
        return $this->hasMany(Rekanans::class, 'id', 'peralatans');
    }

    public function statusmilik()
    {
        return $this->belongsTo(Statusmiliks::class, 'mt_stts_kepemilikan', 'id');
    }
}
