@extends('layouts.app')

@section('content')
    @include('components.form-message', ['messages' => $messages, 'room' => $room])
    @include('components.pusher-activate', ['room' => $room])
@endsection
