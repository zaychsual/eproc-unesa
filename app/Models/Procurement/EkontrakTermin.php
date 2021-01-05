<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EkontrakTermin extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_termin_rekanan';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'kotrak_id',
        'bast_no',
        'bast_tanggal',
        'bast_file',
        'userid_created',
        'userid_updated',
    ];

}
