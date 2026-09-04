<ul class="navbar-nav sidebar sidebar-dark accordion sipklin-sidebar" id="accordionSidebar">

    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-heartbeat"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIPKlin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <hr class="sidebar-divider">

    <div class="sidebar-heading">Data Klinik</div>

   <li class="nav-item {{ request()->routeIs('patients.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('patients.index') }}">
            <i class="fas fa-user-injured"></i>
            <span>Data Pasien</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('doctors.index') }}">
            <i class="fas fa-fw fa-user-md"></i>
            <span>Data Dokter</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('departments.index') }}">
            <i class="fas fa-fw fa-hospital"></i>
            <span>Data Poli</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('doctorschedules.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('doctorschedules.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal Dokter</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">Pelayanan</div>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Pendaftaran</span>
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

   <li class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.profile') }}">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Profil</span>
        </a>
    </li>

</ul>