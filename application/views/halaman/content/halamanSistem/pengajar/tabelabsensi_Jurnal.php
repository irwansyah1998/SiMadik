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

  if (isset($TampilkanJurnal)&&$TampilkanJurnal!==false) {
    foreach ($TampilkanJurnal as $TK) {
      $IDJurnal=$TK->IDJurnal;
      $IDKelasMapel=$TK->IDKelasMapel;
      $IDGuru=$TK->IDGuru;
      $IDAjaran=$TK->IDAjaran;
      $IDJamPel=$TK->IDJamPel;
      $IDKelas=$TK->IDKelas;
      $IDMapel=$TK->IDMapel;
      $KendalaFoto=$TK->KendalaFoto;
      $PenyelesaianFoto=$TK->PenyelesaianFoto;
      $TanggalJurnal=$TK->TanggalJurnal;
      $KendalaKet=$TK->KendalaKet;
      $Penyelesaianket=$TK->Penyelesaianket;
      $MateriPokok=$TK->MateriPokok;
      $InPenKom=$TK->InPenKom;
      $Kegiatan=$TK->Kegiatan;
      $Penilaian=$TK->Penilaian;
      $TindakLanjut=$TK->TindakLanjut;
    }
  }else{
      $IDGuru='';
      $IDAjaran='';
      $IDJamPel='';
      $IDKelas='';
      $IDMapel='';
      $KendalaFoto='';
      $PenyelesaianFoto='';
      $TanggalJurnal='';
      $KendalaKet='';
      $Penyelesaianket='';
      $MateriPokok='';
      $InPenKom='';
      $Kegiatan='';
      $Penilaian='';
      $TindakLanjut='';
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
            <div class="col-sm-6">
              <h1 class="m-0">Jurnal Mata Pelajaran <?=$NamaMapel?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
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


                  <div class="col-md-12">
                      

                      <div class="card card-warning">
                          <div class="card-header">
                            <h2 class="card-title m-0">Data Untuk Jurnal Guru :</h2>
                            <div class="card-tools">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#KembaliDariDataJurnal"><i class="fas fa-backward fa-lg"></i> Kembali</button>
                                    <button <?php if (!isset($IDJurnal)) { echo "disabled"; } ?> type="button" id="btnOpenPdfModal" class="btn btn-primary" data-toggle="modal" data-target="#pdfModal"></i> Lihat PDF</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- /.card-header -->
                          <div class="card-body">
                              <?php if ($datakelas==false): ?>
                                <div class="row">
                                  <div class="col-md-12 text-center">
                                    <h3 class="btn btn-danger col-md-12">Data Belum Tersedia</h3>
                                  </div>
                                </div>
                              <?php endif ?>
                              <?php if (isset($TampilkanData) && $TampilkanData==TRUE) {?>
                              <form class="col-md-12" action="<?php echo base_url('User_pengajar');?>/AbsensiJurnal" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="IDMapel" value="<?= $this->input->post('IDMapel') ?>">
                                <input type="hidden" name="JurnalData" value="Masuk">
                                <input type="hidden" name="IDTahun" value="<?= $this->input->post('IDTahun') ?>">
                                <input type="hidden" name="KodeKelas" value="<?= $this->input->post('KodeKelas') ?>">
                                <input type="hidden" name="IDJamPel" value="<?= $this->input->post('IDJamPel') ?>">
                                <input type="hidden" name="TglAbsensi" value="<?= $this->input->post('TglAbsensi') ?>">
                                <input type="hidden" name="IDKelasMapel" value="<?= $this->input->post('IDKelasMapel') ?>">
                                  <?php foreach ($JamPelajaran as $JP) {
                                      $MulaiJampel=$JP->MulaiJampel;
                                      $AkhirJampel=$JP->AkhirJampel;
                                  } ?>
                                <div class="row">
                                  <div class="col-md-5">
                                      <div class="form-group">
                                        <label>Nama Guru :</label>
                                        <p class="form-control"><?= $this->session->userdata('NamaGuru') ?></p>
                                      </div>
                                  </div>
                                  <div class="col-md-5">
                                      <div class="form-group">
                                        <label>Pelajaran :</label>
                                        <p class="form-control"><?= $NamaMapel ?></p>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                        <label>Kelas :</label>
                                        <p class="form-control"><?= $this->input->post('KodeKelas') ?></p>
                                      </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Tanggal :</label>
                                        <p class="form-control"><?= ubahFormatTanggal($this->input->post('TglAbsensi')) ?></p>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Jam Pelajaran :</label>
                                        <p class="form-control"><?= $MulaiJampel."~".$AkhirJampel ?></p>
                                      </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Semester :</label>
                                        <p class="form-control"><?= $NamaSemester ?></p>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Tahun Ajaran :</label>
                                        <p class="form-control"><?= $KodeAjaran ?></p>
                                      </div>
                                  </div>
                                </div>
                                <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Foto Kendala :</label>
                                                <div class="input-group-prepend">
                                                    <img src="<?= base_url('file/data/gambar/laporanjurnal/'.$KendalaFoto) ?>" alt="Foto Kendala" class="img-thumbnail" id="KendalaFotoPreview" style="max-height: 300px; max-width: 100%;">
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="form-control custom-file-input" name="KendalaFoto" id="KendalaFoto" accept=".jpeg, .jpg, .png">
                                                    <label class="custom-file-label" for="KendalaFotoLabel">Pilih file gambar....</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Foto Penyelesaian :</label>
                                                <div class="input-group-prepend">
                                                    <img src="<?= base_url('file/data/gambar/laporanjurnal/'.$PenyelesaianFoto) ?>" alt="Foto Penyelesaian" class="img-thumbnail" id="KendalaFotoPreview" style="max-height: 300px; max-width: 100%;">
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="form-control custom-file-input" name="PenyelesaianFoto" id="PenyelesaianFoto" accept=".jpeg, .jpg, .png">
                                                    <label class="custom-file-label" for="PenyelesaianFotoLabel">Pilih file gambar....</label>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                <label>Keterangan Kendala :</label>
                                                <textarea name="KendalaKeterangan" class="form-control"><?= $KendalaKet ?></textarea>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                <label>Keterangan Penyelesaian :</label>
                                                <textarea name="PenyelesaianKeterangan" class="form-control"><?= $Penyelesaianket ?></textarea>
                                              </div>
                                          </div>
                                </div>
                                <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                <label>Materi Pokok :</label>
                                                <textarea required name="MateriPokok" class="form-control"><?= $MateriPokok ?></textarea>
                                              </div>
                                          </div>
                                </div>
                                <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                <label>Indikator Pencapaian Kompetensi :</label>
                                                <textarea name="InPenKom" class="form-control"><?= $InPenKom ?></textarea>
                                              </div>
                                          </div>
                                </div>
                                <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                <label>Kegiatan Pembelajaran :</label>
                                                <textarea required name="Kegiatan" class="form-control"><?= $Kegiatan ?></textarea>
                                              </div>
                                          </div>
                                </div>
                                <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                <label>Penilaian :</label>
                                                <textarea name="Penilaian" class="form-control"><?= $Penilaian ?></textarea>
                                              </div>
                                          </div>
                                </div>
                                <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                <label>Rencana Tindak Lanjut :</label>
                                                <textarea name="TindakLanjut" class="form-control"><?= $TindakLanjut ?></textarea>
                                              </div>
                                          </div>
                                </div>
                                <div class="row">
                                  <button type="submit" class="btn btn-success col-md-12"><i class="fas fa-cloud-upload-alt fa-lg"></i> Simpan Data Jurnal</button>
                                </div>
                                
                              </form>
                              <?php } ?>
                          </div>
                          <!-- /.card-body -->
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

  <!-- /.content-wrapper -->


<!-- Modal Peringatan -->
  <?php if (isset($TampilkanData) && $TampilkanData==TRUE) {?>
  <div class="modal fade" id="KembaliDariDataJurnal">
  <div class="modal-dialog modal-lg"> <!-- Menggunakan modal-xl untuk tampilan lebar -->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Kembali Ke Menu Absensi?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="col-md-12" action="<?php echo base_url('User_pengajar');?>/Absensi" method="POST">
        <input type="hidden" name="CariData" value="Kelas">
        <input type="hidden" name="IDMapel" value="<?= $this->input->post('IDMapel') ?>">
        <input type="hidden" name="IDTahun" value="<?= $this->input->post('IDTahun') ?>">
        <input type="hidden" name="KodeKelas" value="<?= $this->input->post('KodeKelas') ?>">
        <input type="hidden" name="IDJamPel" value="<?= $this->input->post('IDJamPel') ?>">
        <input type="hidden" name="TglAbsensi" value="<?= $this->input->post('TglAbsensi') ?>">
        <input type="hidden" name="IDKelasMapel" value="<?= $this->input->post('IDKelasMapel') ?>">
        <div class="modal-body">
          <p>Pastikan semua data sesuai dan telah disimpan!<br><i>Catatan : Semua data yang telah disimpan dapat diubah maksimal 2 hari dari hari sekarang!</i></p>
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


<?php if (isset($IDJurnal)) { ?>
<!-- Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Tampilan PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="pdfContentContainer">
                <!-- Container untuk menampilkan konten PDF -->
                <embed src="<?= base_url('User_pengajar') ?>/JurnalDownloadReview/Review?IDGuru=<?= urlencode($this->encryption->encrypt($this->session->userdata('IDGuru')))?>&IDKelas=<?= urlencode($this->encryption->encrypt($IDKelas))?>&IDMapel=<?= urlencode($this->encryption->encrypt($IDMapel))?>&IDSemester=<?= urlencode($this->encryption->encrypt($this->session->userdata('IDSemester')))?>&IDAjaran=<?= urlencode($this->encryption->encrypt($this->session->userdata('IDAjaran')))?>&IDJamPel=<?=urlencode($this->encryption->encrypt($IDJamPel))?>&IDJurnal=<?= urlencode($this->encryption->encrypt($IDJurnal))?>" width="100%" height="600" type="application/pdf">
                  <!-- <embed src="/JurnalDownloadReview/Download/32/24/6/2/4" width="100%" height="600" type="application/pdf"> -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php } ?>

<script>
    $(document).ready(function () {
        // Fungsi untuk membuka modal dan mengisi konten PDF
        function openPdfModal(pdfContent) {
            $("#pdfModal").modal("show");
        }
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
                selectElement.append($('<option>', {
                    value: item.IDJamPel,
                    text: item.MulaiJampel + ' - ' + item.AkhirJampel
                }));
            });
        });
    });

</script>

<script>
$(document).ready(function () {
    // Hitung tanggal 3 hari ke belakang dari tanggal sekarang
    var today = new Date();
    var threeDaysAgo = new Date(today);
    threeDaysAgo.setDate(today.getDate() - 4);

    // Hitung tanggal 1 hari ke depan dari tanggal sekarang
    var oneDayAhead = new Date(today);
    oneDayAhead.setDate(today.getDate() + 1);

    $('#reservationdate').datetimepicker({
        format: 'dddd, MM/DD/YYYY', // Format tanggal
        minDate: threeDaysAgo, // Set batasan tanggal minimal
        maxDate: oneDayAhead, // Set batasan tanggal maksimal
        daysOfWeekDisabled: [0] // Menonaktifkan hari Minggu (0 adalah indeks hari Minggu)
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
            selectElement.append($('<option>', {
                value: item.IDJamPel,
                text: item.MulaiJampel + ' - ' + item.AkhirJampel
            }));
        });
    });
});

</script>







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
    // Ambil semua elemen input dengan class custom-file-input
    var customFileInputs = document.querySelectorAll('.custom-file-input');

    // Loop melalui elemen-elemen input
    customFileInputs.forEach(function (input) {
        input.addEventListener('change', function (e) {
            var fileName = e.target.files[0].name;
            var labelFor = e.target.getAttribute('id') + 'Label';
            var nextSibling = document.querySelector('[for="' + labelFor + '"]');
            nextSibling.innerText = fileName;
        });
    });
</script>