<style>
.img-preview {
    max-width: 100%; /* Gambar tidak melebihi lebar form-group */
    height: auto; /* Biarkan tinggi gambar mengikuti proporsi aslinya */
}  
</style>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6 animate__animated animate__fadeInLeft">
                <h1 class="m-0">Tambahkan Jurnal Kegiatan </h1>
              </div><!-- /.col -->
              <div class="col-sm-6 animate__animated animate__fadeInRight">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Tambah</li>
                  <li class="breadcrumb-item">Jurnal Kegiatan</li>
                </ol>
              </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        
        <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <div class="card card-primary shadow animate__animated animate__fadeInLeft">
                          <div class="card-header">
                              <h2 class="card-title m-0"></h2>
                              
                          </div>

                          <!-- /.card-header -->
                          <div class="card-body">
                            <input type="hidden" id="IDJurnal" name="IDJurnal" value="">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Tanggal:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input id="TanggalJurnal" name="TanggalJurnal" type="text" class="form-control datetimepicker-input" data-target="#reservationdate" value="" required>
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
                                  <label>Kegiatan:</label>
                                  <textarea id="Kegiatan" name="Kegiatan" class="form-control"></textarea>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Keterangan:</label>
                                  <textarea id="Keterangan" name="Keterangan" class="form-control"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <input type="hidden" name="gambar" id="gambarUploaded" value="">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label>Gambar :</label>
                                      <div id="progressbar"></div>
                                      <img id="imgPreview" class="img-preview" src="#" alt="Preview Gambar" style="display: none; max-width: 100%;">
                                      <div class="custom-file">
                                          <input type="file" accept=".jpg, .jpeg .png" class="custom-file-input" id="customFile">
                                          <label class="custom-file-label" for="customFile">Pilih file</label>
                                      </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <!-- /.card-body -->

                          <div class="card-footer">
                            <div class="card-tools">
                              <div class="btn-group shadow">
                                <button type="button" onclick="TambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Simpan</button>
                              </div>
                            </div>
                          </div>
                      </div>

                  </div>
              </div>
              <!-- ROW -->

          <!-- /.container-fluid -->
          </div>

      </div>
              <!-- /.card -->
    </div>
    <div class="bright-overlay"></div>
  </div>
      <!-- /.container-fluid -->
    <!-- /.content -->

  <!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    $('#customFile').change(function() {
      var fileInput = document.getElementById('customFile');
      var file = fileInput.files[0];
      var formData = new FormData();
      formData.append('file', file);

      var token = '<?=$this->encryption->encrypt($this->session->userdata('IDGuru'))?>';
      formData.append('token', token);

      $('#imgPreview').hide();
      $('#imgPreview').attr('src', '');

      $('#progressbar').html('<div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>');

      $.ajax({
        url: '<?=base_url("/API/UploadGambarJurnalKegiatan");?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = (evt.loaded / evt.total) * 100;
              $('.progress-bar').width(percentComplete + '%');
            }
          }, false);
          return xhr;
        },
        success: function(response) {
          toastr.success(response.msg);
          $('#gambarUploaded').val(response.namafile);
          $('#imgPreview').attr('src', '<?=base_url("/file/data/gambar/jurnalkegiatan/sementara/")?>' + response.namafile);
          $('#imgPreview').show();
          $('#progressbar').html('');
        },
        error: function(xhr, status, error) {
          toastr.error('Terjadi kesalahan saat upload file.');
          $('#progressbar').html('');
        }
      });

      var fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $('#TanpaSpasi').on('input', function() {
      $(this).val($(this).val().replace(/[^\w\d]+/g, ''));
    });

    $('#HanyaNomor').on('input', function() {
      $(this).val($(this).val().replace(/\D/g, ''));
    });
  });
</script>


<script>
  function TambahData() {
    // Ambil nilai dari input dan textarea
    var tanggalJurnal = document.getElementById('TanggalJurnal').value.trim();
    var kegiatan = document.getElementById('Kegiatan').value.trim();
    var keterangan = document.getElementById('Keterangan').value.trim();
    var gambarUploaded = document.getElementById('gambarUploaded').value.trim();
    var IDJurnal = document.getElementById('IDJurnal').value.trim();

    // Periksa apakah nilai input atau textarea kosong
    if (tanggalJurnal === '' || kegiatan === '' || keterangan === '' || gambarUploaded === '') {
      // Tampilkan toastr peringatan jika ada nilai yang kosong
      toastr.warning('Semua kolom harus diisi');
      return; // Hentikan proses jika ada nilai yang kosong
    }

    // Jika nilai IDJurnal kosong atau tidak ada, kirim data dengan metode POST
    if (IDJurnal === '') {
      // Kirim data menggunakan AJAX
      $.ajax({
        url: '<?=base_url("API/TambahDataJurnalKegiatan");?>',
        type: 'POST',
        dataType: 'json',
        data: {
              TanggalJurnal : tanggalJurnal,
              Kegiatan : kegiatan,
              Keterangan : keterangan,
              gambar : gambarUploaded,
              IDHak : '<?=$this->encryption->encrypt($IDHak)?>',
              token : '<?=$this->encryption->encrypt($this->session->userdata("IDGuru"))?>',
              IDSemester : '<?=$this->encryption->encrypt($this->session->userdata('IDSemester'))?>',
              IDAjaran: '<?=$this->encryption->encrypt($this->session->userdata('IDAjaran'))?>'
        },
        success: function(response) {
          toastr.success(response.msg);
          var IDJurnalInput = document.getElementById('IDJurnal');
          IDJurnalInput.value = response.data;
        },
        error: function(xhr, status, error) {
          toastr.error('Terjadi kesalahan saat menambahkan data.');
          console.error("Error:", error);
        }
      });
    } else {
      // Kirim data menggunakan AJAX
      $.ajax({
        url: '<?=base_url("API/TambahDataJurnalKegiatan")?>',
        type: 'PATCH',
        dataType: 'json',
        data: {
                  TanggalJurnal : tanggalJurnal,
                  Kegiatan : kegiatan,
                  Keterangan : keterangan,
                  gambar : gambarUploaded,
                  JurnalID : IDJurnal,
                  token : '<?=$this->encryption->encrypt($this->session->userdata("IDGuru"))?>',
                  IDHak : '<?=$this->encryption->encrypt($IDHak)?>'
        },
        success: function(response) {
          toastr.success(response.msg);
          console.log(response);
        },
        error: function(xhr, status, error) {
          toastr.error('Terjadi kesalahan saat menambahkan data.');
          console.error("Error:", error);
        }
      });
    }
  }
</script>