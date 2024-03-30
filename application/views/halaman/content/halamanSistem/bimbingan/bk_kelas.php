
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Poin Pelanggaran Kelas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Cari Data</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
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
                            <form action="<?php echo base_url('User_bk');?>/BKIndividu" method="POST">
                                
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
                            <h2 class="card-title m-0">Data Siswa :</h2>
                            <div class="card-tools">

                            </div>
                        </div>

                        <!-- /.card-header -->
                        <form action="<?php echo base_url('User_bk');?>/BayarSPPCRUD" method="POST">
                    <div class="card-body col-md-12" id="formContainer">
                                <?php if (isset($_POST['CariData'])) {
                                    if ($_POST['CariData']=='Siswa') {?>
                    <table id="example3" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="25%">Foto</th>
                          <th>Tanggal</th>
                          <th>Jenis Pelanggaran</th>
                          <th>Keterangan</th>
                          <th>Pelapor</th>
                          <th>Poin</th>
                          <th width="15%">Pengaturan</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        if ($RekapIndividu!==FALSE) {
                            $no=0;
                        foreach ($RekapIndividu as $key) {
                        $no++;
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><img src="<?php echo base_url(''.$key->File);?>" alt="Gambar Contoh" class="img-fluid" style="max-width: 100%;"></td>
                            <td><?=$key->TglLapor?></td>>
                            <td><?=$key->KeteranganJenis?></td>
                            <td><?=$key->KeteranganLapor?></td>
                            <td><?=$key->NamaGuru?></td>
                            <td><?=$key->Poin?></td>
                            <td>
                            <div class="btn-group">
                              <a href="#" type="button" class="btn btn-primary"><i class="far fa-list-alt"></i> Detail</a>
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
                          <th colspan="5">Jumlah Poin</th>
                          <th></th>
                          <th>Pengaturan</th>
                        </tr>
                      </tfoot>
                    </table>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                              
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ROW -->
        <!-- /.container-fluid -->
        </div>
    </div>
    <!-- /.content -->



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

