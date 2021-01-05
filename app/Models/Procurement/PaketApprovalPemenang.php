<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketApprovalPemenang extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_paket_approval_pemenang';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'pokja_id',
        'status',
        'reason',
        'userid_created',
        'userid_updated',
    ];
}