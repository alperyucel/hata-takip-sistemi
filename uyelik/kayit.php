<?php

include("baglanti.php");

$username_err="";
$email_err="";
$parola_err="";
$parolatkr_err="";

if(isset($_POST["kaydet"]))
{
   //Kullanıcı adı doğrulama
   if(empty($_POST["kullaniciadi"]))
   {
    $username_err="Kullanıcı adı boş geçilemez.";
   }
   else if(strlen($_POST["kullaniciadi"])<6)
   {
    $username_err="Kullanıcı adı en az 6 karakter olmalıdır.";
   }
   else if (!preg_match('/^[a-z\d_]{5,20}$/i', $_POST["kullaniciadi"]))
    {
    $username_err="Kullanıcı adı büyük küçük harf ve rakamlardan oluşmalıdır.";
      }
    else{
     $username=$_POST["kullaniciadi"];
    }

 //email doğrulama
 if(empty($_POST["email"]))
 {
    $email_err="Email alanı boş geçilemez";
 }

 else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
  {
    $email_err = "Geçersiz email formatı.";
  }

 else{
    $email=$_POST["email"];
 }
  //parola doğrulama
if(empty($_POST["parola"]))

{
    $parola_err="Parola boş geçilemez.";
}
else{
    $parola=password_hash($_POST["parola"], PASSWORD_DEFAULT);
}

//parola tekrar

if (empty($_POST{"parolatkr"}))
{
   $parolatkr_err="Parola tekrar kısmı boş geçilemez.";
}
    else if($_POST["parola"]!=$_POST["parolatkr"])
{
   $parolatkr_err="Parolalar eşleşmiyor."; 
}
else {
    $parolatkr=$_POST["parolatkr"];
}




    
   if(isset($username)&& isset($email) && isset($parola))

   {


   $ekle="INSERT INTO kullanicilar (kullanici_adi, email, parola) VALUES ('$username','$email','$parola')";
   $calistirekle = mysqli_query($baglanti,$ekle);

   if ($calistirekle)  {
        session_start();
        $_SESSION['username'] = $username;
        header("location: giris.php");
        
   }
   else{
    echo '<div class="alert alert-danger" role="alert">
   Kayıt eklenemedi.
</div>';
   }
mysqli_close($baglanti);

}
}
?>

<!doctype html>
<html lang="tr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Üye Kayıt İşlemi</title>
  </head>
  <body>
     
  <div class="container p-5">
    <div class="card p-5">
             <form action="kayit.php" method="POST">

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Kullanıcı Adı</label>
        <input type="text" class="form-control 
        
        <?php
           if(!empty($username_err))
           {
            echo "is-invalid";
           }
        ?>
        
        " id="exampleInputEmail1" name="kullaniciadi">
         <div id="validationServerUsernameFeedback" class="invalid-feedback">
    <?php
    echo $username_err;
    ?>
      </div>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="text" class="form-control 
        
        <?php
            if(!empty($email_err))
        {
            echo "is-invalid";
        }
     ?>
        
        " id="exampleInputEmail1" name="email">
        <div id="validationServerUsernameFeedback" class="invalid-feedback">
    <?php
    echo $email_err;
    ?>
 </div> 
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Parola</label>
        <input type="password" class="form-control 
    <?php
      if(!empty($parola_err))
      {
        echo "is-invalid";
      }
    ?>
        
        
        " id="exampleInputPassword1" name="parola">
        <div id="validationServerUsernameFeedback" class="invalid-feedback">
    <?php
       echo $parola_err;
    ?>
      </div>
  </div>


  <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Parola Tekrar</label>
        <input type="password" class="form-control 
        
    <?php
       if(!empty($parolatkr_err))
       {
        echo "is-invalid";
       }
    ?>
        
        
        " id="exampleInputPassword1" name="parolatkr">
        <div id="validationServerUsernameFeedback" class="invalid-feedback">
<?php
    echo $parolatkr_err;
?>
      </div>
  </div>

   
  <button type="submit" name="kaydet" class="btn btn-primary">Kayıt Ol</button>
</form>
     </div>
  </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>