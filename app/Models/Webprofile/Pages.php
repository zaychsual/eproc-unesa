<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Categories;

class Pages extends Model
{
    public $incrementing = false;
    protected $table = 'swp_pages';

    public static $rules = [
      'title' => 'required',
      'content' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'title', 'content', 'thumbnail', 'post_date', 'posts_status', 'posts_password', 'comment_status', 'viewer', 'comment_count', 'userid_created', 'userid_updated', 'slug',
  ];
}
