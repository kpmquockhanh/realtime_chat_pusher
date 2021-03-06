@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>Create room</div>
                        <div>
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>

                    <form action="{{route('rooms.store')}}" method="post">
                        @csrf()
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required autofocus autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control" name="description"
                                           value="{{ old('description') }}" autofocus autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-4 offset-md-4 w-100">
                                    <button type="submit" class="btn btn-outline-primary w-100" id="send_message">
                                        {{ __('Create!') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
