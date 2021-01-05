<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\UuidTrait;

class PemberianPenjelasanPertanyaan extends Model
{

    use UuidTrait;
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_pemberian_penjelasan_pertanyaan';

    public static $rules = [
        'pemenang' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','mt_rekanan_id','paket_id','userid_created','userid_updated',
        'to_rekanan_id','author','uraian','attachment','bab','dokumen','is_jawaban'
    ];

    public function getRekanan()
    {
        return $this->belongsTo(\App\Models\Procurement\Rekanans::class,'mt_rekanan_id');
    }
}

