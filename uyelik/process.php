<?php
require_once("baglanti.php");

if (isset($_POST["kullaniciekle"])) {
    $name = $_POST["adsoyad"];
    $email = $_POST["email"];
    $telefonno = $_POST["telefonno"];
    $dogumyili = $_POST["dogumyili"];
    $kullanici_adi = $_POST["kullaniciadi"];
    $sifre = $_POST["parola"];

    $ekle = "INSERT INTO kullanicilar (adsoyad, email, telefonno, dogumyili, kullanici_adi, parola)
             VALUES ('$name', '$email', '$telefonno', '$dogumyili', '$kullanici_adi', '$sifre')";

    $calistir = mysqli_query($baglanti, $ekle);

    if ($calistir) {
        echo "Kullanıcı başarıyla eklendi.";
    } else {
        echo "Hata: " . $ekle . "<br>" . mysqli_error($baglanti);
    }
}
 elseif (isset($_POST["kullaniciGuncelle"])) {
    // Kullanıcı güncelleme işlemi
    
    if(isset($_POST['userId'])){

    $userId = $_POST["userId"];
    $name = $_POST["adsoyad"];
    $email = $_POST["email"];
    $telefonno = $_POST["telefonno"];
    $dogumyili = $_POST["dogumyili"];
    $kullanici_adi = $_POST["kullaniciadi"];
    $sifre = $_POST["parola"];

    $guncelle = "UPDATE kullanicilar SET 
                 adsoyad = '$name',
                 email = '$email',
                 telefonno = '$telefonno',
                 dogumyili = '$dogumyili',
                 kullanici_adi = '$kullanici_adi',
                 parola = '$sifre'
                 WHERE id = '$userId'";

    $calistir = mysqli_query($baglanti, $guncelle);

    if ($calistir) {
        echo "Kullanıcı başarıyla güncellendi.";
    } else {
        echo "Hata: " . $guncelle . "<br>" . mysqli_error($baglanti);
    }
 }
}
mysqli_close($baglanti);
?>