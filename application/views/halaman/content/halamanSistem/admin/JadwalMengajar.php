<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Informasi Akun</h1>

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

        <div class="row">
          

          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tabel Informasi Guru Pengajar :</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="col-md-12">
                <div class="card-body">
                  <div class="col-md-12">
                    <table id="example7" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Nomor Induk Guru</th>
                        <th>Nama Guru</th>
                        <th>Guru Pelajaran</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($tabel != false) {
                        $no = 0;
                        foreach ($tabel as $tb) {
                          $no++; ?>
                          <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $tb->NomorIndukGuru; ?></td>
                            <td><?php echo $tb->NamaGuru; ?></td>
                            <td>
                              <?php
                              if ($DataMapelGuru!==false) {
                                $Mapel = array();
                                $i=0;
                                foreach ($DataMapelGuru as $TMM) {
                                  if ($tb->IDGuru==$TMM->IDGuru) {
                                    $Mapel[$i]=$TMM->NamaMapel;
                                    $i++;
                                  }
                                }
                                echo implode(', ', $Mapel);
                              }
                              ?>
                            </td>
                          </tr>
                      <?php }
                      } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Nomor Induk Guru</th>
                        <th>Nama Guru</th>
                        <th>Guru Pelajaran</th>
                      </tr>
                    </tfoot>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          
        </div>

        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Data Hari :</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Hari Pembelajaran :</label>
                        <select name="IDHari" class="select2" data-placeholder="Pilih Hari" style="width: 100%;">
                        <?php if ($TabelHari!==false) {
                          foreach ($TabelHari as $TH) { ?>
                        <option value="<?= $TH->IDHari ?>" ><?= $TH->NamaHari ?></option>
                          <?php }
                        } ?>
                        </select>
                      </div>
                    </div>
                  </div>  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Jam Pelajaran :</label>
                        <select name="IDJamPel" class="select2" data-placeholder="Pilih Jam Pelajaran" style="width: 100%;">
                        </select>
                      </div>
                    </div>
                  </div>                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                </div>
            </div>
            <!-- /.card -->

          </div>


          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Data Guru :</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Guru :</label>
                        <select name="IDGuru" class="select2" data-placeholder="Pilih Guru" style="width: 100%;">
                          <?php if ($TabelGuru!==false) {
                            foreach ($TabelGuru as $TB) { ?>
                              <option value="<?= $TB->IDGuru ?>"><?= $TB->NamaGuru ?> (<?= $TB->NomorIndukGuru ?>)</option>
                          <?php
                            }
                          } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Guru Mengajar Pelajaran :</label>
                          <select name="IDMapel" class="select2" data-placeholder="Pilih Mata Pelajaran" style="width: 100%;">

                          </select>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                </div>
            </div>
            <!-- /.card -->

          </div>

          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Data Kelas :</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Tingkatan :</label>
                        <select id="IDTahun" name="IDTahun" class="select2" data-placeholder="Pilih Tingkatan" style="width: 100%;">
                          <?php if ($TabelTingkat !== false) {
                            foreach ($TabelTingkat as $TT) {
                              ?>
                          <option value="<?= $TT->IDTahun ?>"><?= $TT->KodeTahun.' ('.$TT->PenyebutanTahun.')' ?></option>
                          <?php
                          }
                        } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Kelas :</label>
                          <select id="IDKelas" name="IDKelas" class="select2" data-placeholder="Pilih Kelas" style="width: 100%;"></select>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                </div>
            </div>
            <!-- /.card -->

          </div>

        </div>
        <!-- /.row -->

        <div class="row">
          

          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                  <button type="submit" class="btn btn-block btn-success">
                          <i class="fas fa-angle-double-down"></i><b> Masukkan Data </b><i class="fas fa-angle-double-down"></i>
                        </button>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

          
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tabel Jadwal :</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">

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
  var DataJampel = <?= json_encode($DataJampel) ?>; 

  // Fungsi untuk mengisi select box Jam Pelajaran berdasarkan Hari Pembelajaran
  function populateJamPelajaran() {
    // Dapatkan pilihan Hari Pembelajaran yang dipilih
    var selectedHari = $('select[name="IDHari"]').val();

    // Bersihkan select box Jam Pelajaran
    $('select[name="IDJamPel"]').empty();

    // Loop melalui DataJampel dan tambahkan pilihan Jam Pelajaran yang sesuai
    for (var i = 0; i < DataJampel.length; i++) {
      if (DataJampel[i].IDHari === selectedHari) {
        $('select[name="IDJamPel"]').append($('<option>', {
          value: DataJampel[i].IDJamPel,
          text: DataJampel[i].MulaiJampel + ' - ' + DataJampel[i].AkhirJampel
        }));
      }
    }
  }

  // Panggil fungsi populateJamPelajaran saat dokumen siap
  populateJamPelajaran();

  // Tambahkan event handler untuk mengganti data Jam Pelajaran saat Hari Pembelajaran berubah
  $('select[name="IDHari"]').change(function() {
    populateJamPelajaran();
  });
});
</script>

<script type="text/javascript">
  $(document).ready(function() {
    var DataMapelGuru = <?= json_encode($DataMapelGuru) ?>;

  // Fungsi untuk mengisi select box Guru Mengajar Pelajaran berdasarkan Guru
  function populateGuruMapel() {
    // Dapatkan pilihan Guru yang dipilih
    var selectedGuru = $('select[name="IDGuru"]').val();

    // Bersihkan select box Guru Mengajar Pelajaran
    $('select[name="IDMapel"]').empty();

    // Loop melalui DataMapelGuru dan tambahkan pilihan Mata Pelajaran yang sesuai
    for (var i = 0; i < DataMapelGuru.length; i++) {
      if (DataMapelGuru[i].IDGuru === selectedGuru) {
        $('select[name="IDMapel"]').append($('<option>', {
          value: DataMapelGuru[i].IDMapel,
          text: DataMapelGuru[i].NamaMapel
        }));
      }
    }
  }

  // Panggil fungsi populateGuruMapel saat dokumen siap
  populateGuruMapel();

  // Tambahkan event handler untuk mengganti data Guru Mengajar Pelajaran saat Guru berubah
  $('select[name="IDGuru"]').change(function() {
    populateGuruMapel();
  });
});
</script>

<script type="text/javascript">
  $(document).ready(function() {
    var TabelKelas = <?= json_encode($TabelKelas) ?>;

    // Fungsi untuk mengisi <select name="IDKelas" berdasarkan IDTahun yang dipilih
    function populateKelas() {
      var selectedIDTahun = $("#IDTahun").val();

      // Hapus semua opsi sebelum menambahkan yang baru
      $("#IDKelas").empty();

      // Filter TabelKelas sesuai dengan IDTahun yang dipilih
      var filteredKelas = TabelKelas.filter(function(kelas) {
        return kelas.IDTahun === selectedIDTahun;
      });

      // Tambahkan opsi ke <select name="IDKelas"
      $.each(filteredKelas, function (index, kelas) {
        $("#IDKelas").append(new Option(kelas.RuanganKelas, kelas.IDKelas));
      });
    }

    // Panggil fungsi saat <select name="IDTahun" berubah
    $("#IDTahun").on("change", function() {
      populateKelas();
    });

    // Panggil fungsi saat halaman pertama kali dimuat
    populateKelas();
  });
</script>
