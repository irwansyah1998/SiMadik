<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-with-overlay">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Pelanggaran</h1>
                    </div>
                    <div class="col-sm-6">
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
                         <div class="card card-secondary">
                            <div class="card-header p-2">
                                <!-- Konten Card Header -->
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <table id="example7" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th width="5%">Poin</th>
                                            <th width="15%">Pengaturan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($RekapPoinPelanggaran !== FALSE) {
                                            $no = 0;
                                            foreach ($RekapPoinPelanggaran as $RPP) {
                                                $no++;
                                        ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= $RPP->NamaSiswa ?></td>
                                                    <td><?= $RPP->KodeKelas ?></td>
                                                    <td><?= $RPP->Poin ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('User_bk');?>/BKSkoringPelanggaran/Detail/<?=$RPP->IDLapor?>" class="btn btn-primary"><i class="fas fa-info"></i> Detail</a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Poin</th>
                                            <th>Pengaturan</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div><!-- /.card-body -->
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