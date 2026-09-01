@extends('layouts.app')

@section('title', 'Dashboard - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    </div>
</div>


<div class="row">

    <!-- Pasien -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-sipklin dashboard-card">

            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-sipklin text-uppercase mb-1"> Total Pasien</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalPasien }}</div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-sipklin"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Dokter -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-warning dashboard-card">

            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Dokter</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDokter }}</div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-user-md fa-2x text-warning"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Pendaftaran Hari Ini -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-success dashboard-card">

            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendaftaran Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPendaftaranHariIni }}</div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-success"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Antrean Menunggu -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-info dashboard-card">

            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Antrean Menunggu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAntreanMenunggu }}</div>
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

    <!-- Pendaftaran Hari Ini -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-sipklin">Pendaftaran Hari Ini</h6>
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
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data pendaftaran</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>


    <!-- Antrean Menunggu -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-sipklin">Antrean Menunggu</h6>
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
                            <tr>
                                <td colspan="2" class="text-center text-muted">Belum ada antrean</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@push('styles')
<style>

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

</style>
@endpush