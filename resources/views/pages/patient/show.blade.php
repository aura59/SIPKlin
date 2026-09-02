@extends('layouts.app')

@section('title', 'Detail Pasien - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pasien</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Pasien / Detail</h1>

<div class="row">

    <!-- kiri -->
    <div class="col-md-7">
        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Pasien</h5>
            </div>

            <div class="card-body">

                <div class="detail-item">
                    <label>NIK</label>
                    <p>{{ $patients->nik }}</p>
                </div>

                <div class="detail-item">
                    <label>Nama Pasien</label>
                    <p>{{ $patients->nama }}</p>
                </div>

                <div class="detail-item">
                    <label>Tanggal Lahir</label>
                    <p>{{ $patients->tanggal_lahir }}</p>
                </div>

                <div class="detail-item">
                    <label>Jenis Kelamin</label>
                    <p>{{ ucfirst($patients->jenis_kelamin) }}</p>
                </div>

                <div class="detail-item">
                    <label>Alamat</label>
                    <p>{{ $patients->alamat }}</p>
                </div>

                <div class="detail-item">
                    <label>No. Telepon</label>
                    <p>{{ $patients->no_telepon }}</p>
                </div>

            </div>

           <div class="card-footer">
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                    <span class="fa fa-arrow-left"></span>
                    Back
                </a>

                <a href="{{ route('patients.edit', $patients->id) }}" class="btn btn-sipklin  ">
                    <span class="fa fa-edit"></span>
                    Edit
                </a>
            </div>

        </div>
    </div>


    <!-- kanan -->
    <div class="col-md-5">
        <div class="card info-patient-card h-100">

            <div class="card-body text-center d-flex flex-column justify-content-center">

                <div class="info-icon mb-4">
                    <i class="fas fa-user-injured"></i>
                </div>

                <h3 class="info-title">
                    {{ $patients->nama }}
                </h3>

                <p class="text-muted">
                    Informasi lengkap data pasien SIPKlin.
                </p>

                <hr>

                <div class="patient-summary">

                    <div class="summary-item">
                        <span>NIK</span>
                        <strong>{{ $patients->nik }}</strong>
                    </div>

                    <div class="summary-item">
                        <span>Jenis Kelamin</span>
                        <strong>{{ ucfirst($patients->jenis_kelamin) }}</strong>
                    </div>

                    <div class="summary-item">
                        <span>No. Telepon</span>
                        <strong>{{ $patients->no_telepon }}</strong>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>


@push('styles')
<style>

    .detail-item {
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e3e6f0;
    }

    .detail-item label {
        display: block;
        color: #06285c !important;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .detail-item p {
        margin-bottom: 0;
        color: #555;
        font-size: 16px;
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

    .info-patient-card {
        border-top: 4px solid #06285c;
    }

    .info-icon {
        width: 180px;
        height: 180px;
        margin: 0 auto;

        display: flex;
        align-items: center;
        justify-content: center;

        background-color: #EAF1FB;
        border-radius: 50%;

        color: #06285c;
    }

    .info-icon .fa-user-injured {
        font-size: 110px !important;
        line-height: 1 !important;
    }

    .info-title {
        color: #06285c;
        font-weight: 700;
    }

    .patient-summary {
        text-align: left;
        padding: 0 30px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e3e6f0;
        gap: 15px;
    }

    .summary-item span {
        color: #777;
    }

    .summary-item strong {
        color: #06285c;
        text-align: right;
    }

</style>
@endpush

@endsection
