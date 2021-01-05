<?php

namespace App\Models\Webprofile;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
	use UuidTrait;

    public $incrementing = false;
    protected $table = 'mt_unit_kerja';

    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'alamat',
        'laman',
        'userid_created',
        'userid_updated',
    ];
}
