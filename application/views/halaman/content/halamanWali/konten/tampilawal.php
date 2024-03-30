<script>
  $(document).ready(function() {
    // Variabel untuk melacak jumlah percobaan
    var jumlahPercobaan = 0;
    var keyId = "<?= $this->encryption->encrypt($this->session->userdata('UsrGuru')) ?>";

    // Fungsi untuk kirim perintah TesKoneksi
    function kirimPerintahTesKoneksi() {
      // Ganti ikon ke ikon putar
      $("#icon_spinner").addClass("fa-spin");
      $("#test_koneksi").prop("disabled", true);

      $.ajax({
        url: '<?php echo base_url("whatsapp/SpamKeNomor"); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          keyId: keyId
        },
        success: function(response) {
          // Hentikan animasi putar saat berhasil atau gagal

          if (response.status) {
            jumlahPercobaan = 0;
            setTimeout(jalankanSetiap5Menit, 1000);
            toastr.success(response.message);
            $("#icon_spinner").removeClass("fa-spin");
            $("#test_koneksi").prop("disabled", false);
          } else {
            jumlahPercobaan++;
            if (jumlahPercobaan >= 100) {
              $("#icon_spinner").removeClass("fa-spin");
              toastr.error('WhatsApp Bermasalah, Silahkan cek kembali.');
              $("#test_koneksi").prop("disabled", false);
            } else {
              setTimeout(jalankanSetiap5Menit, 1000);
              toastr.info('Menghubungkan ke WhatsApp...');
              $("#icon_spinner").addClass("fa-spin");
            }
          }
        },
        error: function() {
          // Hentikan animasi putar saat terjadi kesalahan

          jumlahPercobaan++;
          if (jumlahPercobaan >= 100) {
            toastr.error('WhatsApp Bermasalah, Silahkan cek kembali.');
            $("#icon_spinner").removeClass("fa-spin");
            $("#test_koneksi").prop("disabled", false);
          } else {
            setTimeout(jalankanSetiap5Menit, 1000);
            toastr.info('Menghubungkan ke WhatsApp...');
            $("#icon_spinner").addClass("fa-spin");
          }
        }
      });
    }

    // Fungsi untuk menjalankan kirimPerintahTesKoneksi setiap 5 menit
    function jalankanSetiap5Menit() {
      kirimPerintahTesKoneksi();
      setInterval(kirimPerintahTesKoneksi, 5 * 60 * 1000);
    }

    // Panggil fungsi saat tombol diklik
    $("#test_koneksi").click(function() {
      // Panggil fungsi kirimPerintahTesKoneksi saat tombol diklik
      kirimPerintahTesKoneksi();
    });
  });
</script>




<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Informasi Akun</h1>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

        </div>
        <!-- /.row -->
       
        <div class="row">
          <div class="col-md-4">
            <div class="background-effect">
              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="<?php echo base_url('file/data/gambar/default/user.png'); ?>"
                         alt="User profile picture">
                  </div>

                  <h3 class="profile-username text-center"><?= $this->session->userdata('NamaOrtu') ?></h3>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Wali Kelas :</b> <a class="float-right"><?= $this->session->userdata('NamaWaliKelas') ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Nama Siswa :</b> <a class="float-right"><?= $this->session->userdata('NamaSiswa') ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>NIS :</b> <a class="float-right"><?= $this->session->userdata('NisSiswa') ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Kelas :</b> <a class="float-right"><?= $this->session->userdata('KodeKelas') ?></a>
                    <!-- /.input group -->
                    </li>
                    <li class="list-group-item">
                      <b>Tahun Ajaran :</b> <a class="float-right">
                        <?php if ($TahunAjaran != false) {
                          foreach ($TahunAjaran as $TA) { ?>
                            <?= $TA->KodeAjaran ?>
                        <?php }
                        }
                        ?></a>
                    <!-- /.input group -->
                    </li>

                  </ul>

                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>

            <!-- About Me Box -->
            
            <!-- /.card -->
          </div>
          <div class="col-md-8">
            <div class="background-effect">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Daftar Kehadiran Siswa Selama 7 Hari Terakhir :</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <button hidden id="test_koneksi" style="width: 100%" type="button" class="btn btn-block btn-secondary shadow">
                            <i id="icon_spinner" class="fas fa-sync-alt"></i> Test Koneksi
                          </button>
                  <table id="example8" class="table table-bordered table-striped">
                        <thead align="center">
                          <tr>
                            <th>Nama Siswa</th>
                            <?php
                            $a=0;
                            if (isset($RekapAbsen7) && $RekapAbsen7 !== false) {
                              foreach ($RekapAbsen7 as $RAT) {
                              $tanggal_absen[$a] = $RAT->absen_TglAbsensi;
                            ?>
                              <th><?= $RAT->absen_TglAbsensi ?></th>
                            <?php
                              $a++;
                              }
                            }
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($tabel != false) {
                            $no = 0;
                            foreach ($tabel as $tb) {
                              $no++;
                          ?>
                              <tr>
                                <td><strong><?= $tb->NamaSiswa; ?></strong></td>
                                <?php
                                $b=0;
                                if (isset($RekapAbsen7) && $RekapAbsen7 !== false) {
                                  foreach ($RekapAbsen7 as $RAT) {
                                    if ($b==$a) {
                                      $b=0;
                                    }
                                    if ($tb->NisSiswa == $RAT->absen_NisSiswa) {
                                      $Pesan = '';
                                      $button = '';

                                      if ($RAT->absen_MISA == "M") {
                                        $Pesan = '<i class="fas fa-check-square fa-lg"></i>';
                                        $button = 'success';
                                        if ($tanggal_absen[$b] == $RAT->absen_TglAbsensi){ ?>
                                          <td align="center">
                                              <p type="button" class="btn btn-<?= $button ?>"><?= $Pesan ?></p>
                                          </td>
                                        <?php }else{
                                          for ($i=$b; $i < $a; $i++) { 
                                            if($tanggal_absen[$i] == $RAT->absen_TglAbsensi){
                                              $Pesan = '<i class="fas fa-check-square fa-lg"></i>';
                                              $button = 'success';
                                            ?>
                                            <td align="center">
                                              <p type="button" class="btn btn-<?= $button ?>"><?= $Pesan ?></p>
                                            </td>
                                            <?php
                                            }else{
                                              ?>
                                              <td align="center"><p type="button" class="btn btn-light">(Kosong)</p></td>
                                              <?php
                                            }
                                          }
                                        }
                                      }elseif ($RAT->absen_MISA == "I") {
                                        $Pesan = 'Ijin';
                                        $button = 'info';
                                        if ($tanggal_absen[$b] == $RAT->absen_TglAbsensi){ ?>
                                          <td align="center">
                                              <p type="button" class="btn btn-<?= $button ?>"><?= $Pesan ?></p>
                                          </td>
                                        <?php }else{
                                          for ($i=$b; $i < $a; $i++) { 
                                            if($tanggal_absen[$i] == $RAT->absen_TglAbsensi){
                                              $Pesan = 'Ijin';
                                              $button = 'info';
                                            ?>
                                            <td align="center">
                                              <p type="button" class="btn btn-<?= $button ?>"><?= $Pesan ?></p>
                                            </td>
                                            <?php
                                            }else{
                                              ?>
                                              <td align="center"><p type="button" class="btn btn-light">(Kosong)</p></td>
                                              <?php
                                            }
                                          }
                                        }
                                      }elseif ($RAT->absen_MISA == "S") {
                                        $Pesan = 'Sakit';
                                        $button = 'warning';
                                        if ($tanggal_absen[$b] == $RAT->absen_TglAbsensi){ ?>
                                          <td align="center">
                                              <p type="button" class="btn btn-<?= $button ?>"><?= $Pesan ?></p>
                                          </td>
                                        <?php }else{
                                          for ($i=$b; $i < $a; $i++) { 
                                            if($tanggal_absen[$i] == $RAT->absen_TglAbsensi){
                                              $Pesan = 'Sakit';
                                              $button = 'warning';
                                            ?>
                                            <td align="center">
                                              <p type="button" class="btn btn-<?= $button ?>"><?= $Pesan ?></p>
                                            </td>
                                            <?php
                                            }else{
                                              ?>
                                              <td align="center"><p type="button" class="btn btn-light">(Kosong)</p></td>
                                              <?php
                                            }
                                          }
                                        }
                                      }elseif ($RAT->absen_MISA == "A") {
                                        $Pesan = '<i class="fas fa-question fa-lg"></i>';
                                        $button = 'danger';
                                        if ($tanggal_absen[$b] == $RAT->absen_TglAbsensi){ ?>
                                          <td align="center">
                                              <p type="button" class="btn btn-<?= $button ?>"><?= $Pesan ?></p>
                                          </td>
                                        <?php }else{
                                          for ($i=$b; $i < $a; $i++) { 
                                            if($tanggal_absen[$i] == $RAT->absen_TglAbsensi){
                                              $Pesan = 'Alpha';
                                              $button = 'danger';
                                            ?>
                                            <td align="center">
                                              <p type="button" class="btn btn-<?= $button ?>"><?= $Pesan ?></p>
                                            </td>
                                            <?php
                                            }else{
                                              ?>
                                              <td align="center"><p type="button" class="btn btn-light">(Kosong)</p></td>
                                              <?php
                                            }
                                          }
                                        }
                                      }
                                ?>
                                    
                                <?php
                                    }
                                    $b++;
                                  }
                                }
                                ?>
                              </tr>
                          <?php
                            }
                          }
                          ?>
                        </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->