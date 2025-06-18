@extends('layouts.app')

@section('title', 'Email Verification Required')

@section('content')
    <div class="text-center">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <p class="alert alert-warning">Please verify your email address to access all features.</p>
        <form action="{{ route('email.verify.send') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">Resend Verification Email</button>
        </form>
    </div>
@endsection
