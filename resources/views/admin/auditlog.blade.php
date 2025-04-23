@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

{{-- audit log content --}}
@section('content')
<h2 class="text-2xl font-bold mb-4">Audit Log</h2>
<table class="table table-striped table-sm" id="auditLogsTable">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>UserID</th>
            <th>Action</th>
            <th>Description</th>
            <th>Updated</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $log)
        <tr>
            <td>{{ $log->fldID }}</td>
            <td>{{ $log->fldUserID ?? '' }}</td>
            <td>{{ $log->fldAction }}</td>
            <td>{{ $log->fldDescription ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($log->updated_at)->toDayDateTimeString() }}</td>
            <td>{{ \Carbon\Carbon::parse($log->created_at)->toDayDateTimeString() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
