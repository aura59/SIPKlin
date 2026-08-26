@extends('layouts.app')

@section('title', 'Detail Admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Admin</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">Detail Admin</h5>
            </div>

            <div class="card-body">

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Name</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Created At</label>
                    <input type="text" class="form-control" value="{{ $user->created_at }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Updated At</label>
                    <input type="text" class="form-control" value="{{ $user->updated_at }}" readonly>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                    <span class="fa fa-arrow-left"></span>
                    Back
                </a>

                <a href="{{ route('admin.admins.edit', $user->id) }}" class="btn btn-primary">
                    <span class="fa fa-edit"></span>
                    Edit
                </a>
            </div>

        </div>
    </div>
</div>
@endsection