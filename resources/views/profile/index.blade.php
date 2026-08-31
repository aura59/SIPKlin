@extends('layouts.app')

@section('title', 'Profil - SIPKlin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Profil</h1>
        <h1 class="h6 mb-0 text-gray-800">Kelola Informasi Akun Anda</h1>
    </div>
</div>


<div class="card shadow mb-4 profile-card">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-sipklin">Informasi Profil</h6>
    </div>


    <div class="card-body p-4">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="row">

                <div class="col-md-4 mb-4">
                    <div class="text-center">

                        <div class="profile-photo">
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" id="preview-avatar" alt="Foto Profil">
                            @else
                                <img src="{{ asset('public/img/profile/undraw_profile.svg') }}" id="preview-avatar" alt="Foto Profil">
                            @endif
                        </div>

                        <input type="file" name="avatar" id="avatar" accept="image/*" class="d-none" onchange="previewFoto(event)">

                        <button type="button" class="btn btn-sipklin mt-3 px-4" onclick="document.getElementById('avatar').click()">
                            <i class="fas fa-camera mr-1"></i>
                            Ubah Foto
                        </button>

                        @error('avatar')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                </div>


                <div class="col-md-8">
                    <div class="form-group">

                        <label for="name" class="form-label text-sipklin font-weight-bold">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label text-sipklin font-weight-bold">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label text-sipklin font-weight-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label text-sipklin font-weight-bold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>


                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-sipklin px-4"><i class="fas fa-save mr-1"></i>Simpan Perubahan</button>
                    </div>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection

@push('styles')

<style>


    .btn-sipklin {
        background-color: #06285c;
        border-color: #06285c;
        color: white;
    }

    .btn-sipklin:hover {
        background-color: #06285c;
        border-color: #06285c;
        color: white;
    }

    .text-sipklin {
        color: #06285c !important;
    }


    .profile-card {
        border: 1px solid #ddd;
    }


    .profile-photo {
        width: 220px;
        height: 220px;

        margin: auto;

        border: 2px solid #06285c;
        border-radius: 50%;

        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #f8f9fc;
    }

    .profile-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-control:focus {
        border-color: #06285c;
        box-shadow: 0 0 0 0.2rem rgba(36, 89, 166, 0.15);
    }

</style>

@endpush

@push('script')

<script>

function previewFoto(event) {

    const input = event.target;
    const preview = document.getElementById('preview-avatar');

    if (input.files && input.files[0]) {

        preview.src = URL.createObjectURL(input.files[0]);

    }

}

</script>

@if(session('success'))

<script>

Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});

</script>

@endif

@endpush