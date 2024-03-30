<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-with-overlay">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 animate__animated animate__fadeInLeft">
                    <h1>Data Pelanggaran</h1>
                </div>
                <div class="col-sm-6 animate__animated animate__fadeInRight">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data Pelanggaran</a></li>
                        <li class="breadcrumb-item active">Skoring</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                     <div class="card card-secondary animate__animated animate__fadeInLeft">
                        <div class="card-header p-2">
                            <!-- Konten Card Header -->
                        </div><!-- /.card-header -->
                        <div class="card-body col-md-12" id="formContainer">
                                <table id="example8" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Foto</th>
                                      <th>Tanggal</th>
                                      <th>Jenis Pelanggaran</th>
                                      <th>Keterangan</th>
                                      <th>Pelapor</th>
                                      <th>Poin</th>
                                    </tr>
                                  </thead>

                                  <tbody>
                                    <?php
                                    if ($RekapIndividu!==FALSE) {
                                        $no=0;
                                        $hitung=0;
                                    foreach ($RekapIndividu as $key) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?=$no?></td>
                                        <td><img src="<?php echo base_url(''.$key->File);?>" alt="Gambar Contoh" class="img-fluid" style="max-width: 100%;"></td>
                                        <td><?=$key->TglLapor?></td>
                                        <td><?=$key->KeteranganJenis?></td>
                                        <td><?=$key->KeteranganLapor?></td>
                                        <td><?=$key->NamaGuru?></td>
                                        <td><?=$key->Poin?></td>
                                    </tr>
                                    <?php
                                    $hitung+=$key->Poin;
                                        }
                                    }
                                    ?>
                                  </tbody>

                                  <tfoot>
                                    <tr>
                                      <th colspan="6">Jumlah Poin</th>
                                      <th><?php if(isset($hitung)){echo $hitung;}?></th>
                                    </tr>
                                  </tfoot>
                                </table>
                        </div>
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


<div class="modal fade" id="tambahdata1" tabindex="-1" role="dialog" aria-labelledby="tambahdata1" aria-hidden="true">
  <form action="<?php echo base_url('User_bk');?>/BKSkoringPelanggaran" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="Insert" value="JenisPoin">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Tambah Data Untuk Poin!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <input type="hidden" name="SPP" value="TRUE">
                <label for="KodeTahun">Poin :</label>
                <div class="input-group">
                  <input type="text" name="Poin" class="form-control" value="">
                </div>
              </div>
            </div>
            <div class="col-md-10">
              <div class="form-group">
                <label for="KodeGuru">Keterangan :</label>
                <div class="input-group">
                  <input type="text" name="Keterangan" class="form-control" value="">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group col-md-12">
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-save"></i> Simpan
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>