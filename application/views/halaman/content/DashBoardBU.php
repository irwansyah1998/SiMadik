<?php
function hitungSelisihWaktu($waktu_dari_database)
{
  // Konversi teks ke objek DateTime
  $waktu_database_obj = DateTime::createFromFormat('Y-m-d H:i:s', $waktu_dari_database);

  // Periksa jika konversi berhasil
  if ($waktu_database_obj === false) {
    return "Format waktu tidak valid";
  }

  // Waktu sekarang
  $waktu_sekarang = new DateTime();

  // Hitung selisih waktu
  $selisih = $waktu_sekarang->diff($waktu_database_obj);

  $hasil = array();

  if ($selisih->d > 0) {
    $hasil['selisih_hari'] = $selisih->d . " Hari lalu";
  } elseif ($selisih->h > 23) {
    $hasil['selisih_hari'] = "1 hari";
  } elseif ($selisih->h > 0) {
    $hasil['selisih_jam'] = $selisih->h . " Jam lalu";
  } elseif ($selisih->i > 0) {
    $hasil['selisih_menit'] = $selisih->i . " Menit lalu";
  } else {
    $hasil['selisih_menit'] = "Baru saja";
  }

  return $hasil;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-with-overlay">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 animate__animated animate__slideInLeft">Dashboard</h1>

          </div><!-- /.col -->
          <div class="col-sm-6 animate__animated animate__slideInRight">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6 animate__animated animate__slideInLeft">
            <!-- small box -->
            <div class="small-box shadow" style="transform: perspective(5000px); backdrop-filter: blur(1px); background-color: rgba(200, 0, 0, 0.3); transition: backdrop-filter 0.7s ease-in-out;">
              <div class="inner">
                <h3><?= $Jumlah_Staff ?></h3>
                <p>Total Pegawai</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6 animate__animated animate__fadeInDown">
            <!-- small box -->
            <div class="small-box shadow" style="transform: perspective(5000px); transition: backdrop-filter 0.7s ease-in-out; backdrop-filter: blur(1px); background-color: rgba(0, 200, 0, 0.3);">
              <div class="inner">
                <h3><?= $Jumlah_Guru ?></h3>

                <p>Total Guru</p>
              </div>
              <div class="icon">
                <i class="fa fa-graduation-cap"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6 animate__animated animate__fadeInUp">
            <!-- small box -->
            <div class="small-box shadow" style="transform: perspective(5000px); transition: backdrop-filter 0.7s ease-in-out; backdrop-filter: blur(1px); background-color: rgba(0, 0, 200, 0.3);">
              <div class="inner">
                <h3><?= $Jumlah_Murid ?></h3>

                <p>Total Siswa</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6 animate__animated animate__slideInRight">
            <!-- small box -->
            <div class="small-box shadow" style="transform: perspective(5000px); transition: backdrop-filter 0.7s ease-in-out; backdrop-filter: blur(1px); background-color: rgba(200, 200, 0, 0.3);">
              <div class="inner">
                <h3><?= $Jumlah_Kelas ?></h3>

                <p>Total Kelas</p>
              </div>
              <div class="icon">
                <i class="fas fa-store-alt"></i>
              </div>
            </div>
          </div>



        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">

            <?= form_open_multipart(base_url('User_halaman/CRUDIndex'), array('method' => 'post')); ?>
            <input type="hidden" name="Pengaturan" value="Pengguna">
            <!-- Profile Image -->
            <div class="card card-widget widget-user-2 shadow animate__animated animate__fadeInLeft" style="transform: perspective(5000px);">
              <div class="widget-user-header bg-primary" style="background: url('<?php echo base_url("assets/gambar/bg3.webp"); ?>') center center;">
                <div class="widget-user-image">
                  <img class="img-circle" src="<?php echo base_url('/file/data/gambar/default/user.png'); ?>" alt="User Avatar">
                </div>
                <h3 class="widget-user-username text-right"><?= $this->session->userdata('UsrGuru') ?></h3>
                <h5 class="widget-user-desc text-right"><?= $this->session->userdata('KodeGuru') ?></h5>
              </div>

              <div class="card-body box-profile">

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Nama :</b> <i class="float-right"><?= $this->session->userdata('NamaGuru') ?></i>
                  </li>
                  <li class="list-group-item">
                    <b>Pelajaran :</b>
                    <a class="input-group float-right col-md-12">
                      <select name="IDMapel" class="form-control select2" required style="width: 100%;">
                        <option value="">Pelajaran</option>
                        <?php
                        if ($MapelGuru != FALSE) {
                          foreach ($MapelGuru as $MG) { ?>
                            <option <?php if ($MG->IDMapel == $this->session->userdata('IDMapel')) {
                                      echo "selected";
                                    } ?> value="<?= $MG->IDMapel ?>"><?= $MG->NamaMapel ?></option>
                        <?php }
                        }
                        ?>
                      </select>
                    </a>
                    <!-- /.input group -->
                  </li>

                  <li class="list-group-item">
                    <b>Semester :</b>
                    <a class="input-group float-right col-md-12">
                      <select class="form-control select2 shadow" name="Semester" required style="width: 100%;">
                        <option value="">Semester</option>
                        <?php
                        if ($Semester != FALSE) {
                          foreach ($Semester as $SM) { ?>
                            <option <?php if ($this->session->userdata('IDSemester') == $SM->IDSemester) {
                                      echo "selected";
                                    } ?> value="<?= $SM->IDSemester ?>"><?= $SM->NamaSemester ?></option>
                        <?php }
                        }
                        ?>
                      </select>
                    </a>
                    <!-- /.input group -->
                  </li>

                  <li class="list-group-item">
                    <b>Tahun Ajaran :</b>
                    <a class="input-group float-right col-md-12">
                      <select class="form-control select2 shadow" name="TahunAjaran" required style="width: 100%;">
                        <option value="">Tahun Ajaran</option>
                        <?php if ($TahunAjaran != false) {
                          foreach ($TahunAjaran as $TA) { ?>
                            <option <?php if ($this->session->userdata('IDAjaran') == $TA->IDAjaran) {
                                      echo "selected";
                                    } ?> value="<?= $TA->IDAjaran ?>"><?= $TA->KodeAjaran ?></option>
                        <?php }
                        }
                        ?>
                      </select>
                    </a>
                    <!-- /.input group -->
                  </li>
                  <li class="list-group-item">
                    <div class="form-group">
                      <button type="submit" class="btn btn-block btn-primary shadow" style="transform: perspective(5000px);">
                        <i class="fas fa-clipboard-check"></i> Tentukan
                      </button>
                    </div>
                  </li>

                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <?= form_close(); ?>
            <!-- About Me Box -->

            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary shadow animate__animated animate__fadeInRight">
              <div class="card-header">
                <h3 class="card-title">Informasi Riwayat</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="TabelInformasi" class="table table-bordered table-striped">
                  <thead align="center">
                    <tr>
                      <th rowspan="2">No</th>
                      <th rowspan="2">Tanggal</th>
                      <th rowspan="2">Kelas</th>
                      <th rowspan="2">Jam</th>
                      <!-- <th rowspan="2">MulaiJampel</th> -->
                      <th rowspan="2">MaPel</th>
                      <th colspan="5">Rekap Kehadiran Siswa</th>
                      <th rowspan="2">Jurnal</th>
                    </tr>
                    <tr>
                      <th>Jmlh</th>
                      <th>Hadir</th>
                      <th>I</th>
                      <th>S</th>
                      <th>A</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($TampilkanJurnal !== FALSE) {
                      $no = 0;
                      foreach ($TampilkanJurnal as $tj) {
                        $no++;
                    ?>
                        <tr align="center">
                          <td><?= $no ?></td>
                          <td><?= date('d/m/Y', strtotime($tj->TglAbsensi)) ?></td>
                          <td><?= $tj->KodeKelas ?></td>
                          <td><?= $tj->MulaiJampel . ' - ' . $tj->AkhirJampel ?></td>
                          <td><?= $tj->NamaMapel ?></td>

                          <!-- Tampilkan hasil kehadiran di tabel atau tempat yang sesuai -->
                          <td><?= $tj->JumlahM + $tj->JumlahI + $tj->JumlahS + $tj->JumlahA ?></td>
                          <td><?= $tj->JumlahM ?></td>
                          <td><?= $tj->JumlahI ?></td>
                          <td><?= $tj->JumlahS ?></td>
                          <td><?= $tj->JumlahA ?></td>
                          <td><?= $tj->KeteranganJurnal ?></td>
                        </tr>
                    <?php
                      }
                    }
                    ?>
                  </tbody>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
          </div>


        </div>


        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary shadow animate__animated animate__fadeInRight">
              <div class="card-header">
                <h3 class="card-title">Pengumuman</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if ($DataSuratDigital !== false) {
                  foreach ($DataSuratDigital as $DSD) {
                ?>
                    <!-- Post -->

                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="<?php echo base_url('/file/data/gambar/default/user.png'); ?>" alt="user image">
                        <span class="username">
                          <?php if ($DSD->IDHakSurat == '1') {
                            $User = 'Administrasi';
                          } ?>
                          <a href="<?= base_url('User_halaman/index/Informasi/' . $DSD->IDSurat) ?>"><?= $User ?></a>
                        </span>
                        <span class="description">Untuk <?= $DSD->KategoriSurat ?> - <?php
                                                                                      $selisih_waktu = hitungSelisihWaktu($DSD->TanggalSurat);
                                                                                      if (isset($selisih_waktu['selisih_hari'])) {
                                                                                        echo $selisih_waktu['selisih_hari'];
                                                                                      } elseif (isset($selisih_waktu['selisih_jam'])) {
                                                                                        echo $selisih_waktu['selisih_jam'];
                                                                                      } elseif (isset($selisih_waktu['selisih_menit'])) {
                                                                                        echo $selisih_waktu['selisih_menit'];
                                                                                      }
                                                                                      ?></span>
                      </div>
                      <a href="<?= base_url('User_halaman/index/Informasi/' . $DSD->IDSurat) ?>">
                        <p><b><?= $DSD->SubjekSurat ?></b><br><?= $DSD->Keterangan ?></p>
                      </a>

                      <!-- /.user-block -->

                    </div>

                    <!-- /.post -->
                <?php
                  }
                } ?>


              </div>
              <!-- /.card-body -->
            </div>
          </div>

        </div>



      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <div class="bright-overlay"></div>
</div>
<!-- /.content-wrapper -->

<script>
  $(function() {
    $('#TabelInformasi').DataTable({
      "paging": true,
      "lengthChange": false,
      "lengthMenu": [7],
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>