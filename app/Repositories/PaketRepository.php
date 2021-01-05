<?php

namespace App\Repositories;

use App\Models\Procurement\Pakets;

class PaketRepository
{
    private $model;

    public function __construct(Pakets $model)
    {
        $this->model = $model;
    }

    public function getMax()
    {
        $data = $this->model
            ->max('kode');

        if ($data == NULL) {
            $data = '100001';
        } else {
            $data = $data + 1;
        }

        return $data;
    }
}