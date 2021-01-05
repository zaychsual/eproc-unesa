<?php

namespace App\Repositories;

use App\Models\Webprofile\Kotas;

class KotaRepository
{
    private $model;

    public function __construct(Kotas $model)
    {
        $this->model = $model;
    }

    public function kota($id = null, $status = 'ajax')
    {
        $data = $this->model
            ->when($id, function ($query) use ($id) {
                return $query->where('mt_provinsi_id', '35');
            })
            ->orderBy('id', 'asc')
            ->when($status, function ($query) use ($status) {
                if ($status == 'ajax') {
                    return $query->where('mt_provinsi_id', '35')->get();
                } else {
                    return $query->where('mt_provinsi_id', '35')->pluck('nama', 'id');
                }
            });

        if ($status == 'ajax') {
            $kosong = "<option value=''>- Pilih Data -</option>";
            $return = '';
            foreach ($data as $value) {
                $return = $return . "<option value='$value->id'>$value->nama</option>";
            }

            return $kosong . $return;
        } else {
            return $data;
        }
    }
}
