@extends('layouts.app')

@section('title', 'Create New - Doctor Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dokter Baru</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Dokter / Create</h1>

<div class="row">

    <!-- kiri -->
    <div class="col-md-7">
        <div class="card">
            <form action="{{ route('doctors.store') }}" method="POST">
                @csrf

                <div class="card-header">
                    <h5 class="card-title mb-0">Input Data Dokter Baru</h5>
                </div>

                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="user_id" class="form-label">Akun Dokter</label>

                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Pilih Akun Dokter</option>

                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>

                        @error('user_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama Dokter</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror">

                        @error('nama')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="form-group mb-3">
                        <label for="spesialis" class="form-label">Spesialis</label>
                        <input type="text" name="spesialis" id="spesialis" value="{{ old('spesialis') }}" class="form-control @error('spesialis') is-invalid @enderror">

                        @error('spesialis')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                     <div class="form-group mb-3">
                        <label for="department_id" class="form-label">Poli</label>
                        <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror">
                            <option value="">Pilih Poli</option>

                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('department_id')
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
                    <button type="submit" class="btn btn-primary">
                        <span class="fa fa-save"></span>
                        Save
                    </button>

                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-user-md logo-icon mr-2"></i>
                </div>

                <h3 class="info-title">Data Dokter Baru</h3>

                <p class="text-muted px-4">Lengkapi informasi dokter dengan data yang benar dan sesuai.</p>

                <hr class="mx-2">

                <div class="info-list text-left px-5 mt-3">
                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pilih akun yang terdaftar sebagai dokter</span>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pastikan poli dan spesialis sesuai</span>
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

</style>
@endpush

@endsection