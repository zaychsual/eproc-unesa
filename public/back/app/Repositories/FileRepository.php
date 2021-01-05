<?php

namespace App\Repositories;

use App\Models\Webprofile\File;

class FileRepository
{
    private $model;
    public function __construct(File $model)
    {
        $this->model = $model;
    }

    public function find($with = null, $id = null, $file = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })
            ->when($file, function ($query) use ($file) {
                return $query->where('file', $file);
            })
            ->firstOrFail();
    }

    public function is_url_exist($url)
    {
        stream_context_set_default([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);
        
        $headers = get_headers($url);
        return stripos($headers[0], "200 OK") ? true : false;
    }

    public function countDownload(File $file)
    {
        $file->downloaded = $file->downloaded + 1;
        return $file->save();
    }
}
