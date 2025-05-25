@extends('layout')

@section('content')
    <h1>Practitioner Details</h1>

    <p><strong>User ID:</strong> {{ $practitioner->user_id }}</p>
    <p><strong>Specialization:</strong> {{ $practitioner->specialization }}</p>
    <p><strong>Qualifications:</strong> {{ $practitioner->qualifications }}</p>
    <p><strong>Contact:</strong> {{ $practitioner->contact }}</p>
    <p><strong>Working Hours:</strong> {{ $practitioner->working_hours }}</p>

    <p><strong>Services:</strong>
        {{ $practitioner->services->pluck('name')->join(', ') }}
    </p>

    <a href="{{ route('practitioners.edit', $practitioner->Practitioners_id) }}">Edit</a>
    <a href="{{ route('practitioners.index') }}">Back to List</a>
@endsection
