<?php

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	error_reporting(E_ERROR | E_PARSE);
	session_start();

	if($_SESSION["userid"] != "") {

?>

<!-- 修改完記得修改版本號 -->

<html>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/home.css?v=<?php echo date('His') ?>" rel="stylesheet" type="text/css" />
	<link href="css/TAT.css?v=<?php echo date('His') ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/an-skill-bar.css">
		<link rel="stylesheet" href="css/skillBar.css">
		<link rel="stylesheet" href="css/Dashboard.css">
    <link rel="stylesheet" href="use/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="use/jquery-ui.css">
    <script src="use/jquery-3.7.1.min.js"></script>
    <script src="use/jquery-ui.min.js"></script>
    <!--<script src="js/jquery-3.6.0.min.js"></script>-->
    <script src="js/an-skill-bar.js"></script>
    <script src="use/anime.min.js"></script>
    <!--<script src="js/crypto-js.min.js"></script>-->
	<script src="js/main.js?v=<?php echo date('His') ?>"></script>
    <script src="js/statistics.js?v=<?php echo date('His') ?>"></script>
	<script src="js/TAT.js?v=<?php echo date('His') ?>"></script>
    <script src="js/Dashboard.js"></script>
    <script src="use/jquery-latest.min.js"></script>
		<script type="text/javascript" src="js/jquery-barcode.js"></script>
		<script src="use/chart.js@2.8.0.js"></script>
	</head>
	<body>
		
		<!--遮罩-->
		<mask box="mask">
			
			<window box="window"></window>
			
		</mask>
		
		<!--Loading遮罩-->
		<mask box="loading">
			
			<div class="img"><img src="image/loading.gif" alt="Loading" class="loading-gif"></div>
  		<div class="loading-text">Loading...</div>
			
		</mask>
		
		<!--上方選單-->
    <bar box="bar">
        <bar box="title">
            <bar box="logo"><img src="image/OsunLogo2018.JPG"></bar>
            <bar box="company"><?php print_r($_SESSION["ip"]) ?><br>護理站代碼：<?php print_r($_SESSION["dicCode"]); ?> 護理站名稱：<?php print_r($_SESSION["dicName"]); ?></bar>
        </bar>
        <bar box="menu">

					<?php if($_SESSION["prTube"] == "yes"){ ?>
							
						<bar box="item" pos="menu" openMenu="testTube">備管作業</bar>
						<bar box="item" pos="menu" go="checkTubeAndPatient" action="Plant" function="checkTubeAndPatient">檢體採檢</bar>


          <?php }
          
          		if($_SESSION["Package"] == "yes"){ ?>  
          
            <bar box="item" pos="menu" openMenu="package">檢體打包</bar>
            
          <?php }
          
          	 if($_SESSION["signIn"] == "yes"){ ?>
            
            <bar box="item" pos="menu" openMenu="sign">檢體送出</bar>
            
          <?php } ?>
					
						<!-- <bar box="item" pos="menu" go="set" action="ShortData" function="recode">過去紀錄</bar> -->
						<bar box="item" pos="menu" go="set" action="Plant" function="setting">設定</bar>

        </bar>
        <bar box="user">
           
            <bar box="item" pos="user" go="userOption" action="UserOption" userid=<?php print_r($_SESSION["userid"]) ?>> <?php print_r($_SESSION["username"]) ?> </bar>
            <bar box="item" pos="user" go="logout" action="Logout">登出</bar>
           
        </bar>
    </bar>
    
    <!--空白頁面-->
    <space box="space" mcode=<?php print_r($_SESSION["Class"]); ?> machine=<?php print_r($_SESSION["machine"]); ?> pkgbar=<?php print_r($_SESSION["pkgbar"]); ?> pkglist=<?php print_r($_SESSION["pkglist"]); ?>>
    	
    	<ip ip=<?php print_r($_SESSION["ip"]) ?> > </ip>
    	<class dicCode=<?php print_r($_SESSION["dicCode"]); ?> > </class>
    	<class dicName="<?php print_r($_SESSION["dicName"]); ?>" ></class>
    	<class machineIP="<?php print_r($_SESSION["machineIP"]) ?>"></class>
    	<?php if($_SESSION["Class"] == "ER"){ ?>
    			<class otherIP="<?php print_r($_SESSION["otherIP"]) ?>"></class>
    	<?php } ?>
    	
    </space>
    
    <!--彈出視窗-->
    <userOP box="userOP">
    
    	<userOP box="close">&#xf00d</userOP>	
    	<userOP box="changebox">
    		<userOP box="change" action="Plant" function="change">修改密碼</userOP>
    	</userOP>
    	
    </userOP>
    
    <bar box="subMenu" pos="testTube">
    	
    	<?php //if($_SESSION["Class"] != "ER"){ ?>
    	
    	 <!-- <bar box="subItem" go="workList" action="filterForWorkList" function="workList">我的工作</bar> -->
    	
    	<?php //} ?>
    	
    	<bar box="subItem" go="testTube" action="Plant"	function="testTube">單號備管</bar>
    	<bar box="subItem" go="mix" action="ShortData" function="mix">病患備管</bar>
    	<bar box="subItem" go="HisTestTube" action="Filter" function="HisTestTube">備管紀錄</bar>
    	<bar box="subItem" go="TAT" action="ShortData" function="TAT">TAT看板</bar>
    	
    </bar>
    
    <bar box="subMenu" pos="package">
    	
    	<bar box="subItem" go="package" action="recode" function="Package">檢體打包</bar>
      <bar box="subItem" go="HistoryPackage" action="LongData" function="HistoryPackage">打包紀錄</bar>
    	
    </bar>
    
    <bar box="subMenu" pos="sign">
    	
    	<bar box="subItem" go="sign" action="ShortData" function="sign" option="signOut">檢體送出</bar>
    	<bar box="subItem" go="sign" action="ShortData" function="sign" option="signIn">檢體送達</bar>
    	
    </bar>

		<!--日期時間-->
    <clock>

    	<date id="date"></date>
    	<time id="clock"></time>
    	<version> / ver_1.5.3</version>

    </clock>
    
    <?php
    	
    	if($_SESSION["Class"] == "ER"){
    
    ?>
    
    	<forER>
    
    		<label class="switch">
																										
					<input type="checkbox" name="ER">
					<span class="slider">
																										
				</label>
				
				<labeltext>切換條碼機</labeltext>
				
			</forER>

  	<?php } ?>
    
    <!--主畫面-->
    <home box="home">

    	<!--下方選單-->
    	<home box="grid">
    		
    	 <?php if($_SESSION["prTube"] == "yes"){ ?>
    	 	
    	 	<?php //if($_SESSION["Class"] != "ER"){ ?>
    	 	
    	 	 <!-- <home box="item" go="workList" action="filterForWorkList" function="workList">
    	 	 	
    	 	 		<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADUAAAA1CAYAAADh5qNwAAAACXBIWXMAAAsTAAALEwEAmpwYAAAC5klEQVR4nO2aTWjUQBiGI70I/iGIoN48aGmtCqJg61IsIiJYBK0KHnooVUSrYNFqa2lQxF7EPxAV6VHBv4tQEXsSPenFHhQEvanYatXWaovWRwLfQlwmk50ka5I2L7xsmJ18+Z6dZHbyJZaVaQoIWA60Am0BfBiotJIk4DQwQTj9BrqsJAjYLkmNAdeA7gC+DoxLnPokQPVJMs0h4+yXOL3RZRdQwEtJpiJknBUS54UVt4BXkkx5yDhVEqc/uuwUAqYBm4GLwC0PD0syDzR9ivFDifPV4/sbMiFVWUEFzHYdKEmaAE4FhbpLsrU36EWbZH0AykygDpEOVZhAdZEOrTOBskmHchkU6VAuGynSoVw2UqRDuWykmIQj1ekT7DvwBHgk7gf+hEjuM/DYFa9YLzOBatIk8BxYBNQAG8RL5dOpU5jIqUsclNucNa54QVwNzNJBLdQkWCs3bIX3OPXAFUOoZmATMEA0GgZ2e0GVAe0eO84HPiraLwAtBgm8kVhfiFbjwBIVlJNcuRQnRwp2mgcMKoJdAg4YHPwmsJXSqMVr9nN+wUaB2ALsEU/XQFW6+vm51ufafQasBlZ5uFezr+0FlZdzqt2XQuVVYKYGar30KcaNPlA/ZVLy8rcwUIVyJpF3ivazUhMvVj0+UGFkm0I5ZeYOqX3nNSinxL20Qr0H6oAZwFyx8z9z3PDAKqinrjrfHZmkRmVbVzPsCwuV1w9gSOwetTBQJ4AG8Q7gNfAW2Olqb1B4X1RQYZWo0y+1UJ1MQqgm4oHaBiz28Ubpe9LVVlMMlG5BW0qoIVkT6vxJ+o662gZ8oQSsPQaoqGTrnk2pFrTphcoLmFOwoI3KqgXtbcVD7vNyOzEm290K9xhBlVIKqMuKdyw65PoZke02hc8kGSoq2RlUlJoqI1Wn6bvA4FUh+/+S/JvoLkqjo3FCOUucXyWAqo4NSsCORPAGmlvnrCQIWCn1je4QPgasjZslkxVQfwF7hG+n/XxU0QAAAABJRU5ErkJggg==">
    	 	 		<home box="text">我的工作</home>
    	 	 	
    	 	 </home> -->
    	 	
    	<?php //} ?>
    	 	
    	 	 <home box="item" go="testTube" action="ShortData" function="testTube">
    		
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACOElEQVR4nO3ZTYiNURzH8TNeRhhZDQspyiSxUTYKJQsLWWiabLAem7EZxQaxMraysDFr2SmyG1ZCLEioWQilYbxFMYaPTveZuure6957Fs95Mt/d031uPd/nf855zv93QpjnPwQ78AzTGENfqCJ44W9eYyhUDbzTmFsYCFUBI/jdROY7zmJpqALYhSeaM4l9oQpgMY7hSwuh61gXcgSXMYwFxfWo1nzFCfSGXMDOuge8h914W1zfLYZUM57G+3OQWID7TR5yBhvjJC8me5z0jYiLxEjZIodbvO3Pxe89xb0DxXLciKkyJZbhlX8zgc11/xsqPpj1PC9T5LT2manfuqAPF/AJj+M8K0tiTbHydMobHAm5gHFpHMxBYit+JUhMYkkOIrcTq3EgB4nBRImJHCR6G/QdnRCH47YcRI4nVuNKDhL9+Jgg8Q1rcxC5lFiNUzlIbMLPBIm4HVmeg8jNxGocykFiT6LEw7lmq0yJhcWGLoVyNoP14GiixNVQNlhR1652ww9syEFkLLEa53OQWN+iv26HKazMQeRaYjWGc5DY3iL6bIcY7ywqW6KnyKVS2FuqRCT20okSN0LZqIVoLxMkZrGlbI/QYbTTiIs5SKzuMtqZI2ZT/TmInEusxmjIATyqfLQTSRxWgyEX1PrpbrgTckKt+almtFMPznQhMh5yQ2357STq+RDT+JAjalHobJtDKu8jZjWZ+HFrxnvsD1VALVE8iQfFEJouDjvjUfKqsp9vnpARfwBZicQQH9MHxAAAAABJRU5ErkJggg==">
    			<home box="text">單號備管</home>
    			
    		</home>
    		
    		<home box="item" go="mix" action="ShortData" function="mix">
    		
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAACXBIWXMAAAsTAAALEwEAmpwYAAAD3klEQVR4nO2abYgVVRjHzxqlaYvs5gtSCWWCEkGsgohiaBSxENunQJM0/JJCHzQoCFKJBBFRREM21KKCIAhqNyLoiyYGioaCmHYRXSTfgi11NV2tnzzs/8LhcMfdO3dm7jTODw7c+5yXOf85L/OcZ8a5kpKSkiIAPA487O4HgCeAQeB7dz8AzGKI3/W7mjqA8a7AgmvxH/Ap8JAroOBbwOkg/aO8ta6Ago/WyHtReYddkQUD7cBTwCLlndN/S2NckQQDE4EBotnvCib4Gf0fDNZzn+x/uIIKPhmUm1oKLtgIn/Y2Kkvziz7CUTQk2JwYYHRiAhIUfAfo99Lf9QgGxgJtXnoZOKjN8DbwK9AVlBn3v9q0gBZgGVCJnB9DN9IER3EGWAmMylpwJbj7z45A8Gqv4zc0M657fvlaoNVGEnjHEx6WNdZnLTiKmoKBR+R7m7A3qyMEfKx6e2rU2aq8L7wZ8ppuhM2ESVkIHme/g3X7r7eWP4lop1Nlfw7sh2V/oUad2cqrBPZe2RenLtgHmK68M24YgFUquyuwn5D9uRp1nlTe+cC+Wfb3XY4Ff6SyHwb2HtlX1aizVHn7Avsa2bfHV5a+4N0quzKwvy77RXNggjhaX0SdxbJ/43Is+AeV7QrsbfLajKvAV8CXwF/V6QxMDuo8r7xfEpKZimDb6Iw52sC6gePa8IbDdvbfbCcHXgVmyn7W5VjwJS8Y6GOe1SFgm9bsW9rglgBbbBSBm0Gdahtmb8mdYODBYCQvAxt04Bg23m2+NTAXWKcp7jOhUY1pCB4lkcYR4NF7lR+mLfPE9qutgcRDSiQjeJrWoXlaUxPok4WZrujaHY22l4bgjSr3uUsIYIfa3JlUm7EFKyDQ441CFlwDfgRmuCwFM7TB3Ov4lzYWMm7NUnCnbBX5wm0ZJTuPH2v4UEH9gu3RYWyOfdH4ff1A196SluBW+cDferavVX55A32P21fzwoyfUhFcdSqch1xAY7bLGD3+jIupCfYxr0mRCBQc6M84VQ8cxI6GUJ/gBeSHziwEv6eyn2W4O4fJDiHGhiwE96jsMtckvI1rb6qCGYooVg8IT7smYacn+e03Yn2KwcgFVwPxlxI/o9YJcEp9mZOm4AeATRY3dk1GkRFjTaprOC8AK2IH+Rj5CC9shrNRCzsxqc8XUhEMjNHrj+SDajHQBvqn+j0trRF+2x4JLicA36nfbxR+DRvAu+p3t0thSr8EvOJyBDBP/T6e9GlptB7yg6m9pI6B+nVT4eH2OJ8P90bkj9eL6gMuZ+i1qol+LNEPxIEpefzkUB/I1Ce2pKSkxOWUu12w6jK833aTAAAAAElFTkSuQmCC">
    			<home box="text">病患備管</home>
    			
    		</home>
    		
    		<home box="item" go="HisTestTube" action="Filter" function="HisTestTube">
    		
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAqUlEQVR4nO3UQQoDIRQE0bpEhtz/SJlFjtOzGbJLIKDfVrvWgjwahTRRMotAzCKLmEUWMYssYhZZZJdF+HK24r6/2gZSHYGYRRbZ5bGzCqQ6AjGLLLLLY2cVSHUEYhZZZJfHziqQ6gjELLKIWbgv8uP+Q9J5HzunhEh6SHrdR96SntNB1BIxCqLWiBEQ9UBUQ7ohKiFdEcWQzxcr6aB1qq39EgMg/RCJMV2MBLTrSHkuYQAAAABJRU5ErkJggg==">
    			<home box="text">備管紀錄</home>
    			
    		</home>
    		
    		<home box="item" go="checkTubeAndPatient" action="Plant" function="checkTubeAndPatient">
    			
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAACk0lEQVR4nO2YO2gVQRSGP6+5UUERUXwlvgJ2ioWFhVVEwQcEEcGgYKWIFj5BsLNIZSGC4KPQgFaihaB2CiIqIkELCYrxnUpRSCw0xsSVgVk8HGayd4s7Oyv7wUDu3N2b79+dOTuzUFFRUdFE2oBjwEpKyDLgE5AA34BWSsQi4L2VL12AhcCAkP8BrKMkzAX6hfwvYAuRMRPYBZwADgGbgeXAfOCFkB8FuoiM3cB3IZmINib+/g1sIzKOesQT1caBbiJju5I047wHOA/cA76K78wdqjmq0mWgvSB/TgnBB8B0xzGfxTGrRH8deGr7HwMtFPREvQ5c8MgbrokAB/jHXnX3zDwKwjRgUo7jDwrJq6L/uQpg7kLT6bX/bMiO30ZYKyQf2b6afRbIAMMErjYf7BDKM9Hviv776vduF1EqBzJCdACD4viT4rvFwB07yW8CC5olf8RRKkfEZ7M4W+qR/yiO+2KXFEHR8g+BGcCmjBAdSt4s3DpjkU/xhVgCvFPy62OT94UYFJuVJKT8DuAWsDGHfEqXoyQmIeXr4iqO5ZRP2QP8EeeNhB42zxxX0Le20egxb1adZi8QlHm2zMkA5xo4L4oJm9KphoFpp5l4j6tL5QYKok1tuGU76znneKzyo7ZlhVhtNylDRQ6bdiVvyuFWYIWq774QU4EpIYUv2VJ5xiMv3xY0GiIYdTVJhyeQT+lxzAm5KQnORYeQT36foyoltq+wVyM14IYSMuuXyRny/fYBlX7+CcwpMsRrFeKlCKHln9i3bmbD8SqGAOl8eOMIsd8jnzIbOAysIQJaHCFk6wNmETl1Twh95aOmFXirAvTmfPcTRYg+FSK6F7FZmCp0pcwB0hJr3lHuLNsQqqj43/gL8BFVJbnPc54AAAAASUVORK5CYII=" style="filter: brightness(0) invert(1);">
    			<home box="text">檢體採檢</home>
    			
    		</home>
    		
    		<?php }
          if($_SESSION["Package"] == "yes"){ ?>
    		
    		<home box="item" go="package" action="recode" function="Package">
    			
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEzklEQVR4nO2ae4hVRRzHp63ssWqhYWWkFmkviP6KBCGhBxQKhlSauPSAoBcWJRUEbZBgRNEDSguijCi2gkgiUjRCi4KkP3pIhvR+baa9zB7qJ37c33GHcWbOnHPP2d3rPV+47OXuzPx+8z3ze84xZoQA9ACL9dNjug1AH0NYbLoNQL9FQL/pNtAQQHMCaExgHxofYLoNND6AxgfQ+IB9aHyA6TbQLT4AOAhYBCyU7ykEAPOAq4FDTKcDuNLa6IqMhBABwH3W77ebTgetp49Lgo8A4AFn7K2m00Frsys8JNxrEwA86ox5BTjUjHYAJwA3A9fYNp5Aws/W98HUzcvvKu964NjaN+gDcJRueB2wx1J8oXdCmAQfok8euMEauxt4Q9tq40ydAA4DLgVeBnYFlF+Qs0YeCbnHHrg2MHcn8AIwtzLTodW4nA08BewICP4PeB2YHzKBRBKSbF7nS0h9U0+AD9uAx4FZKTp5AUwHtkae1ntqi5NMQXhIKOXwgOMlUgCbInp+DJxYRsG3Agv+CFxSVNmADEl2bqwi4dETKE/eh9XtJC8hfALcIU/BjGwEWgJsJB9zUhcdB3xnTXwWeBLYHlhY7HANcBUwfhg2fbQ6wvVOBLKxXXUW3TOIOR+RIuBBa9LXwFgrCoiHXQX8GRD8txw3vfQ4ssJN27J3psqWv8CX1ph78gSdAfxrTZgfyQP6VKBEAR92qMJzy9i4RiDx4o84SZONPXr8xQwmBtZZYI3/Czg5JnS9NXhNoqKTE+zwW93IrIT1ztTU+Isc/yNjpiXqKAlbhtdSHN8/wKkpiztrnKaKbYko/6mOmW7Nm6IkfhiZ95WSeHYJvdyTPSfP8S0rKsQT4mYCj3ny/Ax7gXf1I999GNQ1ZpZOaIZ0eijoENnf8fW2I8wRfDBwgfqD38nHLvUtl1VZDepD/n4/hwic7hyPO6sS6lGiV/sDGzwb36D/661R/jKH6Gny4y0BO70bOKkmRV7yyByoSdaMiF+6SQZMjTgtsc13NF09piKFLiSM8yuScZw61fcjsr4BTvHF3MFIxrdW4//YkoqNATbnhLdSdi9OTf3GasekcfKAzL+MiWVd8/SYhur+P4DngIuLJDnAXeTjtoKESqL1om4uhE1aQhfzL8B4zfHXRmrvn7Sfd27OWlOcFFqOoA+/xQosDbFyWp+IVH8u2r93ACYC12nGtzeSrCz3JVFa89s1ut3+drEqkMyIM/s8cdPVEmBDHaeUwp+llMsexzfbaYu7EILPK1juVksAie/xAecADwM/BITv1mOd4XmdFyNA8Guk3B0WAvqKvMenGd9FwDPOhm1IJjg5kYAq0T+sl5e0QtLlwKtaWGVYElj/wCLABjBBI8kVzu/dQUAIDQE0J6C/MYHhQ+MDTFHQOEGaKEA7NnSA+YC3tTjp6SYClnoWko7x/cBZHUbA0rIl7+bIoh9ph2fqKCdga1kdTWKvUPCB1u2TRgkBbd1LepF4O5zcOK2BgFpupmO9wrzbYWlSDoReWqqIgNzb4dpBWq/wF2Cl/dJSmwSM+NspZW5hMmzRMU8X3HQ2b4bpBNC651/uXEgWxTb35HQcGIokKyO9wmTf0dEADteNDTi9Qjt61HY7PKrAUK9QPhNGSpH/AanmwEDa9wJCAAAAAElFTkSuQmCC">
    			<home box="text">檢體打包</home>
    			
    		</home>
    		
    		<home box="item" go="HistoryPackage" action="LongData" function="HistoryPackage">
    			
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAD0klEQVR4nO2bS0hVURSGd0nv6En2JAusDCHKqKAcRkXhoEKahBnBJYKSoIgIwgZGA6kcBI6k1yCinAQFPWYVBJJNyjKKiIgeoGUPy9cXO9fl7k73PO7xHO8V9wfC5Rz3Pmv/7rXWPnctlbJYLBbL0AWYC+wH9gJ5ajgATAH2APeAXlIcVUMBoAg4ATwHXgGngdU+Y8YC24FG4Bfp+QEUqFwEmAMcBJpwR4tRAyyTMXnAeqAB+OIyptdxr1HlCsBkYDdwF+ghM1qA9x73nwCHgXnAOqDPuLcpm4seA2wFrgGdLsZ3ABeAjfKjP38PIMob4CRQnOa5543fa9V2DOaiRwKlQB3w2cV47bc3gApggrFDKuR6t8u4NuCiuMIIDxvygXZj3LHBWHgxUA289vDP+0AVMMPYIWWyKLe/eqeIUg6MzsAenQ6T/AQWxLHo+bKgZo+t+lSEWZhmh3zyESsBTAppmw6aj405r0e16HxR96Ej2Ji8lNRW5BhbID7pxiMRdFZEtq6NLCAC24CbHv75ATgLrPGY40Caca2yQxaHNs7b7oYBB0T6U0s6tN9e0soGOXoChY6DS03YhQV41jhgh5wQTfaFmSzhIcBlYDMwKsA804Dbjl0zJewiXfx+g6TBry4210YpgG+KAqYa6e03/1MXUQY65XNYikyAeuCQT+TXqbAWuAV0+RikT4XLQ9ik3em4vEO40Sy21kcpQLVxfakEMB31B8IDr4ONw4USkiLdMtBbSbErjHHVsQhgAqyUB2u/DkOlRzArFxfqCnNCHBQBkhhvbdqgbxkI8FHHiwzmCHxCHFQBTICJwE6f84PJFeCcxztEt8yl55yoApI1AdL4r84Gdzz8140mOSHOVCHICQFCvEO0iOGL1ADJOQFMgBLZFUn05xIVITktQBoD457fCqBCKJiwOyCFdQEVr4/aGKDiFdjGABVCwYSNASlsDFDx+qiNASpegW0MUCEUTNgYkMLGABWvj9oYoOIV2MYAFULBhI0BKYZ9DOiR7+0qMvlqOgMfjURgaaXT3SdXHTXJ2ijL4x1Gg1NetgWQgkqy0UrbFrgC5QuwJUCDRJ1Xg0RcAuhn+pTl+qSeWBmkBhlFgfKNlKuXxCWAtNscAV7gzjOZu1DFAcGbpLShswcqADA9gPjvZDeUxrLoCNrk/uv88hLAUR12c792KaSWZb1LnGCNksnKrs4k450C6GpvBv2Df+dQuQjBWmXbpA6YpEWupaNHeox2he0fzBoEa4UNHUeGFPS3y1dFmUmGLPz7DxN60WeAVdm2y2KxWCwWNbz4AzvNdoFLA4cbAAAAAElFTkSuQmCC">
    			<home box="text">打包紀錄</home>
    			
    		</home>
    		
    		<?php } ?>
    		
    	 <?php if($_SESSION["signIn"] == "yes"){ ?>
    		
    		<home box="item" go="sign" action="ShortData" function="sign" option="signOut">
    			
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAECklEQVR4nO2a228VVRTGp2ihBUKh9KKQGqWJCXjBF6MJr6ZIhEBJeAAfCYgPhaYhGl+E+EJSjIkk/CFWKBASFZBbqRVUsKUlXmqUEH0FapWfWe03dnO6ZzpzOlPmJHzJSebMWnvt9e3Ze83aa08QPEYyAPPtF1QygAVAj34LgqICeAKYFyGrAXqZwgmgNsZOVe4OR3S8ExgF+j3yhcBppsPuLfToD8jWTrM9VyTagBuOc8dK5IuBLyX73dELr78ynZI2Jx2968AbeRJ4EjgI/KsOfwJ2u1MLWOSQ+ANY4zj4vEbd8DWwxGlXBWwDbkr+APg08yABNAEX1cnfwPtAdYnOUuCSdH4BWnV/ArpulQzpLi2xUQ18AIxL5wLQmBWJZuB7x8F1Hh0jcVk6PwOrHNn/RPT/GWBEt21tNHjsvQrcks6PwIrZkngaGJTBq77RsXuSoanRUiJ/iIjutTjTKMpuE/CdQ+apcknYYz4vQ/1AfYReX9zI+Yjo/gq1MfRF2G7QUzOctXVaDpFPnKmyPEbvoog2R8i9RJxpa20vxNhvBH6VmcNpSbypyDEGvJaqcQoiKWy8Ll/Mp7Y0YTZ8T+yfjQNZETEA78nUD4mmGNChBoOlIfYRE6kGhmTu3STKt6W8abadZ0nEALQ7WUL0UwG2hiExyAhZEjFoahk2B1GwvElKHUFxiXTJ5GdRCvZ2/ge4HxduC0CkQRHM0pg6n8IG9Xkmq07zIGJQ0ok3FAMfSXgoKD6Rbpk96BOenHERFYdIu8z2+oRhgvZSBRB5RWa/9Ql/k3BlBRBpkdlRn/CuhLUVQKRWZu/6hBbSyHp7CZyzFDyHMpPhvk/414QoYt9RJDCZ2hvu+IThjm11UHAAL8jXQZ/weB7hNw8wlRP2+IQfS/hhUHAwWZYydPuEWyT8Iig4gDPydaNPuMxJGh+qNxUJQL2TNC6JUjolpruCggLYIx+Pxym9LaVphekigMnSalge2j7TiyZMVdYHBQOwUb6Nznje4uzABuasxJ+8unNNvu1N0qDGqc3uCwoCpgZ4KPHpl7NbtETy5dy9TJa235NPbWkbH3VGILM9fJl51bB8OVKOAZtiV5yzjEW5eBrvw2LnuOJy2QeqGo3wWKEvs0OX5C++8+p7JKpInsbgc86jtWm2NjNv49fEsPq0rPzZrAw3O9PMAkBnWWcVyUJsl7OwbTo1Zd1JjRMAwpOmDRm+sd9y3hMTCzvXjwx0dhI+dsM3wDuWdJa5DvY4aUc4ldKF2Fk+nU4nnUEZqaXXB1R3sl3c8vBbFF2/qE3RAemGdYIw7dj7SD71UG62Q59n2BYgLca1M91emG9VgDo7U1E583MddP6pUR/T9Q19YNMtXf9+4jGCysd/dWVhhPSyhmcAAAAASUVORK5CYII=">
    			<home box="text">檢體送出</home>
    			
    		</home>
    		
    		<?php }
          if($_SESSION["signOut"] == "yes"){ ?>
    		
    		<home box="item" go="sign" action="ShortData" function="sign" option="signIn">
    			
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAD/ElEQVR4nO2aS6xOVxTHt+e98Sh6qUTT0KFoPFJDaSIRbVO0zDCWGnHpwESQmMiNkYTotDNGcuVqOvFIWqFFNFGvi1AdlYiRusj9NYv/Zuc453z7nLO/6xP+o/Nl77X2+p+z12Ov/Tn3Hu8YgDPAadfJAEYDq4BjwI8Fc56jYOwnYABYabrcSAMYD2wFbnlDgb9qELkZyNtzLzCu7QS0+BdmdGDAdRnwQQ0iU4AtwGCg7xKwpJ0EuoCDwLAWvAJ802pLlBHJbNEVwFVNtzUO2JdPTeJD4IQWeQLsMWKRsi2JBHPHAduA/yT2KzC9MQEp/xS4JsV/AwsqykcT8QAWAf8EX36OS/AlPIk/gU9q6KhMxADMAs4FZKa5BpHppBSZwkk19dQiYgAmAxek4ngtn5Fj++00q7KCBEQMwMfAXak54GqE2GE5XSWfSE3EACyULcPRoVlbyueJ7VFCbSZiAHYGeaZ10gR+kMDlFHE8IZGuIM9sbjV5DHBbk7+OXGCaRbe6RICe2FzBi6Tpy5niRAx8p4nGfFSk8jvAvSJfKiNiMsC/5syRa41WSWRYWTbxF03aFKNYMockk0umiIhImIzhcIX1eiXzc9GEiSo/ngJTKyi24NBfRCaPSIZEfxVfBKbKxiFgQt6EZVJ8NlZphswRyT8APi8ikiFxLLZmCwH8IfmleYO7NdjnaqCITEgkBQkDsFc6drkS//jW1UTeNvNEmmynkqD0up8ExeHLbZGIjEcSEgZgsXRdcVkADzU42zVEhkyIxiQMZqPfwi4LRSxyI0Fzn2nkE1mYjdI5lDdo4YyUx8vgy/Qn1tslWx/nDd7XYE+qBQMySc/ewHTvd3mDPvXPdR0OYJ5svZo3ONA0/I4UgDU+eJQlmR2uwwHsKkzeQZI57jocwCnZuqLoXPHMIkGVonGkwYvOzpAKx9zuZlimbHAdCmCjbBwom7Rek865DgQwKmgPrW2VaHyH70vXYeDVUfduyypB1wWI+RjXIQDGqtsZd4IFuoEbUd2KEQSvXvC16JrNOigSegTMb7uV8Q06w/KqwvuDN5C0/qpox4zgImhfHQXdwdnYLjQntsXSchsmWQ9BNpytfQzQ2/Ddvd/td3JryxPfb1rbfHZmiouewWCbNWpqV/CJQa15vfFFT6B4ZrDNHqlJNjaJ8tdD7NbAsW07fZR6ke4gABguxvaHIzO2Xaz6PPHcsVMdjYsW/SpznXwe+L7O1Zj8YGNQdvitVC3ENvw6vUE5gyrSU7rHWK1TXI8/6ur5Mx2Kdmqu7xP4smNTW79Ci9psnTXKdASoiqc6ma59IwRK/sVg/ynpA47qJva+3vqQni+ro9Knufnnifdwbz/+B5xnoKu7apXYAAAAAElFTkSuQmCC">
    			<home box="text">檢體送達</home>
    			
    		</home>
    		
    	 <?php } ?>
    	 
    	 <!-- <home box="item" go="set" action="ShortData" function="recode">
    			
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAABMElEQVR4nO2XQUoDQRBFaxcXQYjnUYghXkPwFOLCnCiCxBsYXOkVJHvXgSyfzFCLEMikqe6eqZB60Kv5XVW/P7UYkSAYFuCL/lnXMDIIUstI8cJ99yOMOHk4hlny8kuPE6SUkexCQ/cnjJSB3Id0suT5S49TxGpEnEAYUcQJWOcJI5UgElHECVjnCSOVIBJRxAlY5wkjleAiEyH/HyT5f6FqL8owTjBxXaKRnDKS+qoHd9/0+jRBO1Pt0tirxS7oLv6k198TtB+qffRo5ArYaInnDt2Lan6BkTsjDcAdsNMyK+C+2Rk9s70kGs2tGKG2Ea3xAPxxnObbPLNHi12Q3ugGWAA/wFbPN/AKTArUb7ELnMCpOcNIzxCJOINIxBlcXCLngnQYWXM+fFYKPAhkj3/01XF7kP7fWAAAAABJRU5ErkJggg==">
    			<home box="text">過去紀錄</home>
    			
    	</home> -->
    	 
    	  <home box="item" go="set" action="Plant" function="setting">
    			
    			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAC20lEQVR4nO2av2sUQRTHN+QwaLwTwWjhD4QENBExRtGIpdhor5YG/QMisYsKElA06F+glZ1BLGwVLDRiEW0tRDGHwsVKiyTeJfeRgRdYxs3u/MrtXswXrrq3b+azO2/m7XsbRRv6DwTcA5b5Vw1gLGoXAVVW14eoHQRUgGYKyCJQioouYJhsHcxzgvuAa0BPht2IAciFDB89wCiwNzTEfuCrTKIGnE+xnTQAuZ1y/Rngu9ipWOsLBdGXELwqBh4AXZrtduCNAcgroKxdu0lugh5fs0DvWkDE9REYkLh4DvzBXPPAE+AwcACYSbF1hwH2ZECsqI6f1BNYMLCbBXa7gJgEbat12QVkC/CJ4ugzsNUaRGCOBVg6IdQATjpBxGBu5U0B3PCCEJASMJ0jxFug0xsktg3nscTmvc8QDeQU+WgZOBQS5IXlBFQaMw4MAt3yO6rWuvxno0ehIHbKrmGqp3r6ofkrA1MW/n4Bm13fJ1TKcVXyqfeWEB0GY3RYwrwG7sshfSLtRinndyUNcFUtdYDkGzbnMd43Neckx0v4adwUIjbmTc8xl5Kcpr2emuiIA4jaAHzUXAsQ6zxIAr9wIGUHkEoRQQaLsrTqrU7sAiSk9SSn11XxTOpOrdh+twE/HcdalLmOZWW76j38InDHsJiwoimLA/GZhd+XwIQqIwH9TgU+hxRFwVQynoQNxG+nFCVQ0jgnh92Q2pblNyQxYbucHgeByDmNb4ZO4wcsl1coLaiaVyiILinE5aUZVYUMAfKQ/DXpC3E2wIkfQk3gnCvEDuAHxVEN2OUConohRdOoa2PHpIhtU4H3KWJX1ZysQQzbCu/EZlhOa9e2Qm9GEbDq3fBZBaYhp3QpodEzbVhM0Bs9nVIu0rPwoF2reOvtC3Dac7ueSLn+eKwLEA5Ca/yockx3ht0VA5BLBi2NEafGTovzsv6o6GK9fDCwbj7hiFUt2/+jmg1F7voLIPGx/CY2I0YAAAAASUVORK5CYII=">
    			<home box="text">設定</home>
    			
    		</home>
    		
    		
    	</home>	
    	
    </home>
	</body>
</html>

<!--未登入畫面-->
<?php } else { ?>
    
<html>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/home.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/an-skill-bar.css">
		<link rel="stylesheet" href="css/skillBar.css">
		<link rel="stylesheet" href="css/Dashboard.css">
    <link rel="stylesheet" href="use/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="use/jquery-ui.css">
    <script src="use/jquery-3.7.1.min.js"></script>
    <script src="use/jquery-ui.min.js"></script>
    <!--<script src="js/jquery-3.6.0.min.js"></script>-->
    <script src="js/an-skill-bar.js"></script>
    <script src="use/anime.min.js"></script>
    <script src="js/crypto-js.min.js"></script>
    <script src="js/statistics.js"></script>
    <script src="js/Dashboard.js"></script>
    <script src="js/main.js?v=<?php echo date('His') ?>"></script>
    <script src="use/jquery-latest.min.js"></script>
		<script type="text/javascript" src="js/jquery-barcode.js"></script>
		<script src="use/chart.js@2.8.0"></script>
	</head>
	<body>
    <bar box="bar">
        <bar box="title">
            <bar box="logo"><img src="image/OsunLogo2018.JPG"></bar>
            <bar box="company">咸陽科技股份有限公司<br>Osun Technology Co., Ltd.</bar>
        </bar>
    </bar>
    <space box="space"></space>
    <message box="message">
    	
    	<message box="window">
    		
    		<message box="error">請先登入</message>
    		<message box="button" pos="login">登入</message>
    		
    	</message>
    	
    </message>
    </body>
</html>
<?php } ?>