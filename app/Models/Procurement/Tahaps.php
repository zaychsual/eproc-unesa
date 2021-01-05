<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tahaps extends Model
{


    use SoftDeletes;
    const TenderTerbuka = 'Tender Terbuka';
    const Tender        = 2;
    const NonTender        = 1;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_tahap';

    public static $rules = [
        'nama' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','nama','keterangan','urut','status_hapus','userid_created','userid_updated',
    ];

    public static function getTahapanTenderTerbuka()
    {
        return Tahaps::where('keterangan',Self::TenderTerbuka)
            ->where('type', Self::Tender)
            ->get();
    }   
}

