<?php
require_once("header.php");
require_once("baglanti.php");

session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0;

?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>
        <main>
            <div class="container mt-5">               
                <h3>Sorunlar</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Sorun Başlığı</th>
                            <th scope="col">Açıklama</th>
                            <th scope="col">Yükleyen</th>
                            <th scope="col">Oluşturma Tarihi</th>
                            <th scope="col">Öncelik</th>  
                            <td>
                                <a href="sorunolustur.php" type="button" class="btn btn-success btn-sm">Yeni Sorun Ekle</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sorgu = "SELECT sorunlar.*, kullanicilar.kullanici_adi FROM sorunlar
                                  LEFT JOIN kullanicilar ON sorunlar.kullanici_id = kullanicilar.id
                                  WHERE sorunlar.cozuldu_mu = 0"; // Sadece çözülmemiş (aktif) sorunları getir

                        $sonuc = mysqli_query($baglanti, $sorgu);

                        if ($sonuc) {
                            while ($row = mysqli_fetch_assoc($sonuc)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['sorun_id'] . "</th>";
                                echo "<td>" . $row['sorun_baslik'] . "</td>";
                                echo "<td>" . $row['aciklama'] . "</td>";
                                echo "<td>" . $row['kullanici_adi'] . "</td>";
                                echo "<td>" . $row['sorun_tarih'] . "</td>";
                                echo "<td>" . getSecenekler($row['secenekler']) . "</td>";  
                                echo "<td>
                                        <a href='sorundetay.php?id=" . $row['sorun_id'] . "&edit=true' class='btn btn-primary btn-sm'>Düzenle</a> 
                                        <a href='sorunsil.php?sil=" . $row['sorun_id'] . "' class='btn btn-danger btn-sm'>Sil</a>                          
                                      </td>";
                                      
                                echo "</tr>";
                            }
                        } else {
                            echo "Hata: " . $sorgu . "<br>" . mysqli_error($baglanti);
                        }

                        mysqli_close($baglanti);
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

<?php 
require_once("scripts.php"); 

function getSecenekler($secenekler) {
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