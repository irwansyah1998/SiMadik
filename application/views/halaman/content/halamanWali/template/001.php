<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="SiMadik (Sistem Manajemen Pendidikan) adalah platform digital yang mengelola proses administrasi dan manajemen di lembaga pendidikan. Sistem ini membantu dalam manajemen data siswa, guru, kurikulum, dan kegiatan sekolah.">
  <meta name="keywords" content="SiMadik, Sistem Manajemen Pendidikan, pendidikan, administrasi, manajemen, sekolah">
  <meta name="author" content="PT. Bening Jaya Sentosa">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Wali Murid</title>
  <meta name="robots" content="index, follow"> <!-- Memperbolehkan mesin pencari untuk mengindex dan mengikuti tautan -->
  <meta name="og:title" content="SiMadik - Sistem Manajemen Pendidikan"> <!-- Judul yang ditampilkan saat dibagikan di media sosial -->
  <meta name="og:description" content="Platform SiMadik membantu dalam manajemen data siswa, guru, kurikulum, dan kegiatan sekolah."> <!-- Deskripsi yang ditampilkan saat dibagikan di media sosial -->
  <meta name="og:image" content="<?php echo base_url('assets/gambar/simadik.jpeg');?>">
  <!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  

  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/toastr/toastr.min.css">

  



  <?php if ($ButuhTabel==TRUE){ ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php } ?>



  <?php if ($ButuhForm==TRUE){ ?>
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/dropzone/min/dropzone.min.css">
  <?php } ?>
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/summernote/summernote-bs4.min.css">
  
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master/');?>dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo base_url('assets/template/addon/');?>animate.min.css">
  <script src="<?php echo base_url('assets/template/');?>jquery-3.6.0.min.js"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo base_url('assets/template/addon/');?>jquery.timepicker.min.js"></script>

  



  <style>
    body {
        background-color: #525252;
    }

    .main-sidebar {
        background-color: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(5px);
    }

    .nav-sidebar .nav-header {
        color: #fffe00;
        font-size: 16px;
    }

    .nav-sidebar .nav-item > a.nav-link {
        color: #ffffff;
    }

    .kelas-checkbox {
        transform: scale(1.5);
        margin-right: 10px;
    }

    #mobile-navbar {
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(10px);
    }

    .navbar-nav.mr-auto .nav-link {
        color: white; /* Ubah warna teks menjadi putih */
    }

    .navbar-nav.mx-auto .nav-link {
        color: white; /* Ubah warna teks menjadi putih */
    }
    .navbar-nav.ml-auto .nav-link {
        color: white; /* Ubah warna teks menjadi putih */
    }

    /* Mengubah latar belakang content-wrapper */
    .content-wrapper {
        position: relative;
        background-image: url('<?= base_url('assets/gambar/bg.webp')?>');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        overflow: hidden;
    }

    /* Menambahkan overlay berwarna cerah */
    .bright-overlay {
        position: absolute;
        backdrop-filter: blur(1px);
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(200, 200, 200, 0.7); /* Ubah kecerahan sesuai preferensi */
        z-index: 1;
    }

    /* Konten yang ingin diberikan overlay */
    .content-with-overlay {
        position: relative;
        z-index: 2;
        padding: 20px;
    }

    .small-box:hover {
          backdrop-filter: blur(15px); /* Efek blur saat hover */
    }

    /* Main Footer */
    .main-footer {
        z-index: 2;
    }

    .light-effect {
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.5) 10%, transparent 70%);
      opacity: 0;
      animation: lightAnimation 4s infinite;
      transition: opacity 0.3s ease-in-out;
    }

    @keyframes lightAnimation {
      0%, 100% {
        opacity: 0;
        transform: scale(0.5);
      }
      50% {
        opacity: 1;
        transform: scale(1);
      }
    }

</style>

<style>
  .content-header {
    background-color: rgba(255, 255, 255, 0.5); /* Warna putih dengan tingkat transparansi */
    padding: 10px; /* Tambahkan padding untuk membuat jarak dari tepi ke konten di dalamnya */
    margin: 2px; /* Tambahkan margin untuk membuat jarak dari tepi elemen lain */
    border-radius: 25px; /* Atur nilai border-radius untuk membuat sudut elemen lebih melengkung */
    backdrop-filter: blur(8px); /* Tambahkan efek blur dengan backdrop-filter */
  }

  .content-header h1 {
    color: black; /* Warna teks */
    margin: 0; /* Menghapus margin default pada elemen h1 */
  }

  .background-effect {
    background-color: rgba(255, 255, 255, 0.5); /* Warna putih dengan tingkat transparansi */
    padding: 20px; /* Tambahkan padding untuk membuat jarak dari tepi ke konten di dalamnya */
    margin: 2px; /* Tambahkan margin untuk membuat jarak dari tepi elemen lain */
    border-radius: 25px; /* Atur nilai border-radius untuk membuat sudut elemen lebih melengkung */
    backdrop-filter: blur(8px); /* Tambahkan efek blur dengan backdrop-filter */
  }

  /* Ganti properti yang perlu diberi efek transparan jika diperlukan */
</style>





  <style>
    @keyframes fadeInFromLeft {
      0% {
        opacity: 0;
        transform: translateX(-20px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Animasi untuk setiap nav-item-animation */
    .nav-item.nav-item-animation {
      animation: fadeInFromLeft 1.5s ease forwards;
    }
  </style>

</head>

