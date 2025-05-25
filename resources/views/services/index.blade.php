@extends('layout')

@section('content')
    <h1>All Services</h1>

    <a href="{{ route('services.create') }}">Add New Service</a>

    <ul>
        @foreach ($services as $service)
            <li>
                {{ $service->name }} ({{ $service->duration_minutes }} mins) - ${{ $service->price }}

                <a href="{{ route('services.edit', $service->id) }}">Edit</a>

                <form method="POST" action="{{ route('services.destroy', $service->id) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button>Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
