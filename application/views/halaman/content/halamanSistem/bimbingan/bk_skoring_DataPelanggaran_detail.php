<?php
// print_r($DataPelanggaran);
foreach ($DataPelanggaran as $key) {
  $IDLapor = $key->IDLapor;
  $TglLapor = $key->TglLapor;
  $NisSiswa = $key->NisSiswa;
  $IDJenis = $key->IDJenis;
  $File = $key->File;
  $Keterangan = $key->Keterangan;
  $IDGuru = $key->IDGuru;
  $StatusBK = $key->StatusBK;
  $IDSiswa = $key->IDSiswa;
  $KodeKelas = $key->KodeKelas;
  $NamaSiswa = $key->NamaSiswa;
  $GenderSiswa = $key->GenderSiswa;
  $AyahSiswa = $key->AyahSiswa;
  $IbuSiswa = $key->IbuSiswa;
  $TglLhrSiswa = $key->TglLhrSiswa;
  $TmptLhrSiswa = $key->TmptLhrSiswa;
  $NISNSiswa = $key->NISNSiswa;
  $TGLMasuk = $key->TGLMasuk;
  $TGLKeluar = $key->TGLKeluar;
  $Status = $key->Status;
  $Wali = $key->Wali;
  $IDOrtu = $key->IDOrtu;
  $UsrOrtu = $key->UsrOrtu;
  $NamaOrtu = $key->NamaOrtu;
  $NisSiswaOrtu = $key->NisSiswaOrtu;
  $Poin = $key->Poin;
  $KeteranganJenis = $key->KeteranganJenis;
  $KodeGuru = $key->KodeGuru;
  $NamaGuru = $key->NamaGuru;
  $NomorIndukGuru = $key->NomorIndukGuru;
  $KodeMapel = $key->KodeMapel;
  $IDHak = $key->IDHak;
  $NomorHP = $key->NomorHP;
  $Alamat = $key->Alamat;
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-5">

              <!-- Profile Image -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Pelanggaran</h3>
                </div>
                <div class="card-body box-profile">
                    <img src="<?= base_url(''.$File) ?>" class="img-fluid mb-2" alt="white sample" style="max-width: 100%;" />
                    <!-- <?php print_r($DataPelanggaran); ?> -->
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Tanggal :</b> <i class="float-right"><?= $TglLapor ?></i>
                    </li>
                    <li class="list-group-item">
                      <b>Nama Siswa :</b> <i class="float-right"><?= $NamaSiswa ?></i>
                    </li>
                    <li class="list-group-item">
                      <b>Jenis Pelanggaran :</b> <i class="float-right"><?= $KeteranganJenis ?></i>
                    </li>
                    <li class="list-group-item">
                      <b>Poin :</b> <i class="float-right"><?= $Poin ?></i>
                    </li>
                    <li class="list-group-item">
                      <b>Keterangan :</b> <i class="float-right"><?= $Keterangan ?></i>
                    </li>
                    <li class="list-group-item">
                      <b>Pelapor :</b> <i class="float-right"><?= $NamaGuru ?></i>
                    </li>
                  </ul>

                <?= form_open(base_url('User_bk/BKSkoringPelanggaran/Detail/'.$IDLapor), array('method' => 'post')); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <input type="hidden" name="Konfirmasi" value="True">
                              <input type="hidden" name="IDLapor" value="<?= $IDLapor ?>">
                                <button <?php if($StatusBK!=='Baru'){echo "disabled";}?> type="submit" class="btn btn-block btn-primary">
                                  <i class="fas fa-share-square"></i> Konfirmasi
                                </button>
                            </div>
                        </div>
                    </div>
                <?= form_close(); ?>

                <?= form_open(base_url('User_bk/BKSkoringPelanggaran/Detail/'.$IDLapor), array('method' => 'post')); ?>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <input type="hidden" name="Laporkan" value="True">
                            <input type="hidden" name="IDLapor" value="<?= $IDLapor ?>">
                            <input type="hidden" name="NomorHP" value="<?= $NomorHP ?>">
                              <button <?php if($StatusBK!=='Baru'){$kata=' Laporkan Ke Wali Murid';}elseif($StatusBK=='Baru'){$kata=' Konfirmasi Dan Laporkan Ke Wali Murid';}?> type="submit" class="btn btn-block btn-warning">
                                <i class="fas fa-exclamation-triangle"></i><?=$kata?>
                              </button>
                          </div>
                      </div>
                  </div>
                <?= form_close(); ?>

                  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button data-toggle="modal" data-target="#deleteModal<?= $IDLapor ?>" type="button" class="btn btn-block btn-danger">
                                  <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                  
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->


            </div>
            <!-- /.col -->
            <div class="col-md-7">
                          <!-- About Me Box -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Data Orang Tua :</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <div class="row">
                      <div class="col-md-7">
                          <div class="form-group">
                            <label><strong><i class="fas fa-user mr-1"></i> Ayah</strong></label>
                            <div class="input-group">
                              <p class="form-control" style="width: 100%;"><?= $AyahSiswa ?></p>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-5">
                          <div class="form-group">
                            <label><strong><i class="fas fa-briefcase mr-1"></i> Pekerjaan Ayah</strong></label>
                            <div class="input-group">
                              <p class="form-control" style="width: 100%;"></p>
                            </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-7">
                          <div class="form-group">
                            <label><strong><i class="fas fa-user mr-1"></i> Ibu</strong></label>
                            <div class="input-group">
                              <p class="form-control" style="width: 100%;"><?= $IbuSiswa ?></p>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-5">
                          <div class="form-group">
                            <label><strong><i class="fas fa-briefcase mr-1"></i> Pekerjaan Ibu</strong></label>
                            <div class="input-group">
                              <p class="form-control" style="width: 100%;"></p>
                            </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <label><strong><i class="fas fa-phone-square-alt mr-1"></i> Nomor Telephone</strong></label>
                            <div class="input-group">
                              <p class="form-control" style="width: 100%;"><?= $NomorHP?></p>
                            </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <label><strong><i class="fas fa-home mr-1"></i> Alamat</strong></label>
                            <div class="input-group">
                              <p class="form-control" style="width: 100%;"><?= $Alamat ?></p>
                            </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                    <form action="<?php echo base_url('User_bk');?>/BKIndividu" method="POST" class="col-md-12">
                      <input type="hidden" name="CariData" value="Siswa">
                      <input type="hidden" name="NisSiswa" value="<?= $NisSiswa ?>">
                      <div class="col-md-12">
                          <div class="form-group">
                              <button type="submit" class="btn btn-block btn-secondary">
                                <i class="fas fa-eye"></i> Lihat Seluruh Pelanggaran
                              </button>
                          </div>
                      </div>
                    </form>
                  </div>

                  
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->



            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <div class="bright-overlay"></div>
  </div>
  <!-- /.content-wrapper -->
              
  <div class="modal fade" id="deleteModal<?= $IDLapor ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <?= form_open(base_url('User_bk/BKCRUD/Hapus/'.$IDLapor), array('method' => 'post')); ?>
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Apakah Anda yakin ingin menghapus data ini?
              <input type="hidden" name="Laporkan" value="True">
              <input type="hidden" name="IDLapor" value="<?= $IDLapor ?>">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
            </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>