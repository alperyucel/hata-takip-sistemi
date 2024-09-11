<?php
require_once("header.php");
require_once("baglanti.php");

session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0;

$sorun_id = isset($_GET["id"]) ? $_GET["id"] : null;

if ($sorun_id && is_numeric($sorun_id)) {
    $sorgu = "SELECT sorunlar.*, kullanicilar.kullanici_adi FROM sorunlar
              LEFT JOIN kullanicilar ON sorunlar.kullanici_id = kullanicilar.id
              WHERE sorun_id = '$sorun_id'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if ($sonuc) {
        $sorun = mysqli_fetch_assoc($sonuc);
    } else {
        echo "Hata: " . $sorgu . "<br>" . mysqli_error($baglanti);
    }
}

// Eğer form gönderildiyse mesajı kaydet
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mesaj = $_POST["mesaj"];
    $kullanici_id = $_SESSION["kullanici_id"];
    // Mesajı veritabanına ekleme işlemi
    $ekle_sorgusu = "INSERT INTO mesajlar (gonderen_id, alici_id, mesaj, mesaj_tarihi) 
                    VALUES ('$kullanici_id', '$sorun_id', '$mesaj', NOW())";

    $ekle_sonuc = mysqli_query($baglanti, $ekle_sorgusu);

    if ($ekle_sonuc) {
         
    } else {
        echo "Hata: " . $ekle_sorgusu . "<br>" . mysqli_error($baglanti);
    }
}

// Mesajları çekme işlemi
$sorgu_mesajlar = "SELECT mesajlar.*, kullanicilar.kullanici_adi FROM mesajlar
                   LEFT JOIN kullanicilar ON mesajlar.gonderen_id = kullanicilar.id
                   WHERE alici_id = '$sorun_id'
                   ORDER BY mesaj_tarihi DESC"; // Sorun ID'sine göre mesajları getir ve en yeni mesajı en üstte göster

$sonuc_mesajlar = mysqli_query($baglanti, $sorgu_mesajlar);
?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>
        <main>
            <div class="container mt-5">
                <div class="card mb-3">
                    <div class="card-header">
                        <p><strong><h4>Sorun Detayları</h4></strong></p> 
                    </div>
                    <div class="card-body">
                        <p class="text-start"><strong>Sorun Başlığı:</strong> <?php echo isset($sorun['sorun_baslik']) ? $sorun['sorun_baslik'] : ''; ?></p>
                        <p class="text-start"><strong>Açıklama:</strong> <?php echo isset($sorun['aciklama']) ? $sorun['aciklama'] : ''; ?></p>
                        <p class="text-start"><strong>Sorunu Yükleyen:</strong> <?php echo isset($sorun['kullanici_adi']) ? $sorun['kullanici_adi'] : ''; ?></p>
                        <p class="text-start"><strong>Sorun Oluşturma Tarihi:</strong> <?php echo isset($sorun['sorun_tarih']) ? $sorun['sorun_tarih'] : ''; ?></p>
                        <p class="text-start"><strong>Öncelik:</strong> <?php echo getSecenekler($sorun['secenekler']); ?></p>

                        <!-- Sorun çözüldüyse, işlevleri gizle -->
                        <?php if ($sorun['cozuldu_mu'] != 1) : ?>
                        <form action="sorunkapat.php?id=<?php echo $sorun_id; ?>" method="POST">
                            <button type="submit" class="btn btn-danger float-end">Sorunu Kapat</button>
                        </form>
                    </div>
                </div>           
                        <hr>
                        <form action="sorundetay.php?id=<?php echo $sorun_id; ?>" method="POST">
                            <div class="mb-3">
                                <label for="mesaj"><h4>Mesaj yaz:</h4></label>
                                <textarea class="form-control" id="mesaj" name="mesaj" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary float-end">Mesajı Gönder</button>
                        </form>
                        <?php endif; ?>
                        <!-- /Sorun çözülmediyse, işlevleri göster -->
<br><br>
                 

                <h4>Mesajlar</h4>
                <?php
                if ($sonuc_mesajlar && mysqli_num_rows($sonuc_mesajlar) > 0) {
                    while ($mesaj = mysqli_fetch_assoc($sonuc_mesajlar)) {
                        echo "<div class='card mb-3 text-start'>";
                        echo "<div class='card-header'><strong>Gönderen:</strong>" . $mesaj['kullanici_adi'] . "</div>";
                        echo "<div class='card-body'>";
                        echo "<p class='card-text'><strong></strong>" . $mesaj['mesaj'] . "</p>";      
                        echo "</div>";
                        echo "<div class='card-footer text-body-secondary'>";
                        echo "<p class='card-text'><strong>Gönderim Tarihi:</strong>" . $mesaj['mesaj_tarihi'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Mesaj bulunamadı.</p>";
                }
                ?>
            </div>
        </main>
    </div>
</body>
<?php
require_once("scripts.php");
?>

<?php
function getSecenekler($secenekler)
{
    $secenekText = "";
    if ($secenekler & 1) {
        $secenekText .= "Düşük ";
    }
    if ($secenekler & 2) {
        $secenekText .= "Orta ";
    }
    if ($secenekler & 4) {
        $secenekText .= "Yüksek ";
    }
    return $secenekText;
}
?>