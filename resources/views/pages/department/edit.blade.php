@extends('layouts.app')

@section('title', 'Update Department Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Update Data Poli</h1>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Poli / Update</h1>

<div class="row">

    <div class="col-md-7">
        <div class="card">
            <form action="{{ route('departments.update', $department->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <h5 class="card-title mb-0">Update Data</h5>
                </div>

                <div class="card-body">
                   <div class="form-group mb-3">
                        <label for="nama_department" class="form-label">Nama Poli</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}" class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control @error('description', $department->description) is-invalid @enderror">{{ old('description', $department->description) }}</textarea>

                        @error('deskripsi')
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