<?php
 class OperatorImage{ public $srcImage = false; public $type_img; public $name_img = "no_image.jpg"; public $image; public $image_type; function operatorPhoto($photo_name){ if(empty($_FILES['operator_photo']['name'])) return $this->name_img; if($_FILES['operator_photo']['error'] > 0){ die('Ошибка при загрузке картинки'); }else{ if(!$this->moveFile($_FILES['operator_photo'], $photo_name)){ die('Не удалось переместить файл'); }else{ return $this->name_img; } } } public function moveFile($file, $photo_name){ $tmp_file_name = $file["tmp_name"]; $this->name_img = time(); $type_img = $this->imageType($file['name']); $this->name_img .= $type_img; if(is_dir('../images/operator/')){ $dir = '../images/operator'; }else{ $dir = '../consultant/images/operator'; } $this->srcImage = $dir."/".$this->name_img; if(!move_uploaded_file($tmp_file_name, $dir."/".$this->name_img)){ return false; }else{ $this->load($this->srcImage); $this->resize(70, 85); $this->save($this->srcImage); return true; } } public function imageType($name){ switch(mb_substr($name, -3)){ case "jpg": $this->type_img = ".jpg"; break; case "gif": $this->type_img = ".gif"; break; case "png": $this->type_img = ".png"; break; default: $this->type_img = ".jpeg"; } return $this->type_img; } public function load($filename) { $image_info = getimagesize($filename); $this->image_type = $image_info[2]; if( $this->image_type == IMAGETYPE_JPEG ) { $this->image = imagecreatefromjpeg($filename); } elseif( $this->image_type == IMAGETYPE_GIF ) { $this->image = imagecreatefromgif($filename); } elseif( $this->image_type == IMAGETYPE_PNG ) { $this->image = imagecreatefrompng($filename); } } public function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) { if( $image_type == IMAGETYPE_JPEG ) { imagejpeg($this->image,$filename,$compression); } elseif( $image_type == IMAGETYPE_GIF ) { imagegif($this->image,$filename); } elseif( $image_type == IMAGETYPE_PNG ) { imagepng($this->image,$filename); } if( $permissions != null) { chmod($filename,$permissions); } } public function getWidth() { return imagesx($this->image); } public function getHeight() { return imagesy($this->image); } public function resizeToHeight($height) { $ratio = $height / $this->getHeight(); $width = $this->getWidth() * $ratio; $this->resize($width,$height); } public function resizeToWidth($width) { $ratio = $width / $this->getWidth(); $height = $this->getheight() * $ratio; $this->resize($width,$height); } public function resize($width,$height) { $new_image = imagecreatetruecolor($width, $height); imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight()); $this->image = $new_image; } } ?>
