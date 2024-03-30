<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 animate__animated animate__fadeInLeft">
            <h1 class="m-0">Tambah Tabel Kelas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 animate__animated animate__fadeInRight">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Tabel Kelas</li>
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
        
        <div class="card card-secondary animate__animated animate__fadeInUp">
              <div class="card-header">
                <div class="card-tools">
                  <div class="btn-group">
                    <button data-toggle="modal" data-target="#InsertTabel" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
                    <button data-toggle="modal" data-target="#uploadModal" type="button" class="btn btn-warning"><i class="fas fa-file-import"></i> Import</button>
                    <a href="<?php echo base_url('ExportImport'); ?>/TabelKelasExcell" class="btn btn-success"><i class="fas fa-file-export"></i> Export</a>
                  </div>
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Kode Kelas</th>
                    <th>Ruang Kelas</th>
                    <th>Tingkatan</th>
                    <th>Wali Kelas</th>
                    <th>Pengaturan</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if ($tabel != false) {
                      $no=0;
                      foreach ($tabel as $tb) {
                      $no++; ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $tb->KodeKelas;?></td>
                    <td><?php echo $tb->RuanganKelas;?></td>
                    <td><?php echo $tb->PenulisanTahun;?> (<?php echo $tb->PenyebutanTahun;?>)</td>
                    <td><?php echo $tb->NamaGuru;?></td>
                    <td width="15%">
                      <div class="btn-group">
                        <button type="button" data-toggle="modal" data-target="#EditTabel<?php echo $tb->IDKelas; ?>" class="btn btn-default"><i class="fas fa-edit"></i>Edit</button>
                        <a href="<?php echo base_url('User_admin/TabelKelas/Kelas/'.$tb->KodeKelas);?>" type="button" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i> Detail</a>
                        <button type="button" data-toggle="modal" data-target="#deleteModal<?php echo $tb->IDKelas; ?>" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</button>
                      </div>
                    </td>
                  </tr>


                  <!-- EDIT DATA -->




                  <!-- END OF EDIT DATA -->




                  <!-- Hapus Data -->
                  <div class="modal fade" id="deleteModal<?php echo $tb->IDKelas; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data dengan nama <?php echo $tb->KodeKelas; ?>?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <a href="<?php echo base_url('User_admin/KelasData/DataHapus/'.$tb->IDKelas);?>" class="btn btn-danger">Hapus</a>
                      </div>
                    </div>
                  </div>
                </div>

                <?php }
                } ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kode Kelas</th>
                    <th>Ruang Kelas</th>
                    <th>Tingkatan</th>
                    <th>Wali Kelas</th>
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
  <!-- /.content-wrapper -->


        <div class="modal fade" id="InsertTabel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Tambah Kelas!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                <form action="<?php echo base_url('User_admin/KelasData/');?>DataMasuk" method="POST">
                <div class="form-group">
                  <label>Kode Kelas :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-school"></i></span>
                    </div>
                    <input id="noSpecialCharsInputsss" type="text" class="form-control" name="KodeKelas" placeholder="Masukkan Kode Kelas...." title="Kode Kelas Yang Benar!" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

              <div class="row">
              <div class="col-md-6">
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Tahun :</label>
                  <div class="input-group">
                      <select class="form-control select2" name="KodeTahun" style="width: 100%;">
                        <?php foreach ($tahunkelas as $data) {?>
                        <option value="<?php echo $data->KodeTahun; ?>" ><?php echo $data->PenyebutanTahun.' ('.$data->PenulisanTahun.')';?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Wali Kelas :</label>
                      <select class="form-control select2" name="IDGuru" style="width: 100%;">
                        <?php foreach ($walikelas as $tb) {?>
                        <option value="<?php echo $tb->IDGuru; ?>" ><?php echo $tb->NamaGuru;?></option>
                        <?php } ?>
                      </select>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>

            <div class="form-group">
                  <label>Ruang Kelas :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-school"></i></span>
                    </div>
                    <input type="text" class="form-control" name="RuanganKelas" placeholder="Ruangan Kelas...." title="Kode Kelas Yang Benar!">
                  </div>
                  <!-- /.input group -->
                </div>
                <br>
                <div class="form-group">
                  <div class="input-group">
                    <button type="submit" class="form-control btn btn-block btn-success">Simpan</button>
                  </div>
                  <!-- /.input group -->
                </div>
                </form>
              </div>
                      
                    </div>
                  </div>
                </div>






<?php if ($tabel !== false) {
  foreach ($tabel as $tb) {
 ?>
        <div class="modal fade" id="EditTabel<?=$tb->IDKelas?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Edit Kelas!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                <form action="<?php echo base_url('User_admin/KelasData/');?>DataUpdate" method="POST">
                  <input type="hidden" name="IDKelas" value="<?= $tb->IDKelas ?>">
                <div class="form-group">
                  <label>Kode Kelas :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-school"></i></span>
                    </div>
                    <input id="noSpecialCharsInputsss" type="text" class="form-control" name="KodeKelas" placeholder="Masukkan Kode Kelas...." title="Kode Kelas Yang Benar!" required value="<?= $tb->KodeKelas ?>">
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

              <div class="row">
              <div class="col-md-6">
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Tahun :</label>
                  <div class="input-group">
                      <select class="form-control select2" name="KodeTahun" style="width: 100%;">
                        <?php foreach ($tahunkelas as $data) {?>
                        <option value="<?php echo $data->KodeTahun; ?>" ><?php echo $data->PenyebutanTahun.' ('.$data->PenulisanTahun.')';?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Wali Kelas :</label>
                      <select class="form-control select2" name="IDGuru" style="width: 100%;">
                        <?php foreach ($walikelas as $WK) {?>
                        <option value="<?php echo $WK->IDGuru; ?>" ><?php echo $WK->NamaGuru;?></option>
                        <?php } ?>
                      </select>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>

            <div class="form-group">
                  <label>Ruang Kelas :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-school"></i></span>
                    </div>
                    <input type="text" class="form-control" name="RuanganKelas" placeholder="Ruangan Kelas...." title="Kode Kelas Yang Benar!" value="<?= $tb->RuanganKelas ?>">
                  </div>
                  <!-- /.input group -->
                </div>
                <br>
                <div class="form-group">
                  <div class="input-group">
                    <button type="submit" class="form-control btn btn-block btn-success">Simpan</button>
                  </div>
                  <!-- /.input group -->
                </div>
                </form>
              </div>
                      
                    </div>
                  </div>
                </div>
<?php
  }
}
?>