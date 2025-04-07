<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$ip = $_SERVER["REMOTE_ADDR"];

?>

<html>
	<head>

		<meta charset = "UTF-8">
  	<meta name = "viewport" content = "width=device-width, initial-scale=1.0">
		<link href = "css/login.css?v=<?php echo date('His') ?>" rel = "stylesheet" type = "text/css" />
		<link rel="stylesheet" href="use/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
		<script src = "use/jquery-3.7.1.min.js"></script>
		<script src = "use/anime.min.js"></script>
		<script src = "js/crypto-js.min.js"></script>
		<script src = "js/Login.js?v=<?php echo date('His') ?>"></script>
	
	</head>
	<body>
		
		<login box="login">

			<login box="window">
				
				<login box="title">
					
					<titleText>護理備管工作站</titleText>
					<URLtext box="URL">若您無法登入請點選<a box="URL" href="#">這裡</a>，說明請點選<a box="ill" href="#">這裡</a></URLtext>
					<URLtext>允許完畢後關閉分頁，並重新整理(F5)此畫面</URLtext>
					
				</login>
				
				
				<form box="form" option="login">
					
					<login box="inputIcon">
						
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAETUlEQVR4nO2ZW4iVVRTHz5SXkoaovFBGPfQSZg4zkqjUc1COEd3UEIYgRHyafBBLMARFwoko56EQHSUny6ygqFejeupJqF7MW2XhOENOUEx4+clq1idrFnt/Z3/z7SmD84cDh7PW/u+19tpr7bX3aTRaaKGF2gBuBJYCW4APgR+AYeAicAS4oXE9ArgH2An8SjnuM2O6gHPAL8ArwNz/wvA5wNvA3zTHxzYCwHYnHwPeBG79t4x/XreHh0RhD7BWV3k2MC0w/gHgTGD8WeDpqTR8uq66x1FgheRBRa7ngK8DfH3ZcwaYBXzuJvoReDQD95OaDxYfATfnMn56wPiDwC1ZJmj8M0c78EHAifqRAN5xxK820Z8GLNdc6dWPfF8WyokCQJtwu7lea9QBsMYRbi3R7QD2AyPEMaI6HSU8O92Yp+qUSmvMgYieVJsDwGXScVnHzI5EYtDo/japEusqzvHQngcWAicDBp4A3tWK0qc5E9NbGMkJm9hvVDX+bndIPRbQuRO44AyStqGzhLdTdSxGI0484w67eVUcsPvwaERHep8CF0JOlvA/robbSIS20zfXNGBzlcbMhm9FRE/26lbgMHB/qvFm/CLnxEBAZ5WRn0kqq1rubAJFS19dMH6C28Re5OQztPEr8GAK6ctmwJ5IgnXkOu4Zb/bKovCekW9IIbRJttbJbtIWQtCfyYEuM9+wjziw3sjfTyH83gzocjI5YQt8m8MBAXDK8C5rGABLKs3pDq87nOxFI9vfyAQmbpPVTnavkZ1OIbP1f4aTbTayHRkd2GV4NwY64QJ/ppDJoVFgppNtNLJdGR3oM7wvOdlMIxtLIbNla8J9VcJrZAenaAutcrK5RjaUQvadGbC4JIlPZnTgtOFd6mQPGdmxFLJDZsALgV7fJnlnBuMXG77z/moK9Bj54RRCm6h7A3Lp5wscyeDAJ4ZvX0A+YOSbUghtyIYCK9Jhev8r0pjVMH6lmeuSbxU04jYnl6SQSpP2sxn0RJMojPoeJtF4WYjRJtHuNvKfktsXqfFm4JeRW9gJ50Sway1Z+T/chen2gN5XRmd7Kr8MvMsdaN2R25hdQbQxm9B+BBLW7nnB78CCJqsvZ9P8ZAeUYLchkNVujzhhI1HglN5rX9fPoCuVduUXRDpeewXdXcl4JblNy1ppJyj9klaKKpd6Sdi9kW3T5kr5UEgv1Ql5/rPY1uSGNRB5Ny0gsn1lFxNgmxvz7KSMN4T9jlAen9oS/itYYx62Vutv0fdTxlfeG9+f62nxU0c86DvVmnO0u20j+CzbdVZvYl+4CdZl4u4OvBmJ8bNy8PtT8S0zycqaUZWzIPS83j+VDwky+SPAw4G/mg5pZVmn9X6+PJFrPz9HW5QeTXTbHthqUy9hM75gV8GYnjmTK5WZHNgwCcOlt9lR+YSdKugW6dXb1TFtCP/SlmRYf5NXvE360nB9/vXaQguN/xeuAtAhnLh7ERoVAAAAAElFTkSuQmCC">
						<select box="dicCode">
							
						</select>
						
					</login>
					
					<login box="inputIcon">
						
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAD9klEQVR4nO2ZW4iNURTHZxjXiZpxya2kPKG8GPIolxTGC/PmmhJjhqKGmJQakrwMXpTbg1zzIMULJZdB7sKDGBRjjIghl/DTYm12e75zvr3P+c4hnX99zXS+/V+Xvdfea6/1FRUVUEABiQAYCdQCx4AmoBn4AHwGXgO3gSPAamAc0OlfMLovsB54RjieAhuBQX/D8HJgu85wtvikssrzZfzUFDP+EjgALNIQGQr0BLrqSo0B5gF7gNYIfhtQlWvjNwPfHcVXgNlA5wA5JUAlcC7CEVmNklwY39tR9ByYkYDcGcAjR/ZxoEcylv9RVAyc1BWQUOmT8OQcjHAiJyvRK3GhRb8nqMFxYlsudMUZ0k3zwSXgvT6SF2rknQe/wXFiVn4s/6V8CHCL1LgpYzxW4pBzupXla+bTGW9wQ45Wjz3x2OI05sMBCRs7OUnIlOlTq78ZLPOQV2mN/xiUsYHhwEr5G8C5bCmsiXi/wnrf5CnzgsVp8DWk2DqXHwY40G4pK0tx/TB45ymz0uI88boAAiMsUkuAA+9iHOiTgQNddBMbVPiQllqEwwEOyLFpUBsTQhcD5O61eHU+BMmyBtUBimTTGsiGXa5hU67Gf85Q7oKgCZXZsQjjA49ROefjcD3uGLUBjLW4t4vi4FyshsUSOiayGzHGDw6U2d/it/kQJPUblIYoU77c/6t1Jdt1c1/U37pmIK+bHZo+BDtWgxUmDX5NiMEXH8Iri9A3L1amgZM/3vgQ7liEMTFjS4GtwD3gG/6QsfeBLXFhCoy2ePd8HDhqEebHGC+GZ4u76ZwAJlpjT/g4sMYi7E4zTmYvKWxJo0caA+e1tzTFxwHpKBi0pirrNAQM5oY0qmSsdigM7vpyfYVL08mg0uPy1ivLJkF7IsZbwqVjZnA+xZhr1phVGeios/hXEzHcEj7YKUA6tE80MRl8Bdb65A1NTPXKMViSqAOqSBpMBnK96B2RYNzG1FMtyicBA4Du+sj/k4FNTngKzrqO68at9tq0MQlE2n0G0rcpjrjjnyZznHZ7otq1O6XvpQc1MhsnqhyFHco6VbgMeBFgeItySiKqwZ3WuOwciAiln064K2GF1HRghxY3L7QY/6gGN+m7aVJpRfA7A7scXfVZGW/NsLT5bBxy90SWOgYCZxwde6MmKlMFPSKcaE6VIwJzzkKn7kXDyLvbHbISbjihrY+ZUWERc5TOiajg5Ghdl9jMp1A+K8UHCpnFfVrDVgD9dF+YY1SuKIu15n4bwW8GJuTMcMcJ6bY1OskuU7QDGxL/HuDpyCA9ldzk5IMHep3IfePWczNWqEGHtcn7SstTc4zKZ9b9cm8CRv1tmwso4H/BD5y9Wlc4bTnpAAAAAElFTkSuQmCC">
						<input box="username" name="username" pos="login" type="text" placeholder="請輸入您的帳號或利用條碼機刷您的識別卡">
						
					</login>
					
					<login box="inputIcon">
						
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAADYElEQVR4nO2ZTUhUURTHRzErF4phUUYfi4hoFaQZEW1qkYqaYC7aZEQQtKlFmIuWIy2jJGiTBkFqRh+72laURYtsXZZaYEqbvpwofnGb++zweOM79703OMb8YRjmzf2fc/7vnnfvueelUkUUUURiAFYBt4A3QIYszPdnYMz+dw5oAEpThQbgDHpMAL1AbapQAOwB5nDDHNBnZi9VCADWAluBFfZ3OVAD1AFHgX5gOkDIDNCZWgoAyoBW4FGAEDMbZamlAqAFeOsTcR9YmeTdOgzsSMRgsI9KYDBARPyZAK5agz+BLYlEHOynBEj7RFyOa7TNZ3CnkrcXuAd8sJ+7ZoVSctM+nx1Rg19nVwYPN5S8buB3wMP5CzirnIkhwfsEVEcRcEUYmdQYsfuACTQXjLB9ymfineBdcg1+DfBdGDig5JlU8fAA2Gg/D8X1O0pbrYLzw2nH9uXhqAPP5LuHDeL6JnF9ysHeE8FLuwiYEsRDDrx5uPynnIX3qgIQ2C5IMy5VYx4ELLMPsYd6Dem0INzUOsuHAANgQFC7U2EAbgvCccX4ZuCFqP81yFhOs8L+McEb1gh4JggNijomLppDfOwSY8c0AsYFYXPIWHMX4+K5Ykn3MKMR8E0QKkLGyrSpDDX+j1cleJmQscvF2DmNcRlUecjYeWiDd+WSPRCpxHqEWUGoKQABNWLorMbwa0GoixqEXZ2mbB3VGENAvetDPCIIXTEEmMA9TMQQ0CWGjmgE9AjCtQIQMOC6kZmmk4fphY51IQIarQjT/zkYRQDZB3hWm9IeqdQ69dAaRYDCj0aAuQkezMG/RGvcdMw8PF5EAfvFsPMuxtf7Omwtij2jKk8bWTtwwlSmagGW2OebvsrFKCXidprloX7Qn4NAUwICmqJHGS6i0+csnWPDGo1QThtO/oLPkUp/RahXg0IA2daiafNJDLlUn8p07bfdh96k7EoHKwNEjC+0RzjYbgc+Crtfk4k6eCb86YRtfbS5LHP2sH4EeBlg70JeBAjnHTleUJjuwXV7hjUV5GpbClSYkx2wGzhp35PJ8sDDpOaMnJSIatPui/A6KQhfgIsuG2GSQmrtqiRrJy1Mo6onUuM2D0JKbdqYzvQw8MqmScaesc1O/tSmzylg22LHXEQR/wv+ABNltAU2rJ66AAAAAElFTkSuQmCC">
						<input box="username" name="password" pos="login" type="password" placeholder="請輸入您的密碼">
						
					</login>
					
					<login box="error">*錯誤的帳號或密碼*</login>
					<ip ip = <?php print_r($ip) ?> ></ip>
					
					<login box="inputIcon" pos="bottom">
						
						<!-- <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAC80lEQVR4nO2ZPWgUQRTH13gqiRiIRpFYpLGyEA2JgmAlCAqJjdhJYiliFSGKRaoTsTLxGlESBYtL1EY7LUTUSgWNYuHnKSjE+NEoJhb5yWNnYLLZcLO7s7t3cj847uD4v4+d2Z333npegwYNEgMsB3YBp4GbwEvgB/AXmFO/p4DrwElgJ9BUC4F3AueAL0TnE3AG6Mgj8A3AJXWFkzILlIC1WQV/WG2JIJ+By+r/LmAdsAJYCbQD3UA/MA5Mh+hngENpBr4KGAtxfA/YL/dBBFsFoA94EGJPVqPgOvg1wN2Ao9fAXge2e4H3Adu3gGY30ftOzgccyEq0OLTfCpRDkii4TmAeOOXE6GIfy4BiIIkLroy3AMdcbBkLX8VAEge9egJ/JSaMBL4CbV49gX9PVIwkRr16A/8xq/mT+YkNbAYG5TuBjUdGEkW3EVZ3/k45/i4ns4NV+JhpAWgkEDsJ/FJEbmJNTzrRhjvvUoEnTeKKYWMonWiXdr4N+GYE8DPqVQSOGPrJ9KJNKQlgh6GdshHsAW6rRmXI0WcU+B3YTtsj9B6aGRuBiybFhjcRynjNrI1gvsYSWG1oftkIZI9qRoCzDj7j6jSNs4U6DV3FRvDCEHTbOMnwJn5iI7hhCAbyDF4Ajhv6a141pGExBGNVBekfZGXDxlEbgQydNNNx2zpHpURzYAKy1UbUpIZOmr4ci7l+I4630uzYCmVipnmYRzmNfyGfGnEMRhFvUhMzTa+XMSysgeQUb49qQAZMGpnbtKYWbfgQwZy3DntRkVmlGvdpytZ7MCH4209TiT3kklklC8msrQOGgfsytk9qqBRMIquVcIIaxMqYz2Qiy3siMepACSbxIe4ZkedKlFiMjD4OSAMe8YJsyWUryqxyiRcUMj24qp7fPcB69XJDGpKNwG7gBHDHKK0vZp6ASqJNtYnmYReHV7kkYCTSoZ5KZu1kyzNgn1cLqLqlRzXwk8Bz1QfMqVWSA/Gx2mIDubyZbNDgP+UfqaAZpJcK4foAAAAASUVORK5CYII="> -->
						<login box="button" option="login" action="Login">登入</login>
						
					</login>
					
					<login box="FunctionColumn">
						
						<!--<login box="function" pos="forget">忘記密碼</login>
						<login> | </login>-->
						<!-- <login box="function" pos="register" action="Plant" function="register">創建帳號</login> -->
						
					</login>
						
					
				</form>
				
				<login box='userInfo'>

					<ip><?php print_r($ip) ?></ip>
					<version> / ver_1.1.0</version>
					
				</login>
				
			</login>
			
		</login>

	</body>
</html>
