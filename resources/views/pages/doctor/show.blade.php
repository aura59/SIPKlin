@extends('layouts.app')

@section('title', 'Detail Riwayat Kunjungan - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Rekam Medis</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Riwayat Kunjungan / Detail</h1>

<div class="row">
    <div class="col-md-7">

        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Rekam Medis</h5>
            </div>

            <div class="card-body">
                <div class="detail-item">
                    <label>Pasien</label>
                    <p>{{ $registration->patient->nama ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <label>No. Antrean</label>
                    <p>{{ optional($registration->queue)->nomor ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <label>Poli</label>
                    <p>{{ $registration->doctorSchedule->doctor->department->name ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <label>Tanggal</label>
                    <p>{{ \Carbon\Carbon::parse($registration->tanggal)->format('d F Y') }}</p>
                </div>

                <div class="detail-item">
                    <label>Dokter</label>
                    <p>{{ $registration->doctorSchedule->doctor->nama ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <label>Status</label>
                    <p>
                        <span class="badge badge-success">{{ ucfirst($registration->status) }}</span>
                    </p>
                </div>

                <div class="detail-item">
                    <label>Keluhan</label>
                    <p>{{ $registration->medicalRecord->keluhan ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <label>Diagnosis</label>
                    <p>{{ $registration->medicalRecord->diagnosis ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <label>Tindakan</label>
                    <p>{{ $registration->medicalRecord->tindakan ?? '-' }}</p>
                </div>
            </div>


            <div class="card-footer">
                <a href="{{ route('visit-history.index') }}"class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
            </div>

        </div>
    </div>


    <div class="col-md-5">

        <div class="card info-patient-card h-100">

            <div class="card-body text-center d-flex flex-column justify-content-center">
                <div class="info-icon mb-4">
                    <i class="fas fa-user"></i>
                </div>

                <h3 class="info-title">{{ $registration->patient->nama ?? '-' }}</h3>

                <p class="text-muted">Informasi lengkap data pasien SIPKlin.</p>

                <hr>

                <div class="patient-summary">
                    <div class="summary-item">
                        <span>NIK</span>
                        <strong>{{ $registration->patient->nik ?? '-' }}</strong>
                    </div>

                    <div class="summary-item">
                        <span>Jenis Kelamin</span>
                        <strong>{{ $registration->patient->jenis_kelamin ?? '-' }}</strong>
                    </div>

                    <div class="summary-item">
                        <span>No. Telepon</span>
                        <strong>{{ $registration->patient->no_telepon ?? '-' }}</strong>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


@push('styles')

<style>

    .card-header {
        background-color: #06285c !important;
        color: white !important;
    }

    .card-header .card-title {
        color: white !important;
        font-weight: 600;
        font-size: 18px !important;
    }

    .detail-item {
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e3e6f0;
    }

    .detail-item label {
        display: block;
        color: #06285c !important;
        font-weight: 600;
        font-size: 16px !important;
        margin-bottom: 7px;
    }

    .detail-item p {
        margin-bottom: 0;
        color: #555;
        font-size: 18px !important;
        line-height: 1.5;
    }

    .badge-success {
        background-color: #1cc88a;
        color: white;
        font-size: 14px !important;
        padding: 6px 10px;
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

    .info-icon .fa-user {
        font-size: 120px !important;
        line-height: 1 !important;
    }

    .info-title {
        color: #06285c;
        font-weight: 700;
        font-size: 28px !important;
    }

    .patient-summary {
        text-align: left;
        padding: 0 30px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #e3e6f0;
        font-size: 15px;
    }

    .summary-item span {
        color: #777;
        font-size: 15px;
    }

    .summary-item strong {
        color: #06285c;
        font-size: 15px;
        text-align: right;
    }

    @media (max-width: 768px) {
        .col-md-7,
        .col-md-5 {
            margin-bottom: 20px;
        }
        .detail-item p {
            font-size: 17px !important;
        }
        .info-icon {
            width: 140px;
            height: 140px;
        }
        .info-icon .fa-user {
            font-size: 90px !important;
        }
    }

</style>

@endpush

@endsection