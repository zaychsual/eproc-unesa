<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $incrementing = false;
    // protected $connection = 'pgsql2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'role', 'is_active', 'userid_created', 'userid_updated', 'nohp', 'mt_rekanan_id','last_login','ip_address','browser_login','browser_version','device_login','device_version','language','root','https','id_jenis_pengadaan',
        'nomor_sertifikat','file_sertifikat','is_validate','is_validate_ukpbj','mt_unit_kerja_id','nip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public const Active = 1;
    public const NotActive = 0;
    public const ValidateYes = 1;
    public const ValidateNo = 3;
    public const WaitingForValidate = 0;
    public const WaitingValidateUkpbj = 1;
    public const RejectedUkpbj = 3;
    public const ValidateUkpbj = 2;
}