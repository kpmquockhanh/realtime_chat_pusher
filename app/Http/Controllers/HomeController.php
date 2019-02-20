<?php

namespace App\Http\Controllers;

use App\Events\MessageDeleted;
use App\Events\MessagingSent;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $messages = Message::query()->where('room_id', 1)->orderByDesc('created_at')->get();
        return view('home')->with(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $saveData = [
            'room_id' => $request->room_id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ];

        if ($message = Message::query()->create($saveData)) {
            broadcast(new MessagingSent($message));
        }
    }

    public function deleteAllMessage(Request $request)
    {
        Message::query()->where('room_id', $request->id)->delete();

        broadcast(new MessageDeleted($request->id));
        return response()->json([
            'status' => true
        ]);
    }
}
