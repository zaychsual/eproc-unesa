<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Storage;
use Auth;
use App\Models\Webprofile\CategoriesFile;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $file = File::orderBy('created_at', 'DESC')->get();

        $data = [
            'file' => $file,
        ];

        return view('webprofile.backend.file.index', $data)->withTitle('File');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriesFile = CategoriesFile::where('is_active', 1)->orderBy('name', 'asc')->pluck('name', 'id');

        $data = [
            'categoriesFile' => $categoriesFile,
        ];

        return view('webprofile.backend.file.create', $data)->withTitle('Tambah File');
    }

    public function file_aktif($id)
    {
        File::where('id', Crypt::decrypt($id))->update([
          'is_active' => '1',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('file.index');
    }

    public function file_naktif($id)
    {
        File::where('id', Crypt::decrypt($id))->update([
          'is_active' => '0',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('file.index');
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
        $validator = Validator::make($data, File::$rules, File::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('file.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();
            if ($request->hasFile('file')) {
                $cover = $request->file('file');
                $extension = $cover->guessClientExtension();
                $filename = $uuid . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/file/' . $filename, file_get_contents($cover->getRealPath()));
                $data['file'] = $filename;
                $data['slug'] = str_slug($data['title']) . '.' . $extension;
            }

            $data['id'] = $uuid;
            $data['is_active'] = $request->input('is_active') ? true : false;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;
            

            File::create($data);

            Alert::success('File berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah File Berhasil !!";
            return redirect()->route('file.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $file = File::find(Crypt::decrypt($id));

            $categoriesFile = CategoriesFile::where('is_active', 1)->orderBy('name', 'asc')->pluck('name', 'id');

            $data = [
                'categoriesFile' => $categoriesFile,
                'file' => $file,
            ];

            return view('webprofile.backend.file.edit', $data)->withTitle('Ubah File');
        } catch (\Exception $id) {
            return redirect()->route('file.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, File::$rulese, File::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = File::findOrFail($id);

        if ($request->hasFile('file')) {
            $cover = $request->file('file');
            $extension = $cover->guessClientExtension();
            $filename = $file->id . '.' . $extension;
            Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/file/' . $filename, file_get_contents($cover->getRealPath()));
            $data['file'] = $filename;
        }

        $data['is_active'] = $request->input('is_active') ? true : false;
        $data['userid_updated'] = Auth::user()->name;
        $file->update($data);

        Alert::success('File berhasil diubah')->persistent('Ok');
        return redirect()->route('file.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = File::where('id', Crypt::decrypt($id))->first();
            if ($data->file) {
                Storage::disk('uploads')->delete('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/file/' . $data->file);
            }
            File::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('file.index');
        } catch (\Exception $id) {
            return redirect()->route('file.index');
        }
    }
}
