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

    <!-- Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Data Master -->
    <div class="sidebar-heading">Data Klinik</div>

    <!-- Data Pasien -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pasien</span>
        </a>
    </li>

    <!-- Data Dokter -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user-md"></i>
            <span>Data Dokter</span>
        </a>
    </li>

    <!-- Data Poli -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-hospital"></i>
            <span>Data Poli</span>
        </a>
    </li>

    <!-- Jadwal Dokter -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal Dokter</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Pelayanan -->
    <div class="sidebar-heading">Pelayanan</div>

    <!-- Pendaftaran -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Pendaftaran</span>
        </a>
    </li>

    <!-- Antrean -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-list-ol"></i>
            <span>Antrean</span>
        </a>
    </li>

    <!-- Rekam Medis -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-notes-medical"></i>
            <span>Rekam Medis</span>
        </a>
    </li>

    <!-- Riwayat Kunjungan -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Kunjungan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Profil -->
    <li class="nav-item">

        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Profil</span>
        </a>
    </li>

</ul>