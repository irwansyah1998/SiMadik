<?php
function formatRupiah($angka) {
    $rupiah = number_format($angka, 2, ',', '.');
    return $rupiah;
}

function pasangbulan($angka){
    switch ($angka) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
        default:
            return "Bulan tidak valid";
    }
}

foreach ($DataSiswaPembayaran as $DSP) {
    $NisSiswa=$DSP->NisSiswaSiswa;
    $NamaSiswa=$DSP->NamaSiswa;
    $NamaOrtu=$DSP->NamaOrtu;
    $NomorHP=$DSP->NomorHP;
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
                            <h1 class="m-0">Laporan Pembayaran SPP</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Riwayat</li>
                                <li class="breadcrumb-item">Pembayaran</li>
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

                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <a href="<?php echo base_url('User_keuangan/BayarSPP/');?>" class="btn btn-block btn-success">
                                            <i class="fas fa-chevron-circle-left"></i> Kembali
                                        </a>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                    <div class="card-body col-md-12" id="formContainer">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label>Data Murid :</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="<?php echo base_url('PDFPrint/Keuangan/pdf/'.$NisSiswa);?>" class="btn btn-block btn-primary">
                                                    <i class="far fa-file-pdf"></i> Tampilkan file PDF
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Siswa :</label>
                                                        <p class="form-control"><?=$NamaSiswa?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor Induk Siswa :</label>
                                                        <p class="form-control"><?=$NisSiswa?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Wali Murid :</label>
                                                        <p class="form-control"><?=$NamaOrtu?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor HP :</label>
                                                        <p class="form-control"><?=$NomorHP?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Riwayat Pembayaran :</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($RiwayatPembayaran!==false) {
                                            foreach ($RiwayatPembayaran as $RP) {
                                        ?>
                                        <!-- /Riwayat Pembayaran -->
                                        <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Tanggal :</label>
                                                        <p class="form-control"><?=$RP->TglBayar?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Jumlah :</label>
                                                        <p class="form-control">Rp.<?=formatRupiah($RP->RiwayatBayar)?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Nama SPP :</label>
                                                        <p class="form-control"><?= $RP->Nama?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Bag. Keuangan :</label>
                                                        <p class="form-control"><?= $RP->NamaGuru?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>SPP Periode :</label>
                                                        <p class="form-control"><?= pasangbulan($RP->BayarBulan).'/'.$RP->BayarTahun?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Keterangan :</label>
                                                        <p class="form-control"><?= $RP->Keterangan?></p>
                                                    </div>
                                                </div>
                                        </div>
                                        <!-- /Riwayat Pembayaran -->
                                        <?php
                                            }
                                        } ?>

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                      
                                    </div>
                            </div>
                        </div>

                        
                    </div>
                    <!-- ROW -->
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
