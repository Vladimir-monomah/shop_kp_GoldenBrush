<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    define('it', true);
    include("db_connect.php");
    include("../function/function.php");
    include("../function/localization.php");
    include("../include/auth_cookie.php");

    session_start();
    $user_uid = isset($_SESSION['id']) ? $_SESSION['id'] : $_SERVER['REMOTE_ADDR'];
    $result = mysqli_query($link, "SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$user_uid}' AND table_products.products_id = cart.cart_id_products");
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        $count = 0;
        $int = 0;

        do
        {
            $count = $count + $row["cart_count"];    
            $int = $int + ($row["price"] * $row["cart_count"]); 
        }
        while ($row = mysqli_fetch_array($result));

        if ($count == 1 or $count == 21 or $count == 31 or $count == 41 or $count == 51 or $count == 61 or $count == 71 or $count == 81)
        {
            $str = localize_text('товар', $_SESSION["lang"], $link);
        }
        if ($count == 2 or $count == 3 or $count == 4 or $count == 22 or $count == 23 or $count == 24 or $count == 32 or $count == 33 or $count == 34 or $count == 42 or $count == 43 or $count == 44 or $count == 52 or $count == 53 or $count == 54 or $count == 62 or $count == 63 or $count == 64)
        {
            $str = localize_text('товара', $_SESSION["lang"], $link);
        }
        if ($count == 5 or $count == 6 or $count == 7 or $count == 8 or $count == 9 or $count == 10 or $count == 11 or $count == 12 or $count == 13 or $count == 14 or $count == 15 or $count == 16 or $count == 17 or $count == 18 or $count == 19 or $count == 20 or $count == 25 or $count == 26 or $count == 27 or $count == 28 or $count == 29 or $count == 30 or $count == 35 or $count == 36 or $count == 37 or $count == 38 or $count == 39 or $count == 40 or $count == 45 or $count == 46 or $count == 47 or $count == 48 or $count == 49 or $count == 50 or $count == 55 or $count == 56 or $count == 57 or $count == 58 or $count == 59 or $count == 60 or $count == 65)
        {
            $str = localize_text('товаров', $_SESSION["lang"], $link);
        }

        if ($count > 81)
        {
            $str = localize_text('тов.', $_SESSION["lang"], $link);
        }

        echo '<span>'.$count.$str.'</span> '.localize_text('на сумму', $_SESSION["lang"], $link).' <span>'.group_numerals($int).'</span> '.localize_text('руб', $_SESSION["lang"], $link).'';
    }
    else
    {
        echo localize_text('Корзина пуста', $_SESSION["lang"], $link);
    }
}
?>