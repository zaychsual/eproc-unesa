<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\UuidTrait;

class EPaketCategory extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_paket_category';

    protected $fillable = [
        'id',
        'name',
        'code',
        'validasi',
    ];

    public static function getName($value)
    {
        return EPaketCategory::where('id', $value)->select('name')->first();
    }
}
