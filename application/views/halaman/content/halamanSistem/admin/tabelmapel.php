<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-with-overlay">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 animate__animated animate__fadeInLeft">
            <h1 class="m-0">Tabel Mata Pelajaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right animate__animated animate__fadeInRight">
              <li class="breadcrumb-item active">Mata Pelajaran</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const noSpecialCharsInput = document.getElementById('noSpecialCharsInputsss');

        if (noSpecialCharsInput) {
          noSpecialCharsInput.addEventListener('input', function() {
            const inputValue = noSpecialCharsInput.value;
            const newValue = inputValue.replace(/[\W_]+/g, ''); // Menghapus semua spasi dan karakter khusus

            if (inputValue !== newValue) {
              noSpecialCharsInput.value = newValue;
            }
          });
        }

        const onlyNumbersInput = document.getElementById('onlyNumbersInput');

        if (onlyNumbersInput) {
          onlyNumbersInput.addEventListener('input', function() {
            const inputValue = onlyNumbersInput.value;
            const newValue = inputValue.replace(/[^0-9]/g, ''); // Menghapus semua selain angka

            if (inputValue !== newValue) {
              onlyNumbersInput.value = newValue;
            }
          });
        }
      });
    </script>




    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <div class="card card-secondary animate__animated animate__fadeInLeft">
          <div class="card-header">
            <div class="card-tools shadow">
              <div class="btn-group">
                <button data-toggle="modal" data-target="#InsertTabel" type="button" class="btn  btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
                <button data-toggle="modal" data-target="#uploadModal" type="button" class="btn btn-warning">
                  <i class="fas fa-file-import"></i> Import</button>
                <a href="<?= base_url('ExportImport') ?>/TabelMapelExcell" type="button" class="btn btn-success">
                  <i class="fas fa-file-import"></i> Export</a>
              </div>
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped shadow">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Kode Mata Pelajaran</th>
                  <th>Nama Mata Pelajaran</th>
                  <th>Pengaturan</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($TabelMapel != false) {
                  $no = 0;
                  foreach ($TabelMapel as $tb) {
                    $no++; ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $tb->KodeMapel; ?></td>
                      <td><?php echo $tb->NamaMapel; ?></td>
                      <td width="15%">
                        <div class="btn-group">
                          <button type="button" data-toggle="modal" data-target="#EditModal<?php echo $tb->IDMapel; ?>" class="btn btn-default"><i class="fas fa-edit"></i>Edit</button>
                          <button type="button" data-toggle="modal" data-target="#deleteModal<?php echo $tb->IDMapel; ?>" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</button>
                        </div>
                      </td>
                    </tr>


                    

                <?php }
                } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Kode Mata Pelajaran</th>
                  <th>Nama Mata Pelajaran</th>
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
        <h5 class="modal-title" id="deleteModalLabel">Input Mata Pelajaran!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('User_admin/TabelMapel/'); ?>DataMasuk" method="POST">

          <!-- /.form group -->

          <div class="row">
            <div class="col-md-6">
              <!-- /.form-group -->
              <div class="form-group">
                <label>Kode Mapel :</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                  </div>
                  <input id="noSpecialCharsInputsss" type="text" class="form-control" name="KodeMapel" placeholder="Kode Mata Pelajaran...." required>
                </div>
                <!-- /.input group -->
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <!-- /.form-group -->
              <div class="form-group">
                <label>Nama Mata Pelajaran :</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                  </div>
                  <input type="text" class="form-control" name="NamaMapel" placeholder="Mata Pelajaran....">
                </div>
                <!-- /.input group -->
              </div>
            </div>
            <!-- /.col -->
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


<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?php echo base_url('ExportImport/ImportTabelMapelExcell'); ?>" method="POST" enctype="multipart/form-data">
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

                    
                <?php if ($TabelMapel != false) {
                  $no = 0;
                  foreach ($TabelMapel as $tb) {
                    $no++; ?>
                    <!-- EDIT DATA -->
                    <div class="modal fade" id="EditModal<?= $tb->IDMapel ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Edit Mata Pelajaran!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo base_url('User_admin/TabelMapel/'); ?>DataUpdate" method="POST">

                              <!-- /.form group -->

                              <div class="row">
                                <div class="col-md-6">
                                  <!-- /.form-group -->
                                  <div class="form-group">
                                    <label>Kode Mapel :</label>
                                    <input type="hidden" name="IDMapel" value="<?= $tb->IDMapel ?>">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                      </div>
                                      <input id="noSpecialCharsInput" type="text" class="form-control" name="KodeMapel" placeholder="Kode Mata Pelajaran...." value="<?= $tb->KodeMapel ?>" required>
                                    </div>
                                    <!-- /.input group -->
                                  </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                  <!-- /.form-group -->
                                  <div class="form-group">
                                    <label>Nama Mata Pelajaran :</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                                      </div>
                                      <input type="text" value="<?= $tb->NamaMapel ?>" class="form-control" name="NamaMapel" placeholder="Mata Pelajaran....">
                                    </div>
                                    <!-- /.input group -->
                                  </div>
                                </div>
                                <!-- /.col -->
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



                    <!-- END OF EDIT DATA -->




                    <!-- Hapus Data -->
                    <div class="modal fade" id="deleteModal<?php echo $tb->IDMapel; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menghapus <?php echo $tb->NamaMapel; ?>?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <a href="<?php echo base_url('User_admin/TabelMapel/DataHapus/' . $tb->IDMapel); ?>" class="btn btn-danger">Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php }
                }?>