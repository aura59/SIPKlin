@extends('layouts.app')

@section('title', 'Riwayat Kunjungan - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h3 mb-0 text-gray-900">Riwayat Kunjungan</h5>
</div>

<h1 class="h6 text-gray-800 mb-4">Pelayanan / Riwayat Kunjungan</h1>

<div class="card">
    <div class="card-header d-flex justify-content-end align-items-center">
        <div class="search-box">
            <form action="{{ route('visit-history.index') }}" method="GET">
                <div class="search-box">
                    <input type="text" id="searchRiwayatKunjungan" name="search" value="{{ $search ?? '' }}" placeholder="Cari No. RM, nama, dokter..." >
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-hover datatable dashboard-table" id="tableRiwayatKunjungan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. RM</th>
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
                    <td>{{ $registration->patient->no_rm ?? '-' }}</td>
                    <td>{{ $registration->patient->nama ?? '-' }}</td>
                    <td>{{ $registration->tanggal }}</td>
                    <td> {{ $registration->doctorSchedule->doctor->nama ?? '-' }}</td>
                    <td>{{ $registration->doctorSchedule->doctor->department->name ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('visit-history.show', $registration->id) }}"class="btn btn-link text-secondary p-0 mx-1">
                        <span class="fa fa-eye"></span>
                        </a>  
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada riwayat kunjungan</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $registrations->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@push('styles')

<style>
    .search-box {
        position: relative;
        width: 280px;
    }

    .search-box input {
        width: 100%;
        height: 38px;
        border: 1px solid #06285c;
        border-radius: 5px;
        color: #06285c;
        padding: 0 40px 0 12px;
        outline: none;
    }

    .search-box input:focus {
        border-color: #315fa3;
        box-shadow: 0 0 0 2px rgba(6, 40, 92, 0.1);
    }

    .btn-search {
        position: absolute;
        right: 0;
        top: 0;
        height: 38px;
        width: 40px;
        border: none;
        background: transparent;
        color: #06285c;
        cursor: pointer;
    }

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
        color: #06285c !important;
        border: 1px solid #ddd;
        font-size: 14px !important;
        line-height: 1.2;
        padding: 6px 10px;
    }

    .pagination .page-item.active .page-link {
        background-color: #06285c !important;
        border-color: #06285c !important;
        color: white !important;
    }

    .pagination .page-link:hover {
        background-color: #EAF1FB !important;
        color: #06285c !important;
    }

    .pagination svg {
        width: 16px !important;
        height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
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