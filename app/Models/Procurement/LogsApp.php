<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class LogsApp extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_logapp';

    protected $fillable = [
        'id', 'user_id', 'message', 'status',
    ];


    public function rUsers()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
