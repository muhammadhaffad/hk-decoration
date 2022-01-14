<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Decorationitem;
use App\Models\Decorationpacket;
use App\Models\Sessionpackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function __construct()
    {
        new Decorationitem;
        new Decorationpacket;
        new Sessionpackage;
    }

    public function index(Request $request)
    {
        $request->validate([
            'type' => 'nullable',
            'id' => 'nullable|numeric'
        ]);
        $chats = Chat::where([
            ['from', '=', 1], 
            ['to', '=', auth()->user()->id]
        ])->orWhere([
            ['from', '=', auth()->user()->id],
            ['to', '=', 1]
        ]);
        $product = null;
        if ($this->getModel($request->type)) {
            $product = DB::table($request->type)->find($request->id);
        }
        return view('chat', [
            'chats' => $chats,
            'product' => $product,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pesan' => 'required',
            'id' => 'nullable|numeric'
        ]);
        $product = null;
        if ($class = $this->getModel($request->type)) {
            $product = (new $class)->find($request->id);
        }
        if ($product) {
            $product->chats()->create([
                'user_id' => auth()->user()->id,
                'from' => auth()->user()->id,
                'to' => 1,
                'pesan' => $request->pesan,
                'status' => 'unread'
            ]);
        } else {
            Chat::create([
                'user_id' => auth()->user()->id,
                'from' => auth()->user()->id,
                'to' => 1,
                'pesan' => $request->pesan,
                'status' => 'unread'
            ]);
        }
        return back();
    }

    public function getModel($table)
    {
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, 'Illuminate\Database\Eloquent\Model')) {
                $model = new $class;
                if ($model->getTable() === $table)
                    return $class;
            }
        }

        return false;
    }
}
