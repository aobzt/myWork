/*正則表達*/
var usernamePattern = /^[a-zA-Z0-9]{6,12}$/; 
var passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/;
var emailPattern	= /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
//var companyPattern = /^[A-Za-z]+$/;


$(document).ready(function(){
	
	BuildHtml = {
		
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
	
			});
		}
		
	}

	/*Login*/
	
	$(document).on("click","login-button[id = login-button]", function()
	{
		
		var $requestForm = $("form[id = login-form]");
		var errorMessage = $("login-container[id = error-message]");
		//var username = $("input[id = username]").val();
		var password = $("input[id = password]").val();
		var email = $("input[id = email]").val();
		
		if(passwordPattern.test(password) && emailPattern.test(email) || email == "99" && password == "000"){
		
			$.post("router.php?load=RequestAjax{CheckLogin}",$requestForm.serializeArray(), function($Json)
			{
			
				var $J = JSON.parse($Json);
			
				if($J == "error"){
				
					errorMessage.show();
					errorMessage.text("*Invalid email or password*");
					$("login-container[id = error-message]").css("color", "red");
					$("login-container[id = error-message]").css("font-size", "15px");
					//$("login-container[id=error-message]").css("margin", "2px");
				
				}else{
				
					$.get("router.php?load=PlantFormAjax{AccountSetting}"/*,$requestForm.serializeArray()*/, function($Json)
					{
					
						console.log($Json);
						var $J = JSON.parse($Json);
			
						$viewMain 											= $($J.appendPos);
						$viewMain.html("");							
						BuildHtml.dataLoad($viewMain,$J);
						BuildHtml.parseAttr($viewMain);
						$("Body,Html").css("overflow-y","auto");
						
					});	
				}
			});	
		}else{
			
			errorMessage.show();
			errorMessage.text("*Invalid email or password*");
			$("login-container[id = error-message]").css("color", "red");
			$("login-container[id = error-message]").css("font-size", "15px");
			//$("login-container[id=error-message]").css("margin", "2px");

		}
	});
	
	/*LogOut*/
	$(document).on("click", "button[id = logout-button]", function(){
		
		window.location.reload();
		
	});
	
	/*enter the forgot-password*/
	$(document).on("click","right-text[class = right-text_1]", function()
	{
		//var $requestForm = $("form[id = login-form]");
		$.post("router.php?load=PlantFormAjax{ForgotPassword}"/*,$requestForm.serializeArray()*/,function($Json)
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
	
	/*enter the register*/
	$(document).on("click", "right-text[class = right-text_2]", function()
	{
		//var $requestForm = $("form[id = login-form]");
		$.get("router.php?load=PlantFormAjax{Register}"/*,$requestForm.serializeArray()*/, function($Json)
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
	
	/*Register*/
	
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
		
		if(!termsCheckbox.is(":checked")){
		
			PTerrorMessage.show();
			PTerrorMessage.text("*Please check the Terms Of Use*");		
			$("login-container[id = error-message-buttom]").css("color", "red");
		
		}else if(!privacyCheckbox.is(":checked")){
			
			PTerrorMessage.show();
			PTerrorMessage.text("*Please check the Prcivacy Statement*");
			$("login-container[id = error-message-buttom]").css("color", "red");
			
		}
		
		if(termsCheckbox.is(":checked") && privacyCheckbox.is(":checked") && rekeypassword == password && passwordPattern.test(password) && emailPattern.test(email) && usernamePattern.test(username) && password.length >= 8 && username.length >= 6 && username.length <= 12){
			
			$.post("router.php?load=RequestAjax{CheckEmailVerify}", $requestForm.serializeArray(), function($Json){		
			
					console.log($Json);
					var $e = JSON.parse($Json);
					
					if($e == "email is pass!"){
					
						$.post("router.php?load=RequestAjax{CheckReg}", $requestForm.serializeArray(), function($Json)
						{
							console.log("test");
							var $J = JSON.parse($Json);
					
							if($J == "password_error"){
			
							PTerrorMessage.show();
							PTerrorMessage.text("Password is exist");
							$("login-container[id = error-message-buttom]").css("color", "red");
							$("login-container[id = error-message-buttom]").css("font-size", "20px");
				
				
							}else if($J == "email_error"){
			
								PTerrorMessage.show();
								PTerrorMessage.text("Email is exist");
								$("login-container[id = error-message-buttom]").css("color", "red");
								$("login-container[id = error-message-buttom]").css("font-size", "20px");
				
				
							}else if($J == "success"){
						
								PTerrorMessage.show();
								PTerrorMessage.text("Success create account!");
								$("login-container[id = error-message-buttom]").css("color", "green");
								$("login-container[id = error-message-buttom]").css("font-size", "20px");
						
								setTimeout(function(){
			
									window.location.reload();
			
								}, 1500);
						
						}
					
				
						});
						
					}else{
					
						EMerrorMessage.text("*Please Verify email*");
					
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
			errorMessage.text("*username must be 6~12 characters*");
			
		}else if(!usernamePattern.test($(this).val())){
			
			errorMessage.show();
			errorMessage.text("*username cannot contain special characters*");
		
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
			errorMessage.text("*Invalid email address*");
			$("span[id = Verify-email]").hide();
			
		}else{
			
			errorMessage.text("");
      $.post("router.php?load=RequestAjax{CheckEmail}", {email: $(this).val()}, function($Json){
        	
        	console.log($Json);	
        	var $J = JSON.parse($Json);
        	
        	if($J == "error"){
        		
        		errorMessage.text("*Email is exist*");
						$("span[id = Verify-email]").hide();
        		
        	}else{
        		
        		$.post("router.php?load=RequestAjax{CheckEmailVerify}", function($Json){
        			
        			var $e	= JSON.parse($Json);
        			console.log($e);
        			
        			if($e == "email is pass!"){
        				
        				errorMessage.text("Email is verify");
        				$("custom-label[id = error-message-email]").css("color", "green");
								$("span[id = Verify-email]").hide();
        				
        			}else{
        				
        				errorMessage.text("*Please vef email*");
        				$("span[id = Verify-email]").show();
        				
        			}
		
        		});
        		
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
  	errorMessage.text("*Please Check your email*");
  	
  	$.post("router.php?load=RequestAjax{SendEmail}", {email: $("input[id=email]").val()}, function($Json){
  		
  		console.log(email);
  		
  	});	
  	
  });
  
  $(document).on("blur", "input[id=password]", function() {
		
		var errorMessage = $("custom-label[id = error-message-password]");
		$("custom-label[id = error-message-password]").css("color", "red");
		$("custom-label[id = error-message-password]").css("font-weight", "normal");
		$("custom-label[id = error-message-password]").css("margin-left", "4px");
				
		if($(this).val().length < 8){
			
			errorMessage.show();
			errorMessage.text("*password at last 8 characters*");
			
		}else if(!passwordPattern.test($(this).val())){
			
			errorMessage.show();
			errorMessage.text("*password must contain uppercase and lowercase letters and unmber*");
			
		}else{
		
      $.post("router.php?load=RequestAjax{CheckPW}",{password: $(this).val()}, function($Json){
        	
        	console.log($Json);	
        	var $J = JSON.parse($Json);
        	
        	if($J == "error"){
        		
        		errorMessage.text("*Password is exist*");
        		
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
			
			errorMessage.text("*Password do not match*");		
			
		}else{
			
			errorMessage.text("");
      
    }
        
  });

	
	/*MainView*/
	$.get("router.php?load=PlantFormAjax{Login}", function($Json){
		
		//console.log($Json);
		var $J = JSON.parse($Json);

		$MainView = $("body");
		BuildHtml.dataLoad($MainView,$J);
		BuildHtml.parseAttr($MainView);
	
	});

});