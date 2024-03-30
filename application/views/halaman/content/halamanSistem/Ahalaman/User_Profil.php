<?php
function hitungSelisihWaktu($waktu_dari_database)
{
  // Konversi teks ke objek DateTime
  $waktu_database_obj = DateTime::createFromFormat('Y-m-d H:i:s', $waktu_dari_database);

  // Periksa jika konversi berhasil
  if ($waktu_database_obj === false) {
    return "Format waktu tidak valid";
  }

  // Waktu sekarang
  $waktu_sekarang = new DateTime();

  // Hitung selisih waktu
  $selisih = $waktu_sekarang->diff($waktu_database_obj);

  $hasil = array();

  if ($selisih->d > 0) {
    $hasil['selisih_hari'] = $selisih->d . " Hari lalu";
  } elseif ($selisih->h > 23) {
    $hasil['selisih_hari'] = "1 hari";
  } elseif ($selisih->h > 0) {
    $hasil['selisih_jam'] = $selisih->h . " Jam lalu";
  } elseif ($selisih->i > 0) {
    $hasil['selisih_menit'] = $selisih->i . " Menit lalu";
  } else {
    $hasil['selisih_menit'] = "Baru saja";
  }

  return $hasil;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-with-overlay">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 animate__animated animate__slideInLeft">User Profile</h1>

          </div><!-- /.col -->
          <div class="col-sm-6 animate__animated animate__slideInRight">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Pengguna</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php
    foreach ($DataGuru as $dp) {
      $IDGuru = $dp->IDGuru;
      $NamaGuru = $dp->NamaGuru;
      $KodeGuru = $dp->KodeGuru;
      $NomorIndukGuru = $dp->NomorIndukGuru;
      $KoMa = $dp->KodeMapel;
      $UsrGuru = $dp->UsrGuru;
      $IDHak = $dp->IDHak;
      $PassGuru = $dp->PassGuru;
      $NomorHP = $dp->NomorHP;
    } ?>

    <div class="content">
      <div class="row d-flex align-items-center">
        <div class="col-sm-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              <img src="<?php echo base_url('/file/data/gambar/default/user.png'); ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
              <h5 class="my-3"><?= $NamaGuru ?></h5>
              <p class="text-muted mb-1"><?= $NomorIndukGuru ?></p>
            </div>
          </div>
        </div>

        <div class="col-sm-8">
          <div class="card mb-4">
            <div class="card-body">
              <form action="<?php echo base_url('User_halaman/UserProfile/DataUpdate'); ?>" method="POST">
                <div class="row">
                  <input type="hidden" id="IDGuru" class="form-control" name="IDGuru" value="<?= $IDGuru ?>">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nomor Induk Guru :</label>
                      <div class="input-group shadow">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                        </div>
                        <input type="number" id="NomorIndukGuru" class="form-control" name="NomorIndukGuru" value="<?= $NomorIndukGuru ?>" readonly>
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Kode Guru :</label>
                      <div class="input-group shadow">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-book"></i></span>
                        </div>
                        <input type="text" id="KodeGuru" class="form-control" name="KodeGuru" value="<?= $KodeGuru ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nama Guru :</label>
                      <div class="input-group shadow">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                        </div>
                        <input type="text" id="NamaGuru" class="form-control" name="NamaGuru" value="<?= $NamaGuru ?>" readonly>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Username Guru :</label>
                      <div class="input-group shadow">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                        </div>
                        <input type="text" id="UsrGuru" minlength="6" class="form-control" name="UsrGuru" value="<?= $UsrGuru ?>" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nomor HP (WhatsApp):</label>
                      <div class="input-group shadow">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fab fa-whatsapp fa-lg"></i></span>
                        </div>
                        <input name="NomorHP" id="NomorHP" value="<?= $NomorHP ?>" type="text" class="form-control" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Password Guru :</label>
                      <div class="input-group shadow">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <div id="showPassword" href="#"><i id="eyeIcon" class="fa fa-eye"></i></div>
                          </span>
                        </div>
                        <input type="password" id="PassGuru" minlength="6" class="form-control" name="PassGuru" name="Password" value="<?= $PassGuru ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-3 d-flex justify-content-center">
                  <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-primary" onclick="enableEdit()">Edit</button>
                  </div>
                  <div class="col-sm-6">
                    <button type="Submit" id="simpanButton" class="btn btn-primary" disabled>Simpan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
  <div class="bright-overlay"></div>
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    document.getElementById('showPassword').addEventListener('click', togglePassword);

    function togglePassword() {
      var passwordInput = document.getElementById('PassGuru');
      var eyeIcon = document.getElementById('eyeIcon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }
  });

  function enableEdit() {
    document.getElementById('NomorIndukGuru').readOnly = false;
    document.getElementById('KodeGuru').readOnly = false;
    document.getElementById('NamaGuru').readOnly = false;
    document.getElementById('UsrGuru').readOnly = false;
    document.getElementById('NomorHP').readOnly = false;
    document.getElementById('PassGuru').readOnly = false;

    document.getElementById('simpanButton').disabled = false;
  }
</script>