 @extends('layouts.app')

@section('title', 'Jadwal Kontrol - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h3 mb-0 text-gray-900">Jadwal Kontrol</h5>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Jadwal Kontrol Pasien</h1>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="font-weight-bold">Daftar Pasien yang Perlu Kontrol</span>

        <form action="{{ route('control-schedules.index') }}" method="GET" class="search-box">
            <button type="submit" aria-label="Cari jadwal kontrol">
                <i class="fas fa-search"></i>
            </button>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari pasien..."
            >
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover dashboard-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. RM</th>
                        <th>Nama Pasien</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Tanggal Kontrol</th>
                        <th>Catatan Kontrol</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jadwalKontrol as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->registration->patient->no_rm ?? '-' }}
                            </td>

                            <td>
                                {{ $item->registration->patient->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $item->registration->doctorSchedule->doctor->department->name ?? '-' }}
                            </td>

                            <td>
                                {{ $item->registration->doctorSchedule->doctor->nama ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_kontrol)->format('d-m-Y') }}
                            </td>

                            <td>{{ $item->catatan_kontrol ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada jadwal kontrol pasien.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    .search-box {
        position: relative;
        width: 220px;
    }

    .search-box button {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #06285c;
        border: 0;
        padding: 0;
        background: transparent;
        cursor: pointer;
    }

    .search-box input {
        width: 220px;
        height: 38px;
        border: 1px solid #06285c;
        border-radius: 5px;
        color: #06285c;
        padding: 0 35px 0 10px;
        outline: none;
    }

    .dashboard-table,
    .dashboard-table th,
    .dashboard-table td {
        border: 1px solid #afaeae !important;
        color: #06285c !important;
    }

    .dashboard-table {
        margin-bottom: 0;
    }

    .dashboard-table thead th {
        background-color: #06285c !important;
        color: white !important;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
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

    .dashboard-table th:first-child,
    .dashboard-table td:first-child {
        width: 60px !important;
        max-width: 60px;
        text-align: center;
    }
</style>
@endpush

@endsection