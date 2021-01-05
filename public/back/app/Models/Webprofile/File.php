<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public $incrementing = false;
    protected $table = 'swp_file';

    public static $rules = [
        'title' => 'required',
        'file' => 'required',
    ];

    public static $rulese = [
        'title' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];
    
    protected $fillable = [
        'id', 'title', 'content', 'file', 'is_active', 'userid_created', 'userid_updated', 'categories_file', 'downloaded', 'slug',
    ];

    public function rCategoryFile()
    {
        return $this->belongsTo(CategoriesFile::class, 'categories_file', 'id');
    }
}
