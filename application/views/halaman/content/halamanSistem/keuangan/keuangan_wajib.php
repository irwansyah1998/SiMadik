<?php
  function formatRupiah($angka) {
    $rupiah = number_format($angka, 2, ',', '.');
    return "Rp." . $rupiah;
}
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Keuangan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Info</li>
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
        
        <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Pembayaran Wajib</h3>
                <div class="card-tools">
                  <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#InsertData"><i class="fas fa-plus"></i> Tambah Data</button>
                  </div>
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Tahun Ajaran</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th width="20%">Pengaturan</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($DataWajib!==false) {
                      $no=0;
                      foreach ($DataWajib as $key) {
                        $no++;
                    ?>
                    <tr>
                      <td><?=$no?></td>
                      <td><?=$key->KodeAjaran?></td>
                      <td><?=$key->NamaWajib?></td>
                      <td><?=$key->Keterangan?></td>
                      <td><?=formatRupiah($key->JumlahRpWajib)?></td>
                      <td>
                        <div class="btn-group">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#EditData<?= $key->IDWajib?>"><i class="fas fa-edit"></i>Edit</button>
                        <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $key->IDWajib?>"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</a>
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
                    <th>No</th>
                    <th>Tahun Ajaran</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
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
  <!-- /.content-wrapper -->



<div class="modal fade" id="InsertData" tabindex="-1" role="dialog" aria-labelledby="InsertData" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="InsertData">Tambah Data!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('User_keuangan');?>/WajibCRUD" method="POST">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="hidden" name="Wajib" value="TRUE">
                <input type="hidden" name="Insert" value="TRUE">
                <label for="KodeTahun">Nama :</label>
                <div class="input-group">
                  <input  type="text" class="form-control" name="Nama" placeholder="Nama Pembayaran..." title="Masukkan Nama Yang Benar!" required value="">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="KodeTahun">Tahun Ajaran :</label>
                <div class="input-group">
                  <select required class="form-control select2" name="IDAjaran" style="width: 100%;">
                        <?php foreach ($datatahunajaran as $row) { ?>
                          <option value="<?= $row->IDAjaran ?>"><?= $row->KodeAjaran ?></option>
                        <?php } ?>
                      </select>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="KodeGuru">Total Pembayaran :</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                  </div>
                  <input type="text" name="JumlahRp" id="nilai onlyNumbersInput" class="form-control" oninput="formatNumberInput(this)">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="KodeTahun">Keterangan :</label>
                <div class="input-group">
                  <input  type="text" class="form-control" name="Keterangan" placeholder="Keterangan..." title="Masukkan Keterangan Yang Benar!" required value="">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <button type="submit" class="form-control btn btn-block btn-success">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if ($DataWajib!==false) {
  foreach ($DataWajib as $key2) {
?>
<div class="modal fade" id="EditData<?= $key2->IDWajib?>" tabindex="-1" role="dialog" aria-labelledby="InsertData" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditData<?= $key2->IDWajib?>">Tambah Data!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('User_keuangan');?>/WajibCRUD" method="POST">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="hidden" name="Wajib" value="TRUE">
                <input type="hidden" name="Edit" value="TRUE">
                <label for="KodeTahun">Nama :</label>
                <div class="input-group">
                  <input  type="text" class="form-control" name="Nama" placeholder="Nama Pembayaran..." title="Masukkan Nama Yang Benar!" required value="<?= $key2->NamaWajib?>">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="KodeTahun">Tahun Ajaran :</label>
                <div class="input-group">
                  <select required class="form-control select2" name="IDAjaran" style="width: 100%;">
                        <?php foreach ($datatahunajaran as $row) { ?>
                          <option value="<?= $row->IDAjaran ?>" <?php if($key2->IDAjaran===$row->IDAjaran){echo "selected";}?> ><?= $row->KodeAjaran ?></option>
                        <?php } ?>
                      </select>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="KodeGuru">Total Pembayaran :</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                  </div>
                  <input type="text" name="JumlahRp" id="nilai onlyNumbersInput" class="form-control" oninput="formatNumberInput(this)" value="<?= $key2->JumlahRpWajib ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="KodeTahun">Keterangan :</label>
                <div class="input-group">
                  <input  type="text" class="form-control" name="Keterangan" placeholder="Keterangan..." title="Masukkan Keterangan Yang Benar!" required value="<?= $key2->Keterangan ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <button type="submit" class="form-control btn btn-block btn-success">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
  }
}
?>

<?php
if ($DataWajib!==false) {
  foreach ($DataWajib as $key3) {
?>
<div class="modal fade" id="deleteModal<?php echo $key3->IDWajib; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <form action="<?php echo base_url('User_keuangan');?>/WajibCRUD" method="POST">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type="hidden" name="Wajib" value="TRUE">
      <input type="hidden" name="Edit" value="TRUE">
      <input type="hidden" name="IDWajib" value="<?= $key3->IDWajib ?>">
      Apakah Anda yakin ingin menghapus data SPP <?php echo $key3->NamaWajib; ?>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-danger">Hapus</button>
      </div>
    </div>
  </div>
  </form>
</div>
<?php
}
}
?>


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

