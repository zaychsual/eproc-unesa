<?php

namespace App\Http\Controllers\Procurement;

use App\Models\Procurement\Dokumens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class DokumensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Dokumens::orderBy('dokumen', 'ASC')->get();

        return view('procurement.dokumens.index', compact('data'))->withTitle('Dokumen');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('procurement.dokumens.create')->withTitle('Tambah Dokumen');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, Dokumens::$rules, Dokumens::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('statuss.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();

            $data['id'] = $uuid;
            
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Dokumens::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Dokumen Berhasil !!";
            return redirect()->route('dokumens.index')->with('successMessage', $successmessage);
        }
    }


   

   
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Dokumens::find(Crypt::decrypt($id));
            return view('procurement.dokumens.edit', compact('data'))->withTitle('Ubah Dokumen');
        } catch (\Exception $id) {
            return redirect()->route('dokumens.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categories = Dokumens::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, Dokumens::$rules, Dokumens::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $categories->update($data);

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('dokumens.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            
            $status = Dokumens::find(Crypt::decrypt($id));
            $status->delete();
           
            return redirect()->route('dokumens.index');
        } catch (\Exception $id) {
            return redirect()->route('dokumens.index');
        }
    }
}
