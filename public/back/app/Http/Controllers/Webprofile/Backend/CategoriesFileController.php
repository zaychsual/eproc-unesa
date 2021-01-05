<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\CategoriesFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class CategoriesFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CategoriesFile::orderBy('name', 'ASC')->get();

        return view('webprofile.backend.categories_file.index', compact('data'))->withTitle('Kategori Dokumen');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.categories_file.create')->withTitle('Tambah Kategori Dokumen');
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
        $validator = Validator::make($data, CategoriesFile::$rules, CategoriesFile::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('categories_file.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();

            $data['id'] = $uuid;
            $data['is_active'] = 1;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            CategoriesFile::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Kategori Dokumen Berhasil !!";
            return redirect()->route('categories_file.index')->with('successMessage', $successmessage);
        }
    }

    public function categoriesfile_aktif($id)
    {
        CategoriesFile::where('id', Crypt::decrypt($id))->update([
          'is_active' => '1',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('categories_file.index');
    }

    public function categoriesfile_naktif($id)
    {
        CategoriesFile::where('id', Crypt::decrypt($id))->update([
          'is_active' => '0',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('categories_file.index');
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
            $data = CategoriesFile::find(Crypt::decrypt($id));
            return view('webprofile.backend.categories_file.edit', compact('data'))->withTitle('Ubah Kategori Dokumen');
        } catch (\Exception $id) {
            return redirect()->route('categories_file.index');
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
        $categories = CategoriesFile::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, CategoriesFile::$rules, CategoriesFile::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $categories->update($data);

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('categories_file.index');
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
            CategoriesFile::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('categories_file.index');
        } catch (\Exception $id) {
            return redirect()->route('categories_file.index');
        }
    }
}
