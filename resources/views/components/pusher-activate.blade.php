<script>
    // Pusher.logToConsole = true;

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: 'ap1',
        forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}'
            }
        }
    });
    let authUserID = '{{ \Illuminate\Support\Facades\Auth::id() }}';
    let channel = pusher.subscribe('presence-room-' + '{{$room->id}}');
    channel.bind('has-message', function(data) {
        if (parseInt(authUserID) !== data.user_id) {
            $('#content_message > div').prepend(`<div class="py-2"><span class="alert alert-info p-1"><strong>`+ data.name +`</strong>: `+ data.message +`</span></div>`);
        }
    });

    channel.bind('message-deleted', function(data) {
        $('#content_message > div').empty();
        // $('#content_message > div').append('<div class="py-2"><span class="font-italic small alert alert-secondary p-1">Messages deleted</span></div>');
    });

    function addMemberOnline(member) {
        if (member.id === parseInt(authUserID)) {
            $('#list_online').append('<div data-id-user="' + member.id + '"><i class="far fa-circle text-success small mr-2"></i>' + member.name + ' (you)</div>');
        }
        else {
            $('#list_online').append('<div data-id-user="' + member.id + '"><i class="far fa-circle text-success small mr-2"></i>' + member.name + '</div>');
        }
    };
    function removeMember(member) {
        $(`#list_online div[data-id-user="${member.id}"]`).remove();
        $('#content_message > div').prepend('<div class="my-2"><span class="font-italic small alert alert-secondary p-1"><strong>'+member.info.name+'</strong> has left the room</span></div>');

    }

    channel.bind('pusher:subscription_succeeded', function(members) {
        $.each(members.members, function (i, member) {
            addMemberOnline(member);
        })
    });

    channel.bind('pusher:subscription_error', function(code) {
        if (code === 403) {
            window.location.href = '{{ route('rooms.index') }}'
        }
    });

    channel.bind('pusher:member_added', function(member) {
        $('#list_online').append('<div data-id-user="' + member.id + '"><i class="far fa-circle text-success small mr-2"></i>' + member.info.name + '</div>');
        $('#content_message > div').prepend('<div class="my-2"><span class="font-italic small alert alert-secondary p-1"><strong>'+member.info.name+'</strong> joined the room</span></div>');
    });
    channel.bind('pusher:member_removed', function(member) {
        removeMember(member);

    });
</script>
