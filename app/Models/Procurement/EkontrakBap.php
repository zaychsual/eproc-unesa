<?php

namespace App\Models\Procurement;


use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class EkontrakBap extends Model
{
	use UuidTrait;

    public $incrementing = false;
    protected $table = 'e_bap';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'mt_rekanan_id',
        'kotrak_id',
        'bap_no',
        'bap_tanggal',
        'bap_besar_pembayaran',
        'bap_progress_fisik',
        'bap_file_upload',
        'userid_created',
        'userid_updated',
    ];
}
