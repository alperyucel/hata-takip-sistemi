<?php
require_once("header.php");
require_once("baglanti.php");

session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : null;

$proje_id = isset($_GET["id"]) ? $_GET["id"] : null;

// Projeyi veritabanından alma
if ($proje_id && is_numeric($proje_id)) {
    $sorgu = "SELECT * FROM projeler WHERE proje_id = '$proje_id'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if ($sonuc) {
        $proje = mysqli_fetch_assoc($sonuc);
    } else {
        echo "Hata: " . $sorgu . "<br>" . mysqli_error($baglanti);
    }
}

// Projeyi güncelle veya yeni proje ekle
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $proje_adi = $_POST["proje_adi"];
    $aciklama = $_POST["aciklama"];

    if ($proje_id) {
        $guncelle_sorgusu = "UPDATE projeler SET proje_adi = '$proje_adi', aciklama = '$aciklama' WHERE proje_id = '$proje_id' AND kullanici_id = '$kullanici_id'";
    } else {
        $guncelle_sorgusu = "INSERT INTO projeler (proje_adi, aciklama, proje_tarihi, kullanici_id) 
                            VALUES ('$proje_adi', '$aciklama', NOW(), '$kullanici_id')";
    }

    $guncelle_sonuc = mysqli_query($baglanti, $guncelle_sorgusu);

    if ($guncelle_sonuc) {
        header("Location: projeler.php");
        exit();
    } else {
        echo "Hata: " . $guncelle_sorgusu . "<br>" . mysqli_error($baglanti);
    }
}

mysqli_close($baglanti);
?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>
        <main>
            <form action="projeyukle.php" method="POST">
                <div class="container py-3">
                    <h3><?php echo $proje_id ? "Projeyi Düzenle" : "Yeni Proje Ekle"; ?></h3>
                    <div class="card p-3">
                        <div class="mb-3 text-start">
                            <label for="exampleProje" class="form-label"><strong>Proje Adı</strong></label>
                            <input type="text" class="form-control" name="proje_adi" id="exampleProje" value="<?php echo isset($proje['proje_adi']) ? $proje['proje_adi'] : ""; ?>" aria-describedby="ProjeAdiHelp">
                        </div>
                        <div class="mb-3 text-start">
                            <label for="exampleAciklama" class="form-label"><strong>Açıklama</strong></label>
                            <textarea class="form-control" name="aciklama" id="exampleAciklama" rows="5"><?php echo isset($proje['aciklama']) ? $proje['aciklama'] : ""; ?></textarea>
                        </div>
                        <div class="row">
                            <div class="btn-container">
                                <button type="submit" name="<?php echo $proje_id ? "projeGuncelle" : "projeEkle"; ?>" class="btn btn-primary"><?php echo $proje_id ? "Projeyi Güncelle" : "Proje Ekle"; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>

<?php 
require_once("scripts.php"); 
?>