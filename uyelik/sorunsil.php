<?php
require_once("baglanti.php");
 
if (isset($_GET["sil"])) {
    $sil_id = $_GET["sil"];
    $sil_sorgusu = "DELETE FROM sorunlar WHERE sorun_id = '$sil_id'";
    $sil_sonuc = mysqli_query($baglanti, $sil_sorgusu);

    if ($sil_sonuc) {
        echo "Proje başarıyla silindi.";
    } else {
        echo "Hata: " . $sil_sorgusu . "<br>" . mysqli_error($baglanti);
    }
}

mysqli_close($baglanti);
?>