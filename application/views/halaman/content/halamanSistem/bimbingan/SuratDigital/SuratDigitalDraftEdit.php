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
<style type="text/css">
  /* CSS untuk menetapkan z-index pada modal */
.modal {
    z-index: 1050; /* Atur nilai z-index sesuai kebutuhan */
}

#BuatSuratID{
  z-index: 9999;
}

/* CSS untuk mengatasi modal-backdrop */
.modal-backdrop {
    z-index: -1; /* Atur nilai z-index yang lebih rendah dari modal */
}
</style>
  <script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/summernote/summernote-bs4.min.js"></script>
  <?= form_open(base_url('User_bk/SuratDigitalBuat/Kirim')) ?>
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
                  <li class="breadcrumb-item active">Edit</li>
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
              <a href="<?=base_url('User_bk/')?>SuratDigitalBuat" class="btn btn-primary btn-block mb-3 shadow"><i class="fas fa-envelope-open-text"></i> Buat Surat Baru</a>

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
                      <a href="<?=base_url('User_bk/')?>SuratDigital" class="nav-link">
                        <i class="far fa-envelope"></i> Terkirim
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?=base_url('User_bk/')?>SuratDigitalDraft" class="nav-link active">
                        <i class="far fa-file-alt"></i> Rancangan
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
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
                  <h3 class="card-title">Edit Surat</h3>

                  <div class="card-tools">
                    
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <input type="hidden" name="IDSuratDigital" value="<?=$IDSurat?>">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input required name="Subjek" class="form-control" value="<?=$SubjekSurat?>" placeholder="Subject:">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input required name="Keterangan" class="form-control" value="<?=$Keterangan?>" placeholder="Keterangan:">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <textarea name="IsiSurat" id="compose-textarea" class="form-control"><?=$IsiSurat?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="button" id="btnSave" class="btn btn-secondary"><i class="far fa-save"></i> Save</button>
                    <div class="float-right">
                      <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                    </div>
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
      $(function () {
        //Add text editor
        $('#compose-textarea').summernote()
      })

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

      // Fungsi untuk melakukan simpan data melalui AJAX
      $('#btnSave').click(function() {
        var btnSave = $(this); // Memuat tombol 'Save' sebagai variabel
        var btnIcon = btnSave.find('i'); // Memuat ikon pada tombol 'Save'

        // Mengubah tampilan tombol menjadi disabled dan menampilkan ikon loading
        btnSave.prop('disabled', true);
        btnIcon.removeClass('fa-save').addClass('fa-spinner fa-spin');

        var dataForm = {
            'IDSurat': $('input[name="IDSuratDigital"]').val(),
            'Token': '<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>',
            'Subjek': $('input[name="Subjek"]').val(),
            'Keterangan': $('input[name="Keterangan"]').val(),
            'IsiSurat': $('#compose-textarea').val()
            // Tambahkan data lainnya jika diperlukan
        };

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            type: 'POST',
            url: '<?= base_url("User_bk/ServerSideSave") ?>',
            data: dataForm,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Tampilkan toast jika penyimpanan berhasil
                    toastr.success('Data surat berhasil disimpan!');
                } else {
                    // Tampilkan toast jika terjadi kesalahan saat menyimpan data
                    toastr.error('Gagal menyimpan data surat.');
                }

                // Mengembalikan tampilan tombol ke kondisi semula
                btnSave.prop('disabled', false);
                btnIcon.removeClass('fa-spinner fa-spin').addClass('fa-save');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);

                // Mengembalikan tampilan tombol ke kondisi semula
                btnSave.prop('disabled', false);
                btnIcon.removeClass('fa-spinner fa-spin').addClass('fa-save');
            }
        });
      });


    });
  </script>