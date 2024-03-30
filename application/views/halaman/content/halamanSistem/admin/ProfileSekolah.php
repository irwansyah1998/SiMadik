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
        url: '<?php echo base_url("whatsapp/TesKoneksi"); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          keyId: keyId
        },
        success: function(response) {
          // Hentikan animasi putar saat berhasil atau gagal

          if (response.status) {
            jumlahPercobaan = 0;
            setTimeout(jalankanSetiap5Menit, 3 * 60 * 1000);
            toastr.success(response.message);
            $("#icon_spinner").removeClass("fa-spin");
            $("#test_koneksi").prop("disabled", false);
          } else {
            jumlahPercobaan++;
            if (jumlahPercobaan >= 5) {
              $("#icon_spinner").removeClass("fa-spin");
              toastr.error('WhatsApp Bermasalah, Silahkan cek kembali.');
              $("#test_koneksi").prop("disabled", false);
            } else {
              setTimeout(jalankanSetiap5Menit, 3500);
              toastr.info('Menghubungkan ke WhatsApp...');
              $("#icon_spinner").addClass("fa-spin");
            }
          }
        },
        error: function() {
          // Hentikan animasi putar saat terjadi kesalahan

          jumlahPercobaan++;
          if (jumlahPercobaan >= 5) {
            toastr.error('WhatsApp Bermasalah, Silahkan cek kembali.');
            $("#icon_spinner").removeClass("fa-spin");
            $("#test_koneksi").prop("disabled", false);
          } else {
            setTimeout(jalankanSetiap5Menit, 3500);
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


<?php
if ($ProfileSekolah !== false) {
  foreach ($ProfileSekolah as $PS) {
    $id = $PS->id;
    $NamaSistem = $PS->NamaSistem;
    $NamaInstansi = $PS->NamaInstansi;
    $Logo = $PS->Logo;
    $visi = $PS->visi;
    $misi = $PS->misi;
    $Alamat = $PS->Alamat;
    $Keterangan = $PS->Keterangan;
    $NamaKepala = $PS->NamaKepala;
    $Foto = $PS->Foto;
    $NIPKepala = $PS->NIPKepala;
  }
}

function formatNomorTelepon($nomor_telepon)
{
  // Hapus karakter awal '62' jika ada
  if (substr($nomor_telepon, 0, 2) === '62') {
    $nomor_telepon = substr($nomor_telepon, 2);
  }

  // Ubah format nomor telepon
  $nomor_telepon = preg_replace('/^(\d{4})(\d{4})(\d{4})$/', '$1-$2-$3', $nomor_telepon);

  // Tambahkan awalan '0' kembali
  $nomor_telepon = '0' . $nomor_telepon;

  return $nomor_telepon;
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
            <h1 class="m-0">Informasi Sekolah</h1>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Informasi Akun</li>
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
          <div class="col-lg-3 col-6 animate__animated animate__slideInLeft">
            <!-- small box -->
            <div class="small-box shadow" style="transform: perspective(5000px); backdrop-filter: blur(5px); background-color: rgba(200, 0, 0, 0.25);">
              <div class="inner">
                <h3><?= $Jumlah_Staff ?></h3>

                <p>Total Pegawai</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6 animate__animated animate__fadeInDown">
            <!-- small box -->
            <div class="small-box shadow" style="transform: perspective(5000px); backdrop-filter: blur(5px); background-color: rgba(0, 255, 0, 0.25);">
              <div class="inner">
                <h3><?= $Jumlah_Guru ?></h3>

                <p>Total Guru</p>
              </div>
              <div class="icon">
                <i class="fa fa-graduation-cap"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6 animate__animated animate__fadeInUp">
            <!-- small box -->
            <div class="small-box shadow" style="transform: perspective(5000px); backdrop-filter: blur(5px); background-color: rgba(0, 0, 255, 0.25);">
              <div class="inner">
                <h3><?= $Jumlah_Murid ?></h3>

                <p>Total Siswa</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6 animate__animated animate__slideInRight">
            <!-- small box -->
            <div class="small-box shadow" style="transform: perspective(5000px); backdrop-filter: blur(5px); background-color: rgba(200, 255, 0, 0.25);">
              <div class="inner">
                <h3><?= $Jumlah_Kelas ?></h3>

                <p>Total Kelas</p>
              </div>
              <div class="icon">
                <i class="fas fa-store-alt"></i>
              </div>
            </div>
          </div>



        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-4">
            <?= form_open_multipart(base_url('User_admin/ProfileSekolahCRUD'), array('method' => 'post')); ?>
            <!-- Profile Image -->
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="Input" value="File">
            <div class="card card-primary shadow animate__animated animate__fadeInLeft" style="transform: perspective(5000px);">
              <div class="card-header">
                <h3 class="card-title">Logo Sekolah</h3>
              </div>
              <div class="card-body box-profile">
                <img src="<?php echo base_url('file/data/gambar/' . $Logo); ?>" class="img-fluid mb-2 shadow" alt="white sample" style="max-width: 100%;" />
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <div class="custom-file shadow">
                            <input required type="file" class="form-control custom-file-inputfoto" name="UploadLogo" accept=".jpg, .jpeg">
                            <label class="custom-file-label" for="exampleInputFile">Logo (.jpg)</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <button type="submit" class="btn btn-block btn-warning shadow">
                            <i class="fas fa-sync-alt"></i> Ganti
                          </button>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
                <!-- /.card-body -->
              </div>
            </div>
            <?= form_close(); ?>
            <!-- /.card -->

            <!-- Profile Image -->
            <?= form_open(base_url('User_admin/ProfileSekolahCRUD'), array('method' => 'post')); ?>
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="Input" value="WhatsApp">
            <div class="card card-warning shadow animate__animated animate__fadeInUp" style="transform: perspective(5000px);">
              <div class="card-header">
                <h3 class="card-title">Nomor WhatsApp</h3>
              </div>
              <div class="card-body box-profile">
                <p>Jika nomor WhatsApp tidak muncul,anda juga dapat menambah nomor WhatsApp <a href="https://whatsapp.<?= str_replace('https://', '', base_url()) ?>app/login" class="btn btn-warning">di sini <i class="fab fa-whatsapp fa-lg"></i></a></p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Nomor WhatsApp:</label>
                          <select required class="form-control select2 shadow" name="NomorWA" style="width: 100%;">
                            <?php if ($NomorWA !== false) {
                              foreach ($NomorWA as $NWA) { ?>
                                <option value="<?= $NWA->whatsapp_number ?>"><?= formatNomorTelepon($NWA->whatsapp_number) ?></option>
                            <?php
                              }
                            } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <button style="width: 100%" type="submit" class="btn btn-block btn-success shadow">
                            <i class="fas fa-sync-alt"></i> Ganti
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <button id="test_koneksi" style="width: 100%" type="button" class="btn btn-block btn-secondary shadow">
                            <i id="icon_spinner" class="fas fa-sync-alt"></i> Test Koneksi
                          </button>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
                <!-- /.card-body -->
              </div>
            </div>
            <!-- /.card -->
            <?= form_close(); ?>
          </div>


          <div class="col-md-8">
            <div class="card card-secondary shadow animate__animated animate__fadeInRight" style="transform: perspective(5000px);">
              <div class="card-header">
                <h3 class="card-title">Profile Sekolah</h3>
              </div>
              <!-- /.card-header -->
              <?= form_open_multipart(base_url('User_admin/ProfileSekolahCRUD'), array('method' => 'post')); ?>
              <input type="hidden" name="id" value="<?= $id ?>">
              <input type="hidden" name="Input" value="Data">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="NamaInstansi">Nama Sekolah / Instansi :</label>
                          <div class="input-group">
                            <input type="text" class="form-control shadow" name="NamaInstansi" placeholder="Nama Sekolah/Instansi..." title="Masukkan Keterangan Yang Benar!" required value="<?= $NamaInstansi ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="NamaKepala">Nama Kepala Sekolah :</label>
                          <div class="input-group">
                            <input type="text" class="form-control shadow" name="NamaKepala" placeholder="Nama Kepala Sekolah" title="Masukkan Keterangan Yang Benar!" required value="<?= $NamaKepala ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- 29 Januari 2024 || vita rahmada -->
                  <div class="col-sm-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Foto Tanda Tangan Kepala : </label>
                          <div class="custom-file shadow">
                            <input required type="file" class="form-control custom-file-input" name="UploadFoto" accept=".png">
                            <label class="custom-file-label" for="exampleInputFile"><?= $Foto ?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <!-- Indra Gunawan Ardiansyah || Jan 31 2024  -->
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="NamaKepala">NIP Kepala :</label>
                          <div class="input-group">
                            <input type="text" class="form-control shadow" name="NIPKepala" placeholder="NIP...." title="Masukkan Keterangan Yang Benar!" required value="<?= $NIPKepala ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="Alamat">Alamat :</label>
                          <div class="input-group">
                            <input type="text" class="form-control shadow" name="Alamat" placeholder="Alamat Sekolah/Instansi..." title="Masukkan Keterangan Yang Benar!" required value="<?= $Alamat ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="visi">Visi :</label>
                          <div class="input-group">
                            <textarea name="visi" class="form-control shadow"><?= $visi ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="misi">Misi :</label>
                          <div class="input-group">
                            <textarea name="misi" class="form-control shadow"><?= $misi ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="Keterangan">Keterangan Tambahan :</label>
                          <div class="input-group">
                            <textarea name="Keterangan" class="form-control shadow"><?= $Keterangan ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <button style="width: 100%" type="submit" class="btn btn-block btn-primary shadow">
                        <i class="fas fa-save"></i> Simpan
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <?= form_close(); ?>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <div class="bright-overlay"></div>
</div>
<!-- /.content-wrapper -->


<script>
  document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });
  document.querySelector('.custom-file-inputfoto').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>