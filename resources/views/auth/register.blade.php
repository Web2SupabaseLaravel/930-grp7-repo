{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Register</h1>
  <form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
      <label>Name</label>
      <input type="text" name="name" value="{{ old('name') }}" required>
      @error('name') <div>{{ $message }}</div> @enderror
    </div>
    <div>
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required>
      @error('email') <div>{{ $message }}</div> @enderror
    </div>
    <div>
      <label>Password</label>
      <input type="password" name="password" required>
      @error('password') <div>{{ $message }}</div> @enderror
    </div>
    <div>
      <label>Confirm Password</label>
      <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
</div>
@endsection
