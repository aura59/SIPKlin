@extends('layouts.app')

@section('title', 'Detail Patient')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pasien</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">Detail Pasien</h5>
            </div>

            <div class="card-body">

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Nik</label>
                    <input type="text" class="form-control" value="{{ $patients->nik }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Nama</label>
                    <input type="nama" class="form-control" value="{{ $patients->nama }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Tanggal Lahir</label>
                    <input type="date" class="form-control" value="{{ $patients->tanggal_lahir }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Jenis Kelamin</label>
                    <input type="jenis_kelamin" class="form-control" value="{{ $patients->jenis_kelamin }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Alamat</label>
                    <input type="alamat" class="form-control" value="{{ $patients->alamat }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">No. Telp</label>
                    <input type="text" class="form-control" value="{{ $patients->no_telepon }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Created At</label>
                    <input type="text" class="form-control" value="{{ $patients->created_at }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Updated At</label>
                    <input type="text" class="form-control" value="{{ $patients->updated_at }}" readonly>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                    <span class="fa fa-arrow-left"></span>
                    Back
                </a>

                <a href="{{ route('patients.edit', $patients->id) }}" class="btn btn-primary">
                    <span class="fa fa-edit"></span>
                    Edit
                </a>
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
</style>
@endpush

@endsection