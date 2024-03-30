
  

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Nilai Siswa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><?= $this->session->userdata('NisSiswa'); ?></li>
              <li class="breadcrumb-item">Nilai</li>
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
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">
              <div class="background-effect">
                <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Menu Wali Kelas :</h3>
                        <div class="card-tools">
                          <div class="row mb-2">

                          </div>
                        </div>
                      </div>

                      <form action="<?= base_url('Wali_Halaman');?>/NilaiSiswa" method="POST">
                        <input type="hidden" name="CariData" value="DataNilai">
                        <!-- /.card-header -->
                          <div class="card-body">
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Tahun Ajaran :</label>
                                  <select name="IDAjaran" class="select2" data-placeholder="Pilih Tahun Ajaran" style="width: 100%;">
                                    <?php if ($DataTahunAjaran !==false) {
                                      foreach ($DataTahunAjaran as $DTJ) {
                                    ?>
                                    <option value="<?= $DTJ->IDAjaran ?>"><?= $DTJ->KodeAjaran ?></option>
                                    <?php }
                                    } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Semester :</label>
                                  <select name="IDSemester" class="select2" data-placeholder="Pilih Semester" style="width: 100%;">
                                    <?php if ($DataSemester !==false) {
                                      foreach ($DataSemester as $DS) {
                                    ?>
                                    <option value="<?= $DS->IDSemester ?>"><?= $DS->NamaSemester ?></option>
                                    <?php }
                                    } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                  <button type="submit" class="btn btn-block btn-primary">
                                    <i class="fas fa-search"></i> Cari Data
                                  </button>
                                </div>
                            </div>
                          </div>
                        <!-- /.card-body -->
                      </form>
                </div>
              </div>

            </div>
            <div class="col-md-8">
              <div class="background-effect">
                <div class="card card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">Tabel Kelas</h3>
                        <div class="card-tools">

                        </div>
                      </div>
                      <?php if (isset($TampilData) && $TampilData==true) {
                      ?>
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
                              <?php if ($tabelNilai !== false) {
                                $no = 0;
                                foreach ($tabelNilai as $tb) {
                                  $no++;
                              ?>
                                  <tr>
                                    <td align="center"><?= $no ?></td>
                                    <td align="center"><?= $tb->NamaMapelTBMapel ?></td>
                                    <td align="center"><?= $tb->NamaGuru ?></td>
                                    <td align="center">
                                      <input type="text" class='form-control' id="HanyaNomor" readonly name="NilaiAkhir" value="<?= $tb->NilaiAkhir ?>">
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

                      <?php } ?>
                    </div>
              </div>
            </div>
          </div>
              <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
      </div>
    <!-- /.content -->
    

  </div>
  <!-- /.content-wrapper -->
