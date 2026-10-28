<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifikasi Jadwal Kontrol -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle"
            href="#"
            id="notificationDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            title="Jadwal Kontrol">

                <i class="fas fa-bell fa-fw"></i>

                @if(isset($jumlahJadwalKontrol) && $jumlahJadwalKontrol > 0)
                    <span class="badge badge-danger badge-counter">
                        {{ $jumlahJadwalKontrol > 99 ? '99+' : $jumlahJadwalKontrol }}
                    </span>
                @endif
            </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="notificationDropdown"
                style="width: 350px; max-width: 90vw;">

                <h6 class="dropdown-header"
                    style="background-color: #06285c; border-color: #06285c;">
                    Jadwal Kontrol Pasien
                </h6>

                @forelse($jadwalKontrolNotifikasi as $item)
                    <a class="dropdown-item d-flex align-items-start"
                    href="{{ route('control-schedules.index') }}"
                    style="white-space: normal; padding: 12px 16px;">

                        <div class="mr-3">
                            <div class="icon-circle"
                                style="background-color: #EAF1FB; color: #06285c;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>

                        <div>
                            <div class="small text-gray-500">
                                {{ \Carbon\Carbon::parse($item->tanggal_kontrol)->format('d-m-Y') }}
                            </div>

                            <span class="font-weight-bold text-gray-800">
                                {{ $item->registration->patient->nama ?? 'Nama pasien tidak tersedia' }}
                            </span>

                            <div class="small text-gray-600">
                                {{ $item->catatan_kontrol ?: 'Pasien dijadwalkan untuk kontrol.' }}
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center p-3">
                        <i class="fas fa-calendar-check text-gray-400 mb-2"
                        style="font-size: 24px;"></i>

                        <p class="small text-gray-600 mb-0">
                            Belum ada jadwal kontrol mendatang.
                        </p>
                    </div>
                @endforelse

                <a class="dropdown-item text-center small text-gray-600"
                href="{{ route('control-schedules.index') }}">
                    Lihat Semua Jadwal Kontrol
                </a>
            </div>
        </li>

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