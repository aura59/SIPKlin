<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Guestbook</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

             <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.guest.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Guest list</span></a>
            </li>

             <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.employees.index') }}">
                    <i class="fas fa-fw fa-user-check"></i>
                    <span>Employees</span></a>
            </li>

             <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.admins.index') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Admin</span></a>
            </li>

         

</ul>