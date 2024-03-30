<?php
foreach ($DataKelasBy as $DKB) {
  $IDKelas=$DKB->IDKelas;
  $KodeKelas=$DKB->KodeKelas;
  $KodeTahun=$DKB->KodeTahun;
  $KodeGuru=$DKB->KodeGuru;
  $IDGuru=$DKB->IDGuru;
  $RuanganKelas=$DKB->RuanganKelas;
}
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Mata Pelajaran Untuk Kelas <?= $KodeKelas ?> </h1>

            </div><!-- /.col -->
            <div class="col-sm-6 animate__animated animate__fadeInRight">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Detail</li>
                <li class="breadcrumb-item">Pelajaran Kelas</li>
                <li class="breadcrumb-item">Jadwal</li>
                <li class="breadcrumb-item">Jadwal Sekolah</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">
            <form class="col-md-12" action="<?= base_url('User_admin/JadwalKelasMapel/Detail/'.$IDKelasMapel)?>" method="GET">
              <input type="hidden" name="Cari" value="TahunAjaran">
              <!-- general form elements -->
              <div class="card card-warning shadow animate__animated animate__fadeInLeft">
                <div class="card-header">
                  <h3 class="card-title">Pilih Tahun Ajaran :</h3>
                </div>
                <!-- /.card-header -->
                  <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label>Pilih Tahun Ajaran :</label>
                          <select id="IDAjaran" name="IDAjaran" class="select2" data-placeholder="Pilih Tahun Ajaran" style="width: 100%;">
                            <?php if ($TahunAjaran!==false) {
                              foreach ($TahunAjaran as $TA) {
                              ?>
                              <option <?php if(isset($_GET['IDAjaran']) && $_GET['IDAjaran']==$TA->IDAjaran){echo "selected";} ?> value="<?= $TA->IDAjaran ?>"><?= $TA->KodeAjaran ?></option>
                              <?php
                              }
                            }?>
                          </select>
                        </div>
                      </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <div class="form-group">
                      <div class="input-group">
                        <button type="submit" class="form-control btn btn-block btn-primary shadow"><i class="fas fa-search"></i> Cari</button>
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>
              </div>
              <!-- /.card -->
            </form>
            </div>
            <div class="col-md-9">
              <!-- general form elements -->
              <form class="col-md-12" action="<?= base_url('User_admin/')?>JadwalKelasMapelGuruCRUD" method="POST">
              <input type="hidden" name="InputData" value="GuruMapel">
              <input type="hidden" name="IDKelas" value="<?=$DKB->IDKelas?>">
              <div class="card card-primary shadow animate__animated animate__fadeInRight">
                <div class="card-header">
                  <h3 class="card-title">Data Kelas :</h3>
                  <div class="card-tools">
                    <div class="btn-group">
                      <a href="<?= base_url('User_admin/')?>JadwalKelasMapel" class="btn  btn-secondary shadow"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                  <div class="card-body">
                    <?php if (isset($TampilData) && $TampilData==true) { ?>
                    <table id="example8" class="table table-bordered table-striped shadow">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="60%">Mata Pelajaran</th>
                          <th>Guru</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if ($DataMapelKelas!==false) {
                          $No=0;
                          foreach ($DataMapelKelas as $DMK) {
                          $No++;
                          ?>
                          <tr>
                            <td><?=$No?></td>
                            <td><?=$DMK->NamaMapel?></td>
                            <td>
                              <input type="hidden" name="IDKelasMapel[]" value="<?=$DMK->IDKelasMapel?>">
                              <select required name="IDGuru[]" class="select2 col-md-12" data-placeholder="Pilih Guru <?=$DMK->NamaMapel ?>">
                                <option value="">Pilih Guru <?=$DMK->NamaMapel ?></option>
                                <?php if ($DataGuruMengajar!==false) {
                                  foreach ($DataGuruMengajar as $DGM) {
                                    if ($DMK->IDMapel==$DGM->IDMapel) {
                                  ?>
                                  <option <?php if($DMK->IDGuru==$DGM->IDGuru){echo "selected";} ?> value="<?=$DGM->IDGuru?>"><?=$DGM->NamaGuru?> (<?=$DGM->NomorIndukGuru?>)</option>
                                  <?php
                                    }
                                  }
                                } ?>
                              </select>
                            </td>
                          </tr>
                          <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                    <?php } ?>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <?php if (isset($TampilData) && $TampilData==true) { ?>
                    <div class="row">
                      <div class="col-md-6">
                      </div>
                      <div class="col-md-6">
                        <button type="submit" class="btn btn-primary col-md-12"><i class="fas fa-save"></i> Simpan Data</button>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
              </div>
              <!-- /.card -->
            </form>
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