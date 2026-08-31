<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <!-- Foto Profil -->
                @if(Auth::user()->avatar)
                    <img class="img-profile rounded-circle" src="{{ asset(Auth::user()->avatar) }}" alt="Foto Profil">
                @else
                    <img class="img-profile rounded-circle" src="{{ asset('public/img/profile/undraw_profile.svg') }}" alt="Foto Profil">
                @endif

                <!-- Nama User -->
                <span class="ml-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
            </a>


            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                @if(Auth::user()->role === 'admin')
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profil
                    </a>
                @elseif(Auth::user()->role === 'dokter')
                    <a class="dropdown-item" href="{{ route('doctor.profile') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profil
                    </a>
                @endif

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>

                <form action="{{ route('logout') }}" id="form-logout" method="POST" class="d-none">

                    @csrf

                </form>

            </div>

        </li>

    </ul>

</nav>