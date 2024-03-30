
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Guru Mengajar</h1>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Informasi Akun</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <!-- /.row -->
        <div class="row">
          <div class="col-md-3">
          <form class="col-md-12" action="<?= base_url('User_admin/JadwalGuruMengajar') ?>" method="POST">
            <input type="hidden" name="CariData" value="Jadwal">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Pilih Data Guru:</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                    <div class="card-body">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Pilih Guru :</label>
                              <div class="input-group">
                                <select class="form-control select2" name="IDGuru" style="width: 100%;">
                                  <option value="">Pilih Guru</option>
                                  <?php
                                  if ($TabelGuru!==false) {
                                    foreach ($TabelGuru as $TG) {?>
                                  <option <?php if(isset($_POST['IDGuru']) && $_POST['IDGuru']==$TG->IDGuru){echo "selected";}?> value="<?= $TG->IDGuru ?>"><?= $TG->NamaGuru ?> (<?= $TG->NomorIndukGuru ?>)</option>
                                  <?php }
                                  }
                                  ?>
                                </select>
                              </div>
                              <!-- /.input group -->
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Pilih Mata Pelajaran :</label>
                              <div class="input-group">
                                <select class="form-control select2" name="IDMaPel" style="width: 100%;">
                                  
                                </select>
                              </div>
                              <!-- /.input group -->
                            </div>
                          </div>
                          <!-- /.col -->
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Pilih Hari :</label>
                              <div class="input-group">
                                <select class="form-control select2" name="IDHari" style="width: 100%;">
                                  <?php
                                  if ($TabelHari!==false) {
                                    foreach ($TabelHari as $TH) { ?>
                                      <option <?php if(isset($_POST['IDHari']) && $_POST['IDHari']==$TH->IDHari){echo "selected";}?> value="<?=$TH->IDHari?>"><?=$TH->NamaHari?></option>
                                  <?php }
                                  }
                                  ?>
                                </select>
                              </div>
                              <!-- /.input group -->
                            </div>
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                  <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="btn-group col-md-12">
                        <button style="width: 100%" type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari Data</button>
                      </div>
                    </div>
          </form>
          </div>
            <!-- /.card -->

            <!-- general form elements -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Keterangan Jam Pelajaran:</h3>
          
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <?php
                        if (isset($DataJadwal) && $DataJadwal=='Ada') { ?>
                        <table id="example9" class="table table-bordered">
                          <thead>
                            <tr>
                              <th>Jam Ke-</th>
                              <th>Jam Pelajaran</th>
                            </tr>
                          </thead>
                            <?php if ($JadwalJamPelajaran!==false) {
                              $no=0;
                              foreach ($JadwalJamPelajaran as $JJP) { $no++;
                              ?>
                              <tr>
                                <td><?=$no?></td>
                                <td><?=$JJP->MulaiJampel?>~<?=$JJP->AkhirJampel?></td>
                              </tr>
                            <?php
                              }
                            } ?>
                            
                        </table>
                        <?php } ?>
                      </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
              
                <div class="card-footer">
                </div>
            </div>
            <!-- /.card -->

          </div>

          <div class="col-md-9">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tabel Jadwal :</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
              if (isset($DataJadwal) && $DataJadwal=='Ada') { ?>
              
                  <form method="POST" class="col-md-12" action="<?= base_url('User_admin/')?>JadwalGuruMengajarCRUD">
                    <div class="card-body">
                      <input type="hidden" name="IDGuru" value="<?=$IDGuru?>">
                      <input type="hidden" name="IDMaPel" value="<?=$IDMaPel?>">
                      <div class="row">
                        <div class="col-6">
                          <h5>Nomor Induk Guru </h5>
                        </div>
                        <div class="col-6">
                          <h5><b><?= $NomorIndukGuru ?></b></h5>
                        </div>
                        <!-- /.col -->
                      </div>

                      <div class="row">
                        <div class="col-6">
                          <h5>Nama Guru</h5>
                        </div>
                        <div class="col-6">
                          <h5><b><?= $NamaGuru ?></b></h5>
                        </div>
                        <!-- /.col -->
                      </div>

                      <div class="row">
                        <div class="col-6">
                          <h5>Mata Pelajaran</h5>
                        </div>
                        <div class="col-6">
                          <h5><b><?= $NamaMaPel ?></b></h5>
                        </div>
                        <!-- /.col -->
                      </div>

                      <div class="row">
                        <div class="col-12">
                          <?php if ($JadwalMapelGuru==false) {
                            ?><h5 class="btn btn-danger" style="width: 100%">Jadwal Tidak Tersedia</h5><?php
                          } ?>
                        </div>
                        <!-- /.col -->
                      </div>
                      <?php if ($JadwalMapelGuru!==false) {?>
                      <div class="row">
                        <div class="col-12">
                          <?php
                          $kelas1 = array();
                          $jams = array();
                          $no=0;
                          foreach ($JadwalMapelGuru as $JMG) {
                            $kelas1[$no]=$JMG->kelas_KodeKelas;
                            $no++;
                          }
                          if ($JadwalJamPelajaran!==false) {
                            $no=0;
                            $jamke=1;
                            foreach ($JadwalJamPelajaran as $JJP) {
                              $jams[$no]=$jamke;
                              $IDJamPel[$no]=$JJP->IDJamPel;
                              $no++; $jamke++;
                            }
                          }

                          ?>
              						<table id="example10" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Jam\Kelas</th>
                                    <?php
                                    // Loop untuk membuat header kolom dengan kelas dari 7A hingga 7G
                                    foreach ($kelas1 as $kelasColumn) {
                                        echo "<th>$kelasColumn</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop untuk membuat header baris dengan jam dari 07.00~08.00 hingga 13.00~14.00
                                $a=0;
                                foreach ($jams as $jam) {
                                    echo "<tr>";
                                    echo "<td>$jam</td>";
                                    // Loop untuk mengisi sel-sel dengan konten yang sesuai
                                    foreach ($kelas1 as $kelasRow) {
                                        // Di sini Anda dapat menambahkan logika untuk mengisi sel dengan data sesuai kebutuhan
                                        echo '<td><input data-kelas="IDKelas" name="'.$IDJamPel[$a].'" type="radio" class="kelas-checkbox" value="'.$kelasRow.'"></td>';
                                    }
                                    $a++;
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>


                        </div>
                        <!-- /.col -->
                      </div>
                      <?php } ?>
                      <!-- /.row -->
                    </div>
                <!-- /.card-body -->

                    <?php } ?>
                      <div class="card-footer">
                      <?php if (isset($DataJadwal) && $DataJadwal=='Ada') { ?>
                        <?php if ($JadwalMapelGuru!==false) {?>
                        <div class="btn-group col-md-12">
                          <button style="width: 100%" type="submit" class="btn btn-primary"><i class="fas fa-save fa-lg"></i> Simpan Data</button>
                        </div>
                        <?php } ?>
                      <?php } ?>
                      </div>
                  </form>
            </div>
            <!-- /.card -->

          </div>

        </div>

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript">
  $(document).ready(function() {
    var DataMapelGuru = <?= json_encode($DataMapelGuru) ?>;

    // Pilih elemen <select> pertama
    var selectGuru = $('select[name="IDGuru"]');
  
    // Pilih elemen <select> kedua
    var selectMapel = $('select[name="IDMaPel"]');
  
    // Atur event listener untuk perubahan pada <select> pertama
    selectGuru.on('change', function() {
      var selectedGuruId = $(this).val();
    
      // Hapus semua opsi pada <select> kedua
      selectMapel.empty();
    
      // Tambahkan opsi sesuai dengan pilihan pada <select> pertama
      for (var i = 0; i < DataMapelGuru.length; i++) {
        if (DataMapelGuru[i].IDGuru == selectedGuruId) {
          selectMapel.append($('<option>', {
            value: DataMapelGuru[i].IDMapel,
            text: DataMapelGuru[i].NamaMapel
          }));
        }
      }
    });

    // Memanggil event listener secara otomatis saat halaman dimuat
    selectGuru.trigger('change');
  });
</script>

