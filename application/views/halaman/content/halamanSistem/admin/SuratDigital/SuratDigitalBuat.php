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
  <?= form_open(base_url('User_admin/SuratDigitalBuat/Kirim')) ?>
    <div class="content-wrapper">
      <div class="content-with-overlay">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Surat Digital</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right animate__animated animate__fadeInRight">
                  <li class="breadcrumb-item active">Buat Surat Baru</li>
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
                      <a href="<?=base_url('User_admin/')?>SuratDigitalDraft" class="nav-link">
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

              <div class="card card-primary card-outline shadow animate__animated animate__fadeInLeft">
                <div class="card-header">
                  <h3 class="card-title">Tujuan :</h3>

                  <div class="card-tools">
                    
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <select name="KategoriSurat" id="KategoriSurat" class="form-control select2" data-placeholder="Pilih Kategori Pengiriman">
                          <option value="Semua">Semua</option>
                          <option value="Khusus">Khusus</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <select name="FilterKategori" id="FilterKategori" class="form-control select2" data-placeholder="Pilih Kategori Pengiriman">
                          <option value="Guru">Guru/Staff</option>
                          <option value="Wali Murid">Wali Murid</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    
                  </div>

              </div>
              
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card card-primary card-outline shadow" id="BuatSuratID">
                <div class="card-header">
                  <h3 class="card-title">Buat Surat</h3>

                  <div class="card-tools">
                    
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <input type="hidden" name="IDSuratDigital" value="0">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input required name="Subjek" class="form-control" placeholder="Subject:">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input required name="Keterangan" class="form-control" placeholder="Keterangan:">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <textarea name="IsiSurat" id="compose-textarea" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="button" id="btnSave" class="btn btn-secondary"><i class="far fa-save"></i> Simpan Ke Rancangan</button>
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
      
      $('#myModal').on('shown.bs.modal', function() {
        $('.modal-backdrop').css('display', 'none');
      });

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
            'KategoriSurat': $('#KategoriSurat').val(),
            'Subjek': $('input[name="Subjek"]').val(),
            'Keterangan': $('input[name="Keterangan"]').val(),
            'IsiSurat': $('#compose-textarea').val()
            // Tambahkan data lainnya jika diperlukan
        };

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            type: 'POST',
            url: '<?= base_url("User_admin/ServerSideSave") ?>',
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