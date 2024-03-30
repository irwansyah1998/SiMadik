<?php
foreach ($DataMurid as $row) {
    $NIS=$row->NisSiswa;
    $Kelas=$row->KodeKelas;
    $Nama=$row->NamaSiswa;
    $Nama=$row->NamaSiswa;
}
if ($datanilai!==FALSE) {
    foreach ($datanilai as $tb) {
        $NilaiHarian=$tb->NilaiHarian;
        $KodeNilaiHarian=$tb->KodeNilaiHarian;
        $NilaiUTS=$tb->NilaiUTS;
        $NilaiUAS=$tb->NilaiUAS;
        $NisSiswa=$tb->NisSiswa;
    }
}
?>
<div class="content-wrapper">
    <div class="content-with-overlay">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0"><?php echo $Nama; ?> (<?php echo $Kelas; ?>)</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item">Penilaian</li>
                  <li class="breadcrumb-item"><?php echo $Kelas; ?></li>
                  <li class="breadcrumb-item active"><?php echo $Nama; ?></li>

                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <form action="<?php echo base_url('User_pengajar');?>/PenilaianCRUD" method="POST">
         <section class="content">
            <input type="hidden" name="NilaiHarian" value="TRUE">
            <input type="hidden" name="NisSiswa" value="<?php echo $NIS; ?>">
            <input type="hidden" name="IDAjaran" value="<?php echo $TahunAjaran; ?>">
            <input type="hidden" name="IDSemester" value="<?php echo $Semester; ?>">
            <input type="hidden" name="KodeMapel" value="<?php echo $KodeMapel; ?>">
            <input type="hidden" name="KodeKelas" value="<?php echo $Kelas; ?>">
            <input type="hidden" name="KodeTahun" value="<?php echo $idTahun; ?>">
            <input type="hidden" name="KodeGuru" value="<?php echo $KodeGuru; ?>">
                    <div class="container-fluid">


            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Masukkan Nilai</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="keterangan">Keterangan</label>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="nilaiHarian">Nilai:</label>
                        </div>
                    </div>
                </div>
            <?php

            ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div id="ketHarianContainer">
                                <?php if($KodeNilaiHarian!==null){
                                    $KodeNilai = explode('//', $KodeNilaiHarian);
                                    for ($i=0; $i < count($KodeNilai); $i++) { ?>
                                        <select class="form-control mb-2" name="ketHarian[]">
                                            <?php if ($PenilaianHari !== FALSE) {
                                                foreach ($PenilaianHari as $tb) { ?>
                                            <option value="<?= $tb->KodeNilaiHarian ?>" <?php if($tb->KodeNilaiHarian===$KodeNilai[$i]){echo "selected";} ?> >
                                                <?= $tb->NamaNilaiHarian ?>
                                            </option>
                                                <?php }
                                                } ?>
                                        </select>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <select class="form-control mb-2" name="ketHarian[]">
                                        <?php if ($PenilaianHari !== FALSE) {
                                                foreach ($PenilaianHari as $tb) { ?>
                                            <option value="<?= $tb->KodeNilaiHarian ?>">
                                                <?= $tb->NamaNilaiHarian ?>
                                            </option>
                                                <?php }
                                                } ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div id="nilaiHarianContainer">
                                    <?php if($NilaiHarian!==null){
                                    $Nilai = explode('//', $NilaiHarian);
                                    for ($i=0; $i < count($Nilai); $i++) { ?>
                                            <input type="number" class="form-control mb-2" name="nilaiHarian[]" value="<?= $Nilai[$i] ?>">
                                                <?php }
                                                }else{ ?>
                                    <input type="number" class="form-control mb-2" name="nilaiHarian[]">
                                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="tambahInputNilaiHarian()" class="btn btn-success">Tambah Nilai Harian</button>
                <button type="button" onclick="kurangInputNilaiHarian()" class="btn btn-danger">Kurang Nilai Harian</button>
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </div>





            </div>
                </section>
        </form>
        <!-- /.content -->
    </div>
    <div class="bright-overlay"></div>
  </div>

  <script>
            function tambahInputNilaiHarian() {
            var container = document.getElementById("nilaiHarianContainer");
            var container1 = document.getElementById("ketHarianContainer");

            var dataFromJson = <?= json_encode($PenilaianHari) ?>;

            var input = document.createElement("input");
            input.type = "number";
            input.className = "form-control mb-2";
            input.name = "nilaiHarian[]";
            container.appendChild(input);

            var select = document.createElement("select");
            select.className = "form-control mb-2";
            select.name = "ketHarian[]";
            for (var i = 0; i < dataFromJson.length; i++) {
                var option = document.createElement("option");
                option.value = dataFromJson[i].KodeNilaiHarian;
                option.text = dataFromJson[i].NamaNilaiHarian;
                select.appendChild(option);
            }
            container1.appendChild(select);
            }

            function kurangInputNilaiHarian() {
                var container = document.getElementById("nilaiHarianContainer");
            var container1 = document.getElementById("ketHarianContainer");
            
            var inputs = container.getElementsByTagName("input");
            var selects = container1.getElementsByTagName("select");
            
            if (inputs.length > 1 && selects.length > 0) {
                container.removeChild(inputs[inputs.length - 1]);
                container1.removeChild(selects[selects.length - 1]);
                }
            }

            function hitungNilai() {
                var nilaiHarianInputs = document.getElementsByName("nilaiHarian[]");
                var uts = parseFloat(document.getElementById("uts").value);
                var uas = parseFloat(document.getElementById("uas").value);

                var totalNilaiHarian = 0;
                for (var i = 0; i < nilaiHarianInputs.length; i++) {
                    totalNilaiHarian += parseFloat(nilaiHarianInputs[i].value);
                }
                var jumlahNilaiHarian = nilaiHarianInputs.length; // Jumlah nilai harian

                var HasilNilaiHarian = totalNilaiHarian / jumlahNilaiHarian;

                var nilaiAkhir = (2 * HasilNilaiHarian + uts + uas) / 4;

                document.getElementById("nilaiRapor").value = nilaiAkhir.toFixed(2);
                document.getElementById("nilaiAkhir").textContent = nilaiAkhir.toFixed(2);
                
            }
</script>

  <?php
// print_r($AbsensiGuru);
// print_r($AbsensiHadir);

?>