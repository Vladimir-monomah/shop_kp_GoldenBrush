<?php
define('it', true);	
   include("include/db_connect.php");
   include("function/function.php");
   session_start();
   include("include/auth_cookie.php");
   include("function/localization.php");
 
 
    $go = clear_string($_GET["go"],$link);
    
    switch ($go) {

	    case "news":     
	    $query_aystopper= " WHERE visible = '1' AND new = '1'";
        $name_aystopper = "Новинки товаров";
	    break;

	    case "leaders":
	    $query_aystopper= " WHERE visible = '1' AND leader = '1'";
        $name_aystopper = "Лидеры продаж";
	    break;

	    case "sale":
	    $query_aystopper= " WHERE visible = '1' AND sale = '1'";
        $name_aystopper = "Распродажа товаров";
	    break;
        
        
	    default:
        $query_aystopper = "";  
	    break;
} 
 
  
$sorting = $_GET["sort"];   
 
switch ($sorting)
{
    case 'price-asc';
    $sorting = 'price ASC';
    $sort_name = 'От дешевых к дорогим';
    break;

    case 'price-desc';
    $sorting = 'price DESC';
    $sort_name = 'От дорогих к дешевым';
    break;
    
    case 'popular';
    $sorting = 'count DESC';
    $sort_name = 'Популярное';
    break;
    
    case 'news';
    $sorting = 'datetime DESC';
    $sort_name = 'Новинки';
    break;
    
    case 'brand';
    $sorting = 'brand';
    $sort_name = 'Новинки';
    break;
    
    default:
    $sorting = 'products_id DESC';
    $sort_name = 'Нет сортировки';
    break;                           
} 
   
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    
    <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script> 
    <script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script> 
    <script type="text/javascript" src="/js/shop-script.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript" src="/js/TextChange.js"></script>
    
    <link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox.css" />
    <script type="text/javascript" src="/fancybox/jquery.fancybox.js"></script>
    
	<title><?php echo localize_text('Золотая кисть', $_SESSION["lang"], $link); ?></title>
</head>
<body>
<div id="block-body">
<?php	
    include("include/block-header.php");    
?>
<div class="right-block-menu-container">
	<input type="checkbox" name="right-block-menu" id="toggle-right-block" class="toggle-right-block">
	<label for="toggle-right-block" class="toggle-right-block header-title">Меню</label>
	
		<div id="block-left" class="block-left">
	<?php	
		include("include/block-category.php");
		include("include/block-parameter.php");
	?>
	</div>
</div>
<div id="block-content">

<?php
	if ($query_aystopper != "")
    {
    
	$num = 6; // Здесь указываем сколько хотим выводить товаров.
    $page = (int)$_GET['page'];              
    
    $count_query = "SELECT COUNT(*) FROM table_products $query_aystopper";
    $count_result = mysqli_query($link, $count_query);
    $temp = mysqli_fetch_array($count_result);

	If ($temp[0] > 0)
	{  
	$tempcount = $temp[0];

	// Находим общее число страниц
	$total = (($tempcount - 1) / $num) + 1;
	$total =  intval($total);

	$page = intval($page);

	if(empty($page) or $page < 0) $page = 1;  
       
	if($page > $total) $page = $total;
	 
	// Вычисляем начиная с какого номера
    // следует выводить товары 
	$start = $page * $num - $num;

	$qury_start_num = " LIMIT $start, $num"; 
	}



If ($temp[0] > 0)
	{ 

?>


<div id="block-sorting">
<p id="nav-breadcrumbs"><a href="index.php" >Главная страница</a> \ <span><?php echo $name_aystopper; ?></span></p>
<ul id="options-list" type="none">
<li>Вид: </li>
<li><img id="style-grid" src="/images/icon-grid.png" /></li>
<li><img id="style-list" src="/images/icon-list.png" /></li>
<li>Сортировать:</li>
<li><a id="select-sort"><?php echo $sort_name; ?></a>
<ul id="sorting-list" type="none">
<li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=price-asc" >От дешевых к дорогим</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=price-desc" >От дорогих к дешевым</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=popular" >Популярное</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=news" >Новинки</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=brand" >От А до Я</a></li>
</ul>
</li>
</ul>
</div>

<ul id="block-tovar-grid" type="none">
<?php
	
    $result = mysqli_query($link, "SELECT * FROM table_products $query_aystopper ORDER BY $sorting $qury_start_num");

if (mysqli_num_rows($result) > 0)
{
 $row = mysqli_fetch_array($result); 
 
 do
 {

if  ($row["image"] != "" && file_exists("./uploads_images/".$row["image"]))
{
$img_path = './uploads_images/'.$row["image"];
$max_width = 200; 
$max_height = 200; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "/images/no-image.png";
$width = 110;
$height = 200;
} 
  
   // Количество отзывов 
   $query_reviews = mysqli_query($link, "SELECT * FROM table_reviews WHERE products_id = '{$row["products_id"]}' AND moderat='1'");
   $count_reviews = mysqli_num_rows($query_reviews);
   
  
  echo '
  
  <li>
  <div class="block-images-grid">
  <a class="product-image" href="'.$img_path.'"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></a>
  </div>
  <p class="style-title-grid" ><a href="view_content.php?id='.$row["products_id"].'" >'.$row["title"].'</a></p>
  <a class="add-cart-style-grid" tid="'.$row["products_id"].'"></a>
  <p class="style-price-grid" ><strong>'.group_numerals( $row['price']).'</strong> руб.</p>
  <div class="mini-features" >
  '.$row["mini_features"].'
  </div>
  </li>
  
  ';
  
    
 }
    while ($row = mysqli_fetch_array($result));
}    


?>
</ul>


<ul id="block-tovar-list" type="none">

<?php
	
    $query = "SELECT * FROM table_products $query_aystopper ORDER BY $sorting $qury_start_num";
    $result = mysqli_query($link, $query);
      

if (mysqli_num_rows($result) > 0)
{
 $row = mysqli_fetch_array($result); 
 
 do
 {

if  ($row["image"] != "" && file_exists("./uploads_images/".$row["image"]))
{
$img_path = './uploads_images/'.$row["image"];
$max_width = 150; 
$max_height = 150; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "/images/noimages80x70.png";
$width = 80;
$height = 70;
} 
  
  // Количество отзывов 
  $query = "SELECT * FROM table_reviews WHERE products_id = '{$row["products_id"]}' AND moderat='1'";
  $query_reviews = mysqli_query($link, $query);
  $count_reviews = mysqli_num_rows($query_reviews);
  
  
  echo '
  
  <li>
  <div class="block-images-list" >
  <a class="product-image" href="'.$img_path.'"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/></a>
  </div>
  
  <p class="style-title-list" ><a href="view_content.php?id='.$row["products_id"].'" >'.$row["title"].'</a></p>
  
  <a class="add-cart-style-list" tid="'.$row["products_id"].'"></a>
  <p class="style-price-list" ><strong>'.group_numerals( $row['price']).'</strong> руб.</p>
  <div class="style-text-list" >
  '.$row["mini_description"].'
  </div>
  </li>
  
  ';
  
    
 }
    while ($row = mysqli_fetch_array($result));
}    

echo '</ul>';

}else
{
    echo '<p>Товаров нет!</p>';
}

    }else
    {
        echo '<p>Данная категория не найдена!</p>';
    }


if ($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="view_aystopper.php?go='.$go.'&page='.($page - 1).'">&lt;</a></li>';}
if ($page != $total) $pstr_next = '<li><a class="pstr-next" href="view_aystopper.php?go='.$go.'&page='.($page + 1).'">&gt;</a></li>';


// Формируем ссылки со страницами
if($page - 5 > 0) $page5left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 5).'">'.($page - 5).'</a></li>';
if($page - 4 > 0) $page4left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 1).'">'.($page - 1).'</a></li>';

if($page + 5 <= $total) $page5right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 5).'">'.($page + 5).'</a></li>';
if($page + 4 <= $total) $page4right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 1).'">'.($page + 1).'</a></li>';


if ($page+5 < $total)
{
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_aystopper.php?go='.$go.'&page='.$total.'">'.$total.'</a></li>';
}else
{
    $strtotal = ""; 
}

if ($total > 1)
{
    echo '
    <div class="pstrnav">
    <ul type="none">
    ';
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='view_aystopper.php?go=".$go."&page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '
    </ul>
    </div>
    ';
}


?>



</div>

<?php	
    include("include/block-random.php");
    include("include/block-footer.php");    
?>
</div>

</body>
</html>