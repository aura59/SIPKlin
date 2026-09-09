@extends('layouts.app')

@section('title', 'Rekam Medis')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">Rekam Medis</h1>
    </div>

    <h1 class="h6 text-gray-800 mb-4">Data Pelayanan / Rekam Medis</h1>

    <div class="row">

        <div class="col-md-10">
            <div class="card">
                <form action="{{ route('medical-records.store') }}" method="POST">
                    @csrf

                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Rekam Medis</h5>
                    </div>

                    <div class="card-body">
                        <div class="patient-data-box">
                            
                            <div class="patient-data-title">
                                <i class="fas fa-user mr-2"></i>
                                Data Pasien
                            </div>

                            <div class="form-row-costum">
                                <label for="registration_id">Pasien</label>
                                <select class="form-control" id="registration_id" name="registration_id" required>
                                    <option value="">Pilih Pasien</option>

                                    @foreach ($registrations as $registration)

                                    <option value="{{ $registration->id }}"
                                        data-nama="{{ $registration->patient->nama ?? '-' }}"
                                        data-nik="{{ $registration->patient->nik ?? '-' }}"
                                        data-jenis-kelamin="{{ $registration->patient->jenis_kelamin ?? '-' }}"
                                        data-tanggal-lahir="{{ $registration->patient->tanggal_lahir ?? '-' }}"
                                        data-poli="{{ $registration->doctorSchedule?->doctor?->department?->name ?? '-' }}"
                                        data-dokter="{{ $registration->doctorSchedule?->doctor?->nama ?? '-' }}"
                                        {{ old('registration_id') == $registration->id ? 'selected' : '' }}>

                                        {{ $registration->patient->nama ?? '-' }}
                                    </option>

                                        @endforeach
                                </select>
                            </div>

                            <div class="patient-information" style="display: none;">

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="patient-info">
                                            <span>Nama Pasien</span>
                                            <strong id="patient-nama">-</strong>
                                        </div>
                                        <div class="patient-info">
                                            <span>NIK</span>
                                            <strong id="patient-nik">-</strong>
                                        </div>
                                        <div class="patient-info">
                                            <span>Jenis Kelamin</span>
                                            <strong id="patient-jenis-kelamin">-</strong>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="patient-info">
                                            <span>Tanggal Lahir</span>
                                            <strong id="patient-tanggal-lahir">-</strong>
                                        </div>
                                        <div class="patient-info">
                                            <span>Poli</span>
                                            <strong id="patient-poli">-</strong>
                                        </div>
                                        <div class="patient-info">
                                            <span>Dokter</span>
                                            <strong id="patient-dokter">-</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row-costum textarea-row">
                            <label for="keluhan">Keluhan</label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="4" required>{{ old('keluhan') }}</textarea>
                        </div>

                        <div class="form-row-costum textarea-row">
                            <label for="diagnosis">Diagnosis</label>
                            <textarea class="form-control" id="diagnosis" name="diagnosis" rows="4" required>{{ old('diagnosis') }}</textarea>
                        </div>

                        <div class="form-row-costum textarea-row">
                            <label for="tindakan">Tindakan</label>
                            <textarea class="form-control" id="tindakan" name="tindakan" rows="4" required>{{ old('tindakan') }}</textarea>
                        </div>

                        <div class="form-row-costum textarea-row">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="4" required>{{ old('catatan') }}</textarea>
                        </div>
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-sipklin">
                            <span class="fa fa-save"></span>
                            Save
                        </button>

                        <a href="{{ route('queues.index') }}" class="btn btn-secondary">
                            <span class="fa fa-times-circle"></span>
                            Cancel
                        </a>>
                    </div>
                </form>
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
    }

    label {
        color: #06285c !important;
        font-weight: 600;
    }

    .form-control {
        color: #06285c !important;
        border-color: #afaeae;
        border-radius: 3px;
    }

    .form-control:focus {
        border-color: #06285c !important;
        box-shadow: 0 0 0 0.2rem rgba(6, 40, 92, 0.12) !important;
    }

    .medical-record-card {
        border: none;
        border-radius: 8px;
    }

    .medical-record-card .card-header {
        background: #06285c;
        color: white;
    }

    .medical-record-card .card-header h5 {
        color: white;
        font-weight: 600;
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

    .form-row-costum {
        display: grid;
        grid-template-columns: 180px 1fr;
        align-items: center;
        column-gap: 20px;
        margin-bottom: 20px;
    }

    .form-row-costum label {
        margin: 0;
        font-weight: 600;
        color: #343a40;
    }

    .textarea-row {
        align-items: start;
    }

    .textarea-row label {
        padding-top: 10px;
    }

    .textarea-row textarea {
        resize: vertical;
        min-height: 100px;
    }

    .patient-data-box {
        background-color: #EAF1FB;
        border-left: 4px solid #06285c;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .patient-data-title {
        color: #06285c;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .patient-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 5px;
        border-bottom: 1px solid rgba(6, 40, 92, 0.12);
    }

    .patient-info span {
        color: #777;
    }

    .patient-info strong {
        color: #06285c;
        text-align: right;
    }

    @media (max-width: 768px) {

        .form-row-costum {
            grid-template-columns: 1fr;
            row-gap: 8px;
        }

        .patient-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .patient-info strong {
            text-align: left;
        }

    }

</style>

@endpush


<script>

document.addEventListener('DOMContentLoaded', function () {

    const registrationSelect =
        document.getElementById('registration_id');

    const patientInformation =
        document.getElementById('patient-information');


    registrationSelect.addEventListener('change', function () {

        const selectedOption =
            this.options[this.selectedIndex];


        if (!this.value) {

            patientInformation.style.display = 'none';

            resetPatientData();

            return;
        }


        patientInformation.style.display = 'block';


        document.getElementById('patient-nama').textContent =
            selectedOption.dataset.nama || '-';

        document.getElementById('patient-nik').textContent =
            selectedOption.dataset.nik || '-';

        document.getElementById('patient-jenis-kelamin').textContent =
            selectedOption.dataset.jenisKelamin || '-';

        document.getElementById('patient-tanggal-lahir').textContent =
            formatDate(selectedOption.dataset.tanggalLahir);

        document.getElementById('patient-poli').textContent =
            selectedOption.dataset.poli || '-';

        document.getElementById('patient-dokter').textContent =
            selectedOption.dataset.dokter || '-';

    });


    function formatDate(dateString) {

        if (!dateString || dateString === '-') {
            return '-';
        }


        const date = new Date(dateString);


        if (isNaN(date.getTime())) {
            return dateString;
        }


        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });

    }


    function resetPatientData() {

        document.getElementById('patient-nama').textContent = '-';

        document.getElementById('patient-nik').textContent = '-';

        document.getElementById('patient-jenis-kelamin').textContent = '-';

        document.getElementById('patient-tanggal-lahir').textContent = '-';

        document.getElementById('patient-poli').textContent = '-';

        document.getElementById('patient-dokter').textContent = '-';

    }


    if (registrationSelect.value) {

        registrationSelect.dispatchEvent(
            new Event('change')
        );

    }

});

</script>

@endsection