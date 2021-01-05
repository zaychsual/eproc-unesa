<?php

namespace App\Http\Controllers\Webprofile\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Webprofile\Design;
use Auth;

class DesignController extends Controller
{
    public function index()
    {
        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();

        $quote = Design::where('name_design', 'quote')->orderBy('urutan', 'ASC')->get();

        $body = Design::where('name_design', 'body')->orderBy('urutan', 'ASC')->get();

        return view('webprofile.backend.design.index', compact('widget_right', 'widget_left', 'quote', 'body'))->withTitle('Layouts Website');
    }
}
