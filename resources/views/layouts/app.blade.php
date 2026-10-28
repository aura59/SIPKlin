
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
        
        /* Sidebar desktop */
        #accordionSidebar {
            position: fixed !important;
            top: 0;
            left: 0;
            height: 100vh;
            height: 100dvh;
            overflow-y: auto;
            z-index: 1050;
            transition: transform 0.25s ease;
        }

        /* Konten desktop */
        #content-wrapper {
            margin-left: 224px;
            min-width: 0;
        }

        /* Tampilan HP dan tablet kecil */
        @media (max-width: 767.98px) {

            /* Sidebar menjadi menu geser */
            #accordionSidebar {
                width: 224px !important;
                max-width: 85vw;
                transform: translateX(0);
            }

            /* Sidebar disembunyikan saat menu tertutup */
            #accordionSidebar.toggled {
                width: 224px !important;
                max-width: 85vw;
                transform: translateX(-100%);
                overflow-y: auto;
            }

            /* Konten menggunakan seluruh lebar layar */
            #content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                min-width: 0;
            }

            #wrapper {
                width: 100%;
                overflow-x: hidden;
            }

            /* Kurangi jarak di sisi layar HP */
            .container-fluid {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            /* Lapisan gelap ketika menu dibuka */
            body:not(.sidebar-toggled)::before {
                content: "";
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.35);
                z-index: 1040;
            }

            .card {
                max-width: 100%;
            }

            .table-responsive {
                max-width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
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

    <link rel="stylesheet" href="{{ asset('css/sipklin-responsive.css') }}">
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

    <!-- TAMBAHAN: Library Chart.js harus dimuat sebelum script grafik -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Script tambahan setiap halaman -->
    @stack('script')


    <script>
    (function () {
        const sidebar = document.getElementById('accordionSidebar');
        const toggle = document.getElementById('sidebarToggleTop');

        if (!sidebar) return;

        function tutupSidebarHP() {
            document.body.classList.add('sidebar-toggled');
            sidebar.classList.add('toggled');
        }

        function bukaSidebar() {
            document.body.classList.remove('sidebar-toggled');
            sidebar.classList.remove('toggled');
        }

        if (window.innerWidth < 768) {
            tutupSidebarHP();
        }

        let sebelumnyaHP = window.innerWidth < 768;

        window.addEventListener('resize', function () {
            const sekarangHP = window.innerWidth < 768;

            if (sekarangHP && !sebelumnyaHP) {
                tutupSidebarHP();
            } else if (!sekarangHP && sebelumnyaHP) {
                bukaSidebar();
            }

            sebelumnyaHP = sekarangHP;
        });

        document.addEventListener('click', function (event) {
            if (window.innerWidth >= 768) return;

            if (document.body.classList.contains('sidebar-toggled')) {
                return;
            }

            if (
                !sidebar.contains(event.target) &&
                !(toggle && toggle.contains(event.target))
            ) {
                tutupSidebarHP();
            }
        });
    })();
    </script>

</body>

</html>
