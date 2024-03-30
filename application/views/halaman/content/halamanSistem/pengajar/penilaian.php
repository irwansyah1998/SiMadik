
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
                      <div class="card card-primary shadow animate__animated animate__fadeInLeft">
                          <div class="card-header">
                              <h2 class="card-title m-0">Cari Siswa :</h2>
                              
                          </div>

                          <!-- /.card-header -->
                          <div class="card-body">
                              <?= form_open(base_url('User_pengajar/Penilaian'), 'post'); ?>

                                  
                                  <input type="hidden" name="CariData" value="Kelas">
                                  <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label>Cari Tingkatan:</label>
                                                  <select required class="form-control select2" name="IDTahun" style="width: 100%;" id="tahun">
                                                      <option value="">Pilih Tingkatan</option>
                                                  </select>
                                              </div>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label>Cari Kelas:</label>
                                                  <select required class="form-control select2" name="KodeKelas" style="width: 100%;" id="kelas">
                                                  </select>
                                              </div>
                                          </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <button type="submit" class="btn btn-block btn-primary">
                                                  <i class="fas fa-search"></i> Cari Data
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                                  
                              <?= form_close(); ?>
                          </div>
                          <!-- /.card-body -->
                      </div>


                  </div>

                  <div class="col-md-9">
                      <div class="card card-secondary shadow animate__animated animate__fadeInRight">
                          <div class="card-header">
                              <?php if (isset($TampilkanData) && $TampilkanData==TRUE): ?>
                              <div class="card-tools">
                                <div class="btn-group shadow">

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-edit"></i> Nilai
                                        </button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#EditNilai">
                                                <i class="fas fa-edit"></i> Edit Nilai Harian
                                            </button>
                                            <a class="dropdown-item" href="<?= base_url('User_pengajar/PenilaianExcell?KodeKelas='.$this->input->post('KodeKelas')) ?>" style="color: black;">
                                                <i class="fas fa-cloud-download-alt"></i> Download Nilai (.xlsx)
                                            </a>
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#UploadNilai">
                                                <i class="fas fa-cloud-upload-alt" style="color: black;"></i> Upload Nilai (.xlsx)
                                            </button>
                                           
                                        </div>
                                    </div>

                                    <!-- <a class="btn btn-info" href="#">
                                        <i class="fas fa-file-export"></i> R.D.M.
                                    </a> -->
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#KonfirmasiNilai">
                                      <i class="fas fa-paper-plane"></i> Kirim Nilai
                                    </button>
                                </div>
                            </div>

                              <?php endif ?>
                          </div>
                            <div class="card-body col-md-12">
                              <?php if ($datakelas==false): ?>
                                <div class="row">
                                  <div class="col-md-12 text-center">
                                    <h3 class="btn btn-danger col-md-12">Data Belum Tersedia</h3>
                                  </div>
                                </div>
                              <?php endif ?>
                              <?php if (isset($TampilkanData) && $TampilkanData==TRUE) {?>
                              <?= form_open(base_url('User_pengajar/Penilaian'), 'post'); ?>
                              
                                <input type="hidden" name="InsertNilaiKelas" value="Masuk">
                                <input type="hidden" name="IDTahun" value="<?= $this->input->post('IDTahun') ?>">
                                <input type="hidden" name="KodeKelas" value="<?= $this->input->post('KodeKelas') ?>">
                                <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
                                <div class="row">
                                  <div class="col-md-4 text-left">
                                    <h5>Data Kelas <?= $this->input->post('KodeKelas') ?></h5>
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
                                    <?php
                                    
                                      if (isset($NilaiHari)&&$NilaiHari!==false) {
                                        $JumlahData=0;
                                      foreach ($NilaiHari as $NH)
                                      $JumlahData++;
                                      
                                      }
                                    ?>
                                    <table id="example10" class="table table-bordered table-striped">
                                          <thead align="center">
                                            <tr>
                                              <th rowspan="2" width="5%">No</th>
                                              <th rowspan="2">Nama Siswa</th>
                                              <th colspan="<?php if(isset($JumlahData)){echo $JumlahData+3;}else{echo 3;} ?>">Nilai</th>
                                              
                                            </tr>
                                            <tr>
                                              <?php
                                                if (isset($NilaiHari)&&$NilaiHari!==false) {
                                                  foreach ($NilaiHari as $NH) {?>
                                              <th><?= $NH->KodeNilai ?></th>
                                              <?php }
                                                }
                                                ?>
                                              <th>UTS</th>
                                              <th>UAS</th>
                                              <th>NA</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          <?php if ($DataSiswa != false) {
                                          $no = 0;
                                          foreach ($DataSiswa as $tb) {
                                            $JmlhNilaiHarian=0;
                                            $JlmhNilaiUTS=0;
                                            $JlmhNilaiUAS=0;
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
                                              <?php
                                              if (isset($KelasMapelNilaiSiswa)&&$KelasMapelNilaiSiswa!==false) {
                                               foreach ($KelasMapelNilaiSiswa as $KMNS) {
                                                if ($KMNS->NisSiswa==$tb->NisSiswa && $KMNS->IDNilaiHari==$NH->IDNilaiHari) {
                                                  $NilaiHariSiswa=$KMNS->Nilai;
                                                }
                                              }
                                            }else{
                                              $NilaiHariSiswa=0;
                                            }
                                            $JmlhNilaiHarian+=$NilaiHariSiswa;
                                            ?>
                                              <div class="row">
                                                <div class="col-md-12">
                                                  <div class="form-group">
                                                    <input readonly type="text" id="HanyaNomor" class="form-control" value="<?= $NilaiHariSiswa ?>">
                                                  </div>
                                                </div>
                                              </div>
                                            </td>
                                              <?php }
                                              }
                                              ?>
                                              <td>
                                                <?php if (isset($NilaiMapelSiswa) && $NilaiMapelSiswa!==false) {
                                                  foreach ($NilaiMapelSiswa as $NMS) {
                                                    if ($tb->NisSiswa==$NMS->NisSiswa) {
                                                      $nilaiUTS=$NMS->NilaiUTS;
                                                    }
                                                  }
                                                }else{
                                                  $nilaiUTS=0;
                                                }
                                                $JlmhNilaiUTS=$nilaiUTS;
                                                ?>
                                                <input type='text' id="HanyaNomor" class='form-control' name='nilaiUTS[]' min="0" required value='<?= $nilaiUTS ?>'></td>
                                              <td>
                                                <?php if (isset($NilaiMapelSiswa) && $NilaiMapelSiswa!==false) {
                                                  foreach ($NilaiMapelSiswa as $NMS) {
                                                    if ($tb->NisSiswa==$NMS->NisSiswa) {
                                                      $nilaiUAS=$NMS->NilaiUAS;
                                                    }
                                                  }
                                                }else{
                                                      $nilaiUAS=0;
                                                }
                                                  $JlmhNilaiUAS=$nilaiUAS;
                                                ?>
                                                <input type='text' id="HanyaNomor" class='form-control' name='nilaiUAS[]' min="0" required value='<?= $nilaiUAS ?>'>
                                              </td>
                                              <td>
                                                <?php if (isset($NilaiHari)&&$NilaiHari!==false){
                                                  $NilaiAkhir=((($JmlhNilaiHarian/$Hitung)*2)+$JlmhNilaiUTS+$JlmhNilaiUAS)/4;
                                                }else{
                                                  $NilaiAkhir=0;
                                                }?>
                                                <input type="hidden" name="NilaiHari[]" <?php if($Hitung>0){ ?>value="<?=$JmlhNilaiHarian/$Hitung?>"<?php }?> >
                                                <p class='form-control'><?= round($NilaiAkhir) ?></p> </td>
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
                              <?= form_close(); ?>
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
        <form action="<?= base_url('User_pengajar');?>/PenilaianHarian" method="GET" class="col-md-12">
          <input type="hidden" name="IDTahun" value="<?= $this->input->post('IDTahun') ?>">
          <input type="hidden" name="KodeKelas" value="<?= $this->input->post('KodeKelas') ?>">
          <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
          <input type="hidden" name="CariData" value="NilaiHari">
          <div class="modal-header">
            <h5 class="modal-title" id="HapusNewLabel">Pengimputan Nilai Harian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Anda akan diarahkan ke halaman selanjutnya untuk memasukkan nilai harian.<br>Anda dapat menambah mengurangi dan memperbarui nilai harian di halaman tersebut.<br><i>Catatan : Harap isi data dengan benar!</i></p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Lanjutkan</button>
          </div>

        </form>
      </div>
    </div>
  </div>

<div class="modal fade" id="UploadNilai" tabindex="-1" role="dialog" aria-labelledby="UploadingNilai" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="UploadingNilai"><i class="fas fa-cloud-upload-alt"></i> Upload Nilai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Pastikan File yang di-upload sesuai dengan format yang telah ditentukan oleh sistem!</p>
                    <table id="example12" class="table">
                        <thead align="center">
                            <tr>
                                <th>File</th>
                                <th>Nilai Harian</th>
                                <th>Siswa</th>
                                <th>Kode Kelas</th>
                                <th>Belum Terisi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <tr>
                              <td id="NamaFile">
                                <label class="btn-xs btn-success col fileinput-button" for="customFileInput">
                                    <i class="fas fa-file"></i>
                                    <span id="fileLabel">Unggah File</span>
                                </label>
                                <input type="file" class="custom-file-input" id="customFileInput" style="display: none;" accept=".xls, .xlsx">
                              </td>
                              <td id="JumlahNilaiHarian"></td>
                              <td id="JumlahSiswa"></td>
                              <td id="KKelas"></td>
                              <td id="Kosong"></td>
                              <td id="StatusUpload"></td>
                              <td id="Keterangan"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                  <?= form_open(base_url('User_pengajar/Penilaian'), 'post'); ?>
                    <input type="hidden" name="IDTahun" value="<?= $this->input->post('IDTahun') ?>">
                    <input type="hidden" name="KodeKelas" value="<?= $this->input->post('KodeKelas') ?>">
                    <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
                    <input type="hidden" name="SecretPath" id="SecretPath" value="">
                    <button type="submit" class="btn btn-primary" id="BtnLanjutkan" disabled="">Lanjutkan</button>
                  <?= form_close(); ?>
                </div>
        </div>
    </div>
</div>


<div class="modal fade" id="KonfirmasiNilai" tabindex="-1" role="dialog" aria-labelledby="ConfirmNilai" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="ConfirmNilai"><i class="fas fa-paper-plane"></i> Kirim Nilai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                                         
                                              <?php
                                                if (isset($NilaiHari)&&$NilaiHari!==false) {
                                                  foreach ($NilaiHari as $NH) {?>
                                              
                                              <?php }
                                                }
                                                ?>
                                              
                                          <tbody>
                                          <?php if ($DataSiswa != false) {
                                          $no = 0;
                                          foreach ($DataSiswa as $tb) {
                                            $JmlhNilaiHarian=0;
                                            $JlmhNilaiUTS=0;
                                            $JlmhNilaiUAS=0;
                                          $no++; ?>
                                          
                                              <input type="text" name="NisSiswa[]" value="<?= $tb->NisSiswa ?>">
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
                                            
                                              <?php
                                              if (isset($KelasMapelNilaiSiswa)&&$KelasMapelNilaiSiswa!==false) {
                                               foreach ($KelasMapelNilaiSiswa as $KMNS) {
                                                if ($KMNS->NisSiswa==$tb->NisSiswa && $KMNS->IDNilaiHari==$NH->IDNilaiHari) {
                                                  $NilaiHariSiswa=$KMNS->Nilai;
                                                }
                                              }
                                            }else{
                                              $NilaiHariSiswa=0;
                                            }
                                            $JmlhNilaiHarian+=$NilaiHariSiswa;
                                            ?>
                                              
                                              <?php }
                                              }
                                              ?>
                                                <?php if (isset($NilaiMapelSiswa) && $NilaiMapelSiswa!==false) {
                                                  foreach ($NilaiMapelSiswa as $NMS) {
                                                    if ($tb->NisSiswa==$NMS->NisSiswa) {
                                                      $nilaiUTS=$NMS->NilaiUTS;
                                                    }
                                                  }
                                                }else{
                                                  $nilaiUTS=0;
                                                }
                                                $JlmhNilaiUTS=$nilaiUTS;
                                                ?>
                                                <input type='text' name='nilaiUTS[]' min="0" required value='<?= $nilaiUTS ?>'>
                                                <?php if (isset($NilaiMapelSiswa) && $NilaiMapelSiswa!==false) {
                                                  foreach ($NilaiMapelSiswa as $NMS) {
                                                    if ($tb->NisSiswa==$NMS->NisSiswa) {
                                                      $nilaiUAS=$NMS->NilaiUAS;
                                                    }
                                                  }
                                                }else{
                                                      $nilaiUAS=0;
                                                }
                                                  $JlmhNilaiUAS=$nilaiUAS;
                                                ?>
                                                <input type='text' name='nilaiUAS[]' required value='<?= $nilaiUAS ?>'>
                                                <?php if (isset($NilaiHari)&&$NilaiHari!==false){
                                                  $NilaiAkhir=((($JmlhNilaiHarian/$Hitung)*2)+$JlmhNilaiUTS+$JlmhNilaiUAS)/4;
                                                }else{
                                                  $NilaiAkhir=0;
                                                }?>
                                                <input type="text" name="NilaiHari[]" value="<?= round($NilaiAkhir) ?>" ><br>
                                            <?php }
                                            } ?>                                          
                </div>
                <div class="modal-footer">
                  
                </div>
        </div>
    </div>
</div>
<?php } ?>
  <!-- Modal untuk Peringatan -->

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

<script>
    $(document).ready(function() {
        $('#customFileInput').on('change', function() {
            var fileInput = $('#customFileInput')[0];
            var file = fileInput.files[0];
            var formData = new FormData();
            var KodeKelas = '<?= $this->input->post("KodeKelas") ?>';
            var IDTahun = '<?= $this->input->post("IDTahun") ?>';
            var IDKelasMapel = '<?= $IDKelasMapel ?>';
            var Token = '<?= $this->encryption->encrypt($this->session->userdata("UsrGuru"))?>';

            formData.append('file', file);
            formData.append('token', Token); // Menambahkan token ke FormData
            formData.append('KodeKelas', KodeKelas);
            formData.append('IDTahun', IDTahun);
            formData.append('IDKelasMapel', IDKelasMapel);

            // Reset progress bar and status on each file selection
            $('#Memproses .progress-bar').css('width', '0%');
            $('#StatusUpload').empty().html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
            $('#BtnLanjutkan').prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("User_pengajar/PenilaianImport"); ?>',
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#Memproses .progress-bar').css('width', percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    // Handle success, update status
                    if (response.status === 'success') {
                        $('#JumlahNilaiHarian').html('<div class="animate__animated animate__fadeIn">'+response.jumlahNH+'</div>');
                        $('#JumlahSiswa').html('<div class="animate__animated animate__fadeIn">'+response.jumlahMrd+'</div>');
                        $('#Keterangan').html('<div class="animate__animated animate__fadeIn">'+response.message+'</div>');
                        $('#KKelas').html('<div class="animate__animated animate__fadeIn">'+response.Kelas+'</div>');
                        $('#Kosong').html('<div class="animate__animated animate__fadeIn">'+response.Kosong+'</div>');
                        $('#SecretPath').val(response.path);
                        // Aktifkan tombol Lanjutkan
                        $('#BtnLanjutkan').prop('disabled', false);
                        // Ganti status dengan ikon check setelah selesai
                        $('#StatusUpload').html('<i class="far fa-check-circle animate__animated animate__fadeIn" style="color: #2832ff;"></i>');
                    } else {
                        $('#JumlahNilaiHarian').html('<div class="animate__animated animate__fadeIn">'+response.jumlahNH+'</div>');
                        $('#JumlahSiswa').html('<div class="animate__animated animate__fadeIn">'+response.jumlahMrd+'</div>');
                        $('#Keterangan').html('<div class="animate__animated animate__fadeIn">'+response.message+'</div>');
                        $('#Kosong').html('<div class="animate__animated animate__fadeIn">'+response.Kosong+'</div>');
                        $('#KKelas').html('<div class="animate__animated animate__fadeIn">'+response.Kelas+'</div>');
                        // Aktifkan tombol Lanjutkan
                        $('#BtnLanjutkan').prop('disabled', true);
                        // Ganti status dengan ikon cross jika ada kegagalan
                        $('#StatusUpload').html('<i class="fas fa-times animate__animated animate__fadeIn" style="color: #ef2929;"></i> ');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error, update status
                    $('#StatusUpload').html('<i class="fas fa-times animate__animated animate__fadeIn" style="color: #ef2929;"></i>');
                    $('#JumlahNilaiHarian').html('<i class="fas fa-times animate__animated animate__fadeIn" style="color: #ef2929;"></i>');
                    $('#JumlahSiswa').html('<i class="fas fa-times animate__animated animate__fadeIn" style="color: #ef2929;"></i>');
                    $('#KKelas').html('<i class="fas fa-times animate__animated animate__fadeIn" style="color: #ef2929;"></i>');
                    $('#Kosong').html('<i class="fas fa-times animate__animated animate__fadeIn" style="color: #ef2929;"></i>');
                    $('#Keterangan').html('<div class="animate__animated animate__fadeIn">Cek kembali file anda!</div>');
                    // Aktifkan tombol Lanjutkan
                    $('#BtnLanjutkan').prop('disabled', true);
                }
            });
        });
    });



</script>