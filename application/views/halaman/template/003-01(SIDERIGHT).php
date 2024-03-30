<script type="text/javascript">
  // Contoh menggunakan jQuery
  $(document).ready(function () {
    $(".nav-item").addClass("nav-item-animation");
  });
</script>
<?php
$MATIKAN = TRUE;
foreach ($SISTEM as $row) {
  $NamaSistem = $row->NamaSistem;
  $NamaInstansi = $row->NamaInstansi;
  $Alamat = $row->Alamat;
  $Keterangan = $row->Keterangan;
  $Logo = $row->Logo;
}
$TataTertib = false;
$SuratDigital = false;
$Keuangan = false;
$SiAdik = false;
$SU = false;
$KPLS = false;
$WLIK = false;
$KUG = false;
$GBK = false;
$GR1 = false;
if (isset ($IDHak)) {
  $cek = explode('//', $IDHak);
  for ($i = 0; $i < count($cek); $i++) {
    if ($cek[$i] === '1') {
      $SU = TRUE;
    }
    if ($cek[$i] === '2') {
      $KPLS = TRUE;
    }
    if ($cek[$i] === '3') {
      $WLIK = TRUE;
    }
    if ($cek[$i] === '4') {
      $KUG = TRUE;
    }
    if ($cek[$i] === '5') {
      $GBK = TRUE;
    }
    if ($cek[$i] === '6') {
      $GR1 = TRUE;
    }
  }
}
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo base_url('User_halaman'); ?>" class="brand-link">
    <img src="<?php echo base_url('file/data/gambar/' . $Logo); ?>" alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SiMadik</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url('file/data/gambar/default/user.png'); ?>" class="img-circle elevation-2"
          alt="User Image">
      </div>
      <div class="info">
        <a href="<?= base_url('User_halaman/UserProfile') ?>" class="d-block">
          <?php echo $NamaGuru; ?>
        </a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
          <a href="<?php echo base_url('User_halaman'); ?>" class="nav-link <?php if ($aktif == 'Dashboard') {
               echo 'active';
             } ?>">
            <i class="nav-icon fa fa-id-card fa-lg"></i>
            <p>
              Informasi Dasar
            </p>
          </a>
        </li>

        <!-- menambahkan menu kepala sekolah || 25 januari 2024 || vita -->
        <?php if ($KPLS === TRUE) { ?>
          <li class="nav-header">Menu Kepala Sekolah</li>

          <li class="nav-item">
            <a href="<?php echo base_url('User_kepsek/JurnalGuru'); ?>" class="nav-link <?php if ($aktif == 'JurnalGuru') {
                 echo 'active';
               } ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Jurnal Guru
              </p>
            </a>
          </li>

          <!-- <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-donate"></i>
                <p>
                  Data Keuangan
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Data Pegawai
                  <i class="fas fa-angle-left fa-sm right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user-graduate"></i>
                    <p>
                      Guru
                    </p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user-tie"></i>
                    <p>
                      Pegawai
                    </p>
                  </a>
                </li>

              </ul>
            </li> -->
          <?php
        } ?>

        <?php if ($SU === TRUE) { ?>
          <li class="nav-header">Menu Admin</li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($aktif == 'TabelKelas' || $aktif == 'TabelTahunAjaran' || $aktif == 'TabelMapel' || $aktif == 'TabelTingkatan' || $aktif == 'ProfileSekolah' || $aktif == 'TabelSemester') {
              echo 'active';
            } ?>">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Sekolah
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('User_admin/'); ?>ProfileSekolah" class="nav-link <?php if ($aktif == 'ProfileSekolah') {
                     echo 'active';
                   } ?>">
                  <i class="nav-icon fas fa-school"></i>
                  <p>
                    Profile Sekolah
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link <?php if ($aktif == 'TabelTahunAjaran' || $aktif == 'TabelSemester') {
                  echo 'active';
                } ?>">
                  <i class="nav-icon fas fa-user-graduate"></i>
                  <p>
                    Ajaran Pendidikan
                    <i class="fas fa-angle-left fa-sm right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_admin/TabelTahunAjaran'); ?>" class="nav-link <?php if ($aktif == 'TabelTahunAjaran') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-user-graduate"></i>
                      <p>
                        Tahun Ajaran
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_admin/TabelSemester'); ?>" class="nav-link <?php if ($aktif == 'TabelSemester') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-book"></i>
                      <p>
                        Semeseter
                      </p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link <?php if ($aktif == 'TabelKelas' || $aktif == 'TabelTingkatan') {
                  echo 'active';
                } ?>">
                  <i class="nav-icon fas fa-school fa-lg"></i>
                  <p>
                    Menu Kelas
                    <i class="fas fa-angle-left fa-sm right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_admin/TabelTingkatan'); ?>" class="nav-link <?php if ($aktif == 'TabelTingkatan') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-hashtag"></i>
                      <p>Tingkatan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_admin/TabelKelas'); ?>" class="nav-link <?php if ($aktif == 'TabelKelas') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-list fa-xm"></i>
                      <p>Daftar Kelas</p>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="nav-item">
                <a href="" class="nav-link <?php if ($aktif == 'TabelMapel') {
                  echo 'active';
                } ?>">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    Pelajaran
                    <i class="fas fa-angle-left fa-sm right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">


                  <li class="nav-item">
                    <a href="<?php echo base_url('User_admin/TabelMapel'); ?>" class="nav-link <?php if ($aktif == 'TabelMapel') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-book"></i>
                      <p>Mata Pelajaran</p>
                    </a>
                  </li>

                </ul>
              </li>

            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($aktif == 'HariPembelajaran' || $aktif == 'JamPembelajaran' || $aktif == 'JadwalKelasMapel') {
              echo 'active';
            } ?>">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Jadwal Sekolah
                <i class="fas fa-angle-left fa-sm right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link <?php if ($aktif == 'HariPembelajaran' || $aktif == 'JamPembelajaran') {
                  echo 'active';
                } ?>">
                  <i class="nav-icon fas fa-chalkboard"></i>
                  <p>
                    Waktu Pembelajaran
                    <i class="fas fa-angle-left fa-sm right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_admin/HariPembelajaran'); ?>" class="nav-link <?php if ($aktif == 'HariPembelajaran') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-calendar-day"></i>
                      <p>
                        Hari Pembelajaran
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_admin/JamPembelajaran'); ?>" class="nav-link <?php if ($aktif == 'JamPembelajaran') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-clock"></i>
                      <p>
                        Jam Pembelajaran
                      </p>
                    </a>
                  </li>
                </ul>
              </li>





            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link <?php if ($aktif == 'JadwalKelasMapel') {
                  echo 'active';
                } ?>">
                  <i class="nav-icon fas fa-chalkboard"></i>
                  <p>
                    Jadwal
                    <i class="fas fa-angle-left fa-sm right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_admin/'); ?>JadwalKelasMapel" class="nav-link <?php if ($aktif == 'JadwalKelasMapel') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-chalkboard-teacher"></i>
                      <p>Pelajaran Kelas</p>
                    </a>
                  </li>
                  <?php if ($MATIKAN !== TRUE) { ?>
                    <li class="nav-item">
                      <a href="<?php echo base_url('User_admin/'); ?>JadwalGuruMengajar" class="nav-link <?php if ($aktif == '') {
                           echo 'active';
                         } ?>">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>Jadwal Guru</p>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>





            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($aktif == 'TabelGuru' || $aktif == 'TabelMurid' || $aktif == 'TabelOrtu' || $aktif == 'TabelLevelUser') {
              echo 'active';
            } ?>">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Pengguna
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('User_admin/TabelLevelUser'); ?>" class="nav-link <?php if ($aktif == 'TabelLevelUser') {
                     echo 'active';
                   } ?>">
                  <i class="fa fa-suitcase nav-icon"></i>
                  <p>Level User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('User_admin/TabelGuru'); ?>" class="nav-link <?php if ($aktif == 'TabelGuru') {
                     echo 'active';
                   } ?>">
                  <i class="fa fa-suitcase nav-icon"></i>
                  <p>Guru</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('User_admin/TabelMurid'); ?>" class="nav-link <?php if ($aktif == 'TabelMurid') {
                     echo 'active';
                   } ?>">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('User_admin/WaliMurid'); ?>" class="nav-link <?php if ($aktif == 'TabelOrtu') {
                     echo 'active';
                   } ?>">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Wali Murid</p>
                </a>
              </li>
            </ul>
          </li>
          <?php foreach ($Fitur as $FA) {
            if ($FA->NamaFitur == 'SuratDigital' && $FA->Aktivasi == 'Aktif') {
              $SuratDigital = true;
            }
          } ?>
          <?php
          if ($SuratDigital == true) {
            ?>
            <li class="nav-item">
              <a href="<?php echo base_url('User_admin/'); ?>SuratDigital" class="nav-link <?php if ($aktif == 'SuratDigital') {
                   echo 'active';
                 } ?>">
                <i class="nav-icon fas fa-envelope"></i>
                <p>
                  Surat Digital
                </p>
              </a>
            </li>
            <?php
          }
          ?>

        <?php } ?>






        <?php if ($WLIK === TRUE) { ?>
          <li class="nav-header">Menu Wali Kelas</li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($aktif == 'WKAbsen' || $aktif == 'WKNilai' || $aktif == 'WKPelanggaran') {
              echo 'active';
            } ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Siswa Kelas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('User_walikelas/WKAbsen'); ?>" class="nav-link <?php if ($aktif == 'WKAbsen') {
                     echo 'active';
                   } ?>">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Absensi Kelas
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('User_walikelas/WKNilai'); ?>" class="nav-link <?php if ($aktif == 'WKNilai') {
                     echo 'active';
                   } ?>">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Nilai Kelas
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('User_walikelas/WKPelanggaran'); ?>" class="nav-link <?php if ($aktif == 'WKPelanggaran') {
                     echo 'active';
                   } ?>">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Pelanggaran
                  </p>
                </a>
              </li>
            </ul>
          </li>
        <?php } ?>

        <?php foreach ($Fitur as $FA) {
          if ($FA->NamaFitur == 'Keuangan' && $FA->Aktivasi == 'Aktif') {
            $Keuangan = true;
          }
        }
        ?>
        <?php if ($KUG === TRUE && $Keuangan == true) { ?>
          <li class="nav-header">Menu Keuangan</li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($aktif == 'SPP' || $aktif == 'BayarSPP' || $aktif == 'Wajib' || $aktif == 'WajibBayar') {
              echo 'active';
            } ?>">
              <i class="nav-icon fas fa-calculator"></i>
              <p>
                Keuangan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('User_keuangan/SPP'); ?>" class="nav-link <?php if ($aktif == 'SPP' || $aktif == 'BayarSPP') {
                     echo 'active';
                   } ?>">
                  <i class="nav-icon fas fa-wallet"></i>
                  <p>
                    SPP
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_keuangan/SPP'); ?>" class="nav-link <?php if ($aktif == 'SPP') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-list fa-xm"></i>
                      <p>SPP Info</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_keuangan/BayarSPP'); ?>" class="nav-link <?php if ($aktif == 'BayarSPP') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon far fa-money-bill-alt"></i>
                      <p>
                        Pembayaran
                      </p>
                    </a>
                  </li>
                </ul>
              </li>
              <?php if ($MATIKAN !== TRUE) { ?>

                <li class="nav-item">
                  <a href="#" class="nav-link <?php if ($aktif == 'Wajib' || $aktif == 'WajibBayar') {
                    echo 'active';
                  } ?>">
                    <i class="nav-icon fas fa-wallet"></i>
                    <p>
                      Dana Wajib
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url('User_keuangan/Wajib'); ?>" class="nav-link <?php if ($aktif == 'Wajib') {
                           echo 'active';
                         } ?>">
                        <i class="nav-icon fas fa-list fa-xm"></i>
                        <p>Dana Info</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url('User_keuangan/WajibBayar'); ?>" class="nav-link <?php if ($aktif == 'WajibBayar') {
                         } ?>">
                        <i class="nav-icon far fa-money-bill-alt"></i>
                        <p>
                          Pembayaran
                        </p>
                      </a>
                    </li>
                  </ul>
                </li>

              <?php } ?>
            </ul>
          </li>
        <?php } ?>

        <?php if ($GR1 === TRUE) { ?>
          <li class="nav-header">Menu Guru Pengajar</li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($aktif == 'Absensi' || $aktif == 'Penilaian') {
              echo 'active';
            } ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Siswa
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('User_pengajar/Absensi'); ?>" class="nav-link <?php if ($aktif == 'Absensi') {
                     echo 'active';
                   } ?>">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Absensi
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('User_pengajar/RekapAbsensi'); ?>" class="nav-link <?php if ($aktif == 'RekapAbsensi') {
                     echo 'active';
                   } ?>">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Rekapitulasi Absensi
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('User_pengajar/Penilaian'); ?>" class="nav-link <?php if ($aktif == 'Penilaian') {
                     echo 'active';
                   } ?>">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Penilaian
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Indra Gunawan Ardiansyah || 25 Januari 2024 -->
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($aktif == 'Jurnal') {
              echo 'active';
            } elseif ($aktif == 'RekapitulasiJurnal') {
              echo 'active';
            } ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Guru
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php foreach ($Fitur as $FA) {
                if ($FA->NamaFitur == 'JurnalGuru' && $FA->Aktivasi == 'Aktif') {
                  ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_pengajar/Jurnal'); ?>" class="nav-link <?php if ($aktif == 'Jurnal') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-book"></i>
                      <p>
                        Jurnal
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('User_pengajar/RekapitulasiJurnal'); ?>" class="nav-link <?php if ($aktif == 'RekapitulasiJurnal') {
                         echo 'active';
                       } ?>">
                      <i class="nav-icon fas fa-book"></i>
                      <p>
                        Rekapitulasi Jurnal
                      </p>
                    </a>
                  </li>
                  <?php
                }
              } ?>
            </ul>
          </li>
          <!-- Indra Gunawan Ardiansyah || 25 Januari 2024 -->
        <?php } ?>

        <?php foreach ($Fitur as $FA) {
          if ($FA->NamaFitur == 'TataTertib' && $FA->Aktivasi == 'Aktif') {
            $TataTertib = true;
          }
        } ?>

        <?php
        if ($TataTertib == true) {
          if ($GBK === TRUE) { ?>
            <li class="nav-header">Menu Bimbingan Konseling</li>
            <li class="nav-item">
              <a href="#" class="nav-link <?php if ($aktif == 'BKIndividu') {
                echo 'active';
              } ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Siswa
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link <?php if ($aktif == 'BKIndividu') {
                    echo 'active';
                  } ?>">
                    <i class="nav-icon far fa-calendar-alt"></i>
                    <p>
                      Poin Pelanggaran
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url('User_bk/BKIndividu'); ?>" class="nav-link <?php if ($aktif == 'BKIndividu') {
                           echo 'active';
                         } ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Individu</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link <?php if ($aktif == 'BKKelas') {
                        echo 'active';
                      } ?>">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Kelas</p>
                      </a>
                    </li>

                  </ul>
                </li>

              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link <?php if ($aktif == 'BKSkoringSetting' || $aktif == 'BKSkoringPelanggaran') {
                echo 'active';
              } ?>">
                <i class="nav-icon fas fa-book-reader"></i>
                <p>
                  Skoring
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('User_bk/BKSkoringSetting'); ?>" class="nav-link <?php if ($aktif == 'BKSkoringSetting') {
                       echo 'active';
                     } ?>">
                    <i class="fas fa-cogs"></i>
                    <p>Skoring Setting</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('User_bk/BKSkoringPelanggaran'); ?>" class="nav-link <?php if ($aktif == 'BKSkoringPelanggaran') {
                     } ?>">
                    <i class="far fa-list-alt"></i>
                    <p>Data Pelanggaran</p>
                  </a>
                </li>


              </ul>
            </li>

            <?php if ($MATIKAN == false) { ?>
            <?php } ?>

            <?php
            if ($SuratDigital == true) {
              ?>
              <li class="nav-item">
                <a href="<?php echo base_url('User_bk/'); ?>SuratDigital" class="nav-link <?php if ($aktif == 'SuratDigitalBK') {
                     echo 'active';
                   } ?>">
                  <i class="nav-icon fas fa-envelope"></i>
                  <p>
                    Surat Digital
                  </p>
                </a>
              </li>
              <?php
            }
            ?>





          <?php }
        } ?>

        <?php
        if ($TataTertib == true) {
          ?>

          <?php if ($GR1 === TRUE || $SU === TRUE || $KPLS === TRUE || $WLIK === TRUE || $GBK === TRUE) { ?>
            <li class="nav-header">Menu Laporan Pelanggaran</li>
            <li class="nav-item">
              <a href="#" class="nav-link <?php if ($aktif == 'LaporPelanggaran') {
                echo 'active';
              } ?>">
                <i class="nav-icon fas fa-exclamation-circle"></i>
                <p>
                  Laporkan!
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('User_halaman/LaporPelanggaran'); ?>" class="nav-link <?php if ($aktif == 'LaporPelanggaran') {
                       echo 'active';
                     } ?>">
                    <i class="nav-icon fas fa-exclamation-triangle"></i>
                    <p>Laporkan Pelanggaran!</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } ?>

          <?php
        }
        ?>

        <li class="nav-header">Tugas Tambahan</li>
        <ul id="navItemDinamis" class="nav nav-pills nav-sidebar flex-column">
        </ul>
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item" id="navitemdinamis">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Edit <i>(On Building...)</i>
              </p>
            </a>
          </li>
        </ul>
        <script>
          $(document).ready(function () {
            // Fungsi untuk mengambil data JSON dari URL/API
            function ambilDataTugas() {
              var token = '<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>';

              $.ajax({
                url: '<?php echo base_url('API/TugasTambahan'); ?>',
                type: 'GET',
                dataType: 'json',
                data: { Token: token }, // Mengirim token dengan method GET
                success: function (data) {
                  // Iterasi melalui data JSON dan menambahkan elemen <li> dengan nama tugas
                  $.each(data, function (index, tugas) {
                    var li = $('<li>').addClass('nav-item nav-item-animation');
                    var a = $('<a>').attr('href', '#').addClass('nav-link');
                    var icon = $('<i>').addClass('nav-icon fas fa-exclamation-circle');
                    var p = $('<p>').html(tugas.NamaTugas);

                    a.append(icon);
                    a.append(p);
                    li.append(a);

                    // Sisipkan li sebelum elemen dengan id "navitemdinamis"
                    $('#navitemdinamis').before(li);
                  });
                },
                error: function (xhr, status, error) {
                  console.error('Terjadi kesalahan:', error);
                }
              });
            }

            // Panggil fungsi untuk mengambil dan menampilkan data tugas saat halaman dimuat
            ambilDataTugas();
          });
        </script>

        <?php
        foreach ($HakAkses as $HAT) {
          if ($HAT->IDHak > 6) {
            $Extra = false;
            for ($i = 0; $i < count($cek); $i++) {
              if ($cek[$i] == $HAT->IDHak) {
                $Extra = TRUE;
              }
            }
            if ($Extra == TRUE) {
              ?>
              <li class="nav-header">Menu Jurnal Kegiatan
                <?= $HAT->NamaHak ?>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('User_custom/JurnalAdd/' . $HAT->IDHak); ?>" class="nav-link <?php if ($aktif == $HAT->IDHak && isset ($Halaman) && $Halaman == 'TambahJurnal') {
                       echo 'active';
                     } ?>">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    Tambahkan Jurnal
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('User_custom/JurnalPreview/' . $HAT->IDHak); ?>" class="nav-link <?php if ($aktif == $HAT->IDHak && isset ($Halaman) && $Halaman == 'JurnalPreview') {
                       echo 'active';
                     } ?>">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    Rekapitulasi Jurnal
                  </p>
                </a>
              </li>

            <?php }
          }
        } ?>


        <?php foreach ($Fitur as $FA) {
          if ($FA->NamaFitur == 'SiAdik' && $FA->Aktivasi == 'Aktif') {
            $SiAdik = true;
          }
        } ?>
        <?php if ($SiAdik == true) { ?>
          <li class="nav-header">Si ADik</li>
          <li class="nav-item">
            <a href="<?php echo base_url('User_Beta/SiAdik'); ?>" class="nav-link <?php if ($aktif == 'SiAdik') {
                 echo 'active';
               } ?>">
              <i class="nav-icon fas fa-microchip"></i>
              <p>
                Si Adik (A.I.)
              </p>
            </a>
          </li>
          <?php
        }
        ?>


        <li class="nav-header">Pengaturan</li>
        <li class="nav-item">
          <a href="<?php echo base_url('User_login/aksi_logout'); ?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Keluar
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<?php if ($GR1 === TRUE || $GBK === TRUE) { ?>

<?php } ?>