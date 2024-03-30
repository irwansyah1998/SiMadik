<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-with-overlay">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 animate__animated animate__fadeInLeft">
            <h1 class="m-0">Tabel Tingkat (Kelas)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 animate__animated animate__fadeInRight">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Tingkatan</li>
              <li class="breadcrumb-item">Menu Kelas</li>
              <li class="breadcrumb-item">Sekolah</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const inputElement = document.getElementById('noSpecialCharsInputsss');

        inputElement.addEventListener('input', function() {
          const inputValue = inputElement.value;
          const newValue = inputValue.replace(/[\W_]+/g, ''); // Menghapus semua spasi dan karakter khusus

          if (inputValue !== newValue) {
            inputElement.value = newValue;
          }
        });
      });

      document.addEventListener('DOMContentLoaded', function() {
        const inputElement = document.getElementById('noSpecialCharsInputss');

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

        <div class="card card-secondary shadow animate__animated animate__fadeInLeft">
          <div class="card-header">
            <div class="card-tools">
              <button data-toggle="modal" data-target="#InsertTabel" type="button" class="btn btn-block btn-primary shadow">
                <i class="fa fa-plus"></i> Tambah Data
              </button>
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped shadow">
              <thead>
                <tr>
                  <th width="5%">Kode Tahun</th>
                  <th>Penyebutan</th>
                  <th>Penulisan</th>
                  <th width="15%">Pengaturan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($TabelTingkat !== FALSE) {
                  $no = 0;
                  foreach ($TabelTingkat as $TT) {
                    $no++;
                ?>
                    <tr>
                      <td><?= $TT->KodeTahun ?></td>
                      <td><?= $TT->PenyebutanTahun ?></td>
                      <td><?= $TT->PenulisanTahun ?></td>
                      <td>
                        <div class="btn-group">
                          <button data-toggle="modal" data-target="#DeleteTabel<?= $TT->IDTahun ?>" type="button" class="btn btn-danger shadow"><i class="fa fa-trash"></i>Hapus</button>
                        </div>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Kode Tahun</th>
                  <th>Penyebutan</th>
                  <th>Penulisan</th>
                  <th>Pengaturan</th>
                </tr>
              </tfoot>
            </table>
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

<div class="modal fade" id="InsertTabel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Tambah Data!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('User_admin/TabelTingakatanCRUD'); ?>" method="POST">
          <input type="hidden" name="InsertData" value="Tingkatan">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Kode Tahun:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                  </div>
                  <input id="onlyNumbersInput" type="text" class="form-control" name="KodeTahun" placeholder="Masukkan Kode Tahun...." title="Kode Tahun Yang Benar!" required>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Penyebutan:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-server"></i></span>
                  </div>
                  <input id="noSpecialCharsInputsss" type="text" class="form-control" name="Penyebutan" placeholder="Penyebutan..." required>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Penulisan :</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                  </div>
                  <input id="noSpecialCharsInputss" type="text" class="form-control" name="Penulisan" placeholder="Penulisan..." title="Kode Tahun Yang Benar!" required>
                </div>
              </div>
            </div>
          </div>

          <!-- /.form group -->
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

<?php
if ($TabelTingkat !== FALSE) {
  $no = 0;
  foreach ($TabelTingkat as $TT) {
    $no++;
?>
    <div class="modal fade" id="DeleteTabel<?= $TT->IDTahun ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Apakah Anda yakin ingin menghapus data <?php echo $TT->PenyebutanTahun; ?>?
          </div>
          <form action="<?php echo base_url('User_admin/TabelTingakatanCRUD'); ?>" class="col-md-12" method="POST">
            <input type="hidden" name="HapusData" value="Tingkatan">
            <input type="hidden" name="IDTahun" value="<?= $TT->IDTahun ?>">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php
  }
}
?>