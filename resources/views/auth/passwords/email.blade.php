{{-- resources/views/auth/passwords/email.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Reset Password</h1>
  @if (session('status'))
    <div>{{ session('status') }}</div>
  @endif
  <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div>
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required>
      @error('email') <div>{{ $message }}</div> @enderror
    </div>
    <button type="submit">Send Password Reset Link</button>
  </form>
</div>
@endsection
