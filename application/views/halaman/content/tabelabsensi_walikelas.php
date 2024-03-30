<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Absensi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item">Absensi </li>
              <li class="breadcrumb-item active">Murid</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container mt-5">
        <div class="card col-md-8 card-secondary card-outline">
          <div class="card-header">
            <label>Cari Absensi :</label>
            <div class="col-md-12">
              <form action="<?php echo base_url('User_halaman/DataAbsenMasuk');?>" method="POST" >
                <input type="hidden" name="Cari" value="Data">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jam Pelajaran :</label>
                  <select class="form-control select2bs4" name="IDJamPel" style="width: 100%;">
                    <?php foreach ($jampel as $tb2) {?>
                      <option value="<?php echo $tb2->IDJamPel; ?>" ><?php echo $tb2->MulaiJampel;?> ~ <?php echo $tb2->AkhirJampel;?></option>
                    <?php } ?>
                  </select>
                </div>
                <!-- /.form-group -->
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Pilih Tanggal:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                      <input name="TglAbsensi" type="text" class="form-control datetimepicker-input" data-inputmask-alias="datetime" inputmode="numeric" data-target="#reservationdate" value="" required>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <!-- /.form-group -->
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-12">
                <div class="form-group">
                <label>Pilih Kelas:</label>
                      <select required class="form-control select2" name="KodeKelas" style="width: 100%;">
                        <?php foreach ($kelas as $tb) {?>
                        <option value="<?php echo $tb->KodeKelas; ?>" ><?php echo $tb->KodeKelas;?></option>
                        <?php } ?>
                      </select>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
              
              <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary">
                <i class="fa fa-plus"></i> Cari Data
                </button>
              </div>
              </form>
          </div>
          </div>
              <!-- /.card-header -->
        <div class="card-body">


        </div>
              <!-- /.card-body -->
      </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>