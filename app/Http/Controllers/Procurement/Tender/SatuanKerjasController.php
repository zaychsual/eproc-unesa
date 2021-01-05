<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\SatuanKerjas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class SatuanKerjasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SatuanKerjas::orderBy('satuankerja', 'ASC')->get();

        return view('procurement.satuankerjas.index', compact('data'))->withTitle('Satuan Kerja');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('procurement.satuankerjas.create')->withTitle('Tambah Satuan Kerja');
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
        $validator = Validator::make($data, SatuanKerjas::$rules, SatuanKerjas::$errormessage);

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

            SatuanKerjas::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Satuan Kerja Berhasil !!";
            return redirect()->route('satuankerjas.index')->with('successMessage', $successmessage);
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
            $data = SatuanKerjas::find(Crypt::decrypt($id));
            return view('procurement.satuankerjas.edit', compact('data'))->withTitle('Ubah Satuan Kerja');
        } catch (\Exception $id) {
            return redirect()->route('satuankerjas.index');
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
        $categories = SatuanKerjas::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, SatuanKerjas::$rules, SatuanKerjas::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $categories->update($data);

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('satuankerjas.index');
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
            
            $status = SatuanKerjas::find(Crypt::decrypt($id));
            $status->delete();
           
            return redirect()->route('satuankerjas.index');
        } catch (\Exception $id) {
            return redirect()->route('satuankerjas.index');
        }
    }
}
