<?php

namespace App\Http\Controllers;

use App\Events\MessageDeleted;
use App\Events\MessagingSent;
use App\Message;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

        $this->validate($request, [
            'room_id' => 'integer|required',
            'message' => 'string|required'
        ]);

        if ($message = Message::query()->create($saveData)) {
            broadcast(new MessagingSent($message));
        }
    }

    public function deleteAllMessage(Request $request)
    {
        $room = Room::query()->findOrFail($request->id);
        if ($room->user_id !== Auth::id()) {
            abort(403);
        }

        if ($room->user_id)
        Message::query()->where('room_id', $request->id)->delete();

        broadcast(new MessageDeleted($request->id));
        return response()->json([
            'status' => true
        ]);
    }
}
