<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>

    {{-- Font Awesome --}}
    <link
        href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet"
        type="text/css">

    {{-- Font Nunito --}}
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900"
        rel="stylesheet">

    {{-- CSS SB Admin 2 --}}
    <link
        href="{{ asset('css/sb-admin-2.min.css') }}"
        rel="stylesheet">

    <style>

        body {
            background: #f4f6fb;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .sipklin-login-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(31, 78, 121, 0.12);
        }

        .logo-icon {
            color: #06285c;
            font-size: 34px;
        }

        .logo-name {
            color: #06285c;
            font-size: 28px;
            font-weight: 800;
        }

        .logo-subtitle {
            color: #536b7d;
            font-size: 13px;
            line-height: 1.4;
        }

        .login-title {
            color: #06285c;
            font-weight: 700;
            font-size: 18px;
        }

        .btn-sipklin {
            background: #06285c;
            border-color: #06285c;
            color: white;
        }

        .btn-sipklin:hover {
            background: #06285c;
            border-color: #06285c;
            color: white;
        }

    </style>

</head>

<body>

    @yield('content')

    {{-- jQuery --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    {{-- Bootstrap --}}
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- jQuery Easing --}}
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    {{-- SB Admin 2 --}}
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>