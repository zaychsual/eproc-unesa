<?php

namespace App\Repositories;

use Storage;

abstract class Repository
{
    protected $model;

    abstract public function get();

    /**
     * Display specified resource.
     *
     * @param varchar $with
     * @param uuid    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function findId($id = null, $with = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })
            ->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $request['userid_created'] = auth()->user()->id;

        return $this->model->create($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Model                    $model
     *
     * @return \Illuminate\Http\Response
     */
    public function update($request, $model)
    {
        $request['userid_updated'] = auth()->user()->id;

        return $model->update($request);
    }

    /**
     * Show the specified resource in storage.
     *
     * @param uuid $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->model->where('user_id', $id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Model $model
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($model)
    {
        return $model->delete();
    }

    public function upload($name, $request, $tipe, $setting = 'internal')
    {
        $cover = $request->file($tipe);
        if ($setting != 'internal') {
            Storage::disk('storage')->put($setting['directory'].'/'.$tipe.'/'.$name, file_get_contents($cover->getRealPath()));
        } else {
            Storage::disk('local')->put('public/'.$tipe.'/'.$name, file_get_contents($cover->getRealPath()));
        }

        return $name;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Model $model
     *
     * @return \Illuminate\Http\Response
     */
    public function deletefile($model, $tipe, $setting = 'internal')
    {
        if ($model->$tipe) {
            if ($setting != 'internal') {
                Storage::disk('storage')->delete($setting['directory'].'/'.$tipe.'/'.$model->$tipe);
            } else {
                Storage::disk('local')->delete('public/'.$tipe.'/'.$model->$tipe);
            }
        }
    }
}
