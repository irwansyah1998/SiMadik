<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Semester</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 animate__animated animate__fadeInRight">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Tabel</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const inputElement = document.getElementById('noSpaceInput');

          inputElement.addEventListener('input', function() {
            const inputValue = inputElement.value;
            const newValue = inputValue.replace(/\s/g, ''); // Menghapus semua spasi

            if (inputValue !== newValue) {
              inputElement.value = newValue;
            }
          });
        });
      </script>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          
          <div class="card card-secondary shadow animate__animated animate__fadeInLeft" style="transform: perspective(5000px);">
                <div class="card-header">
                  <h3 class="card-title">Tabel Semester</h3>
                  <div class="card-tools">
                    <button data-toggle="modal" data-target="#InsertTabel" type="button" class="btn btn-block btn-primary">
                      <i class="fa fa-plus"></i> Tambah Data
                    </button>
                  </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example12" class="table table-bordered table-striped shadow">
                    <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Semester</th>
                      <th width="10%">Kode</th>
                      <th width="15%">Aktif</th>
                      <th width="15%">Pengaturan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($AmbilSemester!==false) {
                    $no=0;
                    foreach ($AmbilSemester as $AS) {
                      $no++;
                    ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= $AS->NamaSemester ?></td>
                        <td><?= $AS->Penyebutan ?></td>
                        <td>
                          <?php if ($AS->Status !== 'Aktif') {
                            $Aktif = false;
                            $Text = 'Pilih';
                          }elseif ($AS->Status == 'Aktif'){
                            $Aktif = true;
                            $Text = 'Terpilih';
                          } ?>
                          <div class="btn-group">
                            <button type="button" <?php if($Aktif==true ){echo "disabled";} ?> data-toggle="modal" data-target="#AktifModal_<?= $AS->IDSemester ?>" class="btn btn-primary"><?php if($Aktif==true ){echo '<i class="fas fa-check"></i> ';} ?><?= $Text ?></button>
                          </div>
                        </td>
                        <td>
                          <div class="btn-group">
                          <!-- <button type="button" class="btn btn-default"><i class="fas fa-edit"></i>Edit</button> -->
                            <button type="button" data-toggle="modal" data-target="#deleteModal_<?= $AS->IDSemester ?>" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</button>
                          </div>
                        </td>
                      </tr>
                    <?php
                      }
                    } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Semester</th>
                      <th>Kode</th>
                      <th>Aktif</th>
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
                        <h5 class="modal-title" id="deleteModalLabel">Tambah Data!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                <form action="<?php echo base_url('User_admin/TabelSemester/EditUpdate/');?>DataMasuk" method="POST">

                  <div class="row">
                  <div class="col-md-8">
                    <!-- /.form-group -->
                    <div class="form-group">
                      <div class="input-group">
                        <label>Nama Semester :</label>
                        <div class="input-group">
                        <input  type="text" name="NamaSemester" class="form-control" minlength="1" value="" required>
                      </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Kode Semester :</label>
                        <input  type="text" id="noSpaceInput" name="Penyebutan" class="form-control" minlength="1" value="" required>
                      </div>
                    <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                  </div>

                  <div class="form-group">
                      
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
                    if ($AmbilSemester!==false) {
                    $no=0;
                    foreach ($AmbilSemester as $AS) {
                    ?>

                      <div class="modal fade" id="AktifModal_<?php echo $AS->IDSemester; ?>" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="EditModalLabel">Pemberitahuan!</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              Apakah Anda yakin ingin memilih <?= $AS->NamaSemester ?>, sebagai tahun ajaran saat ini?
                            </div>
                            <div class="modal-footer">
                              
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                              <a href="<?php echo base_url('User_admin/TabelSemester/EditUpdate/Aktifkan/'.$AS->IDSemester);?>" class="btn btn-primary">Lanjutkan</a>
                            </div>
                          </div>
                        </div>
                      </div>


                      <!-- Hapus Data -->
                        <div class="modal fade" id="deleteModal_<?php echo $AS->IDSemester; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Apakah Anda yakin ingin menghapus data <?php echo $AS->NamaSemester; ?>?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <a href="<?php echo base_url('User_admin/TabelSemester/EditUpdate/Hapus/'.$AS->IDSemester);?>" class="btn btn-danger">Hapus</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!-- Hapus Data -->
                    <?php
                      }
                    } ?>