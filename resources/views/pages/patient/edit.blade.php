@extends('layouts.app')

@section('title', 'Update Patient Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Update Data Pasien</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Pasien / Update</h1>

<div class="row">

    <div class="col-md-7">
        <div class="card">
            <form action="{{ route('patients.update', $patients->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <h5 class="card-title mb-0">Update Data</h5>
                </div>

                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="nik" class="form-label">Nik</label>
                        <input type="text" name="nik" id="nik" value="{{ old('nik', $patients->nik) }}" class="form-control @error('nik') is-invalid @enderror">

                        @error('nik')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $patients->nama) }}" class="form-control @error('nama') is-invalid @enderror">

                        @error('nama')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $patients->tanggal_lahir) }}"  class="form-control @error('tanggal_lahir') is-invalid @enderror">

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
                            <option value="laki-laki" {{ old('jenis_kelamin', $patients->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('jenis_kelamin', $patients->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>

                        @error('jenis_kelamin')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                     <div class="form-group mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $patients->alamat) }}" class="form-control @error('alamat') is-invalid @enderror">

                        @error('alamat')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                     <div class="form-group mb-3">
                        <label for="no_telepon" class="form-label">No. Telp</label>
                        <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $patients->no_telepon) }}" class="form-control @error('no_telepon') is-invalid @enderror">

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

                    <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                        <span class="fa fa-times-circle"></span>
                        Cancel
                    </a>
                </div>

            </form>
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

</style>
@endpush

@endsection