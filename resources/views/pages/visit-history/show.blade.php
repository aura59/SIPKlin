@extends('layouts.app')

@section('title', 'Detail Riwayat Kunjungan - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h3 mb-0 text-gray-900">Detail Rekam Medis</h5>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Riwayat Kunjungan / Detail</h1>

<div class="row rekam-medis-row">

    <div class="col-md-7">

        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Rekam Medis</h5>
            </div>

            <div class="card-body">

                <div class="detail-item">
                    <label>Pasien</label>
                    <p>{{ $registration->patient->nama }}</p>
                </div>

                <div class="detail-item">
                    <label>No. Antrean</label>
                    <p>
                        {{ $registration->doctorSchedule->doctor->department->kode_poli ?? '-' }}-{{ str_pad(optional($registration->queue)->nomor_antrean ?? 0, 3, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <div class="detail-item">
                    <label>Poli</label>
                    <p>
                        {{ $registration->doctorSchedule->doctor->department->name ?? '-' }}
                    </p>
                </div>

                <div class="detail-item">
                    <label>Tanggal</label>
                    <p>
                        {{ \Carbon\Carbon::parse($registration->tanggal)->format('d F Y') }}
                    </p>
                </div>

                <div class="detail-item">
                    <label>Dokter</label>
                    <p>
                        {{ $registration->doctorSchedule->doctor->nama ?? '-' }}
                    </p>
                </div>

                <div class="detail-item">
                    <label>Status</label>
                    <p>
                        <span class="badge badge-success">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </p>
                </div>

                <div class="detail-item">
                    <label>Keluhan</label>
                    <p>
                        {{ $registration->medicalRecord->keluhan ?? '-' }}
                    </p>
                </div>

                <div class="detail-item">
                    <label>Diagnosis</label>
                    <p>
                        {{ $registration->medicalRecord->diagnosis ?? '-' }}
                    </p>
                </div>

                <div class="detail-item">
                    <label>Tindakan</label>
                    <p>
                        {{ $registration->medicalRecord->tindakan ?? '-' }}
                    </p>
                </div>

            </div>

            <div class="card-footer bg-white">

                <a href="{{ route('visit-history.index') }}" class="btn btn-secondary">
                    <span class="fa fa-arrow-left"></span>
                    Back
                </a>

            </div>

        </div>

    </div>

    <div class="col-md-5">

        <div class="card info-patient-card">

            <div class="card-body text-center d-flex flex-column justify-content-center">

                <div class="info-icon mb-4">
                    <i class="fas fa-user-injured"></i>
                </div>

                <h3 class="info-title">{{ $registration->patient->nama ?? '-' }}</h3>

                <p class="info-description">Informasi lengkap data pasien SIPKlin.</p>

                <hr>

                <div class="patient-summary">

                    <div class="summary-item">
                        <span>NIK</span>
                        <strong>{{ $registration->patient->nik ?? '-' }}</strong>
                    </div>

                    <div class="summary-item">
                        <span>Jenis Kelamin</span>
                        <strong>{{ ucfirst($registration->patient->jenis_kelamin ?? '-') }}</strong>
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

    .detail-label {
        color: #06285c;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .detail-value {
        color: #5a5c69;
        font-size: 15px;
    }

    .medical-item {
        padding: 14px 0;
        border-bottom: 1px solid #e1e5eb;
    }

    .medical-item:last-child {
        border-bottom: none;
    }

    .medical-label {
        color: #06285c;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .medical-value {
        color: #5a5c69;
        font-size: 15px;
        line-height: 1.6;
    }

    .badge-success {
        background-color: #1cc88a;
        color: white;
        font-size: 13px;
        padding: 6px 10px;
    }

    .info-patient-card {
        border-top: 4px solid #06285c;
    }

    .info-icon {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #eaf1fb;
        border-radius: 50%;
        color: #06285c;
    }

    .info-icon .fa-user-injured {
        font-size: 85px !important;
        line-height: 1 !important;
    }

    .info-title {
        color: #06285c;
        font-weight: 700;
        font-size: 25px;
        margin-bottom: 10px;
    }

    .info-description {
        color: #858796;
        font-size: 15px;
        margin-bottom: 25px;
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
        border-bottom: 1px solid #e1e5eb;
        font-size: 15px;
        gap: 15px;
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

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .rekam-medis-row {
        align-items: flex-start;
    }

    .rekam-medis-row .card {
        height: auto !important;
    }

    @media (max-width: 768px) {

        .col-md-7,
        .col-md-5 {
            margin-bottom: 20px;
        }

        .info-title {
            font-size: 22px;
        }

        .summary-item {
            font-size: 14px;
        }

        .summary-item span,
        .summary-item strong {
            font-size: 14px;
        }

    }

</style>
@endpush

@endsection