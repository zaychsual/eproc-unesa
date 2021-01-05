<?php

namespace App\Http\Controllers\Procurement\tender;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Procurement\Einbox;
use App\Models\Procurement\Logs;
use Auth;
use Uuid;
use Crypt;
class AllLogController extends Controller
{
	public function index()
	{
		$inbox = Einbox::where('user_to_id','=',Auth::user()->id)
			->orderBy('created_at', 'DESC')
			->get();
		return view('procurement.inbox.index',compact('inbox'))->withTitle('Inbox');
	}
	public function getDataInbox($inbox_id)
	{
		$inbox = Einbox::find(Crypt::decrypt($inbox_id));
		$inbox->is_read = 1;
		$inbox->save();
		return view('procurement.inbox.show',compact('inbox'))->withTitle($inbox->subject);
	}
	public function logLogin()
	{
		$log = \DB::table('e_log')->where('users_id','=',Auth::user()->id)
			->orderBy('last_login', 'DESC')
			->get();
		return view('procurement.elog.index',compact('log'))->withTitle('Log Akses');
	}
}
