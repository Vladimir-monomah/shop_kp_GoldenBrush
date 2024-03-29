<?php
defined('it') or die('Доступ запрещён!');
session_start();

if ($_SESSION['auth'] != 'yes_auth' && $_COOKIE["rememberme"]) {
    $str = $_COOKIE["rememberme"];
  
    // Вся длина строки
    $all_len = strlen($str);
    // Длина логина
    $login_len = strpos($str, '+'); 
    // Обрезаем строку до Плюса и получаем Логин
    $login = clear_string(substr($str, 0, $login_len),$link);
  
    // Получаем пароль 
    $pass = clear_string(substr($str, $login_len + 1, $all_len),$link);

    $result = mysqli_query($link, "SELECT * FROM reg_user WHERE (login = '$login' or email = '$login') AND pass = '$pass'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $_SESSION['id'] = $row["id"];
        $_SESSION['auth'] = 'yes_auth'; 
        $_SESSION['auth_pass'] = $row["pass"];
        $_SESSION['auth_login'] = $row["login"];
        $_SESSION['auth_surname'] = $row["surname"];
        $_SESSION['auth_name'] = $row["name"];
        $_SESSION['auth_patronymic'] = $row["patronymic"];
        $_SESSION['auth_address'] = $row["address"];
        $_SESSION['auth_phone'] = $row["phone"];
        $_SESSION['auth_email'] = $row["email"];
    }
} else if (!isset($_SESSION['id']) && isset($_COOKIE['user_uid'])) {
    $_SESSION['id'] = $_COOKIE['user_uid'];
} else if (!isset($_SESSION['id'])) {
    $user_uid = uniqid('', true);
    setcookie('user_uid', $user_uid, time()+3600*24*31, "/");
    $_SESSION['id'] = $user_uid;
}
?>
