<ul class="navbar-nav sidebar sidebar-dark accordion sipklin-sidebar"
    id="accordionSidebar">

    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('doctor.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-heartbeat"></i>
        </div>

        <div class="sidebar-brand-text mx-3">SIPKlin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('doctor.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('doctorschedules.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('doctorschedules.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal Dokter</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-list-ol"></i>
            <span>Antrean</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-notes-medical"></i>
            <span>Rekam Medis</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Kunjungan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('doctor.profile') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('doctor.profile') }}">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Profil</span>
        </a>
    </li>

</ul>