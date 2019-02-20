<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Send message</div>
                    <div>
                        <span>
                            <a class="btn btn-danger text-white" id="delete_all">
                                {{ __('Delete all') }}
                            </a>
                        </span>
                        <a href="{{ route('rooms.index') }}" class="btn btn-success">Back</a>
                    </div>

                </div>

                <div class="card-body">
                    <h3>Room {{$room->name}} (ID: <strong>{{ $room->id }}</strong>)</h3>
                    <div class="form-group row">
                        <div class="col-md-12 d-flex justify-content-between no-gutters">
                            <div class="col-10 pr-1">
                                <input id="text" type="text" class="form-control" name="message"
                                       value="{{ old('message') }}" required autofocus>
                            </div>
                            <div class="col-2 pl-1">
                                <button type="submit" class="btn btn-primary w-100" id="send_message">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="content_message">
                        @foreach($messages as $message)
                            @include('components.message', [
                            'name' => $message->user->name,
                            'message' => $message->message,
                            ])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 order-sm-first order-md-2 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Online</div>
                </div>

                <div class="card-body" id="list_online">
                    {{--<div><i class="far fa-circle text-black-50 small mr-2"></i>User 1</div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        let body = $('body');
        let name = '{{ Auth::user()->name }}';
        body.on('click', '#send_message', function () {
            sendMessage();
        });
        body.on('click', '#delete_all', function () {
            axios.post('{{route('user.delete.all')}}', {
                id: '{{$room->id}}'
            })
                .then(function (response) {
                    if (response.data.status)
                    {
                        $('#content_message').empty();
                    }else {
                        alert("Failed");
                    }

                })
                .catch(function (error) {
                    console.log(error);
                })
        });

        body.on('keyup', '#text', function (e) {
            if (e.keyCode === 13 && $('#text').val())
            {
                sendMessage();
            }
        });

        function sendMessage() {
            let text = $('#text').val();
            $('#content_message').prepend(`<div class="my-2"><span class="alert alert-info p-1"><strong>`+ name + `</strong>: ` + text +`</span></div>`);
            $.get('{{route('user.send.message')}}', {
                'message': text ? text : 'unknown',
                'room_id': '{{ $room->id }}',
            });
            $('#text').val('');
        }
    </script>
@stop
