@extends('layouts.app')

@section('title', 'Antrean - SIPKlin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-4 text-gray-900">Antrean Pasien</h1>
        <h1 class="h6 text-gray-800 mb-2">Data Pelayanan / Antrean</h1>
    </div>

    <form action="{{ route('queues.index') }}" method="GET" class="queue-filter">

        <div class="filter-item">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal', $tanggal) }}">
        </div>

        <div class="filter-item">
            <label for="department_id">Poli</label>
            <select name="department_id" id="department_id" class="form-control">
                <option value="">Semua Poli</option>

                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ request('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-sipklin btn-tampilkan">Tampilkan</button>

    </form>
</div>

<div class="row">

    <div class="col-md-3 mb-4">
        <div class="card queue-info-card h-100">

            <div class="card-header text-center">
                <strong>Informasi Poli</strong>
            </div>

            <div class="card-body">

                <div class="poli-information text-center">

                    <div class="poli-icon">
                        <i class="fas fa-hospital"></i>
                    </div>

                    <h5>{{ $selectedDepartment->name ?? 'Semua Poli' }}</h5>

                    @if ($currentRegistration)
                        <p class="mb-1">
                            <strong>Dokter:</strong>
                            {{ $currentRegistration->doctorSchedule->doctor->nama ?? '-' }}
                        </p>

                        <p>
                            <strong>Jam:</strong>
                            {{ \Carbon\Carbon::parse($currentRegistration->doctorSchedule->jam_mulai)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($currentRegistration->doctorSchedule->jam_selesai)->format('H:i') }}
                        </p>
                    @elseif ($nextRegistration)

                        <p class="mb-1">
                            <strong>Dokter:</strong>
                            {{ $nextRegistration->doctorSchedule->doctor->nama ?? '-' }}
                        </p>

                        <p>
                            <strong>Jam:</strong>
                            {{ \Carbon\Carbon::parse($nextRegistration->doctorSchedule->jam_mulai)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($nextRegistration->doctorSchedule->jam_selesai)->format('H:i') }}
                        </p>
                    @else
                        <p class="text-muted">Belum ada antrean</p>
                    @endif

                </div>

                <div class="current-queue-box">
                    <span>Sedang Dilayani</span>

                    @if ($currentRegistration)

                        @php
                            $currentCode = $currentRegistration->doctorSchedule->doctor->department->kode_poli ?? 'A';
                            $currentNumber = optional($currentRegistration->queue)->nomor_antrean ?? 0;
                        @endphp

                        <strong>
                            {{ $currentCode }}-{{ str_pad($currentNumber, 2, '0', STR_PAD_LEFT) }}
                        </strong>

                        <p>{{ $currentRegistration->patient->nama ?? '-' }}</p>

                    @else
                        <strong>-</strong>
                        <p>Belum ada</p>
                    @endif
                </div>

                <div class="next-queue-info">

                <span>Berikutnya</span>

                    @if ($nextRegistration)

                        @php
                            $nextCode = $nextRegistration->doctorSchedule->doctor->department->kode_poli ?? 'A';
                            $nextNumber = optional($nextRegistration->queue)->nomor_antrean ?? 0;
                        @endphp

                        <strong>
                            {{ $nextCode }}-{{ str_pad($nextNumber, 2, '0', STR_PAD_LEFT) }}
                        </strong>

                        <p>{{ $nextRegistration->patient->nama ?? '-' }}</p>

                        <form action="{{ route('queues.call', $nextRegistration->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-sipklin btn-block">
                                <i class="fas fa-bullhorn mr-2"></i>
                                Panggil
                                {{ $nextCode }}-{{ str_pad($nextNumber, 2, '0', STR_PAD_LEFT) }}
                            </button>
                        </form>

                    @else
                        <strong>-</strong>
                        <p>Tidak ada antrean</p>
                    @endif

                </div>

            </div>

        </div>
    </div>


    <div class="col-md-9 mb-4">
        <div class="card queue-table-card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Daftar Antrean</strong>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-hover dashboard-table">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Antrean</th>
                                <th>Pasien</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Jam Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($registrations as $registration)

                                @php
                                    $kodePoli = $registration->doctorSchedule->doctor->department->kode_poli ?? 'A';
                                    $nomorAntrean = optional($registration->queue)->nomor_antrean ?? 0;
                                @endphp

                                <tr>

                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $kodePoli }}-{{ str_pad($nomorAntrean, 2, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>{{ $registration->patient->nama ?? '-' }}</td>
                                    <td>{{ $registration->doctorSchedule->doctor->department->name ?? '-' }}</td>
                                    <td>{{ $registration->doctorSchedule->doctor->nama ?? '-' }}</td>
                                    <td>{{ $registration->created_at->timezone('Asia/Jakarta')->format('H:i') }}</td>
                                    <td>
                                        @if ($registration->status == 'menunggu')
                                            <span class="badge badge-warning">Menunggu</span>

                                        @elseif ($registration->status == 'dipanggil')
                                            <span class="badge badge-success">Dipanggil</span>

                                        @elseif ($registration->status == 'selesai')
                                            <span class="badge badge-secondary">Selesai</span>

                                        @endif
                                    </td>

                                    <td>
                                        @if ($registration->status == 'menunggu')

                                            <form action="{{ route('queues.call', $registration->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-sm btn-primary" title="Panggil antrean">
                                                    <i class="fas fa-bullhorn"></i>
                                                </button>
                                            </form>

                                        @elseif ($registration->status == 'dipanggil')

                                            <form action="{{ route('queues.finish', $registration->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-sm btn-success" title="Selesaikan antrean">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                        @else

                                            <span class="text-muted">—</span>

                                        @endif
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        Belum ada antrean pasien
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
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

    .queue-filter {
        display: flex;
        align-items: end;
        gap: 15px;
    }

    .filter-item {
        width: 180px;
    }

    .filter-item label {
        display: block;
        margin-bottom: 6px;
        color: #06285c;
        font-weight: bold;
    }

    .filter-item .form-control {
        height: 38px;
        border: 1px solid #afaeae !important;
        color: #06285c !important;
    }

    .btn-tampilkan {
        height: 38px;
        padding-left: 18px !important;
        padding-right: 18px !important;
        white-space: nowrap;
    }

    .queue-info-card {
        border: 1px solid #afaeae !important;
        border-radius: 6px;
    }

    .queue-info-card .card-header {
        background-color: #06285c;
        color: white;
        text-align: center;
    }

    .poli-information {
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .poli-icon {
        width: 55px;
        height: 55px;
        margin: 0 auto 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #EAF1FB;
        border-radius: 50%;
        color: #06285c;
        font-size: 25px;
    }

    .poli-information h5 {
        color: #06285c;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .poli-information p {
        color: #6c757d;
        font-size: 13px;
    }

    .current-queue-box {
        margin-top: 20px;
        padding: 15px;
        background-color: #EAF1FB;
        border-radius: 6px;
        text-align: center;
    }

    .current-queue-box span,
    .next-queue-info span {
        display: block;
        color: #6c757d;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .current-queue-box strong,
    .next-queue-info strong {
        display: block;
        color: #06285c;
        font-size: 30px;
        font-weight: 800;
    }

    .current-queue-box p,
    .next-queue-info p {
        color: #06285c;
        font-size: 14px;
        margin: 3px 0 12px;
    }

    .next-queue-info {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #afaeae;
        border-radius: 6px;
        text-align: center;
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

    .badge-warning {
        padding: 7px 10px;
    }

    .badge-success {
        padding: 7px 10px;
    }

    .badge-secondary {
        padding: 7px 10px;
    }

</style>

@endpush

@endsection