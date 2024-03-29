<?php
    defined('it') or die('Доступ запрещён!');
?>
<div id="block-random-tovar">
    <ul type="none">
        <?php
            $query_random = mysqli_query($link, "SELECT DISTINCT * FROM table_products WHERE visible='1' ORDER by RAND() LIMIT 4");

            if (mysqli_num_rows($query_random) > 0) {
                while ($res_query = mysqli_fetch_array($query_random)) {
                    // Выбор отзывов
                    $query_reviews = mysqli_query($link, "SELECT * FROM table_reviews WHERE products_id = {$res_query["products_id"]} AND moderat='1'");
                    $count_reviews = mysqli_num_rows($query_reviews);

                    if (strlen($res_query["image"]) > 0 && file_exists("./uploads_images/".$res_query["image"])) {
                        $img_path = './uploads_images/'.$res_query["image"];
                        $max_width = 120;
                        $max_height = 120;
                        list($width, $height) = getimagesize($img_path);
                        $ratioh = $max_height/$height;
                        $ratiow = $max_width/$width;
                        $ratio = min($ratioh, $ratiow);

                        $width = intval($ratio*$width);
                        $height = intval($ratio*$height);
                    } else {
                        $img_path = "/images/no-image-65.png";
                        $width = 65;
                        $height = 118;
                    }

                    echo '
                        <li>
                            <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
                            <a class="random-title" href="view_content.php?id='.$res_query["products_id"].'">'.localize_text($res_query["title"], $_SESSION["lang"], $link).'</a>
                            <p class="random-reviews">'.localize_text('Отзывы', $_SESSION["lang"], $link).' '.$count_reviews.'</p>
                            <p class="random-price">'.group_numerals($res_query["price"]).'</p>
                            <a class="random-add-cart" tid="'.$res_query["products_id"].'"></a>
                        </li>
                    ';
                }
            }
        ?>
    </ul>
</div>
