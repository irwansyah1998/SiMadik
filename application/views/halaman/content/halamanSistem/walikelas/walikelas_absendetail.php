<?php
foreach ($MuridWhere as $tb) {
  $NamaSiswa = $tb->NamaSiswa;
  $NamaSiswa = $tb->NamaSiswa;
  $KodeKelas = $tb->KodeKelas;
  $IbuSiswa = $tb->IbuSiswa;
  $AyahSiswa = $tb->AyahSiswa;
  $NomorHP = $tb->NomorHP;
  $NamaOrtu = $tb->NamaOrtu;
  $Alamat = $tb->Alamat;
}

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Kelas</li>
              <li class="breadcrumb-item active">Detail</li>
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <!-- <img class="profile-user-img img-fluid img-circle"
                       src="../../dist/img/user4-128x128.jpg"
                       alt="User profile picture"> -->
                </div>

                <h3 class="profile-username text-center"><?= $NamaSiswa ?></h3>

                <p class="text-muted text-center"><?= $KodeKelas ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Jumlah Sakit</b> <a class="float-right"><?= $JumlahSakit ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Jumlah Ijin</b> <a class="float-right"><?= $JumlahIjin ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Jumlah Alpha</b> <a class="float-right"><?= $JumlahAlpha ?></a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Wali Murid Dari <?= $NamaSiswa ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                    <ul class="list-group list-group-unbordered mb-3">
                      <li class="list-group-item">
                        <b>Nama Wali Murid :</b> <a class="float-right"><?= $NamaOrtu ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Nomor HP :</b> <a class="float-right"><?= $NomorHP ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Alamat Wali Murid :</b> <a class="float-right"><?= $Alamat ?></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-8">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Rekapitulasi Nilai Untuk <?= $NamaSiswa ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                     <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                  </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                  </tr>
                  </tfoot>
                </table>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-6">
            
          </div>

        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


  </div>
  <!-- /.content-wrapper -->

        <div class="modal fade" id="InsertTabel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                <form action="<?php echo base_url('User_halaman/KelasData/');?>DataMasuk" method="POST">
                <div class="form-group">
                  <label>Kode Kelas :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-school"></i></span>
                    </div>
                    <input id="noSpaceInput" type="text" class="form-control" name="KodeKelas" placeholder="Masukkan Kode Kelas...." title="Kode Kelas Yang Benar!" required>
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
                      <select class="form-control select2" name="KodeGuru" style="width: 100%;">
                        <?php foreach ($walikelas as $tb) {?>
                        <option value="<?php echo $tb->KodeGuru; ?>" ><?php echo $tb->NamaGuru;?></option>
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