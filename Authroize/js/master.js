/*正則表達*/
var usernamePattern = /^[a-zA-Z0-9]{6,12}$/; 
var usernameCNPattern = /^[a-zA-Z0-9\u4e00-\u9fa5]{2,12}$/;
var passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/;
var emailPattern	= /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
//var companyPattern = /^[A-Za-z]+$/;

$(document).ready(function(){
	
	var $pm = $("workeare");
	
	/*PHP轉HTML*/
	BuildHtml = {
	
		$pubVar						: new Array,
		jsonLoad					: function($e)
		{
				
			$load = this.$pubVar["encode"] + "/" + $e.attr("connectime") + "." + this.$pubVar["encode"];
			$.getJSON($load, function($J){
				
				BuildHtml.$pubVar["Json"] = $J;
				
			});
			
		},
		
		dataLoad						: function($e,$J)
		{
			$J.appendHtml && this.setHtml($e,$J.appendHtml);
			$J.attrHtml		&& this.setAttr($e,$J.attrHtml);
		},
		setHtml 						: function($e,$J)
		{
			for(i in $J)
				!isNaN(i) ? $e.append("<" + $J[i] + " />") : this.setHtml($e.find(i),$J[i]);
		},
		setAttr							: function($e,$J)
		{
			for(i in $J)
			{
				for(j in $J[i])
				{
					$(i).attr(j,$J[i][j]);
				}
			}
		},
		parseAttr						: function($e)
		{
			$e.find("*").each(function()
			{
				$(this).attr("insertHtmlText")	&&	$(this).html($(this).attr("insertHtmlText"));
				$(this).attr("insertBase64")		&&	$(this).html("<img src=" + $(this).attr("insertBase64") + ">");
	
			});
		}
		
	}
	
	/*加密解密*/
	Crypt = {
		JSAesEncrypt					: function($e)
		{
			var sa 															= CryptoJS.lib.WordArray.random(256);
			var iv 															= CryptoJS.lib.WordArray.random(16);
			var key 														= CryptoJS.PBKDF2("public", sa, { hasher:CryptoJS.algo.SHA512,keySize:64/8,iterations:999 });
			var encrypted 											= CryptoJS.AES.encrypt($e,key,{iv: iv});
			var data = {
				decrypt_string 		: CryptoJS.enc.Base64.stringify(encrypted.ciphertext),
				sa 								: CryptoJS.enc.Hex.stringify(sa),
				iv 								: CryptoJS.enc.Hex.stringify(iv) 
			}
		  return JSON.stringify(data);
		},
		JSAesDecrypt					: function($J,$encrypt)
		{
		  var sa 															= CryptoJS.enc.Hex.parse($J.sa);
		  var iv 															= CryptoJS.enc.Hex.parse($J.iv);   
		  var key 														= CryptoJS.PBKDF2("public",sa,{ hasher:CryptoJS.algo.SHA512,keySize:64/8,iterations:999});
		  var decrypted 											= CryptoJS.AES.decrypt($encrypt, key, { iv:iv});

		  return decrypted.toString(CryptoJS.enc.Utf8);
		}
	}
	
	/*登入*/
	$(document).on("click", "msu-button[class=login][id=login]", function(){
		
		var $requestForm = $("form[class=master-login][name=master-login]");
		
		$.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), $requestForm.serializeArray(), function($Json){
			
			var $J = JSON.parse($Json);
			
			//console.log($J);
			
				if($J.status == "error"){
					
					
				
				}else{
				
					$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$J.redirect), function($Json)
					{
						
						var $J = JSON.parse($Json);
			
						$viewMain 											= $($J.appendPos);
						$viewMain.html("");							
						BuildHtml.dataLoad($viewMain,$J);
						BuildHtml.parseAttr($viewMain);
						
					});	
				}
			
		});
		
	});
		
	/*首頁功能*/
	$(document).on("click", "shortcut[class=shortcut-name]", function(){
		
		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), function($Json){
			
			var $J 													= JSON.parse($Json);
			$viewMain 											= $("main-container[class = main-container]");
			$viewMain.html("");							
			BuildHtml.dataLoad($viewMain,$J);
			BuildHtml.parseAttr($viewMain);
					
		});
		
	});
	
	/*側邊主選單功能*/
	$(document).on("click", "sideMenu[class=item-container]", function(){
		
		if(!$(this).attr("Exece")){
			
			$openid = $(this).attr("id").split("_");
			$open		= "detial[class=detial-container][id=" + $openid[1] + "]";
			$down		= "sidemenu[class=item-page][photo=" + $(this).attr("id") + "_" + $openid[1] + "]";
			
			/*if($($open).css("display") == "none"){
				
				$($open).css("display", "flex");
				
				if($($down).html() != ""){
					
					$($down).html("");
					$($down).html("&#xf0d7;");
					
				}
				
				
			}else{

				$($open).css("display", "none");
				
				if($($down).html() != ""){
					
					$($down).html("");
					$($down).html("&#xf0da");
					
				}
				
			}*/
			
			if ($($open).css("display") == "none") {
				
    		 $($open).slideDown(500, function() {
    		 	
        		if ($($down).html() != "") {
        			
            	$($down).html("").html("&#xf0d7;");
            	
        		}
    		 });
    		 
    		 $($open).css("display", "flex");
    		 
			} else {
    		
    		$($open).slideUp(500, function() {
        	if ($($down).html() != "") {
        	
            	$($down).html("").html("&#xf0da");
            
        	}
   			 });
			}
			

		}else{
			
			$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("Exece")), function($Json){
				
				var $J	= JSON.parse($Json);
				
				if($J	== "reload")
				{
					
					window.location.reload();
					
				}
				
			});
			
		}
		
	});
	
	/*側邊子選單功能*/
	$(document).on("click", "detial[class = detial-caption]", function(){
		
		$openID	= $(this).attr("id");
		$open	= "detial[class = detial-name][id = " + $openID + "]";
		
		//console.log($open);
		
		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$($open).attr("exece")), function($Json){
			
			var $J 													= JSON.parse($Json);
			$viewMain 											= $("main-container[class = main-container]");
			$viewMain.html("");							
			BuildHtml.dataLoad($viewMain,$J);
			BuildHtml.parseAttr($viewMain);
					
		});
			
		
	});
	
	/*呼叫修改刪除功能*/
	$(document).on("click", "detial_button[id = open_function]", function(){
		
		switch($(this).attr("cell"))
		{
			
			case "delete":
			
				$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), function($Json){
			
					var $J 													= JSON.parse($Json);
					console.log($J);
					
					$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$J), function($Json){
						
						var $J 													= JSON.parse($Json);
						$viewMain 											= $("main-container[class = main-container]");
						$viewMain.html("");							
						BuildHtml.dataLoad($viewMain,$J);
						BuildHtml.parseAttr($viewMain);	
						
					});
			
				});
			
				break;
				
			case "update":
			
				$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), function($Json){
			
					var $J 													= JSON.parse($Json);
					console.log($J);
					$viewMain 											= $("main-container[class = main-container]");
					$viewMain.html("");							
					BuildHtml.dataLoad($viewMain,$J);
					BuildHtml.parseAttr($viewMain);
					
				});
			
				break;
			
		}
		
	});
	
	/*確認修改與新增功能*/
	$(document).on("click", "update-button[class = update]", function(){
		
		var $requestForm = $("form[class = user-update]");
		$.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), $requestForm.serializeArray(), function($Json){
			
			console.log($Json);
			
			var $J = JSON.parse($Json);
			
			if($J.status == "error")
			{
				
				$("mask").css("display", "flex");
				$("html").css("overflow-y", "hidden");
				
				$viewMain 											= $("mask");
				$viewMain.html("");							
				BuildHtml.dataLoad($viewMain,$J);
				BuildHtml.parseAttr($viewMain);	
				
			}else{
				
				$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$J.reload), function($Json){
					
						var $J 													= JSON.parse($Json);

						$viewMain 											= $("main-container[class = main-container]");
						$viewMain.html("");							
						BuildHtml.dataLoad($viewMain,$J);
						BuildHtml.parseAttr($viewMain);	
						
				});
				
			}

		});

	});
	
	/*關閉錯誤提示*/
	$(document).on("click", "viewFlow[class = ill-close]", function(){
		
		$("mask").css("display", "none");
		
	});
	
	/*獲取新增頁面*/
	$(document).on("click", "toolBar[class = addData]", function(){
		
		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), function($Json){
			
			var $J 													= JSON.parse($Json);
					$viewMain 											= $("main-container[class = main-container]");
					$viewMain.html("");							
					BuildHtml.dataLoad($viewMain,$J);
					BuildHtml.parseAttr($viewMain);
					
		});
		
	});
	
	/*刪除全部*/
	
	$(document).on("click", "toolBar[class = deleteAll]", function(){
		
		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), function($Json){
			
			var $J 													= JSON.parse($Json);
					
			$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$J), function($Json){
						
				var $J 													= JSON.parse($Json);
				$viewMain 											= $("main-container[class = main-container]");
				$viewMain.html("");							
				BuildHtml.dataLoad($viewMain,$J);
				BuildHtml.parseAttr($viewMain);	
						
			});
			
		});
		
	});
	
	/*搜尋*/
	$(document).on("click", "toolBar[class = search]", function(){
		
		var $requestForm = $("form[class = search-box]");
		
		$.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), $requestForm.serializeArray(), function($Json){
			
			var $J = JSON.parse($Json);

			$MainView = $("tableContent[loc = report_table]");
			$MainView.html("");		
			BuildHtml.dataLoad($MainView,$J);
			BuildHtml.parseAttr($MainView);	

		});
		
	});
	
	/*下拉選單製作*/
	
	$(document).on("click", "input[class = selection-input]", function(){

		if($("selection[class = selection-item-container]").css("display") == "none")
		{
			
			$("selection[class = selection-item-container]").css("display", "flex");
			
		}else{
			
			$("selection[class = selection-item-container]").css("display", "none");
			
		}
	
	});
	
	$(document).on("click", "selection[class = selection-item]", function(){
			
			$("input[class = selection-input]").val();
			$("input[class = selection-input]").val($(this).attr("insertHtmlText"));
			$("selection[class = selection-item-container]").css("display", "none");
			
			$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), function($Json){
				
				var $J = JSON.parse($Json);

				$("input[class = update-input][name = productName]").val($J);
				
			});
			
	});
	
	/*頁碼*/
	$(document).on("click", "page", function($Json){

			$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), function($Json){
			
				var $J = JSON.parse($Json);

				$MainView = $("main-container[class = main-container]");
				$MainView.html("");		
				BuildHtml.dataLoad($MainView,$J);
				BuildHtml.parseAttr($MainView);	
				
				$(this).css("color", "red");

			});

	});
	
	/*手機板菜單收合*/
	$(document).on("click", "bar[class=bar-openside]", function(){
		
		if($("sideMenu[class=sideMenu-container]").css("display") == "flex")
		{
			
			$("sideMenu[class=sideMenu-container]").animate({
				
            left: "-100%"
            
        }, 500, function() {
        	
           $("sideMenu[class=sideMenu-container]").css("display", "none");
        
        });
			
		}else{
			
			 $("sideMenu[class=sideMenu-container]").css("display", "flex");
			 
        $("sideMenu[class=sideMenu-container]").animate({
        	
            left: 0
            
        }, 500);
			
		}
		
	});

	BuildHtml.$pubVar["encode"]							= "json";
	BuildHtml.jsonLoad($pm);
	setTimeout(function()
	{
		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"], BuildHtml.$pubVar["Json"].master_url), function($Json){
		
			//console.log($Json);
			var $J = JSON.parse($Json);

			$MainView = $("workeare");
			BuildHtml.dataLoad($MainView,$J);
			BuildHtml.parseAttr($MainView);																					
		
		});
		
	},100);

});