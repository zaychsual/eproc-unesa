<?php

namespace App\Repositories;

use App\Models\Webprofile\JenisPengadaans;

class JenisPengadaanRepository
{
    private $model;

    public function __construct(JenisPengadaans $model)
    {
        $this->model = $model;
    }

    public function jenis_pengadaan($id = null, $status = 'ajax')
    {
        $data = $this->model
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })
            ->orderBy('id', 'asc')
            ->when($status, function ($query) use ($status) {
                if ($status == 'ajax') {
                    return $query->get();
                } else {
                    return $query->pluck('name', 'id');
                }
            });

        if ($status == 'ajax') {
            $kosong = "<option value=''>- Pilih Data -</option>";
            $return = '';
            foreach ($data as $value) {
                $return = $return . "<option value='$value->id'>$value->name</option>";
            }

            return $kosong . $return;
        } else {
            return $data;
        }
    }
}
