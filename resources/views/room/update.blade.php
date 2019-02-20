@extends('layouts.app')

@section('content')
    @include('components.form-message', ['messages' => $messages, 'room' => $room])
@endsection
