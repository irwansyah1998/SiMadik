<?php
if ($ProfileSekolah!==false) {
  foreach ($ProfileSekolah as $PS) {
    $id = $PS->id;
    $NamaSistem = $PS->NamaSistem;
    $NamaInstansi = $PS->NamaInstansi;
    $Logo = $PS->Logo;
    $visi = $PS->visi;
    $misi = $PS->misi;
    $Alamat = $PS->Alamat;
    $Keterangan = $PS->Keterangan;
  }
}

function formatNomorTelepon($nomor_telepon) {
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
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><?= $Jumlah_Staff ?></h3>

                <p>Total Pegawai</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
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
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
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
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
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
            <form class="col-md-12" action="<?php echo base_url('User_kepsek');?>/ProfileSekolahCRUD" method="POST" enctype="multipart/form-data">
              <!-- Profile Image -->
              <input type="hidden" name="id" value="<?= $id ?>">
              <input type="hidden" name="Input" value="File">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Logo Sekolah</h3>
                </div>
                <div class="card-body box-profile">
                    <img src="<?php echo base_url('file/data/gambar/'.$Logo); ?>" class="img-fluid mb-2" alt="white sample" style="max-width: 100%;" />
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <div class="custom-file">
                              <input required type="file" class="form-control custom-file-input" name="UploadLogo" accept=".jpg, .jpeg">
                              <label class="custom-file-label" for="exampleInputFile">Logo (.jpg)</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                              <button type="submit" class="btn btn-block btn-warning">
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
            </form>
            <!-- /.card -->

              <!-- Profile Image -->
              <form class="col-md-12" action="" method="POST">
              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title">Nomor WhatsApp</h3>
                </div>
                <div class="card-body box-profile">
                    <p>Jika nomor WhatsApp tidak muncul,anda juga dapat menambah nomor WhatsApp <a href="https://whatsapp.simadikbeningtechno.my.id/app/login" class="btn btn-warning">di sini <i class="fab fa-whatsapp fa-lg"></i></a></p>
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-group">
                              <label>Nomor WhatsApp:</label>
                              <select required class="form-control select2" name="NomorWA" style="width: 100%;" >
                                <?php if ($NomorWA!==false) {
                                  foreach ($NomorWA as $NWA) { ?>
                                <option value="<?= $NWA->whatsapp_number ?>"><?=formatNomorTelepon($NWA->whatsapp_number)?></option>
                                <?php
                                  }
                                } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <button style="width: 100%" type="submit" class="btn btn-block btn-success">
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
            <!-- /.card -->
              </form>
          </div>


          <div class="col-md-8">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Profile Sekolah</h3>
              </div>
              <!-- /.card-header -->
              <form class="col-md-12" action="<?php echo base_url('User_kepsek');?>/ProfileSekolahCRUD" method="POST">
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
                            <input  type="text" class="form-control" name="NamaInstansi" placeholder="Nama Sekolah/Instansi..." title="Masukkan Keterangan Yang Benar!" required value="<?= $NamaInstansi ?>">
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
                            <input type="text" class="form-control" name="Alamat" placeholder="Alamat Sekolah/Instansi..." title="Masukkan Keterangan Yang Benar!" required value="<?= $Alamat ?>">
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
                            <textarea name="visi" class="form-control"><?= $visi ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="misi">Misi :</label>
                          <div class="input-group">
                            <textarea name="misi" class="form-control"><?= $misi ?></textarea>
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
                            <textarea name="Keterangan" class="form-control"><?= $Keterangan ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <button style="width: 100%" type="submit" class="btn btn-block btn-primary">
                                <i class="fas fa-save"></i> Simpan
                              </button>
                            </div>
                        </div>
                      </div>
                </div>
              <!-- /.card-body -->
              </form>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<script>
  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>