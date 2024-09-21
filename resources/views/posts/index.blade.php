@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Posts</h1>

    <!-- Create Post Button -->
    @auth
        <a href="{{ route('posts.create') }}" class="btn btn-dark mb-4">Create Post</a>
    @endauth

    <div class="posts">
        <!-- Loop through all posts -->
        @foreach($posts as $post)
            <div class="post mb-4 border p-3 rounded">
                <!-- Post Title -->
                <h2>{{ $post->title }}</h2>
                
                <!-- Post Content -->
                <p>{{ $post->content }}</p>

                <!-- Display Post Image if available -->
                @if($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid mb-2">
                @endif

                <!-- Posted by User and Category -->
                <p class="text-muted">Posted by {{ $post->user->name }} | Category: {{ $post->category->name }}</p>

                <!-- Edit/Delete Post Buttons (only if the user is the post author) -->
                @if(auth()->check() && auth()->user()->id === $post->user_id)
                    <!-- Edit Button -->
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-dark">Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-dark" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                @endif

                <!-- Bookmark Button -->
                @auth
                    <form action="{{ route('posts.bookmark', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-dark">Bookmark</button>
                    </form>
                @endauth
            </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="pagination mt-4">
        {{ $posts->links() }}
    </div>
@endsection
