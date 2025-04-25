<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $youtubeUrl = $_POST['url'];

    // Lokasi yt-dlp dan ffmpeg
    $ytDlpPath = __DIR__ . '/bin/yt-dlp.exe';
    $ffmpegPath = __DIR__ . '/bin/ffmpeg.exe';

    $folder = 'mp3/';
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    // Mengambil judul video YouTube menggunakan yt-dlp
    $command = "\"$ytDlpPath\" -e \"$youtubeUrl\"";
    $videoTitle = shell_exec($command);
    $videoTitle = trim($videoTitle); // Menghapus spasi di awal dan akhir

    // Menangani nama file yang aman (menghapus karakter yang tidak valid untuk nama file)
    $safeTitle = preg_replace('/[\/:*?"<>|]/', '', $videoTitle); // Menghapus karakter yang tidak valid
    $safeTitle = preg_replace('/\s+/', ' ', $safeTitle); // Mengganti spasi ganda dengan satu spasi

    // Tentukan nama file mp3
    $filename = $safeTitle . '.mp3';
    $outputPath = $folder . $filename;

    // Perintah konversi video ke mp3
    $command = "\"$ytDlpPath\" --ffmpeg-location \"$ffmpegPath\" -x --audio-format mp3 -o \"$outputPath\" \"$youtubeUrl\" 2>&1";
    $output = shell_exec($command);

    // Setelah konversi berhasil, arahkan ke halaman hasil
    if (file_exists($outputPath)) {
        header('Location: hasil.php?file=' . urlencode($filename));
        exit;  // Jangan lanjutkan eksekusi kode
    } else {
        $error = "Gagal mengunduh atau mengonversi.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Convert YouTube ke MP3</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            margin-top: 10px;
        }

        .error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <h2>Convert YouTube ke MP3</h2>
    <form method="POST">
        <label>Masukkan Link YouTube:</label><br>
        <input type="text" name="url" placeholder="https://www.youtube.com/watch?v=xxxxx" required>
        <button type="submit">Convert</button>
    </form>

    <?php if (!empty($error)): ?>
        <div class="error">❌ <?= $error ?></div>
    <?php endif; ?>

</body>

</html>