<?php
  foreach ($Edit as $tb) {
    $IDGuru=$tb->IDGuru;
    $NamaGuru=$tb->NamaGuru;
    $KodeGuru=$tb->KodeGuru;
    $NomorIndukGuru=$tb->NomorIndukGuru;
    $KoMa=$tb->KodeMapel;
    $UsrGuru=$tb->UsrGuru;
    $IDHak=$tb->IDHak;
    $PassGuru=$tb->PassGuru;
    $NomorHP=$tb->NomorHP;
  }
  $Hak=explode('//', $IDHak);
  $TotalHak=count($Hak);

?>
<div class="content-wrapper">
  <div class="content-with-overlay">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Data Guru</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Edit Data Guru</li>
              <li class="breadcrumb-item">Guru</li>
              <li class="breadcrumb-item">Tabel Pengguna</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <script>
        document.addEventListener('DOMContentLoaded', function() {
          const inputElement = document.getElementById('noSpecialCharsInput');

          inputElement.addEventListener('input', function() {
            const inputValue = inputElement.value;
            const newValue = inputValue.replace(/[\W_]+/g, ''); // Menghapus semua spasi dan karakter khusus

            if (inputValue !== newValue) {
              inputElement.value = newValue;
            }
          });
        });

        document.addEventListener('DOMContentLoaded', function() {
          const inputElement = document.getElementById('onlyNumbersInput');

          inputElement.addEventListener('input', function() {
            const inputValue = inputElement.value;
            const newValue = inputValue.replace(/[^0-9]/g, ''); // Menghapus semua selain angka

            if (inputValue !== newValue) {
              inputElement.value = newValue;
            }
          });
        });
      </script>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <div class="card card-secondary shadow">
          <div class="card-header">
            <div class="card-tools">
              <div class="btn-group">

              </div>
            </div>

          </div>

          <div class="card-body">
            <form action="<?php echo base_url('User_admin/TabelGuru/DataUpdate'); ?>" method="POST">
              <input type="hidden" name="UpdateData" value="Guru">
              <input type="hidden" name="IDGuru" value="<?=$IDGuru?>">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                        <label>Nomor Induk Guru :</label>
                        <div class="input-group shadow">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                          </div>
                          <input id="noSpecialCharsInput" type="number" id="numInput" name="NomorIndukGuru" min="0" step="1" class="form-control" placeholder="Masukkan Nomor Induk Guru" minlength="4" value="<?=$NomorIndukGuru?>" required>
                        </div>
                        <!-- /.input group -->
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                        <label>Kode Guru :</label>
                        <div class="input-group shadow">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                          </div>
                          <input type="text" id="noSpecialCharsInput" class="form-control" name="KodeGuru" placeholder="Masukkan Kode Untuk Guru" title="Masukkan Kode Guru!" value="<?=$KodeGuru?>" required>
                        </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                        <label>Nama Guru :</label>
                        <div class="input-group shadow">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                          </div>
                          <input type="text" class="form-control" name="NamaGuru" placeholder="Masukkan Nama Guru" value="<?=$NamaGuru?>" required>
                        </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Mata Pelajaran :</label>
                    <div class="input-group shadow">
                      <select required name="IDMapel[]" class="select2" multiple="multiple" data-placeholder="Pilih Mata Pelajaran" style="width: 100%;">
                        <option value='0'>Bukan Guru</option>
                        <?php foreach ($mapel as $data) { ?>
                          <option <?php if($Mengajar!==false){foreach ($Mengajar as $MB){if($MB->IDMapel==$data->IDMapel){echo "selected";}}} ?> value="<?php echo $data->IDMapel; ?>"><?php echo $data->NamaMapel; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <!-- <button type="button" class="btn btn-success addMapel">Tambah Mata Pelajaran</button> -->
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Username Guru :</label>
                    <div class="input-group shadow">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                      </div>
                      <input type="text" minlength="6" class="form-control" name="UsrGuru" placeholder="Username Guru" value="<?= $UsrGuru ?>" required>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                      <div class="form-group">
                        <label>Nomor HP (WhatsApp):</label>
                        <div class="input-group shadow">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fab fa-whatsapp fa-lg"></i></span>
                          </div>
                          <input name="NomorHP" value="<?=$NomorHP?>" type="text" class="form-control"
                             data-inputmask="'mask': ['9999-9999-9999', '9999 9999 9999']" data-mask>
                        </div>
                    <!-- /.input group -->
                      </div>
                    </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Password Guru :</label>
                    <div class="input-group shadow">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><div id="showPassword" href="#" ><i id="eyeIcon" class="fa fa-eye"></i></div></span>
                      </div>
                      <input type="password" minlength="6" class="form-control" name="PassGuru1" placeholder="Tulis Password...." id="password1" name="Password1" value="<?= $PassGuru ?>" required>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                        <label>Tulis Ulang Password Guru :</label>
                        <div class="input-group shadow">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><div id="showPassword2" href="#" ><i id="eyeIcon2" class="fa fa-eye"></i></div></span>
                          </div>
                          <input type="password" minlength="6" class="form-control" name="PassGuru2" placeholder="Ulangi Password...." id="password2" value="<?= $PassGuru ?>" name="Password2" required>
                        </div>
                        <!-- /.input group -->
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                        <label>Jabatan :</label>
                        <?php
                        $no = 0;
                        foreach ($hakakses as $tb) {  ?>

                          <div class="custom-control custom-checkbox">
                            <input <?php for ($i=0; $i < $TotalHak; $i++){if($tb->IDHak==$Hak[$i]){echo "checked";}} ?> class="custom-control-input" type="checkbox" id="customCheckbox<?php echo $no; ?>" value="<?php echo $tb->IDHak; ?>" name="IDHak[]">
                            <label for="customCheckbox<?php echo $no; ?>" class="custom-control-label"><?php echo $tb->NamaHak; ?></label>
                          </div>

                        <?php $no++;
                        } ?>
                      </div>
                </div>
              </div>
                      

                      

                      
                      
                      
                      <br>
                      <div class="form-group">
                        <div class="input-group">
                          <button type="submit" id="submitBtn" class="form-control btn btn-block btn-success shadow">Simpan</button>
                        </div>
                        <!-- /.input group -->
                      </div>
                    </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bright-overlay"></div>
</div>

<script>
    $(document).ready(function () {

        // Menyembunyikan tampilan password saat halaman dimuat
        $("#password1").attr("type", "password");

        // Fungsi untuk menampilkan atau menyembunyikan karakter password
        $("#showPassword").on("click", function () {
            var passwordInput = $("#password1");
            var eyeIcon = $("#eyeIcon");

            if (passwordInput.attr("type") === "password") {
                passwordInput.attr("type", "text");
                eyeIcon.removeClass("fa-eye");
                eyeIcon.addClass("fa-eye-slash");
            } else {
                passwordInput.attr("type", "password");
                eyeIcon.removeClass("fa-eye-slash");
                eyeIcon.addClass("fa-eye");
            }
        });

        // Menyembunyikan tampilan password saat halaman dimuat
        $("#password2").attr("type", "password");

        // Fungsi untuk menampilkan atau menyembunyikan karakter password
        $("#showPassword2").on("click", function () {
            var passwordInput = $("#password2");
            var eyeIcon = $("#eyeIcon2");

            if (passwordInput.attr("type") === "password") {
                passwordInput.attr("type", "text");
                eyeIcon.removeClass("fa-eye");
                eyeIcon.addClass("fa-eye-slash");
            } else {
                passwordInput.attr("type", "password");
                eyeIcon.removeClass("fa-eye-slash");
                eyeIcon.addClass("fa-eye");
            }
        });

        // Fungsi untuk menangani perubahan pada elemen select yang sudah ada
        $("#mapelContainer").on("change", "select", function () {
            // Dapatkan elemen select pertama sebagai referensi
            var referenceSelect = $("#mapelContainer").find("select").first();

            // Dapatkan nilai yang dipilih
            var selectedValue = $(this).val();

            // Cek jika nilai yang dipilih adalah "null"
            if (selectedValue === "null") {
                // Nonaktifkan tombol "Tambah Mata Pelajaran"
                referenceSelect.siblings(".addMapel").prop("disabled", true);
            } else {
                // Aktifkan tombol "Tambah Mata Pelajaran"
                referenceSelect.siblings(".addMapel").prop("disabled", false);
            }
        });

        // Fungsi untuk menambahkan Mata Pelajaran
        $(".addMapel").on("click", function () {
            // Dapatkan elemen select pertama sebagai referensi
            var referenceSelect = $("#mapelContainer").find("select").first();

            // Dapatkan nilai dan teks dari elemen select referensi
            var selectedValue = referenceSelect.val();
            var selectedText = referenceSelect.find("option:selected").text();

            // Buat elemen select baru dengan nilai dan teks yang sama
            var newSelect = $("<div class='form-group'><select class='form-control select2' name='KodeMapel[]' style='width: 100%; margin-top: 10px;'></select><button type='button' class='btn btn-danger removeMapel'>Hapus</button></div>");

            // Tambahkan opsi yang sama ke dalam elemen select baru
            referenceSelect.find("option").each(function () {
                newSelect.find("select").append("<option value='" + $(this).val() + "'>" + $(this).text() + "</option>");
            });

            // Tambahkan elemen select baru ke dalam container
            $("#mapelContainer").append(newSelect);

            // Inisialisasi Select2 pada elemen select yang baru ditambahkan
            newSelect.find("select").select2();
        });

        // Fungsi untuk menghapus Mata Pelajaran
        $(document).on("click", ".removeMapel", function () {
            // Hapus elemen formulir saat tombol "Hapus" ditekan
            $(this).parent().remove();
        });

        // Inisialisasi status tombol "Tambah Mata Pelajaran" saat dokumen dimuat
        var initialSelectedValue = $("#mapelContainer").find("select").first().val();
        if (initialSelectedValue === "null") {
            $(".addMapel").prop("disabled", true);
        }
    });
</script>


