<?php
$file = $_GET['file'] ?? '';
$linkHasil = '';
$error = '';

if ($file && file_exists(__DIR__ . '/mp3/' . $file)) {
    $linkHasil = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/mp3/" . $file;
} else {
    $error = "File tidak ditemukan atau belum di-convert.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Hasil Convert</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        .result {
            margin-top: 20px;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <h2>Hasil Convert</h2>

    <div class="result">
        <?php if ($linkHasil): ?>
             Link Hasil: <a href="<?= $linkHasil ?>" target="_blank"><?= $linkHasil ?></a><br><br>
             <audio controls>
                <source src="<?= $linkHasil ?>" type="audio/mpeg">Browser Anda tidak mendukung audio.</audio><br><br>
            <a href="convert.php">Convert Lagi</a>
        <?php else: ?>
            <div class="error">error<?= $error ?></div>
        <?php endif; ?>
    </div>

</body>

</html>