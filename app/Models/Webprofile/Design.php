<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    public $incrementing = false;
    protected $table = 'swp_design';

    protected $fillable = [
        'id', 'name_design', 'value_design', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'title_design', 'urutan',
    ];

    public static $rules = [
        'title_design' => 'required',
        'value_design' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];
}
