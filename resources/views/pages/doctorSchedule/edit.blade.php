@extends('layouts.app')

@section('title', 'Update Doctors Schedule Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Update Data Jadwal Dokter</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Jadwal Dokter / Update</h1>

<div class="row">

    <div class="col-md-7">
        <div class="card">
            <form action="{{ route('doctorschedules.update', $doctorschedule->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <h5 class="card-title mb-0">Update Data</h5>
                </div>

                <div class="card-body">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="doctor_id" class="form-label">Akun Dokter</label>

                            <select name="doctor_id" id="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror">
                                <option value="">Pilih Dokter</option>

                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"
                                        {{ old('doctor_id', $doctorschedule->doctor_id) == $doctor->id ? 'selected' : '' }}>
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
                                <option value="Senin"{{ old('hari', $doctorschedule->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                <option value="Selasa"{{ old('hari',  $doctorschedule->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="Rabu"{{ old('hari',  $doctorschedule->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="Kamis"{{ old('hari',  $doctorschedule->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="Jumat"{{ old('hari',  $doctorschedule->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="Sabtu"{{ old('hari',  $doctorschedule->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                <option value="Minggu"{{ old('hari',  $doctorschedule->hari) == 'Minggu' ? 'selected' : '' }}>Minggu</option>

                            </select>

                            @error('hari')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', $doctorschedule->jam_mulai) }}" class="form-control @error('jam_mulai') is-invalid @enderror">

                            @error('jam_mulai')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai"  id="jam_selesai" value="{{ old('jam_selesai', $doctorschedule->jam_selesai) }}" class="form-control @error('jam_selesai') is-invalid @enderror">

                            @error('jam_selesai')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="kuota" class="form-label">Kuota</label>
                            <input type="number" name="kuota" id="kuota" value="{{ old('kuota', $doctorschedule->kuota) }}" class="form-control @error('kuota') is-invalid @enderror">

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