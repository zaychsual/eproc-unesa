<?php

namespace App\Repositories;

use App\Models\Webprofile\Provinsis;

class ProvinsiRepository
{
    private $model;

    public function __construct(Provinsis $model)
    {
        $this->model = $model;
    }

    public function provinsi($status = 'ajax')
    {
        $data = $this->model
            ->orderBy('id', 'asc')
            ->when($status, function ($query) use ($status) {
                if ($status == 'ajax') {
                    return $query->get();
                } else {
                    return $query->pluck('nama', 'id');
                }
            });

        if ($status == 'ajax') {
            $kosong = "<option value=''>- Pilih -</option>";
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
