<?php
require_once("process.php");
require_once("header.php");
?>

<body>
    <div class="container py-3">
        <?php
        require_once("navbar.php");
        ?>

        <main>
            <div class="container">
                <h3>Yeni Kullanıcı Ekle</h3>
                <form action="process.php" method="POST">
        <div class="card p-3">
                    <h5>Kullanıcı Detayları</h5>
                    <?php
                    include("baglanti.php");
                    
                     
                    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                        // Boş bir form göster
                        ?>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="adsoyad" class="form-label">Ad Soyad</label>
                                    <input type="text" class="form-control" name="adsoyad" aria-describedby="adsoyadHelp">
                                </div>
                            </div>
                            <div class="col">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email"  aria-describedby="emailHelp">
                                    </div>
                                </div>                     
                        </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="telefonno" class="form-label">Telefon No</label>
                                        <input type="text" class="form-control" name="telefonno"  aria-describedby="telefonnoHelp">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="dogumyili" class="form-label">Doğum Yılı</label>
                                        <input type="text" class="form-control" name="dogumyili"  aria-describedby="dogumyiliHelp">
                                    </div>
                                </div>
                            </div>

                            <h5>Hesap Detayları</h5>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="kullaniciadi" class="form-label">Kullanıcı Adı</label>
                                        <input type="text" class="form-control" name="kullaniciadi"  aria-describedby="kullaniciadiHelp">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="sifre" class="form-label">Şifre</label>
                                        <input type="text" class="form-control" name="parola" aria-describedby="sifreHelp">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="btn-container">
                                    <button type="submit" name="kullaniciekle" class="btn btn-primary">Kaydet</button>
                                </div>
                            </div>
                        </div>
        </div>
                        <?php
                    } 
                        // Eğer URL'de id parametresi varsa ve geçerli bir kullanıcı ise
                        else {
                             
                            $kullanici_id = $_GET['id'];
                            $sorgu = "SELECT * FROM kullanicilar WHERE id = '$kullanici_id'";
                            $sonuc = mysqli_query($baglanti, $sorgu);
    
                            if (mysqli_num_rows($sonuc) > 0) {
                                // Düzenleme modunda
                                $row = mysqli_fetch_assoc($sonuc);
                            ?>
         
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="adsoyad" class="form-label">Ad Soyad</label>
                                    <input type="text" class="form-control" name="adsoyad" value="<?php echo $row['adsoyad']; ?>" aria-describedby="adsoyadHelp">
                                </div>
                            </div>
                            <div class="col">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" value="<?php echo $row['email']; ?>" aria-describedby="emailHelp">
                                    </div>
                                </div>                     
                        </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="telefonno" class="form-label">Telefon No</label>
                                        <input type="text" class="form-control" name="telefonno" value="<?php echo $row['telefonno']; ?>" aria-describedby="telefonnoHelp">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="dogumyili" class="form-label">Doğum Yılı</label>
                                        <input type="text" class="form-control" name="dogumyili" value="<?php echo $row['dogumyili']; ?>" aria-describedby="dogumyiliHelp">
                                    </div>
                                </div>
                            </div>

                            <h5>Hesap Detayları</h5>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="kullaniciadi" class="form-label">Kullanıcı Adı</label>
                                        <input type="text" class="form-control" name="kullaniciadi" value="<?php echo $row['kullanici_adi']; ?>" aria-describedby="kullaniciadiHelp">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="sifre" class="form-label">Şifre</label>
                                        <input type="text" class="form-control" name="parola" value="<?php echo $row['parola']; ?>" aria-describedby="sifreHelp">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <input type="hidden" name="userId" value="<?php echo $row['id']; ?>">
                                <div class="btn-container">
                            <?php
                                if (isset($_GET['id'])) {
                            ?>
                                    <button type="submit" name="kullaniciGuncelle" class="btn btn-primary">Kaydet</button>
                            <?php
                                    } else {
                            ?>
                                        <button type="submit" name="kullaniciekle" class="btn btn-primary">Kaydet</button>
                            <?php
                                    }
                            ?>
                                </div>
                            </div>
                        </div>

                    <?php
                        } else {
                            echo "Kullanıcı bulunamadı.";
                        }
                    }

                    mysqli_close($baglanti);
                    ?>
                    
                     
                </form>
            </div>
        </main>
    </div>
</body>

<?php
require_once("scripts.php");
?>