@extends('layout')

@section('content')
    <h1>Create Service</h1>

    <form method="POST" action="{{ route('services.store') }}">
        @csrf
        <input name="name" placeholder="Name" required>
        <input name="description" placeholder="Description" required>
        <input type="number" name="duration_minutes" placeholder="Duration (in minutes)" required>
        <input type="number" name="price" placeholder="Price" required>
        <button>Add</button>
    </form>
@endsection
