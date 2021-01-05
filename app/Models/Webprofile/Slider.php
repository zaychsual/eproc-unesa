<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $incrementing = false;
    protected $table = 'swp_sliders';

    public static $rules = [
        'title' => 'required',
        'images' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id', 'title', 'content', 'images', 'is_active', 'userid_created', 'userid_updated',
    ];
}
