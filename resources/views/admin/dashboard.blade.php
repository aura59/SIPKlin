@extends('layouts.app')

@section('title', 'Dashboard - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    </div>

     <!-- Tombol Pengingat Kontrol  -->
    <button type="button"class="btn btn-light rounded-circle shadow-sm position-relative mt-3 mt-sm-0" id="btnPengingatKontrol" data-toggle="modal" data-target="#modalPengingatKontrol" title="Pengingat Jadwal Kontrol" aria-label="Buka pengingat jadwal kontrol" style="width: 48px; height: 48px; border: 1px solid #dce3ed;">
        <i class="fas fa-bell text-sipklin"></i>
        @if (($totalPengingatKontrol ?? 0) > 0)
            <span class="badge badge-danger badge-counter" style="position: absolute; top: -5px; right: -5px;">
                {{ $totalPengingatKontrol }}
            </span>
        @endif
    </button>
</div>


<div class="row">

    <!-- Total Pasien -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-sipklin dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-sipklin text-uppercase mb-1">
                            Total Pasien
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalPasien }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-sipklin"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Dokter -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-warning dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Dokter
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalDokter }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-user-md fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendaftaran Hari Ini  -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-success dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pendaftaran Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalPendaftaranHariIni }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Antrean Menunggu  -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-info dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Antrean Menunggu
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalAntreanMenunggu }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="row">

     <!-- Pendaftaran Hari Ini  -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-sipklin">
                    <i class="fas fa-calendar-plus fa-2x text-success mr-2"></i>
                    Pendaftaran Hari Ini
                </h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dashboard-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Jam</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($pendaftaranHariIni as $pendaftaran)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $pendaftaran->patient->nama ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $pendaftaran->doctorSchedule->doctor->department->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $pendaftaran->doctorSchedule->doctor->nama ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($pendaftaran->doctorSchedule->jam_mulai)->format('H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Belum ada data pendaftaran
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Antrean Menunggu  -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-sipklin">
                    <i class="fas fa-user-clock fa-2x text-info mr-2"></i>
                    Antrean Menunggu
                </h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dashboard-table">
                        <thead>
                            <tr>
                                <th>Poli</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($antreanMenunggu as $poli => $jumlah)
                                <tr>
                                    <td>{{ $poli }}</td>
                                    <td class="text-center">{{ $jumlah }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        Belum ada data antrean menunggu
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


<!-- GRAFIK KUNJUNGAN PASIEN  -->
<div class="row">

    <div class="col-lg-8">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-sipklin">
                    <i class="fas fa-chart-line fa-2x text-sipklin mr-2"></i>
                    Grafik Kunjungan Pasien
                </h6>
            </div>

            <div class="card-body">
                <div style="position: relative; height: 320px;">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Ringkasan Kontrol Hari Ini  -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-sipklin">
                    <i class="fas fa-calendar-check fa-2x text-warning mr-2"></i>
                    Ringkasan Kontrol Hari Ini
                </h6>
            </div>

            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-calendar-check fa-3x text-sipklin mb-3"></i>

                    <h6 class="font-weight-bold text-gray-800">
                        Kontrol Hari Ini
                    </h6>

                    <p class="text-muted small">Pasien yang dijadwalkan kontrol hari ini.</p>

                    <div class="h2 font-weight-bold text-sipklin">
                        {{ $totalKontrolHariIni ?? 0 }}
                    </div>

                    <small class="text-muted">Jadwal kontrol</small>
                </div>

                <hr>

                @forelse ($jadwalKontrolHariIni ?? [] as $item)
                    <div class="border rounded p-3 mb-3">

                        <div class="font-weight-bold text-gray-800">
                            <i class="fas fa-user-circle text-sipklin mr-1"></i>
                            {{ $item->registration->patient->nama ?? 'Nama pasien tidak tersedia' }}
                        </div>

                        <div class="small text-muted mt-2">
                            <i class="fas fa-hospital mr-1"></i>
                            Poli:
                            {{ $item->registration->doctorSchedule->doctor->department->name ?? '-' }}
                        </div>

                        <div class="small text-muted mt-1">
                            <i class="fas fa-user-md mr-1"></i>
                            Dokter:
                            {{ $item->registration->doctorSchedule->doctor->nama ?? '-' }}
                        </div>

                        <div class="small text-muted mt-1">
                            <i class="fas fa-sticky-note mr-1"></i>
                            Catatan:
                            {{ $item->catatan_kontrol ?: 'Tidak ada catatan' }}
                        </div>

                    </div>
                @empty
                    <div class="text-center text-muted small py-3">
                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                        <p class="mb-0">
                            Tidak ada pasien yang dijadwalkan kontrol hari ini.
                        </p>
                    </div>
                @endforelse

                <a href="{{ route('control-schedules.index') }}"class="btn btn-sipklin btn-block">
                    Lihat Semua Jadwal
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

</div>


<!-- POPUP PENGINGAT JADWAL KONTROL  -->
<div class="modal fade" id="modalPengingatKontrol" tabindex="-1" role="dialog" aria-labelledby="judulPengingatKontrol" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">

        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">

            <!-- Header Popup -->
            <div class="modal-header text-white"style="background-color: #06285c;">
                <h5 class="modal-title" id="judulPengingatKontrol">
                    <i class="fas fa-bell mr-2"></i>
                    Pengingat Kontrol Pasien
                </h5>

                <button type="button"class="close text-white" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <!-- Kontrol Terlewat -->
                <h6 class="font-weight-bold text-danger mb-3">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Kontrol Terlewat
                    <span class="badge badge-danger">
                        {{ $totalKontrolTerlewat ?? 0 }}
                    </span>
                </h6>

                @forelse (($jadwalKontrolTerlewat ?? collect())->take(5) as $item)
                    <div class="p-3 mb-2 rounded" style="background-color: #FDECEC; border-left: 4px solid #dc3545;">

                        <div class="font-weight-bold text-gray-800">
                            {{ $item->registration->patient->nama ?? 'Nama pasien tidak tersedia' }}
                        </div>

                        <div class="small text-muted">
                            No. RM:
                            {{ $item->registration->patient->no_rm ?? '-' }}
                        </div>

                        <div class="small text-danger mt-1">
                            <i class="fas fa-calendar-times mr-1"></i>
                            Jadwal:
                            {{ \Carbon\Carbon::parse($item->tanggal_kontrol)->format('d-m-Y') }}
                        </div>

                    </div>
                @empty
                    <p class="small text-muted"> Tidak ada jadwal kontrol yang terlewat.</p>
                @endforelse

                <hr>

                <!-- Kontrol Hari Ini -->
                <h6 class="font-weight-bold mb-3" style="color: #d99b00;">
                    <i class="fas fa-calendar-day mr-1"></i>
                    Kontrol Hari Ini
                    <span class="badge badge-warning">
                        {{ $totalKontrolHariIni ?? 0 }}
                    </span>
                </h6>

                @forelse (($jadwalKontrolHariIni ?? collect())->take(5) as $item)
                    <div class="p-3 mb-2 rounded" style="background-color: #FFF6DB; border-left: 4px solid #ffc107;">

                        <div class="font-weight-bold text-gray-800">
                            {{ $item->registration->patient->nama ?? 'Nama pasien tidak tersedia' }}
                        </div>

                        <div class="small text-muted">
                            No. RM:
                            {{ $item->registration->patient->no_rm ?? '-' }}
                        </div>

                        <div class="small text-muted">
                            Poli:
                            {{ $item->registration->doctorSchedule->doctor->department->name ?? '-' }}
                        </div>

                    </div>
                @empty
                    <p class="small text-muted">Tidak ada pasien yang dijadwalkan kontrol hari ini.</p>
                @endforelse

                <hr>

                <!-- Kontrol Mendatang -->
                <h6 class="font-weight-bold text-sipklin mb-3">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Kontrol dalam 3 Hari
                    <span class="badge badge-info">
                        {{ $totalKontrolMendatang ?? 0 }}
                    </span>
                </h6>

                @forelse (($jadwalKontrolMendatang ?? collect())->take(5) as $item)
                    <div class="p-3 mb-2 rounded" style="background-color: #EAF1FB; border-left: 4px solid #06285c;">

                        <div class="font-weight-bold text-gray-800">
                            {{ $item->registration->patient->nama ?? 'Nama pasien tidak tersedia' }}
                        </div>

                        <div class="small text-muted">
                            No. RM:
                            {{ $item->registration->patient->no_rm ?? '-' }}
                        </div>

                        <div class="small text-sipklin mt-1">
                            <i class="fas fa-calendar-check mr-1"></i>
                            Jadwal:
                            {{ \Carbon\Carbon::parse($item->tanggal_kontrol)->format('d-m-Y') }}
                        </div>

                    </div>
                @empty
                    <p class="small text-muted"> Belum ada jadwal kontrol dalam 3 hari ke depan.</p>
                @endforelse

            </div>

            <!-- Footer poup -->
            <div class="modal-footer">
                <button type="button"class="btn btn-secondary"data-dismiss="modal">
                    Tutup
                </button>

                <a href="{{ route('control-schedules.index') }}" class="btn btn-sipklin">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Lihat Semua Jadwal
                </a>
            </div>

        </div>
    </div>
</div>

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
        background-color: #06285c !important;
        border-color: #06285c !important;
        color: white !important;
    }

    .btn-sipklin:hover {
        background-color: #041c40 !important;
        border-color: #041c40 !important;
        color: white !important;
    }

    .text-sipklin {
        color: #06285c !important;
    }

    .dashboard-table,
    .dashboard-table th,
    .dashboard-table td {
        border: 1px solid #afaeae !important;
        color: #06285c;
    }

    .dashboard-table th {
        font-weight: bold;
        text-align: center;
    }

    #btnPengingatKontrol {
        transition: all 0.2s ease;
    }

    #btnPengingatKontrol:hover {
        background-color: #EAF1FB !important;
        transform: translateY(-2px);
    }

    #modalPengingatKontrol .modal-body {
        max-height: 65vh;
        overflow-y: auto;
    }
</style>
@endpush


<!-- GRAFIK KUNJUNGAN PASIEN SIPKlin -->
@push('script')
<script>
    window.sipklinChartLabels = [
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];

    window.sipklinChartValues = {{ Js::from($grafikKunjungan ?? array_fill(0, 12, 0)) }};
</script>

<script src="{{ asset('js/demo/chart-area-sipklin.js') }}"></script>
@endpush