@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('rooms.create') }}" class="btn-lg btn-primary">Create</a>
                    </div>
                </div>
        </div>
        <div class="row d-flex justify-content-center">
            @if (count($rooms))
                @foreach($rooms as $room)
                    <div class="col-12 col-sm-6 mb-3 col-md-4 col-lg-3">
                        <div class="card">
                            <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_168a32c2b31%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_168a32c2b31%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.203125%22%20y%3D%2296.3%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Room {{$room->name}}</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur.</p>
                                <a href="{{ route('rooms.show', ['id' => $room->id]) }}" class="btn btn-primary">Go {{$room->name}}!</a>
                            </div>
                        </div>
                    </div>

                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">NO ROOMS</div>
                </div>
            @endif
        </div>
    </div>
@endsection
