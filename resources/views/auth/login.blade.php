{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Login</h1>
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required autofocus>
      @error('email') <div>{{ $message }}</div> @enderror
    </div>
    <div>
      <label>Password</label>
      <input type="password" name="password" required>
      @error('password') <div>{{ $message }}</div> @enderror
    </div>
    <div>
      <label>
        <input type="checkbox" name="remember"> Remember Me
      </label>
    </div>
    <button type="submit">Login</button>
  </form>
  <a href="{{ route('password.request') }}">Forgot Your Password?</a>
  <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
</div>
@endsection
