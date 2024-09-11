<?php
require_once("header.php");
require_once("baglanti.php");

session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0; // Oturum açan kullanıcının id'sini al
?>
<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>
        <main>
            <div class="container mt-5">
                 
                <h3>Projeler</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Proje Adı</th>
                            <th scope="col">Açıklama</th>
                            <th scope="col">Yükleyen</th>
                            <th scope="col">Yükleme Tarihi</th>
                            <td>
                                <a href="projeyukle.php" type="button" class="btn btn-success btn-sm">Yeni Proje Ekle</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        // Projeleri ve ilgili kullanıcı adlarını veritabanından çekme
                        $sorgu = "SELECT * FROM projeler
                                  left JOIN kullanicilar ON projeler.kullanici_id = id";
                        $sonuc = mysqli_query($baglanti, $sorgu);

                        if ($sonuc) {
                            while ($row = mysqli_fetch_assoc($sonuc)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['proje_id'] . "</th>";
                                echo "<td>" . $row['proje_adi'] . "</td>";
                                echo "<td>" . $row['aciklama'] . "</td>";
                                echo "<td>" . $row['kullanici_adi'] . "</td>";
                                echo "<td>" . $row['proje_tarihi'] . "</td>";
                                echo "<td>
                                        <a href='projeyukle.php?id=" . $row['proje_id'] . "' class='btn btn-primary btn-sm'>Düzenle</a> 
                                        <a href='sil.php?sil=" . $row['proje_id'] . "' class='btn btn-danger btn-sm'>Sil</a>                                
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
?>