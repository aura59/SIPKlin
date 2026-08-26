@extends('layouts.app')

@section('title', 'Detail Guest')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Detail Guest</h5>
    </div>

    <div class="card-body">

        <div class="form-group mb-3">
            <label class="font-weight-bold">Name</label>
            <input type="text" class="form-control" value="{{ $guest->name }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label class="font-weight-bold">Telephone</label>
            <input type="text" class="form-control" value="{{ $guest->telephone }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label class="font-weight-bold">Email</label>
            <input type="email" class="form-control" value="{{ $guest->email }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label class="font-weight-bold">Address</label>
            <textarea class="form-control" rows="3" readonly>{{ $guest->address }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label class="font-weight-bold">Agency Of Origin</label>
            <input type="text" class="form-control" value="{{ $guest->agency_of_origin }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label class="font-weight-bold">Purpose</label>
            <textarea class="form-control" rows="3" readonly>{{ $guest->purpose }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label class="font-weight-bold">Created At</label>
            <input type="text" class="form-control" value="{{ $guest->created_at }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label class="font-weight-bold">Updated At</label>
            <input type="text" class="form-control" value="{{ $guest->updated_at }}" readonly>
        </div>

    </div>

    <div class="card-footer">
        <a href="{{ route('admin.guest.index') }}" class="btn btn-secondary">
            <span class="fa fa-arrow-left"></span>
            Back
        </a>
    </div>
</div>

@endsection