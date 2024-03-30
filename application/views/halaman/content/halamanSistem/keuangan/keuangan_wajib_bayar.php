<?php
function formatRupiah($angka) {
    $rupiah = number_format($angka, 2, ',', '.');
    return $rupiah;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembayaran Dana Wajib</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Bayar</li>
                        <li class="breadcrumb-item">Dana Wajib</li>
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
                            <h2 class="card-title m-0">Pembayaran Wajib :</h2>
                            
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="<?php echo base_url('User_keuangan');?>/BayarSPP" method="POST">
                                <input type="hidden" name="WajibBayar" value="Cari">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="NisSiswa">Nomor Induk Siswa (NIS) :</label>
                                            <div class="input-group">
                                                <select required name="NisSiswa" class="form-control select2">
                                                    <option value="">Nomor Induk Siswa</option>
                                                    <?php if ($datasiswa!==FALSE) {
                                                        foreach ($datasiswa as $key) {
                                                    ?>
                                                        <option value="<?= $key->NisSiswa ?>"
                                                            <?php if($DataCari!==FALSE){if($key->NisSiswa===$_POST['NisSiswa']){echo "selected";}} ?>>
                                                            <?= $key->NamaSiswa ?> (<?= $key->NisSiswa ?>)</option>
                                                    <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="KodeGuru">Tahun Ajaran :</label>
                                            <div class="input-group">
                                                <select required name="IDAjaran" class="form-control select2">
                                                    <option value>Tahun Ajaran</option>
                                                    <?php if ($datatahunajaran!==FALSE) {
                                                        foreach ($datatahunajaran as $key) {
                                                    ?>
                                                            <option value="<?= $key->IDAjaran ?>"
                                                                <?php if($DataCari!==FALSE){if($key->IDAjaran===$_POST['IDAjaran']){echo "selected";}} ?>>
                                                                <?= $key->KodeAjaran ?></option>
                                                    <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block btn-primary">
                                                <i class="fas fa-search"></i> Cari Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h2 class="card-title m-0">Data Pembayaran :</h2>
                            <div class="card-tools">
                                <button data-toggle="modal" data-target="#DetailTabel" type="button"
                                    class="btn btn-block btn-primary">
                                    <i class="fas fa-info"></i> Detail Pembayaran
                                </button>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <form action="<?php echo base_url('User_keuangan');?>/BayarSPPCRUD" method="POST">
                            <div class="card-body col-md-12" id="formContainer">
                                <?php
                                if ($DataCari !== FALSE) {
                                ?>
                                <input type="hidden" name="NisSiswa" value="<?=$_POST['NisSiswa']?>">
                                <input type="hidden" name="IDSpp" value="<?=$_POST['IDSpp']?>">
                                <input type="hidden" name="BayarSPP" value="TRUE">
                                <table class="table table-bordered table-striped" id="example3">
                                    <thead>
                                        <tr>
                                            <th width="5%">Bayar</th>
                                            <th width="10%">Tahun</th>
                                            <th width="10%">SPP Bulan</th>
                                            <th>Rp.</th>

                                            <th width="15%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Bayar</th>
                                            <th>SPP Bulan</th>
                                            <th>Tahun</th>
                                            <th>Rp.</th>

                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <input type="hidden" name="JumlahRp" value="<?=$JumlahRp?>">
                                <?php }
                                ?>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                              <?php
                                if ($DataCari !== FALSE) {
                                ?>
                              <div class="card-tools">
                                <button type="submit" class="btn btn-block btn-primary">
                                    <i class="fa fa-plus"></i> Bayar
                                </button>
                              </div>
                            <?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ROW -->
        <!-- /.container-fluid -->
        </div>
    </div>
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
