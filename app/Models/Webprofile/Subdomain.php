<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;

class Subdomain extends Model
{
    public $incrementing = false;
    protected $table = 'swp_subdomain';

    public static $rules = [
        'wildcard' => 'required|unique:swp_subdomain',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
        'unique' => 'Subdomain sudah ada',
    ];

    protected $fillable = [
        'id', 'nm_prodi', 'userid_created', 'userid_updated',
    ];
}
