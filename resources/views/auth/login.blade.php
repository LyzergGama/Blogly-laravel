@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Login</h1>
    <form method="POST" action="/login">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
@endsection
