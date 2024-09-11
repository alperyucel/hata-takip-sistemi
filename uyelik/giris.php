<?php

include("baglanti.php");

$username_err="";
$parola_err="";
 



if(isset($_POST["giris"]))
{
   //Kullanıcı adı doğrulama
   if(empty($_POST["kullaniciadi"]))
   {
    $username_err="Kullanıcı adı boş geçilemez.";
   }
    
    else{
     $username=$_POST["kullaniciadi"];
    }

  
  //parola doğrulama
if(empty($_POST["parola"]))

{
    $parola_err="Parola boş geçilemez.";
}
else{
    $parola=$_POST["parola"];
}

 



    
   if(isset($username) && isset($parola))

   {
$secim ="SELECT * FROM kullanicilar WHERE kullanici_adi = '$username'";
$calistir=mysqli_query($baglanti,$secim);
$kayitsayisi = mysqli_num_rows($calistir);  //ya sıfır ya bir

if($kayitsayisi>0)
{
    $ilgilikayit = mysqli_fetch_assoc($calistir);
    $hashlisifre=$ilgilikayit["parola"];

    if(password_verify($parola,$hashlisifre))
    {
        session_start();
        $_SESSION["kullanici_adi"]=$ilgilikayit["kullanici_adi"];
        $_SESSION["email"]=$ilgilikayit["email"];
        $_SESSION['kullanici_id'] = $ilgilikayit["id"];
        header("location:index.php");
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
    Parola yanlış.
</div>';
    }
}
else
{
    echo '<div class="alert alert-danger" role="alert">
    Kullanıcı adı yanlış.
</div>';
}

session_start();

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

    <title>Üye Giriş İşlemi</title>
  </head>
  <body>
     
  <div class="container p-5">
    <div class="card p-5">
             <form action="giris.php" method="POST">

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


   

   
  <button type="submit" name="giris" class="btn btn-primary">Giriş Yap</button>
  <a href="kayit.php" class="btn btn-success">Kaydol</a>
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