<?php

session_start();
include("./functions/helper.php");
//başlangıçta ilk oalrak index.php açılacak ya bu endenle session oluşturduk.
/*Şimdi bu index.php içerisinde ise bizim giriş yaptıktan sonra gözükecek olan sayfamız bulunuyor.
Ancak biz giriş yapmayan insanların bu sayfayı görmesini istemeyiz. Bu nedenle serverda tutulan session global değişkenine
bir login değişkeni atayacağız. Eğer bu login değeri false ise ya da logind eğeri set edilmediyse
bu durumda bizi index.php'ye değil login.php'ye yönlendirmeli. Bu nedenle bu kontrolü index.php içerisinde yapıyoruz.
E peki bizi login.php'ye gönderecek kodu aşağıda yazalım. Daha sonra ne olacak. Login.php'ye yönelndirince burada da session start
diyerek sessionoluşturuyoruz. Ardından login.php ieçrisinde bulunan form verilerini islem.php'ye yönlendireceğiz. Eğer işlem.php
kendisine gönderilen giriş bilgilerini doğrularsa session globali içerisindeki logind eğişkenini true olarak ayarlıyoruz.
doğru değilse false olarak ayarlıyoruz. Her iki durumda da kişiyi login.php'ye geri yönlendiriyoruz. Login.php tekrar 
session global değişkeni içerisindeki login değerini kontrol ediyor. Ve true ise index.php'yi bize gösteriyor. Ancak false ya da set edilmediyse
bizi tekrar login.php'ye yönlendiriyor. 
*/


if ($_SESSION["login"] == false) {
    //session global değişkeni içerisindeki login değişkeni false ise ya da login set edilmediyse
    header("Location: login.php"); //login sayfasına yönlendir bunları da islem.php içerisinde kontrol et
};

if (file_exists("db/" . session('username') . ".txt")) {
    $hakkimda =  trim(htmlspecialchars_decode(file_get_contents("db/" . session('username') . ".txt"))); //Varsa bu sayfayı ekranda göstersin
} else {
    $hakkimda = ""; // Eğer bu dosya yoksa boş bir $hakkimda değişkeni oluştursun
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Anasayfa</title>
    <style>
        body.bg-dark {
            background: #181818 !important;
        }

        button {
            position: absolute;
            bottom: 8px;
            right: 8px
        }

        form {
            position: relative;
        }
    </style>
</head>

<body class="<?= getColor(); ?>">
    <div class="d-flex align-items-center justify-content-center p-4"><img height="" src="kodl.png" alt=""></div>
    <div class="container d-flex align-items-center justify-content-center">
        <div class="card <?= getColor(); ?>" style="width: 18rem;">
            <div class="card-header bg-primary">
                Profilim
            </div>
            <div class="card-body">
                <h5 class="card-title text-warning"> <?= $_SESSION['logged_user'] ?> </h5>
                <h6 class="card-subtitle mb-2 text-muted"> <?= $_SESSION['logged_email'] ?> </h6>


                <?php
                if (!isset($_GET['islem'])) {
                    echo '<div class="alert alert-info">Hosgeldiniz ' . session('username') . '</div>';
                } elseif (get('islem') == 'basarili') {
                    echo '<div class="alert alert-success">İslem basarili!</div>';
                } elseif (get('islem' == 'basarisiz')) {
                    echo '<div class="alert alert-danger">İslem basarisiz!</div>';
                }
                ?>

                <form action="islem.php?islem=hakkimda" method="post">
                    <textarea class="form-control <?= getColor(); ?> text-primary" name="hakkimda" id="" cols="30" rows="10">
                        <?= $hakkimda ?>
                        </textarea>
                    <button class="btn btn-sm btn-primary" type="submit">Kaydet</button>
                </form>
                <a href="islem.php?islem=cikis" class="btn btn-success btn-sm mt-2 w-100">Oturumu Kapat</a><br>

            </div>
            <div class="card-footer bg-info d-flex align-items-center justify-content-between">
                <a href="islem.php?islem=renk&color=bg-light" class="btn btn-sm btn-light">Light Mod</a>
                <a href="islem.php?islem=renk&color=bg-dark" class="btn btn-sm btn-dark">Dark Mod</a>
            </div>
        </div>
    </div>
</body>

</html>