<?php

namespace App\Models\Webprofile;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    public $incrementing = false;
    protected $table = 'swp_design';

    protected $fillable = [
        'id', 'row1', 'row2', 'row3', 'row4', 'userid_created', 'userid_updated',
    ];
}
