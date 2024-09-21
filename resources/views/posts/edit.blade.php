@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title Input -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
        </div>

        <!-- Content Input -->
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" required>{{ $post->content }}</textarea>
        </div>

        <!-- Category Dropdown -->
        <div class="form-group">
            <label for="category">Category</label>
            <select name="category_id" id="category" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Image Upload -->
        <div class="form-group">
            <label for="image">Image (optional)</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Update Post</button>
    </form>
@endsection
