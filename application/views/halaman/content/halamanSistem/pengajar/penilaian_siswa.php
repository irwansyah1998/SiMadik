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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 animate__animated animate__fadeInLeft">
            <h1 class="m-0">Penilaian <?php echo $Kelas; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6 animate__animated animate__fadeInRight">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item">Penilaian</li>
              <li class="breadcrumb-item active"><?php echo $Kelas; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Kelas <?php echo $Kelas; ?> </h3>
                <div class="card-tools">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="btn-group">
                        <form action="<?php echo base_url('User_pengajar');?>/InsertNilaiHarian" method="GET">
                          <input type="hidden" name="InsertOrUpdate" value="TRUE">
                          <input type="hidden" name="KodeMapel" value="<?= $_GET['KodeMapel'] ?>">
                          <input type="hidden" name="IDSemester" value="<?= $_GET['IDSemester'] ?>">
                          <input type="hidden" name="KodeTahun" value="<?= $_GET['KodeTahun'] ?>">
                          <input type="hidden" name="IDAjaran" value="<?= $_GET['IDAjaran'] ?>">
                          <input type="hidden" name="KodeKelas" value="<?= $_GET['KodeKelas'] ?>">
                          <input type="hidden" name="KodeGuru" value="<?= $_GET['KodeGuru'] ?>">
                          <button type="submit" class="btn btn-default"><i class="fas fa-edit"></i>Edit Nilai Harian</button>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
          <form action="<?php echo base_url('User_pengajar');?>/PenilaianCRUD/NilaiMasuk" method="POST">
            <!-- <input type="hidden" name="InsertOrUpdate" value="TRUE"> -->
              <!-- /.card-header -->
              <div class="card-body">
                <table  class="table table-bordered table-striped" id="example2">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Nama Siswa</th>
                    <th width="40%">Nilai Harian</th>
                    <th width="10%">Nilai UTS</th>
                    <th width="10%">UAS</th>
                    <th width="5%">Nilai Akhir</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if ($datasiswa !== false){
                        $no=0;
                        foreach ($datasiswa as $tb) {
                          $no++;
                          
                          ?>
                  <?php
                  $NilaiHarian = array(); // Inisialisasi variabel $NilaiHarian di luar loop
                  if ($datasiswanilai !== FALSE) {
                  $NilaiHarian = array(); // Inisialisasi ulang variabel $NilaiHarian di awal loop
                  foreach ($datasiswanilai as $tb2) {
                    if ($tb->NisSiswa === $tb2->NisSiswa && isset($tb2->NilaiHarian)) {
                      $ds = explode("//", $tb2->NilaiHarian);
                      for ($i = 0; $i < count($ds); $i++) {
                      $NilaiHarian[] = $ds[$i]; // Menambahkan nilai ke array $NilaiHarian
                    }
                  }
                }
              } else {
                $NilaiHarian = FALSE;
              }
              ?>

                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $tb->NamaSiswa;?></td>
                    <td>

                      <?php if ($DataNilaiHarian!==FALSE) { ?>
                      <table class="col-sm-12">
                        <thead>
                        <tr>
                      <?php foreach ($DataNilaiHarian as $row) { ?>
                         <th><?= $row->KodeNilaiHarian ?></th> 
                      <?php } ?>
                        </tr>
                        <tr>
                        </thead>
                          <tr>
                            <?php
                            $Nilaike=0;
                            foreach ($DataNilaiHarian as $row) { ?>
                            <td>
                              <div class="row">
                                <div class="col-sm-12">
                                <!-- text input -->
                                  <div class="form-group">
                                    <div class="input-group">
                                      
                                      <input required min="0" type="text" id="onlyNumbersInput" class="form-control" name="N<?= $no ?>[]" value="<?php if(isset($NilaiHarian[$Nilaike])){echo $NilaiHarian[$Nilaike]; }?>">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td> 
                          <?php $Nilaike++; } ?>
                          </tr>
                      </table>
                    <?php } ?>
                    </td>
                    
                    <td> 
                      <input type="hidden" name="<?= $no ?>[]" value="<?= $tb->NisSiswa ?>">
                      <input type="hidden" name="<?= $no ?>[]" value="<?= $_GET['KodeMapel'] ?>">
                      <input type="hidden" name="<?= $no ?>[]" value="<?= $_GET['IDSemester'] ?>">
                      <input type="hidden" name="<?= $no ?>[]" value="<?= $_GET['KodeTahun'] ?>">
                      <input type="hidden" name="<?= $no ?>[]" value="<?= $_GET['IDAjaran'] ?>">
                      <input type="hidden" name="<?= $no ?>[]" value="<?= $_GET['KodeKelas'] ?>">
                      <input type="hidden" name="<?= $no ?>[]" value="<?= $_GET['KodeGuru'] ?>">
                          <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                            <div class="form-group">
                              <div class="input-group">
                                <input min="0" required type="text" id="onlyNumbersInput" class="form-control" value="<?php if($datasiswanilai!==FALSE){foreach($datasiswanilai as $tb2){if($tb->NisSiswa===$tb2->NisSiswa && isset($tb2->NilaiUTS)){echo $tb2->NilaiUTS;}}} ?>" name="<?= $no ?>[]" placeholder="Nilai UTS...">
                              </div>
                            </div>
                          </div>
                        </div>
                    </td>
                    <td>
                      <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                            <div class="form-group">
                              <div class="input-group">
                                <input min="0" required type="text" id="onlyNumbersInput" class="form-control" value="<?php if ($datasiswanilai !== false) foreach ($datasiswanilai as $tb2) if ($tb->NisSiswa === $tb2->NisSiswa && isset($tb2->NilaiUAS)) echo $tb2->NilaiUAS; ?>" name="<?= $no ?>[]" placeholder="Nilai UAS...">
                              </div>
                            </div>
                          </div>
                        </div>
                    </td>
                    <td>
                      <?php if($datasiswanilai!==FALSE){
                        foreach($datasiswanilai as $tb2){
                          if($tb->NisSiswa===$tb2->NisSiswa && isset($tb2->NilaiHarian) && isset($tb2->NilaiUTS) && isset($tb2->NilaiUAS)){
                            $pisah=explode("//", $tb2->NilaiHarian);
                            $data_hitung=0;
                            for ($i=0; $i < count($pisah); $i++) { 
                              $data_hitung+=$pisah[$i];
                            }
                            $NilaiAkhir=((2*($data_hitung/count($pisah)))+$tb2->NilaiUTS+$tb2->NilaiUAS)/4;
                            echo round($NilaiAkhir);
                            ?>
                            <!-- <input type="hidden" value="<?= $NilaiAkhir ?>" name="<?= $no ?>[]"> -->
                            <?php
                          }
                        }
                      }
                       ?>
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
                    <th>Nilai Harian</th>
                    <th>Nilai UTS</th>
                    <th>Nilai UAS</th>
                    <th>Nilai Akhir</th>
                  </tr>
                  </tfoot>
                </table>

                <!-- Modal Peringatan Hapus Data -->

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
              </div>
            </form>
            </div>
            <!-- /.card -->

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <?php
  // print_r($AbsensiGuru);
  // print_r($AbsensiHadir);
  ?>