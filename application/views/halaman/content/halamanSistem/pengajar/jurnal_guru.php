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
                                            <table id="example7" class="table table-bordered table-striped">
                                                <thead align="center">
                                                    <tr>
                                                        <th width="10%">Tingkatan</th>
                                                        <th width="10%">Kelas</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th width="10%">Tampilan</th>
                                                        <th width="10%">Jurnal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (isset($JurnalGuruData)&&$JurnalGuruData!==false) {
                                                        foreach ($JurnalGuruData as $JGD) {
                                                         ?>
                                                    <tr>
                                                    <?= form_open(base_url('User_pengajar/JurnalDownload/Download/'.$JGD->IDGuru.'/'.$JGD->IDKelas.'/'.$JGD->IDMapel.'/'.$this->session->userdata('IDSemester').'/'.$this->session->userdata('IDAjaran')), array('method' => 'post')) ?>
                                                            <td align="center"><?= $JGD->KodeTahun ?></td>
                                                            <td align="center"><?= $JGD->KodeKelas ?></td>
                                                            <td align="center"><?= $JGD->NamaMapel ?></td>
                                                            <td align="left">
                                                                <div class="form-check">
                                                                    <input id="waktuCheckbox" name="Fitur[]" type="checkbox" class="form-check-input kelas-checkbox" value="Waktu">
                                                                    <label for="waktuCheckbox" class="form-check-label"> <b>Waktu</b></label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input id="jamCheckbox" name="Fitur[]" type="checkbox" class="form-check-input kelas-checkbox" value="JamKe">
                                                                    <label for="jamCheckbox" class="form-check-label"> <b>Jam Ke-</b></label>
                                                                </div>
                                                            </td>
                                                            <td align="center">
                                                                <div class="btn-group">
                                                                    <button type="submit" class="btn btn-block btn-primary"> <i class="fas fa-file-download fa-lg"></i> Unduh
                                                                    </button>
                                                                </div>
                                                            </td>                              
                                                    <?= form_close(); ?>
                                                    </tr>
                                                    <?php
                                                         }
                                                    } ?>
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

