@extends('layouts.app')

@section('title', 'Create New - Employees Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create New - Employees Page</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <form action="{{ route('admin.employees.store') }}" method="POST">
                @csrf

                <div class="card-header">
                    <h5 class="card-title mb-0">Create New Employee</h5>
                </div>

                <div class="card-body">

                    <div class="form-group mb-3">
                        <label for="nip" class="form-label">Nip</label>

                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="form-control @error('nip') is-invalid @enderror">

                        @error('nip')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>

                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="position" class="form-label">Position</label>

                        <input type="text" name="position" id="position" value="{{ old('position') }}" class="form-control @error('position') is-invalid @enderror">

                        @error('position')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <span class="fa fa-save"></span>
                        Save
                    </button>

                    <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                        <span class="fa fa-times-circle"></span>
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection