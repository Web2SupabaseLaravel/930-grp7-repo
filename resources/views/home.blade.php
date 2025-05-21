{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
  <h1>Welcome, {{ Auth::user()->name }}!</h1>
  <p>This is your dashboard.</p>
</div>
@endsection
