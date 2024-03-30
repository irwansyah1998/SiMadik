
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6 animate__animated animate__fadeInLeft">
              <h1 class="m-0">Jam Pembelajaran</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 animate__animated animate__fadeInRight">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Cari</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <!-- Main content -->
      <div class="content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-4">
                      <div class="card card-primary shadow animate__animated animate__fadeInLeft">
                          <div class="card-header">
                              <h2 class="card-title m-0">Hari Pembelajaran :</h2>
                              
                          </div>

                          <!-- /.card-header -->
                          <div class="card-body">
                              <form action="<?php echo base_url('User_admin');?>/JamPembelajaran" method="POST">
                                  
                                  <input type="hidden" name="CariData" value="HariJam">
                                  <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label>Hari Pembelajaran:</label>
                                                  <select required class="form-control select2 shadow" name="IDHari" style="width: 100%;">
                                                      <option value="">Pilih Hari</option>
                                                      <?php
                                                      if ($TabelHari!==false) {
                                                          foreach ($TabelHari as $TH) {
                                                      ?>
                                                      <option <?php if(isset($_POST['IDHari']) && $_POST['IDHari']==$TH->IDHari || isset($IDHari) && $IDHari==$TH->IDHari){echo "selected";} ?> value="<?= $TH->IDHari ?>"><?= $TH->NamaHari ?></option>
                                                      <?php
                                                          }
                                                      }
                                                      ?>
                                                  </select>
                                              </div>
                                          </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <button type="submit" class="btn btn-block btn-primary shadow">
                                                  <i class="fas fa-search"></i> Cari Data
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                                  
                              </form>
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <?php if ($this->input->post('IDHari')!==null || isset($IDHari)) { ?>
                        <div class="card card-dark shadow animate__animated animate__fadeInLeft">
                            <div class="card-header">
                                <h2 class="card-title m-0">Salin Data Jam Pelajaran Ke :</h2>
                                
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                    
                                    
                                    <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Salin ke Hari Pembelajaran:</label>
                                                    <select title="Pilih Hari" placeholder="Pilih Hari..." required class="form-control select2 shadow" name="CopyHari[]" style="width: 100%;" multiple>
                                                        <?php
                                                        if ($TabelHari!==false) {
                                                            foreach ($TabelHari as $TH) {
                                                        ?>
                                                        <option <?php if(isset($_POST['IDHari']) && $_POST['IDHari']==$TH->IDHari || isset($IDHari) && $IDHari==$TH->IDHari){echo "disabled";} ?> value="<?= $TH->IDHari ?>"><?= $TH->NamaHari ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-block btn-dark shadow" id="CopyButton">
                                                    <i class="fas fa-copy"></i> Salin Data Jam Pelajaran
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                      <?php } ?>
                  </div>

                  <div class="col-md-8">
                    <form class="col-md-12" action="<?php echo base_url('User_admin');?>/JamPembelajaranCRUD" method="POST">
                      <?php if (isset($_POST['IDHari']) || isset($IDHari)) { ?>
                      <input type="hidden" name="JamPembelajaran" value="TambahData">
                      <?php if (isset($_POST['IDHari'])) { ?>
                      <input type="hidden" name="IDHari" value="<?= $_POST['IDHari']?>">
                      <?php }elseif(isset($IDHari)){ ?>
                      <input type="hidden" name="IDHari" value="<?= $IDHari?>">
                      <?php } ?>
                      <?php } ?>
                      <div class="card card-secondary shadow animate__animated animate__fadeInRight">
                          <div class="card-header">
                              <h2 class="card-title m-0">Data Jam :</h2>
                              <div class="card-tools">

                              </div>
                          </div>

                          <!-- /.card-header -->
                      <div class="card-body col-md-12" id="formContainer">
                        <?php
                        if ($TabelJam!==false) {
                          foreach ($TabelJam as $TH) {
                        ?>
                        <div class="row" id="jamForm_<?= $TH->IDJamPel ?>">
                        <input type="hidden" name="IDJamPel[]" value="<?= $TH->IDJamPel ?>">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Jam Ke:</label>
                              <input type="text" class="form-control shadow" name="JamKe[]" required  value="<?= $TH->JamKe ?>">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Jam Awal:</label>
                              <input type="time" class="form-control shadow" name="MulaiJampel[]" required  value="<?= $TH->MulaiJampel ?>">
                            </div>
                          </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Jam Akhir:</label>
                            <input type="time" class="form-control shadow" name="AkhirJampel[]" required  value="<?= $TH->AkhirJampel ?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-block shadow" id="hapusButton" data-toggle="modal" data-target="#konfirmasiModal<?= $TH->IDJamPel ?>">Hapus</button>
                          </div>
                        </div>
                      </div>
                        <?php
                          }
                        }
                        ?>
                      </div>
                              <!-- /.card-body -->
                      <div class="card-footer">
                        <?php if ($this->input->post('IDHari')!==null || isset($IDHari)) { ?>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="btn-group btn-group col-md-12">
                                      <button type="button" class="btn btn-secondary col-md-12 shadow" id="addJamBtn">Tambah Jam</button>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="btn-group col-md-12">
                                      <button type="submit" class="btn btn-primary col-md-12 shadow">Simpan</button>
                                  </div>
                              </div>
                          </div>
                        <?php } ?>
                      </div>
                      </div>
                    </form>
                  </div>
              </div>
              <!-- ROW -->
          <!-- /.container-fluid -->
          </div>
      </div>
      <!-- /.content -->
    </div>
    <div class="bright-overlay"></div>
  </div>
  <!-- /.content-wrapper -->

<?php
                      if ($TabelJam!==false) {
                        foreach ($TabelJam as $TH) {
                      ?>
<!-- Modal Konfirmasi -->
<div class="modal fade" id="konfirmasiModal<?= $TH->IDJamPel ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?php echo base_url('User_admin');?>/JamPembelajaranCRUD" method="POST">
    <input type="hidden" name="HapusData" value="JamPel">
    <?php if (isset($_POST['IDHari'])) { ?>
    <input type="hidden" name="IDHari" value="<?= $_POST['IDHari']?>">
    <?php }elseif(isset($IDHari)){ ?>
    <input type="hidden" name="IDHari" value="<?= $IDHari?>">
    <?php } ?>
    <input type="hidden" name="IDJamPel" value="<?= $TH->IDJamPel ?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin menghapus jam pelajaran <b><?= $TH->MulaiJampel ?> ~ <?= $TH->AkhirJampel ?></b>?<br>Tindakan ini tidak dapat dibatalkan.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger" id="hapusButton">Hapus</button>
      </div>
    </div>
  </div>
  </form>
</div>
<?php
    }
  }
?>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
  $(document).ready(function () {
    // Fungsi untuk membuat formulir jam
    function createJamForm() {
      var uniqueId = new Date().getTime(); // Membuat id unik berdasarkan timestamp

      var formHtml = `
        <div class="row" id="jamForm_${uniqueId}">
          <div class="col-md-3">
            <div class="form-group">
              <label>Jam Ke:</label>
              <input type="text" class="form-control shadow" name="JamKe[]" required >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Jam Awal:</label>
              <input type="time" class="form-control shadow" name="MulaiJampel[]" required >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Jam Akhir:</label>
              <input type="time" class="form-control shadow" name="AkhirJampel[]" required >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>&nbsp;</label>
              <button type="button" class="btn btn-danger btn-block shadow" onclick="confirmAndRemoveJamForm(${uniqueId})">Hapus</button>
            </div>
          </div>
        </div>`;

      $("#formContainer").append(formHtml);
    }

    // Fungsi untuk konfirmasi dan menghapus formulir jam
    window.confirmAndRemoveJamForm = function (uniqueId) {
      var mulaiJamValue = $("#jamForm_" + uniqueId + " [name='MulaiJampel[]']").val();
      var akhirJamValue = $("#jamForm_" + uniqueId + " [name='AkhirJampel[]']").val();

      if (mulaiJamValue !== "" || akhirJamValue !== "") {
        // Jika nilai MulaiJam atau AkhirJam tidak kosong, tampilkan modal konfirmasi
        // Gantilah "#konfirmasiModal" dengan ID modal yang sebenarnya
        $("#konfirmasiModal").modal('show');
        $("#konfirmasiModal #hapusButton").data("uniqueId", uniqueId); // Set data attribut untuk menyimpan uniqueId
      } else {
        // Jika nilai MulaiJam dan AkhirJam kosong, langsung hapus formulir jam
        $("#jamForm_" + uniqueId).remove();
      }
    };

    // Event handler untuk tombol "Tambah Jam"
    $("#addJamBtn").on("click", function () {
      createJamForm();
    });

    // Event handler untuk tombol "Hapus" pada modal konfirmasi
    $("#hapusButton").on("click", function () {
      var uniqueId = $(this).data("uniqueId");
      $("#jamForm_" + uniqueId).remove();
      $("#konfirmasiModal").modal('hide');
    });
  });
</script>

<script>
$(document).ready(function(){
    $("#CopyButton").click(function(){
        // Mengumpulkan data dari formulir
        var jamKe = $("input[name='JamKe[]']").map(function(){return $(this).val();}).get();
        var copyHari = $("select[name='CopyHari[]']").val();
        var mulaiJampel = $("input[name='MulaiJampel[]']").map(function(){return $(this).val();}).get();
        var akhirJampel = $("input[name='AkhirJampel[]']").map(function(){return $(this).val();}).get();

        // Cek apakah setidaknya satu elemen ada dalam array
        if (jamKe.length === 0 || !copyHari || mulaiJampel.length === 0 || akhirJampel.length === 0) {
            toastr.warning('Tidak ada data yang dikirim.', 'Peringatan');
            return;
        }

        // Menampilkan toast notifikasi sedang menyalin data
        toastr.info('Sedang menyalin data....', 'Informasi');

        // Data yang akan dikirimkan melalui AJAX
        var postData = {
            CopyHari: copyHari,
            JamKe: jamKe,
            MulaiJampel: mulaiJampel,
            AkhirJampel: akhirJampel
            // Tambahkan data lainnya sesuai kebutuhan
        };

        // Kirim data ke controller CodeIgniter menggunakan AJAX
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('User_admin/JamPembelajaranAJAX');?>",
            data: postData,
            success: function(response){
                // Handle respons dari server jika diperlukan
                console.log(response);

                // Menampilkan toast jika respons adalah sukses
                if (response.status === 'success') {
                    toastr.success(response.message, 'Sukses');
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function(error){
                // Handle kesalahan jika diperlukan
                console.log(error);

                // Menampilkan toast untuk kesalahan
                toastr.error('Terjadi kesalahan saat mengirim data.', 'Error');
            }
        });
    });
});

</script>



