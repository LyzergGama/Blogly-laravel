<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookmarks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('posts.index') }}">Blog.ly</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('posts.index') }}">Home</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('posts.create') }}">Create Post</a></li>
                        <li class="nav-item"><form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-link nav-link">Logout</button></form></li>
                    @endauth
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endguest
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.bookmarks') }}">Bookmarks</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Your Bookmarks</h1>
        @if($bookmarks->isEmpty())
            <p>No bookmarks found.</p>
        @else
            <ul class="list-group">
                @foreach($bookmarks as $bookmark)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', $bookmark->post_id) }}">{{ $bookmark->post->title }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
