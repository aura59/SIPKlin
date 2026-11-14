
@extends('layouts.app')

@section('title', 'Jadwal Kontrol - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h3 mb-0 text-gray-900">Jadwal Kontrol</h5>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Jadwal Kontrol Pasien</h1>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="card shadow mb-4">

    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <span class="font-weight-bold mb-2 mb-md-0">
            Daftar Pasien yang Perlu Kontrol
        </span>

        <form action="{{ route('control-schedules.index') }}" method="GET" class="search-box">
            <button type="submit" aria-label="Cari jadwal kontrol">
                <i class="fas fa-search"></i>
            </button>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pasien...">
        </form>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped table-hover dashboard-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. RM</th>
                        <th>Nama Pasien</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Tanggal Kontrol</th>
                        <th>Status</th>
                        <th>Catatan Kontrol</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jadwalKontrol as $item)

                        @php
                            $tanggalKontrol = \Carbon\Carbon::parse($item->tanggal_kontrol);
                            $terlewat = $tanggalKontrol->lt(today());
                            $hariIni = $tanggalKontrol->isToday();
                        @endphp

                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

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

                            <td class="text-center">
                                {{ $tanggalKontrol->format('d-m-Y') }}
                            </td>

                            <td class="text-center">
                                @if ($terlewat)
                                    <span class="badge badge-danger">Terlewat</span>
                                @elseif ($hariIni)
                                    <span class="badge badge-warning">Hari Ini</span>
                                @else
                                    <span class="badge badge-success">Mendatang</span>
                                @endif
                            </td>

                            <td>
                                {{ $item->catatan_kontrol ?? '-' }}
                            </td>

                            <td class="text-center">

                                @if (Auth::user()->role === 'admin')
                                    @if ($terlewat)

                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#jadwalUlang{{ $item->id }}">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            Jadwalkan Ulang
                                        </button>

                                        <div class="collapse mt-2" id="jadwalUlang{{ $item->id }}">

                                            <form action="{{ route('control-schedules.reschedule', $item->id) }}" method="POST" class="form-jadwal-ulang">
                                                @csrf
                                                @method('PATCH')
                                                <input type="date" name="tanggal_kontrol_baru" class="form-control form-control-sm mb-2" min="{{ today()->addDay()->format('Y-m-d') }}" required>
                                                <textarea name="catatan_kontrol_baru" class="form-control form-control-sm mb-2" rows="2" placeholder="Catatan kontrol baru (opsional)">{{ $item->catatan_kontrol }}</textarea>
                                                <button type="submit"  class="btn btn-sm btn-sipklin btn-block">
                                                    <i class="fas fa-save mr-1"></i>
                                                    Simpan Jadwal Baru
                                                </button>
                                            </form>

                                        </div>

                                    @elseif ($hariIni)

                                        <a href="{{ route('registrations.create', ['patient_id' => $item->registration->patient_id]) }}" class="btn btn-sm btn-sipklin">
                                            <i class="fas fa-user-plus mr-1"></i>
                                            Daftarkan Pasien
                                        </a>

                                    @else

                                        <button type="button" class="btn btn-sm btn-secondary" disabled title="Pendaftaran baru bisa dilakukan pada tanggal kontrol">
                                            <i class="fas fa-clock mr-1"></i>
                                            Belum Waktunya
                                        </button>

                                    @endif
                                @endif

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                <p class="mb-0">
                                    Belum ada jadwal kontrol pasien.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const forms = document.querySelectorAll('.form-jadwal-ulang');

        forms.forEach(function (form) {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi Jadwal',
                    text: 'Yakin ingin menjadwalkan ulang kontrol pasien ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#06285c',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            });

        });

    });
</script>

@if (session('success'))

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ Session::get('success') }}",
                confirmButtonText: 'Oke',
                confirmButtonColor: '#06285c',
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>

@endif

@endsection

@push('styles')
<style>
    #content {
        background-color: #eaf1fb !important;
        background-image:
            radial-gradient(
                circle at 95% 5%,
                rgba(6, 40, 92, 0.16),
                transparent 35%
            ),
            radial-gradient(
                circle at 5% 95%,
                rgba(32, 201, 151, 0.13),
                transparent 30%
            ) !important;
    }
    
    .btn-sipklin {
        background-color: #06285c;
        border-color: #06285c;
        color: #ffffff !important;
        white-space: normal;
        line-height: 1.4;
    }

    .btn-sipklin:hover {
        background-color: #0b397d;
        border-color: #0b397d;
        color: #ffffff !important;
    }

    .search-box {
        position: relative;
        width: 220px;
        max-width: 100%;
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
        width: 100%;
        height: 38px;
        border: 1px solid #06285c;
        border-radius: 5px;
        color: #06285c;
        padding: 0 35px 0 10px;
        outline: none;
        box-sizing: border-box;
    }

    .search-box input:focus {
        border-color: #0b397d;
        box-shadow: 0 0 0 2px rgba(6, 40, 92, 0.1);
    }

    .dashboard-table {
        width: 100%;
        min-width: 0;
        table-layout: auto;
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .dashboard-table,
    .dashboard-table th,
    .dashboard-table td {
        border: 1px solid #afaeae !important;
        color: #06285c !important;
        font-family: Arial, sans-serif;
        font-size: 0.85rem;
    }

    .dashboard-table thead th {
        background-color: #06285c !important;
        color: #ffffff !important;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        white-space: normal;
        overflow-wrap: break-word;
        padding: 12px 8px !important;
    }

    .dashboard-table tbody td {
        vertical-align: middle;
        padding: 8px 6px !important;
        white-space: normal;
        overflow-wrap: break-word;
        word-wrap: break-word;
    }

    .dashboard-table tbody tr:hover {
        background-color: #EAF1FB !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f4f7fc !important;
    }

    .dashboard-table th:nth-child(1),
    .dashboard-table td:nth-child(1) {
        width: 5%;
        text-align: center;
    }

    .dashboard-table th:nth-child(2),
    .dashboard-table td:nth-child(2) {
        width: 9%;
    }

    .dashboard-table th:nth-child(3),
    .dashboard-table td:nth-child(3) {
        width: 15%;
    }

    .dashboard-table th:nth-child(4),
    .dashboard-table td:nth-child(4) {
        width: 10%;
    }

    .dashboard-table th:nth-child(5),
    .dashboard-table td:nth-child(5) {
        width: 13%;
    }

    .dashboard-table th:nth-child(6),
    .dashboard-table td:nth-child(6) {
        width: 13%;
    }

    .dashboard-table th:nth-child(7),
    .dashboard-table td:nth-child(7) {
        width: 8%;
    }

    .dashboard-table th:nth-child(8),
    .dashboard-table td:nth-child(8) {
        min-width: 150px;
        white-space: normal;
    }

    .dashboard-table th:last-child,
    .dashboard-table td:last-child {
        min-width: 150px;
        padding: 5px 8px;
        font-size: 0.78rem;
        line-height: 1.3;
        max-width: 110px;
    }

    .dashboard-table td:last-child .collapse {
        max-width: 145px;
        margin-left: auto;
        margin-right: auto;
    }

    @media (max-width: 991.98px) {
        .dashboard-table {
            table-layout: auto;
        }

        .dashboard-table th,
        .dashboard-table td {
            padding: 10px 8px !important;
        }

        .search-box {
            width: 220px;
        }
    }

    @media (max-width: 575.98px) {
        .card-header {
            align-items: flex-start !important;
            gap: 10px;
        }

        .search-box {
            width: 100%;
        }
    }
</style>
@endpush