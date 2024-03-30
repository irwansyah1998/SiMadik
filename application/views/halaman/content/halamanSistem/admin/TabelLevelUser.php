<script>
    function removeSpecialChars(input) {
        // Hapus semua spasi dan karakter khusus dari nilai input
        input.value = input.value.replace(/[^\w\s]/gi, '').replace(/\s+/g, '');
    }
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-with-overlay">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 animate__animated animate__fadeInLeft">
            <h1 class="m-0">Tabel Hak Akses</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 animate__animated animate__fadeInRight">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Hak Akses</li>
              <li class="breadcrumb-item">Tabel Pengguna</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <div class="card card-secondary">
          <div class="card-header">
            <div class="card-tools">
              <div class="btn-group shadow">
                <button type="button" onclick="openTambahModal()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tabelcustom" class="table table-bordered table-striped shadow">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Kode Hak Akses</th>
                  <th>Jenis Hak Akses</th>
                  <th>Nama Hak Akses</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
              <tfoot>
                <tr>
                  <th width="5%">No</th>
                  <th>Kode Hak Akses</th>
                  <th>Jenis Hak Akses</th>
                  <th>Nama Hak Akses</th>
                  <th>Actions</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <div class="bright-overlay"></div>
</div>

<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Data Hak Akkses</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="modal-buffer" style="display: none;">
          <!-- Tampilan buffer di sini -->
          </div>
          <input type="hidden" name="IDHak" id="IDHak">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Kode Hak Akses :</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                  </div>
                  <input type="text" class="form-control" name="KodeHak" id="KodeHak" placeholder="Kode Hak Akses...." title="Masukkan Kode Hak Akses!" value="" oninput="removeSpecialChars(this)">
                </div>
                            <!-- /.input group -->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jenis Hak Akses :</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                  </div>
                  <input type="text" class="form-control" name="JenisHak" id="JenisHak" placeholder="Jenis Hak Akses...." title="Masukkan Jenis Hak Akses!" value="">
                </div>
                            <!-- /.input group -->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama Hak Akses :</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                  </div>
                  <input type="text" class="form-control" name="Nama" id="NamaHak" placeholder="Ruangan Kelas...." title="Masukkan Nama Hak Akses!" value="">
                </div>
                            <!-- /.input group -->
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="button" disabled="true" id="SimpanData" class="btn btn-primary" onclick="SimpanDataHak()">Simpan</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="HapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="modal-buffer" style="display: none;">
          <!-- Tampilan buffer di sini -->
          </div>
          <input type="hidden" name="IDHak" id="IDHakHapus">
          <div class="row">
            <div class="col-md-12">
              <p>Apakah Anda Yakin Ingin Menghapus Data?</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
          <button type="button" id="HapusData" class="btn btn-danger" onclick="HapusDataHak()">Hapus</button>
        </div>
      </div>
    </div>
</div>

<script>
  document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });


</script>

<script>
    $(document).ready(function() {
        // Mengecek setiap kali nilai input berubah
        $('#KodeHak, #JenisHak, #NamaHak').on('input', function() {
            // Mengambil nilai dari setiap input
            var kodeHak = $('#KodeHak').val();
            var jenisHak = $('#JenisHak').val();
            var namaHak = $('#NamaHak').val();
            
            // Memeriksa apakah salah satu nilai kosong
            if (kodeHak === '' || jenisHak === '' || namaHak === '') {
                // Jika salah satu nilai kosong, menonaktifkan tombol Simpan
                $('#SimpanData').prop('disabled', true);
            } else {
                // Jika tidak ada nilai yang kosong, mengaktifkan tombol Simpan
                $('#SimpanData').prop('disabled', false);
            }
        });
    });

    $(document).ready(function() {
        var idGuru = "<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>";

        $('#tabelcustom').DataTable({
            "responsive": true,
            "info": true,
            "paging": true,
            "lengthMenu": [25, 50, 100, 250, 500, 1000, 2000],
            "processing": true,
            "serverSide": true,
            "ajax": {
                // Perbarui URL sesuai dengan controller Anda
                "url": "<?php echo base_url('API/DTHakAkses'); ?>",
                "type": "POST",
                "data": function (d) {
                    // Kirim parameter tambahan jika diperlukan
                    d.IDGuru = idGuru;
                }
            },
            "columns": [
                { 
                    "data": null,
                    "render": function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "orderable": false
                },
                { "data": "KodeHak", "orderable": true }, // Kolom ini diurutkan
                { "data": "JenisHak", "orderable": false }, // Kolom ini diurutkan
                { "data": "NamaHak", "orderable": false }, // Kolom ini diurutkan
                {
                  "data": null,
                  "render": function (data, type, row) {
                      var buttonDisabled = data.IDHak < 7 ? 'disabled' : ''; // mengecek jika IDHak kurang dari 6 karakter
                      var buttonTitle = data.IDHak < 7 ? 'Anda tidak dapat merubah sistem!' : ''; // menentukan judul tooltip berdasarkan panjang IDHak
                      return '<button type="button" class="btn btn-info" onclick="openEditModal(\''+ data.IDHak +'\')" ' + buttonDisabled + ' title="' + buttonTitle + '">Edit</button><button type="button" class="btn btn-danger" onclick="openHapusModal(\''+ data.IDHak +'\')" ' + buttonDisabled + ' title="' + buttonTitle + '">Hapus</button>';s // Perubahan di sini
                  },
                  "orderable": false
                }
            ],
            "order": [[1, 'desc']], // Mengurutkan kolom Tanggal Absensi secara default dari yang terbaru
            "drawCallback": function(settings) {
                var api = this.api();
                var response = api.ajax.json();
                console.log(response);
            }
        });

    });

    function openTambahModal() {
      // Membersihkan nilai input pada modal
      $('#IDHak').val('');
      $('#KodeHak').val('');
      $('#JenisHak').val('');
      $('#NamaHak').val('');
      
      // Tampilkan modal
      $('#EditModal').modal('show');
      $('#modal-buffer').hide();
    }

    function openHapusModal(IDHak){
      document.getElementById('IDHakHapus').value = IDHak;
      $('#HapusModal').modal('show');
    }

    function openEditModal(IDHak) {
      var Token = "<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>";
      console.log('Memilih Menu Edit :' + IDHak);
      // Set nilai IDHak ke input KodeHak pada modal
      document.getElementById('IDHak').value = IDHak;
      // Tampilkan modal
      $('#EditModal').modal('show');
      // Tampilkan buffer
      $('#modal-buffer').show();

      // Memanggil data dari API menggunakan Ajax
      $.ajax({
          url: '<?php echo base_url('API/HakAksesCRUD'); ?>',
          type: 'GET',
          dataType: 'json',
          data: { IDHak: IDHak, token: Token }, // Mengirim token sebagai bagian dari data
          success: function(response) {
              // Handle response data di sini
              // console.log(response);
              // Sembunyikan buffer setelah respons selesai
              document.getElementById('KodeHak').value = response.data[0].KodeHak;
              document.getElementById('JenisHak').value = response.data[0].JenisHak;
              document.getElementById('NamaHak').value = response.data[0].NamaHak;
              $('#modal-buffer').hide();
          },
          error: function(xhr, status, error) {
              // Handle error di sini
              console.error(xhr.responseText);
          }
      });
    }

    function HapusDataHak(){
      var Token = "<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>";
      $('#modal-buffer').show();
      var IDHak = $('#IDHakHapus').val();
      $.ajax({
          url: '<?php echo base_url('API/HakAksesCRUD'); ?>',
          type: 'DELETE',
          dataType: 'json',
          data: { IDHak: IDHak, token: Token }, // Mengirim token sebagai bagian dari data
          success: function(response) {
                  // Handle respons dari server jika diperlukan
                  console.log(response);
                  if (response.tugas === 'Berhasil') {
                      // Menutup modal
                      $('#HapusModal').modal('hide');
                      // Menampilkan toast success
                      toastr.success(response.msg);
                      // Muat ulang tabel
                      $('#tabelcustom').DataTable().ajax.reload();
                  } else {
                      toastr.error('Gagal melakukan operasi.'); // Menampilkan toast error jika tugas tidak berhasil
                  }
              },
          error: function(xhr, status, error) {
              // Handle error di sini
              console.error(xhr.responseText);
          }
      });
    }

    function SimpanDataHak() {
      $('#modal-buffer').show();
      // Mengambil nilai input dari modal
      var Token = "<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>";
      var IDHak = $('#IDHak').val();
      var KodeHak = $('#KodeHak').val();
      var JenisHak = $('#JenisHak').val();
      var NamaHak = $('#NamaHak').val();

      // Melakukan pengecekan apakah IDHak tidak kosong atau null
      if (IDHak !== null && IDHak !== '') {
          // Melakukan operasi yang diperlukan, contoh: mengirim data ke server menggunakan AJAX
          $.ajax({
              url: '<?php echo base_url('API/HakAksesCRUD'); ?>',
              type: 'PATCH', // Menggunakan metode PATCH
              data: {
                  IDHak: IDHak,
                  KodeHak: KodeHak,
                  JenisHak: JenisHak,
                  NamaHak: NamaHak,
                  token: Token
              },
              success: function(response) {
                  // Handle respons dari server jika diperlukan
                  console.log(response);
                  if (response.tugas === 'Berhasil') {
                      // Menutup modal
                      $('#EditModal').modal('hide');
                      // Menampilkan toast success
                      toastr.success(response.msg);
                      // Muat ulang tabel
                      $('#tabelcustom').DataTable().ajax.reload();
                  } else {
                      toastr.error('Gagal melakukan operasi.'); // Menampilkan toast error jika tugas tidak berhasil
                  }
              },
              error: function(xhr, status, error) {
                  // Handle kesalahan jika ada
                  console.error(xhr.responseText);
                  toastr.error('Terjadi kesalahan saat menyimpan data.');
              }
          });
      } else {
        // Jika IDHak kosong atau null, lakukan AJAX dengan method POST
        $.ajax({
            url: '<?php echo base_url('API/HakAksesCRUD'); ?>',
            type: 'POST', // Menggunakan metode POST
            data: {
                KodeHak: KodeHak,
                JenisHak: JenisHak,
                NamaHak: NamaHak,
                token: Token
            },
            success: function(response) {
                // Handle respons dari server jika diperlukan
                console.log(response);
                if (response.tugas === 'Berhasil') {
                    // Menutup modal
                    $('#EditModal').modal('hide');
                    // Menampilkan toast success
                    toastr.success(response.msg);
                    $('#tabelcustom').DataTable().ajax.reload();
                } else {
                    toastr.error('Gagal melakukan operasi.'); // Menampilkan toast error jika tugas tidak berhasil
                }
            },
            error: function(xhr, status, error) {
                // Handle kesalahan jika ada
                console.error(xhr.responseText);
                toastr.error('Terjadi kesalahan saat menyimpan data.');
            }
        });
      }
    }


</script>

