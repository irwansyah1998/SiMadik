<div class="content-wrapper">
  <div class="content-with-overlay">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 animate__animated animate__fadeInLeft">
            <h1 class="m-0">Tabel Murid</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 animate__animated animate__fadeInRight">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Murid</li>
              <li class="breadcrumb-item">Tabel Pengguna</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const noSpecialCharsInput = document.getElementById('noSpecialCharsInputsss');

        if (noSpecialCharsInput) {
          noSpecialCharsInput.addEventListener('input', function() {
            const inputValue = noSpecialCharsInput.value;
            const newValue = inputValue.replace(/[\W_]+/g, ''); // Menghapus semua spasi dan karakter khusus

            if (inputValue !== newValue) {
              noSpecialCharsInput.value = newValue;
            }
          });
        }

        const onlyNumbersInput = document.getElementById('onlyNumbersInputsss');

        if (onlyNumbersInput) {
          onlyNumbersInput.addEventListener('input', function() {
            const inputValue = onlyNumbersInput.value;
            const newValue = inputValue.replace(/[^0-9]/g, ''); // Menghapus semua selain angka

            if (inputValue !== newValue) {
              onlyNumbersInput.value = newValue;
            }
          });
        }
      });
    </script>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <div class="card card-secondary animate__animated animate__fadeIn">
          <div class="card-header">
            <div class="card-tools">
              <div class="btn-group">
                <button data-toggle="modal" data-target="#InsertTabelModal" type="button" class="btn btn-primary">
                  <i class="fa fa-plus"></i> Tambah</button>
                <button data-toggle="modal" data-target="#uploadModal" type="button" class="btn btn-warning"><i class="fas fa-file-import"></i> Import</button>
                <a href="<?php echo base_url('ExportImport'); ?>/TabelMuridExcell" class="btn btn-success">
                  <i class="fas fa-file-export"></i> Export</a>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example15" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Siswa</th>
                  <th>NIS</th>
                  <th>NISN</th>
                  <th>Kelas</th>
                  <th>Wali Kelas</th>
                  <th>Awal Masuk</th>
                  <th>Nama Ayah</th>
                  <th>Nama Ibu</th>
                  <th>Pengaturan</th>
                </tr>
              </thead>
              <tbody id="data-container"></tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama Siswa</th>
                  <th>NIS</th>
                  <th>NISN</th>
                  <th>Kelas</th>
                  <th>Wali Kelas</th>
                  <th>Awal Masuk</th>
                  <th>Nama Ayah</th>
                  <th>Nama Ibu</th>
                  <th>Pengaturan</th>
                </tr>
              </tfoot>
            </table>

            <!-- Modal Peringatan Hapus Data -->

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
<!-- /.content-wrapper -->



<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?php echo base_url('ExportImport/ImportTabelMuridExcell'); ?>" method="POST" enctype="multipart/form-data">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Unggah File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="fileUploadForm">

            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="excelfile" accept=".xls, .xlsx">
                <label class="custom-file-label" for="exampleInputFile">Pilih file Excel</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Unggah</button>
        </div>
      </div>
    </div>
  </form>
</div>


<!-- Hapus Data -->
                <div class="modal fade" id="InsertTabelModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Input Data!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="<?php echo base_url('User_admin/TabelMurid/DataMasuk'); ?>" method="POST">
                          <div class="form-group">
                            <label>Nama Murid :</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                              </div>
                              <input type="text" class="form-control" name="NamaSiswa" placeholder="Masukkan Nama Siswa...." pattern="[A-Za-z\s]+" title="Masukkan Nama Yang Benar!" required>
                            </div>
                            <!-- /.input group -->
                          </div>
                          <!-- /.form group -->

                          <div class="form-group">
                            <label>Nomor Induk Siswa Nasional :</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                              </div>
                              <input id="noSpecialCharsInputsss" type="number" id="numInput" min="0" step="1" class="form-control" name="NISNSiswa" placeholder="Masukkan Nomor Induk Siswa Nasional...." minlength="4">
                            </div>
                            <!-- /.input group -->
                          </div>
                          <!-- /.form group -->

                          <div class="form-group">
                            <label>Nomor Induk Siswa :</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                              </div>
                              <input id="noSpecialCharsInputsss" type="number" id="numInput" min="0" step="1" class="form-control" name="NisSiswa" placeholder="Masukkan Nomor Induk Siswa" minlength="4" required>
                            </div>
                            <!-- /.input group -->
                          </div>
                          <!-- /.form group -->

                          <div class="form-group">
                            <label>Kelas :</label>
                            <select class="form-control select2" name="KodeKelas" style="width: 100%;">
                              <?php foreach ($kelas as $tb) { ?>
                                <option value="<?php echo $tb->KodeKelas; ?>"><?php echo $tb->KodeKelas; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <!-- /.form group -->

                          <div class="form-group">
                            <label>Jenis Kelamin :</label>
                            <select class="form-control select2" name="GenderSiswa" style="width: 100%;">
                              <option value="L">Laki-Laki</option>
                              <option value="P">Perempuan</option>
                            </select>
                          </div>
                          <!-- /.form group -->

                          <div class="row">
                            <div class="col-sm-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Ayah :</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                  </div>
                                  <input type="text" minlength="6" class="form-control" name="AyahSiswa" placeholder="Nama Ayah..." required>
                                </div>
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Ibu :</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                  </div>
                                  <input type="text" class="form-control" name="IbuSiswa" placeholder="Nama Ibu..." required>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-sm-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Tempat Lahir Siswa :</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                  </div>
                                  <input type="text" class="form-control" name="TmptLhrSiswa" placeholder="Tempat Lahir...." required>
                                </div>
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Tanggal Lahir Siswa :</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                  </div>
                                  <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" name="TglLhrSiswa" data-mask="" inputmode="numeric">
                                </div>
                              </div>
                            </div>
                          </div>



                          <div class="row">
                            <div class="col-sm-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Tanggal Masuk :</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                  </div>
                                  <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/yyyy" name="TGLMasuk" data-mask="" inputmode="numeric">
                                </div>
                              </div>
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <div class="input-group">
                              <button type="submit" class="form-control btn btn-block btn-success">Simpan</button>
                            </div>
                            <!-- /.input group -->
                          </div>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>



                  

                  <!-- Edit Data -->
                  <!-- Edit Data -->
                  <!-- Edit Data -->
                  <!-- Edit Data -->
                  <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="overlay">
                            <i class="fas fa-2x fa-sync fa-spin"></i>
                        </div>
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel">Edit Data!</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="card-body">
                            <form id="editForm" action="<?php echo base_url('User_admin/TabelMurid/DataUpdate'); ?>" method="POST">
                              <input id="IDSiswa" type="hidden" name="IDSiswa" value="">
                              <div class="form-group">
                                <label>Nama Murid :</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                  </div>
                                  <input id="NamaSiswa" type="text" class="form-control" name="NamaSiswa" placeholder="Masukkan Nama Siswa" pattern="[A-Za-z\s]+" value="" title="Masukkan Nama Yang Benar!" required>
                                </div>
                                <!-- /.input group -->
                              </div>
                              <!-- /.form group -->

                              <div class="form-group">
                                <label>Nomor Induk Siswa Nasional :</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                  </div>
                                  <input id="NISNSiswa" type="number" id="numInput noSpecialCharsInputsss" name="NISNSiswa" min="0" step="1" class="form-control" name="NISNSiswa" placeholder="Masukkan Nomor Induk Siswa Nasional...." minlength="4" value="">
                                </div>
                                <!-- /.input group -->
                              </div>
                              <!-- /.form group -->

                              <div class="form-group">
                                <label>Nomor Induk Siswa :</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                  </div>
                                  <input id="NisSiswa" type="number" id="numInput noSpecialCharsInputsss" name="NisSiswa" min="0" step="1" class="form-control" placeholder="Masukkan Nomor Induk Siswa" minlength="4" value="" required>
                                </div>
                                <!-- /.input group -->
                              </div>
                              <!-- /.form group -->

                              <div class="form-group">
                                <label>Kelas :</label>
                                <select class="form-control select2" name="KodeKelas" id="KodeKelas" style="width: 100%;">
                                  <?php foreach ($kelas as $tb2) { ?>
                                    <!-- Tambahkan selected pada opsi jika nilainya sama dengan data yang diterima -->
                                    <option value="<?php echo $tb2->KodeKelas; ?>"><?php echo $tb2->KodeKelas; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <!-- /.form group -->

                              <div class="form-group">
                                <label>Jenis Kelamin :</label>
                                <select id="GenderSiswa" class="form-control select2" name="GenderSiswa" style="width: 100%;">
                                  <option value="L">Laki-Laki</option>
                                  <option value="P">Perempuan</option>
                                </select>
                              </div>
                              <!-- /.form group -->

                              <div class="row">
                                <div class="col-sm-6">
                                  <!-- text input -->
                                  <div class="form-group">
                                    <label>Ayah :</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                      </div>
                                      <input id="AyahSiswa" type="text" minlength="6" class="form-control" name="AyahSiswa" placeholder="Nama Ayah..." value="" required>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-sm-6">
                                  <!-- text input -->
                                  <div class="form-group">
                                    <label>Ibu :</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                      </div>
                                      <input id="IbuSiswa" type="text" minlength="6" class="form-control" name="IbuSiswa" placeholder="Nama Ibu..." value="" required>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-6">
                                  <!-- text input -->
                                  <div class="form-group">
                                    <label>Tempat Lahir Siswa :</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                      </div>
                                      <input id="TmptLhrSiswa" type="text" minlength="6" class="form-control" name="TmptLhrSiswa" value="" placeholder="Tempat Lahir...." required>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-sm-6">
                                  <!-- text input -->
                                  <div class="form-group">
                                    <label>Tanggal Lahir Siswa :</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                      </div>
                                      <input id="TglLhrSiswa" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" name="TglLhrSiswa" data-mask="" inputmode="numeric" value="">
                                    </div>
                                  </div>
                                </div>
                              </div>


                              <div class="row">
                                <div class="col-sm-6">
                                  <!-- text input -->
                                  <div class="form-group">
                                    <label>Tanggal Masuk :</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                      </div>
                                      <input id="TGLMasuk" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/yyyy" name="TGLMasuk" data-mask="" inputmode="numeric" value="">
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <br>
                              <div class="form-group">
                                <div class="input-group">
                                  <button type="submit" class="form-control btn btn-block btn-success">Simpan</button>
                                </div>
                                <!-- /.input group -->
                              </div>
                            </form>

                          </div>
                        </div>
                        <div class="modal-footer">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--End Edit Data -->
                  <!--End Edit Data -->
                  <!--End Edit Data -->
                  <!--End Edit Data -->

                  <!-- Modal Hapus -->
                    <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div id="overlayDel" class="overlay">
                              <i class="fas fa-2x fa-sync fa-spin"></i>
                          </div>
                          <?= form_open(base_url('User_admin/TabelMurid/Hapus/'), 'post'); ?>
                            <div class="modal-header">
                              <h5 class="modal-title" id="deleteModalLabels">Peringatan!</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              Apakah Anda yakin ingin menghapus data dengan nama <i id="DelNamaSiswa" ></i> ?
                            </div>
                            <div class="modal-footer">
                            <input id="IDSiswaDel" type="hidden" name="IDSiswa" value="">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                              <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                          <?= form_close(); ?>
                        </div>
                      </div>
                    </div>
                  <!-- Modal Hapus -->




<script>
  document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>


<script>
  $(document).ready(function () {
    var Token = "<?php echo $this->encryption->encrypt($this->session->userdata('IDGuru')); ?>";
    $('#example15').DataTable({
      "lengthMenu": [50, 100, 250, 500, 1000, 2000],
      "searching": true,
      "ordering": true,
      "autoWidth": true,
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
          "url": "<?php echo base_url('User_admin/DataMuridServerSide'); ?>",
          "type": "GET",
          "headers": {
              // Menambahkan token keamanan ke header permintaan
              "Token": Token
          },
          "data": function (d) {
              d.search.value = $('#example15_filter input').val();
              // Debug: lihat nilai pencarian sebelum dikirim ke server
              // console.log("Search Value (sent to server):", d.search.value);
          }
      },
      "columns": [
        { "data": null, "render": function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          },
          "orderable": false
        },
        { "data": "NamaSiswa", "orderable": false },
        { "data": "NisSiswa", "orderable": false },
        { "data": "NISNSiswa", "orderable": false },
        { "data": "KodeKelas", "orderable": false },
        { "data": "NamaGuru", "orderable": false },
        { "data": "TGLMasuk", "orderable": false },
        { "data": "AyahSiswa", "orderable": false },
        { "data": "IbuSiswa", "orderable": false },
        {
          "data": null,
          "render": function (data, type, row) {
            return '<div class="btn-group">' +
                   '<button type="button" data-target="#EditModal" data-idsiswa="' + row.IDSiswa + '" class="btn btn-default"><i class="fas fa-edit"></i>Edit</button>' +
                   '<button type="button" data-target="#DeleteModal" data-idsiswa="' + row.IDSiswa + '" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</button>' +
                   '</div>';
          }
        }
      ]
    });

    function loadModal(IDSiswa) {
      $('.overlay').show();
      $('#EditModal').modal('show');
      var Token = "<?php echo $this->encryption->encrypt($this->session->userdata('IDGuru')); ?>";
      $.ajax({
        url: "<?php echo base_url('User_admin/ServerSide_MuridByID'); ?>",
        type: "GET",
        dataType: "json",
        data: {
          'IDSiswa' : IDSiswa
        },
        headers: {
              "Token": Token
        },
        success: function (data) {
          // Mengisi nilai modal dengan data yang diterima
          $('#IDSiswa').val(data.Data[0].IDSiswa);
          $('#NamaSiswa').val(data.Data[0].NamaSiswa);
          $('#NISNSiswa').val(data.Data[0].NISNSiswa);
          $('#NisSiswa').val(data.Data[0].NisSiswa);
          $('#AyahSiswa').val(data.Data[0].AyahSiswa);
          $('#IbuSiswa').val(data.Data[0].IbuSiswa);
          $('#TglLhrSiswa').val(data.Data[0].TglLhrSiswa);
          $('#TmptLhrSiswa').val(data.Data[0].TmptLhrSiswa);
          $('#TGLMasuk').val(data.Data[0].TGLMasuk);
          // Memeriksa dan menetapkan atribut selected pada elemen dengan nilai yang cocok
          var selectedKodeKelas = data.Data[0].KodeKelas;
          $('#KodeKelas option').each(function () {
            if ($(this).val() == selectedKodeKelas) {
              $(this).prop('selected', true);
            }
          });
          var selectedGenderSiswa = data.Data[0].GenderSiswa;
          $('#GenderSiswa option').each(function () {
            if ($(this).val() == selectedGenderSiswa) {
              $(this).prop('selected', true);
            }
          });

          if (window.select2Initialized) {
            // Hapus instansi Select2 yang ada
            $('#KodeKelas').select2('destroy');
            window.select2Initialized = false;
            $('#GenderSiswa').select2('destroy');
            window.select2Initialized = false;
          }
          $('#KodeKelas').select2();
          $('#GenderSiswa').select2();
          $('.overlay').hide();

          // Menampilkan modal
          // console.log(data);

        },
        error: function () {
          alert("Gagal mengambil data.");
        }
      });
    }

    function loadDelModal(IDSiswa) {
      $('#overlayDel').show();
      $('#DeleteModal').modal('show');
      var Token = "<?php echo $this->encryption->encrypt($this->session->userdata('IDGuru')); ?>";
      $.ajax({
        url: "<?php echo base_url('User_admin/ServerSide_MuridByID'); ?>",
        type: "GET",
        dataType: "json",
        data: {
          'IDSiswa' : IDSiswa
        },
        headers: {
              "Token": Token
        },
        success: function (data) {
          // Mengisi nilai modal dengan data yang diterima
          $('#IDSiswaDel').val(data.Data[0].IDSiswa);
          $('#DelNamaSiswa').text(data.Data[0].NamaSiswa);
          $('#overlayDel').hide();

          // Menampilkan modal
          // console.log(data);

        },
        error: function () {
          alert("Gagal mengambil data.");
        }
      });
    }

    // Memanggil loadModal saat tombol "Edit" diklik
    $('#example15').on('click', 'button[data-target="#EditModal"]', function () {
        var IDSiswa = $(this).data('idsiswa');
        loadModal(IDSiswa);
    });

    // Memanggil loadModal saat tombol "Edit" diklik
    $('#example15').on('click', 'button[data-target="#DeleteModal"]', function () {
        var IDSiswa = $(this).data('idsiswa');
        loadDelModal(IDSiswa);
    });
  });
</script>


