@extends('layouts.app')

@section('title', 'Detail Employees')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Employees</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">Detail Employees</h5>
            </div>

            <div class="card-body">

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Nip</label>
                    <input type="text" class="form-control" value="{{ $employee->nip }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Name</label>
                    <input type="text" class="form-control" value="{{ $employee->name }}" readonly>
                </div>

                 <div class="form-group mb-3">
                    <label class="font-weight-bold">Position</label>
                    <input type="text" class="form-control" value="{{ $employee->position }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Created At</label>
                    <input type="text" class="form-control" value="{{ $employee->created_at }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Updated At</label>
                    <input type="text" class="form-control" value="{{ $employee->updated_at }}" readonly>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                    <span class="fa fa-arrow-left"></span>
                    Back
                </a>

                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-primary">
                    <span class="fa fa-edit"></span>
                    Edit
                </a>
            </div>

        </div>
    </div>
</div>
@endsection