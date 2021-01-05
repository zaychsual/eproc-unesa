<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Newmenu;
use App\Models\Webprofile\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class NewmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parent = Newmenu::where('status', '1')->whereNull('url')->whereIn('level', [1, 2])->pluck('name', 'id');
        $page = Pages::where('posts_status', '1')->pluck('title', 'id');
        $data = Newmenu::select('id', 'parent', 'name', 'url', 'level', 'urutan')->orderby('level', 'asc')->orderby('urutan', 'asc')->get();
        
        $arr = $this->build_menu();

        return view('webprofile.backend.newmenu.index', compact('parent', 'page', 'data', 'arr'))->withTitle('Newmenu');
    }

    public function build_menu()
    {
        $data = Newmenu::select('id', 'parent', 'name', 'url', 'level', 'urutan')->where('level', '1')->orderby('urutan', 'asc')->get();
        $menu = [];

        $i = 0;
        foreach ($data as $item) {
            $menu[$i]['id'] = $item->id;
            $menu[$i]['parent'] = $item->parent;
            $menu[$i]['name'] = $item->name;
            $menu[$i]['url'] = $item->url;
            $menu[$i]['level'] = $item->level;
            $menu[$i]['urutan'] = $item->urutan;
            if ($this->menu_has_child($item->parent)) {
                $menu[$i]['child'] = $this->menu_get_child($item->id);
            }
            $i++;
        }
        
        return $menu;
    }

    public function menu_has_child($parentid)
    {
        $data = Newmenu::where('parent', $parentid)->count();

        if ($data > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function menu_get_child($parentid)
    {
        $cdata = Newmenu::select('id', 'parent', 'name', 'url', 'level', 'urutan')->where('parent', $parentid)->orderby('urutan', 'asc')->get();

        $i = 0;
        $cmenu = [];
        foreach ($cdata as $citem) {
            $cmenu[$i]['id'] = $citem->id;
            $cmenu[$i]['parent'] = $citem->parent;
            $cmenu[$i]['name'] = $citem->name;
            $cmenu[$i]['url'] = $citem->url;
            $cmenu[$i]['level'] = $citem->level;
            $cmenu[$i]['urutan'] = $citem->urutan;
            if ($this->menu_has_child($citem->parent)) {
                $cmenu[$i]['child'] = $this->menu_get_child($citem->id);
            }
            $i++;
        }

        return $cmenu;
    }

    public function newmenu_up($id)
    {
        $cur_menu = Newmenu::where('id', Crypt::decrypt($id))->first();
        if ($cur_menu->parentlevel == null) {
            $up_menu = Newmenu::where('level', $cur_menu->level)->where('urutan', (int)$cur_menu->urutan-1)->first();
        }
        if ($cur_menu->parentlevel != null) {
            $up_menu = Newmenu::where('parent', $cur_menu->parent)->where('level', $cur_menu->level)->where('urutan', (int)$cur_menu->urutan-1)->first();
        }

        Newmenu::where('id', Crypt::decrypt($id))->update([
            'urutan' => $up_menu->urutan,
            'userid_created' => Auth::user()->name,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Newmenu::where('id', $up_menu->id)->update([
            'urutan' => $up_menu->urutan+1,
            'userid_created' => Auth::user()->name,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('newmenu.index');
    }

    public function newmenu_down($id)
    {
        $cur_menu = Newmenu::where('id', Crypt::decrypt($id))->first();
        if ($cur_menu->parentlevel == null) {
            $up_menu = Newmenu::where('level', $cur_menu->level)->where('urutan', (int)$cur_menu->urutan+1)->first();
        }
        if ($cur_menu->parentlevel != null) {
            $up_menu = Newmenu::where('parent', $cur_menu->parent)->where('level', $cur_menu->level)->where('urutan', (int)$cur_menu->urutan+1)->first();
        }

        Newmenu::where('id', Crypt::decrypt($id))->update([
            'urutan' => $up_menu->urutan,
            'userid_created' => Auth::user()->name,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Newmenu::where('id', $up_menu->id)->update([
            'urutan' => $up_menu->urutan-1,
            'userid_created' => Auth::user()->name,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('newmenu.index');
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
        $validator = Validator::make($data, Newmenu::$rules, Newmenu::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('menu.index')
            ->withErrors($validator)
            ->withInput();
        } else {
            $uuid = Uuid::generate();
            // dd($data);
            if ($request->input('parent') == null || $request->input('parent') == '') {
                $parentlevel = null;
                $level = 1;
            } else {
                $getlevelparent = Newmenu::where('id', $request->input('parent'))->first()->level;
                $parentlevel = $getlevelparent;
                $level = (int)$getlevelparent + 1;
            }

            $urutan = Newmenu::where('level', $level)->where('parent', $request->input('parent'))->max('urutan');

            $data['id'] = $uuid;
            $data['status'] = 1;
            $data['level'] = $level;
            $data['parentlevel'] = $parentlevel;
            $data['urutan'] = $urutan+1;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Newmenu::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Newmenu Berhasil !!";
            return redirect()->route('newmenu.index')->with('successMessage', $successmessage);
        }
    }

    public function newstorepage(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, Newmenu::$rules, Newmenu::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('menu.index')
            ->withErrors($validator)
            ->withInput();
        } else {
            $uuid = Uuid::generate();

            if ($request->input('parentpage') == null || $request->input('parentpage') == '') {
                $parentlevel = null;
                $level = 1;
            } else {
                $getlevelparent = Newmenu::where('id', $request->input('parentpage'))->first()->level;
                $parentlevel = $getlevelparent;
                $level = (int)$getlevelparent + 1;
            }

            $urutan = Newmenu::where('level', $level)->where('parent', $request->input('parentpage'))->max('urutan');

            $page = Pages::where('id', $request->input('page'))->first();

            $data['id'] = $uuid;
            $data['name'] = $page->title;
            $data['level'] = $level;
            $data['parentlevel'] = $parentlevel;
            $data['urutan'] = $urutan+1;
            $data['parent'] = $request->input('parentpage');
            $data['url'] = '/page/'.$page->slug;
            $data['status'] = 1;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Newmenu::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Newmenu Berhasil !!";
            return redirect()->route('newmenu.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newmenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Newmenu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Newmenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Newmenu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Newmenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newmenu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newmenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ceklevel = Newmenu::where('id', Crypt::decrypt($id))->first();
            $level = $ceklevel->level;

            Newmenu::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));
            $tataurut = Newmenu::where('level', $level)->orderBy('urutan', 'asc')->get();
            $urut = 1;
            
            foreach ($tataurut as $value) {
                Newmenu::where('id', $value->id)->update([
                    'urutan' => $urut++,
                    'userid_created' => Auth::user()->name,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            return redirect()->route('newmenu.index');
        } catch (\Exception $id) {
            return redirect()->route('newmenu.index');
        }
    }
}
