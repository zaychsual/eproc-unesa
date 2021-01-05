<?php

namespace App\Repositories;

use App\Models\Procurement\LogsApp;

class LogsAppRepository extends Repository
{
    public function __construct(LogsApp $model)
    {
        $this->model = $model;
    }

    public function get()
    {
    }

    public function log($status, $message)
    {
        if (auth()->user()) {
            $user = auth()->user()->id;
        } else {
            $user = null;
        }

        $log['status'] = $status;
        $log['message'] = $message;
        $log['user_id'] = $user;

        return $this->model->create($log);
    }


   
}
