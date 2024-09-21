@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Bookmarks</h1>

    @if($bookmarks->isEmpty())
        <p>You have no bookmarks yet. Start bookmarking posts you like!</p>
    @else
        <ul class="list-group">
            @foreach($bookmarks as $bookmark)
                <li class="list-group-item">
                    <a href="{{ route('posts.show', $bookmark->post_id) }}">{{ $bookmark->post->title }}</a>
                    <form action="{{ route('posts.bookmark', $bookmark->post_id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Remove Bookmark</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
