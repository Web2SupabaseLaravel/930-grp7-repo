{{-- resources/views/auth/passwords/reset.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Set New Password</h1>
  <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div>
      <label>Email</label>
      <input type="email" name="email" value="{{ $email ?? old('email') }}" required>
      @error('email') <div>{{ $message }}</div> @enderror
    </div>
    <div>
      <label>New Password</label>
      <input type="password" name="password" required>
      @error('password') <div>{{ $message }}</div> @enderror
    </div>
    <div>
      <label>Confirm Password</label>
      <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Reset Password</button>
  </form>
</div>
@endsection
