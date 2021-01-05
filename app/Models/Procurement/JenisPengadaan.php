<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\UuidTrait;

class JenisPengadaan extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_jenispengadaan';

    protected $fillable = [
        'id',
        'jenispengadaan',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_active',
    ];

    public static function getName($value)
    {
        return JenisPengadaan::where('id', $value)->select('jenispengadaan')->first();
    }
}
