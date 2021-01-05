<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\MetodeKualifikasis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class MetodeKualifikasisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MetodeKualifikasis::orderBy('metode_kualifikasi', 'ASC')->get();

        return view('procurement.metodekualifikasis.index', compact('data'))->withTitle('Metode Kualifikasi');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('procurement.metodekualifikasis.create')->withTitle('Tambah Metode Kualifikasi');
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
        $validator = Validator::make($data, MetodeKualifikasis::$rules, MetodeKualifikasis::$errormessage);

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

            MetodeKualifikasis::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Tahun Berhasil !!";
            return redirect()->route('metodekualifikasis.index')->with('successMessage', $successmessage);
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
            $data = MetodeKualifikasis::find(Crypt::decrypt($id));
            return view('procurement.metodekualifikasis.edit', compact('data'))->withTitle('Ubah Metode Kualifikasi');
        } catch (\Exception $id) {
            return redirect()->route('metodekualifikasis.index');
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
        $categories = MetodeKualifikasis::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, MetodeKualifikasis::$rules, MetodeKualifikasis::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $categories->update($data);

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('metodekualifikasis.index');
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
            
            $status = MetodeKualifikasis::find(Crypt::decrypt($id));
            $status->delete();
           
            return redirect()->route('metodekualifikasis.index');
        } catch (\Exception $id) {
            return redirect()->route('metodekualifikasis.index');
        }
    }
}
