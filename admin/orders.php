<?php
session_start();
if ($_SESSION['auth_admin'] != "yes_auth")
{
    header("Location: login.php");
    die();
}
	define('it', true);
       
       if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }

  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='orders.php' >Заказы</a>";
  
  include("include/db_connect.php");
  include("include/function.php");
   $sort = $_GET["sort"];
   switch ($sort) {

	    case 'all-orders':

	    $sort = "order_id DESC";
        $sort_name = 'От А до Я';

	    break;

	    case 'confirmed':

	    $sort = "order_confirmed = 'yes' DESC";
        $sort_name = 'Обработаные';

	    break;

	    case 'no-confirmed':

	    $sort = "order_confirmed = 'no' DESC";
        $sort_name = 'Не обработаные';

	    break;
        
	    default:
        
        $sort = "order_id DESC";
        $sort_name = 'От А до Я';
        
	    break;

	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
    <script type="text/javascript" src="js/script.js"></script> 
    <script type="text/javascript" src="jquery_confirm/jquery_confirm.js"></script> 
    
	<title>Панель для Администратора - Заказы</title>
</head>
<body>
<!--Основной блок тела сайта -->
<div id="block-body">
<?php
	include("include/block-header.php");
    
 $all_count = mysqli_query($link,"SELECT * FROM orders");
 $all_count_result = mysqli_num_rows($all_count);

 $buy_count = mysqli_query($link,"SELECT * FROM orders WHERE order_confirmed = 'yes'");
 $buy_count_result = mysqli_num_rows($buy_count);

 $no_buy_count = mysqli_query($link,"SELECT * FROM orders WHERE order_confirmed = 'no'");
 $no_buy_count_result = mysqli_num_rows($no_buy_count); 
 
echo "
<!--Основной блок контента -->
<div id=\"block-content\">
<!--Основной блок сортировки -->
<div id=\"block-parameters\">
<ul id=\"options-list\">
<li>Сортировать</li>
<li><a id=\"select-links\" href=\"#\">$sort_name</a>
<ul id=\"list-links-sort\">
<li><a href=\"orders.php?sort=all-orders\">От А до Я</a></li>
<li><a href=\"orders.php?sort=confirmed\">Обработаные</a></li>
<li><a href=\"orders.php?sort=no-confirmed\">Не обработаные</a></li>

</ul>
</li>
</ul>
</div>
<div id=\"block-info\">
<ul id=\"review-info-count\">
<li>Всего заказов - <strong>$all_count_result</strong></li>
<li>Обработаных - <strong>$buy_count_result</strong></li>
<li>Не обработаных - <strong>$no_buy_count_result</strong></li>

</ul>
</div>
";
	$result = mysqli_query($link,"SELECT * FROM orders ORDER BY $sort");
 
 If (mysqli_num_rows($result) > 0)
{
$row = mysqli_fetch_array($result);
do
{
if ($row["order_confirmed"] == 'yes')
{
    $status = '<span class="green">Обработан</span>';
} else
{
    $status = '<span class="red">Не обработан</span>';    
}
  
 echo '
 <div class="block-order">
 
  <p class="order-datetime" >'.$row["order_datetime"].'</p>
  <p class="order-number" >Заказ № '.$row["order_id"].' - '.$status.'</p>
  <p class="order-link" ><a class="green" href="view_order.php?id='.$row["order_id"].'" >Подробнее</a></p>
 </div>
 ';   
    
} while ($row = mysqli_fetch_array($result));
}
?>
</div>
</div>
</body>
</html>