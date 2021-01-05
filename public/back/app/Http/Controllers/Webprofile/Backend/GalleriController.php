<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Storage;
use Auth;

class GalleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Gallery::orderBy('created_at', 'DESC')->get();

        return view('webprofile.backend.gallery.index', compact('data'))->withTitle('Gallery');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.gallery.create', compact('categories'))->withTitle('Tambah Gallery');
    }

    public function gallery_aktif($id)
    {
        Gallery::where('id', Crypt::decrypt($id))->update([
          'is_active' => '1',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('gallery.index');
    }

    public function gallery_naktif($id)
    {
        Gallery::where('id', Crypt::decrypt($id))->update([
          'is_active' => '0',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('gallery.index');
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
        $validator = Validator::make($data, Gallery::$rules, Gallery::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('gallery.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();

            if ($request->hasFile('images')) {
                $cover = $request->file('images');
                $extension = $cover->guessClientExtension();
                $filename = $uuid . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/gallery/' . $filename, file_get_contents($cover->getRealPath()));
                $data['images'] = $filename;
            }

            $data['id'] = $uuid;
            $data['is_active'] = $request->input('is_active') ? true : false;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Gallery::create($data);

            Alert::success('Gallery berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Gallery Berhasil !!";
            return redirect()->route('gallery.index')->with('successMessage', $successmessage);
        }
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
            $data = Gallery::find(Crypt::decrypt($id));

            return view('webprofile.backend.gallery.edit', compact('data'))->withTitle('Ubah Gallery');
        } catch (\Exception $id) {
            return redirect()->route('gallery.index');
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
        $data = $request->except('_token');
        $validator = Validator::make($data, Gallery::$rules, Gallery::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $gallery = Gallery::findOrFail($id);

        if ($request->hasFile('images')) {
            $cover = $request->file('images');
            $extension = $cover->guessClientExtension();
            $filename = $gallery->id . '.' . $extension;
            Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/gallery/' . $filename, file_get_contents($cover->getRealPath()));
            $data['images'] = $filename;
        }

        $data['is_active'] = $request->input('is_active') ? true : false;
        $data['userid_updated'] = Auth::user()->name;
        $gallery->update($data);

        Alert::success('Gallery berhasil diubah')->persistent('Ok');
        return redirect()->route('gallery.index');
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
            $data = Gallery::where('id', Crypt::decrypt($id))->first();
            if ($data->images) {
                Storage::disk('uploads')->delete('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/gallery/' . $data->images);
            }
            Gallery::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('gallery.index');
        } catch (\Exception $id) {
            return redirect()->route('gallery.index');
        }
    }
}
