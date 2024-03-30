 <?php foreach ($SISTEM as $row) {
  $NamaSistem = $row->NamaSistem;
  $NamaInstansi = $row->NamaInstansi;
  $Alamat = $row->Alamat;
  $Keterangan = $row->Keterangan;
  $Logo = $row->Logo;
}?>
  <script type="text/javascript">
      // Contoh menggunakan jQuery
    $(document).ready(function() {
      $(".nav-item").addClass("nav-item-animation");
    });
    </script>
 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url('User_halaman'); ?>" class="brand-link">
    <img src="<?php echo base_url('file/data/gambar/'.$Logo); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SiMadik</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url('file/data/gambar/default/user.png'); ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?=$this->session->userdata('NamaOrtu')?></a>
      </div>
    </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="<?= base_url('Wali_Halaman') ?>" class="nav-link <?php if ($aktif=='Dashboard'){echo 'active';}?>">
              <i class="nav-icon fa fa-id-card fa-lg"></i>
              <p>
                Informasi Dasar
              </p>
            </a>
          </li>
          <li class="nav-header">Murid</li>
            <li class="nav-item">
              <a href="<?= base_url('Wali_Halaman') ?>/NilaiSiswa" class="nav-link <?php if ($aktif=='NilaiSiswa'){echo 'active';}?>">
             <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Nilai Sekolah Siswa
              </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('Wali_Halaman') ?>/Pelanggaran" class="nav-link <?php if ($aktif=='Pelanggaran'){echo 'active';}?>">
             <i class="nav-icon fas fa-exclamation-triangle"></i>
              <p>
                Pelanggaran
              </p>
              </a>
            </li>
          <li class="nav-header">Pembayaran</li>
            <li class="nav-item">
              <a href="<?= base_url('Wali_Halaman') ?>/RiwayatBayar" class="nav-link <?php if ($aktif=='RiwayatBayar'){echo 'active';}?>">
                <i class="nav-icon fas fa-money-check-alt"></i>
                <p>
                  Riwayat Pembayaran
                </p>
              </a>
            </li>
          <li class="nav-header">Pengaturan</li>
            <li class="nav-item">
              <a href="<?php echo base_url('User_login/aksi_logout');?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Keluar
              </p>
              </a>
            </li>
          </li>
        </ul>
      </nav>
    </div>
  </aside>


  