<script>
    $(document).ready(function () {
        // Variabel untuk melacak jumlah percobaan
        var jumlahPercobaan = 0;
        var keyId = "<?= $this->encryption->encrypt($this->session->userdata('UsrGuru')) ?>";

        // Fungsi untuk kirim perintah TesKoneksi
        function kirimPerintahTesKoneksi() {
            // Ganti ikon ke ikon putar
            $("#icon_spinner").addClass("fa-spin");
            $("#test_koneksi").prop("disabled", true);

            $.ajax({
                url: '<?php echo base_url("whatsapp/TesKoneksi"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    keyId: keyId
                },
                success: function (response) {
                    // Hentikan animasi putar saat berhasil atau gagal

                    if (response.status) {
                        jumlahPercobaan = 0;
                        setTimeout(jalankanSetiap5Menit, 3 * 60 * 1000);
                        toastr.success(response.message);
                        $("#icon_spinner").removeClass("fa-spin");
                            $("#test_koneksi").prop("disabled", false);
                    } else {
                        jumlahPercobaan++;
                        if (jumlahPercobaan >= 5) {
                            $("#icon_spinner").removeClass("fa-spin");
                            toastr.error('WhatsApp Bermasalah, Silahkan tunggu, atau hubungi Administrator.');
                            $("#test_koneksi").prop("disabled", false);
                        } else {
                            setTimeout(jalankanSetiap5Menit, 3500);
                            toastr.info('Menghubungkan ke WhatsApp...');
                            $("#icon_spinner").addClass("fa-spin");
                        }
                    }
                },
                error: function () {
                    // Hentikan animasi putar saat terjadi kesalahan

                    jumlahPercobaan++;
                    if (jumlahPercobaan >= 5) {
                        toastr.error('WhatsApp Bermasalah, Silahkan tunggu, atau hubungi Administrator.');
                        $("#icon_spinner").removeClass("fa-spin");
                        $("#test_koneksi").prop("disabled", false);
                    } else {
                        setTimeout(jalankanSetiap5Menit, 3500);
                        toastr.info('Menghubungkan ke WhatsApp...');
                        $("#icon_spinner").addClass("fa-spin");
                    }
                }
            });
        }

        // Fungsi untuk menjalankan kirimPerintahTesKoneksi setiap 5 menit
        function jalankanSetiap5Menit() {
            kirimPerintahTesKoneksi();
            setInterval(kirimPerintahTesKoneksi, 5 * 60 * 1000);
        }

        // Panggil fungsi saat tombol diklik
        $("#test_koneksi").click(function () {
            // Panggil fungsi kirimPerintahTesKoneksi saat tombol diklik
            kirimPerintahTesKoneksi();
        });
    });
</script>
  
<?php
    function ubahFormatTanggal($tanggalInggris) {
        $tanggalTimestamp = strtotime($tanggalInggris); // Mengonversi tanggal Inggris menjadi timestamp
        $tanggalIndonesia = date('d/m/Y', $tanggalTimestamp); // Mengubah format ke bahasa Indonesia

        return $tanggalIndonesia;
    }
  if (isset($KelasMapel)&&$KelasMapel!==false) {
    foreach ($KelasMapel as $KMPN) {
     $IDKelasMapel=$KMPN->IDKelasMapel;
    }
  }
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
                <?php if (isset($NamaMapel)) { ?>
                <h1 class="m-0">Absensi Mata Pelajaran </h1>
                <?php }else{ ?>
                <h1 class="m-0">Mata Pelajaran Belum Ditetapkan</h1>
                <?php } ?>
              </div><!-- /.col -->
            <?php if (isset($NamaMapel)) { ?>
              <div class="col-sm-6 animate__animated animate__fadeInRight">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Mata Pelajaran</li>
                  <li class="breadcrumb-item">Penilaian</li>
                </ol>
              </div><!-- /.col -->
            <?php } ?>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        
        <div class="container-fluid">
            <?php if (isset($NamaMapel)) { ?>
              <div class="row">
                  <div class="col-md-5">
                      <div class="card card-primary shadow animate__animated animate__fadeInLeft">
                          <div class="card-header">
                              <h2 class="card-title m-0">Cari Kelas :</h2>
                              
                          </div>

                          <!-- /.card-header -->
                          <div class="card-body">
                              <form action="<?php echo base_url('User_pengajar');?>/Absensi" method="POST">
                                  
                                  <input type="hidden" name="CariData" value="Kelas">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Mata Pelajaran:</label>
                                        <select name="IDMapel" id="MaPelGuru" class="form-control select2" required style="width: 100%;">
                                          <option value="">Pelajaran</option>
                                          <?php
                                          if ($MapelGuru!=FALSE) {
                                            foreach ($MapelGuru as $MG) { ?>
                                          <option <?php if($MG->IDMapel==$this->session->userdata('IDMapel')){echo "selected";} ?> value="<?=$MG->IDMapel?>"><?=$MG->NamaMapel?></option>
                                          <?php }
                                          }
                                          ?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>Cari Tingkatan:</label>
                                                  <select required class="form-control select2" name="IDTahun" style="width: 100%;" id="tahun">
                                                      <option value="">Pilih Tingkatan</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>Cari Kelas:</label>
                                                  <select required class="form-control select2" name="KodeKelas" style="width: 100%;" id="kelas">
                                                  </select>
                                              </div>
                                          </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Pilih Tanggal:</label>
                                              <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                  <input name="TglAbsensi" type="text" class="form-control datetimepicker-input" data-target="#reservationdate" value="" required>
                                                  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Jam Pelajaran:</label>
                                              <select class="form-control select2bs4" name="IDJamPel" style="width: 100%;" required>
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
                                  
                              </form>
                          </div>
                          <!-- /.card-body -->
                      </div>

                  </div>

                  <div class="col-md-7">
                      <div class="card card-secondary shadow animate__animated animate__fadeInRight">
                          <div class="card-header">
                              <h2 class="card-title m-0">Form Absensi :</h2>
                              <div class="card-tools">
                                <div class="input-group shadow">
                                  <div class="input-group-prepend">
                                    <div class="btn-group">
                                      <button id="test_koneksi" type="button" class="btn btn-success">
                                        <i id="icon_spinner" class="fas fa-sync-alt"></i> Uji Koneksi
                                      </button>
                                      <!-- <button id="openExcelButton" class="btn btn-primary">Absensi (.xlsx)</button> -->
                                    </div>
                                  </div>
                                </div>
                              </div>
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
                              <form class="col-md-12" action="<?php echo base_url('User_pengajar');?>/Absensi" method="POST">
                                
                                <input type="hidden" name="AbsenData" value="Kelas">
                                <input type="hidden" name="IDTahun" value="<?= $this->input->post('IDTahun') ?>">
                                <input type="hidden" name="KodeKelas" value="<?= $this->input->post('KodeKelas') ?>">
                                <input type="hidden" name="IDJamPel" value="<?= $this->input->post('IDJamPel') ?>">
                                <input type="hidden" name="TglAbsensi" value="<?= $this->input->post('TglAbsensi') ?>">
                                <input type="hidden" name="IDMapel" value="<?= $this->session->userdata('IDMapel') ?>">
                                <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
                                <div class="row">
                                  <?php foreach ($JamPelajaran as $JP) {
                                      $MulaiJampel=$JP->MulaiJampel;
                                      $AkhirJampel=$JP->AkhirJampel;
                                  } ?>
                                  <div class="col-md-4 text-left">
                                    <h5>Data Kelas <?= $this->input->post('KodeKelas') ?></h5>
                                  </div>
                                  <div class="col-md-4 text-center">
                                    <h5><?= $MulaiJampel."~".$AkhirJampel ?></h5>
                                  </div>
                                  <div class="col-md-4 text-right">
                                    <h5><?= ubahFormatTanggal($this->input->post('TglAbsensi')) ?></h5>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <table id="example10" class="table table-bordered table-striped">
                                          <thead>
                                            <tr>
                                              <th width="5%">No</th>
                                              <th>Nama Siswa</th>
                                              <th>Absen</th>
                                              <?php if ($DataAbsenSiswa!==false){?>
                                              <th width="15%">Pengaturan</th>
                                              <?php } ?>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                           $SimpanData=true;
                                          if ($DataSiswa != false) {
                                            $no = 0;
                                            foreach ($DataSiswa as $tb) {
                                              $no++; ?>
                                              <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $tb->NamaSiswa; ?></td>
                                                <td>
                                                  <select <?php if ($DataAbsenSiswa!==false){echo "disabled";}?> class="form-control select2" name="<?= $tb->NisSiswa?>" style="width: 100%;">
                                                      <option <?php if ($DataAbsenSiswa !== false) { foreach ($DataAbsenSiswa as $key) { if ($key->NisSiswa == $tb->NisSiswa && $key->MISA == 'M') { echo "selected"; } } } ?> value="M">Masuk</option>
                                                      <option <?php if ($DataAbsenSiswa !== false) { foreach ($DataAbsenSiswa as $key) { if ($key->NisSiswa == $tb->NisSiswa && $key->MISA == 'I') { echo "selected"; } } } ?> value="I">Ijin</option>
                                                      <option <?php if ($DataAbsenSiswa !== false) { foreach ($DataAbsenSiswa as $key) { if ($key->NisSiswa == $tb->NisSiswa && $key->MISA == 'S') { echo "selected"; } } } ?> value="S">Sakit</option>
                                                      <option <?php if ($DataAbsenSiswa !== false) { foreach ($DataAbsenSiswa as $key) { if ($key->NisSiswa == $tb->NisSiswa && $key->MISA == 'A') { echo "selected"; } } } ?> value="A">Alpha</option>
                                                  </select>
                                                </td>
                                                  <?php if ($DataAbsenSiswa!==false){?>
                                                <td>
                                                  <div class="col-12">
                                                      <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#EditData<?=$tb->NisSiswa?>"><i class="fas fa-edit"></i> Ubah</button>
                                                  </div>
                                                </td>
                                                  <?php } ?>
                                              </tr>
                                              <?php }
                                              } ?>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <th>No</th>
                                              <th>Nama Siswa</th>
                                              <th>Absen</th>
                                              <?php if ($DataAbsenSiswa!==false){?>
                                              <th>Pengaturan</th>
                                              <?php } ?>
                                            </tr>
                                          </tfoot>
                                        </table>
                                      </div>
                                  </div>
                                  <div class="row">
                                  <?php if ($DataAbsenSiswa!==false) {
                                      
                                          $SimpanData=false;
                                  }
                                      ?>
                                  <div class="col-md-6 text-left">
                                    <button <?php if($SimpanData!==false){echo "disabled";} ?> type="button" class="btn btn-secondary " data-toggle="modal" data-target="#EditDataJurnal"><i class="fas fa-edit"></i> Masuk Ke Menu Jurnal</button>
                                  </div>
                                  <div class="col-md-6 text-right">
                                    <button <?php if($SimpanData==false){echo "disabled";} ?> type="submit" class=" btn btn-primary"><i class="fas fa-save"></i> Simpan Absensi</button>
                                  </div>
                                </div>
                                  
                              </form>
                              <?php } ?>

                            </div>
                          </div>
                      </div>
              </div>
              <!-- ROW -->
            <?php } ?>

          <!-- /.container-fluid -->
          </div>

      </div>
              <!-- /.card -->
    </div>
    <div class="bright-overlay"></div>
  </div>
      <!-- /.container-fluid -->
    <!-- /.content -->

  <!-- /.content-wrapper -->
  
  <?php if (isset($TampilkanData) && $TampilkanData==TRUE) {?>
  <div class="modal fade" id="EditDataJurnal">
  <div class="modal-dialog modal-lg"> <!-- Menggunakan modal-xl untuk tampilan lebar -->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Masuk Ke Pengaturan Jurnal!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="col-md-12" action="<?php echo base_url('User_pengajar');?>/AbsensiJurnal" method="POST">
        <input type="hidden" name="CariData" value="Jurnal">
        <input type="hidden" name="IDTahun" value="<?= $this->input->post('IDTahun') ?>">
        <input type="hidden" name="IDMapel" value="<?= $this->input->post('IDMapel') ?>">
        <input type="hidden" name="KodeKelas" value="<?= $this->input->post('KodeKelas') ?>">
        <input type="hidden" name="IDJamPel" value="<?= $this->input->post('IDJamPel') ?>">
        <input type="hidden" name="TglAbsensi" value="<?= $this->input->post('TglAbsensi') ?>">
        <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
        <div class="modal-body">
          <p>Anda akan di arahkan menuju halaman untuk memasukkan jurnal!<br></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Konfirmasi</button>
        </div>
    </div>
    </form>
  </div>
</div>
<?php } ?>

<!-- Modal Peringatan -->
<?php if (isset($DataAbsenSiswa) && $DataAbsenSiswa!==false){
    foreach ($DataAbsenSiswa as $DAS) {
?>
<div class="modal fade" id="EditData<?=$DAS->NisSiswa?>">
  <div class="modal-dialog modal-sm"> <!-- Menggunakan modal-xl untuk tampilan lebar -->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Merubah Data <?=$DAS->NamaSiswa?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="col-md-12" action="<?php echo base_url('User_pengajar');?>/Absensi" method="POST">
      <div class="modal-body">
        <input type="hidden" name="AbsenData" value="Update">
        <input type="hidden" name="IDTahun" value="<?= $this->input->post('IDTahun') ?>">
        <input type="hidden" name="IDMapel" value="<?= $this->input->post('IDMapel') ?>">
        <input type="hidden" name="KodeKelas" value="<?= $this->input->post('KodeKelas') ?>">
        <input type="hidden" name="IDJamPel" value="<?= $this->input->post('IDJamPel') ?>">
        <input type="hidden" name="TglAbsensi" value="<?= $this->input->post('TglAbsensi') ?>">
        <input type="hidden" name="IDKelasMapel" value="<?= $IDKelasMapel ?>">
        <!-- Konten Peringatan -->
        <p>Merubah Data <?=$DAS->NamaSiswa?> dengan Absensi :</p>
        <select class="form-control select2" name="<?= $DAS->NisSiswa?>" style="width: 100%;">
            <option <?php if ($DAS->MISA == 'M') { echo "selected"; } ?> value="M">Masuk</option>
            <option <?php if ($DAS->MISA == 'I') { echo "selected"; } ?> value="I">Ijin</option>
            <option <?php if ($DAS->MISA == 'S') { echo "selected"; } ?> value="S">Sakit</option>
            <option <?php if ($DAS->MISA == 'A') { echo "selected"; } ?> value="A">Alpha</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Konfirmasi</button>
      </div>
    </div>
    </form>
  </div>
</div>
<?php 
    }
} ?>


<div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="excelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excelModalLabel">Data Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tempatkan konten Excel di sini -->
                <div id="excelContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan file Excel menggunakan <embed>
    function displayExcel(embedURL) {
        $('#excelContent').html('<embed src="' + embedURL + '" type="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" width="100%" height="600px">');
        // Tampilkan modal
        $('#excelModal').modal('show');
    }

    // Contoh penggunaan dengan tombol
    $('#openExcelButton').on('click', function () {
        var embedURL = 'https://example.com/path/to/excel.xlsx';
        displayExcel(embedURL);
    });
</script>












<script type="text/javascript">
    // Fungsi untuk mengambil data kelas menggunakan AJAX
    function fetchDataKelas() {
        return $.ajax({
            url: '<?= base_url("User_pengajar/AbsensiKelasServerSide") ?>',
            type: 'POST',
            data: {
                'IDMapel': $('#MaPelGuru').val(),
                'IDGuru': '<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>',
                'IDAjaran': '<?= $this->encryption->encrypt($this->session->userdata('IDAjaran')) ?>'
            },
            dataType: 'json'
        });
    }

    // Panggil fungsi saat elemen halaman dokumen siap (document ready)
    $(document).ready(function () {
        var dataTahun = <?= json_encode($datatahun) ?>;
        var dataKelas; // Variabel untuk menyimpan dataKelas

        // Tambahkan variabel dataKelas
        fetchDataKelas().then(function (result) {
            dataKelas = result;
            // Lakukan sesuatu dengan dataKelas, misalnya memperbarui tampilan
            // console.log(dataKelas);

            // Populate Tahun Dropdown
            var tahunDropdown = $("#tahun");
            $.each(dataTahun, function (index, item) {
                var isSelected = item.IDTahun == '<?= $this->input->post('IDTahun') ?>';
                tahunDropdown.append($('<option>', {
                    value: item.IDTahun,
                    text: item.PenyebutanTahun,
                    selected: isSelected // Tambahkan atribut selected jika isSelected true
                }));
            });

            // Panggil fungsi untuk mempopulasi dropdown kelas saat halaman dimuat
            populateKelasDropdown(tahunDropdown.val());
        });

        // Tambahkan event listener untuk perubahan pada #MaPelGuru
        $('#MaPelGuru').change(function () {
            // Panggil fungsi setiap kali #MaPelGuru berubah
            fetchDataKelas().then(function (result) {
                dataKelas = result;
                // Lakukan sesuatu dengan dataKelas setelah perubahan
                // Misalnya, perbarui dropdown kelas
                var selectedIDTahun = $('#tahun').val();
                populateKelasDropdown(selectedIDTahun);
            });
        });

        // Fungsi untuk mempopulasi dropdown kelas
        function populateKelasDropdown(selectedIDTahun) {
            // Filter Kelas based on selected Tahun
            var filteredKelas = dataKelas.filter(function (kelas) {
                return kelas.IDTahun === selectedIDTahun;
            });

            // Populate Kelas Dropdown
            var kelasDropdown = $("#kelas");
            kelasDropdown.empty().append($('<option>', {
                value: "",
                text: "Pilih Kelas"
            }));
            $.each(filteredKelas, function (index, item) {
                var SelectedKls = item.KodeKelas == '<?= $this->input->post('KodeKelas') ?>';
                kelasDropdown.append($('<option>', {
                    value: item.KodeKelas,
                    text: item.KodeKelas,
                    selected: SelectedKls
                }));
            });
        }

        // Handle Tahun Dropdown Change Event
        $('#tahun').change(function () {
            var selectedIDTahun = $(this).val();
            // Panggil fungsi untuk mempopulasi dropdown kelas saat dropdown tahun berubah
            populateKelasDropdown(selectedIDTahun);
        });
    });
</script>



<script type="text/javascript">
    $(document).ready(function() {
        var dataHariJampel = <?= json_encode($dataHariJampel) ?>;
        var dayMapping = {
            "Sunday": "Minggu",
            "Monday": "Senin",
            "Tuesday": "Selasa",
            "Wednesday": "Rabu",
            "Thursday": "Kamis",
            "Friday": "Jumat",
            "Saturday": "Sabtu"
        };

        $('#reservationdate').on('change.datetimepicker', function (e) {
            var selectedDate = e.date.format('dddd, MM/DD/YYYY'); // Mengambil hari dan format tanggal
            var selectedDay = selectedDate.split(',')[0]; // Mengambil nama hari dalam bahasa Inggris
            var selectedIndonesianDay = dayMapping[selectedDay]; // Mengonversi nama hari ke bahasa Indonesia

            // Filter data sesuai dengan hari yang dipilih
            var filteredData = dataHariJampel.filter(function (item) {
                return item.NamaHari === selectedIndonesianDay;
            });

            // Kemudian, Anda dapat memuat data ini ke elemen <select>
            var selectElement = $('select[name="IDJamPel"]');
            selectElement.empty(); // Kosongkan elemen select terlebih dahulu

            // Tambahkan opsi sesuai dengan data yang telah difilter
            filteredData.forEach(function (item) {
                // Periksa apakah IDJamPel sama dengan yang dikirimkan melalui POST
                var isSelected = item.IDJamPel == '<?php echo $this->input->post('IDJamPel'); ?>';

                // Tambahkan elemen <option> dengan atau tanpa atribut selected
                selectElement.append($('<option>', {
                    value: item.IDJamPel,
                    text: item.MulaiJampel + ' - ' + item.AkhirJampel,
                    selected: isSelected // Tambahkan atribut selected jika isSelected true
                }));
            });
        });

        // Hitung tanggal 3 hari ke belakang dari tanggal sekarang
        var today=new Date();
        // Periksa apakah ada nilai post 'TglAbsensi'
        var tanggalAbsensi = '<?= $this->input->post('TglAbsensi') ?>';

        if (tanggalAbsensi !== null && tanggalAbsensi !== '') {
            // Ubah format tanggal dari PHP ke 'm/d/Y' dalam JavaScript
            var dateObj = new Date(tanggalAbsensi);
            AmbilDate = new Date(dateObj.getFullYear(), dateObj.getMonth(), dateObj.getDate());
        }else{

          var AmbilDate = new Date();
        }

        


        // Menggunakan moment.js untuk menghitung tiga hari yang lalu
        // var threeDaysAgo = moment(today, 'dddd, MM/DD/YYYY').subtract(3, 'days').toDate();

        // Menggunakan moment.js untuk menghitung satu hari ke depan
        var oneDayAhead = moment(today, 'dddd, MM/DD/YYYY').add(0, 'days').toDate();

        console.log(AmbilDate);

        // Menggunakan Now_Date langsung sebagai defaultDate tanpa moment()
        $('#reservationdate').datetimepicker({
            format: 'dddd, MM/DD/YYYY',
            // minDate: threeDaysAgo,
            maxDate: oneDayAhead,
            daysOfWeekDisabled: [0],
            defaultDate: new Date(AmbilDate) // Menggunakan new Date() untuk mengonversi string ke objek Date
        });



        $('#reservationdate').on('change.datetimepicker', function (e) {
            var selectedDate = e.date.format('dddd, MM/DD/YYYY'); // Mengambil hari dan format tanggal
            var selectedDay = selectedDate.split(',')[0]; // Mengambil nama hari dalam bahasa Inggris
            var selectedIndonesianDay = dayMapping[selectedDay]; // Mengonversi nama hari ke bahasa Indonesia

            // Filter data sesuai dengan hari yang dipilih
            var filteredData = dataHariJampel.filter(function (item) {
                return item.NamaHari === selectedIndonesianDay;
            });

            // Kemudian, Anda dapat memuat data ini ke elemen <select>
            var selectElement = $('select[name="IDJamPel"]');
            selectElement.empty(); // Kosongkan elemen select terlebih dahulu

            // Tambahkan opsi sesuai dengan data yang telah difilter
            filteredData.forEach(function (item) {
                // Periksa apakah IDJamPel sama dengan yang dikirimkan melalui POST
                var isSelected = item.IDJamPel == '<?php echo $this->input->post('IDJamPel'); ?>';

                // Tambahkan elemen <option> dengan atau tanpa atribut selected
                selectElement.append($('<option>', {
                    value: item.IDJamPel,
                    text: item.MulaiJampel + ' - ' + item.AkhirJampel,
                    selected: isSelected // Tambahkan atribut selected jika isSelected true
                }));
            });
        });
    });

</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- Pastikan Anda menyertakan jQuery -->

<script>
  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>