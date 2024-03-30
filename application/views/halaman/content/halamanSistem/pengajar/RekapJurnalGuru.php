<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-with-overlay">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Jurnal Guru Pengajar</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Jurnal</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const noSpecialCharsInput = document.getElementById('noSpecialCharsInputsss');

                if (noSpecialCharsInput) {
                    noSpecialCharsInput.addEventListener('input', function () {
                        const inputValue = noSpecialCharsInput.value;
                        const newValue = inputValue.replace(/[\W_]+/g, ''); // Menghapus semua spasi dan karakter khusus

                        if (inputValue !== newValue) {
                            noSpecialCharsInput.value = newValue;
                        }
                    });
                }

                const onlyNumbersInput = document.getElementById('onlyNumbersInput');

                if (onlyNumbersInput) {
                    onlyNumbersInput.addEventListener('input', function () {
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
                                <h3 class="card-title">Jurnal Guru :</h3>
                                <div class="card-tools">
                                    <div class="row mb-2">

                                    </div>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <select id="WhereIDMapel" name="IDMapel" class="form-control select2"
                                                required style="width: 100%;">
                                                <option value="">Pelajaran</option>
                                                <?php
                                                if ($MapelGuru != FALSE) {
                                                    foreach ($MapelGuru as $MG) { ?>
                                                        <option <?php if ($MG->IDMapel == $this->session->userdata('IDMapel')) {
                                                            echo "selected";
                                                        } ?> value="<?= $MG->IDMapel ?>"><?= $MG->NamaMapel ?>
                                                        </option>
                                                    <?php }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="tabelcustom" class="table table-bordered table-striped">
                                            <thead align="center">
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th rowspan="2">Hari/Tgl</th>
                                                    <th rowspan="2">Jam</th>
                                                    <th rowspan="2">Materi Pokok</th>
                                                    <th rowspan="2">Kegiatan Pembelajaran</th>
                                                    <th rowspan="2">Rencana Tindak Lanjut</th>
                                                    <th colspan="5">Rekap Kehadiran Siswa</th>
                                                    <th rowspan="2">Fungsi</th>
                                                </tr>
                                                <tr>
                                                    <th>Jmlh</th>
                                                    <th>Hadir</th>
                                                    <th>I</th>
                                                    <th>S</th>
                                                    <th>A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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
    $(document).ready(function () {
        var idGuru = "<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>";
        var idMapel = $("#WhereIDMapel").val(); // Variabel untuk menyimpan IDMapel yang dipilih

        // Fungsi untuk mengambil data berdasarkan IDMapel yang dipilih
        function fetchDataBasedOnMapel() {
            $('#tabelcustom').DataTable().ajax.reload(null, false);
        }

        // Inisialisasi select2
        $('#WhereIDMapel').select2();

        // Event change pada select IDMapel
        $('#WhereIDMapel').on('change', function () {
            idMapel = $(this).val();
            fetchDataBasedOnMapel();
        });

        $('#tabelcustom').DataTable({
            "responsive": true,
            "info": true,
            "paging": true,
            "lengthMenu": [25, 50, 100, 250, 500, 1000, 2000],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('User_pengajar/JurnalAmbilData'); ?>",
                "type": "POST",
                "data": function (d) {
                    // Kirim parameter tambahan jika diperlukan
                    d.IDGuru = idGuru;
                    d.IDMapel = idMapel;
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
                {
                    "data": "TglAbsensi",
                    "orderable": true,
                    "render": function (data) {
                        // Mengonversi tanggal ke format yang diinginkan
                        var date = new Date(data);
                        var day = date.getDate();
                        var month = date.getMonth() + 1;
                        var year = date.getFullYear();

                        // Menambahkan nol di depan tanggal dan bulan jika nilainya kurang dari 10
                        if (day < 10) {
                            day = '0' + day;
                        }
                        if (month < 10) {
                            month = '0' + month;
                        }

                        // Menggabungkan tanggal, bulan, dan tahun menjadi format "dd/mm/yyyy"
                        return day + '/' + month + '/' + year;
                    }
                }, // Kolom ini diurutkan
                { "data": "JamKe", "orderable": false }, // Kolom ini diurutkan
                { "data": "MateriPokok", "orderable": false }, // Kolom ini diurutkan
                { "data": "Kegiatan", "orderable": false }, // Kolom ini diurutkan
                { "data": "TindakLanjut", "orderable": false }, // Kolom ini diurutkan
                { "data": "TotalSiswa", "orderable": false }, // Kolom ini diurutkan
                { "data": "JumlahM", "orderable": false }, // Kolom ini diurutkan
                { "data": "JumlahI", "orderable": false }, // Kolom ini diurutkan
                { "data": "JumlahS", "orderable": false }, // Kolom ini diurutkan
                { "data": "JumlahA", "orderable": false }, // Kolom ini tidak diurutkan
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<div class="btn-group" ><a type="button" href="<?= base_url('User_pengajar/RekapitulasiJurnal/Edit') ?>?IDJurnal=' + data.IDJurnal + '" class="btn btn-info">Edit</a>' +
                            '<button type="button" class="btn btn-danger btn-delete" data-id="' + data.IDJurnal + '">Hapus</button></div>';
                    },
                    "orderable": false
                }
            ],
            "order": [[1, 'desc']], // Mengurutkan kolom Tanggal Absensi secara default dari yang terbaru
            "drawCallback": function (settings) {
                var api = this.api();
                var response = api.ajax.json();
                console.log(response);
            }
        });

    });

    function openEditModal(IDJurnal) {
        console.log('Memilih Menu Edit :' + IDJurnal);
        // Tambahkan logika untuk membuka modal atau lakukan apa yang Anda inginkan dengan IDJurnal
        // Contoh: Munculkan modal atau arahkan ke halaman edit dengan menggunakan idJurnal
        // Pada titik ini, Anda dapat menyesuaikan dengan logika yang sesuai dengan kebutuhan Anda,
        // seperti menampilkan modal dengan data tersebut atau mengarahkan pengguna ke halaman edit.
    }

    // Tambahkan kode jQuery untuk menangani klik tombol hapus dan menampilkan modal konfirmasi
    $(document).on('click', '.btn-delete', function () {
        var idJurnal = $(this).data('id');
        var Token = '<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>';
        $('#modal-confirm-delete').modal('show');

        // Tambahkan event click pada tombol "Hapus" di modal konfirmasi
        $('#btn-confirm-delete').on('click', function () {
            // Lakukan proses penghapusan data dengan menggunakan AJAX
            $.ajax({
                url: '<?php echo base_url('API/JurnalGuruPengajar'); ?>', // Ganti URL_untuk_menghapus_data dengan URL yang sesuai untuk menghapus data
                type: 'DELETE',
                data: {
                    IDJurnal: idJurnal,
                    Token: Token,
                 },
                success: function (response) {
                    // Lakukan sesuatu setelah data berhasil dihapus, seperti memperbarui tabel atau menampilkan pesan sukses
                    // console.log('Data berhasil dihapus');
                    if (response.status == 'success') {
                        toastr.success(response.msg);
                        $('#tabelcustom').DataTable().ajax.reload();
                    }
                },
                error: function (xhr, status, error) {
                    // Tangani kesalahan jika terjadi saat menghapus data
                    console.error(xhr.responseText);
                }
            });

            // Sembunyikan modal konfirmasi setelah proses hapus selesai
            $('#modal-confirm-delete').modal('hide');
        });
    });
</script>

<!-- Modal Konfirmasi Penghapusan -->
<div class="modal fade" id="modal-confirm-delete" tabindex="-1" aria-labelledby="modal-confirm-delete-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-confirm-delete-label">Konfirmasi Penghapusan</h5>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Batalkan</button>
                <button type="button" class="btn btn-danger" id="btn-confirm-delete">Hapus</button>
            </div>
        </div>
    </div>
</div>