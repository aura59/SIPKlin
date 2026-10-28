@extends('layouts.app')

@section('title', 'Rekam Medis')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-900">Rekam Medis</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Pelayanan / Rekam Medis</h1>

<div class="row">
    <div class="col-12">
        <div class="card medical-record-card">

            <form action="{{ route('medical-records.store') }}" method="POST">
                @csrf

                <div class="card-header">
                    <h5 class="card-title mb-0">Form Rekam Medis</h5>
                </div>

                <div class="card-body">

                    {{-- DATA PASIEN --}}
                    <div class="patient-data-box">

                        <div class="patient-data-title">
                            <i class="fas fa-user mr-2"></i>
                            Data Pasien
                        </div>

                        <div class="form-row-costum">
                            <label for="registration_id">Pasien</label>

                            <select class="form-control"
                                    id="registration_id"
                                    name="registration_id"
                                    required>

                                <option value="">Pilih Pasien</option>

                                @foreach ($registrations as $registration)
                                    <option
                                        value="{{ $registration->id }}"
                                        data-nama="{{ $registration->patient->nama ?? '-' }}"
                                        data-nik="{{ $registration->patient->nik ?? '-' }}"
                                        data-no-rm="{{ $registration->patient->no_rm ?? '-' }}"
                                        data-jenis-kelamin="{{ $registration->patient->jenis_kelamin ?? '-' }}"
                                        data-tanggal-lahir="{{ $registration->patient->tanggal_lahir ?? '-' }}"
                                        data-poli="{{ $registration->doctorSchedule?->doctor?->department?->name ?? '-' }}"
                                        data-dokter="{{ $registration->doctorSchedule?->doctor?->nama ?? '-' }}"
                                        {{ old('registration_id') == $registration->id ? 'selected' : '' }}>

                                        {{ $registration->patient->no_rm ?? '-' }}
                                        - {{ $registration->patient->nama ?? '-' }}
                                    </option>
                                @endforeach

                            </select>

                            @error('registration_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div id="patient-information" style="display: none;">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="patient-info">
                                        <span>No. RM</span>
                                        <strong id="patient-no-rm">-</strong>
                                    </div>

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

                    {{-- PEMERIKSAAN DAN RESEP OBAT --}}
                    <div class="section-title">
                        <i class="fas fa-stethoscope mr-2"></i>
                        Pemeriksaan dan Resep Obat
                    </div>

                    <div class="row">

                        {{-- KOLOM KIRI: PEMERIKSAAN --}}
                        <div class="col-lg-7">

                            <div class="form-group">
                                <label for="keluhan">Keluhan</label>

                                <textarea
                                    class="form-control"
                                    id="keluhan"
                                    name="keluhan"
                                    rows="4"
                                    maxlength="500"
                                    required>{{ old('keluhan') }}</textarea>

                                @error('keluhan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="diagnosis">Diagnosis</label>

                                <textarea
                                    class="form-control"
                                    id="diagnosis"
                                    name="diagnosis"
                                    rows="4"
                                    maxlength="500"
                                    required>{{ old('diagnosis') }}</textarea>

                                @error('diagnosis')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tindakan">Tindakan</label>

                                <textarea
                                    class="form-control"
                                    id="tindakan"
                                    name="tindakan"
                                    rows="4"
                                    maxlength="500"
                                    required>{{ old('tindakan') }}</textarea>

                                @error('tindakan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        {{-- KOLOM KANAN: RESEP OBAT --}}
                        <div class="col-lg-5">

                            <div class="prescription-box">

                                <div class="prescription-title">
                                    <i class="fas fa-prescription-bottle-alt mr-2"></i>
                                    Resep Obat
                                </div>

                                <p class="text-muted small">
                                    Tuliskan nama obat, dosis, frekuensi,
                                    dan aturan pakai sesuai resep dokter.
                                </p>

                                <div class="form-group">
                                    <label for="resep_obat">Detail Resep Obat</label>

                                    <textarea
                                        class="form-control"
                                        id="resep_obat"
                                        name="resep_obat"
                                        rows="10"
                                        maxlength="2000"
                                        placeholder="Contoh format penulisan:&#10;Nama obat: ...&#10;Dosis: ...&#10;Aturan pakai: ...">{{ old('resep_obat') }}</textarea>

                                    @error('resep_obat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="prescription-note">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Jika tidak ada obat yang diresepkan, bagian ini boleh dikosongkan.
                                </div>

                            </div>

                        </div>
                    </div>

                    {{-- JADWAL KONTROL --}}
                    <div class="control-section mt-4">

                        <div class="section-title">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Jadwal Kontrol
                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="perlu_kontrol">Pasien Perlu Kontrol?</label>

                                    <select
                                        class="form-control"
                                        id="perlu_kontrol"
                                        name="perlu_kontrol"
                                        required>

                                        <option value="0"
                                            {{ old('perlu_kontrol', '0') == '0' ? 'selected' : '' }}>
                                            Tidak
                                        </option>

                                        <option value="1"
                                            {{ old('perlu_kontrol') == '1' ? 'selected' : '' }}>
                                            Ya
                                        </option>

                                    </select>

                                    @error('perlu_kontrol')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_kontrol">Tanggal Kontrol</label>

                                    <input
                                        type="date"
                                        class="form-control"
                                        id="tanggal_kontrol"
                                        name="tanggal_kontrol"
                                        value="{{ old('tanggal_kontrol') }}"
                                        min="{{ now()->toDateString() }}"
                                        disabled>

                                    @error('tanggal_kontrol')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="catatan_kontrol">Catatan Kontrol</label>

                                    <textarea
                                        class="form-control"
                                        id="catatan_kontrol"
                                        name="catatan_kontrol"
                                        rows="3"
                                        maxlength="500"
                                        placeholder="Catatan atau arahan kontrol..."
                                        disabled>{{ old('catatan_kontrol') }}</textarea>

                                    @error('catatan_kontrol')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <small class="text-muted">
                            Jadwal kontrol akan dicatat setelah rekam medis berhasil disimpan.
                        </small>

                    </div>

                </div>

                {{-- TOMBOL --}}
                <div class="card-footer">
                    <button type="submit" class="btn btn-sipklin">
                        <span class="fa fa-save"></span>
                        Simpan Rekam Medis
                    </button>

                    <a href="{{ route('queues.index') }}" class="btn btn-secondary">
                        <span class="fa fa-times-circle"></span>
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .medical-record-card {
        border: none;
        border-radius: 8px;
        overflow: hidden;
    }

    .medical-record-card .card-header {
        background-color: #06285c !important;
        color: white !important;
    }

    .medical-record-card .card-title {
        color: white !important;
        font-weight: 600;
    }

    .medical-record-card label {
        color: #06285c;
        font-weight: 600;
    }

    .medical-record-card .form-control {
        color: #06285c;
        border-color: #afaeae;
        border-radius: 4px;
    }

    .medical-record-card .form-control:focus {
        border-color: #06285c;
        box-shadow: 0 0 0 0.2rem rgba(6, 40, 92, 0.12);
    }

    .medical-record-card textarea {
        resize: vertical;
        min-height: 100px;
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

    .patient-data-box {
        background-color: #EAF1FB;
        border-left: 4px solid #06285c;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 28px;
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
        gap: 12px;
        padding: 10px 5px;
        border-bottom: 1px solid rgba(6, 40, 92, 0.12);
    }

    .patient-info span {
        color: #777;
    }

    .patient-info strong {
        color: #06285c;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .section-title {
        color: #06285c;
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .prescription-box {
        height: calc(100% - 15px);
        padding: 20px;
        background-color: #f8faff;
        border: 1px solid #dce5f2;
        border-radius: 8px;
    }

    .prescription-title {
        color: #06285c;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .prescription-note {
        padding: 10px;
        background-color: #EAF1FB;
        border-radius: 5px;
        color: #06285c;
        font-size: 12px;
    }

    .control-section {
        padding: 20px;
        background-color: #f8faff;
        border: 1px solid #dce5f2;
        border-radius: 8px;
    }

    @media (max-width: 767.98px) {
        .patient-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .patient-info strong {
            text-align: left;
        }

        .prescription-box {
            margin-top: 10px;
            height: auto;
        }

        .control-section {
            padding: 15px;
        }
    }
</style>
@endpush

<script>
document.addEventListener('DOMContentLoaded', function () {
    const registrationSelect = document.getElementById('registration_id');
    const patientInformation = document.getElementById('patient-information');

    const perluKontrol = document.getElementById('perlu_kontrol');
    const tanggalKontrol = document.getElementById('tanggal_kontrol');
    const catatanKontrol = document.getElementById('catatan_kontrol');

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
        document.getElementById('patient-no-rm').textContent = '-';
        document.getElementById('patient-nama').textContent = '-';
        document.getElementById('patient-nik').textContent = '-';
        document.getElementById('patient-jenis-kelamin').textContent = '-';
        document.getElementById('patient-tanggal-lahir').textContent = '-';
        document.getElementById('patient-poli').textContent = '-';
        document.getElementById('patient-dokter').textContent = '-';
    }

    registrationSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        if (!this.value) {
            patientInformation.style.display = 'none';
            resetPatientData();
            return;
        }

        patientInformation.style.display = 'block';

        document.getElementById('patient-no-rm').textContent =
            selectedOption.dataset.noRm || '-';

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

    function toggleControlFields() {
        const isRequired = perluKontrol.value === '1';

        tanggalKontrol.disabled = !isRequired;
        catatanKontrol.disabled = !isRequired;

        tanggalKontrol.required = isRequired;

        if (!isRequired) {
            tanggalKontrol.value = '';
            catatanKontrol.value = '';
        }
    }

    perluKontrol.addEventListener('change', toggleControlFields);

    toggleControlFields();

    if (registrationSelect.value) {
        registrationSelect.dispatchEvent(new Event('change'));
    }
});
</script>

@endsection