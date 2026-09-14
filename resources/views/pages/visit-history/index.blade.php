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

    .pagination {
        margin-bottom: 0;
    }

    .pagination .page-link {
        color: #06285c;
        border: 1px solid #ddd;
    }

    .pagination .page-item.active .page-link {
        background-color: #06285c;
        border-color: #06285c;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #EAF1FB;
        color: #06285c;
    }


</style>
@endpush


@endsection

@push('script')

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