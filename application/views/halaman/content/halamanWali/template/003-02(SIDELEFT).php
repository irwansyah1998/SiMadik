

  <!-- Navbar melayang di bawah (awalnya tidak disembunyikan) -->
<nav class="navbar fixed-bottom d-md-none shadow animate__animated animate__fadeInUp" id="mobile-navbar">
    <div class="container-fluid">
        <ul class="navbar-nav mr-auto"> <!-- Menu-menu di samping kiri -->
            <li class="nav-item">
                <a class="nav-link text-center" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars d-block"></i>
                  Menu
                </a>
            </li>
        </ul>
        <ul class="navbar-nav mr-auto"> <!-- Menu-menu di samping kiri -->
            <li class="nav-item">
                <a class="nav-link text-center" href="<?= base_url('Wali_Halaman/NilaiSiswa') ?>"><i class="fas fa-book d-block"></i>
                  Penilaian
                </a>
            </li>
        </ul>
        <ul class="navbar-nav mx-auto"> <!-- Menu "Home" di tengah -->
            <li class="nav-item">
                <a class="nav-link text-center" href="<?= base_url('Wali_Halaman') ?>">
                  <i class="fa fa-home fa-2x d-block"></i>
                Home
              </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto"> <!-- Menu-menu di samping kanan -->
            <li class="nav-item">
                <a class="nav-link text-center" href="#"><i class="fas fa-calendar-alt d-block"></i>
                  Jadwal
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto"> <!-- Menu-menu di samping kanan -->
            <li class="nav-item">
                <a class="nav-link text-center" id="toggleControlSidebar" href="#" role="button" data-widget="control-sidebar"><i class="fas fa-user-cog d-block"></i>
                  Akun
                </a>
            </li>
        </ul>
    </div>
</nav>