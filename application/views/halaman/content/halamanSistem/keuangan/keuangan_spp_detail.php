<?php
  function formatRupiah($angka) {
    $rupiah = number_format($angka, 2, ',', '.');
    return $rupiah;
  }

  foreach ($tabel2 as $tb) {
    $IDSpp = $tb->IDSpp;
    $JumlahRp = $tb->JumlahRp;
    $IDAjaran = $tb->IDAjaran;
    $KodeAjaran = $tb->KodeAjaran;
    $Keterangan = $tb->Keterangan;
    $Nama = $tb->Nama;
    $Jumlah = $tb->Jumlah;
  }

  $subSPPnama=explode('//A//', $Nama);
  $subSPPjumlah=explode('//A//', $Jumlah);
  if (count($subSPPnama)===count($subSPPjumlah)){
    $hitung=count($subSPPjumlah);
  }
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Sumbangan Pembinaan Pendidikan (SPP)</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Detail</li>
                <li class="breadcrumb-item">SPP</li>
                <li class="breadcrumb-item">Keuangan</li>
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

          const onlyNumbersInput = document.getElementById('onlyNumbersInput');

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
          <div class="row">
          <div class="col-md-4">
          <div class="card card-primary">
                <div class="card-header">
                  <h2 class="card-title m-0">SPP Tipe :</h2>
                  <div class="card-tools">
                    <!-- <button data-toggle="modal" data-target="#InsertTabel" type="button" class="btn btn-block btn-primary">
                      <i class="fa fa-plus"></i> Tambah Data
                    </button> -->
                  </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="KodeGuru">Total SPP :</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><b>Rp</b></span>
                          </div>
                            <p class="form-control"><b><?= formatrupiah($JumlahRp) ?></b></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="KodeGuru">Keterangan :</label>
                        <div class="input-group">
                            <p class="form-control"><?= $Keterangan ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
            </div>
            </div>

            <div class="col-md-8">
              <div class="card card-secondary">
                <div class="card-header">
                  <h2 class="card-title m-0">Pembayaran SPP Bulanan</h2>
                  <div class="card-tools">
                    <!-- <button data-toggle="modal" data-target="#InsertTabel" type="button" class="btn btn-block btn-primary">
                      <i class="fa fa-plus"></i> Tambah Data
                    </button> -->
                  </div>
                </div>

                <!-- /.card-header -->
              <form action="<?php echo base_url('User_keuangan');?>/SPPCRUD" method="POST">
              <div class="card-body col-md-12" id="formContainer">
                  <input type="hidden" name="SubSPP" value="SubSPP">
                  <input type="hidden" name="IDSpp" value="<?= $IDSpp ?>">
                                      <!-- Formulir awal -->
                                    <?php if($hitung>0){for ($i=0; $i < $hitung; $i++) { ?>
                                      <div class="form-group form-row">
                                          <div class="col">
                                              <label for="nama">Nama:</label>
                                              <input type="text" class="form-control" name="nama[]" required value="<?= $subSPPnama[$i] ?>">
                                          </div>
                                          <div class="col">
                                              <label for="jumlah">Jumlah:</label>
                                              <input type="text" oninput="formatNumberInput(this); periksaJumlah();" class="format-number form-control" name="jumlah[]" value="<?= $subSPPjumlah[$i] ?>" required>
                                          </div>
                                          <div class="col">
                                              <button type="button" class="btn btn-danger btn-sm mt-4" onclick="hapusForm(this)"><i class="fas fa-times-circle"></i>Hapus</button>
                                          </div>
                                      </div>                    
                                    <?php }
                                  }else{
                                    ?>
                                    <div class="form-group form-row">
                                          <div class="col">
                                              <label for="nama">Nama:</label>
                                              <input type="text" class="form-control" name="nama[]" required value="">
                                          </div>
                                          <div class="col">
                                              <label for="jumlah">Jumlah:</label>
                                              <input type="text" oninput="formatNumberInput(this); periksaJumlah();" class="format-number form-control" name="jumlah[]" value="" required>
                                          </div>
                                          <div class="col">
                                              <button type="button" class="btn btn-danger btn-sm mt-4" onclick="hapusForm(this)"><i class="fas fa-times-circle"></i>Hapus</button>
                                          </div>
                                      </div>
                                  <?php } ?>
              </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="card-tools">
                    <div class="row">
                      <div class="col-lg-8 col-12">
                        <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><b>Total (Rp)</b></span>
                          </div>
                            <p class="form-control" id="TotalJumlah"></p>
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-4 col-12">
                        
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" onclick="tambahForm()">Tambah Form</button>
                            <button type="submit" disabled class="btn btn-success" id="tombolSimpan" onclick="simpanForm()">Simpan</button>
                          </div>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            </div>

          </div>
        <!-- /.container-fluid -->
        </div>
      </div>
    </div>
    <div class="bright-overlay"></div>
</div>
  <!-- /.content-wrapper -->




<script>
  // Fungsi untuk memformat angka
  function formatNumberInput(input) {
    const ribuanSeparator = new Intl.NumberFormat('en-US');
    let nilai = input.value.replace(/\D/g, ''); // Hapus karakter non-digit
    const ribuanFormatted = ribuanSeparator.format(nilai); // Format nilai dengan tanda pemisah ribuan
    input.value = ribuanFormatted; // Set nilai yang sudah diformat kembali ke input
  }

  // Fungsi untuk memformat semua input dengan class "format-number"
  function formatAllNumberInputs() {
    const inputElements = document.querySelectorAll('.format-number');

    inputElements.forEach(function(input) {
      formatNumberInput(input);
    });
  }

  // Panggil fungsi formatAllNumberInputs saat halaman dimuat
  window.addEventListener('DOMContentLoaded', formatAllNumberInputs);

  // Tambahkan event listener pada setiap elemen input
  const inputElements = document.querySelectorAll('.format-number');

  inputElements.forEach(function(input) {
    input.addEventListener('input', function() {
      formatNumberInput(input);
    });

    // Tambahkan event listener saat fokus hilang (blur)
    input.addEventListener('blur', function() {
      formatNumberInput(input);
    });
  });
</script>

<script>
        function tambahForm() {
            var formContainer = document.getElementById("formContainer");
            var newForm = document.createElement("div");
            newForm.className = "form-group form-row";
            newForm.innerHTML = `
                <div class="col">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" name="nama[]" required>
                </div>
                <div class="col">
                    <label for="jumlah">Jumlah:</label>
                    <input type="text" oninput="formatNumberInput(this); periksaJumlah();" class="format-number form-control" name="jumlah[]" required>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger btn-sm mt-4" onclick="hapusForm(this)"><i class="fas fa-times-circle"></i>Hapus</button>
                </div>
            `;
            formContainer.appendChild(newForm);
        }

        function hapusForm(button) {
            var formContainer = document.getElementById("formContainer");
            var formGroup = button.closest(".form-group");
            if (formContainer.childElementCount > 1) {
                formContainer.removeChild(formGroup);
            }
        }



  function hitungTotal() {
    var inputs = document.querySelectorAll('input[name="jumlah[]"]');
    var total = 0;

    for (var i = 0; i < inputs.length; i++) {
        if (!isNaN(parseFloat(inputs[i].value))) {
            total += parseFloat(inputs[i].value.replace(/,/g, ''));
        }
    }

    return total;
}

function periksaJumlah() {
    var batasJumlah = <?= $JumlahRp ?>; // Ubah dengan nilai batas yang Anda inginkan.
    var total = hitungTotal();
    var tombolSimpan = document.getElementById("tombolSimpan");
    var totalJumlahElement = document.getElementById("TotalJumlah");

    if (total !== batasJumlah) {
        tombolSimpan.disabled = true;
        totalJumlahElement.textContent = total.toLocaleString(); // Update teks total dengan pemisah ribuan
    } else {
        tombolSimpan.disabled = false;
        totalJumlahElement.textContent = total.toLocaleString(); // Update teks total dengan pemisah ribuan
    }
}

    </script>


