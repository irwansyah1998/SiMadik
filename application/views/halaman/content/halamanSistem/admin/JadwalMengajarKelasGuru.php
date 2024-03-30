<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Penentuan Kelas Untuk Pelajaran</h1>

            </div><!-- /.col -->
            <div class="col-sm-6 animate__animated animate__fadeInRight">
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
        <form action="<?= base_url('User_admin/')?>JadwalKelasMapelCRUD" method="POST">
          <!-- Small boxes (Stat box) -->
          <div class="row">

            <div class="col-md-3">
              <!-- general form elements -->
              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title">Pilih Data Tingkatan :</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Pilih Tingakatan :</label>
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
                  <h3 class="card-title">Pilih Data Kelas :</h3>
                </div>
                <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example8" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="5%">
                            <input type="checkbox" class="kelas-checkbox" id="checkAll">
                          </th>
                          <th>Nama Kelas</th>
                          <th>Wali Kelas</th>
                          <th>Ruangan</th>
                        </tr>
                      </thead>

                    </table>
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
                <div class="card-header">
                  <h3 class="card-title">Memasukkan Mata Pelajaran :</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                  <div class="card-body">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <select class="duallistbox" multiple="multiple">
                              <?php if ($TabelMapel) {
                                foreach ($TabelMapel as $TM) {
                              ?>
                              <option value="<?= $TM->IDMapel ?>"><?= $TM->NamaMapel ?></option>
                              <?php
                                }
                              } ?>
                            </select>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <div class="btn-group col-md-12">
                      <button style="width: 100%" type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Simpan Data</button>
                    </div>
                  </div>
              </div>
              <!-- /.card -->

            </div>
          </div>

        </form>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <div class="bright-overlay"></div>
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

    // Function to update the Data Kelas table
    function updateDataKelasTable(selectedIDTahun) {
      var dataKelas = TabelKelas.filter(function(item) {
        return item.IDTahun === selectedIDTahun;
      });
    
      // Clear the table
      $('#example8').DataTable().clear().draw();
    
      // Populate the table with the filtered data
      dataKelas.forEach(function(item, index) {
        $('#example8').DataTable().row.add([
          index + 1,
          '<input name="IDKelas[]" type="checkbox" class="kelas-checkbox" value="' + item.IDKelas + '">',
          item.KodeKelas,
          item.NamaGuru,
          item.RuanganKelas
        ]).draw();
      });
    }

     // Event listener untuk checkbox "Pilih Semua"
  $('#checkAll').change(function() {
    // Mendapatkan status centang "Pilih Semua"
    var isChecked = $(this).is(":checked");

    // Menyetel status centang pada semua checkbox di dalam tabel
    $('.kelas-checkbox').prop('checked', isChecked);
  });

  // Event listener untuk setiap checkbox individual
  $('.kelas-checkbox').change(function() {
    // Memeriksa apakah semua checkbox telah dicentang atau tidak
    var allChecked = $('.kelas-checkbox:checked').length === $('.kelas-checkbox').length;

    // Memperbarui status centang pada checkbox "Pilih Semua" berdasarkan hasil di atas
    $('#checkAll').prop('checked', allChecked);
  });

    // Initial population of the Data Kelas table based on the default value of the select
    var selectedIDTahun = $('#IDTahun').val();
    updateDataKelasTable(selectedIDTahun);

    // Event listener for the select change event
    $('#IDTahun').on('change', function() {
      selectedIDTahun = $(this).val();
      updateDataKelasTable(selectedIDTahun);
    });
  });
</script>