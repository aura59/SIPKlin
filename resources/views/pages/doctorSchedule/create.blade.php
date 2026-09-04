@extends('layouts.app')

@section('title', 'Create New - Doctor Schedule Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jadwal Dokter Baru</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Jadwal Dokter / Create</h1>

<div class="row">

    <!-- kiri -->
    <div class="col-md-7">
        <div class="card">
            <form action="{{ route('doctorschedules.store') }}" method="POST">
                @csrf

                <div class="card-header">
                    <h5 class="card-title mb-0">Input Data Jadwal Dokter Baru</h5>
                </div>

                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="doctor_id" class="form-label">Akun Dokter</label>

                        <select name="doctor_id" id="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror">
                            <option value="">Pilih Dokter</option>

                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}"
                                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->nama }}
                                </option>
                            @endforeach
                        </select>

                        @error('doctor_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="poli" class="form-label">Poli</label>
                        <input type="text" id="poli" class="form-control" placeholder="Poli akan muncul otomatis" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="hari" class="form-label">Hari</label>
                        <select name="hari" id="hari" class="form-control @error('hari') is-invalid @enderror">

                            <option value="">Pilih Hari</option>
                            <option value="Senin"{{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                            <option value="Selasa"{{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                            <option value="Rabu"{{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                            <option value="Kamis"{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                            <option value="Jumat"{{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            <option value="Sabtu"{{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                            <option value="Minggu"{{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>

                        </select>

                        @error('hari')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="form-group mb-3">
                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" class="form-control @error('jam_mulai') is-invalid @enderror" step="60">

                        @error('jam_mulai')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="jam_selesai" class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai"  id="jam_selesai" value="{{ old('jam_selesai') }}" class="form-control @error('jam_selesai') is-invalid @enderror" step="60">

                        @error('jam_selesai')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="kuota" class="form-label">Kuota</label>
                        <input type="number" name="kuota" id="kuota" value="{{ old('kuota') }}" class="form-control @error('kuota') is-invalid @enderror">

                        @error('kuota')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-sipklin">
                        <span class="fa fa-save"></span>
                        Save
                    </button>

                    <a href="{{ route('doctorschedules.index') }}" class="btn btn-secondary">
                        <span class="fa fa-times-circle"></span>
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>


    <!-- kanan -->
    <div class="col-md-5">
        <div class="card info-pasien-card h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center">
                <div class="info-icon mb-4">
                    <i class="fas fa-calendar-alt"></i>
                </div>

                <h3 class="info-title">Data Jadwal Dokter Baru</h3>

                <p class="text-muted px-4">Lengkapi informasi jadwal dokter dengan data yang benar dan sesuai.</p>

                <hr class="mx-2">

                <div class="info-list text-left px-5 mt-3">
                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pilih dokter yang akan dibuatkan jadwal</span>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Poli akan mengikuti poli dokter secara otomatis</span>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pastikan jam praktik sesuai</span>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Masukkan kuota pasien sesuai jadwal</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    label {
        color: #06285c !important;
        font-weight: 600;
    }

    .form-control {
        color: #06285c !important;
    }

    .form-control:focus {
        border-color: #06285c !important;
        box-shadow: 0 0 0 0.2rem rgba(60, 40, 92, 0.15) !important;
    }

    .info-pasien-card {
        border-top: 4px solid #06285c;
        min-height: 100%;
    }

    .info-icon {
        width: 90px;
        height: 90px;
        margin: 0 auto;

        display: flex;
        align-items: center;
        justify-content: center;

        background-color: #EAF1FB;
        border-radius: 50%;

        color: #06285c;
        font-size: 38px;
    }

    .info-title {
        color: #06285c;
        font-weight: 700;
    }

    .info-list {
        max-width: 500px;
        margin: auto;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 18px;

        color: #555;
        font-size: 15px;
    }

    .info-item i {
        color: #28a745;
        font-size: 18px;
        margin-right: 12px;
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

</style>
@endpush

@endsection