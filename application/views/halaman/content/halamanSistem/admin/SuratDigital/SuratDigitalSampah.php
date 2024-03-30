<?php
 function hitungSelisihWaktu($waktu_dari_database) {
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
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Surat Digital Yang Terhapus</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right animate__animated animate__fadeInRight">
                <li class="breadcrumb-item active">Terhapus</li>
                <li class="breadcrumb-item">Surat Digital</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-3 animate__animated animate__fadeInLeft">
            <a href="<?=base_url('User_admin/')?>SuratDigitalBuat" class="btn btn-primary btn-block mb-3 shadow"><i class="fas fa-envelope-open-text"></i> Buat Surat Baru</a>

            <div class="card shadow animate__animated animate__fadeInLeft">
              <div class="card-header">
                <h3 class="card-title">Menu Surat</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a href="<?=base_url('User_admin/')?>SuratDigital" class="nav-link">
                      <i class="far fa-envelope"></i> Terkirim
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url('User_admin/')?>SuratDigitalDraft" class="nav-link">
                      <i class="far fa-file-alt"></i> Rancangan
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url('User_admin/')?>SuratDigitalHapus" class="nav-link active">
                      <i class="far fa-trash-alt"></i> Terhapus
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <?= form_open_multipart(base_url('User_admin/SuratHapusPermanenMany'), array('method' => 'post','id' => 'deleteForm')); ?>
              <div class="card card-primary card-outline shadow animate__animated animate__fadeInRight">
                <div class="card-header">
                  <h3 class="card-title">Surat Yang Dihapus</h3>

                  <div class="card-tools">
                    
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <?php if ($SuratDigital!==false) { ?>
                    <div class="mailbox-controls">
                        <!-- Check all button -->
                          <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                          </button>
                        <div class="btn-group">
                          <button type="button" class="btn btn-default btn-sm" id="deleteSelectedBtn" data-toggle="modal" data-target="#confirmDeleteModal">
                            <i class="far fa-trash-alt"></i> Hapus
                          </button>
                        </div>
                        <!-- /.btn-group -->
                        
                        <!-- /.float-right -->
                      </div>
                  <?php } ?>
                  <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                      <tbody>
                        <?php if ($SuratDigital!==false) {
                          foreach ($SuratDigital as $SD) {
                          ?>
                            
                          <tr>
                            <td>
                                <div class="icheck-primary">
                                  <input type="checkbox" name="IDSurat[]" value="<?=$SD->IDSurat?>" id="check<?=$SD->IDSurat?>">
                                  <label for="check<?=$SD->IDSurat?>"></label>
                                </div>
                            </td>
                            <td class="mailbox-name">
                              <a href="<?=base_url('User_admin/SuratDigitalHapus/Baca/'.$SD->IDSurat)?>">
                              <?=$SD->NamaGuru?>
                              </a>
                            </td>
                            <td class="mailbox-subject">
                              <a href="<?=base_url('User_admin/SuratDigitalHapus/Baca/'.$SD->IDSurat)?>">
                                <b><?=$SD->SubjekSurat?></b> - <?=$SD->Keterangan?>
                              </a>
                            </td>
                            <td class="mailbox-attachment"><?=$SD->KategoriSurat?></td>
                            <td class="mailbox-date">
                              <?php 
                              $selisih_waktu = hitungSelisihWaktu($SD->TanggalSurat);
                              if (isset($selisih_waktu['selisih_hari'])) {
                                  echo $selisih_waktu['selisih_hari'];
                              } elseif (isset($selisih_waktu['selisih_jam'])) {
                                  echo $selisih_waktu['selisih_jam'];
                              } elseif (isset($selisih_waktu['selisih_menit'])) {
                                  echo $selisih_waktu['selisih_menit'];
                              }
                              ?>
                          </td>

                          </tr>
                          <?php
                          }
                        } ?>
                      </tbody>
                    </table>
                    <!-- /.table -->
                  </div>
                </div>
              </div>
              <!-- /.card -->
            <?= form_close(); ?>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <div class="bright-overlay"></div>
  </div>

  <script>
  $(function () {
    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function () {
      var clicks = $(this).data('clicks')
      if (clicks) {
        //Uncheck all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
      } else {
        //Check all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
      }
      $(this).data('clicks', !clicks)
    })

    //Handle starring for font awesome
    $('.mailbox-star').click(function (e) {
      e.preventDefault()
      //detect type
      var $this = $(this).find('a > i')
      var fa    = $this.hasClass('fa')

      //Switch states
      if (fa) {
        $this.toggleClass('fa-star')
        $this.toggleClass('fa-star-o')
      }
    })
  })
</script>

  <!-- Modal Konfirmasi Hapus -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Penghapusan Secara Permanen!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus permanen data terpilih?<br>
          <i>NB : Melakukan perintah ini akan membuat data yang dipilih hilang! Anda yakin?</i>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Hapus</a>
        </div>
      </div>
    </div>
  </div>


  <script>
    // Penghapusan Data
    $(document).ready(function () {
      $('#confirmDeleteBtn').on('click', function (e) {
        e.preventDefault();

        // Eksekusi Penghapusan Data
        $('#deleteForm').submit();
      });
    });
  </script>
