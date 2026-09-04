@extends('layouts.app')

@section('title', 'Create New - Department Page')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Poli Baru</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Poli / Create</h1>

<div class="row">

    <!-- kiri -->
    <div class="col-md-7">
        <div class="card">

            <form action="{{ route('departments.store') }}" method="POST">
                @csrf

                <div class="card-header">
                    <h5 class="card-title mb-0">Input Data Poli Baru</h5>
                </div>

                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nama Poli</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                        @error('description')
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

                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                        <span class="fa fa-times-circle"></span>
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>


    <!-- kanan -->
    <div class="col-md-5">
        <div class="card info-poli-card h-100">

            <div class="card-body text-center d-flex flex-column justify-content-center">
                <div class="info-icon mb-4">
                    <i class="fas fa-fw fa-hospital"></i>
                </div>

                <h3 class="info-title">Data Poli Baru </h3>

                <p class="text-muted px-4">Lengkapi informasi poli dengan data yang benar dan sesuai.</p>

                <hr class="mx-2">

                <div class="info-list text-left px-4 mt-3">

                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pastikan nama poli sesuai</span>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pastikan menulis deskripsi sesuai dengan data yang benar</span>
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
        box-shadow: 0 0 0 0.2rem rgba(6, 40, 92, 0.15) !important;
    }

    /* Card kanan */
    .info-poli-card {
        border-top: 4px solid #06285c;
        min-height: 100%;
    }

    /* Icon */
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

    /* Judul */
    .info-title {
        color: #06285c;
        font-weight: 700;
    }

    /* List */
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
        flex-shrink: 0;
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