<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logs extends Model
{

    use SoftDeletes;
 
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $table = 'e_log';

    public static $rules = [
        'id' => 'required'
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id','mt_rekanan_id','last_login','last_logout','ip_address','browser_login','browser_version','device_login','device_version','current_location','language','root','https','users_id',
    ];
}