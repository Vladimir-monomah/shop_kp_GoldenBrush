<?php
 require_once 'mysql.php'; function online(){ $sql = "SELECT operator_id FROM ok_operators WHERE operator_connected < operator_limit AND operator_online = '1'"; $mysql = Mysql::getInstance(); $result = $mysql->query($sql); if($result->rowCount() > 0){ echo 'var online = true;'; }else{ echo 'var online = false;'; } } online(); ?>