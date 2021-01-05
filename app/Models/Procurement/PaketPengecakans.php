<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketPengecekans extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_paket_pengecekan';
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'paket_id', 'mt_rekanan_id','pengendali_kualitas_id','tanggal','remark_pengecekan', 'userid_created', 'userid_updated',
    ];
}