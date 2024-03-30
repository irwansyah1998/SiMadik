<div class="content-wrapper">
  <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Tabel Murid (<?= $KodeKelas ?>)</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 animate__animated animate__fadeInRight">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"><?= $KodeKelas ?></li>
                 <li class="breadcrumb-item">Tabel Kelas</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const inputElement = document.getElementById('onlyNumbersInput');

          inputElement.addEventListener('input', function() {
            const inputValue = inputElement.value;
            const newValue = inputValue.replace(/\D/g, ''); // Menghapus semua selain angka

            if (inputValue !== newValue) {
              inputElement.value = newValue;
            }
          });
        });
      </script>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          
          <div class="card card-secondary animate__animated animate__fadeInLeft">
                <div class="card-header">
                  <div class="card-tools">
                    <div class="btn-group animate__animated animate__fadeIn">
                      <button data-toggle="modal" data-target="#InsertTabelModal" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
                      <button data-toggle="modal" data-target="#uploadModal" type="button" class="btn btn-warning"><i class="fas fa-file-import"></i> Import</button>
                      <a href="<?php echo base_url('ExportImport');?>/TabelMuridExcell/<?= $kelas; ?>" class="btn btn-success"><i class="fas fa-file-export"></i> Export</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Nama Siswa</th>
                      <th>NIS</th>
                      <th>NISN</th>
                      <th>Awal Masuk</th>
                      <th>Nama Ayah</th>
                      <th>Nama Ibu</th>
                      <th width="5%">Pengaturan</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php if ($murid != false) {
                        $no=0;
                        foreach ($murid as $tb) {
                        $no++; ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $tb->NamaSiswa;?></td>
                      <td><?php echo $tb->NisSiswa;?></td>
                      <td><?php echo $tb->NISNSiswa;?></td>
                      <td><?php echo $tb->TGLMasuk;?></td>
                      <td><?php echo $tb->AyahSiswa;?></td>
                      <td><?php echo $tb->IbuSiswa;?></td>
                      <td>
                        <div class="btn-group">
                          <button type="button" data-toggle="modal" data-target="#EditModal<?php echo $tb->IDSiswa; ?>" class="btn btn-default"><i class="fas fa-edit"></i>Edit</button>
                        </div>
                      </td>
                    </tr>
                  <?php }
                  } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Siswa</th>
                      <th>NIS</th>
                      <th>NISN</th>
                      <th>Awal Masuk</th>
                      <th>Nama Ayah</th>
                      <th>Nama Ibu</th>
                      <th>Pengaturan</th>
                    </tr>
                    </tfoot>
                  </table>

                  <!-- Modal Peringatan Hapus Data -->

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



 <div class="modal fade" id="InsertTabelModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Input Data!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
              <form action="<?php echo base_url('User_admin/TabelKelas/Kelas/'.$kelas.'/DataMasuk');?>" method="POST">
                <input type="hidden" name="KodeKelas" value="<?php echo $kelas; ?>">
                <div class="form-group">
                  <label>Nama Murid :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                    </div>
                    <input  type="text" class="form-control" name="NamaSiswa" placeholder="Masukkan Nama Siswa...." pattern="[A-Za-z\s]+" title="Masukkan Nama Yang Benar!" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <div class="form-group">
                  <label>Nomor Induk Siswa Nasional :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                    </div>
                    <input id="onlyNumbersInput numInput" type="text" min="0" step="1" class="form-control" name="NISNSiswa" placeholder="Masukkan Nomor Induk Siswa Nasional...." minlength="4">
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <div class="form-group">
                  <label>Nomor Induk Siswa :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                    </div>
                    <input id="onlyNumbersInput numInput" type="text" min="0" step="1" class="form-control" name="NisSiswa" placeholder="Masukkan Nomor Induk Siswa" minlength="4" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

                

                <div class="form-group">
                  <label>Jenis Kelamin :</label>
                      <select class="form-control select2" name="GenderSiswa" style="width: 100%;">
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                </div>
                <!-- /.form group -->

                <div class="row">
                  <div class="col-sm-6">
                      <!-- text input -->
                    <div class="form-group">
                        <label>Ayah :</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                          </div>
                          <input  type="text" minlength="6" class="form-control" name="AyahSiswa" placeholder="Nama Ayah..." required>
                        </div>
                      </div>
                  </div>

                  <div class="col-sm-6">
                      <!-- text input -->
                    <div class="form-group">
                        <label>Ibu :</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                          </div>
                          <input  type="text" minlength="6" class="form-control" name="IbuSiswa" placeholder="Nama Ibu..." required>
                        </div>
                      </div>
                    </div>
                  </div>

                <div class="row">
                  <div class="col-sm-6">
                      <!-- text input -->
                    <div class="form-group">
                        <label>Tempat Lahir Siswa :</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                          </div>
                          <input  type="text" minlength="6" class="form-control" name="TmptLhrSiswa" placeholder="Tempat Lahir...." required>
                        </div>
                      </div>
                  </div>

                  <div class="col-sm-6">
                      <!-- text input -->
                       <div class="form-group">
                        <label>Tanggal Lahir Siswa :</label>
                        <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" name="TglLhrSiswa" data-mask="" inputmode="numeric">
                      </div>
                      </div>
                    </div>
                  </div>


                  <div class="row">
                  <div class="col-sm-6">
                      <!-- text input -->
                       <div class="form-group">
                        <label>Tanggal Masuk :</label>
                        <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/yyyy" name="TGLMasuk" data-mask="" inputmode="numeric" value="">
                      </div>
                      </div>
                    </div>
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

<?php if ($murid != false) {
$no=0;
foreach ($murid as $tb) {
?>
<div class="modal fade" id="EditModal<?= $tb->IDSiswa; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Edit Data!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="<?php echo base_url('User_admin/TabelKelas/Kelas/'.$kelas.'/DataUpdate');?>" method="POST">
                        <input type="hidden" name="IDSiswa" value="<?= $tb->IDSiswa; ?>">

                        <!-- Nama Murid -->
                        <div class="form-group">
                            <label for="NamaSiswa">Nama Murid:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                </div>
                                <input type="text" class="form-control" name="NamaSiswa" placeholder="Masukkan Nama Murid" pattern="[A-Za-z\s]+" value="<?= $tb->NamaSiswa; ?>" title="Masukkan Nama Yang Benar!" required>
                            </div>
                        </div>

                        <!-- Nomor Induk Siswa Nasional -->
                        <div class="form-group">
                            <label for="NISNSiswa">Nomor Induk Siswa Nasional:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                </div>
                                <input type="number" id="numInput onlyNumbersInput" name="NISNSiswa" min="0" step="1" class="form-control" placeholder="Masukkan Nomor Induk Siswa Nasional...." minlength="4" value="<?= $tb->NISNSiswa; ?>">
                            </div>
                        </div>

                        <!-- Nomor Induk Siswa -->
                        <div class="form-group">
                            <label for="NisSiswa">Nomor Induk Siswa:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                </div>
                                <input type="number" id="numInput onlyNumbersInput" name="NisSiswa" min="0" step="1" class="form-control" placeholder="Masukkan Nomor Induk Siswa" minlength="4" value="<?= $tb->NisSiswa; ?>" required>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-group">
                            <label for="GenderSiswa">Jenis Kelamin:</label>
                            <select class="form-control select2" name="GenderSiswa" style="width: 100%;">
                                <option <?= $tb->GenderSiswa == 'L' ? 'selected' : '' ?> value="L">Laki-Laki</option>
                                <option <?= $tb->GenderSiswa == 'P' ? 'selected' : '' ?> value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Ayah -->
                                <div class="form-group">
                                    <label for="AyahSiswa">Ayah:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                        </div>
                                        <input type="text" minlength="6" class="form-control" name="AyahSiswa" placeholder="Nama Ayah..." value="<?= $tb->AyahSiswa; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <!-- Ibu -->
                                <div class="form-group">
                                    <label for="IbuSiswa">Ibu:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                        </div>
                                        <input type="text" minlength="6" class="form-control" name="IbuSiswa" placeholder="Nama Ibu..." value="<?= $tb->IbuSiswa; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Tempat Lahir Siswa -->
                                <div class="form-group">
                                    <label for="TmptLhrSiswa">Tempat Lahir Siswa:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" minlength="6" class="form-control" name="TmptLhrSiswa" value="<?= $tb->TmptLhrSiswa; ?>" placeholder="Tempat Lahir...." required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <!-- Tanggal Lahir Siswa -->
                                <div class="form-group">
                                    <label for="TglLhrSiswa">Tanggal Lahir Siswa:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" name="TglLhrSiswa" data-mask="" inputmode="numeric" value="<?= $tb->TglLhrSiswa; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Tanggal Masuk -->
                                <div class="form-group">
                                    <label for="TGLMasuk">Tanggal Masuk:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/yyyy" name="TGLMasuk" data-mask="" inputmode="numeric" value="<?= $tb->TGLMasuk; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <button type="submit" class="form-control btn btn-block btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
            </div>
        </div>
    </div>
</div>
<?php
    }
  }
?>

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<form action="<?php echo base_url('ExportImport/ImportTabelMuridExcell/'.$kelas);?>" method="POST" enctype="multipart/form-data">
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
  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>