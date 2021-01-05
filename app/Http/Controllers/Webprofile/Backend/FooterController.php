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

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Design::whereIn('name_design', ['footer_row_1', 'footer_row_2','footer_row_3', 'footer_row_4'])->orderBy('name_design', 'asc')->get();

        // $footer = InseoHelper::footer(Auth::user()->prodi);

        return view('webprofile.backend.footer.index', compact('data'))->withTitle('Setting Footer');
        // return view('webprofile.backend.footer.index', compact('data', 'footer'))->withTitle('Setting Footer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            return redirect()->route('footer.create')
              ->withErrors($validator)
              ->withInput();
        }

        $uuid = Uuid::generate();

        $data['id'] = $uuid;
        $data['name_design'] = Session::get('ss_pos_footer');
        $data['userid_created'] = Auth::user()->name;
        $data['userid_updated'] = Auth::user()->name;
        
        Design::create($data);
        
        Session::forget('ss_pos_footer');
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
        $data = Design::where('name_design', $id)->first();

        if ($data) {
            return view('webprofile.backend.footer.edit', compact('data'))->withTitle('Ubah Footer');
        } else {
            Session::put('ss_pos_footer', $id);
            return view('webprofile.backend.footer.create')->withTitle('Ubah Footer');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
