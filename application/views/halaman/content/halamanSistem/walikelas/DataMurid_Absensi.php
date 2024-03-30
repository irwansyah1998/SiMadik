<?php
$CekWaliKelas=false;
if (isset($datakelas) && is_array($datakelas) ) {
  $CekWaliKelas=true;
  
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
              <h1 class="m-0">Wali Kelas (Absensi)</h1>
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
            <div class="col-md-4">
              
              <div class="card card-primary shadow animate__animated animate__fadeInLeft">
                    <div class="card-header">
                      <h3 class="card-title">Menu Wali Kelas :</h3>
                      <div class="card-tools">
                        <div class="row mb-2">

                        </div>
                      </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                      <form action="<?= base_url('User_walikelas');?>/WKAbsen" method="POST">
                        <input type="hidden" name="CariData" value="FilterData">
                      
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>Kelas :</label>
                              <select name="IDKelas" class="select2" data-placeholder="Pilih Kelas" style="width: 100%;">
                                <?php foreach ($DataKelasByWaliKelas as $data) { ?>
                                  <option value="<?php echo $data->IDKelas; ?>"><?php echo $data->KodeKelas; ?></option>
                                <?php } ?>
                              </select>
                              <!-- <button type="button" class="btn btn-success addMapel">Tambah Mata Pelajaran</button> -->
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>Tanggal :</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input name="TglFilter" type="text" class="form-control float-right" id="reservation">
                              </div>
                              <!-- /.input group -->
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


                      </form>
                    </div>
                    <!-- /.card-body -->
                  </div>

            </div>
            <div class="col-md-8">
              
              <div class="card card-secondary shadow animate__animated animate__fadeInRight">
                    <div class="card-header">
                      <h3 class="card-title">Tabel Kelas :</h3>
                      <div class="card-tools">

                      </div>
                    </div>
                    <?php if (isset($TampilData) && $TampilData==true) {
                    ?>
                    
                    <!-- /.card-header -->
                    <div class="card-body" style="overflow-x: auto;">
                      <?php
                        $absen_data = []; // Membuat array kosong untuk data absen
                        if (isset($RekapAbsen) && $RekapAbsen != false) {
                          // Mengisi array $absen_data dengan data absen
                          foreach ($RekapAbsen as $absen) {
                            $tanggal = $absen->absen_TglAbsensi;
                            $nis_siswa = $absen->absen_NisSiswa;
                            $absen_data[$tanggal][$nis_siswa] = $absen->absen_MISA; // Menggunakan absen_MISA sebagai kunci
                          }
                        }

                        // Memulai pembuatan tabel
                        ?>

                        <table id="example13" class="table table-bordered table-striped">
                          <thead align="center">
                            <tr>
                              <th width="5%">No</th>
                              <th>Nama Siswa</th>
                              <?php
                              if (isset($RekapAbsenTanggal) && $RekapAbsenTanggal !== false) {
                                foreach ($RekapAbsenTanggal as $tanggal) {
                              ?>
                                  <th><?= $tanggal ?></th>
                              <?php
                                }
                              }
                              ?>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if ($tabel != false) {
                              $no = 0;
                              foreach ($tabel as $tb) {
                                $no++;
                            ?>
                                <tr>
                                  <td><?= $no ?></td>
                                  <td><?= $tb->NamaSiswa; ?></td>
                                  <?php
                                  if (isset($RekapAbsenTanggal) && $RekapAbsenTanggal !== false) {
                                    foreach ($RekapAbsenTanggal as $tanggal) {
                                      if (isset($absen_data[$tanggal]) && isset($absen_data[$tanggal][$tb->NisSiswa])) {
                                        $absen_misa = $absen_data[$tanggal][$tb->NisSiswa];
                                        $keterangan = '';

                                        // Mengganti teks berdasarkan nilai absen_MISA
                                        switch ($absen_misa) {
                                          case 'M':
                                            $keterangan = '<button type="button" class="btn btn-success" onclick="openInfoModal(\''.$tb->NisSiswa.'\',\''.$tanggal.'\')"><i class="fas fa-check-square fa-lg"></i></button>';
                                            break;
                                          case 'I':
                                            $keterangan = '<button type="button" class="btn btn-primary" onclick="openInfoModal(\''.$tb->NisSiswa.'\',\''.$tanggal.'\')">Ijin</button>';
                                            break;
                                          case 'S':
                                            $keterangan = '<button type="button" class="btn btn-warning" onclick="openInfoModal(\''.$tb->NisSiswa.'\',\''.$tanggal.'\')">Sakit</button>';
                                            break;
                                          case 'A':
                                            $keterangan = '<button type="button" class="btn btn-danger" onclick="openInfoModal(\''.$tb->NisSiswa.'\',\''.$tanggal.'\')">Alpa</button>';
                                            break;
                                          default:
                                            $keterangan = '<p type="button" class="btn btn-light">(Kosong)</p>';
                                        }
                                  ?>
                                        <td><?= $keterangan; ?></td>
                                  <?php
                                      } else {
                                  ?>
                                        <td><p type="button" class="btn btn-light">(Kosong)</p></td>
                                  <?php
                                      }
                                    }
                                  }
                                  ?>
                                </tr>
                            <?php
                              }
                            }
                            ?>
                          </tbody>
                        </table>

                    </div>

                    <?php } ?>
                    <!-- /.card-body -->
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


<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoModalLabel">Informasi Absen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Konten informasi akan ditambahkan dinamis oleh JavaScript -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  function openInfoModal(nisSiswa, tanggal) {
    var modalId = "infoModal";
    // Mengubah format tanggal
    var formattedDate = new Date(tanggal);
    var day = formattedDate.getDate().toString().padStart(2, '0');
    var month = (formattedDate.getMonth() + 1).toString().padStart(2, '0');
    var year = formattedDate.getFullYear();

    var formattedDateString = day + '/' + month + '/' + year;

    var modalTitle = "Informasi Absen (" + formattedDateString + ")";

    // Mendapatkan elemen modal
    var modal = document.getElementById(modalId);

    // Mengganti judul modal
    var modalTitleElement = modal.querySelector(".modal-title");
    modalTitleElement.textContent = modalTitle;

    $(modal).modal("show");

    // Menampilkan loading spinner selama data diambil
    var modalBodyElement = modal.querySelector(".modal-body");
    modalBodyElement.innerHTML = '<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Mengambil data...</div>';

    

    // Menggunakan AJAX untuk mengambil data dari server
    $.ajax({
      url: '<?php echo base_url('User_walikelas/AmbilAbsensiMurid'); ?>', // Ganti dengan URL controller Anda
      type: 'POST',
      dataType: 'json',
      data: {
        nisSiswa: nisSiswa,
        tanggal: tanggal
      },
      success: function(data) {
        console.log(data);
        // Menampilkan data di dalam modal setelah berhasil diambil
        var tableHtml = '<table class="table">';
        tableHtml += '<thead align="center">';
        tableHtml += '<tr>';
        tableHtml += '<th>Jam Ke</th>';
        tableHtml += '<th>Waktu</th>';
        tableHtml += '<th>Mata Pelajaran</th>';
        tableHtml += '<th>Guru</th>';
        tableHtml += '<th>Status</th>';
        // ... tambahkan kolom lain sesuai dengan kebutuhan
        tableHtml += '</tr>';
        tableHtml += '</thead>';
        tableHtml += '<tbody align="center">';

        // Iterasi melalui data dan menambahkan baris ke dalam tabel
        for (var i = 0; i < data.length; i++) {
            tableHtml += '<tr>';
            tableHtml += '<td>' + data[i].JamKe + '</td>';
            tableHtml += '<td>' + data[i].MulaiJampel +' ~ '+ data[i].AkhirJampel + '</td>';
            tableHtml += '<td>' + data[i].NamaMapel + '</td>';
            tableHtml += '<td>' + data[i].NamaGuru + '</td>';
             // Menentukan tampilan berdasarkan nilai absen_MISA
            if (data[i].absen_MISA === 'M') {
                tableHtml += '<td><p type="button" class="btn btn-success"><i class="fas fa-check-square fa-lg"></i></p></td>';
            }
            if (data[i].absen_MISA === 'I') {
                tableHtml += '<td><p type="button" class="btn btn-primary">Ijin</p></td>';
            }
            if (data[i].absen_MISA === 'S') {
                tableHtml += '<td><p type="button" class="btn btn-warning">Sakit</p></td>';
            }
            if (data[i].absen_MISA === 'A') {
                tableHtml += '<td><p type="button" class="btn btn-danger">Alpha</p></td>';
            }
            // ... tambahkan kolom lain sesuai dengan kebutuhan
            tableHtml += '</tr>';
        }

        tableHtml += '</tbody>';
        tableHtml += '</table>';

        modalBodyElement.innerHTML = tableHtml;
      },
      error: function() {
        // Menampilkan pesan error jika terjadi kesalahan saat mengambil data
        modalBodyElement.innerHTML = '<div class="text-center text-danger">Gagal mengambil data.</div>';
      }
    });
  }
</script>
