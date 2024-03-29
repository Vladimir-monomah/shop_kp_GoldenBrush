<?php
    defined('it') or die('Доступ запрещён!');
    include_once(__DIR__ ."/../function/localization.php");
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#blocktrackbar').trackbar({
        onMove : function() {
            document.getElementById("start-price").value = this.leftValue;
            document.getElementById("end-price").value = this.rightValue;	
        },
        width : 160,
        leftLimit : 100,
        leftValue : <?php
            if ((int)$_GET["start_price"] >= 100 && (int)$_GET["start_price"] <= 3000) {
                echo (int)$_GET["start_price"];
            } else {
                echo "100";
            }
        ?>,
        rightLimit : 3000,
        rightValue : <?php
            if ((int)$_GET["end_price"] >= 100 && (int)$_GET["end_price"] <= 3000) {
                echo (int)$_GET["end_price"];
            } else {
                echo "3000";
            }
        ?>,
        roundUp : 100
    });
});
</script>
<!--Основной блок параметров -->
<div id="block-parameter">
    <!--Основной блок поисков по параметрам. -->
    <p class="header-title"><?php echo localize_text('Поиск по параметрам', $_SESSION["lang"], $link); ?></p>
    <p class="title-filter"><?php echo localize_text('Стоимость', $_SESSION["lang"], $link); ?></p>
    <form method="GET" action="search_filter.php">
        <!--Блок выбора параметров -->
        <div id="block-input-price">
            <ul type="none" class="input-price">
                <li><p><?php echo localize_text('от', $_SESSION["lang"], $link); ?></p></li>
                <li><input type="text" id="start-price" name="start_price" value="100" /></li>
                <li><p><?php echo localize_text('до', $_SESSION["lang"], $link); ?></p></li>
                <li><input type="text" id="end-price" name="end_price" value="3000" /></li>
                <li><p><?php echo localize_text('руб', $_SESSION["lang"], $link); ?></p></li>
            </ul>
        </div>
        <!--Блок увеличения цены -->
        <div id="blocktrackbar"></div>
        <p class="title-filter"><?php echo localize_text('Производители', $_SESSION["lang"], $link); ?></p>
        <!--Разделение товаров по брендам -->
        <ul class="checkbox-brand" type="none">
            <?php
                $query = "SELECT * FROM category WHERE type='paper'";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $checked_brand = "";
                        if ($_GET["brand"] && in_array($row["id"], $_GET["brand"])) {
                            $checked_brand = "checked";
                        }
                        echo '
                            <li>
                                <input '.$checked_brand.' type="checkbox" name="brand[]" value="'.$row["id"].'" id="checkbrend'.$row["id"].'" />
                                <label for="checkbrend'.$row["id"].'">'.$row["brand"].'</label>
                            </li>
                        ';
                    }
                }
            ?>
            <?php
                $query = "SELECT * FROM category WHERE type='paints'";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $checked_brand = "";
                        if ($_GET["brand"] && in_array($row["id"], $_GET["brand"])) {
                            $checked_brand = "checked";
                        }
                        echo '
                            <li>
                                <input '.$checked_brand.' type="checkbox" name="brand[]" value="'.$row["id"].'" id="checkbrend'.$row["id"].'" />
                                <label for="checkbrend'.$row["id"].'">'.$row["brand"].'</label>
                            </li>
                        ';
                    }
                }
            ?>
            <?php
                $query = "SELECT * FROM category WHERE type='graphics'";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $checked_brand = "";
                        if ($_GET["brand"] && in_array($row["id"], $_GET["brand"])) {
                            $checked_brand = "checked";
                        }
                        echo '
                            <li>
                                <input '.$checked_brand.' type="checkbox" name="brand[]" value="'.$row["id"].'" id="checkbrend'.$row["id"].'" />
                                <label for="checkbrend'.$row["id"].'">'.$row["brand"].'</label>
                            </li>
                        ';
                    }
                }
            ?>
            <?php
                $query = "SELECT * FROM category WHERE type='other'";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $checked_brand = "";
                        if ($_GET["brand"] && in_array($row["id"], $_GET["brand"])) {
                            $checked_brand = "checked";
                        }
                        echo '
                            <li>
                                <input '.$checked_brand.' type="checkbox" name="brand[]" value="'.$row["id"].'" id="checkbrend'.$row["id"].'" />
                                <label for="checkbrend'.$row["id"].'">'.$row["brand"].'</label>
                            </li>
                        ';
                    }
                }
            ?>
        </ul>
        <center><input type="submit" name="submit" class="<?php echo localize_text('button-param-search', $_SESSION["lang"], $link); ?>" value=""/></center>
    </form>
</div>
