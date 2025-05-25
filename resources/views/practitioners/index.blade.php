@extends('layout')

@section('content')
    <h1>All Practitioners</h1>

    <a href="{{ route('practitioners.create') }}">Add New Practitioner</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <ul>
        @foreach ($practitioners as $p)
            <li>
                <strong>Specialization:</strong> {{ $p->specialization }}<br>
                <strong>Qualifications:</strong> {{ $p->qualifications }}<br>
                <strong>Contact:</strong> {{ $p->contact }}<br>
                <strong>Working Hours:</strong> {{ $p->working_hours }}<br>
                <strong>Services:</strong> {{ $p->services->pluck('name')->join(', ') }}

                <br>
                <a href="{{ route('practitioners.edit', $p->Practitioners_id) }}">Edit</a>
                <form method="POST" action="{{ route('practitioners.destroy', $p->Practitioners_id) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
