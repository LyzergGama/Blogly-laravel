@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Register</h1>
    <form method="POST" action="/register">
        @csrf
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Name" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
@endsection
