@extends('layout')

@section('content')
    <h1>Edit Practitioner</h1>

    <form method="POST" action="{{ route('practitioners.update', $practitioner->id) }}">
        @csrf
        @method('PUT')

        <input name="user_id" value="{{ $practitioner->user_id }}" placeholder="User ID">
        <input name="specialization" value="{{ $practitioner->specialization }}" placeholder="Specialization">
        <input name="qualifications" value="{{ $practitioner->qualifications }}" placeholder="Qualifications">
        <input name="contact" value="{{ $practitioner->contact }}" placeholder="Contact">
        <input name="working_hours" value="{{ $practitioner->working_hours }}" placeholder="Working Hours">

        <p><strong>Services:</strong></p>
        @foreach ($services as $service)
            <label>
                <input type="checkbox" name="services[]" value="{{ $service->id }}"
                       {{ $practitioner->services->contains($service->id) ? 'checked' : '' }}>
                {{ $service->name }}
            </label><br>
        @endforeach

        <br>
        <button>Update</button>
    </form>
@endsection
