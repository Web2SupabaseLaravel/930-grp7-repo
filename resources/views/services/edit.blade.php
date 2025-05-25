@extends('layout')

@section('content')
    <h1>Edit Service</h1>

    <form method="POST" action="{{ route('services.update', $service->id) }}">
        @csrf
        @method('PUT')
        <input name="name" value="{{ $service->name }}" required>
        <input name="description" value="{{ $service->description }}" required>
        <input type="number" name="duration_minutes" value="{{ $service->duration_minutes }}" required>
        <input type="number" name="price" value="{{ $service->price }}" required>
        <button>Update</button>
    </form>
@endsection
