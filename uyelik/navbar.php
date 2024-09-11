<header>
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
      <a href="index.php" class="fs-4 text-decoration-none text-dark">Proje</a>

      <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="projeler.php">Projeler</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="sorunolustur.php">Sorun Oluştur</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="cozumlenmis_sorunlar.php">Çözümlenmiş Sorunlar</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="sorunlar.php">Aktif Sorunlar</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="kullanicilar.php">Kullanıcılar</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="cikis.php">Çıkış Yap</a>
      </nav>
      
                 <?php
                 $kullanici_adi = isset($_SESSION["kullanici_adi"]) ? $_SESSION["kullanici_adi"] : "";
                 if (!empty($kullanici_adi)) {
                     echo  "<span class='me-3 py-2' style='color: blue;'>(Kullanıcı: $kullanici_adi)</span>";
                 }
                 ?>
    </div>
</header>