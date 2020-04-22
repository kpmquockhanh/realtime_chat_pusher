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
                        <div class="card h-100">
                            <img class="card-img-top" src="https://picsum.photos/200" alt="Card image cap">
                            @if ($room->isOwner())
                                <div class="position-absolute action-room">
                                    <a href="{{ route('rooms.edit', ['id' => $room->id]) }}">
                                        <span class="badge badge-success p-2"><i class="fas fa-edit"></i></span>
                                    </a>
                                        <a href="#" onclick="$(this).find('form').submit()">
                                            <span class="badge badge-danger p-2"><i class="fas fa-trash"></i></span>
                                            <form action="{{ route('rooms.destroy' , $room->id)}}"
                                                  method="POST" class="d-none" id="delete-form">
                                                <input name="_method" type="hidden" value="DELETE">
                                                <input name="id" type="hidden" value="{{ $room->id }}">
                                                {{ csrf_field() }}
                                            </form>
                                        </a>
                                </div>
                            @endif
                            <div class="card-body d-flex justify-content-between flex-column">
                                <h5 class="card-title">Room <strong>{{$room->name}}</strong></h5>
                                <p class="card-text">{{ $room->description }}</p>
                                <p class="card-text">Created by <strong>{{ $room->user->name }}</strong></p>
                                <a href="{{ route('rooms.show', ['id' => $room->id]) }}" class="btn btn-outline-primary">Go {{$room->name}}!</a>
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
