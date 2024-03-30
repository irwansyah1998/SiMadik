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
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <?php if($CekWaliKelas===true){ ?>
              <h1 class="m-0">Wali Kelas (Pelanggaran)</h1>
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
          <div class="row">
            <div class="col-md-3">
              
              <div class="card card-primary shadow animate__animated animate__fadeInLeft">
                    <div class="card-header">
                      <h3 class="card-title">Menu Wali Kelas :</h3>
                      <div class="card-tools">
                        <div class="row mb-2">

                      </div>
                    </div>
                  </div>

                    <?= form_open(base_url('User_walikelas/WKPelanggaran'), array('method' => 'post')); ?>
                      <input type="hidden" name="CariKelas" value="WaliKelas">
                      <!-- /.card-header -->
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label>Kelas :</label>
                                <select name="IDKelas" class="select2" data-placeholder="Pilih Kelas" style="width: 100%;">
                                  <?php 
                                  $selectedIDKelas = $this->input->post('IDKelas'); // Simpan nilai dari input post ke dalam variabel

                                  foreach ($DataKelasByWaliKelas as $data) {
                                      $selected = ($selectedIDKelas && $selectedIDKelas == $data->IDKelas) ? 'selected' : ''; // Tentukan apakah opsi harus dipilih

                                      // Tampilkan opsi dengan menambahkan atribut 'selected' jika diperlukan
                                      ?>
                                      <option <?php echo $selected; ?> value="<?php echo $data->IDKelas; ?>">
                                          <?php echo $data->KodeKelas; ?>
                                      </option>
                                  <?php } ?>
                              </select>
                                <!-- <button type="button" class="btn btn-success addMapel">Tambah Mata Pelajaran</button> -->
                              </div>
                            </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                <button type="submit" class="btn btn-block btn-primary">
                                  <i class="fas fa-search"></i> Lihat Data
                                </button>
                              </div>
                          </div>
                        </div>
                      <!-- /.card-body -->
                    <?= form_close(); ?>
                  </div>

            </div>
            <div class="col-md-9">
              
              <div class="card card-secondary shadow animate__animated animate__fadeInRight">
                  <div class="card-header">
                      <h3 class="card-title">Tabel Kelas</h3>
                      <div class="card-tools">
                      </div>
                  </div>
                    <?php if (isset($TampilData) && $TampilData==true) {
                    ?>
                    <!-- /.card-header -->
                        <div class="card-body">
                          <div class="row">
                              <div class="col-md-12">
                                  <table id="example3" class="table table-bordered table-striped">
                                    <thead>
                                      <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NisSiswa</th>
                                        <th>Jumlah Poin</th>
                                        <th>Pengaturan</th>
                                      </tr>
                                    </thead>

                                    <tbody>
                                      <?php
                                      if ($DataPelanggaran!==false) {
                                        $no=0;
                                        foreach ($DataPelanggaran as $DP) {
                                        $no++;
                                        ?>
                                        <tr>
                                          <td><?=$no?></td>
                                          <td><?=$DP->NamaSiswa?></td>
                                          <td><?=$DP->NisSiswa?></td>
                                          <td><?php if($DP->TotalPoin==null){echo "0";}else{echo $DP->TotalPoin;}?> Poin</td>
                                          <td>
                                            <div class="btn-group">
                                              <a href="<?= base_url('User_walikelas/WKPelanggaran/Detail/'.$DP->NisSiswa) ?>" class="btn btn-secondary"><i class="fas fa-list"></i> Detail</a>
                                            </div>
                                          </td>
                                        </tr>
                                        <?php
                                        }
                                      }
                                      ?>
                                    </tbody>

                                    <tfoot>
                                      <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NisSiswa</th>
                                        <th>Jumlah Poin</th>
                                        <th>Pengaturan</th>
                                      </tr>
                                    </tfoot>
                                  </table>
                              </div>
                          </div>

                        </div>
                    <!-- /.card-body -->

                    <?php } ?>
              </div>

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
