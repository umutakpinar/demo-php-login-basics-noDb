<?php
session_start();
include("./functions/helper.php");

//Bu dizide ise kullanıcı bilgilerini tutalım normalde veritabanından çekiyoruz elbette
$users = [
    "umutakpinar" => [
        "password" => "123456",
        "email" => "umtakpnr@mail.com"
    ],
    "preloader" => [
        "password" => "123456",
        "email" => "prelaoder@mail.com"
    ],
];

//Şimdi burada get ile gönderilen islem değişkeninin değeri giris ise bunları yapsın diyelim 
if (get('islem') == 'giris') {
    $_SESSION['username'] = post('username'); //hatalı ya da boşsa bile bunları alıyoruz. Kullnaıcı yeniden girmekle uğraşmasın diye form inputlarına value oalrak bunları göndereceğiz.
    $_SESSION['password'] = post('password');
    //bu durumda giriş işlemi yapılmaya çalıştığını anladık böylece giriş için gerekli olan bilgileri post ile alabiliriz
    if (!post('username')) { //Eğer kullanıcı adı girilmemişse kullanıcıyı uyarmak için bunu ekranda göstermeliyiz. E tamam da nasıl yapıcaz?
        // Bunun için sessionda hata mesajı adında bir değişken tutabiliriz. Daha sonra bu hata mesajını login.php'de ekrana bastırırız.
        $_SESSION['error'] = 'Kullanıcı adınızı girmelisiniz';
        header('Location:login.php'); //Hata var ise tekrar login.php'ye yönelndirmeliyiz!
        exit();
    } elseif (!post('password')) { //Eğer şifre girilmemişse kullanıcıyı uyarmak için bunu ekranda göstermeliyiz. E tamam da nasıl yapıcaz?
        $_SESSION['error'] = 'Şifrenizi girmelisiniz';
        header('Location:login.php'); //Hata var ise tekrar login.php'ye yönelndirmeliyiz!
        exit(); //burada kodların çalışmasını durduruyoruz
    } else {
        if (array_key_exists(post('username'), $users)) {
            if ($users[post('username')]["password"] == post('password')) {
                $_SESSION['login'] = true;
                $_SESSION["logged_user"] = post('username');
                $_SESSION["logged_email"] = $users[post('username')]['email'];
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error'] = 'Hatalı kullanıcı adı ya da şifre';
                header("Location:login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = 'Böyle bir kullanıcı yok. Ama olabilir de?';
            header("Location:login.php");
            exit();
        }
    }
};

if (get('islem') == 'hakkimda') {
    $hakkimda = post('hakkimda');
    $sonuc = file_put_contents("db/" . session('username') . ".txt", htmlspecialchars($hakkimda));
    if ($sonuc) {
        header("Location: index.php?islem=basarili");
    } else {
        header("Location: index.php?islem=basarisiz");
    }
};

if (get('islem') == 'cikis') {
    session_destroy();
    session_start();
    $_SESSION['error'] = 'Çıkış yapıldı!';
    header('Location:login.php');
}

if (get('islem') == 'renk') {
    setcookie('color', get('color'), time() + (86400 * 360)); //color adında bir cookie oluşturduk ve değerini get değerindeki color değişkeninden aldık ayrıca 86400 saniye yani bir gün x 360 edik yani bu bilgiler 360 gün boyunca cookielerde tutulacak
    header('Location:' . $_SERVER['HTTP_REFERER'] ?? 'index.php'); //http-referer bize o kullanıcının hangi sayfadan geldiğini bulup o sayfay yönelndirir. Eğer bu varsa buraya yönlendirsin yoksa index.php'ye yönlendirsin
    //NOT: cookie bilgileri tarayıcıda saklanır. Serverda değil!
    //$_SERVER serverın bilgilerini tutar incelemk için print_r ile ekrana yazdırıp tuutuğu bilgilerin ne işe ayradığına internetten bakabilirsin.
    // Ayrıca cookiler chrome developer tools altında cookies kısmında tutulur.
}
