<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="http://vk.com/js/api/share.js?86" 
		charset="windows-1251">
</script>		
<script type="text/javascript" src="http://vkontakte.ru/js/api/openapi.js?24" 
		charset="windows-1251">
</script>




</head>
<body>

<?php
session_start ();
$VK_APP_ID = "3877463";
$VK_SECRET_CODE = "ix2PZdPGN0e3RgrqEULf";
if (! isset ( $_SESSION ["code"] ))
	$_SESSION ["code"] = null;

if (! empty ( $_GET ['code'] )) {
	if ($_GET ['code'] != $_SESSION ["code"]) {
		$vk_grand_url = "https://api.vk.com/oauth/access_token?client_id=" . $VK_APP_ID . 
							"&client_secret=" . $VK_SECRET_CODE . 
							"&code=" . $_GET ['code'] . 
							"&redirect_uri=http://localhost.glitch/testtask/";
		$resp = @file_get_contents ( $vk_grand_url );
		if ($resp != FALSE) {
			$data = json_decode ( $resp, true );
			$vk_access_token = $data ['access_token'];
			$vk_uid = $data ['user_id'];
			
			$res = file_get_contents ( "https://api.vk.com/method/friends.get?uids=" . $vk_uid . 
										"&access_token=" . $vk_access_token . 
										"&order=random" .
										"&fields=first_name,last_name,photo_100" );
			$_SESSION ["res"] = $res;
			$_SESSION ["code"] = $_GET ['code'];
		} else
			echo "<div id='error_code' >Что-то тут не так.... </div>";
	}
	$data = json_decode ( $_SESSION ["res"], true );
	
	$user_info = $data ['response'];
	$count = count ( $data ['response'] );
	$inc = 0;
	foreach ( array_slice ( $user_info, 0, 25 ) as $value ) {
		// Glitch($value['photo_100']);
		// echo $_SESSION['imgage'];
		if ($inc % 5 == 0) {
			echo "<br />";
		}
		echo "<img class='img_all' id='img_$inc' 
				src='http://localhost.glitch/testtask/image.php?
				uri=" . $value ['photo_100'] . "' />";
		
		$inc += 1;
	}
}
?>

<form action="https://oauth.vk.com/authorize?client_id=3877463&scope=wall
				&redirect_uri=http://localhost.glitch/testtask/
				&response_type=code" 
		method="post">
		<button id='button'>Glitch</button>
</form>
<div id = 'VK'>
	<script type="text/javascript">
		document.write(VK.Share.button({
			url: "http://localhost.glitch/testtask/",
			title: "Glitch effect!",
			description: "Тестовое приложение, при нажатии на кнопку Glitch \
							можно увидеть аватарки друзей с Glitch эффектом!",
			image: "http://media.rhizome.org/blog/8110/lady-glitch2.jpg"
			},{type: "link", text: "Поделиться"}));
	</script>
</div>

</body>