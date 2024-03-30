<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tabel Wali Murid</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item">Tabel Pengguna</li>
               <li class="breadcrumb-item">Wali Murid</li>
              <li class="breadcrumb-item active">Tambah</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<script type="text/javascript">
  $(document).ready(function() {
  var dataTahun = <?= json_encode($DataTahun) ?>;
  var dataKelas = <?= json_encode($DataKelas) ?>;
  var dataMurid = <?= json_encode($DataMurid) ?>;

  var tahunDropdown = $("#tahun");
  $.each(dataTahun, function(index, item) {
    tahunDropdown.append($('<option>', {
      value: item.KodeTahun,
      text: item.PenyebutanTahun
    }));
  });

  // Handle Tahun Dropdown Change Event
  tahunDropdown.change(function() {
    var selectedKodeTahun = $(this).val();

    // Filter Kelas based on selected Tahun
    var filteredKelas = dataKelas.filter(function(kelas) {
      return kelas.KodeTahun === selectedKodeTahun;
    });

    // Populate Kelas Dropdown
    var kelasDropdown = $("#kelas");
    kelasDropdown.empty().append($('<option>', {
      value: "",
      text: "Pilih Kelas"
    }));
    $.each(filteredKelas, function(index, item) {
      kelasDropdown.append($('<option>', {
        value: item.KodeKelas,
        text: item.KodeKelas
      }));
    });

    // Reset Murid Dropdown
    var muridDropdown = $("#murid");
    muridDropdown.empty().append($('<option>', {
      value: "",
      text: "Pilih Murid"
    }));
  });

  // Handle Kelas Dropdown Change Event
  var kelasDropdown = $("#kelas");
  var muridDropdown = $("#murid");
  kelasDropdown.change(function() {
    var selectedKodeKelas = $(this).val();

    // Filter Murid based on selected Kelas
    var filteredMurid = dataMurid.filter(function(murid) {
      return murid.KodeKelas === selectedKodeKelas;
    });

    // Populate Murid Dropdown
    muridDropdown.empty().append($('<option>', {
      value: "",
      text: "Pilih Murid"
    }));
    $.each(filteredMurid, function(index, item) {
      muridDropdown.append($('<option>', {
        value: item.NisSiswa,
        text: item.NamaSiswa
      }));
    });
  });
});
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const inputElement = document.getElementById('noSpaceInput');

    inputElement.addEventListener('input', function() {
      const inputValue = inputElement.value;
      const newValue = inputValue.replace(/\s/g, ''); // Menghapus semua spasi

      if (inputValue !== newValue) {
        inputElement.value = newValue;
      }
    });
  });
</script>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title">Tambah Wali Murid</h3>
                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="<?php echo base_url('User_admin/WaliMurid/InputData/Save');?>" method="POST">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nama Orang Tua Murid :</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                        </div>
                        <input  type="text" class="form-control" name="NamaOrtu" placeholder="Masukkan Nama Orang Tua Siswa...." pattern="[A-Za-z\s]+" title="Masukkan Nama Yang Benar!" required>
                      </div>
                  <!-- /.input group -->
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nomor HP (WhatsApp):</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fab fa-whatsapp fa-lg"></i></span>
                        </div>
                        <input name="NomorHP" required type="text" class="form-control"
                           data-inputmask="'mask': ['9999-9999-9999', '9999 9999 9999']" data-mask>
                      </div>
                  <!-- /.input group -->
                    </div>
                  </div>
                </div>
                <!-- /.form group -->
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Username :</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                        </div>
                        <input  type="text" class="form-control" id="noSpaceInput" name="UsrOrtu" placeholder="Masukkan Username Orang Tua Siswa...." pattern="[A-Za-z\s]+" title="Username!" required>
                      </div>
                  <!-- /.input group -->
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Alamat :</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" id="noSpaceInput" name="Alamat" placeholder="Alamat Orang Tua Siswa...." title="Username!" required>
                      </div>
                  <!-- /.input group -->
                    </div>
                  </div>
                </div>
                <!-- /.form group -->

                <div class="row">
                  <div class="col-sm-6">
                      <!-- text input -->
                    <div class="form-group">
                      <label>Tingkatan Kelas:</label>
                      <select required class="form-control select2" name="KodeTahun" style="width: 100%;" id="tahun">
                        <option>Pilih Tingkatan</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-6">
                      <!-- text input -->
                       <div class="form-group">
                      <label>Cari Kelas:</label>
                      <select required class="form-control select2" name="KodeKelas" style="width: 100%;" id="kelas">
                        <option value="">Pilih Kelas</option>
                      </select>
                    </div>
                    </div>
                  </div>

                <div class="form-group">
                  <label>Nama Siswa :</label>
                      <select class="form-control select2" name="NisSiswa" id="murid" style="width: 100%;">
                        <option value="">Pilih Murid</option>
                      </select>
                </div>
                <!-- /.form group -->

                <div class="form-group">
                  <label>Password :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                    </div>
                    <input  type="password" minlength="6" class="form-control" name="PassOrtu1" placeholder="Tulis Password...." id="password1" name="Password1" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Tulis Ulang Password :</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                    </div>
                    <input  type="password" minlength="6" class="form-control" name="PassOrtu2" placeholder="Ulangi Password...." id="password2" name="Password2" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <br>
                <div class="form-group">
                  <div class="input-group">
                    <button type="submit" id="submitBtn" class="form-control btn btn-block btn-success">Simpan</button>
                  </div>
                  <!-- /.input group -->
                </div>
              </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
       
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->