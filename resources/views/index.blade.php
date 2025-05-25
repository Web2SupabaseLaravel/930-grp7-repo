
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('appointments.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
           Book new appointment
        </a>
    </div>

    @if($appointments->isEmpty())
        <p class="text-center text-gray-600">There are no appointments currently.</p>
    @else
    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="px-4 py-2 border">patient</th>
                <th class="px-4 py-2 border">Practitioner</th>
                <th class="px-4 py-2 border">Service</th>
                <th class="px-4 py-2 border">date</th>
                <th class="px-4 py-2 border">time</th>
                <th class="px-4 py-2 border">status</th>
                <th class="px-4 py-2 border">procedures</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr class="text-center">
                <td class="px-4 py-2 border">{{ $appointment->patient->name }}</td>
                <td class="px-4 py-2 border">{{ $appointment->practitioner->name }}</td>
                <td class="px-4 py-2 border">{{ $appointment->service->name }}</td>
                <td class="px-4 py-2 border">{{ $appointment->appointment_date }}</td>
                <td class="px-4 py-2 border">{{ $appointment->appointment_time }}</td>
                <td class="px-4 py-2 border">
                    @switch($appointment->status)
                        @case('completed')
                            <span class="text-green-600">Done</span>@break
                        @case('cancelled')
                            <span class="text-red-600">cancelled</span>@break
                        @default
                            <span class="text-yellow-600">Waiting</span>
                    @endswitch
                </td>
                <td class="px-4 py-2 border space-x-2">
                    @if($appointment->status !== 'completed')
                        <form action="{{ route('appointments.confirm', $appointment->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded">confirm</button>
                        </form>
                    @endif
                    <a href="{{ route('appointments.edit', $appointment->id) }}"
                       class="bg-yellow-400 hover:bg-yellow-500 text-white py-1 px-3 rounded">update</a>
                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('تأكيد الإلغاء؟');"
                                class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded">
                            cancelled
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
