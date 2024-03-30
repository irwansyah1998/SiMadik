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
                                            <select id="WhereIDGuru" name="IDGuru" class="form-control select2" required style="width: 100%;">
                                                <option value="">Guru</option>
                                                <?php
                                                if ($NamaGuru != FALSE) {
                                                    foreach ($NamaGuru as $NG) { ?>
                                                        <option <?php if ($NG->IDGuru == $this->session->userdata('IDGuru')) {
                                                                    echo "selected";
                                                                } ?> value="<?= $NG->IDGuru ?>"><?= $NG->NamaGuru ?></option>
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
                                                    <th rowspan="2">Nama Guru</th>
                                                    <th rowspan="2">Kelas</th>
                                                    <th rowspan="2">Mapel</th>
                                                    <th rowspan="2">Materi Pokok</th>
                                                    <th rowspan="2">Kegiatan Pembelajaran</th>
                                                    <th colspan="5">Rekap Kehadiran Siswa</th>
                                                    <th rowspan="2">Rencana Tindak Lanjut</th>
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
    
    $(document).ready(function() {
        var idGuru = $("#WhereIDGuru").val(); // Variabel untuk menyimpan IDGuru yang dipilih

        // Fungsi untuk mengambil data berdasarkan IDGuru yang dipilih
        function fetchDataBasedOnGuru() {
            $('#tabelcustom').DataTable().ajax.reload(null, false);
        }

        // Inisialisasi select2
        $('#WhereIDGuru').select2();

        // Event change pada select IDGuru
        $('#WhereIDGuru').on('change', function() {
            idGuru = $(this).val();
            fetchDataBasedOnGuru();
        });

        $('#tabelcustom').DataTable({
            "searching": true,
            "ordering": true,
            "lengthMenu": [25, 50, 100, 250, 500, 1000, 2000],
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('User_kepsek/JurnalGuruAmbilData'); ?>",
                "type": "POST",
                "data": function(d) {
                    // Menambahkan parameter IDGuru ke dalam data yang dikirimkan
                    d.IDGuru = idGuru;
                }
            },
            "columns": [
                { "data": null, "render": function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }, "orderable": false },
                { "data": "TglAbsensi", "orderable": true },
                { "data": "JamKe", "orderable": false },
                { "data": "NamaGuru", "orderable": false },
                { "data": "KodeKelas", "orderable": false },
                { "data": "NamaMapel", "orderable": false },
                { "data": "MateriPokok", "orderable": false },
                { "data": "Kegiatan", "orderable": false },
                { "data": "TotalSiswa", "orderable": false },
                { "data": "JumlahM", "orderable": false },
                { "data": "JumlahI", "orderable": false },
                { "data": "JumlahS", "orderable": false },
                { "data": "JumlahA", "orderable": false },
                { "data": "TindakLanjut", "orderable": false },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        if (row.Status === 'Konfirmasi') {
                            return '<button id="Jurnal_'+row.IDJurnal+'" type="button" class="btn btn-danger" onclick="openBatalkanModal('+row.IDJurnal+')">Batalkan</button>';
                        } else {
                            return '<button id="Jurnal_'+row.IDJurnal+'" type="button" class="btn btn-info" onclick="openKonfirmasiModal('+row.IDJurnal+')">Konfirmasi</button>';
                        }
                    },
                    "orderable": false
                }
            ],
            "order": [[1, 'desc']],
            "drawCallback": function(settings) {
                var api = this.api();
                var response = api.ajax.json();
                console.log(response);
            }
        });
    });

    function openKonfirmasiModal(IDJurnal) {
        var button = $('#Jurnal_' + IDJurnal);

        // Men-disable button saat proses pengiriman data
        button.prop('disabled', true);
        
        // Membuat objek data yang akan dikirimkan ke server
        var postData = {
            IDJurnal: IDJurnal,
            IDPengirim: '<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>',
            Perintah: '<?= $this->encryption->encrypt('Konfirmasi') ?>'
        };

        // Melakukan request AJAX
        console.log('Request Ajax');

        $.ajax({
            url: "<?php echo base_url('User_kepsek/JurnalSideServerCRUD'); ?>",
            type: "POST",
            data: postData,
            dataType: "json", // Menambahkan dataType untuk mengonversi response menjadi objek JSON
            success: function(response) {
                console.log('Data berhasil dikirim ke server');
                
                // Handle response dari server jika diperlukan
                if (response.status === 'success') {
                    toastr.success(response.msg);
                    button.prop('disabled', false);
                    setTimeout(function() {
                            fetchDataBasedOnGuru();
                        }, 0);
                    // Mengubah tampilan button dari "Konfirmasi" menjadi "Batalkan"
                    toggleButton(button, 'btn-info', 'btn-danger', 'Batalkan', openBatalkanModal, IDJurnal);
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function(error) {
                console.error('Gagal mengirim data ke server:', error);
                toastr.error("Terjadi kesalahan saat mengirim permintaan AJAX.");
                // Handle error jika diperlukan
            }
        });
    }

    // Fungsi untuk mengubah tampilan button dan fungsi onclick
    function toggleButton(button, oldClass, newClass, newText, newFunction, IDJurnal) {
        button.removeClass(oldClass).addClass(newClass);
        button.text(newText);
        button.prop('onclick', null).off('click');
        button.click(function() {
            newFunction(IDJurnal);
        });
    }

    function openBatalkanModal(IDJurnal) {
        var button = $('#Jurnal_' + IDJurnal);

        // Men-disable button saat proses pengiriman data
        button.prop('disabled', true);
        // Membuat objek data yang akan dikirimkan ke server
        var postData = {
            IDJurnal: IDJurnal,
            IDPengirim: '<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>',
            Perintah: '<?= $this->encryption->encrypt('Batalkan') ?>'
        };

        // Melakukan request AJAX
        console.log('Request Ajax');

        $.ajax({
            url: "<?php echo base_url('User_kepsek/JurnalSideServerCRUD'); ?>",
            type: "POST",
            data: postData,
            dataType: "json", // Menambahkan dataType untuk mengonversi response menjadi objek JSON
            success: function(response) {
                console.log('Data berhasil dikirim ke server');
                // Handle response dari server jika diperlukan
                if (response.status === 'success') {
                    toastr.success(response.msg);
                    button.prop('disabled', false);
                    toggleButton(button, 'btn-danger', 'btn-info', 'Konfirmasi', openKonfirmasiModal, IDJurnal);
                    // Memanggil fungsi fetchDataBasedOnGuru setelah operasi selesai
                        setTimeout(function() {
                            fetchDataBasedOnGuru();
                        }, 0);

                    

                } else {
                    toastr.error(response.msg);
                }
            },
            error: function(error) {
                console.error('Gagal mengirim data ke server:', error);
                toastr.error("Terjadi kesalahan saat mengirim permintaan AJAX.");
                // Handle error jika diperlukan
            }
        });
    }
</script>