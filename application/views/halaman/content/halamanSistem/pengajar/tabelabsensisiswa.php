
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tabel Absensi Siswa Kelas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item">Absensi</li>
               <li class="breadcrumb-item">Murid</li>
              <li class="breadcrumb-item active">Data</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="card col-md-6">
              <div class="card-header">
                <h3 class="card-title">Daftar Absensi Kelas <?php echo $KodeKelas; ?> Untuk tanggal <?php echo $TanggalAbsensi; ?> </h3>
                <div class="card-tools">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-clock"></i></span>
                    </div>
                    <input  type="time" class="form-control" name="JamAbsen" required>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
                <form class="col-md-12" action="<?php echo base_url('User_pengajar/DataAbsenMasuk');?>" method="POST">
              <div class="card-body">
                <table id="example7" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Nama Siswa</th>
                    <th width="5%">Hadir</th>
                    <th width="10%">Kehadiran</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if ($Absensi !== false){
                        $no=0;
                        foreach ($Absensi as $tb) {
                          $no++; ?>
                    
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $tb->NamaSiswa;?></td>
                    <td>
                      <input disabled type="checkbox" value="<?php echo $tb->NisSiswa; ?>" name="CNisSiswa[]"<?php if($AbsensiHadir!==False){foreach($AbsensiHadir as $tb2){if($tb2->NisSiswa===$tb->NisSiswa){if($tb2->MSIA=='M'){ echo "checked"; }}}}?> id="Hadir<?php echo $tb->NisSiswa; ?>">
                      <label for="Hadir<?php echo $tb->NisSiswa; ?>"></label>
                    </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <select <?php if($AbsensiHadir!==False){foreach($AbsensiHadir as $tb2){if($tb2->NisSiswa===$tb->NisSiswa){echo "disabled";}}}?> class="form-control select2" name="MSIA[]" style="width: 100%;">
                          <option <?php if($AbsensiHadir!==False){foreach($AbsensiHadir as $tb2){if($tb2->NisSiswa===$tb->NisSiswa){if($tb2->MSIA=='M'){ echo "selected"; }}}}?> value="M">Masuk</option>
                          <option <?php if($AbsensiHadir!==False){foreach($AbsensiHadir as $tb2){if($tb2->NisSiswa===$tb->NisSiswa){if($tb2->MSIA=='S'){ echo "selected"; }}}}?> value="S">Sakit</option>
                          <option <?php if($AbsensiHadir!==False){foreach($AbsensiHadir as $tb2){if($tb2->NisSiswa===$tb->NisSiswa){if($tb2->MSIA=='I'){ echo "selected"; }}}}?> value="I">Izin</option>
                          <option <?php if($AbsensiHadir!==False){foreach($AbsensiHadir as $tb2){if($tb2->NisSiswa===$tb->NisSiswa){if($tb2->MSIA=='A'){ echo "selected"; }}}}?> value="A">Alpha</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                  
                    <?php
                  }
                }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Hadir</th>
                    <th>Keterangan</th>
                  </tr>
                  </tfoot>
                </table>
                <!-- Modal Peringatan Hapus Data -->

              </div>
              </form>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <?php
// print_r($AbsensiGuru);
// print_r($AbsensiHadir);

?>