<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\JenisKontraks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class JenisKontraksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JenisKontraks::orderBy('jeniskontrak', 'ASC')->get();

        return view('procurement.jeniskontraks.index', compact('data'))->withTitle('Jenis Kontrak');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('procurement.jeniskontraks.create')->withTitle('Tambah Jenis Kontrak');
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
        $validator = Validator::make($data, JenisKontraks::$rules, JenisKontraks::$errormessage);

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

            JenisKontraks::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Jenis Kontrak Berhasil !!";
            return redirect()->route('jeniskontraks.index')->with('successMessage', $successmessage);
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
            $data = JenisKontraks::find(Crypt::decrypt($id));
            return view('procurement.jeniskontraks.edit', compact('data'))->withTitle('Ubah Jenis Kontrak');
        } catch (\Exception $id) {
            return redirect()->route('jeniskontraks.index');
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
        $categories = JenisKontraks::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, JenisKontraks::$rules, JenisKontraks::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $categories->update($data);

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('jeniskontraks.index');
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
            
            $status = JenisKontraks::find(Crypt::decrypt($id));
            $status->delete();
           
            return redirect()->route('jeniskontraks.index');
        } catch (\Exception $id) {
            return redirect()->route('jeniskontraks.index');
        }
    }
}
