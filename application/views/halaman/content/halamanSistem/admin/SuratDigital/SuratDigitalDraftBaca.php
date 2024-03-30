<?php
 function konversiFormatTanggal($waktu_asli) {
    // Konversi ke objek DateTime
    $objek_waktu = DateTime::createFromFormat('Y-m-d H:i:s', $waktu_asli);

    // Jika konversi berhasil, format ulang tanggal
    if ($objek_waktu instanceof DateTime) {
        return $objek_waktu->format('j M. Y H:i');
    } else {
        return "Format waktu tidak valid.";
    }
}

// print_r($SuratDigitalBaca);
foreach ($SuratDigitalBaca as $SDB) {
  $IDSurat = $SDB->IDSurat;
  $IDHakSurat = $SDB->IDHakSurat;
  $KategoriSurat = $SDB->KategoriSurat;
  $FilterKategori = $SDB->FilterKategori;
  $IDIzin = $SDB->IDIzin;
  $TanggalSurat = konversiFormatTanggal($SDB->TanggalSurat);
  $SubjekSurat = $SDB->SubjekSurat;
  $Keterangan = $SDB->Keterangan;
  $IsiSurat = $SDB->IsiSurat;
  $status = $SDB->status;
  $Guru_IDGuru = $SDB->Guru_IDGuru;
  $UsrGuru = $SDB->UsrGuru;
  $KodeGuru = $SDB->KodeGuru;
  $NamaGuru = $SDB->NamaGuru;
  $NomorIndukGuru = $SDB->NomorIndukGuru;
  $KodeMapel = $SDB->KodeMapel;
  $NomorHP = $SDB->NomorHP;
}
?>
  <script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/summernote/summernote-bs4.min.js"></script>
  <?= form_open(base_url('User_admin/SuratDigitalBuat/Kirim')) ?>
    <div class="content-wrapper">
      <div class="content-with-overlay">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Rancangan Surat Digital</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right animate__animated animate__fadeInRight">
                  <li class="breadcrumb-item active">Lihat</li>
                  <li class="breadcrumb-item">Rancangan Surat</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">
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
                    <a href="<?=base_url('User_admin/')?>SuratDigitalDraft" class="nav-link active">
                      <i class="far fa-file-alt"></i> Rancangan
                    </a>
                  </li>
                    <li class="nav-item">
                      <a href="<?=base_url('User_admin/')?>SuratDigitalHapus" class="nav-link">
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
              <div class="card card-primary card-outline shadow">
                  <div class="card-header">
                      <h3 class="card-title">Lihat Rancangan</h3>
                      <div class="card-tools">
                          <!-- Tombol alat atau aksi lainnya -->
                      </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                      <div class="mailbox-read-info">
                          <h4><?= $SubjekSurat ?></h4>
                          <h6>Dari: <?= $NamaGuru ?>
                              <span class="mailbox-read-time float-right"><?= $TanggalSurat ?></span>
                          </h6>
                      </div>
                      <!-- /.mailbox-read-info -->
                      <div class="mailbox-controls with-border text-center">
                          <div class="btn-group">
                              <!-- Tombol-tombol kontrol surat -->
                              <a href="<?=base_url('User_admin/SuratDigitalDraft/Edit/'.$IDSurat)?>" class="btn btn-default btn-sm" title="Edit">
                              <i class="fas fa-edit"></i></a>
                              <button type="button" data-toggle="modal" data-target="#deleteModal<?= $IDSurat ?>" class="btn btn-default btn-sm" title="Hapus">
                              <i class="fas fa-trash-alt"></i></button>
                          </div>
                          <!-- /.btn-group -->
                          <button type="button" class="btn btn-default btn-sm" title="Print">
                              <i class="fas fa-print"></i>
                          </button>
                      </div>
                      <!-- /.mailbox-controls -->
                      <div class="mailbox-read-message">
                          <!-- Isi surat ditampilkan di sini -->
                          <?= $IsiSurat ?>
                      </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                      <!-- Footer atau informasi tambahan -->
                  </div>
              </div>
              <!-- /.card -->
            </div>

            <!-- /.col -->
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
      </div>
      <div class="bright-overlay"></div>
    </div>
  <?= form_close() ?>

  <script>
    $(document).ready(function() {
      function periksaKategoriSurat() {
        if ($('#KategoriSurat').val() === 'Semua') {
          $('#FilterKategori').prop('disabled', true);
          $('#filterKategoriRow').hide();
        } else {
          $('#FilterKategori').prop('disabled', false);
          $('#filterKategoriRow').show();
        }
      }

      periksaKategoriSurat();

      $('#KategoriSurat').change(function() {
        periksaKategoriSurat();
      });
    });
  </script>
  <script>
  $(function () {
    //Add text editor
    $('#compose-textarea').summernote()
  })
</script>

                    <div class="modal fade" id="deleteModal<?= $IDSurat ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menghapus surat ini?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <a href="<?=base_url('User_admin/SuratDigitalCRUD/Hapus/'.$IDSurat)?>" class="btn btn-danger">Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>