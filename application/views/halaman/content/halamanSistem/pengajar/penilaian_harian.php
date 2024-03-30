<?php
  if (isset($KelasMapel)&&$KelasMapel!==false) {
    foreach ($KelasMapel as $KMPN) {
     $IDKelasMapel=$KMPN->IDKelasMapel;
    }
  }
  // print_r($KelasMapel);
?>
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


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Penilaian <?=$NamaMapel?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6 animate__animated animate__fadeInRight">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"><?=$NamaMapel?></li>
                <li class="breadcrumb-item">Penilaian</li>
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
                  <div class="col-md-3">


                      <div class="card card-warning shadow animate__animated animate__fadeInLeft">
                        <div class="card-header">
                          <h3 class="card-title">Nilai Harian</h3>
                          <div class="card-tools">
                                
                          </div>
                        </div>

                        <div class="card-body">
                          <?php if (isset($TampilkanData) && $TampilkanData==TRUE) {?>
                          <form id="dynamicForm" action="<?= base_url('User_pengajar');?>/PenilaianHarian" method="GET">
                              <input type="hidden" name="InsertNilaiHarian" value="Tambah">
                              <input type="hidden" name="IDTahun" value="<?= $_GET['IDTahun'] ?>">
                              <input type="hidden" name="KodeKelas" value="<?= $_GET['KodeKelas'] ?>">
                              <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
                              <div id="formContainer">
                                  <!-- Initial form template is removed -->
                                  <?php
                                  if ($NilaiHari!==false) {
                                    foreach ($NilaiHari as $NH) {
                                    ?>

                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="nilai_harian">Nama Nilai Harian</label>
                                      <input type="hidden" class="form-control" name="IDNilaiHari[]" value="<?= $NH->IDNilaiHari ?>">
                                      <input type="text" class="form-control" name="NamaNilai[]" value="<?= $NH->NamaNilai ?>" required="">
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="KodeNilai">Kode Nilai Harian</label>
                                      <input type="text" id="TanpaSpasi" class="form-control" name="KodeNilai[]" value="<?= $NH->KodeNilai ?>" required="">
                                    </div>
                                  </div>
                                  <div class="col-sm-12">
                                    <div class="form-group">
                                      <label for="keterangan">Keterangan</label>
                                      <input type="text" class="form-control" name="Keterangan[]" value="<?= $NH->Keterangan ?>" required="">
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#HapusNew<?= $NH->IDNilaiHari ?>">Remove</button>
                                  </div>
                                </div>

                                    <?php
                                    }
                                  }
                                  ?>
                              </div>
                              <br>
                              <div class="row">
                                  <div class="col-8">
                                      <div class="row">
                                          <div class="col-12">
                                              <button type="submit" class="col-12 btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-4">
                                      <div class="row">
                                          <div class="col-12">
                                              <button type="button" id="addFieldButton" class="col-12 btn btn-primary"><i class="fas fa-plus-square"></i> Form</button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </form>
                        <?php } ?>
                        </div>

                      </div>


                  </div>

                  <div class="col-md-9">
                      <div class="card card-secondary shadow card-outline direct-chat direct-chat-secondary animate__animated animate__fadeInRight">
                          <div class="card-header">
                              <h2 class="card-title m-0">Form Penilaian :</h2>
                              <?php if (isset($TampilkanData) && $TampilkanData==TRUE): ?>
                              <div class="card-tools">
                                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#EditNilai">
                                  <i class="fas fa-backward"></i> Kembali
                                </button>
                              </div>
                              <?php endif ?>
                          </div>
                              <div class="card-body col-md-12" style="overflow-x: auto;">
                                <?php if ($datakelas==false): ?>
                                  <div class="row">
                                    <div class="col-md-12 text-center">
                                      <h3 class="btn btn-danger col-md-12">Data Belum Tersedia</h3>
                                    </div>
                                  </div>
                                <?php endif ?>
                                <?php if (isset($TampilkanData) && $TampilkanData==TRUE) {?>
                                <form class="col-md-12" action="<?php echo base_url('User_pengajar');?>/PenilaianHarian" method="GET">
                                  
                                  <input type="hidden" name="NilaiKelasHarian" value="Masuk">
                                  <input type="hidden" name="IDTahun" value="<?= $_GET['IDTahun'] ?>">
                                  <input type="hidden" name="KodeKelas" value="<?= $_GET['KodeKelas'] ?>">
                                  <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
                                  <div class="row">
                                    <div class="col-md-4 text-left">
                                      <h5>Data Kelas <?= $_GET['KodeKelas'] ?></h5>
                                    </div>
                                    <div class="col-md-4 text-center">
                                      <h5><?= $KodeAjaran ?></h5>
                                    </div>
                                    <div class="col-md-4 text-right">
                                      <h5><?= $NamaSemester ?></h5>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <table class="table table-bordered table-striped">
                                        <thead align="center">
                                        <tr>
                                          <th width="5%">No</th>
                                          <th>Nama Siswa</th>
                                          <?php
                                            if (isset($NilaiHari)&&$NilaiHari!==false) {
                                              foreach ($NilaiHari as $NH) {?>
                                          <th><?= $NH->NamaNilai ?></th>
                                          <?php }
                                            }
                                          ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <?php if (isset($DataSiswa)&&$DataSiswa != false) {
                                          $no = 0;
                                          foreach ($DataSiswa as $tb) {
                                          $no++; ?>
                                          <tr>
                                            <td><?php echo $no; ?></td>
                                            <td>
                                              <?php echo $tb->NamaSiswa; ?>
                                              <input type="hidden" name="NisSiswa[]" value="<?= $tb->NisSiswa ?>">
                                            </td>
                                              <?php
                                              $Hitung=0;
                                              $Col=12;
                                              if (isset($NilaiHari)&&$NilaiHari!==false) {
                                                foreach ($NilaiHari as $Cek) {
                                                  $Hitung++;
                                                }
                                                $Col=round(12/$Hitung);
                                              }
                                              ?>
                                              <?php
                                              if (isset($NilaiHari)&&$NilaiHari!==false) {
                                              foreach ($NilaiHari as $NH) {?>
                                            <td>
                                              
                                              <div class="row">
                                                <div class="col-md-12">
                                                  <div class="form-group">
                                                    <input type="text" id="HanyaNomor" class="form-control" name="<?= $NH->IDNilaiHari ?>[]" <?php
                                              if (isset($KelasMapelNilaiSiswa)&&$KelasMapelNilaiSiswa!==false) {
                                               foreach ($KelasMapelNilaiSiswa as $KMNS) {
                                                if ($KMNS->NisSiswa==$tb->NisSiswa && $KMNS->IDNilaiHari==$NH->IDNilaiHari) {
                                                  ?>value="<?= $KMNS->Nilai ?>"<?php
                                                }
                                              }
                                            }else{
                                              ?>value="0"<?php
                                            } ?> >
                                                  </div>
                                                </div>
                                              </div>
                                            </td>
                                              <?php }
                                              }
                                              ?>
                                            </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                      </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12 text-right">
                                      <button type="submit" class=" btn btn-primary"><i class="fas fa-save"></i> Simpan Nilai</button>
                                    </div>
                                  </div>
                                </form>
                                <?php } ?>

                              </div>
                          </div>
                      </div>
              </div>
              <!-- ROW -->
          <!-- /.container-fluid -->
          </div>

      </div>
      <!-- /.card -->
    </div>
    <div class="bright-overlay"></div>
  </div>
      <!-- /.container-fluid -->
    <!-- /.content -->
<?php if (isset($TampilkanData) && $TampilkanData==TRUE) {?>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="EditNilai" tabindex="-1" role="dialog" aria-labelledby="HapusNewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form action="<?= base_url('User_pengajar');?>/Penilaian" method="POST" class="col-md-12">
          <input type="hidden" name="CariData" value="Kelas">
          <input type="hidden" name="IDTahun" value="<?= $_GET['IDTahun'] ?>">
          <input type="hidden" name="KodeKelas" value="<?= $_GET['KodeKelas'] ?>">
          <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="HapusNewLabel">Kembali Ke halaman Sebelumnya?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Pastika semua data telah disimpan dan mengecek kembali data yang telah disimpan untuk menghindari kesalahan data.</p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Lanjutkan</button>
          </div>

        </form>
      </div>
    </div>
  </div>
<?php } ?>
  <!-- Modal untuk Peringatan -->
  <?php
  if (isset($NilaiHari)&&$NilaiHari!==false) {
    foreach ($NilaiHari as $NH) {
    ?>
  <div class="modal fade" id="HapusNew<?= $NH->IDNilaiHari ?>" tabindex="-1" role="dialog" aria-labelledby="HapusNewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="<?= base_url('User_pengajar');?>/PenilaianHarian" method="GET" class="col-md-12">
          <input type="hidden" name="IDTahun" value="<?= $_GET['IDTahun'] ?>">
          <input type="hidden" name="KodeKelas" value="<?= $_GET['KodeKelas'] ?>">
          <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
          <input type="hidden" name="IDNilaiHari" value="<?= $NH->IDNilaiHari ?>">
          <input type="hidden" name="NilaiKelasHarian" value="Hapus">
          <div class="modal-header">
            <h5 class="modal-title" id="HapusNewLabel">Peringatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Apakah Anda yakin ingin menghapus data Nilai Harian dengan data <?= $NH->NamaNilai ?>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Tetap Hapus</button>
          </div>

        </form>
      </div>
    </div>
  </div>
  <?php
    }
  }
  ?>

  <script type="text/javascript">
  $(document).ready(function() {
  var dataTahun = <?= json_encode($datatahun) ?>;
  var dataKelas = <?= json_encode($datakelas) ?>;

  // Populate Tahun Dropdown
    var tahunDropdown = $("#tahun");
    $.each(dataTahun, function(index, item) {
        tahunDropdown.append($('<option>', {
            value: item.IDTahun,
            text: item.PenyebutanTahun
        }));
    });

    // Handle Tahun Dropdown Change Event
    tahunDropdown.change(function() {
        var selectedIDTahun = $(this).val();

        // Filter Kelas based on selected Tahun
        var filteredKelas = dataKelas.filter(function(kelas) {
            return kelas.IDTahun === selectedIDTahun;
        });

        // Populate Kelas Dropdown
        var kelasDropdown = $("#kelas");
        kelasDropdown.empty().append($('<option>', {
            value: "",
            text: "Pilih Kelas"
        }));
        $.each(filteredKelas, function(index, item) {
            kelasDropdown.append($('<option>', {
                value: item.KodeKelas,
                text: item.KodeKelas
            }));
        });
    });

    // Handle Kelas Dropdown Change Event
    // $("#kelas").change(function() {
    //     var selectedKelasID = $(this).val();

    //     // Filter Siswa based on selected Kelas
    //     var filteredSiswa = dataSiswa.filter(function(siswa) {
    //         return siswa.IDKelas === selectedKelasID;
    //     });

    //     // Populate Siswa Dropdown
    //     var siswaDropdown = $("#siswa");
    //     siswaDropdown.empty().append($('<option>', {
    //         value: "",
    //         text: "Pilih Siswa"
    //     }));
    //     $.each(filteredSiswa, function(index, item) {
    //         siswaDropdown.append($('<option>', {
    //             value: item.IDSiswa,
    //             text: item.NamaSiswa
    //         }));
    //     });
    // });
});
</script>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- Pastikan Anda menyertakan jQuery -->

<script>
    $(document).ready(function () {
        const formContainer = $("#formContainer");
        const addFieldButton = $("#addFieldButton");

        addFieldButton.on("click", function () {
            // Buat elemen row baru
            const row = $("<div class='row'></div>");

            // Buat elemen col-sm-6 untuk Nama Nilai Harian
            const col1 = $("<div class='col-sm-6'></div>");

            const formGroup1 = $("<div class='form-group'></div>");

            const label1 = $("<label for='NamaNilai'>Nama Nilai Harian</label>");

            const hiddenInput1 = $("<input type='hidden' class='form-control' name='IDNilaiHari[]' value='na'>");
            const input1 = $("<input type='text' class='form-control' name='NamaNilai[]' value='' required>");

            formGroup1.append(label1);
            formGroup1.append(hiddenInput1);
            formGroup1.append(input1);
            col1.append(formGroup1);

            // Buat elemen col-sm-6 untuk Kode Nilai Harian
            const col2 = $("<div class='col-sm-6'></div>");

            const formGroup2 = $("<div class='form-group'></div>");

            const label2 = $("<label for='KodeNilai'>Kode Nilai Harian</label>");

            const input2 = $("<input type='text' id='TanpaSpasi' class='form-control' name='KodeNilai[]' value='' required' id='noSpaceInput'>");

            formGroup2.append(label2);
            formGroup2.append(input2);
            col2.append(formGroup2);

            // Tambahkan col-sm-6 untuk Nama Nilai Harian dan col-sm-6 untuk Kode Nilai Harian ke dalam row
            row.append(col1);
            row.append(col2);

            // Buat elemen col-sm-12 untuk Keterangan
            const col3 = $("<div class='col-sm-12'></div>");

            const formGroup3 = $("<div class='form-group'></div>");

            const label3 = $("<label for='keterangan'>Keterangan</label>");

            const input3 = $("<input type='text' class='form-control' name='Keterangan[]' value='' required>");

            formGroup3.append(label3);
            formGroup3.append(input3);
            col3.append(formGroup3);

            // Tambahkan col-sm-12 untuk Keterangan ke dalam row
            row.append(col3);

            // Buat elemen col-12 untuk tombol "Remove"
            const col4 = $("<div class='col-12'></div>");

            const removeFieldButton = $("<button type='button' class='removeFieldButton btn btn-danger'>Remove</button>");

            col4.append(removeFieldButton);

            // Tambahkan col-12 untuk tombol "Remove" ke dalam row
            row.append(col4);

            // Tambahkan row ke dalam formContainer
            formContainer.append(row);
        });

        // Tambahkan event listener untuk tombol "Remove" dengan event delegation
        formContainer.on("click", ".removeFieldButton", function () {
            $(this).closest(".row").remove();
        });
    });
</script>