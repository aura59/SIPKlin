@extends('layouts.app')

@section('title', 'Riwayat Kunjungan - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h3 mb-0 text-gray-900">Riwayat Kunjungan</h5>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Pelayanan / Riwayat Kunjungan</h1>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <h6 class="h3 mb-0 font-weight-bold text-sipklin">Daftar Riwayat</h6>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-hover datatable dashboard-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Dokter</th>
                    <th>Poli</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($registrations as $registration)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $registration->patient->nama ?? '-' }}</td>
                    <td>{{ $registration->tanggal }}</td>
                    <td> {{ $registration->doctorSchedule->doctor->nama ?? '-' }}</td>
                    <td>{{ $registration->doctorSchedule->doctor->department->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('visit-history.show', $registration->id) }}"class="btn btn-link text-secondary p-0 mx-1"title="Lihat Detail">
                        <span class="fa fa-eye"></span>
                        </a>  
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada riwayat kunjungan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">

<style>

    .btn-sipklin {
        background-color: #06285c !important;
        border-color: #06285c !important;
        color: white !important;
    }

    .btn-sipklin:hover {
        background-color: #041c40 !important;
        border-color: #041c40 !important;
        color: white !important;
    }

    .dashboard-table,
    .dashboard-table th,
    .dashboard-table td {
        border: 1px solid #afaeae !important;
        color: #06285c !important;
    }

    .dashboard-table thead th {
        background-color: #06285c !important;
        color: white !important;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
    }

    .dashboard-table tbody td {
        color: #06285c !important;
        vertical-align: middle;
    }

    .dashboard-table tbody tr:hover {
        background-color: #EAF1FB !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f4f7fc !important;
    }

    .dataTables_filter input {
        border: 1px solid #06285c !important;
        color: #06285c !important;
        border-radius: 5px;
    }

    .dataTables_filter input:focus {
        border-color: #06285c !important;
        box-shadow: 0 0 0 0.2rem rgba(6, 40, 92, 0.15) !important;
        outline: none;
    }

    .dataTables_length select {
        border: 1px solid #06285c !important;
        color: #06285c !important;
        border-radius: 5px;
    }

    .page-item.active .page-link {
        background-color: #06285c !important;
        border-color: #06285c !important;
        color: white !important;
    }

    .page-link {
        color: #06285c !important;
    }

    .page-link:hover {
        background-color: #EAF1FB !important;
        color: #06285c !important;
    }

    .dataTables_info,
    .dataTables_length,
    .dataTables_filter,
    .dataTables_paginate {
        color: #06285c !important;
    }

</style>
@endpush


@endsection

@push('script')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function () {
    $('.datatable').DataTable();
});
</script>

@if (Session::has('success'))
<script>
Swal.fire({
    title: "Berhasil!",
    text: "{{ Session::get('success') }}",
    icon: "success",
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif
@endpush