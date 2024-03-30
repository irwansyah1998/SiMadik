<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Tahun Ajaran</h1>
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
                  <h3 class="card-title">Tabel Tahun Ajaran</h3>
                  <div class="card-tools">
                    <button data-toggle="modal" data-target="#InsertTabel" type="button" class="btn btn-block btn-primary">
                      <i class="fa fa-plus"></i> Tambah Data
                    </button>
                  </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped shadow">
                    <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Tahun Ajaran</th>
                      <th width="15%">Aktif</th>
                      <th>Pengaturan</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php if ($TahunAjaran != false) {
                        $no=0;
                        foreach ($TahunAjaran as $tb) {
                        $no++; ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $tb->KodeAjaran;?></td>
                      <td>
                        <div class="btn-group">
                          <!-- <button type="button" class="btn btn-default"><i class="fas fa-edit"></i>Edit</button> -->
                          <?php if ($tb->Status !== 'Aktif') {
                            $Aktif = false;
                            $Text = 'Pilih';
                          }elseif ($tb->Status == 'Aktif'){
                            $Aktif = true;
                            $Text = 'Terpilih';
                          } ?>
                          <button type="button" <?php if($Aktif==true ){echo "disabled";} ?> data-toggle="modal" data-target="#AktifModal_<?php echo $tb->IDAjaran; ?>" class="btn btn-primary"><?php if($Aktif==true ){echo '<i class="fas fa-check"></i> ';} ?> <?= $Text ?></button>
                        </div>
                      </td>
                      <td width="15%">
                        <div class="btn-group">
                          <!-- <button type="button" class="btn btn-default"><i class="fas fa-edit"></i>Edit</button> -->
                          <button type="button" data-toggle="modal" data-target="#deleteModal_<?php echo $tb->IDAjaran; ?>" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</button>
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
                      <th>Tahun Ajaran</th>
                      <th width="15%">Aktif</th>
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
                <form action="<?php echo base_url('User_admin/TabelTahunAjaran/EditUpdate/');?>DataMasuk" method="POST">

                  <div class="row">
                  <div class="col-md-6">
                    <!-- /.form-group -->
                    <div class="form-group">
                      <div class="input-group">
                        <label>Tahun Awal :</label>
                        <div class="input-group">
                        <input  type="number" id="numInput" name="TahunAwal" min="0" step="1" class="form-control" minlength="4" value="" required>
                      </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Tahun Akhir :</label>
                        <input  type="number" id="numInput" name="TahunAkhir" min="0" step="1" class="form-control" minlength="4" value="" required>
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

                      <?php if ($TahunAjaran != false) {
                      $no=0;
                      foreach ($TahunAjaran as $tb) {
                      $no++; ?>
                <div class="modal fade" id="AktifModal_<?php echo $tb->IDAjaran; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Pemberitahuan!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Apakah Anda yakin ingin memilih <?= $tb->KodeAjaran ?>, sebagai tahun ajaran saat ini?
                      </div>
                      <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <a href="<?php echo base_url('User_admin/TabelTahunAjaran/EditUpdate/Aktifkan/'.$tb->IDAjaran);?>" class="btn btn-primary">Lanjutkan</a>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Hapus Data -->
                  <div class="modal fade" id="deleteModal_<?php echo $tb->IDAjaran; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data Ajaran <?php echo $tb->KodeAjaran; ?>?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <a href="<?php echo base_url('User_admin/TabelTahunAjaran/EditUpdate/Hapus/'.$tb->IDAjaran);?>" class="btn btn-danger">Hapus</a>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                }
              }?>