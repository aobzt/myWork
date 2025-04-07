/*正則表達*/
var usernamePattern = /^[a-zA-Z0-9]{6,12}$/; 
var usernameCNPattern = /^[a-zA-Z0-9\u4e00-\u9fa5]{2,12}$/;
var passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/;
var emailPattern	= /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
//var companyPattern = /^[A-Za-z]+$/;


$(document).ready(function(){
	
	var $pm = $("body");
	
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
	
	$(document).on("click","login-button[id = login-button]", function()
	{
	
		var $requestForm = $("form[id = login-form]");
		var errorMessage = $("login-container[id = error-message]");
		//var username = $("input[id = username]").val();
		var password = $("input[id = password]").val();
		var email = $("input[id = email]").val();
		
		if(passwordPattern.test(password) && emailPattern.test(email) || email == "99" && password == "000"){
		
			//console.log($requestForm.url);
		
			$.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("login-button[id = login-button]").attr("url")),$requestForm.serializeArray(), function($Json)
			{
				var $J = JSON.parse($Json);

				if($J.status == "error"){
					
					errorMessage.show();
					errorMessage.text("*錯誤的信箱或密碼*");
					$("login-container[id = error-message]").css("color", "red");
					$("login-container[id = error-message]").css("font-size", "15px");
					//$("login-container[id=error-message]").css("margin", "2px");
				
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
		}else{
			
			errorMessage.show();
			errorMessage.text("*錯誤的信箱或密碼*");
			$("login-container[id = error-message]").css("color", "red");
			$("login-container[id = error-message]").css("font-size", "15px");
			//$("login-container[id=error-message]").css("margin", "2px");

		}
	});
	
	/*登出*/
	$(document).on("click", "otherwindow[class = logout-button]", function(){
		
		$.get("router.php?load=RequestAjax{SignOut}", function($json){ });
		window.location.reload();
		
	});
	
	/*進入忘記密碼*/
	$(document).on("click","right-text[class = right-text_1]", function()
	{
		//var $requestForm = $("form[id = login-form]");
		$.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("right-text[class = right-text_1]").attr("url")), function($Json)
		{
			
			//console.log($Json);
			var $J = JSON.parse($Json);
			
			$viewMain 											= $($J.appendPos);
			$viewMain.html("");							
			BuildHtml.dataLoad($viewMain,$J);
			BuildHtml.parseAttr($viewMain);
			$("Body,Html").css("overflow-y","auto");
			
		});		
	});
	
	/*忘記密碼功能*/
	$(document).on("click", "fp-button[id = fp-button]", function()
	{
		var $requestForm = $("form[id = fp-form]");
		var errorMessage = $("login-container[id = error-message]");
		var email = $("input[id = email]").val();
		
		if(!emailPattern.test(email)){
			
			errorMessage.show();
			errorMessage.text("*錯誤的電子信箱*");
			$("login-container[id = error-message]").css("color", "red");
			
		}else{
			
			errorMessage.text("");
			$.post("router.php?load=RequestAjax{CheckFGEmail}",$requestForm.serializeArray(), function($Json){
				
				console.log($Json);
				var $J = JSON.parse($Json);
				
				if($J == "error"){
					
					errorMessage.show();
					errorMessage.text("*電子信箱不存在*");
					$("login-container[id = error-message]").css("color", "red");
					
				}else{
					
					errorMessage.show();
					errorMessage.text("*請確認您的電子信箱*");
					$("login-container[id = error-message]").css("color", "green");
					
					setTimeout(function(){
			
						window.location.reload();
			
					}, 1500);
					
				}
				
				
			});
			
		}		
		
	});
	
	/*進入註冊畫面*/
	$(document).on("click", "right-text[class = right-text_2]", function()
	{
		//var $requestForm = $("form[id = login-form]");
		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("right-text[class = right-text_2]").attr("url"))/*,$requestForm.serializeArray()*/, function($Json)
		{
			
			//console.log($Json);
			var $J = JSON.parse($Json);
			
			$viewMain 											= $($J.appendPos);
			$viewMain.html("");							
			BuildHtml.dataLoad($viewMain,$J);
			BuildHtml.parseAttr($viewMain);
			$("Body,Html").css("overflow-y","auto");
				
		});		
	});
	
	/*註冊功能*/
	
	$(document).on("click", "reg-button[id = reg-button]", function()
	{
		
		var $requestForm = $("form[id = reg-form]");
		var PTerrorMessage = $("login-container[id = error-message-buttom]");
		var UNerrorMessage = $("custom-label[id = error-message-username]");
		var EMerrorMessage = $("custom-label[id = error-message-email]");
		var PWerrorMessage = $("custom-label[id = error-message-password]");
		var RePWerrorMessage = $("custom-label[id = error-message-ReKey-password]");
		
		var termsCheckbox = $("input[id = terms-checkbox]");
		var privacyCheckbox = $("input[id = privacy-checkbox]");
		var username = $("input[id = username]").val();
		var password = $("input[id = password]").val();
		var email = $("input[id = email]").val();
		//var company = $("input[id = company]").val();
		var rekeypassword = $("input[id = ReKey-password]").val();	
		
		/*if(!companyPattern.test(company)){
			
			errorMessage.show();
			errorMessage.text("Invalid company name.");
			$("login-container[id = error-message]").css("color", "red");
			
		}*/
		PTerrorMessage.text("");
		
		if(username == "" || password == ""|| email == "" || rekeypassword == ""){
			
			PTerrorMessage.show();
			PTerrorMessage.text("*不可有欄位為空*");		
			$("login-container[id = error-message-buttom]").css("color", "red");
		
		}else if(password != rekeypassword){
		
			PTerrorMessage.show();
			PTerrorMessage.text("*密碼不相符*");		
			$("login-container[id = error-message-buttom]").css("color", "red");

		}else if(!termsCheckbox.is(":checked")){
		
			PTerrorMessage.show();
			PTerrorMessage.text("*請勾選使用者條款*");		
			$("login-container[id = error-message-buttom]").css("color", "red");
		
		}else if(!privacyCheckbox.is(":checked")){
			
			PTerrorMessage.show();
			PTerrorMessage.text("*請勾選隱私權政策*");
			$("login-container[id = error-message-buttom]").css("color", "red");
			
		}
		
		if(termsCheckbox.is(":checked") && privacyCheckbox.is(":checked") && rekeypassword == password && passwordPattern.test(password) && emailPattern.test(email) && usernamePattern.test(username) && password.length >= 8 && username.length >= 6 && username.length <= 12){
			
			$.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("reg-button[id = reg-button]").attr("url")), $requestForm.serializeArray(), function($Json){		
			
					var $e = JSON.parse($Json);
					
					if($e.status == "email is pass!"){
					
						$.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$e.redirect), $requestForm.serializeArray(), function($Json)
						{
							console.log("test");
							var $J = JSON.parse($Json);
					
							if($J == "password_error"){
			
							PTerrorMessage.show();
							PTerrorMessage.text("*密碼已被使用*");
							$("login-container[id = error-message-buttom]").css("color", "red");
							$("login-container[id = error-message-buttom]").css("font-size", "20px");
				
				
							}else if($J == "email_error"){
			
								PTerrorMessage.show();
								PTerrorMessage.text("*電子信箱已被使用*");
								$("login-container[id = error-message-buttom]").css("color", "red");
								$("login-container[id = error-message-buttom]").css("font-size", "20px");
				
				
							}else if($J == "success"){
						
								PTerrorMessage.show();
								PTerrorMessage.text("*註冊成功！*");
								$("login-container[id = error-message-buttom]").css("color", "green");
								$("login-container[id = error-message-buttom]").css("font-size", "20px");
						
								setTimeout(function(){
			
									window.location.reload();
			
								}, 1500);
						
						}
					
				
						});
						
					}else if($e.status == "error"){
					
						EMerrorMessage.text("*請驗證電子信箱*");
						$("custom-label[id = error-message-email]").css("color", "red");
					
					}
								
				});
		}	
				
	});
	
	$(document).on("blur", "input[id=username]", function() {
		
		var errorMessage = $("custom-label[id = error-message-username]");
		$("custom-label[id = error-message-username]").css("color", "red");
		$("custom-label[id = error-message-username]").css("font-weight", "normal");
		$("custom-label[id = error-message-username]").css("margin-left", "4px");
				
		if($(this).val().length < 6 || $(this).val().length > 12){
			
			errorMessage.show();
			errorMessage.text("*使用者名稱必須在6~12個字元*");
			
		}else if(!usernamePattern.test($(this).val())){
			
			errorMessage.show();
			errorMessage.text("*使用者名稱不能包含特殊字符*")
			
		}else{
			
			errorMessage.text("");
      
    }
        
  });
	
	$(document).on("blur", "input[id=email]", function() {
		
		var errorMessage = $("custom-label[id = error-message-email]");
		$("custom-label[id = error-message-email]").css("color", "red");
		$("custom-label[id = error-message-email]").css("font-weight", "normal");
		$("custom-label[id = error-message-email]").css("margin-left", "4px");
				
		if(!emailPattern.test($(this).val())){
			
			errorMessage.show();
			errorMessage.text("*錯誤的電子信箱*");
			$("span[id = Verify-email]").hide();
			
		}else{
			
			errorMessage.text("");
      $.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("input[id=email]").attr("url")), {email: $(this).val()}, function($Json){
        	
        	//console.log($Json);	
        	var $J = JSON.parse($Json);
        	
        	if($J == "error"){
        		
        		errorMessage.text("*電子信箱已被使用*");
						$("span[id = Verify-email]").hide();
        		
        	}else{
        		
        		errorMessage.text("*請驗證信箱*");
        		$("span[id = Verify-email]").show();
        		
        	}
        	
      });
        //showIcon();
    }
        
  });
  
  $(document).on("click", "span[id = Verify-email]", function(){
  	
  	$("custom-label[id = error-message-email]").css("color", "yellow");
		$("custom-label[id = error-message-email]").css("font-weight", "normal");
		$("custom-label[id = error-message-email]").css("margin-left", "4px");
  	
  	var errorMessage = $("custom-label[id = error-message-email]");
  	/*errorMessage.hide();*/
  	errorMessage.text("*請至電子信箱收取驗證信件*");
  	
  	$.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("span[id = Verify-email]").attr("url")), {email: $("input[id=email]").val()}, function($Json){ });	
  	
  	setTimeout(function() {
        errorMessage.text("");
    }, 2000);
  	
  });
  
  $(document).on("blur", "input[id=password]", function() {
		
		var errorMessage = $("custom-label[id = error-message-password]");
		$("custom-label[id = error-message-password]").css("color", "red");
		$("custom-label[id = error-message-password]").css("font-weight", "normal");
		$("custom-label[id = error-message-password]").css("margin-left", "4px");
				
		if($(this).val().length < 8){
			
			errorMessage.show();
			errorMessage.text("*密碼不能少於8個字元*");
			
		}else if(!passwordPattern.test($(this).val())){
			
			errorMessage.show();
			errorMessage.text("*密碼必須包含：至少一個大寫字母、至少一個小寫字母與至少一個數字*");
			
		}else{
		
      $.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("input[id=password]").attr("url")), {password: $(this).val()}, function($Json){
        	
        	//console.log($Json);	
        	var $J = JSON.parse($Json);
        	
        	if($J == "error"){
        		
        		errorMessage.text("*密碼已存在*");
        		
        	}else{
        		
        		errorMessage.text("");
        		
        	}
        
      });
      
    }
        
  });
	
	/*再次輸入密碼*/
	$(document).on("input", "input[id = password]", function(){
		
		var password = $(this).val();
		
		if(password.trim() != ""){
			
			$("login-container[id = ReKey-password-label]").show();
			$("input[id = ReKey-password]").show();
			/*$("custom-label[for = ReKey-password]").show();*/

		}else{
			
			$("login-container[id = ReKey-password-label]").hide();
			$("input[id = ReKey-password]").hide();
			/*$("custom-label[for = ReKey-password]").hide();*/
			
		}
		
	});
	
	$(document).on("blur", "input[id=ReKey-password]", function() {
		
		var errorMessage = $("custom-label[id = error-message-ReKey-password]");
		$("custom-label[id = error-message-ReKey-password]").css("color", "red");
		$("custom-label[id = error-message-ReKey-password]").css("font-weight", "normal");
		$("custom-label[id = error-message-ReKey-password]").css("margin-left", "4px");
				
		if($(this).val() != $("input[id=password]").val()){
			
			errorMessage.text("*密碼不相符*");		
			
		}else{
			
			errorMessage.text("");
      
    }
        
  });
  
	/*使用者條款與隱私權聲明*/
	
	$(document).on("click", "right-text[class = right-text_terms]", function()
	{
		
		window.open("otherwindow/terms.php", "_blank");
			
	});
	
	
	$(document).on("click", "right-text[class = right-text_privacy]", function()
	{

		window.open("otherwindow/privacy.php", "_blank");
	
	});
	
	/*查看輸入密碼*/
	$(document).on("click", "span[id = toggle-password]", function(){
		
		var passwordInput = $("input[id = password]");
    var togglePassword = $("span[id = toggle-password]");

       if (passwordInput.attr("type") == "password") {
       	
                passwordInput.attr("type", "text")
                togglePassword.html('&#x1F441;'); 
                
            } else {
            	
                passwordInput.attr("type", "password");
                togglePassword.html('&#x2014;'); 
                
            }
		//&#x2014; 閉眼
		
	});
	
	/*進入修改密碼*/
	$(document).on("click", "main-userinfo[class = changepassword]", function(){
		
		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("main-userinfo[class = changepassword]").attr("url"))/*,$requestForm.serializeArray()*/, function($Json)
		{
			
			console.log($Json);
			var $J = JSON.parse($Json);
			
			$viewMain 											= $($J.appendPos);
			$viewMain.html("");							
			BuildHtml.dataLoad($viewMain,$J);
			BuildHtml.parseAttr($viewMain);
			$("Body,Html").css("overflow-y","auto");
				
		});
		
	});
	
	/*修改密碼功能*/
	$(document).on("click", "ch-button[id=ch-button]", function(){
		
		var $requestForm = $("form[id=ch-form]");
		var Oldpassword = $("input[id=SU-password]").val();
		var Newpassword = $("input[id=new-password]").val();
		var ReNewpassword = $("input[id=re-new-password]").val();
		var errorMessage = $("login-container[id=error-message-buttom]");
		
		errorMessage.css("color", "red");
		errorMessage.css("font-weight", "normal");
		errorMessage.css("margin-left", "4px");
		
		errorMessage.text("");
		
		if(Newpassword.length < 8){
			
			errorMessage.show();
			errorMessage.text("*密碼不能少於8個字*");
			
		
		}else if(!passwordPattern.test(Oldpassword)){
		
			errorMessage.show();
			errorMessage.text("*您輸入的舊密碼有誤*");
			
		}else if(!passwordPattern.test(Newpassword)){
			
			errorMessage.show();
			errorMessage.text("*密碼必須包含：至少一個大寫字母、至少一個小寫字母與至少一個數字*");
			
		}else if(ReNewpassword != Newpassword  || !passwordPattern.test(ReNewpassword)){
			
			errorMessage.show();
			errorMessage.text("*密碼不相符*");
			
		}else if(Newpassword == Oldpassword){
			
			errorMessage.show();
			errorMessage.text("*新舊密碼不能相同*");
			
		}else{
			
			$.post(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("ch-button[id=ch-button]").attr("url")),$requestForm.serializeArray() , function($Json){
				
				//console.log($Json);		
				var $J = JSON.parse($Json);
				
				if($J	== "SU-error"){
					
					errorMessage.show();
					errorMessage.text("*您輸入的舊密碼有誤*");
					
				}else if($J == "new-error"){
					
					errorMessage.show();
					errorMessage.text("*您使用的新密碼已存在*");
					
				}else{
					
					errorMessage.show();
					errorMessage.text("*修改成功！*");
					
					errorMessage.css("color", "green");
					errorMessage.css("font-size", "20px");
						
					setTimeout(function(){
			
						window.location.reload();
			
					}, 1500);
		
				}
								
			});
		}
		
	});
	
	/*修改使用者名稱*/
	$(document).on("click", "main-userinfo[class = ID-pencil]", function(){
		
		var usernameElement = $("main-userinfo[class = ID]");
    var usernameValue = usernameElement.text();
    var usernameInput = $("<input>", {
    	
        type: "text",
        name: "username",
        value: usernameValue, 
        id: "changeName",
        //url: Crypt.JSAesEncrypt("router.php?load=RequestAjax{ChangeID}")
        
   	});
   	
   	usernameInput.css({
   		
        border: "none",
        borderBottom: "1px solid #000",
        width: "200px",
        height: "40px" 
        
    });
    
    usernameInput.on("keydown", function(event){
    	
    	if(event.which == 13){
    		
    		if(usernameCNPattern.test(usernameInput.val())){
    		
    			var newUsername = usernameInput.val();
    			saveUsername(newUsername);
    			usernameElement.text(newUsername);
    			showIcon();   			
					$("main-userinfo[class = ID-errormessage]").hide();
    			
    		}else{
    			
    			$("main-userinfo[class = ID-errormessage]").show();
    			$("main-userinfo[class = ID-errormessage]").text("*名稱不能包含特殊字元且必須在2~12個字元*");
    			$("main-userinfo[class = ID-errormessage]").css("color", "red");
    			$("main-userinfo[class = ID-errormessage]").css("font-size", "15px");
    			
    		}
    	}
    	
    });
    
    usernameInput.on("blur", function() {
    	
        if(usernameCNPattern.test(usernameInput.val())){
    		
    			var newUsername = usernameInput.val();
    			saveUsername(newUsername);
    			usernameElement.text(newUsername);
    			showIcon();   			
					$("main-userinfo[class = ID-errormessage]").hide();
    			
    		}else{
    			
    			$("main-userinfo[class = ID-errormessage]").show();
    			$("main-userinfo[class = ID-errormessage]").text("*名稱不能包含特殊字元且必須在2~12個字元*");
    			$("main-userinfo[class = ID-errormessage]").css("color", "red");
    			$("main-userinfo[class = ID-errormessage]").css("font-size", "15px");
    			
    		}
        
    });

    usernameElement.empty().append(usernameInput);
    usernameInput.focus();

    hideIcon();
		
	});

	function hideIcon() {
    var icon = $("main-userinfo[class = ID-pencil]");
    if (icon.length > 0) {
        icon.css("display", "none");
    }
	}

	function showIcon() {
    var icon = $("main-userinfo[class = ID-pencil]");
    if (icon.length > 0) {
        icon.css("display", "inline");
    }
	}
	
	function saveUsername(newUsername){
		
		$.post("router.php?load=RequestAjax{ChangeID}", {username: newUsername}, function($Json){ });

	}

	/*change email*/
	$(document).on("click", "main-userinfo[class = email-pencil]", function(){
		
		$("main-userinfo[class = verify]").hide();
		$("main-userinfo[class = email-errormessage]").hide();
		
		console.log("test");
		
		var useremailElement = $("main-userinfo[class = email]");
    var useremailValue = useremailElement.text();
    var useremailInput = $("<input>", {
        type: "text",
        name: "useremail",
        value: useremailValue
   	});
   	
   	useremailInput.css({
        border: "none",
        borderBottom: "1px solid #000",
        width: "200px",
        height: "35px"
    });
    
    useremailInput.on("keydown", function(event){
    
    	if(event.which == 13){
    	
    		if(emailPattern.test(useremailInput.val())){
    		
    			var newUseremail = useremailInput.val();
    			
    			$.post("router.php?load=RequestAjax{CheckEmail}", {email:useremailInput.val()}, function($Json){
    
    				console.log($Json);
    				var $e = JSON.parse($Json);
    		
    				if($e == "error"){

    					$("main-userinfo[class = email-errormessage]").show();
    					$("main-userinfo[class = email-errormessage]").text("*該信箱已被人使用*");
    					$("main-userinfo[class = email-errormessage]").css("color", "red");
    					$("main-userinfo[class = email-errormessage]").css("font-size", "15px");
    			
    				}else{
    			
    					//saveEmail(newUseremail);
    					useremailElement.text(newUseremail);
    					eshowIcon();
    			
    					$("main-userinfo[class = verify]").show();
    					$("main-userinfo[class = email-errormessage]").show();
    					$("main-userinfo[class = email-errormessage]").text("*請驗證您的新信箱*");
    					$("main-userinfo[class = email-errormessage]").css("color", "#FF8B00");
    					$("main-userinfo[class = email-errormessage]").css("font-size", "15px");
    				
   					}
   				});
   				
    		}else{
    			
    			$("main-userinfo[class = email-errormessage]").show();
    			$("main-userinfo[class = email-errormessage]").text("*錯誤的電子信箱*");
    			$("main-userinfo[class = email-errormessage]").css("color", "red");
    			$("main-userinfo[class = email-errormessage]").css("font-size", "15px");
    			
    		}
    	}
    	
    });
    
    
    useremailInput.on("blur", function() {
    	
       if(emailPattern.test(useremailInput.val())){
    		
    		var newUseremail = useremailInput.val();
    			
    		$.post("router.php?load=RequestAjax{CheckEmail}", {email:useremailInput.val()}, function($Json){
    
    			console.log($Json);
    			var $e = JSON.parse($Json);
    		
    			if($e == "error"){

    				$("main-userinfo[class = email-errormessage]").show();
    				$("main-userinfo[class = email-errormessage]").text("*該信箱已被人使用*");
    				$("main-userinfo[class = email-errormessage]").css("color", "red");
    				$("main-userinfo[class = email-errormessage]").css("font-size", "15px");
    			
    			}else{
    			
    				//saveEmail(newUseremail);
    				useremailElement.text(newUseremail);
    				eshowIcon();
    			
    				$("main-userinfo[class = verify]").show();
    				$("main-userinfo[class = email-errormessage]").show();
    				$("main-userinfo[class = email-errormessage]").text("*請驗證您的新信箱*");
    				$("main-userinfo[class = email-errormessage]").css("color", "#FF8B00");
    				$("main-userinfo[class = email-errormessage]").css("font-size", "15px");
    				
   				}
   			});
   				
    	 }else{
    			
    			$("main-userinfo[class = email-errormessage]").show();
    			$("main-userinfo[class = email-errormessage]").text("*錯誤的電子信箱*");
    			$("main-userinfo[class = email-errormessage]").css("color", "red");
    			$("main-userinfo[class = email-errormessage]").css("font-size", "15px");
    			
    		}
        
    });

    useremailElement.empty().append(useremailInput);
    useremailInput.focus();

    ehideIcon(); 
    
    $(document).on("click", "main-userinfo[class = verify]", function(){
  	
  	$("main-userinfo[class = email-errormessage]").show();
    $("main-userinfo[class = email-errormessage]").text("*請至電子信箱收取驗證信件*");
    $("main-userinfo[class = email-errormessage]").css("color", "#FF8B00");
    $("main-userinfo[class = email-errormessage]").css("font-size", "15px");
  	
  	$.post("router.php?load=RequestAjax{ChangeEmail}", {email: useremailInput.val()}, function($Json){
  		
  		console.log($Json);
  		
  	});	
  	
  	setTimeout(function() {
        $("main-userinfo[class = email-errormessage]").text("");
        $("main-userinfo[class = verify]").hide();
    }, 2000);
  	
  });
	
    
		
	});

	function ehideIcon() {
    var icon = $("i[id=chemail]");
    if (icon.length > 0) {
        icon.css("display", "none");
    }
	}

	function eshowIcon() {
    var icon = $("i[id=chemail]");
    if (icon.length > 0) {
        icon.css("display", "inline");
    }
	}

	/*下載simstw*/
	$(document).on("click", "btn[id=open_detial][download=simstw]", function() {
  
    var zipUrl = "http://192.168.1.173/test/PrintBarcode.rar";

    var downloadLink = document.createElement("a");
        downloadLink.href = zipUrl;
        downloadLink.download = "PrintBarcode.rar"; 
        downloadLink.click();
        
   	$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("btn[id=open_detial][download=simstw]").attr("content")), function(){ });
        
   });
   
  /*下載LIS*/ 
  $(document).on("click", "btn[id=open_detial][download=LIS]", function() {
  
   /*var zipUrl = "http://192.168.1.173/test/PrintBarcode.rar";

   var downloadLink = document.createElement("a");
       downloadLink.href = zipUrl;
       downloadLink.download = "PrintBarcode.rar"; 
       downloadLink.click();*/
        
   	$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$("btn[id=open_detial][download=LIS]").attr("content")), function(){ });
        
  });
  
  /*上方選單功能*/
  
  $(document).on("click", "img[class = user-photo]", function(){
  
  	$("otherwindow[class = user-op]").css("display", "block");	
  	
  	$z	= $("otherwindow[class = user-op]").css("z-index");
  	$zAsInt = parseInt($z, 10);
  	
  	
  	console.log($z);
  	if($("otherwindow[class = ill]").css("z-index") >= $zAsInt){
  		
  		$INT	= $zAsInt + 2;
  		$zString	=	$INT.toString();
  		
  		$("otherwindow[class = user-op]").css("z-index", $zString);
  		
  	}
  	
  	
  });
  
  $(document).on("click", "bar[class = ill-bar]", function(){
  
  	$("otherwindow[class = ill]").css("display", "block");	
  	$z	= $("otherwindow[class = ill]").css("z-index");
  	$zAsInt = parseInt($z, 10);
  	
  	console.log($zAsInt);
  	if($("otherwindow[class = user-op]").css("z-index") >= $zAsInt){
  		
  		$INT	= $zAsInt + 2;
  		$zString	=	$INT.toString();
  		
  		$("otherwindow[class = ill]").css("z-index", $zString);
  		
  	}
  	
  	
  });
  
  $(document).on("click", "otherwindow[class = close-op]", function(){
  
  	$("otherwindow[class = user-op]").css("display", "none");	
  	
  });
  
  $(document).on("click", "otherwindow[class = close-ill]", function(){
  
  	$("otherwindow[class = ill]").css("display", "none");	

	});
	
	/*聯絡我們*/
	$(document).on("click", "bar[class = coUs-bar], right-text[class = right-text_CoUs][id = ill]", function(){
		
		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("url")), function($Json){
			
				var $J = JSON.parse($Json);

				$MainView = $("main-userinfo[class=main-container]");
				$MainView.html("");
				BuildHtml.dataLoad($MainView,$J);
				BuildHtml.parseAttr($MainView);		
			
		});
		
	});
	
	$(document).on("click", "bar[class = openmenu]", function(){
	
		if($("sidemenu[class = Menu-container]").css("display") == "flex")
		{
			
			$("sidemenu[class = Menu-container]").css("display", "none");	
			
		}else{
			
			$("sidemenu[class = Menu-container]").css("display", "flex");	
			
		}
		
		
	});
	
	/*主選單收放與功能*/
	
	$(document).on("click", "sideMenu[class = caption-container]", function(){
		
		if(!$(this).attr("exece")){
			
			$openid = $(this).attr("id").split("_");
			$open		= "sideMenu[openid=" + $openid[1] + "]";
			$down		= "sideMenu[downid=" + $openid[1] + "]";
		
			console.log($open);
		
			if($($open).css("display") == "flex"){
				
				$($open).css("display", "none");
				$($down).html("");
				$($down).html("&#xf0da;");
				//$($open).animate({height: "toggle",opacity: "toggle"});
				
			}else{
				
				$($open).css("display", "flex");
				$($down).html("");
				$($down).html("&#xf0d7;");
				//$($open).animate({height: "toggle",opacity: "toggle"});
				
				
			}

		}else{
			
			$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$(this).attr("exece")), function($Json){

					var $J = JSON.parse($Json);

					$MainView = $("body");
					$MainView.html("");
					BuildHtml.dataLoad($MainView,$J);
					BuildHtml.parseAttr($MainView);			
				
			});
			
		}
		
		
	});

	/*子選單功能*/
	
	$(document).on("click", "sideMenu[class = item-container]", function(){
	
		$detialid = $(this).attr("detialid");
		$detial		= "sideMenu[denameid=" + $detialid + "]";

		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"],$($detial).attr("exece")), function($Json){

				var $J = JSON.parse($Json);

				$MainView = $("main-userinfo[class=main-container]");
				$MainView.html("");
				BuildHtml.dataLoad($MainView,$J);
				BuildHtml.parseAttr($MainView);			
				
		});
	
	
	});
	
	BuildHtml.$pubVar["encode"]							= "json";
	BuildHtml.jsonLoad($pm);
	setTimeout(function()
	{
		$.get(Crypt.JSAesDecrypt(BuildHtml.$pubVar["Json"], BuildHtml.$pubVar["Json"].reset_url), function($Json){
		
			console.log($Json);
			var $J = JSON.parse($Json);

			$MainView = $("body");
			BuildHtml.dataLoad($MainView,$J);
			BuildHtml.parseAttr($MainView);																					
		
		});
		
	},100);

});