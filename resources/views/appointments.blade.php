\@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <div class="mb-4">
        <a href="{{ route('appointments.create') }}"
           class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Book an appointment
        </a>
    </div>

    @if($myAppointments->isEmpty())
        <p class="text-center text-gray-600">No appointments are booked.</p>
    @else
    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="px-4 py-2 border">Patient</th>
                <th class="px-4 py-2 border">Practitioner</th>
                <th class="px-4 py-2 border">Service</th>
                <th class="px-4 py-2 border">Date</th>
                <th class="px-4 py-2 border">Time</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">procedures</th>
            </tr>
        </thead>
        <tbody>
            @foreach($myAppointments as $appointment)
            <tr class="text-center">
                <td class="px-4 py-2 border">{{ $appointment->patient->name }}</td>
                <td class="px-4 py-2 border">{{ $appointment->practitioner->name }}</td>
                <td class="px-4 py-2 border">{{ $appointment->service->name }}</td>
                <td class="px-4 py-2 border">{{ $appointment->appointment_date }}</td>
                <td class="px-4 py-2 border">{{ $appointment->appointment_time }}</td>
                <td class="px-4 py-2 border">
                    @switch($appointment->status)
                        @case('completed')
                            <span class="text-green-600 font-semibold">Done</span>
                            @break
                        @case('cancelled')
                            <span class="text-red-600 font-semibold">Cancelled</span>
                            @break
                        @default
                            <span class="text-yellow-600 font-semibold">pending </span>
                    @endswitch
                </td>
                <td class="px-4 py-2 border space-x-2">

                    <a href="{{ route('appointments.edit', $appointment->id) }}"
                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-3 rounded">
                        update
                    </a>

                   
                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('are you sure yuo want to cancelled this appointment?');"
                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded">
                            Cancelled
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
