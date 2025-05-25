@extends('layout')

@section('content')
    <h1>Create Practitioner</h1>

    <form method="POST" action="{{ route('practitioners.store') }}">
        @csrf

        <input name="user_id" placeholder="User ID (optional)">
        <input name="specialization" placeholder="Specialization">
        <input name="qualifications" placeholder="Qualifications">
        <input name="contact" placeholder="Contact Info">
        <input name="working_hours" placeholder="Working Hours">

        <p><strong>Services:</strong></p>
        @foreach ($services as $service)
            <label>
                <input type="checkbox" name="services[]" value="{{ $service->id }}">
                {{ $service->name }}
            </label><br>
        @endforeach

        <br>
        <button>Create</button>
    </form>
@endsection
