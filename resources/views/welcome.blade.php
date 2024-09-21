@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="mb-4">Welcome to My Blog</h1>
    <p class="lead">Explore our posts and join the conversation!</p>
    <a href="{{ route('posts.index') }}" class="btn btn-primary">View Posts</a>
</div>
@endsection
