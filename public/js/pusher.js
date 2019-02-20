let body = $('body');
let name = '{{ Auth::user()->name }}';
let url_send =

body.on('click', '#send_message', function () {
    sendMessage();
});
body.on('click', '#delete_all', function () {
    $.get('{{route('user.delete.all')}}');
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
    $.get('{{route('user.send.test')}}', {
        'message': text ? text : 'unknown',
    });
    $('#text').val('');
}
