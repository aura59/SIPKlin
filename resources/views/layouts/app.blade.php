<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        #accordionSidebar {
            position: fixed !important;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        #content-wrapper {
            margin-left: 224px;
        }

        :root {
            --sipklin-blue: #06285c;
            --sipklin-blue-light: #EAF1FB;
        }

        /* Sidebar */
        .sipklin-sidebar {
            background-color: var(--sipklin-blue) !important;
            background-image: none !important;
        }

        /* Warna teks */
        .text-sipklin {
            color: var(--sipklin-blue) !important;
        }

        /* Border card */
        .border-left-sipklin {
            border-left: 4px solid var(--sipklin-blue) !important;
        }

        /* Badge */
        .badge-sipklin {
            background-color: var(--sipklin-blue);
            color: white;
        }

        /* Hover dashboard */
        .dashboard-card {
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
            cursor: pointer;
        }

    </style>

    @stack('styles')

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @if(Auth::user()->role === 'admin')

            @include('layouts.inc.sidebar')

        @elseif(Auth::user()->role === 'dokter')

            @include('layouts.inc.sidebar-doctor')

        @endif
        <!-- End of Sidebar -->


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.inc.navbar')
                <!-- End of Topbar -->


                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


            <!-- Footer -->
            @include('layouts.inc.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('script')

</body>

</html>