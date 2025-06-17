@extends('layouts.app')

@section('title', $welcomeTitleMeta)

@section('content')
    <div class="text-center">
        <h1 class="display-4">Welcome, {{ auth()->user()->first_name }}!</h1>
        <p class="lead">This is your personalized dashboard.</p>
    <form action="{{ route('logout.post') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
    </div>
    <div class="mt-4">
        <h2>Your Profile</h2>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>First Name:</strong> {{ auth()->user()->first_name }}</p>
        <p><strong>Last Name:</strong> {{ auth()->user()->last_name }}</p>
    </div>
@endsection
