
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const inputElement = document.getElementById('noSpecialCharsInput');

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



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 animate__animated animate__fadeInLeft">
            <h1 class="m-0">Edit Nilai Harian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 animate__animated animate__fadeInRight">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item">Penilaian</li>
               <li class="breadcrumb-item"><?= $_GET['KodeKelas']?></li>
               <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit Nilai Harian</h3>
            <div class="card-tools">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="btn-group">
                      <a class="btn btn-secondary col-12" href="<?= base_url('User_pengajar/Penilaian/Cari?Cari=Data&KodeGuru='.$_GET['KodeGuru'].'&KodeMapel='.$_GET['KodeMapel'].'&KodeTahun='.$_GET['KodeTahun'].'&IDSemester='.$_GET['IDSemester'].'&KodeKelas='.$_GET['KodeKelas'].'&IDAjaran='.$_GET['IDAjaran']);?>">Kembali</a>
                    </div>
                  </div>
                </div>
          </div>
          </div>

          <div class="card-body">
            <form id="dynamicForm" action="<?= base_url('User_pengajar');?>/PenilaianCRUD" method="POST">
              <input type="hidden" name="InsertNilaiHarian" value="TRUE">
              <?php foreach (['IDSemester', 'KodeTahun', 'IDAjaran', 'KodeKelas', 'KodeGuru'] as $param) { ?>
                <input type="hidden" name="<?= $param ?>" value="<?= $_GET[$param] ?>">
              <?php } ?>
              <div id="formContainer">
                <!-- Initial form template is removed -->

              </div>
              <br>
              <div class="row">
                <div class="col-8">
                  <div class="row">
                    <div class="col-12">
                      <button type="submit" class="col-12 btn btn-success">Submit</button>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="row">
                    <div class="col-12">
                      <button type="button" id="addFieldButton" class="col-12 btn btn-primary">Add Field</button>
                    </div>
                    
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<?php
if ($DataNilaiHarian!==FALSE) {
  foreach ($DataNilaiHarian as $hah) {
    ?>
      <div class="modal fade" id="Hapus<?= $hah->IDNilaiHarian ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form action="<?php echo base_url('User_pengajar');?>/PenilaianCRUD" method="POST">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Peringatan!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Apakah Anda yakin ingin menghapus data <?= $hah->KodeNilaiHarian ?> ?
                <input type="hidden" name="HapusNilaiHarian" value="TRUE">
                <input type="hidden" name="IDNilaiHarian" value="<?= $hah->IDNilaiHarian ?>">

              <?php foreach (['IDSemester', 'KodeTahun', 'IDAjaran', 'KodeKelas', 'KodeGuru', 'KodeMapel'] as $param) { ?>
                <input type="hidden" name="<?= $param ?>" value="<?= $_GET[$param] ?>">
              <?php } ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
              </div>
            </div>
          </form>
        </div>
      </div>
<?php }
}
?>
<script>

  const addFieldButton = document.getElementById("addFieldButton");
  const formContainer = document.getElementById("formContainer");

  addFieldButton.addEventListener("click", () => {
    const formTemplate = createFormTemplate({});
    formContainer.appendChild(formTemplate);

    const removeButton = formTemplate.querySelector(".removeFieldButton");
    removeButton.addEventListener("click", () => {
      formContainer.removeChild(formTemplate);
    });
  });

  $(document).ready(function() {
    var DataNilaiHarian = <?= json_encode($DataNilaiHarian) ?>;
    showDataInForm(DataNilaiHarian);
  });

  function showDataInForm(data) {
    const formContainer = document.getElementById("formContainer");

    data.forEach(item => {
      const formTemplate = createFormTemplate(item);
      formContainer.appendChild(formTemplate);

      const removeButton = formTemplate.querySelector(".removeFieldButton");
      removeButton.addEventListener("click", () => {
        if (formTemplate.querySelector("[name='nilai_harian[]']").value === '') {
          formContainer.removeChild(formTemplate);
        } else {
          showDeleteModal(formTemplate);
        }
      });
    });
  }

  function createFormTemplate(data) {
    const formTemplate = document.createElement("div");
    formTemplate.classList.add("form-template");
    formTemplate.innerHTML = `
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="nilai_harian">Nama Nilai Harian</label>
            <input type="hidden" class="form-control" name="IDnilai_harian[]" value="${data.IDNilaiHarian || '0'}">
            <input type="text" class="form-control" name="nilai_harian[]" value="${data.NamaNilaiHarian || ''}" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label for="kode_nilai">Kode Nilai Harian</label>
            <input type="text" id="noSpaceInput" class="form-control" name="kode_nilai[]" value="${data.KodeNilaiHarian || ''}" required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" class="form-control" name="keterangan[]" value="${data.Keterangan || ''}" required>
          </div>
        </div>
      </div>
     <div class="row">
        <div class="col-12">
          <button type="button" class="removeFieldButton btn btn-danger" data-toggle="modal" data-target="#Hapus${data.IDNilaiHarian || 'New'}">Remove</button>
        </div>
      </div>

      
    `;

    return formTemplate;
  }

  function showDeleteModal(formTemplate) {
    const modalId = formTemplate.querySelector(".removeFieldButton").getAttribute("data-target");
    $(modalId).modal("show");
  }

</script>



<!-- Hapus Data -->
                  

</div>