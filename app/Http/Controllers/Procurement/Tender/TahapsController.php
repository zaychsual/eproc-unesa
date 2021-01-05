<?php

namespace App\Http\Controllers\Procurement\Tender;

use App\Models\Procurement\Tahaps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class TahapsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahap = Tahaps::orderBy('urut', 'ASC')->get();

        return view('procurement.tahaps.index', compact('tahap'))->withTitle('Tahap');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('procurement.tahaps.create')->withTitle('Tambah Tahap');
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
        $validator = Validator::make($data, Tahaps::$rules, Tahaps::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('tahaps.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();

            $data['id'] = $uuid;
            $data['is_active'] = 1;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Tahaps::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Kategori Berhasil !!";
            return redirect()->route('tahaps.index')->with('successMessage', $successmessage);
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
            $data = Tahaps::find(Crypt::decrypt($id));
            return view('procurement.tahaps.edit', compact('data'))->withTitle('Ubah Tahap');
        } catch (\Exception $id) {
            return redirect()->route('tahaps.index');
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
        $categories = Tahaps::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, Tahaps::$rules, Tahaps::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $categories->update($data);

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('tahaps.index');
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
            
            $tahap = Tahaps::find(Crypt::decrypt($id));
            $tahap->delete();
           
            return redirect()->route('tahaps.index');
        } catch (\Exception $id) {
            return redirect()->route('tahaps.index');
        }
    }
}
