@extends('layouts.app')

@section('title', 'Create New - Patient Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pasien Baru</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Pasien / Create</h1>

<div class="row">

    <!-- kiri -->
    <div class="col-md-7">
        <div class="card">
            <form action="{{ route('patients.store') }}" method="POST">
                @csrf

                <div class="card-header">
                    <h5 class="card-title mb-0">Input Data Pasien Baru</h5>
                </div>

                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="nik" class="form-label">Nik</label>
                        <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror">

                        @error('nik')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror">

                        @error('nama')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror">

                        @error('tanggal_lahir')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">

                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>

                        </select>

                        @error('jenis_kelamin')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                     <div class="form-group mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" class="form-control @error('alamat') is-invalid @enderror">

                        @error('alamat')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                     <div class="form-group mb-3">
                        <label for="no_telepon" class="form-label">No. Telp</label>
                        <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" class="form-control @error('no_telepon') is-invalid @enderror">

                        @error('no_telepon')
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

                    <a href="{{ route('patients.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-heartbeat logo-icon mr-2"></i>
                </div>

                <h3 class="info-title">Data Pasien Baru</h3>
                <p class="text-muted px-4">Lengkapi informasi pasien dengan data yang benar dan sesuai identitas.</p>

                <hr class="mx-2">

                <div class="info-list text-left px-5 mt-3">
                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pastikan NIK sesuai identitas pasien</span>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Gunakan nomor telepon yang aktif</span>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Periksa kembali data sebelum disimpan</span>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

@push ('styles')
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