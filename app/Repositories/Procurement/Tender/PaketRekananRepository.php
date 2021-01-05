<?php

namespace App\Repositories\Procurement\Tender;

use App\Models\Procurement\PaketRekanan;
use App\Repositories\Repository;

class PaketRekananRepository extends Repository
{
    protected $model;

    public function __construct(PaketRekanan $model)
    {
        $this->model = $model;
    }

    public function get()
    {
    }

    public function register($data)
    {
        $this->model->updateOrCreate(
            [
                'paket_id' => $data['paket_id'],
                'mt_rekanan_id' => $data['mt_rekanan_id'],
            ],
            $data
        );
    }
}
