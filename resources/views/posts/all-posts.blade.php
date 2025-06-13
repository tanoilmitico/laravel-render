@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tutti i post</h2>

    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $post->title }} <small class="text-muted">di {{ $post->user->name }}</small></h5>
                <p>{{ $post->content }}</p>
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" style="width: 100px; height: 100px; object-fit: cover;">
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
