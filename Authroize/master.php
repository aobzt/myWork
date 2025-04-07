<?php

	require ("config.php");

?>

<head>

	<meta charset = "UTF-8">
  <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
	<link href = "css/master.css" rel = "stylesheet" type = "text/css" />
	<link rel = "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
	<script src = "js/crypto-js.min.js"></script>
	
	<script src = "js/master.js"></script>

</head>

<html>
	<body>
		<mask class="mask"></mask>
		<bar class="bar">
			<bar class="bar-image">
				
				<img class="logo" src = "<?=$GLOBALS["bar"]["Logo"];?>">

			</bar>
			
			<bar class="bar-title">
				
				<bar class="company-ch-name"><?=$GLOBALS["bar"]["ch_name"];?></bar>
				<bar class="company-en-name"><?=$GLOBALS["bar"]["en_name"];?></bar>
				
			</bar>
			
			<bar class="bar-openside">&#xf0c9</bar>

		</bar>
		
		<workeare connectime=<?=!$_SESSION["connect_time"] ? $GLOBALS["file"]["connect_time"] : $_SESSION["connect_time"]?>></workeare>
		
		<bottombar class="bottombar">
		
			<?=$GLOBALS["bar"]["ch_name"];?>#<?=$GLOBALS["bar"]["en_name"];?>
		
		</bottombar>
		
	</body>
</html>


