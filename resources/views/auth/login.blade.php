@extends('layouts.auth')

@section('title', 'Login - SIPKlin')

@section('content')

<style>
    :root {
        --sipklin-navy: #06285c;
        --sipklin-blue: #164985;
        --sipklin-yellow: #f7c948;
        --sipklin-light: #edf4fd;
        --sipklin-text: #243b5a;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: #f0f5fc;
    }

    /* Layout utama */
    .sipklin-page {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 0.9fr;
        overflow: hidden;
        background:
            radial-gradient(circle at 48% 10%, #ffffff 0, transparent 30%),
            linear-gradient(135deg, #eaf3ff, #f8fbff);
        position: relative;
    }

    /* Panel kiri */
    .sipklin-intro {
        position: relative;
        min-height: 100vh;
        padding: 65px 7% 55px 10%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: hidden;
        background:
            radial-gradient(ellipse at 5% 85%, #d3e7ff 0, transparent 38%),
            linear-gradient(145deg, #f8fbff 0%, #e5efff 100%);
    }

    .intro-decoration {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 12px;
        background: linear-gradient(
            90deg,
            var(--sipklin-navy) 0%,
            var(--sipklin-blue) 72%,
            var(--sipklin-yellow) 72%,
            var(--sipklin-yellow) 100%
        );
    }

    .intro-content {
        position: relative;
        z-index: 2;
        max-width: 980px;
        margin: auto;
        width: 100%;
    }

    .intro-logo {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 12px;
    }

    .intro-logo-icon {
        font-size: 58px;
        color: var(--sipklin-navy);
        line-height: 1;
    }

    .intro-logo-name {
        font-size: clamp(36px, 4vw, 52px);
        font-weight: 900;
        letter-spacing: -2px;
        color: var(--sipklin-navy);
        line-height: 1.1;
    }

    .intro-subtitle {
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.02em;
        color: var(--sipklin-blue);
        margin: 0;
    }

    .intro-accent {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--sipklin-blue);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.12em;
        margin: 0 0 12px;
    }

    .intro-accent::before {
        content: "";
        width: 22px;
        height: 3px;
        border-radius: 10px;
        background: var(--sipklin-yellow);
    }

    .intro-heading {
        font-size: clamp(27px, 3vw, 39px);
        font-weight: 800;
        line-height: 1.2;
        color: var(--sipklin-navy);
        margin: 0 0 14px;
    }

    .intro-description {
        color: #536b8a;
        font-size: 15px;
        line-height: 1.7;
        max-width: 440px;
        margin: 0;
    }

    .intro-overview {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(245px, 0.92fr);
        align-items: center;
        gap: 22px;
        margin-top: 24px;
    }

    .clinic-illustration {
        display: block;
        width: 100%;
        max-width: 390px;
        height: auto;
        justify-self: end;
        filter: drop-shadow(0 18px 26px rgba(6, 40, 92, 0.08));
    }

    /* Fitur aplikasi */
    .intro-features {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-top: 24px;
    }

    .intro-feature {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        min-height: 76px;
        padding: 14px 12px;
        border: 1px solid rgba(22, 73, 133, 0.1);
        border-radius: 13px;
        background: rgba(255, 255, 255, 0.76);
        box-shadow: 0 6px 18px rgba(6, 40, 92, 0.035);
    }

    .intro-feature-icon {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 11px;
        background: #e8f1fc;
        color: var(--sipklin-blue);
        font-size: 15px;
    }

    .intro-feature h6 {
        color: var(--sipklin-navy);
        font-size: 12px;
        font-weight: 800;
        line-height: 1.4;
        margin: 1px 0 0;
    }

    .intro-feature p {
        color: #627794;
        font-size: 11px;
        line-height: 1.45;
        margin: 0;
    }

    .intro-footer {
        position: relative;
        z-index: 2;
        color: #7589a4;
        font-size: 12px;
        margin-top: 24px;
    }

    @media (max-width: 1200px) {
        .intro-overview {
            grid-template-columns: minmax(0, 1fr) minmax(205px, 0.8fr);
            gap: 10px;
        }

        .intro-features {
            gap: 8px;
        }

        .intro-feature {
            padding: 12px 9px;
            gap: 8px;
        }

        .intro-feature-icon {
            width: 32px;
            height: 32px;
        }
    }

    /* Panel kanan */
    .sipklin-login-area {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 45px 7%;
    }

    /* Kotak login */
    .sipklin-login-card {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 430px;
        margin: auto;
        background: #ffffff;
        border: 1px solid #e1e8f2;
        border-radius: 16px;
        box-shadow: 0 12px 35px rgba(6, 40, 92, 0.12);
        overflow: hidden;
    }

    /* Ruang bagian dalam kotak */
    .sipklin-login-card .card-body {
        position: relative;
        z-index: 1;
        padding: 38px 36px;
    }

    /* Identitas SIPKlin */
    .login-brand {
        text-align: center;
    }

    .login-brand-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 7px;
    }

    .login-brand-logo i {
        color: #06285c;
        font-size: 30px;
    }

    .login-brand-name {
        color: #06285c;
        font-size: 28px;
        font-weight: 800;
    }

    .login-brand-subtitle {
        color: #718096;
        font-size: 13px;
        margin-bottom: 0;
    }

    .login-divider {
        margin: 22px 0;
        border-top: 1px solid #e5eaf2;
    }

    .login-title {
        color: #06285c;
        font-size: 18px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 24px;
    }

    /* Form login */
    .sipklin-login-card label {
        color: #536b8a;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .sipklin-login-card .form-control {
        height: 43px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
    }

    .sipklin-login-card .form-control:focus {
        border-color: #7899e8;
        box-shadow: 0 0 0 0.15rem rgba(6, 40, 92, 0.10);
    }

    /* Tombol masuk */
    .btn-sipklin-login {
        width: 100%;
        min-height: 43px;
        color: #ffffff !important;
        background-color: #06285c !important;
        border: 1px solid #06285c !important;
        border-radius: 6px;
        font-weight: 600;
        margin-top: 5px;
    }

    .btn-sipklin-login:hover {
        background-color: #041c40 !important;
        border-color: #041c40 !important;
    }

    /* Pilihan peran */
    .login-role-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #8998aa;
        font-size: 12px;
        margin: 22px 0 15px;
    }

    .login-role-divider::before,
    .login-role-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #e5eaf2;
    }

    .btn-role {
        min-height: 40px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #ffffff;
        color: #06285c;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-role i {
        margin-right: 5px;
    }

    .btn-role:hover,
    .btn-role.active {
        background: #06285c;
        border-color: #06285c;
        color: #ffffff;
    }

    /* Keterangan bawah */
    .login-help {
        color: #8998aa;
        font-size: 12px;
        line-height: 1.6;
        text-align: center;
        margin: 20px 0 0;
    }

    /* Tablet */
    @media (max-width: 1050px) {
        .sipklin-page {
            grid-template-columns: 0.9fr 1.1fr;
        }

        .sipklin-intro {
            padding: 45px 7%;
        }

        .intro-overview {
            grid-template-columns: 1fr;
            gap: 12px;
            margin-top: 22px;
        }

        .clinic-illustration {
            max-width: 310px;
            justify-self: center;
        }

        .intro-features {
            grid-template-columns: 1fr;
            gap: 9px;
            margin-top: 18px;
        }

        .intro-feature {
            align-items: center;
            min-height: 0;
            padding: 10px 12px;
        }

        .intro-feature h6 {
            font-size: 13px;
        }

        .intro-feature p {
            font-size: 12px;
        }

        .sipklin-login-area {
            padding: 35px 7%;
        }

        .sipklin-login-card .card-body {
            padding: 35px 30px;
        }
    }

    /* HP */
    @media (max-width: 768px) {
        .sipklin-page {
            display: block;
            min-height: 100vh;
            overflow: visible;
        }

        .sipklin-intro {
            min-height: auto;
            padding: 42px 25px 32px;
        }

        .intro-logo-icon {
            font-size: 43px;
        }

        .intro-logo-name {
            font-size: 37px;
        }

        .intro-heading {
            font-size: 25px;
        }

        .intro-feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            font-size: 16px;
        }

        .intro-footer {
            display: none;
        }

        .sipklin-login-area {
            min-height: auto;
            padding: 20px 18px 35px;
        }

        .sipklin-login-card {
            max-width: 500px;
            border-radius: 17px;
        }

        .sipklin-login-card .card-body {
            padding: 30px 24px;
        }

        .login-brand-name {
            font-size: 30px;
        }

        .login-title {
            font-size: 20px;
        }
    }

    @media (max-width: 380px) {
        .sipklin-login-card .card-body {
            padding: 25px 18px;
        }

        .intro-logo-name {
            font-size: 32px;
        }

        .btn-role {
            font-size: 12px;
        }
    }
</style>

<div class="sipklin-page">

    {{-- PANEL KIRI --}}
    <section class="sipklin-intro">
        <div class="intro-decoration"></div>

        <div class="intro-content">

            <div class="intro-logo">
                <i class="fas fa-heartbeat intro-logo-icon"></i>
                <span class="intro-logo-name">SIPKlin<span style="color:#f7c948">.</span></span>
            </div>

            <p class="intro-subtitle">
                Sistem Informasi Pendaftaran Klinik
            </p>

            <div class="intro-overview">
                <div class="intro-copy">
                    <div class="intro-accent">LAYANAN KLINIK TERINTEGRASI</div>

                    <h2 class="intro-heading">
                        Sistem Klinik dalam Satu Pengelolaan.
                    </h2>

                    <p class="intro-description">
                        SIPKlin membantu klinik mengelola pasien, pendaftaran kunjungan,
                        antrean, pemeriksaan, dan rekam medis dalam satu sistem yang
                        terhubung dan mudah digunakan.
                    </p>
                </div>

                <svg class="clinic-illustration" viewBox="0 0 440 330" role="img" aria-labelledby="clinic-illustration-title">
                    <title id="clinic-illustration-title">Ilustrasi petugas klinik dan pengelolaan rekam medis</title>
                    <rect x="12" y="12" width="416" height="306" rx="26" fill="#eaf3ff"/>
                    <circle cx="368" cy="72" r="37" fill="#d6e8fc"/>
                    <path d="M368 52v40M348 72h40" stroke="#164985" stroke-width="8" stroke-linecap="round"/>

                    <rect x="100" y="50" width="240" height="220" rx="14" fill="#fff" stroke="#d7e5f5" stroke-width="2"/>
                    <path d="M100 78h240" stroke="#d7e5f5" stroke-width="2"/>
                    <circle cx="119" cy="64" r="4" fill="#f7c948"/>
                    <circle cx="133" cy="64" r="4" fill="#b9d1ee"/>
                    <circle cx="147" cy="64" r="4" fill="#b9d1ee"/>

                    <rect x="125" y="103" width="190" height="104" rx="10" fill="#f3f8fe"/>
                    <path d="M143 124h55M143 138h38" stroke="#c7d9ee" stroke-width="5" stroke-linecap="round"/>
                    <rect x="270" y="112" width="29" height="29" rx="9" fill="#dceafb"/>
                    <path d="M284.5 119v15M277 126.5h15" stroke="#164985" stroke-width="3" stroke-linecap="round"/>

                    <path d="M202 162c0-15 9-25 22-25s22 10 22 25v8h-44z" fill="#263e5b"/>
                    <circle cx="224" cy="166" r="19" fill="#e9b99a"/>
                    <path d="M205 163c1-16 9-26 22-26 12 0 20 9 21 24-7-3-12-9-15-14-6 7-16 12-28 16z" fill="#263e5b"/>
                    <path d="M187 219c2-24 16-37 37-37s35 13 37 37v20h-74z" fill="#fff" stroke="#d7e5f5" stroke-width="2"/>
                    <path d="m213 188 11 13 11-13M224 201v32" fill="none" stroke="#9bb6d7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M236 203c12 5 13 19 6 25-6 5-15 1-15-6" fill="none" stroke="#164985" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="227" cy="223" r="3" fill="#f7c948"/>

                    <rect x="76" y="231" width="288" height="21" rx="8" fill="#164985"/>
                    <path d="M91 251h258l-12 44H103z" fill="#d5e5f7"/>
                    <path d="M121 271h198" stroke="#b3cbe7" stroke-width="3" stroke-linecap="round"/>
                    <path d="M138 295v8M302 295v8" stroke="#164985" stroke-width="7" stroke-linecap="round"/>

                    <rect x="24" y="155" width="89" height="77" rx="12" fill="#fff" stroke="#d8e6f5" stroke-width="2"/>
                    <rect x="38" y="169" width="25" height="25" rx="7" fill="#fff3c9"/>
                    <path d="M50.5 174v15M43 181.5h15" stroke="#164985" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M71 175h27M71 184h19M39 207h60M39 216h43" stroke="#c2d5eb" stroke-width="4" stroke-linecap="round"/>

                    <rect x="328" y="176" width="91" height="76" rx="12" fill="#fff" stroke="#d8e6f5" stroke-width="2"/>
                    <rect x="342" y="190" width="26" height="26" rx="8" fill="#e4f2ee"/>
                    <path d="M349 202h12M355 196v12" stroke="#368674" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M377 196h28M377 206h21M343 229h62M343 238h43" stroke="#c2d5eb" stroke-width="4" stroke-linecap="round"/>

                    <circle cx="70" cy="92" r="4" fill="#f7c948"/>
                    <circle cx="383" cy="285" r="5" fill="#9bbce2"/>
                    <path d="m51 270 7 7 14-16" fill="none" stroke="#368674" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="intro-features">

                <div class="intro-feature">
                    <div class="intro-feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h6>Pendaftaran dan Antrean Pasien</h6>
                        <p>Atur jadwal kunjungan dan alur antrean.</p>
                    </div>
                </div>

                <div class="intro-feature">
                    <div class="intro-feature-icon">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <div>
                        <h6>Pengelolaan Data Pasien</h6>
                        <p>Data pasien tersimpan terpusat dan rapi.</p>
                    </div>
                </div>

                <div class="intro-feature">
                    <div class="intro-feature-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div>
                        <h6>Pemeriksaan dan Rekam Medis</h6>
                        <p>Catat hasil pemeriksaan dan riwayat pasien.</p>
                    </div>
                </div>

            </div>

            <div class="intro-footer">
                &copy; {{ date('Y') }} SIPKlin · Sistem Informasi Klinik
            </div>

        </div>
    </section>


    {{-- PANEL KANAN: FORM LOGIN --}}
    <section class="sipklin-login-area">

        <div class="card sipklin-login-card">
            <div class="card-body">

                <div class="login-brand">
                    <div class="login-brand-logo">
                        <i class="fas fa-heartbeat"></i>
                        <span class="login-brand-name">SIPKlin</span>
                    </div>
                    <p class="login-brand-subtitle">
                        Sistem Informasi Pendaftaran Klinik
                    </p>
                </div>

                <hr class="login-divider">

                <div class="login-title">Login ke Akun Anda</div>

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email" autocomplete="username" required autofocus >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" autocomplete="current-password" required >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Pilih Peran</label>
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required >
                            <option value="">Pilih peran Anda</option>

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

                    <button type="submit" class="btn btn-sipklin-login btn-block">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </button>
                </form>

                <div class="login-role-divider">
                    Masuk Sebagai
                </div>

                <div class="row">
                    <div class="col-6 pr-2">
                        <button type="button" class="btn btn-role btn-block" id="btn-admin" onclick="pilihRole('admin')" >
                            <i class="fas fa-user-shield"></i>
                            Admin
                        </button>
                    </div>

                    <div class="col-6 pl-2">
                        <button type="button" class="btn btn-role btn-block" id="btn-dokter" onclick="pilihRole('dokter')" >
                            <i class="fas fa-user-md"></i>
                            Dokter
                        </button>
                    </div>
                </div>

                <p class="login-help">
                    Silakan masuk menggunakan akun yang telah terdaftar di SIPKlin.
                </p>

            </div>
        </div>

    </section>

</div>

<script>
    function pilihRole(role) {
        const roleSelect = document.getElementById('role');

        roleSelect.value = role;

        document.getElementById('btn-admin').classList.toggle(
            'active', role === 'admin'
        );

        document.getElementById('btn-dokter').classList.toggle(
            'active', role === 'dokter'
        );
    }

    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');

        if (roleSelect.value) {
            pilihRole(roleSelect.value);
        }

        roleSelect.addEventListener('change', function () {
            pilihRole(this.value);
        });
    });
</script>

@endsection
