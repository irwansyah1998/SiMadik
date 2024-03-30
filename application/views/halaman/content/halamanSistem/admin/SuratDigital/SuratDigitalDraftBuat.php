  <script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/summernote/summernote-bs4.min.js"></script>
  <?= form_open(base_url('User_admin/SuratDigitalDraftCRUD/Simpan')) ?>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Rancangan Surat Digital</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right animate__animated animate__fadeInRight">
                <li class="breadcrumb-item active">Buat Rancangan Baru</li>
                <li class="breadcrumb-item">Rancangan</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-3">
            <a href="<?=base_url('User_admin/')?>SuratDigitalBuat" class="btn btn-primary btn-block mb-3 shadow"><i class="fas fa-envelope-open-text"></i> Buat Rancangan Baru</a>

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
                    <a href="<?=base_url('User_admin/')?>SuratDigitalHapus" class="nav-link">
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
            <div class="card card-primary card-outline shadow">
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
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Simpan Rancangan</button>
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