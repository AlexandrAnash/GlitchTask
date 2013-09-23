<?php
if (@$_GET['uri']) {
	session_start ();
	$size = getimagesize ( $_GET['uri'] );
	$width = $size [0];
	$height = $size [1];
	$gif_png_jpg = (substr(@$_GET['uri'],strlen(@$_GET['uri'])-3,strlen(@$_GET['uri'])));
	if  ($gif_png_jpg == 'gif'){
		$img = imagecreatefromgif ( $_GET['uri'] );
	}
	elseif ($gif_png_jpg == 'png') {
		$img = imagecreatefrompng ( $_GET['uri'] );
	}
	else {
		$img = imagecreatefromjpeg ( $_GET['uri'] );
	}
	for($i = 0; $i < $height; $i ++) {
		$bool = rand ( 0, 2 );
		if ($bool == 1) {
			for($j = 0; $j < $width; $j ++) {
				$c = imagecolorallocate ( $img, rand ( 0, 255 ), rand ( 0, 255 ), rand ( 0, 255 ) );
				imagesetpixel ( $img, $j, $i, $c );
			}
		}
	}
	if  ($gif_png_jpg == 'gif'){
		header ("Content-type: image/gif");
		imagegif ( $img );
	}elseif ($gif_png_jpg == 'png') {
		header ("Content-type: image/png");
		imagepng($img);
	}	
	else {
		header ("Content-type: image/jpeg");
		imagejpeg ( $img );
	}
	imagedestroy ( $img );
}
?>