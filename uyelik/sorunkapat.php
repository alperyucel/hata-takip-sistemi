<?php
require_once("baglanti.php");

$sorun_id = isset($_GET["id"]) ? $_GET["id"] : null;

if ($sorun_id && is_numeric($sorun_id)) {
    $guncelle_sorgusu = "UPDATE sorunlar SET cozuldu_mu = 1 WHERE sorun_id = '$sorun_id'";
    $guncelle_sonuc = mysqli_query($baglanti, $guncelle_sorgusu);

    if ($guncelle_sonuc) {
        header("Location: sorunlar.php");
        exit();
    } else {
        echo "Sorun kapatılırken bir hata oluştu.";
    }
} else {
    echo "Geçersiz sorun IDsi.";
}
?>