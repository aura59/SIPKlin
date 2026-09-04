@extends('layouts.app')

@section('title', 'Detail Dokter - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Data Dokter</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Jadwal Dokter / Detail</h1>

<div class="row">

    <div class="col-md-7">
        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Jadwal Dokter</h5>
            </div>

            <div class="card-body">
                <div class="detail-item">
                    <label>Dokter</label>
                    <p>{{ $doctorschedule->doctor->nama }}</p>
                </div>

                <div class="detail-item">
                    <label>Poli</label>
                    <p>{{ $doctorschedule->doctor->department->name }}</p>
                </div>

                <div class="detail-item">
                    <label>Hari</label>
                    <p>{{ $doctorschedule->hari }}</p>
                </div>

                <div class="detail-item">
                    <label>Jam Mulai</label>
                    <p>{{\Carbon\Carbon::parse($doctorschedule->jam_mulai)->format('H:i') }}</p>
                </div>

                <div class="detail-item">
                    <label>Jam Selesai</label>
                    <p>{{\Carbon\Carbon::parse($doctorschedule->jam_selesai)->format('H:i') }}</p>
                </div>

                <div class="detail-item">
                    <label>Kuota</label>
                    <p>{{ $doctorschedule->kuota }}</p>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('doctorschedules.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <a href="{{ route('doctorschedules.edit', $doctorschedule->id) }}" class="btn btn-sipklin">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
            </div>

        </div>
    </div>


    <div class="col-md-5">
        <div class="card info-doctor-card h-100">

            <div class="card-body text-center d-flex flex-column justify-content-center">

                <div class="info-icon mb-4">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                </div>

                <h3 class="info-title">{{$doctorschedule->doctor->nama}}</h3>

                <p class="text-muted">Informasi lengkap data jadwal dokter SIPKlin.</p>

                <hr>

                <div class="doctor-summary">

                    <div class="summary-item">
                        <span>Poli</span>
                        <strong>
                            {{ $doctorschedule->doctor->department->name}}
                        </strong>
                    </div>

                    <div class="summary-item">
                        <span>Jam Mulai</span>
                        <strong>
                            {{ \Carbon\Carbon::parse($doctorschedule->jam_mulai)->format('H:i') }}
                        </strong>
                    </div>

                    <div class="summary-item">
                        <span>Jam Selesai</span>
                        <strong>
                            {{\Carbon\Carbon::parse($doctorschedule->jam_selesai)->format('H:i') }}
                        </strong>
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

    .info-doctor-card {
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

    .info-icon i {
        font-size: 85px !important;
    } 

    .info-icon .fa-user-md {
        font-size: 120px !important;
        line-height: 1 !important;
    }

    .info-title {
        color: #06285c;
        font-weight: 700;
    }

    .doctor-summary {
        text-align: left;
        padding: 0 30px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e3e6f0;
    }

    .summary-item span {
        color: #777;
    }

    .summary-item strong {
        color: #06285c;
    }

</style>
@endpush

@endsection