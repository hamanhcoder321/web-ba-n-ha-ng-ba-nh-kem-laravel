@extends('layouts.admin')

@section('content')
    <span class="m-r-sm text-muted welcome-message">Chào mừng, {{ Auth::guard('admins')->user()->name }}</span>
@endsection