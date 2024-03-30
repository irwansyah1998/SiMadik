<!DOCTYPE html>
<?php foreach ($SISTEM as $row) {
  $NamaSistem = $row->NamaSistem;
  $NamaInstansi = $row->NamaInstansi;
  $Alamat = $row->Alamat;
  $Keterangan = $row->Keterangan;
  $Logo = $row->Logo;
} ?>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="description"
    content="SiMadik (Sistem Manajemen Pendidikan) adalah platform digital yang mengelola proses administrasi dan manajemen di lembaga pendidikan. Sistem ini membantu dalam manajemen data siswa, guru, kurikulum, dan kegiatan sekolah di <?= $NamaInstansi ?>.">
  <meta name="keywords" content="SiMadik, Sistem Manajemen Pendidikan, pendidikan, administrasi, manajemen, sekolah">
  <meta name="author" content="PT. Bening Jaya Sentosa">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SiMadik |
    <?= $NamaInstansi ?>
  </title>
  <meta name="robots" content="index, follow">
  <!-- Memperbolehkan mesin pencari untuk mengindex dan mengikuti tautan -->
  <meta name="og:title" content="SiMadik - Sistem Manajemen Pendidikan">
  <!-- Judul yang ditampilkan saat dibagikan di media sosial -->
  <meta name="og:description"
    content="Platform SiMadik membantu dalam manajemen data siswa, guru, kurikulum, dan kegiatan sekolah.">
  <!-- Deskripsi yang ditampilkan saat dibagikan di media sosial -->
  <meta name="og:image" content="<?php echo base_url('assets/gambar/simadik.jpeg'); ?>">
  <!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
  <!-- Google Font: Source Sans Pro -->

  <!-- Google Font: Source Sans Pro -->
  <script type="application/ld+json">
  {
     "@context": "<?php echo base_url(); ?>",
     "@type": "Organization",
     "name": "<?= $NamaInstansi ?>",
     "url": "<?= base_url() ?>",
     "logo": "<?= base_url('assets/gambar/simadik.jpeg') ?>"
  }
</script>
  <link rel="icon" type="image/jpeg" href="<?php echo base_url('assets/gambar/simadik.jpeg'); ?>">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet"
    href="<?php echo base_url('assets/template/AdminLTE-master'); ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet"
    href="<?php echo base_url('assets/template/AdminLTE-master'); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/AdminLTE-master'); ?>/dist/css/adminlte.min.css">
  <style>
    body {
      background-image: url('<?= base_url('assets/gambar/bg.webp') ?>');
      /* Ganti 'lokasi_gambar_anda.jpg' dengan lokasi dan nama file gambar Anda */
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      /* Ini akan membuat gambar tetap dalam posisi saat halaman di-scroll */
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      /* Ubah angka transparansi (0.5) sesuai keinginan (0 untuk bening, 1 untuk gelap sepenuhnya) */
    }

    .card {
      position: relative;
      background-color: rgba(255, 255, 255, 0.55);
      /* Nilai transparansi 0-1 */
      transition: backdrop-filter 0.7s ease-in-out;
      backdrop-filter: blur(5px);
      /* Efek blur */
    }

    .card:hover {
      backdrop-filter: blur(15px);
      /* Efek blur saat hover */
    }
  </style>
</head>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const inputElement = document.getElementById('noSpecialCharsInput');

    inputElement.addEventListener('input', function () {
      const inputValue = inputElement.value;
      const newValue = inputValue.replace(/[\W_]+/g, ''); // Menghapus semua spasi dan karakter khusus

      if (inputValue !== newValue) {
        inputElement.value = newValue;
      }
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const inputElement = document.getElementById('onlyNumbersInput');

    inputElement.addEventListener('input', function () {
      const inputValue = inputElement.value;
      const newValue = inputValue.replace(/[^0-9]/g, ''); // Menghapus semua selain angka

      if (inputValue !== newValue) {
        inputElement.value = newValue;
      }
    });
  });
</script>

<body class="hold-transition login-page">
  <div class="overlay"></div> <!-- Elemen overlay untuk efek gelap -->
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h2><b>Sistem</b> Sekolah</h2>
      </div>
      <div class="card-body">
        <?php if (isset ($msg)) { ?>
          <p class="login-box-msg">Silahkan cek kembali Username dan Password!</p>
        <?php } else { ?>
          <p class="login-box-msg">Masukkan Username dan Password!</p>
        <?php } ?>

        <form action="<?php echo base_url(); ?>User_login/aksi_login" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="noSpecialCharsInput" name="usrnm" placeholder="Username"
              required>
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
          <a href="<?php echo base_url('User_login/Wali'); ?>">Anda Orang Tua Murid?</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo base_url('assets/template/AdminLTE-master'); ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script
    src="<?php echo base_url('assets/template/AdminLTE-master'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url('assets/template/AdminLTE-master'); ?>/dist/js/adminlte.min.js"></script>

  <script>
    // Fungsi untuk menghitung jarak antara dua titik koordinat menggunakan formula Haversine
    function calculateDistance(lat1, lon1, lat2, lon2) {
      var R = 6371; // Radius bumi dalam kilometer
      var dLat = (lat2 - lat1) * Math.PI / 180;
      var dLon = (lon2 - lon1) * Math.PI / 180;
      var a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var distance = R * c; // Jarak dalam kilometer
      return distance;
    }

    // Titik awal
    var startLat = -7.564802;
    var startLon = 112.331738;

    // Fungsi untuk mendapatkan lokasi saat ini dan menghitung jarak dari titik awal
    function getLocationAndCalculateDistance() {
      // Meminta izin untuk mengakses lokasi
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
          // Mendapatkan koordinat dari posisi saat ini
          var currentLat = position.coords.latitude;
          var currentLon = position.coords.longitude;

          // Menghitung jarak dari titik awal
          var distance = calculateDistance(startLat, startLon, currentLat, currentLon);
          console.log("Jarak dari titik awal: " + distance.toFixed(2) + " km");
        });
      } else {
        console.log("Geolocation is not supported by this browser.");
      }
    }

    // Mendapatkan lokasi saat ini dan menghitung jarak dari titik awal
    getLocationAndCalculateDistance();

    // Memperbarui lokasi dan jarak setiap 5 detik
    setInterval(getLocationAndCalculateDistance, 5000);

  </script>


</body>

</html>
