<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-with-overlay">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Setting Poin</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Setting Poin</a></li>
                          <li class="breadcrumb-item active">Skoring</li>
                      </ol>
                  </div>
              </div>
          </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <!-- Card Pertama -->
                       <div class="card card-secondary">
                          <div class="card-header p-2">
                              <!-- Tab-link untuk Card Pertama -->
                          </div><!-- /.card-header -->
                          <div class="card-body">
                              <table id="example4" class="table table-bordered table-striped">
                                  <thead>
                                      <tr>
                                          <th width="5%">No</th>
                                          <th>Keterangan Skor</th>
                                          <th width="5%">Poin</th>
                                          <th width="15%">Pengaturan</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php if ($DataPoin!=FALSE) {
                                          $no=0;
                                          foreach ($DataPoin as $key) {
                                              $no++; ?>
                                              <tr>
                                                  <td><?=$no?></td>
                                                  <td><?=$key->Keterangan?></td>
                                                  <td><?=$key->Poin?></td>
                                                  <td>
                                                      <div class="btn-group">
                                                          <button data-toggle="modal" data-target="#EditTabelModal<?=$key->IDJenis?>" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</button>
                                                          <button data-toggle="modal" data-target="#HapusModal<?= $key->IDJenis ?>" type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                                                      </div>
                                                  </td>
                                              </tr>
                                          <?php }
                                      }
                                      ?>
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>No</th>
                                          <th>Keterangan Skor</th>
                                          <th>Poin</th>
                                          <th>Pengaturan</th>
                                      </tr>
                                  </tfoot>
                              </table>
                          </div><!-- /.card-body -->
                      </div>
                      <!-- /.card Pertama -->

                  </div>
                  <!-- /.col -->
              </div>
              <!-- /.row -->
          </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <div class="bright-overlay"></div>
</div>
<!-- /.content-wrapper -->


<div class="modal fade" id="tambahdata1" tabindex="-1" role="dialog" aria-labelledby="tambahdata1" aria-hidden="true">
  <form action="<?php echo base_url('User_bk');?>/BKSkoringSetting" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="Insert" value="JenisPoin">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Tambah Data Untuk Poin!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <input type="hidden" name="SPP" value="TRUE">
                <label for="KodeTahun">Poin :</label>
                <div class="input-group">
                  <input type="text" name="Poin" class="form-control" value="">
                </div>
              </div>
            </div>
            <div class="col-md-10">
              <div class="form-group">
                <label for="KodeGuru">Keterangan :</label>
                <div class="input-group">
                  <input type="text" name="Keterangan" class="form-control" value="">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group col-md-12">
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-save"></i> Simpan
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<?php
if ($RekapPoinPelanggaran!==FALSE) {
$no=0;
foreach ($RekapPoinPelanggaran as $RPP2) {
$no++;
?>
<div class="modal fade" id="Detail<?=$RPP2->IDJenis?>" tabindex="-1" role="dialog" aria-labelledby="Detail" aria-hidden="true">
  <form action="<?php echo base_url('User_bk');?>/BKIndividu" method="POST">
    <input type="hidden" name="Insert" value="DataPelanggaran">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Apakah anda akan melihat data ?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="NisSiswa" value="<?=$RPP2->NisSiswa?>">
          <input type="hidden" name="CariData" value="Siswa">
          <p>Anda akan dialihkan menuju halaman Poin Pelanggaran untuk setiap individu siswa. Anda akan melihat data dari siswa bernama :<br><b><?=$RPP2->NamaSiswa?> (<?=$RPP2->NisSiswa?>).</b></p>
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group col-md-12">
                <button type="submit" class="btn btn-primary" >
                  <i class="fas fa-share"></i> Lanjutkan
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                  <i class="fas fa-window-close"></i> Batalkan
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?php }
}
?>

<?php if ($DataPoin!=FALSE) {
foreach ($DataPoin as $tb) { ?>
<div class="modal fade" id="EditTabelModal<?= $tb->IDJenis ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form action="<?php echo base_url('User_bk');?>/BKSkoringSetting" method="POST">
            <input type="hidden" name="Update" value="JenisPoin">
            <input type="hidden" name="IDJenis" value="<?=$tb->IDJenis?>">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Tabel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="hidden" name="SPP" value="TRUE">
                      <label for="KodeTahun">Poin :</label>
                <div class="input-group">
                  <input type="text" name="Poin" class="form-control" value="<?=$key->Poin?>">
                </div>
              </div>
            </div>
            <div class="col-md-10">
              <div class="form-group">
                <label for="KodeGuru">Keterangan :</label>
                <div class="input-group">
                  
                  <input type="text" name="Keterangan" class="form-control" value="<?=$key->Keterangan?>">
                </div>
              </div>
            </div>
          </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </div>

<div class="modal fade" id="HapusModal<?= $tb->IDJenis ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form action="<?php echo base_url('User_bk');?>/BKSkoringSetting" method="POST">
            <input type="hidden" name="Hapus" value="JenisPoin">
            <input type="hidden" name="IDJenis" value="<?=$tb->IDJenis?>">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Peringatan!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Hapus</button>
              </div>
            </div>
          </form>
        </div>
      </div>

<?php
  }
}
?>


