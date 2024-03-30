<!DOCTYPE html>
<html>
<head>
    <title>Absen Masuk Jam</title>
</head>
<body>
    <h1>Absen Masuk Jam</h1>
    <form id="absenForm">
        <label for="nis_siswa">NIS Siswa:</label>
        <input type="text" name="nis_siswa" id="nis_siswa" required><br>

        <input type="submit" value="Absen Masuk">
    </form>

    <div id="result"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#absenForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '<?php echo base_url("Tes/absen_masuk"); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        $('#result').html('<p>' + response.message + '</p>');
                        console.log(response.jam_masuk);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>
</html>
