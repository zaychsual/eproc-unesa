<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Webprofile\Categories;

class Posts extends Model
{
    public $incrementing = false;
    protected $table = 'swp_posts';

    public static $rules = [
      'title' => 'required',
      'content' => 'required',
      'categories' => 'required',
      'post_date' => 'required',
  ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
  ];

    protected $fillable = [
      'id', 'title', 'content', 'categories', 'thumbnail', 'post_date', 'posts_status', 'posts_password', 'comment_status', 'viewer', 'comment_count', 'userid_created', 'userid_updated', 'slug', 'author','email','keyword','abstract','issni','link','tipe_file','ukuran_file',
  ];

    public function kategori()
    {
        return $this->belongsTo(Categories::class, 'categories', 'id');
    }
}
