@extends('layouts.app')

@section('title', 'Email Verification Required')

@section('content')
    <div class="text-center">
        <p class="alert alert-warning">Please verify your email address to access all features.</p>
        <a class="btn btn-primary" href="{{ route('email.verify.resend') }}">Resend Verification Email</a>
    </div>
@endsection
