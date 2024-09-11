<?php
require_once("header.php");
require_once("baglanti.php");

session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : null;

$sorun_id = isset($_GET["id"]) ? $_GET["id"] : null;

if ($sorun_id && is_numeric($sorun_id)) {
    $sorgu = "SELECT * FROM sorunlar WHERE sorun_id = '$sorun_id'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if ($sonuc) {
        $sorun = mysqli_fetch_assoc($sonuc);
    } else {
        echo "Hata: " . $sorgu . "<br>" . mysqli_error($baglanti);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $baslik = $_POST["baslik"];
    $aciklama = $_POST["aciklama"];
    
    // Checkbox değerlerini al
    $secenek1 = isset($_POST['secenek1']) ? 1 : 0;
    $secenek2 = isset($_POST['secenek2']) ? 2 : 0;
    $secenek3 = isset($_POST['secenek3']) ? 4 : 0;
    
    // Seçeneklerin toplamını hesapla
    $secenekler = $secenek1 + $secenek2 + $secenek3;

    if ($sorun_id) {
        $guncelle_sorgusu = "UPDATE sorunlar SET sorun_baslik = '$baslik', aciklama = '$aciklama', secenekler = '$secenekler' WHERE sorun_id = '$sorun_id'";
    } else {
        $guncelle_sorgusu = "INSERT INTO sorunlar (sorun_baslik, aciklama, sorun_tarih, kullanici_id, secenekler) 
                            VALUES ('$baslik', '$aciklama', NOW(), '$kullanici_id', '$secenekler')";
    }

    $guncelle_sonuc = mysqli_query($baglanti, $guncelle_sorgusu);

    if ($guncelle_sonuc) {
        header("Location: sorunlar.php");
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
            <form action="sorunolustur.php?id=<?php echo $sorun_id; ?>" method="POST">  
                <div class="container py-3">
                    <h3>Sorun Oluştur</h3> 
                    
                    <div class="card p-3">
                        <div class="mb-3 text-start">
                            <label for="exampleSorun" class="form-label"><strong>Başlık</strong></label>
                            <input type="text" class="form-control" name="baslik" id="exampleSorun" aria-describedby="SorunBasligiHelp" value="<?php echo isset($sorun['sorun_baslik']) ? $sorun['sorun_baslik'] : ''; ?>">
                        </div>
                        <div class="mb-3 text-start">
                            <label for="exampleAcıklama" class="form-label"><strong>Açıklama</strong></label>
                            <textarea class="form-control" name="aciklama" id="exampleAciklama" rows="5"><?php echo isset($sorun['aciklama']) ? $sorun['aciklama'] : ''; ?></textarea>
                        </div>
                        <label for="exampleSsecenek" class="form-label"><strong>Öncelik Seçiniz</strong></label>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input type="checkbox" id="secenek1" name="secenek1" value="1" <?php echo isset($sorun['secenek1']) && $sorun['secenek1'] == 1 ? 'checked' : ''; ?>>
                                    <label for="secenek1">Düşük</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input type="checkbox" id="secenek2" name="secenek2" value="2" <?php echo isset($sorun['secenek2']) && $sorun['secenek2'] == 2 ? 'checked' : ''; ?>>
                                    <label for="secenek2">Orta</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input type="checkbox" id="secenek3" name="secenek3" value="4" <?php echo isset($sorun['secenek3']) && $sorun['secenek3'] == 4 ? 'checked' : ''; ?>>
                                    <label for="secenek3">Yüksek</label>
                                </div>
                            </div>
                        <div class="row">
                            <div class="btn-container">
                                <button type="submit" class="btn btn-primary">Sorun Ekle</button>  
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