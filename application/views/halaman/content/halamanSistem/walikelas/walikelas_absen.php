<?php
$CekWaliKelas=false;
if (isset($datakelas) && is_array($datakelas) ) {
  $CekWaliKelas=true;
  foreach ($datakelas as $dk) {
    $KODEkelas=$dk->KodeKelas;
  }
}

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php if($CekWaliKelas===true){ ?>
            <h1 class="m-0">Wali Kelas (<?= $KODEkelas ?>)</h1>
            <?php }else{?>
            <h1 class="m-0">Wali Kelas Belum Ditetapkan</h1>
            <?php } ?>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php if($CekWaliKelas===true){ ?>
              <li class="breadcrumb-item active"><?= $KODEkelas ?></li>
              <?php }else{?>
              <li class="breadcrumb-item active">Data Belum Ada</li>
              <?php } ?>
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
    <?php if($CekWaliKelas===true){ ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Tabel Kelas <?= $KODEkelas ?></h3>
                <div class="card-tools">

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Nama Siswa</th>
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
                    <td><?php echo $tb->NamaSiswa;?></td>
                    <td width="15%">
                      <div class="btn-group">
                        <a href="<?php echo base_url('User_walikelas/WKAbsen/Detail/'.$tb->NisSiswa);?>" type="button" class="btn btn-secondary"><i class="fa fa-list" aria-hidden="true"></i> Detail</a>
                       
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
                        <a href="<?php echo base_url('User_walikelas/KelasData/DataHapus/'.$tb->IDKelas);?>" class="btn btn-danger">Hapus</a>
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
    <?php }?>

  </div>
  <!-- /.content-wrapper -->