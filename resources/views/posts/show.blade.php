@extends('layouts.app')

@section('content')
    <div class="post">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>

        @if($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid mb-2">
        @endif

        <p class="text-muted">Posted by {{ $post->user->name }} | Category: {{ $post->category->name }}</p>

        <a href="{{ route('posts.index') }}" class="btn btn-dark">Back to Posts</a>
    </div>
@endsection
