<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    define('it', true);
    include("db_connect.php");
    include("../function/function.php");
    include("./auth_cookie.php");

    $id = clear_string($_POST["id"],$link);

    $user_uid = isset($_SESSION['id']) ? $_SESSION['id'] : $_SERVER['REMOTE_ADDR'];
    $result = mysqli_query($link, "SELECT * FROM cart WHERE cart_id = '$id' AND cart_ip = '$user_uid'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $new_count = (int)$_POST['count'];
        if ($new_count > 0) {
            $update = mysqli_query($link, "UPDATE cart SET cart_count='$new_count' WHERE cart_id='$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'");
            echo $new_count;
        } else {
            echo $row["cart_count"];
        }
    }
}
?>
