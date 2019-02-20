@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Home</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <a class="btn btn-outline-primary" href="{{ route('rooms.index') }}">Room list</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let body = $('body');
        let name = '{{ Auth::user()->name }}';
        body.on('click', '#send_message', function () {
            sendMessage();
        });
        body.on('click', '#delete_all', function () {
            $.post('{{route('user.delete.all')}}', {
                success: function (res) {
                    $('#content_message').empty();
                },
                error: function () {
                    alert('Error');
                }
            });
        });

        body.on('keyup', '#text', function (e) {
            if (e.keyCode === 13 && $('#text').val())
            {
                sendMessage();
            }
        });

        function sendMessage() {
            let text = $('#text').val();
            $('#content_message').prepend(`
                    <div>` + name + `: ` + text +`</div>
                `);
            $.get('{{route('user.send.message')}}', {
                'message': text ? text : 'unknown',
            });
            $('#text').val('');
        }
    </script>
@endsection
