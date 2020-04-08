<div class="py-2 {{ $isOwner ? 'text-right' : '' }}">
    <span class="alert alert-{{ $isOwner ? 'success' : 'info'}} p-1">
        <strong>{{$name}}</strong>: {{$message}}
    </span>
</div>
