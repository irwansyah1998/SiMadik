<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-with-overlay">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Laporkan Pelanggaran!</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Laporkan!</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const noSpecialCharsInput = document.getElementById('noSpecialCharsInputsss');

                if (noSpecialCharsInput) {
                    noSpecialCharsInput.addEventListener('input', function() {
                        const inputValue = noSpecialCharsInput.value;
                        const newValue = inputValue.replace(/[\W_]+/g, ''); // Menghapus semua spasi dan karakter khusus

                        if (inputValue !== newValue) {
                            noSpecialCharsInput.value = newValue;
                        }
                    });
                }

                const onlyNumbersInput = document.getElementById('onlyNumbersInput');

                if (onlyNumbersInput) {
                    onlyNumbersInput.addEventListener('input', function() {
                        const inputValue = onlyNumbersInput.value;
                        const newValue = inputValue.replace(/[^0-9]/g, ''); // Menghapus semua selain angka

                        if (inputValue !== newValue) {
                            onlyNumbersInput.value = newValue;
                        }
                    });
                }
            });
        </script>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title m-0">Cari Siswa :</h2>
                                
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="<?php echo base_url('User_halaman');?>/LaporPelanggaran" method="POST">
                                    
                                    <input type="hidden" name="CariData" value="Siswa">
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Cari Tahun:</label>
                                                    <select required class="form-control select2" name="KodeTahun" style="width: 100%;" id="tahun">
                                                        <option value="">Pilih Tahun</option>
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
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nama Siswa:</label>
                                                    <select required class="form-control select2" name="NisSiswa" style="width: 100%;" id="NisSiswa">
                                                        <option value="">Siswa</option>
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

                    <div class="col-md-8">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h2 class="card-title m-0">Form Pelaporan :</h2>
                                <div class="card-tools">
                                    
                                </div>
                            </div>
                            <?php if (isset($CariData)) {
                                        if ($CariData=='Siswa') { ?>
                            <!-- /.card-header -->
                            <form action="<?php echo base_url('User_halaman');?>/LaporPelanggaranCRUD" method="POST" enctype="multipart/form-data">
                                <div class="card-body col-md-12" id="formContainer">
                                    <?php
                                    // print_r($DataSiswaCari);
                                    foreach ($DataSiswaCari as $key) {
                                        $PenyebutanTahun = $key->PenyebutanTahun;
                                        $KodeKelas = $key->KodeKelas;
                                        $NamaSiswa = $key->NamaSiswa;
                                        $NisSiswa = $key->NisSiswa;
                                    }
                                    ?>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Siswa:</label>
                                                    <p class="form-control"><?=$NamaSiswa?></p>
                                                    <input type="hidden" name="Data" value="Lapor">
                                                    <input type="hidden" name="NisSiswa" value="<?=$NisSiswa?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal:</label>
                                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                        <input id="TglLapor" name="TglLapor" type="text" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                     <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tahun:</label>
                                                   <p class="form-control"><?=$PenyebutanTahun?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kelas:</label>
                                                    <p class="form-control"><?=$KodeKelas?></p>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Pelanggaran:</label>
                                                    <select class="form-control select2" name="IDJenis" required>
                                                        <option value="">Pilih Jenis Pelanggaran</option>
                                                        <?php if ($JenisPelanggaran!==FALSE) {
                                                            foreach ($JenisPelanggaran as $JP) {
                                                        ?>
                                                        <option value="<?=$JP->IDJenis?>"><?=$JP->Keterangan?> (<?=$JP->Poin?> Poin)</option>
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
                                                    <label>Bukti Foto:</label>
                                                    <div class="custom-file">
                                                        <input required type="file" class="form-control custom-file-input" name="FotoPelanggaran" accept=".jpeg, .jpg, .png">
                                                        <label class="custom-file-label" for="exampleInputFile">Pilih file gambar....</label>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Keterangan Tambahan:</label>
                                                    <textarea class="form-control" name="Keterangan"></textarea>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                  <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-warning">
                                                    <i class="fas fa-exclamation-triangle"></i> Laporkan
                                                </button>
                                            </div>
                                        </div>
                                </div>
                            </form>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <!-- ROW -->
            <!-- /.container-fluid -->
            </div>
        </div>
    </div>
    <div class="bright-overlay"></div>
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
$(document).ready(function() {
    var dataTahun = <?= json_encode($datatahun) ?>;
    var dataKelas = <?= json_encode($datakelas) ?>;
    var dataSiswa = <?= json_encode($datasiswa) ?>;

    // Populate Tahun Dropdown
    var tahunDropdown = $("#tahun");
    $.each(dataTahun, function(index, item) {
        tahunDropdown.append($('<option>', {
            value: item.KodeTahun,
            text: item.PenyebutanTahun
        }));
    });

    // Handle Tahun Dropdown Change Event
    tahunDropdown.change(function() {
        var selectedKodeTahun = $(this).val();

        // Filter Kelas based on selected Tahun
        var filteredKelas = dataKelas.filter(function(kelas) {
            return kelas.KodeTahun === selectedKodeTahun;
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

        // Handle Kelas Dropdown Change Event
        kelasDropdown.change(function() {
            var selectedKodeKelas = $(this).val();

            // Filter Siswa based on selected Kelas
            var filteredSiswa = dataSiswa.filter(function(siswa) {
                return siswa.KodeKelas === selectedKodeKelas;
            });

            // Populate Siswa Dropdown
            var siswaDropdown = $("#NisSiswa");
            siswaDropdown.empty().append($('<option>', {
                value: "",
                text: "Pilih Siswa"
            }));
            $.each(filteredSiswa, function(index, item) {
                siswaDropdown.append($('<option>', {
                    value: item.NisSiswa,
                    text: item.NamaSiswa
                }));
            });
        });
    });
});
</script>


<script>
  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>

<script>
  // Fungsi untuk mendapatkan tanggal hari ini dalam format "mm/dd/yyyy"
  function getCurrentDate() {
    const now = new Date();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Tambahkan leading zero jika perlu
    const day = String(now.getDate()).padStart(2, '0'); // Tambahkan leading zero jika perlu
    const year = now.getFullYear();
    return `${month}/${day}/${year}`;
  }

  // Fungsi untuk memeriksa apakah input adalah format tanggal yang valid
  function isValidDate(input) {
    const dateRegex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
    return dateRegex.test(input);
  }

  // Fungsi untuk meng-handle perubahan pada input tanggal
  function handleDateInputChange(event) {
    const tanggalInput = event.target;
    const inputValue = tanggalInput.value;

    // Memeriksa apakah nilai yang dimasukkan adalah format tanggal yang valid
    if (!isValidDate(inputValue)) {
      // Jika bukan format tanggal yang valid, reset nilai input ke tanggal hari ini
      tanggalInput.value = getCurrentDate();
    }
  }

  // Isi nilai input tanggal dengan tanggal hari ini saat halaman dimuat
  document.addEventListener('DOMContentLoaded', function() {
    const tanggalInput = document.getElementById('TglLapor');
    tanggalInput.value = getCurrentDate();

    // Menambahkan event listener untuk meng-handle perubahan pada input tanggal
    tanggalInput.addEventListener('input', handleDateInputChange);
  });
</script>

