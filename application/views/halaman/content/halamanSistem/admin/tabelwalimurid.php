<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Tabel Wali Murid</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 animate__animated animate__fadeInRight">
              <ol class="breadcrumb float-sm-right">
                 <li class="breadcrumb-item">Tabel Pengguna</li>
                <li class="breadcrumb-item active">Wali Murid</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->


      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          
          <div class="card card-secondary animate__animated animate__fadeIn">
                <div class="card-header">
                  <h3 class="card-title">Tabel Wali Murid</h3>
                  <div class="card-tools">
                    <div class="btn-group">
                      <a href="<?php echo base_url("User_admin/WaliMurid/InputData"); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                      <button data-toggle="modal" data-target="#uploadModal" type="button" class="btn btn-warning"><i class="fas fa-file-import"></i> Import</button>
                      <a href="<?php echo base_url('ExportImport'); ?>/ExportTabelWaliMuridExcell" class="btn btn-success"><i class="fas fa-file-export"></i> Export</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Wali Murid</th>
                      <th>Nama Siswa</th>
                      <th width="20%">Pengaturan</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php if ($WaliMurid != false) {
                        $no=0;
                        foreach ($WaliMurid as $tb) {
                        $no++; ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $tb->NamaOrtu;?></td>
                      <td><?php echo $tb->NamaSiswa;?></td>
                      <td>
                        <div class="btn-group">
                          <a href="<?php echo base_url("User_admin/WaliMurid/EditData/Edit/".$tb->IDOrtu); ?>" type="button" class="btn btn-default"><i class="fas fa-edit"></i>Edit</a>
                          <!--                         <button type="button" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i>Detail</button> -->
                          <button type="button" data-toggle="modal" data-target="#deleteModal<?php echo $tb->IDOrtu; ?>" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</button>
                        </div>
                      </td>
                    </tr>
                  <?php }
                  } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Wali Murid</th>
                      <th>Nama Siswa</th>
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



<?php if ($WaliMurid != false) {
foreach ($WaliMurid as $WM) {
?>
                  <!-- Hapus Data -->
                  <div class="modal fade" id="deleteModal<?php echo $WM->IDOrtu; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <form action="<?php echo base_url("User_admin/WaliMurid/DeleteData/Delete/"); ?>" method="POST">
                      <input type="hidden" name="IDOrtu" value="<?= $WM->IDOrtu ?>">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Apakah Anda yakin ingin menghapus <?php echo $WM->NamaOrtu; ?>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</button>
                        </div>
                      </div>
                    </div>
                    </form>
                  </div>
<?php
  }
}
?>


<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?php echo base_url('ExportImport/ImportTabelWaliMuridExcell'); ?>" method="POST" enctype="multipart/form-data">
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