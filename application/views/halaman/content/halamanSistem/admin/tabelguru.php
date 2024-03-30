<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-with-overlay">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 animate__animated animate__fadeInLeft">
            <h1 class="m-0">Tabel Guru</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 animate__animated animate__fadeInRight">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Guru</li>
              <li class="breadcrumb-item">Tabel Pengguna</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const inputElement = document.getElementById('noSpecialCharsInput');

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

        <div class="card card-secondary">
          <div class="card-header">
            <div class="card-tools">
              <div class="btn-group shadow">
                <a href="<?php echo base_url('User_admin/TabelGuru/TambahData/'); ?>" class="btn  btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                <button data-toggle="modal" data-target="#uploadModal" type="button" class="btn btn-warning"><i class="fas fa-file-import"></i> Import</button>
                <a href="<?php echo base_url('User_admin'); ?>/TabelGuruPDF" class="btn btn-dark"><i class="fas fa-file-pdf"></i> Daftar User</a>
                <a href="<?php echo base_url('User_admin'); ?>/TabelGuruExcell" class="btn btn-success"><i class="fas fa-file-export"></i> Export</a>
              </div>
            </div>

          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped shadow">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Kode Guru</th>
                  <th>Nomor Induk Guru</th>
                  <th>Nama Guru</th>
                  <th>Jabatan</th>
                  <th>Guru Pelajaran</th>
                  <th>Pengaturan</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($tabel != false) {
                  $no = 0;
                  foreach ($tabel as $tb) {
                    $no++; ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $tb->KodeGuru; ?></td>
                      <td><?php echo $tb->NomorIndukGuru; ?></td>
                      <td><?php echo $tb->NamaGuru; ?></td>
                      <td>
                        <?php
                        $IdHak = explode('//', $tb->IDHak);
                        $count = count($IdHak);
                        $NamaHak = array();
                        foreach ($tabel2 as $tb2) {
                          for ($i = 0; $i < $count; $i++) {
                            if ($tb2->IDHak == $IdHak[$i]) {
                              $NamaHak[$i]=$tb2->NamaHak;
                              }
                            }
                          }
                        echo implode(', ', $NamaHak); ?>
                      </td>
                      <td>
                        <?php
                        if ($TabelMengajarMapel!==false) {
                          $Mapel = array();
                          $i=0;
                          foreach ($TabelMengajarMapel as $TMM) {
                            if ($tb->IDGuru==$TMM->IDGuru) {
                              $Mapel[$i]=$TMM->NamaMapel;
                              $i++;
                            }
                          }
                          echo implode(', ', $Mapel);
                        }
                        ?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <a href="<?php echo base_url('User_admin/TabelGuru/Edit/' . $tb->KodeGuru); ?>" type="button" class="btn btn-default"><i class="fas fa-edit"></i>Edit</a>
                          <button type="button" data-toggle="modal" data-target="#deleteModal<?php echo $tb->IDGuru; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></i>Hapus</button>
                        </div>
                      </td>
                    </tr>

                    

                <?php }
                } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Kode Guru</th>
                  <th>Nomor Induk Guru</th>
                  <th>Nama Guru</th>
                  <th>Jabatan</th>
                  <th>Guru Pelajaran</th>
                  <th>Pengaturan</th>
                </tr>
              </tfoot>
            </table>


            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </div>
  <div class="bright-overlay"></div>
</div>


<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?php echo base_url('ExportImport/ImportTabelGuruExcell'); ?>" method="POST" enctype="multipart/form-data">
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

<?php if ($tabel != false) {
foreach ($tabel as $tb) {
?>
<!-- Hapus Data -->
                    <div class="modal fade" id="deleteModal<?php echo $tb->IDGuru; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menghapus data dengan nama <?php echo $tb->NamaGuru; ?>?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Tutup</button>
                            <a href="<?php echo base_url('User_admin/TabelGuru/Hapus/' . $tb->IDGuru); ?>" class="btn btn-danger shadow">Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>
<?php }
}?>