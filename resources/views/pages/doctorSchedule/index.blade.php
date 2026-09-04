@extends('layouts.app')

@section('title', 'Data Poli - SIPKlin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h3 mb-0 text-gray-900">Data Jadwal Dokter</h5>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Jadwal Dokter</h1>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center">
        <a href="{{ route('doctorschedules.create') }}" class="btn btn-sipklin px-4">
            <span class="fa fa-plus-circle mr-2"></span>
            <span>Tambah Jadwal Dokter</span>
        </a>
    </div>

    </div>
</div>

<div class="card-body">
    <table class="table table-striped table-hover datatable dashboard-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Hari</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Kuota</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($doctorschedules as $doctorschedule)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $doctorschedule->doctor->nama }}</td>
                <td>{{ $doctorschedule->doctor->department->name }}</td>
                <td>{{ $doctorschedule->hari }}</td>
                <td>{{ \Carbon\Carbon::parse($doctorschedule->jam_mulai)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($doctorschedule->jam_selesai)->format('H:i') }}</td>
                <td>{{ $doctorschedule->kuota }}</td>

                <td>
                    <a href="{{ route('doctorschedules.show', $doctorschedule->id) }}" class="btn btn-link text-secondary p-0 mx-1">
                        <span class="fa fa-eye"></span>
                    </a>

                    <a href="{{ route('doctorschedules.edit', $doctorschedule->id) }}" class="btn btn-link text-secondary p-0 mx-1">
                        <span class="fa fa-edit"></span>
                    </a>

                    <a href="javascript:void(0)" onclick="actionDestroy('{{ route('doctorschedules.destroy', $doctorschedule->id) }}')" class="btn btn-link text-danger p-0 mx-1">
                        <span class="fa fa-trash"></span>
                    </a>
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada data jadwal dokter</td>
            </tr>
            @endforelse
        </tbody>
    </table>
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

    .dashboard-table th:first-child,
    .dashboard-table td:first-child {
    width: 60px !important;
    max-width: 60px;
    text-align: center;
}

</style>
</style>
@endpush


<form id="form-destroy" method="POST">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('script')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function () {
    $('.datatable').DataTable();
});

function actionDestroy(url) {
    Swal.fire({
        title: 'Apakah Anda yakin ingin menghapus data ini?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-destroy').attr('action', url);
            $('#form-destroy').submit();
        }
    });
}
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

