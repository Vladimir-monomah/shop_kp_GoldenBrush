<?php
 session_start(); class AddOperatorMess{ private $id_user; private $id_operator; private $message; public function __construct(){ if(isset($_POST['message'])) $this->message = strip_tags($_POST['message']); else die('No message'); if(isset($_POST['id_user'])) $this->id_user = intval($_POST['id_user']); else die('No id_user'); if(isset($_SESSION['operator_id'])) $this->id_operator = intval($_SESSION['operator_id']); else die('In session no operator'); require 'mysql.php'; } public function updateUsersChat(){ $sql = "UPDATE ok_users_chat SET new_message_operator = new_message_operator + 1 WHERE id_user = {$this->id_user}"; $mysql = Mysql::getInstance(); if(!$mysql->exec($sql)) die('Error!!! Не удалось отметить о новом сообщение'); } public function addMessage(){ $mysql = Mysql::getInstance(); $sql = "UPDATE ok_users_chat SET write_operator = '0' WHERE id_user = {$this->id_user}"; $mysql->exec($sql); $this->message = $this->url_to_link($this->message); $this->message = $mysql->quote($this->message); $wr_date = time(); $sql = "INSERT INTO ok_messages(id_user, is_for, wr_date, messages, is_from) VALUES({$this->id_user}, {$this->id_operator}, '{$wr_date}', {$this->message}, '2')"; $count = $mysql->exec($sql); $this->updateUsersChat(); } public function url_to_link($text){ $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/"; if (preg_match_all($reg_exUrl, $text, $url)) { foreach($url[0] as $v){ $position = strpos($text,' '.$v)+1; $text = substr_replace($text,'', $position, strlen($v)); $text = substr_replace($text,'<a href="'.$v.'" target="_blank">'.$v.'</a>', $position ,0); } return $text; } else { return $text; } } } if(isset($_SESSION['who']) AND $_SESSION['who'] == "operator"){ $load = new AddOperatorMess(); $load->addMessage(); }else{ die('Error! Нельзя обращаться к файлу напрямую'); } ?>
