@extends('layouts.auth')

@section('title', 'Login - SIPKlin')

@section('content')

<div class="login-wrapper">

<div class="card sipklin-login-card">

    <div class="card-body p-5">
       
        <div class="text-center mb-4">
            <div class="d-flex justify-content-center align-items-center">
                <i class="fas fa-heartbeat logo-icon mr-2"></i>
                <span class="logo-name">SIPKlin</span>
            </div>

            <h1 class="h6 text-gray-900 mb-4">Sistem Informasi Pendaftaran Klinik</h1>
        </div>

         <hr>

        <div class="login-title mb-4">Login ke Akun Anda</div>

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="Masukkan email" required autofocus>

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Masukkan password" required>

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        
            <div class="form-group">
                <label for="role">Pilih Peran</label>
                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value=""></option>

                    <option value="admin"
                        {{ old('role') == 'admin' ? 'selected' : '' }}>
                        Administrator
                    </option>

                    <option value="dokter"
                        {{ old('role') == 'dokter' ? 'selected' : '' }}>
                        Dokter
                    </option>
                </select>

                @error('role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

  
            <button type="submit" class="btn btn-sipklin btn-user btn-block">Login</button>
        </form>

        <hr>

       
        <p class="text-center text-muted small mb-2">Masuk Sebagai</p>

        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-outline-primary btn-block" onclick="pilihRole('admin')">
                    <i class="fas fa-user-shield mr-1"></i>
                    Admin
                </button>
            </div>

           
            <div class="col-6">
                <button type="button" class="btn btn-outline-primary btn-block" onclick="pilihRole('dokter')">
                    <i class="fas fa-user-md mr-1"></i>
                    Dokter
                </button>
            </div>
        </div>

    </div>

</div>

</div>

<script>

    function pilihRole(role) {
        document.getElementById('role').value = role;
    }

</script>

@endsection
