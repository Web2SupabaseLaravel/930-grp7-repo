@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Book a new appointment</h2>

    <form action="{{ route('appointments.store') }}" method="POST" class="space-y-4">
        @csrf

        @if(Auth::user()->role->name === 'patient')
            <div>
                <label>Patient name:</label>
                <input type="text" value="{{ Auth::user()->name }}" disabled class="border p-2 rounded w-full">
                <input type="hidden" name="patient_id" value="{{ Auth::id() }}">
            </div>
        @else
            <div>
                <label for="patient_id">Patient:</label>
                <select name="patient_id" id="patient_id" required class="border p-2 rounded w-full">
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div>
            <label for="practitioner_id">Experienced:</label>
            <select name="practitioner_id" id="practitioner_id" required class="border p-2 rounded w-full">
                @foreach($practitioners as $practitioner)
                    <option value="{{ $practitioner->id }}">{{ $practitioner->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="service_id">Service</label>
            <select name="service_id" id="service_id" required class="border p-2 rounded w-full">
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="appointment_date">date:</label>
            <input type="date" name="appointment_date" id="appointment_date" required class="border p-2 rounded w-full">
        </div>
        <div>
            <label for="appointment_time">time:</label>
            <input type="time" name="appointment_time" id="appointment_time" required class="border p-2 rounded w-full">
        </div>

        
        @if(Auth::user()->role->name !== 'patient')
        <div>
            <label for="status">status:</label>
            <select name="status" id="status" class="border p-2 rounded w-full">
                <option value="scheduled">scheduled</option>
                <option value="completed">scheduled</option>
                <option value="cancelled">cancelled</option>
            </select>
        </div>
        @endif

        <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
            احجز
        </button>
    </form>
</div>
@endsection
