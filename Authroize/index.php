<?php

	require ("config.php");

?>

<head>

	<meta charset = "UTF-8">
  <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
	<link href = "css/main.css" rel = "stylesheet" type = "text/css" />
	<link rel = "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
	<script src = "js/crypto-js.min.js"></script>
	
	<script src = "js/main.js"></script>
	
	
</head>

<html>
	<!--<body>-->
		
		<body connectime=<?=!$_SESSION["connect_time"] ? $GLOBALS["file"]["connect_time"] : $_SESSION["connect_time"]?>>
			
		</body>
		
	<!--</body>-->
</html>


