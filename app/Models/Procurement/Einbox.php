<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Einbox extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_inbox';

    protected $fillable = [
        'user_id',
        'user_to_id',
        'subject',
        'message',
        'attachment',
        'is_read',
    ];
}
