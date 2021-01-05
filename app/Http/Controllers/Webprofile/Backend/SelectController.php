<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Kotas;
use App\Http\Controllers\Controller;
use App\Repositories\KotaRepository;
use Illuminate\Http\Request;

class SelectController extends Controller
{
    public function kota($provinsi)
    {
        $modelKota = new Kotas;
        $kota = new KotaRepository($modelKota);

        return $kota->kota($provinsi);
    }
}
