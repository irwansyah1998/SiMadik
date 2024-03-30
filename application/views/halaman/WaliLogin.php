<!DOCTYPE html>
<?php foreach ($SISTEM as $row) {
  $NamaSistem = $row->NamaSistem;
  $NamaInstansi = $row->NamaInstansi;
  $Alamat = $row->Alamat;
  $Keterangan = $row->Keterangan;
  $Logo = $row->Logo;
} ?>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('')?>" data-template="vertical-menu-template">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="SiMadik (Sistem Manajemen Pendidikan) adalah platform digital yang mengelola proses administrasi dan manajemen di lembaga pendidikan. Sistem ini membantu dalam manajemen data siswa, guru, kurikulum, dan kegiatan sekolah.">
  <meta name="keywords" content="SiMadik, Sistem Manajemen Pendidikan, pendidikan, administrasi, manajemen, sekolah">
  <meta name="author" content="PT. Bening Jaya Sentosa">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wali Murid | <?= $NamaInstansi ?></title>
  <meta name="robots" content="index, follow"> <!-- Memperbolehkan mesin pencari untuk mengindex dan mengikuti tautan -->
  <meta name="og:title" content="SiMadik - Sistem Manajemen Pendidikan"> <!-- Judul yang ditampilkan saat dibagikan di media sosial -->
  <meta name="og:description" content="Platform SiMadik membantu dalam manajemen data siswa, guru, kurikulum, dan kegiatan sekolah."> <!-- Deskripsi yang ditampilkan saat dibagikan di media sosial -->
  <meta name="og:image" content="<?php echo base_url('assets/gambar/simadik.jpeg');?>">
  <!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
  <!-- Google Font: Source Sans Pro -->
  

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master');?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master');?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master');?>/dist/css/adminlte.min.css">
  <style>
        body {
            background-image: url('<?= base_url('assets/gambar/bg.webp')?>'); /* Ganti 'lokasi_gambar_anda.jpg' dengan lokasi dan nama file gambar Anda */
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Ini akan membuat gambar tetap dalam posisi saat halaman di-scroll */
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Ubah angka transparansi (0.5) sesuai keinginan (0 untuk bening, 1 untuk gelap sepenuhnya) */
        }
        .card {
          position: relative;
          background-color: rgba(255, 255, 255, 0.55); /* Nilai transparansi 0-1 */
          transition: backdrop-filter 0.7s ease-in-out;
          backdrop-filter: blur(5px); /* Efek blur */
        }

        .card:hover {
          backdrop-filter: blur(15px); /* Efek blur saat hover */
        }
    </style>
</head>
<body class="hold-transition login-page">
  <div class="overlay"></div>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <h2><b>Sistem</b> Wali Murid</h2>
    </div>
    <div class="card-body">
      <?php if (isset($msg)) { ?>
        <p class="login-box-msg">Silahkan cek kembali Username dan Password!</p>
      <?php }else{ ?>
        <p class="login-box-msg">Masukkan Username dan Password!</p>
      <?php } ?>

      <form action="<?php echo base_url();?>User_login/waliAksi" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="usrnm" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="pswrd" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <p class="mb-1">
        <a href="<?php echo base_url('User_login');?>">Anda seorang guru?</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url('assets/template/AdminLTE-master');?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/template/AdminLTE-master');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/template/AdminLTE-master');?>/dist/js/adminlte.min.js"></script>
</body>
</html>
