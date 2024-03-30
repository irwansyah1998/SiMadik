<?php
$CekWaliKelas=false;
if (isset($datakelas) && is_array($datakelas) ) {
  $CekWaliKelas=true;
  foreach ($datakelas as $dk) {
    $KODEkelas=$dk->KodeKelas;
  }
}

// print_r($tabel);
?>
  

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <?php if($CekWaliKelas===true){ ?>
              <h1 class="m-0">Wali Kelas (Detail Nilai)</h1>
              <?php }else{?>
              <h1 class="m-0">Wali Kelas Belum Ditetapkan</h1>
              <?php } ?>
            </div><!-- /.col -->
            <div class="col-sm-6 animate__animated animate__fadeInRight">
              <ol class="breadcrumb float-sm-right">
                <?php if($CekWaliKelas===true){ ?>
                <li class="breadcrumb-item active">Kelas</li>
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
            document.addEventListener('input', function(event) {
              const target = event.target;
              if (target && target.id === 'TanpaSpasi') {
                const inputValue = target.value;
                const newValue = inputValue.replace(/[^\w\d]+/g, ''); // Menghapus semua spasi dan karakter khusus

                if (inputValue !== newValue) {
                  target.value = newValue;
                }
              }
            });
          </script>

          <script>
            document.addEventListener('input', function(event) {
              const target = event.target;
              if (target && target.id === 'HanyaNomor') {
                const inputValue = target.value;
                const newValue = inputValue.replace(/\D/g, ''); // Menghapus semua karakter selain angka

                if (inputValue !== newValue) {
                  target.value = newValue;
                }
              }
            });
          </script>
      <?php if($CekWaliKelas===true){ ?>
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <form class="col-md-12" action="<?php echo base_url('User_walikelas');?>/NilaiAkhir/Simpan/<?= $NisSiswa ?>" method="POST">
               
                <div class="card card-secondary shadow animate__animated animate__fadeInLeft">
                      <div class="card-header">
                        <h3 class="card-title">Tabel Kelas</h3>
                        <div class="card-tools">
                          <div class="btn-group">
                            <a href="<?= base_url('User_walikelas/WKNilai') ?>" class="btn  btn-secondary"><i class="fas fa-backward"></i> Kembali</a>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-header -->
                          <div class="card-body" style="overflow-x: auto;">
                            <table id="example8" class="table table-bordered table-striped">
                              <thead align="center">
                                <tr>
                                  <th width="5%">No</th>
                                  <th>Mata Pelajaran</th>
                                  <th>Guru Pengajar</th>
                                  <th>Nilai</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if ($tabel != false) {
                                  $no = 0;
                                  foreach ($tabel as $tb) {
                                    $no++;
                                ?>
                                    
                                    <tr>
                                      <td align="center"><?= $no ?></td>
                                      <td align="center"><?= $tb->NamaMapel; ?></td>
                                      <td align="center"><?= $tb->NamaGuru; ?></td>
                                      <td align="center">
                                        <?php if (isset($tb->NilaiAkhir) && $tb->NilaiAkhir!==null && $tb->NilaiAkhir>0) {
                                        ?>
                                        <input type="text" class='form-control' id="HanyaNomor" readonly name="<?= $tb->nilai_IDNilaiMapel ?>" value="<?= $tb->NilaiAkhir ?>">
                                        <?php }else{
                                        if ($tb->NilaiHarian!==null && $tb->NilaiUTS!==null && $tb->NilaiUAS!==null) {
                                            $NilaiAkhir=(($tb->NilaiHarian*2)+$tb->NilaiUTS+$tb->NilaiUAS)/4;
                                            ?>
                                            <input type="text" class='form-control' id="HanyaNomor" name="<?= $tb->nilai_IDNilaiMapel ?>" readonly value="<?= round($NilaiAkhir) ?>">
                                            <?php
                                          }  ?>

                                        <?php } ?>
                                      </td>
                                        
                                      
                                    </tr>
                                <?php
                                  }
                                }
                                ?>
                              </tbody>
                            </table>

                          </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-primary">
                                                    <i class="fas fa-save"></i> Simpan Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                      </div>

                </div>

              </form>
            </div>
          </div>
              <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
      <?php }?>
    </div>
    <div class="bright-overlay"></div>
  </div>
  <!-- /.content-wrapper -->
