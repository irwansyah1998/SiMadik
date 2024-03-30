<style>
    .user-message,
    .ai-message {
        font-size: 20px; /* Ganti ukuran font sesuai keinginan Anda */
        /* Tambahan gaya lainnya, jika diperlukan */
    }
</style>
<!-- chat_page.php -->
<div class="content-wrapper">
    <div class="content-with-overlay">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    
                        <div class="col-sm-12" align="center">
                            <h1 class="m-0">Sistem Artificial Intelligence Pendidikan</h1>
                        </div>
                    
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <form id="chatForm">

                            
                                <p id="chat" class="chat-container">
                                    <!-- Tampilkan pesan chat di sini -->
                                </p>
                                <div id="loading" style="display: none;">
                                    <p class="ai-message"><b>Si ADik (AI) :</b><br>
                                    <p><i class="fas fa-spinner fa-pulse" style="color: #724fff;"></i> Sedang berfikir...</p>
                                </div>
                            
                            
                                <div class="input-group">
                                    <input required type="text" id="userMessage" class="form-control form-control-lg" placeholder="Type your message...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-lg btn-default" onclick="sendMessage()">
                                            <i class="fas fa-paper-plane"></i> Kirim
                                        </button>
                                    </div>
                                </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="bright-overlay"></div>
</div>

<script>

    // Tambahkan event listener untuk menangkap tombol "Enter"
    $('#userMessage').keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault(); // Mencegah perilaku default tombol "Enter"
            sendMessage(); // Panggil fungsi sendMessage() manual
        }
    });

    var chatHistory = []; // Variabel untuk menyimpan riwayat percakapan

    function sendMessage() {
        var userMessage = $('#userMessage').val();
        console.log('Sending message:', userMessage);

        // Menyimpan pesan pengguna ke riwayat percakapan
        chatHistory.push({ type: 'user', message: userMessage });

        // Tampilkan pesan pengguna di antarmuka sebelum menerima respons
        var chatDiv = $('#chat');
        chatDiv.append('<p class="user-message"><b>Anda :</b><br>' + userMessage + '</p>');

        // Menampilkan ikon loading di bawah pesan pengguna
        $('#loading').show();

        // Kirim pesan ke server CodeIgniter dengan menyertakan base_url dan konteks sebelumnya
        $.ajax({
            type: 'POST',
            url: '<?= base_url('User_Beta/sendMessage') ?>',
            data: { message: userMessage, context: chatHistory, language: 'id' },
            success: function (response) {
                console.log('Response:', response);

                // Menyembunyikan ikon loading setelah menerima respons
                $('#loading').hide();

                // Ambil pesan dari asisten (assistant) dari respons
                var aiMessage = response.AI;
                
                // Menyimpan pesan AI ke riwayat percakapan
                chatHistory.push({ type: 'ai', message: aiMessage });

                // Ganti setiap kemunculan blok kode dengan elemen textarea
                aiMessage = aiMessage.replace(/```([\s\S]+?)```/g, function(match, p1) {
                    return '<textarea class="form-control">' + p1 + '</textarea>';
                });

                aiMessage = aiMessage.replace(/`([^`]+)`/g, function(match, p1) {
                    return '<textarea class="form-control">' + p1 + '</textarea>';
                });

                // Menambahkan tag <br> untuk setiap newline dalam pesan AI
                aiMessage = aiMessage.replace(/\n/g, '<br>');

                // Menangani teks miring dan tebal untuk format seperti di WhatsApp
                aiMessage = aiMessage.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>'); // Tebal
                aiMessage = aiMessage.replace(/\*([^*]+)\*/g, '<em>$1</em>'); // Miring
                aiMessage = aiMessage.replace(/__([^_]+)__/g, '<em>$1</em>'); // Miring



                // Tampilkan pesan AI di bawah pesan pengguna
                chatDiv.append('<p class="ai-message"><b>Si ADik (AI) :</b><br>' + aiMessage + '</p>');

                // Scroll ke bawah untuk menampilkan pesan terbaru
                chatDiv.scrollTop(chatDiv[0].scrollHeight);
            },
            error: function (error) {
                console.log('Error:', error);

                // Menyembunyikan ikon loading jika terjadi kesalahan
                $('#loading').hide();

                // Tampilkan pesan kesalahan kepada pengguna
                alert('Error occurred while processing the request. Please try again.');
            }
        });

        // Bersihkan input setelah mengirim pesan
        $('#userMessage').val('');
    }






</script>

