<?php

namespace App\Repositories;

use App\Models\Webprofile\Rekanans;

class RekananRepository
{
    private $model;

    public function __construct(Rekanans $model)
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
