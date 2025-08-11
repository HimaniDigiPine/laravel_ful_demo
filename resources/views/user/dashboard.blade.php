@extends('frontend.layouts.master')

@section('content')
    <h1>Welcome, {{ session('user')->name }}</h1>
    <a href="{{ route('user.logout') }}">Logout</a>
@endsection