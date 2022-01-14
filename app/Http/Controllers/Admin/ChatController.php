<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Decorationitem;
use App\Models\Decorationpacket;
use App\Models\Sessionpackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function __construct()
    {
        new Decorationpacket;
        new Decorationitem;
        new Sessionpackage;
    }

    public function index($id = null)
    {
        $chats = Chat::where('from', -1)->orWhere('to', -1);
        $user = null;
        $userChat = Chat::groupBy('user_id')->where('user_id', '!=', 1);
        if ($id && $id != 1) {
            $chats = Chat::where([
                ['from', '=', 1], 
                ['to', '=', $id]
            ])->orWhere([
                ['from', '=', $id],
                ['to', '=', 1]
            ]);
            $chats->update(['status' => 'read']);
            $user = User::find($id);
        }
        return view('admin.chat', [
            'chats' => $chats,
            'user' => $user,
            'userChat' => $userChat
        ]);
    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'pesan' => 'required',
        ]);
        if ($id) {
            Chat::create([
                'user_id' => 1,
                'from' => 1,
                'to' => $id,
                'pesan' => $request->pesan,
                'status' => 'unread'
            ]);
        }
        return back();
    }
}
