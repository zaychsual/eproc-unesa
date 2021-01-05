<?php

namespace App\Models\Procurement;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PaketFile extends Model
{
    use UuidTrait;
    public const FileKak = 10;
    public const FileRancangan = 20;
    public const FileDukungDataHps = 30;
    
    public $incrementing = false;
    protected $table = 'e_paket_file';

    public static $rules = [
        'paket_id' => 'required',
    ];

    protected $fillable = [
        'paket_id',
        'files',
        'tanggal_upload',
        'tipe',
        'ukuran_file_dok',
        'tipe_file_dok',
        'userid_created',
        'userid_updated',
    ];
}