<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-with-overlay">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Jurnal Kegiatan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Jurnal</li>
                            <li class="breadcrumb-item">Jurnal Kegiatan</li>

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
                                        <table id="tabelcustom" class="table table-bordered table-striped">
                                            <thead align="center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Hari/Tgl</th>
                                                    <th>Kegiatan</th>
                                                    <th>Keterangan</th>
                                                    <th>Foto</th>
                                                    <th>Fungsi</th>
                                                </tr>
                                            </thead>
                                            <tbody align="center">
                                            </tbody>
                                            <tfoot align="center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Hari/Tgl</th>
                                                    <th>Kegiatan</th>
                                                    <th>Keterangan</th>
                                                    <th>Foto</th>
                                                    <th>Fungsi</th>
                                                </tr>
                                            </tfoot>
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
          <input type="hidden" name="IDJurnal" id="IDJurnalHapus">
          <div class="row">
            <div class="col-md-12">
              <p>Apakah Anda Yakin Ingin Menghapus Data?</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
          <button type="button" id="HapusData" class="btn btn-danger" onclick="HapusDataJurnal()">Hapus</button>
        </div>
      </div>
    </div>
</div>

<script>
    
    $(document).ready(function() {
        var idGuru = '<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>'; // Variabel untuk menyimpan IDGuru yang dipilih
        var token = '<?= $this->encryption->encrypt($IDHak) ?>';

        $('#tabelcustom').DataTable({
            "searching": true,
            "paging": true,
            "ordering": true,
            "lengthMenu": [1, 25, 50, 100, 250, 500],
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('API/DTJurnalKegiatan'); ?>",
                "type": "POST",
                "data": function(d) {
                    // Menambahkan parameter IDGuru ke dalam data yang dikirimkan
                    d.IDGuru = idGuru;
                    d.Token = token
                }
            },
            "columns": [
                { "data": null, "render": function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }, "orderable": false },
                { "data": "TanggalJurnal", "orderable": true },
                { "data": "Kegiatan", "orderable": false },
                { "data": "Keterangan", "orderable": false },
                {
                    "data": "Foto",
                    "orderable": false,
                    "render": function(data, type, row) {
                        // Pastikan data Foto tidak kosong
                        if (data) {
                            return '<img src="<?= base_url('/file/data/gambar/jurnalkegiatan/asli/') ?>' + data + '" alt="Gambar Kegiatan" width="100" height="100">';
                        } else {
                            return 'Tidak ada gambar';
                        }
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                            return '<button id="JurnalHapus_'+row.IDJurnal+'" type="button" class="btn btn-danger" onclick="openHapusModal('+row.IDJurnal+')">Hapus</button>';
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

    function openHapusModal(IDHak){
      document.getElementById('IDJurnalHapus').value = IDHak;
      $('#HapusModal').modal('show');
    }

    function HapusDataJurnal(){
      var Token = "<?= $this->encryption->encrypt($this->session->userdata('IDGuru')) ?>";
      $('#modal-buffer').show();
      var IDJurnal = $('#IDJurnalHapus').val();
      $.ajax({
          url: '<?php echo base_url("API/TambahDataJurnalKegiatan"); ?>',
          type: 'DELETE',
          dataType: 'json',
          data: { JurnalID: IDJurnal, token: Token }, // Mengirim token sebagai bagian dari data
          success: function(response) {
                  // Handle respons dari server jika diperlukan
                  console.log(response);
                  if (response.status === 'success') {
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
              // console.error(xhr.responseText);
          }
      });
    }
</script>

