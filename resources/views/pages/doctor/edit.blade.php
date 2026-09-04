@extends('layouts.app')

@section('title', 'Update Doctors Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Update Data Dokter</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Dokter / Update</h1>

<div class="row">

    <div class="col-md-7">
        <div class="card">
            <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <h5 class="card-title mb-0">Update Data</h5>
                </div>

                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="user_id" class="form-label">Akun Dokter</label>
                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Pilih Akun Dokter</option>

                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $doctor->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} 
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
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $doctor->nama) }}" class="form-control @error('nama') is-invalid @enderror">

                        @error('nama')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="spesialis" class="form-label">Spesialis</label>
                        <input type="text" name="spesialis" id="spesialis" value="{{ old('spesialis', $doctor->spesialis) }}" class="form-control @error('spesialis') is-invalid @enderror">

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
                                    {{ old('department_id', $doctor->department_id) == $department->id ? 'selected' : '' }}>
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
                        <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $doctor->no_telepon) }}" class="form-control @error('no_telepon') is-invalid @enderror">

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

                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                        <span class="fa fa-times-circle"></span>
                        Cancel
                    </a>
                </div>

            </form>
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