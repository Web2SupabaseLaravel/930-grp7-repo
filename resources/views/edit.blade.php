@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4">
  <form action="{{ route('appointments.update',$appointment->id) }}" method="POST" class="space-y-4">
    @csrf @method('PUT')

    <label>Patient:</label>
    <select name="patient_id">
      @foreach($patients as $p)
        <option value="{{ $p->id }}"
          @selected($p->id==$appointment->patient_id)>{{ $p->name }}</option>
      @endforeach
    </select>

    <label>Practitioner:</label>
    <select name="practitioner_id">
      @foreach($practitioners as $pr)
        <option value="{{ $pr->id }}"
          @selected($pr->id==$appointment->practitioner_id)>{{ $pr->user->name }}</option>
      @endforeach
    </select>

    <label>Service:</label>
    <select name="service_id">
      @foreach($services as $s)
        <option value="{{ $s->id }}"
          @selected($s->id==$appointment->service_id)>{{ $s->name }}</option>
      @endforeach
    </select>

    <label>Date:</label>
    <input type="date" name="appointment_date"
           value="{{ $appointment->appointment_date }}">

    <label>Time:</label>
    <input type="time" name="appointment_time"
           value="{{ $appointment->appointment_time }}">

    <label>Status:</label>
    <select name="status">
      @foreach(['scheduled','cancelled','completed'] as $st)
        <option value="{{ $st }}"
          @selected($st==$appointment->status)>{{ ucfirst($st) }}</option>
      @endforeach
    </select>

    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">
      Update Appointment
    </button>
  </form>
</div>
@endsection
