<?php

namespace App\Http\Controllers;

use App\Message;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = [
            'rooms' => Room::with('user')->get()
        ];

        return view('room.index')->with($viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insertData = $request->only([
            'name',
            'description',
        ]);
        $insertData['user_id'] = Auth::id();
        Room::query()->create($insertData);

        return redirect(\route('rooms.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $viewData = [
            'room' => Room::query()->findOrFail($id),
            'messages' => Message::query()->where('room_id', $id)->orderByDesc('created_at')->get()
        ];
        return view('room.room')->with($viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::query()->findOrFail($id);
        if (!$room->isOwner()) {
            abort(403);
        }
        return view('room.edit', compact('room'));
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
        $room = Room::query()->findOrFail($id);

        if (!$room->isOwner()) {
            abort(403);
        }
        $updateData = $request->only([
            'name',
            'description',
        ]);
        $room->update($updateData);

        return redirect(\route('rooms.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $room = Room::query()->findOrFail($request->id);
        if (!$room->isOwner()) {
            abort(403);
        }
        DB::beginTransaction();
        Message::query()->where('room_id', $request->id)->delete();
        Room::query()->findOrFail($request->id)->delete();
        DB::commit();

        return redirect(\route('rooms.index'));
    }
}
