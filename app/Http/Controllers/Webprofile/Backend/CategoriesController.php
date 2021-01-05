<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Categories::orderBy('name', 'ASC')->get();

        return view('webprofile.backend.categories.index', compact('data'))->withTitle('Kategori');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.categories.create')->withTitle('Tambah Kategori');
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
        $validator = Validator::make($data, Categories::$rules, Categories::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('categories.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();

            $data['id'] = $uuid;
            $data['is_active'] = 1;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Categories::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Kategori Berhasil !!";
            return redirect()->route('categories.index')->with('successMessage', $successmessage);
        }
    }

    public function categories_aktif($id)
    {
        Categories::where('id', Crypt::decrypt($id))->update([
          'is_active' => '1',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('categories.index');
    }

    public function categories_naktif($id)
    {
        Categories::where('id', Crypt::decrypt($id))->update([
          'is_active' => '0',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('categories.index');
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
            $data = Categories::find(Crypt::decrypt($id));
            return view('webprofile.backend.categories.edit', compact('data'))->withTitle('Ubah Kategori');
        } catch (\Exception $id) {
            return redirect()->route('categories.index');
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
        $categories = Categories::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, Categories::$rules, Categories::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $categories->update($data);

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('categories.index');
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
            Categories::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('categories.index');
        } catch (\Exception $id) {
            return redirect()->route('categories.index');
        }
    }
}
