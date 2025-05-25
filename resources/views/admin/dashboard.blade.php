@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">لوحة التحكم - المشرف</h2>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">إجمالي المستخدمين</h5>
                    <p class="card-text display-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">الممارسون</h5>
                    <p class="card-text display-4">{{ $totalPractitioners }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">الخدمات</h5>
                    <p class="card-text display-4">{{ $totalServices }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">المواعيد</h5>
                    <p class="card-text display-4">{{ $totalAppointments }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">إحصائيات اليوم</div>
        <div class="card-body">
            <p>عدد المواعيد التي تم حجزها اليوم: <strong>{{ $todayAppointments }}</strong></p>
        </div>
    </div>
</div>
@endsection
