

    
  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024 PT.Bening Jaya Sentosa</strong>
    Theme By AdminLTE.
    <div class="float-right d-none d-sm-inline-block">
      <b>CIV</b>:<i>3.1.13</i> <b>PV</b>:<i>7.4.33</i> <b>VV</b>:<i>2.0.2</i> <b>SV</b>:<i>240425</i> Page rendered in <strong>{elapsed_time}</strong> seconds.
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- <script src="plugins/jquery/jquery.min.js"></script> -->




<script src="<?php echo base_url('assets/template/times/');?>moment-with-locales.min.js"></script>
<script>
        // Inisialisasi Bootstrap Timepicker dengan Moment.js
        $(function () {
            $('#inputTime').timepicker({
                icons: {
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down'
                },
                format: 'HH:mm', // Format waktu yang diinginkan, misalnya HH:mm:ss untuk jam:menit:detik
            });
        });
    </script>



<!-- Toastr -->
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/toastr/toastr.min.js"></script>

    <!-- Tampilkan notifikasi menggunakan Toastr warning jika ada -->
    <?php if ($this->session->flashdata('toastr_success')): ?>
        <script>
            toastr.success('<?php echo $this->session->flashdata('toastr_success'); ?>');
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('toastr_error')): ?>
        <script>
            toastr.error('<?php echo $this->session->flashdata('toastr_error'); ?>');
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('toastr_info')): ?>
        <script>
            toastr.info('<?php echo $this->session->flashdata('toastr_info'); ?>');
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('toastr_warning')): ?>
        <script>
            toastr.warning('<?php echo $this->session->flashdata('toastr_warning'); ?>');
        </script>
    <?php endif; ?>

    <!-- Isi halaman dengan konten yang diinginkan -->
    <!-- ... -->


<?php if($ButuhTabel==TRUE){ ?>
  <!-- DataTables  & Plugins -->
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>



<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    var table = $("#example1").DataTable({
      "paging": true,
      "lengthChange": false,
      "lengthMenu": [50, 75, 100, 250, 500],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    "buttons": [
        {
            extend: 'colvis',
            text: 'Sembunyikan', // Tekstual kustom untuk tombol
            className: '', // Kelas CSS kustom untuk tombol
            align: 'center',
            // columns: [0, 1, 2], // Menentukan kolom yang akan ditampilkan pada default
            // postfixButtons: ['colvisRestore'], // Tombol untuk mengembalikan ke tampilan awal
            // ... Tambahan pengaturan kustom lainnya ...
        }
    ]
});

// Menambahkan tombol "Visibility" ke tampilan
table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#example3').DataTable({
      "paging": true,
      "lengthMenu": [50, 100, 500],
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    $("#example4").DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

$('<button data-toggle="modal" data-target="#tambahdata1" type="button" class="btn btn-primary col-md-6"><i class="fa fa-plus"></i> Tambah Data</button>').appendTo('#example4_wrapper .col-sm-12.col-md-6:first');

$("#example5").DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

$('<button data-toggle="modal" data-target="#tambahdata2" type="button" class="btn btn-primary col-md-6"><i class="fa fa-plus"></i> Tambah Data</button>').appendTo('#example5_wrapper .col-sm-12.col-md-6:first');
  });

  $('#example7').DataTable({
      "paging": true,
      "lengthChange": false,
      "lengthMenu": [5],
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });

  $('#example8').DataTable({
      "paging": true,
      "lengthChange": false,
      "lengthMenu": [100],
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": true,
      "responsive": true,
    });

    $('#example9').DataTable({
      "paging": false,
      "lengthChange": false,
      "lengthMenu": [50, 75, 100, 250, 500],
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": true,
      "responsive": true,
    });

    $('#example10').DataTable({
      "paging": false,
      "lengthChange": false,
      "lengthMenu": [500],
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });

    $('#example11').DataTable({
      "paging": false,
      "lengthChange": false,
      "lengthMenu": [500],
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": false,
    });

    $('#example12').DataTable({
      "paging": false,
      "lengthChange": false,
      "lengthMenu": [500],
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": false,
    });

    $('#example13').DataTable({
      "paging": false,
      "lengthChange": false,
      "lengthMenu": [500],
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": false,
    });
</script>
<?php }?>


<?php if ($ButuhForm) { ?>
  

<!-- InputMask -->
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- BS-Stepper -->
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="<?php echo base_url('assets/template/AdminLTE-master/');?>plugins/dropzone/min/dropzone.min.js"></script>



<!-- Page specific script -->
<script>
  

      
// Saat halaman selesai dimuat
    $(document).ready(function() {

      // Disable F12 key
      $(document).keydown(function(e) {
        if (e.which === 123) {
          return false;
        }
      });



      

      
      // Tangkap form dengan ID registrationForm saat disubmit
      $("#registrationForm").submit(function(event) {
        // Ambil nilai dari kedua input password
        var password1 = $("#password1").val();
        var password2 = $("#password2").val();

        // Periksa apakah kedua password sama
        if (password1 !== password2) {
          alert("Password tidak cocok. Mohon ulangi kembali.");
          event.preventDefault(); // Mencegah formulir dari pengiriman
        }
      });


      // Fungsi untuk memeriksa kesamaan password
    function checkPasswordEquality() {
        var password1 = $("#password1").val();
        var password2 = $("#password2").val();
        var submitBtn = $("#submitBtn");

        // Jika password cocok, aktifkan tombol "Daftar"
        if (password1 === password2) {
            submitBtn.prop("disabled", false);
        } else {
            submitBtn.prop("disabled", true);
        }
    }

    // Memeriksa kesamaan password saat halaman dimuat
    checkPasswordEquality();

    // Periksa kesamaan password saat pengguna memasukkan nilai
    $("#password1, #password2").on("keyup", checkPasswordEquality);
    });
    
    
  $(function () {
   

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'DD/MM/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('D, MMMM YYYY') + ' - ' + end.format('D, MMMM YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
     // Dualistbox
  // $('.duallistbox').bootstrapDualListbox();

  // Colorpicker
  $('.my-colorpicker1').colorpicker();

  // Colorpicker with Addon
  $('.my-colorpicker2').colorpicker();

  $('.my-colorpicker2').on('colorpickerChange', function(event) {
    // Ubah warna ikon kotak (square)
    $('.my-colorpicker2 .input-group-text i').css('color', event.color.toString());

    // Ubah warna ikon lingkaran (circle) pada Colorpicker with Addon
    $('.my-colorpicker2 .input-group-append .input-group-text i').css('color', event.color.toString());
  });
  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

 


</script>
<?php } ?>

<script type="text/javascript">
  if (!window.select2Initialized) {
          // Jika belum diinisialisasi, lakukan inisialisasi
          $('.select2').select2();
          
          // Setel status inisialisasi ke true
          window.select2Initialized = true;
      }
  if (!window.dualListboxInitialized) {
    // Inisialisasi DualListbox
    $('.duallistbox').bootstrapDualListbox();
    
    // Setel status inisialisasi ke true
    window.dualListboxInitialized = true;
  }
  if (!window.summernoteboxInitialized) {
    // Inisialisasi summernote
    $('#compose-textarea').summernote({
      // Konfigurasi Summernote lainnya...
      fullscreen: false, // Menonaktifkan fitur fullscreen
    });
    
    // Setel status inisialisasi ke true
    window.summernoteInitialized = true;
  }
</script>

</body>
</html>