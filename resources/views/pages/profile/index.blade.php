@extends('layouts.app')

@section('title', 'Profile Page - Guestbook')

@section('content')
<div class="d-sm-flex align-items-center justify-content-beetwen mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile page</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-body">
            <h5 class="card-title">User Profile</h5>

            <form action="{{ route('admin.profile.save') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">

                    @error('name')
                    <div class="text-danger">
                       {{ $message }}
                    </div>
                    @enderror
                </div>

                 <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">

                    @error('email')
                    <div class="text-danger">
                       {{ $message }}
                    </div>
                    @enderror
                </div>

                 <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">

                    @error('password')
                    <div class="text-danger">
                       {{ $message }}
                    </div>
                    @enderror
                </div>

                 <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">

                    @error('password_confirmation')
                    <div class="text-danger">
                       {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.26.25/sweetalert2.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.26.25/sweetalert2.all.min.js"></script>

@if(Session::has('success'))
<script>
Swal.fire({
    title: "Berhasil!",
    text: "{{ Session::get('success') }}",
    icon: "success",
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@endsection