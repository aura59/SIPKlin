@extends('layouts.app')

@section('title', 'Pendaftaran Pasien')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pendaftaran Pasien</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Pelayanan / Pendaftaran</h1>

<div class="row">
    <div class="col-md-8">
        <div class="card registration-card">

            <form action="{{ route('registrations.store') }}" method="POST" id="registration-form">
                @csrf

                <div class="card-header">
                    <h5 class="card-title mb-0">Form Pendaftaran</h5>
                </div>

                <div class="card-body">

                    {{-- PILIH PASIEN --}}
                    <div class="form-row-costum">
                        <label for="patient-search">Pasien</label>

                        <div class="patient-picker" id="patient-picker">

                            <div class="patient-search-wrapper">
                                <i class="fas fa-search patient-search-icon"></i>

                                <input
                                    type="search"
                                    class="form-control patient-search-input @error('patient_id') is-invalid @enderror"
                                    id="patient-search"
                                    placeholder="Cari nama atau nomor rekam medis..."
                                    autocomplete="off"
                                    role="combobox"
                                    aria-expanded="false"
                                    aria-controls="patient-options"
                                    aria-autocomplete="list"
                                    value=""
                                    required
                                >
                            </div>

                            <div
                                class="patient-dropdown"
                                id="patient-options"
                                role="listbox"
                                hidden>
                            </div>

                            <select
                                class="d-none"
                                id="patient_id"
                                name="patient_id"
                                aria-hidden="true"
                                tabindex="-1">
                                <option value="">Pilih Pasien</option>

                                @foreach ($patients as $patient)
                                    <option
                                        value="{{ $patient->id }}"
                                        {{ old('patient_id', $selectedPatientId ?? '') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->no_rm }} - {{ $patient->nama }}
                                    </option>
                                @endforeach
                            </select>

                            <small class="patient-helper">
                                Ketik nama atau nomor rekam medis untuk mencari pasien.
                            </small>

                            @error('patient_id')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- POLI --}}
                    <div class="form-row-costum">
                        <label for="department_id">Poli</label>

                        <select class="form-control" id="department_id" name="department_id" required>
                            <option value="">Pilih Poli</option>

                            @foreach ($departments as $department)
                                <option
                                    value="{{ $department->id }}"
                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- DOKTER --}}
                    <div class="form-row-costum">
                        <label for="doctor_id">Dokter</label>

                        <select
                            class="form-control"
                            id="doctor_id"
                            name="doctor_id"
                            disabled
                            required>
                            <option value="">Pilih Dokter</option>

                            @foreach ($doctors as $doctor)
                                <option
                                    value="{{ $doctor->id }}"
                                    data-department="{{ $doctor->department_id }}">
                                    {{ $doctor->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- JADWAL --}}
                    <div class="form-row-costum">
                        <label for="doctor_schedule_id">Jadwal</label>

                        <select
                            class="form-control"
                            id="doctor_schedule_id"
                            name="doctor_schedule_id"
                            disabled
                            required>
                            <option value="">Pilih Jadwal</option>

                            @foreach ($doctorschedules as $schedule)
                                <option
                                    value="{{ $schedule->id }}"
                                    data-doctor="{{ $schedule->doctor_id }}"
                                    data-day="{{ $schedule->hari }}"
                                    data-start="{{ $schedule->jam_mulai }}"
                                    data-end="{{ $schedule->jam_selesai }}"
                                    data-quota="{{ $schedule->kuota }}">
                                    {{ $schedule->hari }} -
                                    {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TANGGAL --}}
                    <div class="form-row-costum">
                        <label for="tanggal">Tanggal</label>

                        <input
                            type="date"
                            class="form-control"
                            id="tanggal"
                            name="tanggal"
                            min="{{ now()->format('Y-m-d') }}"
                            value="{{ old('tanggal') }}"
                            required>
                    </div>

                    {{-- CATATAN --}}
                    <div class="form-row-costum textarea-row">
                        <label for="catatan">Keluhan/Catatan</label>

                        <textarea
                            class="form-control"
                            id="catatan"
                            name="catatan"
                            rows="4"
                            placeholder="Masukkan keluhan pasien..."
                            required>{{ old('catatan') }}</textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-sipklin" id="btn-submit">
                        <span class="fa fa-save"></span>
                        Save
                    </button>

                    <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                        <span class="fa fa-times-circle"></span>
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>

    {{-- INFORMASI ANTREAN --}}
    <div class="col-md-4">
        <div class="card info-registration-card h-100">

            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="registration-icon">
                        <i class="fas fa-list-ol"></i>
                    </div>

                    <h3 class="card-title mb-0">Informasi Antrean</h3>

                    <p class="card-text text-muted">
                        Informasi singkat mengenai antrean pasien di klinik.
                    </p>
                </div>

                <hr>

                <div class="registration-info-list">

                    <div class="registration-info-item">
                        <span>
                            <i class="fas fa-hospital mr-2"></i>
                            Poli
                        </span>
                        <strong id="info-department">-</strong>
                    </div>

                    <div class="registration-info-item">
                        <span>
                            <i class="fas fa-user-md mr-2"></i>
                            Dokter
                        </span>
                        <strong id="info-doctor">-</strong>
                    </div>

                    <div class="registration-info-item">
                        <span>
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Jadwal
                        </span>
                        <strong id="info-schedule">-</strong>
                    </div>

                    <div class="registration-info-item">
                        <span>
                            <i class="fas fa-users mr-2"></i>
                            Kuota Tersedia
                        </span>
                        <strong id="info-quota">-</strong>
                    </div>

                    <div class="queue-box">
                        <span>Nomor Antrean Berikutnya</span>
                        <strong id="info-queue">{{ $nextQueueNumber ?? '-' }}</strong>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div
    id="registration-data"
    data-registration-counts="{{ json_encode($registrationCounts ?? []) }}"
    data-queue-numbers="{{ json_encode($queueNumbers ?? []) }}">
</div>

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
    }

    .form-control:focus {
        border-color: #06285c !important;
        box-shadow: 0 0 0 0.2rem rgba(6, 40, 92, 0.12) !important;
    }

    .registration-card,
    .info-registration-card {
        border: none;
        border-radius: 8px;
    }

    .registration-card .card-header {
        background: #06285c;
        color: white;
    }

    .registration-card .card-header h5 {
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

    .info-registration-card {
        border-top: 4px solid #06285c;
    }

    .registration-icon {
        width: 110px;
        height: 110px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #EAF1FB;
        border-radius: 50%;
        color: #06285c;
    }

    .registration-icon i {
        font-size: 58px;
    }

    .info-title {
        color: #06285c;
        font-weight: 700;
    }

    .registration-info-list {
        margin-top: 25px;
    }

    .registration-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 5px;
        border-bottom: 1px solid #e3e6f0;
    }

    .registration-info-item span {
        color: #777;
    }

    .registration-info-item span i {
        color: #06285c;
    }

    .registration-info-item strong {
        color: #06285c;
        text-align: right;
    }

    .queue-box {
        margin-top: 25px;
        padding: 20px;
        background-color: #EAF1FB;
        border-radius: 8px;
        text-align: center;
    }

    .queue-box span {
        display: block;
        color: #777;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .queue-box strong {
        display: block;
        color: #06285c;
        font-size: 42px;
        font-weight: 800;
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

    .form-row-costum .form-control {
        height: 42px;
        border: 1px solid #afaeae;
        border-radius: 3px;
    }

    .textarea-row {
        align-items: start;
    }

    .textarea-row label {
        padding-top: 10px;
    }

    .textarea-row textarea {
        min-height: 100px;
        resize: vertical;
        height: auto !important;
    }

    /* SEARCHABLE PATIENT DROPDOWN */

    .patient-picker {
        position: relative;
        width: 100%;
    }

    .patient-search-wrapper {
        position: relative;
    }

    .patient-search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #8995a7;
        font-size: 14px;
        z-index: 2;
        pointer-events: none;
    }

    .patient-picker .patient-search-input {
        height: 42px !important;
        padding-left: 40px !important;
        padding-right: 14px;
        border: 1px solid #afaeae !important;
        border-radius: 5px !important;
        background-color: #fff;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
    }

    .patient-picker .patient-search-input:focus {
        border-color: #06285c !important;
        box-shadow: 0 0 0 3px rgba(6, 40, 92, .10) !important;
        outline: none;
    }

    .patient-picker .patient-search-input::placeholder {
        color: #a0a9b6;
    }

    .patient-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        max-height: 240px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #dce3ed;
        border-radius: 7px;
        box-shadow: 0 8px 22px rgba(20, 38, 65, .12);
        z-index: 1050;
        padding: 5px;
    }

    .patient-dropdown[hidden] {
        display: none !important;
    }

    .patient-option {
        display: block;
        width: 100%;
        padding: 10px 12px;
        border: none;
        border-radius: 5px;
        background: transparent;
        text-align: left;
        cursor: pointer;
        transition: background .15s;
    }

    .patient-option:hover,
    .patient-option.active {
        background: #edf3fb;
    }

    .patient-option strong {
        display: block;
        color: #06285c;
        font-size: 13px;
        font-weight: 600;
    }

    .patient-option small {
        display: block;
        color: #7b8798;
        font-size: 12px;
        margin-top: 3px;
    }

    .patient-empty {
        padding: 16px 12px;
        text-align: center;
        color: #7b8798;
        font-size: 13px;
    }

    .patient-helper {
        display: block;
        color: #8490a2;
        font-size: 12px;
        margin-top: 6px;
    }

    @media (max-width: 767.98px) {
        .form-row-costum {
            grid-template-columns: 1fr;
            row-gap: 8px;
        }

        .form-row-costum label {
            margin-bottom: 2px;
        }
    }
</style>
@endpush

<script>
document.addEventListener('DOMContentLoaded', function () {

    const registrationForm = document.getElementById('registration-form');

    const departmentSelect = document.getElementById('department_id');

    const patientPicker = document.getElementById('patient-picker');
    const patientSearch = document.getElementById('patient-search');
    const patientDropdown = document.getElementById('patient-options');
    const patientSelect = document.getElementById('patient_id');

    const doctorSelect = document.getElementById('doctor_id');
    const scheduleSelect = document.getElementById('doctor_schedule_id');
    const tanggalInput = document.getElementById('tanggal');
    const submitButton = document.getElementById('btn-submit');

    const infoDepartment = document.getElementById('info-department');
    const infoDoctor = document.getElementById('info-doctor');
    const infoSchedule = document.getElementById('info-schedule');
    const infoQuota = document.getElementById('info-quota');
    const infoQueue = document.getElementById('info-queue');

    const registrationData = document.getElementById('registration-data');

    let registrationCounts = {};
    let queueNumbers = {};

    try {
        registrationCounts = JSON.parse(
            registrationData.dataset.registrationCounts || '{}'
        );
    } catch (error) {
        console.error('Data jumlah pendaftaran tidak valid:', error);
    }

    try {
        queueNumbers = JSON.parse(
            registrationData.dataset.queueNumbers || '{}'
        );
    } catch (error) {
        console.error('Data nomor antrean tidak valid:', error);
    }

    const doctorOptions = Array.from(
        doctorSelect.querySelectorAll('option[data-department]')
    );

    const scheduleOptions = Array.from(
        scheduleSelect.querySelectorAll('option[data-doctor]')
    );

    // ==========================================
    // SEARCHABLE PATIENT DROPDOWN
    // ==========================================

    const patientOptions = Array.from(
        patientSelect.querySelectorAll('option')
    ).filter(option => option.value !== '');

    let activePatientIndex = -1;

    function closePatientDropdown() {
        patientDropdown.hidden = true;
        patientSearch.setAttribute('aria-expanded', 'false');
        activePatientIndex = -1;
    }

    function selectPatient(option) {
        patientSelect.value = option.value;
        patientSearch.value = option.textContent.trim();

        patientSearch.setCustomValidity('');

        closePatientDropdown();
    }

    function renderPatientOptions(keyword = '') {

        patientDropdown.innerHTML = '';
        activePatientIndex = -1;

        const searchTerm = keyword.trim().toLowerCase();

        const filteredPatients = patientOptions.filter(option => {
            return option.textContent
                .trim()
                .toLowerCase()
                .includes(searchTerm);
        });

        if (filteredPatients.length === 0) {

            const emptyMessage = document.createElement('div');

            emptyMessage.className = 'patient-empty';
            emptyMessage.textContent = 'Pasien tidak ditemukan.';

            patientDropdown.appendChild(emptyMessage);

        } else {

            filteredPatients.forEach(option => {

                const parts = option.textContent.trim().split(' - ');

                const button = document.createElement('button');

                button.type = 'button';
                button.className = 'patient-option';
                button.setAttribute('role', 'option');
                button.setAttribute('aria-selected', 'false');

                const patientName = document.createElement('strong');
                patientName.textContent = parts.slice(1).join(' - ') || option.textContent;

                const recordNumber = document.createElement('small');
                recordNumber.textContent = parts[0] || '';

                button.appendChild(patientName);
                button.appendChild(recordNumber);

                button.addEventListener('click', function () {
                    selectPatient(option);
                });

                patientDropdown.appendChild(button);
            });
        }

        patientDropdown.hidden = false;
        patientSearch.setAttribute('aria-expanded', 'true');
    }

    patientSearch.addEventListener('focus', function () {
        renderPatientOptions(this.value);
    });

    patientSearch.addEventListener('input', function () {

        // Pilihan lama dibatalkan jika isi pencarian berubah.
        patientSelect.value = '';

        this.setCustomValidity(
            'Silakan pilih pasien dari daftar hasil pencarian.'
        );

        renderPatientOptions(this.value);
    });

    patientSearch.addEventListener('keydown', function (event) {

        const buttons = patientDropdown.querySelectorAll('.patient-option');

        if (event.key === 'Escape') {
            closePatientDropdown();
            return;
        }

        if (event.key === 'ArrowDown' && buttons.length) {

            event.preventDefault();

            activePatientIndex = Math.min(
                activePatientIndex + 1,
                buttons.length - 1
            );

        } else if (event.key === 'ArrowUp' && buttons.length) {

            event.preventDefault();

            activePatientIndex = Math.max(
                activePatientIndex - 1,
                0
            );

        } else if (event.key === 'Enter' && activePatientIndex >= 0) {

            event.preventDefault();

            buttons[activePatientIndex].click();
            return;

        } else {
            return;
        }

        buttons.forEach((button, index) => {

            button.classList.toggle(
                'active',
                index === activePatientIndex
            );

            button.setAttribute(
                'aria-selected',
                index === activePatientIndex ? 'true' : 'false'
            );
        });

        buttons[activePatientIndex].scrollIntoView({
            block: 'nearest'
        });
    });

    document.addEventListener('click', function (event) {

        if (!patientPicker.contains(event.target)) {
            closePatientDropdown();
        }
    });

    // Validasi agar admin benar-benar memilih pasien dari daftar.
    registrationForm.addEventListener('submit', function (event) {

        if (!patientSelect.value) {

            event.preventDefault();

            patientSearch.setCustomValidity(
                'Silakan pilih pasien dari daftar hasil pencarian.'
            );

            patientSearch.reportValidity();
            patientSearch.focus();

        }
    });

    // Mempertahankan pilihan pasien setelah validasi gagal.
    if (patientSelect.value) {

        const selectedOption = patientSelect.selectedOptions[0];

        patientSearch.value = selectedOption.textContent.trim();

        patientSearch.setCustomValidity('');
    }

    // ==========================================
    // INFORMASI KUOTA
    // ==========================================

    function updateQuota() {

        const scheduleId = scheduleSelect.value;
        const tanggal = tanggalInput.value;

        if (!scheduleId || !tanggal) {

            infoQuota.textContent = '-';
            submitButton.disabled = false;

            return;
        }

        const selectedOption = scheduleSelect.options[
            scheduleSelect.selectedIndex
        ];

        if (!selectedOption) {

            infoQuota.textContent = '-';
            submitButton.disabled = false;

            return;
        }

        const quota = parseInt(
            selectedOption.dataset.quota,
            10
        );

        const key = scheduleId + '_' + tanggal;

        const jumlahPendaftaran = parseInt(
            registrationCounts[key] || 0,
            10
        );

        const quotaTersedia = quota - jumlahPendaftaran;

        if (quotaTersedia <= 0) {

            infoQuota.textContent = 'Penuh';
            submitButton.disabled = true;

        } else {

            infoQuota.textContent = quotaTersedia + ' pasien';
            submitButton.disabled = false;
        }
    }

    // ==========================================
    // INFORMASI NOMOR ANTREAN
    // ==========================================

    function updateQueue() {

        const departmentId = departmentSelect.value;
        const tanggal = tanggalInput.value;

        if (!departmentId || !tanggal) {

            infoQueue.textContent = '-';

            return;
        }

        const key = departmentId + '_' + tanggal;

        const lastQueueNumber = parseInt(
            queueNumbers[key] || 0,
            10
        );

        infoQueue.textContent = lastQueueNumber + 1;
    }

    // ==========================================
    // PILIH POLI
    // ==========================================

    departmentSelect.addEventListener('change', function () {

        const departmentId = this.value;

        doctorSelect.innerHTML = '<option value="">Pilih Dokter</option>';
        scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';

        doctorSelect.disabled = true;
        scheduleSelect.disabled = true;

        infoDepartment.textContent = '-';
        infoDoctor.textContent = '-';
        infoSchedule.textContent = '-';
        infoQuota.textContent = '-';
        infoQueue.textContent = '-';

        submitButton.disabled = false;

        if (!departmentId) {
            return;
        }

        const selectedDepartment = this.options[
            this.selectedIndex
        ];

        infoDepartment.textContent = selectedDepartment.textContent.trim();

        doctorOptions.forEach(function (option) {

            if (option.dataset.department === departmentId) {

                doctorSelect.appendChild(
                    option.cloneNode(true)
                );
            }
        });

        doctorSelect.disabled = false;

        updateQueue();
    });

    // ==========================================
    // PILIH DOKTER
    // ==========================================

    doctorSelect.addEventListener('change', function () {

        const doctorId = this.value;

        scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';
        scheduleSelect.disabled = true;

        infoDoctor.textContent = '-';
        infoSchedule.textContent = '-';
        infoQuota.textContent = '-';

        submitButton.disabled = false;

        if (!doctorId) {
            return;
        }

        const selectedDoctor = this.options[
            this.selectedIndex
        ];

        infoDoctor.textContent = selectedDoctor.textContent.trim();

        scheduleOptions.forEach(function (option) {

            if (option.dataset.doctor === doctorId) {

                scheduleSelect.appendChild(
                    option.cloneNode(true)
                );
            }
        });

        scheduleSelect.disabled = false;
    });

    // ==========================================
    // PILIH JADWAL
    // ==========================================

    scheduleSelect.addEventListener('change', function () {

        const selectedOption = this.options[
            this.selectedIndex
        ];

        if (!this.value) {

            infoSchedule.textContent = '-';
            infoQuota.textContent = '-';

            submitButton.disabled = false;

            return;
        }

        const day = selectedOption.dataset.day;
        const start = selectedOption.dataset.start.substring(0, 5);
        const end = selectedOption.dataset.end.substring(0, 5);

        infoSchedule.textContent = day + ' - ' + start + ' - ' + end;

        updateQuota();
    });

    tanggalInput.addEventListener('change', function () {

        updateQuota();
        updateQueue();

    });

});
</script>

@endsection