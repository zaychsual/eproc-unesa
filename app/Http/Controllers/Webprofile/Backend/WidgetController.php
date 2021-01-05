<?php

namespace App\Http\Controllers\Webprofile\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Webprofile\Design;
use App\Helpers\InseoHelper;
use Auth;
use Validator;
use Alert;
use Uuid;
use Session;
use Crypt;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($pos)
    {
        return view('webprofile.backend.widget.create', compact('pos'))->withTitle('Tambah Halaman');
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
        $validator = Validator::make($data, Design::$rules, Design::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('widget.createc')
              ->withErrors($validator)
              ->withInput();
        }

        $cekurut = Design::where('name_design', $request->input('name_design'))->max('urutan');

        $uuid = Uuid::generate();

        $data['id'] = $uuid;
        $data['urutan'] = $cekurut+1;
        $data['userid_created'] = Auth::user()->name;
        $data['userid_updated'] = Auth::user()->name;
        
        Design::create($data);
        
        Alert::success('Footer berhasil diubah')->persistent('Ok');
        return redirect()->route('layouts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Design::find(Crypt::decrypt($id));

            return view('webprofile.backend.widget.edit', compact('data'))->withTitle('Ubah Widget');
        } catch (\Exception $id) {
            return redirect()->route('layout.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $layouts = Design::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, Design::$rules, Design::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $layouts->update($data);

        Alert::success('Footer berhasil diubah')->persistent('Ok');
        return redirect()->route('layouts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Design::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('layouts.index');
        } catch (\Exception $id) {
            return redirect()->route('layouts.index');
        }
    }
}
