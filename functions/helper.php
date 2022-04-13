<?php
//öncelikle ben bu sayfaya verileri gönderirken hem post hem get olarak gönderimiştim bu nedenle get olarak gönderdiğim değerin islem=get olup olmadığını kontrol etmem gerekli
// Bu get değerini kontrol edebilmek için bir function yazalım

function get($get)
{
    if (isset($_GET[$get])) { //GET metodu ile gönderilen değer set olup olmadığını kontrol ediyoruz (ki biz islem adında bir değişken yolladık ve değeri giriş)
        return trim($_GET[$get]); //true ise gönderile islem adındaki değeri döndür 
    } else {
        return false;
    }
};

// bu sayede bize get ile gönderilen islem değişkeni giris ise giriş işlemini gerçekleştirecek yok renk modu gibi bir değeri var ise renk modunu değiştirecek 

//aynı işlemi post için de yapalım

function post($post)
{
    if (isset($_POST[$post])) { //yani ben bu fonksiyona username adında bir değişken yollasam, post içinde username adlı bir değişken var ise yani set edilmişse bana bu değişkeni döndür. 
        return trim($_POST[$post]);
    } else {
        return false;
    }
};

//Ayrıca bir de sessiond eğerini alabilmeka dına yani set edildiyse session değerini edilmediyse false döndüren bir fonksiyon yazalım

function session($session)
{
    if (isset($_SESSION[$session])) {
        return trim($_SESSION[$session]);
    } else {
        return false;
    }
};


function getColor()
{
    if ($_COOKIE['color'] == 'bg-light') { //cookieyi set ederken setcookie() kullanılır get ederken $_COOKIE['cokie_name'] şekilnde alınır
        echo 'bg-light';
    } else {
        echo 'bg-dark'; //yani varsayılan olarak light mode yaptık 
    }
};
