<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Hari Pembelajaran</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 animate__animated animate__fadeInRight">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Hari Pembelajaran</li>
                <li class="breadcrumb-item">Jadwal Pembelajaran</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const inputElement = document.getElementById('noSpecialCharsInputsss');

          inputElement.addEventListener('input', function() {
            const inputValue = inputElement.value;
            const newValue = inputValue.replace(/[\W_]+/g, ''); // Menghapus semua spasi dan karakter khusus

            if (inputValue !== newValue) {
              inputElement.value = newValue;
            }
          });
        });

        document.addEventListener('DOMContentLoaded', function() {
          const inputElement = document.getElementById('onlyNumbersInput');

          inputElement.addEventListener('input', function() {
            const inputValue = inputElement.value;
            const newValue = inputValue.replace(/[^0-9]/g, ''); // Menghapus semua selain angka

            if (inputValue !== newValue) {
              inputElement.value = newValue;
            }
          });
        });
      </script>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          
          <div class="card card-secondary shadow animate__animated animate__fadeInLeft">
                <div class="card-header">
                  <div class="card-tools">
                    <div class="btn-group">
                      <button data-toggle="modal" data-target="#InsertTabel" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
                    </div>
                  </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped shadow">
                    <thead>
                    <tr>
                      <th width="10%">Urutan ke</th>
                      <th>Kode Hari</th>
                      <th>Nama Hari</th>
                      <th width="15%">Pengaturan</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($tabel!==false) {
                        $no=0;
                        foreach ($tabel as $tb) {
                          $no++;
                          ?>
                      <tr>
                        <td><?= $tb->UrutanKe ?></td>
                        <td><?= $tb->KodeHari ?></td>
                        <td><?= $tb->NamaHari ?></td>
                        <td>
                          <div class="btn-group">
                            <button type="button" data-toggle="modal" data-target="#EditModal<?= $tb->IDHari ?>" class="btn btn-default"><i class="fas fa-edit"></i>Edit</button>
                            <a href="<?php echo base_url('User_admin/HariPembelajaran');?>" type="button" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i> Detail</a>
                            <button type="button" data-toggle="modal" data-target="#deleteModal<?php echo $tb->IDHari; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></i>Hapus</button>
                          </div>
                        </td>
                      </tr>
                          <?php
                        }
                      }
                      ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>Urutan ke</th>
                      <th>Kode Hari</th>
                      <th>Nama Hari</th>
                      <th>Pengaturan</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <div class="bright-overlay"></div>
  </div>
  <!-- /.content-wrapper -->


        <div class="modal fade" id="InsertTabel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Tambah Hari!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?= form_open(base_url('User_admin/HariPembelajaranCRUD/DataMasuk'), array('method' => 'post')); ?>
                            <div class="form-group">
                              <label>Urutan Ke :</label>
                              <div class="input-group">
                                <select class="form-control select2 shadow" name="UrutanKe" style="width: 100%;">
                                  <?php for ($i = 1; $i <= 7; $i++) { ?>
                                    <option value="<?= $i ?>">Ke-<?= $i ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Kode Hari :</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control shadow" name="KodeHari" placeholder="Kode Hari...." title="Kode Hari Yang Benar!">
                                  </div>
                                </div>
                              </div>
                              <!-- /.col -->
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Nama Hari :</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control shadow" name="NamaHari" placeholder="Nama Hari...." title="Nama Hari Yang Benar!">
                                  </div>
                                </div>
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="form-group shadow">
                              <div class="input-group">
                                <button type="submit" class="form-control btn btn-block btn-success">Simpan</button>
                              </div>
                              <!-- /.input group -->
                            </div>
                        <?= form_close(); ?>

                      </div>
                      
                    </div>
          </div>
        </div>



<?php
if ($tabel!==false) {
  foreach ($tabel as $tb2) {
?>
<div class="modal fade" id="EditModal<?= $tb2->IDHari ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Edit Hari!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?= form_open(base_url('User_admin/HariPembelajaranCRUD/DataUpdate'), array('method' => 'post')); ?>
                            <input type="hidden" name="IDHari" value="<?= $tb2->IDHari ?>">
                            
                            <div class="form-group">
                              <label>Urutan Ke :</label>
                              <div class="input-group">
                                <select class="form-control select2" name="UrutanKe" style="width: 100%;">
                                  <?php for ($i = 1; $i <= 7; $i++) { ?>
                                    <option <?php if($i==$tb2->UrutanKe){echo "selected";}?> value="<?= $i ?>">Ke-<?= $i ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <div class="row">
                              <div class="col-md-6">
                                <!-- /.form-group -->
                                <div class="form-group">
                                  <label>Kode Hari :</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="KodeHari" placeholder="Kode Hari...." title="Kode Hari Yang Benar!" value="<?= $tb2->KodeHari ?>">
                                  </div>
                                </div>
                              </div>
                              <!-- /.col -->
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Nama Hari :</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="NamaHari" placeholder="Nama Hari...." title="Nama Hari Yang Benar!" value="<?= $tb2->NamaHari ?>">
                                  </div>
                                </div>
                                <!-- /.form-group -->
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="form-group">
                              <div class="input-group">
                                <button type="submit" class="form-control btn btn-block btn-success">Simpan</button>
                              </div>
                              <!-- /.input group -->
                            </div>
                        <?= form_close(); ?>

                      </div>
                      
                    </div>
          </div>
</div>


<div class="modal fade" id="deleteModal<?php echo $tb2->IDHari; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <?= form_open(base_url('User_admin/HariPembelajaranCRUD/DataHapus'), array('method' => 'post')); ?>
  
    <input type="hidden" name="IDHari" value="<?= $tb2->IDHari ?>">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Apakah Anda yakin ingin menghapus data hari <b><?php echo $tb2->NamaHari; ?></b>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                      </div>
                    </div>

  <?= form_close(); ?>
</div>

<div class="modal fade" id="DetailModal<?php echo $tb2->IDHari; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <?= form_open(base_url('User_admin/JamPembelajaran/'), array('method' => 'post')); ?>
    <input type="hidden" name="IDHari" value="<?= $tb2->IDHari ?>">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel">Anda Akan Berpindah Halaman!</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Anda akan dialihkan ke halaman jam pelajaran, lanjutkan?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-danger">Lanjutkan</button>
                        </div>
                      </div>
                    </div>
  <?= form_close(); ?>
</div>

<?php
  }
}
?>