<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Tabel Kelas</h1>
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
        const inputElementNoSpecialChars = document.getElementById('noSpecialCharsInput');
        const inputElementOnlyNumbers = document.getElementById('onlyNumbersInput');

        inputElementNoSpecialChars.addEventListener('input', function() {
          const inputValue = inputElementNoSpecialChars.value;
          const newValue = inputValue.replace(/\s/g, ''); // Menghapus semua spasi

          if (inputValue !== newValue) {
            inputElementNoSpecialChars.value = newValue;
          }
        });

        inputElementOnlyNumbers.addEventListener('input', function() {
          const inputValue = inputElementOnlyNumbers.value;
          const newValue = inputValue.replace(/\s/g, ''); // Menghapus semua spasi

          if (inputValue !== newValue) {
            inputElementOnlyNumbers.value = newValue;
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
                    <div class="btn-group shadow">
                      <button data-toggle="modal" data-target="#InsertTabel" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
                      <button data-toggle="modal" data-target="#uploadModal" type="button" class="btn btn-warning"><i class="fas fa-file-import"></i> Import</button>
                      <a href="<?php echo base_url('ExportImport'); ?>/TabelKelasExcell" class="btn btn-success"><i class="fas fa-file-export"></i> Export</a>
                    </div>
                  </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped shadow">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Kelas</th>
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
                          <a href="<?php echo base_url('User_admin/TabelKelas/Kelas/'.$tb->IDKelas);?>" type="button" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i> Detail</a>
                          <button type="button" data-toggle="modal" data-target="#deleteModal<?php echo $tb->IDKelas; ?>" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</button>
                        </div>
                      </td>
                    </tr>


                    <!-- EDIT DATA -->




                    <!-- END OF EDIT DATA -->




                    

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
    <div class="bright-overlay"></div>
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
                    <input id="noSpecialCharsInput" type="text" class="form-control" name="KodeKelas" placeholder="Masukkan Kode Kelas...." title="Kode Kelas Yang Benar!" required>
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
                  

                    <div class="row">
                      <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group">
                          <label>Tahun : </label>
                          <div class="input-group">
                              <select class="form-control select2" name="KodeTahun" style="width: 100%;">
                                <?php foreach ($tahunkelas as $data) {?>
                                <option <?php if($tb->KelasKodeTahun==$data->KodeTahun){echo "selected";} ?> value="<?php echo $data->KodeTahun; ?>" ><?php echo $data->PenyebutanTahun.' ('.$data->PenulisanTahun.')';?></option>
                                <?php } ?>
                              </select>
                          </div>
                        </div>
                      </div>
                    
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Wali Kelas :</label>
                              <select class="form-control select2" name="IDGuru" style="width: 100%;">
                                <?php foreach ($walikelas as $WK) {?>
                                <option <?php if($tb->IDGuru==$WK->IDGuru){echo "selected";} ?> value="<?php echo $WK->IDGuru; ?>" ><?php echo $WK->NamaGuru;?></option>
                                <?php } ?>
                              </select>
                        </div>
                        <!-- /.form-group -->
                      </div>
                    
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
                            <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Tutup</button>
                            <a href="<?php echo base_url('User_admin/KelasData/DataHapus/'.$tb->IDKelas);?>" class="btn btn-danger shadow">Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>
<?php
  }
}
?>

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?php echo base_url('ExportImport/ImportTabelKelasExcell'); ?>" method="POST" enctype="multipart/form-data">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Unggah File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="fileUploadForm">

            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="excelfile" accept=".xls, .xlsx">
                <label class="custom-file-label" for="exampleInputFile">Pilih file Excel</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Unggah</button>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>