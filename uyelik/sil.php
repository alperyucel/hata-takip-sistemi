<?php
require_once("baglanti.php");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Kullanıcıyı silme işlemi
    $silSorgu = "DELETE FROM kullanicilar WHERE id = '$userId'";
    $silSonuc = mysqli_query($baglanti, $silSorgu);

    if ($silSonuc) {
        header("Location: projeler.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($baglanti);
    }
} else {
    echo "Geçersiz bir kullanıcı IDsi.";
}

// Projeyi sil
if (isset($_GET["sil"])) {
    $sil_id = $_GET["sil"];
    $sil_sorgusu = "DELETE FROM projeler WHERE proje_id = '$sil_id'";
    $sil_sonuc = mysqli_query($baglanti, $sil_sorgusu);

    if ($sil_sonuc) {
        header("Location: projeler.php");
        exit();
    } else {
        echo "Hata: " . $sil_sorgusu . "<br>" . mysqli_error($baglanti);
    }
}

mysqli_close($baglanti);
?>