<?php

	class PlantFormAjax
	{
		
		public static $pubVar = array();
		
		function __construct()
		{
				
		}
		
		/*登入*/
		public static function Login()
		{
			
			$appe[]																																			= "Main";
			$appe["Main"][]																															= "login-container class = login-container";
			$appe["login-container[class = login-container]"][]													= "login-container class = left";
			$appe["login-container[class = left]"][]																		= "login-container class = image-text";
			$appe["login-container[class = image-text]"][]															= "left-title class = test";
			$appe["left-title[class = test]"][]																					= "text";
			
			$appe["login-container[class = login-container]"][]													= "login-container class = right";
			$appe["login-container[class = right]"][]																		= "form id = login-form";
			
			$appe["form[id = login-form]"][]																						= "login-container class = input-container_email";			
			$appe["login-container[class = input-container_email]"][]										= "custom-label for = email";
			$appe["login-container[class = input-container_email]"][]										= "input id = email";
			
			$appe["form[id = login-form]"][]																						= "login-container class = input-container_password";
			$appe["login-container[class = input-container_password]"][]								= "custom-label for = password";			
			$appe["login-container[class = input-container_password]"][]								= "input id = password";
			$appe["login-container[class = input-container_password]"][]								= "span class = toggle-password";
			
			$appe["form[id = login-form]"][]																						= "login-container class = error-message";
			$appe["form[id = login-form]"][]																						= "login-button id = login-button";
			
			$appe["login-container[class = right]"][]																		= "login-container class = forgot-password";
			$appe["login-container[class = forgot-password]"][]													= "right-text class = right-text_1";
			$appe["login-container[class = forgot-password]"][]													= "right-text class = right-text_2";
			
			$attr["text"]["insertHtmlText"]																							= "Osun";
			$attr["form[id = login-form]"]["name"]																			= "login-form";
			$attr["form[id = login-form]"]["method"]																		= "POST";
			
			$attr["input[id = email]"]["name"]																					= "email";
			$attr["input[id = email]"]["type"]																					= "text";
			$attr["custom-label[for = email]"]["insertHtmlText"]												= "電子信箱";
			
			$attr["input[id = password]"]["name"]																				= "password";
			$attr["input[id = password]"]["type"]																				= "password";
			$attr["custom-label[for = password]"]["insertHtmlText"]											= "密碼";
			
			$attr["span[class = toggle-password]"]["id"]																= "toggle-password";
			$attr["span[class = toggle-password]"]["id"]																= "toggle-password";
			$attr["span[class = toggle-password]"]["insertHtmlText"]										= "&#x2014;";
			
			$attr["login-container[class = error-message]"]["id"]												= "error-message";
			
			$attr["login-button[id = login-button]"]["type"]														= "submit";
			$attr["login-button[id = login-button]"]["url"]															= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]."RequestAjax{CheckLogin}");
			$attr["login-button[id = login-button]"]["insertHtmlText"]									= "登入";
			
			$attr["right-text[class = right-text_1]"]["url"]														= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]."PlantFormAjax{ForgotPassword}");
			$attr["right-text[class = right-text_1]"]["insertHtmlText"] 								= "忘記密碼?";
			
			$attr["right-text[class = right-text_2]"]["url"]														= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]."PlantFormAjax{Register}");
			$attr["right-text[class = right-text_2]"]["insertHtmlText"] 								= "註冊";
			
			self::$pubVar["exportJson"]["appendPos"]																		= "body";
			self::$pubVar["exportJson"]["appendHtml"]																		= $appe;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attr;	
			
		}
		
		/*註冊*/
		public static function Register()
		{
			
			$appe[] 																																		= "main";
			$appe["main"][]																															= "login-container class = login-container";
			$appe["login-container[class = login-container]"][]													= "login-container class = right";
			
			$appe["login-container[class = right]"][]																		= "form id = reg-form";
			$appe["form[id = reg-form]"][]																							= "login-container class = input-container";
			
			$appe["login-container[class = input-container]"][]													= "login-container id = username-label";
			$appe["login-container[id = username-label]"][]															= "custom-label for = username";
			$appe["login-container[id = username-label]"][]															= "custom-label id = error-message-username";
			$appe["login-container[class = input-container]"][]													= "input id = username";
			
			$appe["login-container[class = input-container]"][]													= "login-container class = input-container_reg-email";
			$appe["login-container[class = input-container_reg-email]"][]								= "login-container id = email-label";
			$appe["login-container[id = email-label]"][]																= "custom-label for = email";
			$appe["login-container[id = email-label]"][]																= "custom-label id = error-message-email";
			$appe["login-container[class = input-container_reg-email]"][]								= "input id = email";
			$appe["login-container[class = input-container_reg-email]"][]								= "span class = toggle-email id = Verify-email style = display:none";
		
			$appe["login-container[class = input-container]"][]													= "login-container id = password-label";
			$appe["login-container[id = password-label]"][]															= "custom-label for = password";
			$appe["login-container[id = password-label]"][]															= "custom-label id = error-message-password";
			$appe["login-container[class = input-container]"][]													= "input id = password";
			//$appe["login-container[class = input-container]"][]													= "span id = toggle-password";
			
			$appe["login-container[class = input-container]"][]													= "login-container id = ReKey-password-label";
			$appe["login-container[id = ReKey-password-label]"][]												= "custom-label for = ReKey-password";
			$appe["login-container[id = ReKey-password-label]"][]												= "custom-label id = error-message-ReKey-password";
			$appe["login-container[class = input-container]"][]													= "input id = ReKey-password";
			//$appe["login-container[class = input-container]"][]													= "span id = toggle-ReKeypassword";
																																							
			/*$appe["login-container[class = input-container]"][]													= "custom-label for = company";
			$appe["login-container[class = input-container]"][]													= "input id = company";*/
			
			$appe["login-container[class = input-container]"][]													= "login-container class = checkbox_box-terms";
			$appe["login-container[class = checkbox_box-terms]"][]											= "input id = terms-checkbox";
			$appe["login-container[class = checkbox_box-terms]"][]											= "right-text for = terms-checkbox";
			
			$appe["login-container[class = input-container]"][]													= "login-container class = checkbox_box-privacy";
			$appe["login-container[class = checkbox_box-privacy]"][]										= "input id = privacy-checkbox";
			$appe["login-container[class = checkbox_box-privacy]"][]				   					= "right-text for = privacy-checkbox";
	
			$appe["login-container[class = input-container]"][]													= "login-container id = error-message-buttom";
			$appe["login-container[class = input-container]"][]													= "reg-button id = reg-button";
			
			$attr["form[id = reg-form]"]["name"]																				= "reg-form";
			$attr["form[id = reg-form]"]["method"]																			= "POST";
		
			$attr["login-container[id = username-label]"]["class"]											= "label";
			$attr["custom-label[for = username]"]["insertHtmlText"]											= "Username";
			$attr["custom-label[id = error-message-username]"]["class"]									= "error_message";
			$attr["input[id = username]"]["name"]																				= "username";
			$attr["input[id = username]"]["type"]																				= "text";
			
			$attr["login-container[id = email-label]"]["class"]													= "label";
			$attr["custom-label[for = email]"]["insertHtmlText"]												= "Email";
			$attr["custom-label[id = error-message-email]"]["class"]						   			= "error_message";
			$attr["input[id = email]"]["name"]																					= "email";
			$attr["input[id = email]"]["type"]																					= "email";
			$attr["input[id = email]"]["url"]																						= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]."RequestAjax{CheckEmail}");
			$attr["span[id = Verify-email]"]["url"]																			= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]."RequestAjax{SendEmail}");
			$attr["span[id = Verify-email]"]["insertHtmlText"]													= "驗證";
			
			$attr["login-container[id = password-label]"]["class"]											= "label";
			$attr["custom-label[for = password]"]["insertHtmlText"]											= "Password";
			$attr["custom-label[id = error-message-password]"]["class"]					  			= "error_message";
			$attr["input[id = password]"]["name"]																				= "password";
			$attr["input[id = password]"]["type"]																				= "password";
			$attr["input[id = password]"]["url"]																				= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]."RequestAjax{CheckPW}");
			/*$attr["span[id = toggle-password]"]["class"]											    			= "toggle-password";
			$attr["span[id = toggle-password]"]["insertHtmlText"]								      	= "&#x2014;";*/
			
			$attr["login-container[id = ReKey-password-label]"]["class"]								= "label";
			$attr["login-container[id = ReKey-password-label]"]["style"]								= "display:none";
			$attr["custom-label[for = ReKey-password]"]["insertHtmlText"]								= "Please enter password again";
			//$attr["custom-label[for = ReKey-password]"]["style"]												= "display:none";
			$attr["custom-label[id = error-message-ReKey-password]"]["class"]		  			= "error_message";
			$attr["input[id = ReKey-password]"]["name"]																	= "ReKey-password";
			$attr["input[id = ReKey-password]"]["type"]																	= "password";
			$attr["input[id = ReKey-password]"]["style"]																= "display:none";
			/*$attr["span[id = toggle-ReKeypassword]"]["class"]														= "toggle-password";
			$attr["span[id = toggle-ReKeypassword]"]["insertHtmlText"]									= "&#x2014;";*/
			
			/*$attr["custom-label[for = company]"]["insertHtmlText"]											= "Company";
			$attr["input[id = company]"]["name"]																				= "company";
			$attr["input[id = company]"]["type"]																				= "text";*/
			
			$attr["input[id = terms-checkbox]"]["name"]																	= "terms";
			$attr["input[id = terms-checkbox]"]["type"]																	= "checkbox";
			$attr["input[id = terms-checkbox]"]["value"]																= "accepted";
			$attr["right-text[for = terms-checkbox]"]["class"]													= "textcolorwhite";
			$attr["right-text[for = terms-checkbox]"]["insertHtmlText"]									= "我同意<right-text class=right-text_terms>《使用者條款》</right-text>";
			
			$attr["input[id = privacy-checkbox]"]["name"]																= "privacy";
			$attr["input[id = privacy-checkbox]"]["type"]																= "checkbox";
			$attr["input[id = privacy-checkbox]"]["value"]															= "accepted";
			$attr["right-text[for = privacy-checkbox]"]["class"]												= "textcolorwhite";
			$attr["right-text[for = privacy-checkbox]"]["insertHtmlText"]								= "我同意<right-text class=right-text_privacy>《隱私權政策》</right-text>";
			
			$attr["login-container[class = error-message]"]["class"]							  		=	"error-message";
			$attr["reg-button[id = reg-button]"]["url"]																	= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]."RequestAjax{CheckEmailVerify}");
			$attr["reg-button[id = reg-button]"]["insertHtmlText"]											= "註冊";
			
			self::$pubVar["exportJson"]["appendPos"]																		= "body";
			self::$pubVar["exportJson"]["appendHtml"]																		= $appe;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attr;
			
		}
		
		/*忘記密碼*/
		public static function ForgotPassword()
		{
			
			$appe[]																																			= "main";
			$appe["main"][]																															= "login-container class = login-container";
			$appe["login-container[class = login-container]"][]													= "login-container class = right";	
			$appe["login-container[class = right]"][]																		= "h2";
			$appe["login-container[class = right]"][]																		= "right-text";
			$appe["login-container[class = right]"][]																		= "form id = fp-form";
			$appe["form[id = fp-form]"][]																								= "login-container class = error-message";
			$appe["form[id = fp-form]"][]																								= "input id = email";
			$appe["form[id = fp-form]"][]																								= "fp-button id = fp-button";
			
			$attr["login-container[class = error-message]"]["id"]												= "error-message";
			$attr["form[id = fp-form]"]["name"]																					= "fp-form";
			$attr["form[id = fp-form]"]["method"]																				= "POST";
			$attr["h2"]["class"]																												= "textcolorwhite";
			$attr["h2"]["insertHtmlText"]																								= "忘記密碼了?";
			$attr["right-text"]["class"]																								= "textcolorwhite";
			$attr["right-text"]["insertHtmlText"]																				= "請輸入您的電子信箱，我們將會寄信給您！";
			$attr["input[id = email]"]["name"]																					= "email";
			$attr["input[id = email]"]["type"]																					= "text";
			$attr["fp-button[id = fp-button]"]["type"]																	= "submit";
			$attr["fp-button[id = fp-button]"]["insertHtmlText"]												= "寄信給我";
			
			self::$pubVar["exportJson"]["appendPos"]																		= "body";
			self::$pubVar["exportJson"]["appendHtml"]																		= $appe;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attr;
			
		}
		
		/*更改密碼*/
		public static function ChangeData()
		{
			
			$appe[] 																																		= "main";
			$appe["main"][]																															= "login-container class = container";
			$appe["login-container[class = container]"][]																= "login-container class = product-info";
			$appe["login-container[class = product-info]"][]														= "login-container class = ch-password";
			$appe["login-container[class = ch-password]"][]															= "form id = ch-form";
			
			$appe["form[id = ch-form]"][]																								= "custom-label for = SU-password";
			$appe["form[id = ch-form]"][]																								= "input class = ch-input id = SU-password";
			
			$appe["form[id = ch-form]"][]																								= "custom-label for = new-password";
			$appe["form[id = ch-form]"][]																								= "input class = ch-input id = new-password";
			
			$appe["form[id = ch-form]"][]																								= "custom-label for = re-new-password";
			$appe["form[id = ch-form]"][]																								= "input class = ch-input id = re-new-password";
			
			$appe["form[id = ch-form]"][]																								= "login-container id = error-message-buttom";
			$appe["form[id = ch-form]"][]																								= "ch-button id = ch-button";
			
			$attr["custom-label[for = SU-password]"]["class"]														= "textcolorblack";
			$attr["custom-label[for = SU-password]"]["insertHtmlText"]									= "請輸入您的舊密碼";
			$attr["input[id = SU-password]"]["name"]																		= "SU-password";
			$attr["input[id = SU-password]"]["type"]																		= "password";
			$attr["custom-label[for = new-password]"]["class"]													= "textcolorblack";
			$attr["custom-label[for = new-password]"]["insertHtmlText"]									= "請輸入您的新密碼";
			$attr["input[id = new-password]"]["name"]																		= "new-password";
			$attr["input[id = new-password]"]["type"]																		= "password";
			$attr["custom-label[for = re-new-password]"]["class"]												= "textcolorblack";
			$attr["custom-label[for = re-new-password]"]["insertHtmlText"]							= "再次輸入新密碼";
			$attr["input[id = re-new-password]"]["name"]																= "re-new-password";
			$attr["input[id = re-new-password]"]["type"]																= "password";
			
			$attr["ch-button[id = ch-button]"]["url"]																		= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]."RequestAjax{ChangePassword}");
			$attr["ch-button[id = ch-button]"]["insertHtmlText"]												= "更改密碼";
			
			self::$pubVar["exportJson"]["appendPos"]																		= "body";
			self::$pubVar["exportJson"]["appendHtml"]																		= $appe;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attr;
			
		}
		
				
		/*新版使用者中心*/
		/*新版上方選單*/
		public static function Bar()
		{
			
			$appe[]																																			= "bar class = center-bar";
			$appe["bar[class = center-bar]"][]																					= "bar class = title-bar";
			$appe["bar[class = center-bar]"][]																					= "bar class = openmenu";
			$appe["bar[class = center-bar]"][]																					= "bar class = coUs-bar";
			$appe["bar[class = center-bar]"][]																					= "bar class = ill-bar";
			$appe["bar[class = center-bar]"][]																					= "bar class = user-bar";
			$appe["bar[class = user-bar]"][]																						= "img class = user-photo src = image/OsunLogo2018.JPG";
			
			$attr["bar[class = title-bar]"]["insertHtmlText"]														= "咸陽科技會員中心";
			$attr["bar[class = openmenu]"]["insertHtmlText"]														= "&#xf0c9";
			$attr["bar[class = coUs-bar]"]["insertHtmlText"]														= "聯絡我們";
			$attr["bar[class = coUs-bar]"]["url"]																				= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{CoUs}");
			$attr["bar[class = ill-bar]"]["insertHtmlText"]															= "說明";
			
			//self::$pubVar["Bar"]["appendPos"]																						= "body";				
			self::$pubVar["Bar"]["appendHtml"]																					= $appe;
			self::$pubVar["Bar"]["attrHtml"]																						= $attr;
			
		}
		
		/*用戶彈窗*/
		public static function OP()
		{
			
			self::ill();
			
			SQLEvent::connectDB();
			SQLEvent::$statement																												= "select * from custom_account where unicode = '" .$_SESSION["user_unicode"]. "'";
			SQLEVent::PDOEvent();
			$data																																				= SQLEvent::$fetch;
			
			$appe[]																																			= "otherwindow class = user-op";
			$appe["otherwindow[class = user-op]"][]																			= "otherwindow class = close-op";
			$appe["otherwindow[class = user-op]"][]																			= "otherwindow class = otherwindow-userop";
			$appe["otherwindow[class = otherwindow-userop]"][]													= "otherwindow class = otherwindow-email";
			$appe["otherwindow[class = otherwindow-userop]"][]													= "otherwindow class = otherwindow-name";
			$appe["otherwindow[class = otherwindow-userop]"][]													= "otherwindow class = logout-button";
			$appe["otherwindow[class = otherwindow-userop]"][]													= "otherwindow class = TandP";
			$appe["otherwindow[class = TandP]"][]																				= "right-text class = right-text_terms";
			$appe["otherwindow[class = TandP]"][]																				= "text-OP";
			$appe["otherwindow[class = TandP]"][]																				= "right-text class = right-text_privacy";
			
			$attr["otherwindow[class = close-op]"]["insertHtmlText"]										= "&#xf00d;";
			$attr["otherwindow[class = otherwindow-email]"]["insertHtmlText"]						= $data[0]["email"];
			$attr["otherwindow[class = otherwindow-name]"]["insertHtmlText"]						= "Welcome！" .$data[0]["accountID"];
			$attr["otherwindow[class = logout-button]"]["insertHtmlText"]								= "登出";
			$attr["right-text[class = right-text_terms]"]["insertHtmlText"]							= "使用者條款";
			$attr["text-OP"]["insertHtmlText"]																					= "．";
			$attr["right-text[class = right-text_privacy]"]["insertHtmlText"]						= "隱私權政策";
			
			self::$pubVar["OP"]["appendHtml"]																						= $appe;
			self::$pubVar["OP"]["attrHtml"]																							= $attr;
			
			$apper																																			= array_merge_recursive(self::$pubVar["OP"]["appendHtml"],
																																																						self::$pubVar["ill"]["appendHtml"]);
			$attrr																																			= array_merge_recursive(self::$pubVar["OP"]["attrHtml"],
																																																						self::$pubVar["ill"]["attrHtml"]);
			
			//self::$pubVar["exportJson"]["appendPos"]																		= "body";																																																			
			self::$pubVar["OPandill"]["appendHtml"]																			= $apper;
			self::$pubVar["OPandill"]["attrHtml"]																				= $attrr;																																																			
			
		}
		
		/*說明彈窗*/
		public static function ill()
		{
			
			$appe[]																																			= "otherwindow class = ill";
			$appe["otherwindow[class = ill]"][]																					= "otherwindow class = close-ill";
			$appe["otherwindow[class = ill]"][]																					= "otherwindow class = otherwindow-ill";
			$appe["otherwindow[class = otherwindow-ill]"][]															= "text-ill";
			$appe["otherwindow[class = otherwindow-ill]"][]															= "otherwindow class = ill-CoUs";
			$appe["otherwindow[class = ill-CoUs]"][]																		= "text-ill-2";
			$appe["otherwindow[class = ill-CoUs]"][]																		= "right-text class = right-text_CoUs id = ill";
			
			$attr["otherwindow[class = close-ill]"]["insertHtmlText"]										= "&#xf00d;";
			$attr["text-ill"]["insertHtmlText"]																					= "測試用";
			$attr["text-ill-2"]["insertHtmlText"]																				= "遇到您無法解決的問題？";
			$attr["right-text[id = ill]"]["insertHtmlText"]															= "聯絡我們";
			$attr["right-text[id = ill]"]["url"]																				= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{CoUs}");
			
			self::$pubVar["ill"]["appendHtml"]																					= $appe;
			self::$pubVar["ill"]["attrHtml"]																						= $attr;
			
		}
		
		/*新版側邊選單*/
		public static function UserSideMenu()
		{
		
			config::UserSideMenu();
			$item																																				= config::$pubVar["UserSideMenu"];
			
			$appe[]																																			= "workerea";
			$appe["workerea"][]																													= "sideMenu class = Menu-container";
			
			foreach($item as $key => $value)
			{
				
				$kkey																																			= $key + 1;
				$appe["sideMenu[class = Menu-container]"][]																= "sideMenu class = caption-container id = m1_" .$kkey;
				$appe["sideMenu[class = Menu-container]"][]																= "sideMenu class = detial-container openID = " .$kkey;
				$appe["sideMenu[id = m1_" .$kkey. "]"][]																	= "sideMenu class = caption-icon iconID = " .$kkey;
				$appe["sideMenu[id = m1_" .$kkey. "]"][]																	= "sideMenu class = caption nameID = " .$kkey;
				$appe["sideMenu[id = m1_" .$kkey. "]"][]																	= "sideMenu class = down downID = " .$kkey;
				$attr["sideMenu[nameID = " .$kkey. "]"]["insertHtmlText"]									= explode("," , $value["Main"])[0];
				$value["Icon"] && $attr["sideMenu[iconID = " .$kkey. "]"]["insertBase64"] = $value["Icon"];
				$value["Exece"] && $attr["sideMenu[id = m1_" .$kkey. "]"]["Exece"]				= $value["Exece"];
				
				
				if($value["flow"] == "Yes")
				{
				
					$attr["sideMenu[downID = " .$kkey. "]"]["insertHtmlText"]									= "&#xf0da;";
					
				}
				
				foreach($value["Item"] as $key2 => $value2)
				{
					
					$kkey2																																	= $key2 + 1;
					list($Name, $Exece)																											= explode("," , $value2);
					
					$appe["sideMenu[openID = " .$kkey. "]"][]																= "sideMenu class = item-container detialID = " .$kkey. "_" .$kkey2;
					$appe["sideMenu[detialID = " .$kkey. "_" .$kkey2. "]"][]								= "sideMenu class = item-name denameID = " .$kkey. "_" .$kkey2;
					$attr["sideMenu[denameID = " .$kkey. "_" .$kkey2. "]"]["insertHtmlText"]	
																																									= $Name;
					$attr["sideMenu[denameID = " .$kkey. "_" .$kkey2. "]"]["Exece"]					= $Exece;
					
				}
				
			}
		
			self::$pubVar["UserSideMenu"]["appendHtml"]																		= $appe;
			self::$pubVar["UserSideMenu"]["attrHtml"]																			= $attr;
	
		}
		
		/*個人檔案*/
		public static function UserInfo()
		{
			
			self::Bar();
			self::OP();
			self::UserSideMenu();
			
			SQLEvent::connectDB();
			SQLEvent::$statement																												= "select * from custom_account where unicode = '" .$_SESSION["user_unicode"]. "'";
			SQLEVent::PDOEvent();
			$data																																				= SQLEvent::$fetch;
			
			$appe["workerea"][]																													= "main-userinfo class = main-container";
			$appe["main-userinfo[class = main-container]"][]														= "main-userinfo class = big-container";
			$appe["main-userinfo[class = big-container]"][]															= "main-userinfo class = title-info";
			$appe["main-userinfo[class = big-container]"][]															= "main-userinfo class = info-container";
			$appe["main-userinfo[class = info-container]"][]														= "main-userinfo class = info";
			$appe["main-userinfo[class = info]"][]																			= "main-userinfo class = ID-container";
			$appe["main-userinfo[class = ID-container]"][]															= "main-userinfo class = ID";
			$appe["main-userinfo[class = ID-container]"][]															= "main-userinfo class = ID-pencil";
			$appe["main-userinfo[class = info]"][]																			= "main-userinfo class = ID-errormessage";
			$appe["main-userinfo[class = info]"][]																			= "main-userinfo class = email-container";
			$appe["main-userinfo[class = email-container]"][]														= "main-userinfo class = email";
			$appe["main-userinfo[class = email-container]"][]														= "main-userinfo class = email-pencil";
			$appe["main-userinfo[class = info]"][]																			= "main-userinfo class = email-errormessage";
			$appe["main-userinfo[class = info]"][]																			= "main-userinfo class = verify";
			$appe["main-userinfo[class = info]"][]																			= "main-userinfo class = date";
			$appe["main-userinfo[class = info]"][]	   																	= "main-userinfo class = changepassword";
			$appe["main-userinfo[class = info-container]"][]														= "main-userinfo class = photo";
			$appe["main-userinfo[class = photo]"][]																			= "main-userinfo class = info-photo";
			$appe["main-userinfo[class = info-photo]"][]																= "img src=image/OsunLogo2018.JPG";
			$appe["main-userinfo[class = photo]"][]																			= "main-userinfo class = change-photo";
			
			$attr["main-userinfo[class = title-info]"]["insertHtmlText"]								= "我的檔案";
			$attr["main-userinfo[class = ID]"]["insertHtmlText"]												= $data[0]["accountID"];
			$attr["main-userinfo[class = ID-pencil]"]["insertHtmlText"]									= "&#xf044;";
			$attr["main-userinfo[class = email]"]["insertHtmlText"]											= $data[0]["email"];
			$attr["main-userinfo[class = email-pencil]"]["insertHtmlText"]							= "&#xf044;";
			$attr["main-userinfo[class = verify]"]["insertHtmlText"]										= "驗證";
			$attr["main-userinfo[class = date]"]["insertHtmlText"]											= "註冊日期：" .$data[0]["registDate"];
			$attr["main-userinfo[class = changepassword]"]["insertHtmlText"]						= "更改密碼";
			$attr["main-userinfo[class = changepassword]"]["url"]												= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]."PlantFormAjax{ChangeData}");
			$attr["main-userinfo[class = change-photo]"]["insertHtmlText"]							= "更換大頭照";
			
			self::$pubVar["UserInfo"]["appendHtml"]																			= $appe;
			self::$pubVar["UserInfo"]["attrHtml"]																				= $attr;
					
			$apper																																			= array_merge_recursive(self::$pubVar["Bar"]["appendHtml"],
																																																					self::$pubVar["OPandill"]["appendHtml"],
																																																					self::$pubVar["UserSideMenu"]["appendHtml"],
																																																					self::$pubVar["UserInfo"]["appendHtml"]);
			$attrr																																			= array_merge_recursive(self::$pubVar["Bar"]["attrHtml"],
																																																					self::$pubVar["OPandill"]["attrHtml"],
																																																					self::$pubVar["UserSideMenu"]["attrHtml"],
																																																					self::$pubVar["UserInfo"]["attrHtml"]);
			
			self::$pubVar["exportJson"]["appendPos"]																		= "body";																																						
			self::$pubVar["exportJson"]["appendHtml"]																		= $apper;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attrr;
			
		}
		
		/*個人產品*/
		public static function Myproduct()
		{

			SQLOption::custom_product();
			self::$pubVar["productInfo"]																								= SQLOption::$pubVar["custom_product"];
			
			SQLEvent::connectDB();
			SQLEvent::$statement																												= "select ProductID, ProductName, registCode, version, expireDate, activeDate from custom_product inner join custom_account on custom_product.unicode = custom_account.unicode where custom_account.unicode = '" .$_SESSION["user_unicode"]. "'";
			SQLEVent::PDOEvent();
			$fetchAll	 																																	= SQLEvent::$fetch;
					
			$appe[]																																			= "main-userinfo class = big-container";
			$appe["main-userinfo[class = big-container]"][]															= "main-userinfo class = title-info";
			$appe["main-userinfo[class = big-container]"][]															= "main-userinfo class = product-left";
			$appe["main-userinfo[class = product-left]"][]															= "unitContent loc = report_table";
			$appe["unitContent[loc = report_table]"][]																	= "unitContent loc = report_tr pos = title";
			
			$attr["main-userinfo[class = title-info]"]["insertHtmlText"]								= "我的產品";
			
			if($fetchAll){
			
				foreach(self::$pubVar["productInfo"]["report"] as $k => $v)
				{
				
					if(is_numeric($k))
					{
					
						$appe["unitContent[loc = report_tr][pos = title]"][]										= "unitContent loc = report_td pos = title cell = " .($k + 1);
						$attr["unitContent[loc = report_td][pos = title][cell = " .($k + 1). "]"]["insertHtmlText"] = $v;
				
					}
				
				} 
				self::$pubVar["productInfo"]["public"]["control_cell"] 
													&& ($appe["unitContent[loc = report_tr][pos = title]"][]	= "unitContent loc = report_td pos = title cell = control");
			
				for($i = 0; $i < count($fetchAll); $i++)
				{
					$j																																				= $i;
					$data																																			= $fetchAll[$i];
					$appe["unitContent[loc = report_table]"][]																= "unitContent loc = report_tr pos = row_" .($i + 1);
				
					foreach(self::$pubVar["productInfo"]["report"] as $k => $v)
					{
					
						if(is_numeric($k))
						{
						
							switch($v)
							{
							
								case "ProductName":
								
									$appe["unitContent[loc = report_tr][pos = row_" .($i + 1). "]"][]	= "unitContent loc = report_td pos = row_" .($i + 1). " cell = " .($k + 1);
									$attr["unitContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($k + 1). "]"]["insertHtmlText"]
																																										= $data["ProductName"];
									break;
								
								case "registCode":
							
									$appe["unitContent[loc = report_tr][pos = row_" .($i + 1). "]"][]	= "unitContent loc = report_td pos = row_" .($i + 1). " cell = " .($k + 1);
									$attr["unitContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($k + 1). "]"]["insertHtmlText"]
																																										= $data["registCode"];
									break;
								
								case "version":
							
									$appe["unitContent[loc = report_tr][pos = row_" .($i + 1). "]"][]	= "unitContent loc = report_td pos = row_" .($i + 1). " cell = " .($k + 1);
									$attr["unitContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($k + 1). "]"]["insertHtmlText"]
																																										= $data["version"];
									break;
								
								case "expireDate":
							
									$appe["unitContent[loc = report_tr][pos = row_" .($i + 1). "]"][]	= "unitContent loc = report_td pos = row_" .($i + 1). " cell = " .($k + 1);
									/*$attr["unitContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($k + 1). "]"]["insertHtmlText"]
																																										= $data["expireDate"];*/
																																									
									if($data["expireDate"] > 30){
									
										$attr["unitContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($k + 1). "]"]["insertHtmlText"]
																																										= "Paid version";
									
									}else{
									
										$attr["unitContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($k + 1). "]"]["insertHtmlText"]
																																										= "30-day free";
									
									}
																																									
								break;
								
								case "activeDate":
							
									$appe["unitContent[loc = report_tr][pos = row_" .($i + 1). "]"][]	= "unitContent loc = report_td pos = row_" .($i + 1). " cell = " .($k + 1);
																																									
									if($data["activeDate"]	== null){
									
										$attr["unitContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($k + 1). "]"]["insertHtmlText"]
																																										= "no active";
									
									}else{
									
										$attr["unitContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($k + 1). "]"]["insertHtmlText"]
																																										= $data["activeDate"];
									
									}
																																									
									break;
							
							}
						
						}
					
					}
				
					if(self::$pubVar["productInfo"]["public"]["control_cell"])
					{
					
						$appe["unitContent[loc=report_tr][pos=row_".($i + 1)."]"][]							= "unitContent loc=report_td pos=row_".($i + 1)." cell=control";
						$appe["unitContent[loc=report_td][pos=row_".($i + 1)."][cell=control]"][]
																																										= "btn id=open_detial porjectId=".self::$pubVar["productInfo"]["public"]["tablename"]." openId=".($i + 1);
						$attr["btn[id=open_detial][openId=".($i + 1)."]"]["insertHtmlText"]			= "Download";
																																
						if($data["ProductID"] == "5000000")
						{
						
							$attr["btn[id=open_detial][openId=".($i + 1)."]"]["download"]					= "simstw";	
							$attr["btn[id=open_detial][openId=".($i + 1)."]"]["content"]					= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Download:productID=" .$data["ProductID"]. "}");
						
						}else if($data["ProductID"] == "2000000"){
						
							$attr["btn[id=open_detial][openId=".($i + 1)."]"]["download"]					= "LIS";	
							$attr["btn[id=open_detial][openId=".($i + 1)."]"]["content"]					= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Download:productID=" .$data["ProductID"]. "}");
						
						}
					
					}
				
				}
			}
			
																																					
			self::$pubVar["exportJson"]["appendHtml"]																		= $appe;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attr;
			
			
		}
		
		/*聯絡我們*/
		public static function CoUs()
		{
			
			SQLEvent::connectDB();
			SQLEvent::$statement																												= "select * from custom_account where unicode = '" .$_SESSION["user_unicode"]. "'";
			SQLEVent::PDOEvent();
			$data																																				= SQLEvent::$fetch;
			
			$appe[]																																			= "main-userinfo class = big-container";
			$appe["main-userinfo[class = big-container]"][]															= "main-userinfo class = title-info";
			$appe["main-userinfo[class = big-container]"][]															= "cu-container class = cu-container";
			$appe["cu-container[class = cu-container]"][]																= "cu-container class = QA";
			$appe["cu-container[class = cu-container]"][]																= "form class = cu-form";
			$appe["form[class = cu-form]"][]																						= "cu-form class = cu-form-title";
			$appe["form[class = cu-form]"][]																						= "cu-form class = cu-label id = cu-unicode";
			$appe["form[class = cu-form]"][]																						= "input class = cu-input id = cu-unicode name = cu-unicode readonly";
			$appe["form[class = cu-form]"][]																						= "cu-form class = cu-label id = cu-username";
			$appe["form[class = cu-form]"][]																						= "input class = cu-input id = cu-username name = cu-username";
			$appe["form[class = cu-form]"][]																						= "cu-form class = cu-label id = cu-email";
			$appe["form[class = cu-form]"][]																						= "input class = cu-input id = cu-email name = cu-email";
			$appe["form[class = cu-form]"][]																						= "cu-form class = cu-label id = cu-text";
			$appe["form[class = cu-form]"][]																						= "textarea class = cu-input-text";
			$appe["form[class = cu-form]"][]																						= "cu-button class = cu-button";
			
			$attr["main-userinfo[class = title-info]"]["insertHtmlText"]								= "聯絡我們";
			
			$attr["cu-container[class = QA]"]["insertHtmlText"]	
															
			= "<n style='font-weight: bold;'>Q：安裝產品
			A：產品相關→我的產品，找尋您希望安裝的產品點選Download</n>
			
			
			<m style='font-size:16px;'>仍然無法解決您的問題？您可以選擇<t style='color: red; font-weight:bold;'>填寫表單</t>，或是以下聯絡資訊：
			電話：04-24529538
			傳真：04-24529236
			Email：osun@mail.7lab.com.tw</m>"; 
			
			$attr["cu-form[class = cu-form-title]"]["insertHtmlText"]										= "寫下您的問題！";
			$attr["cu-form[class = cu-label][id = cu-unicode]"]["insertHtmlText"]				= "帳號識別碼";
			$attr["input[class = cu-input][id = cu-unicode]"]["value"]									= $_SESSION["user_unicode"];
			$attr["cu-form[class = cu-label][id = cu-username]"]["insertHtmlText"]			= "用戶名稱";
			$attr["input[class = cu-input][id = cu-username]"]["value"]									= $data[0]["accountID"];
			$attr["cu-form[class = cu-label][id = cu-email]"]["insertHtmlText"]					= "電子信箱";
			$attr["input[class = cu-input][id = cu-email]"]["value"]										= $data[0]["email"];
			$attr["cu-form[class = cu-label][id = cu-text]"]["insertHtmlText"]					= "輸入文字";
			$attr["cu-button[class = cu-button]"]["insertHtmlText"]											= "送出";
			
			self::$pubVar["exportJson"]["appendHtml"]																		= $appe;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attr;
			
		}
		
		/*後台登入*/
		public static function Master_Login()
		{
			
			$appe[]																																			= "login class = big-container";
			$appe["login[class = big-container]"][]																			= "login class = login-title";
			$appe["login[class = login-title]"][]																				= "login class = icon";
			$appe["login[class = icon]"][]																							= "i class='fa fa-unlock-alt'";
			$appe["login[class = login-title]"][]																				= "login class = caption";
			$appe["login[class = big-container]"][]																			= "login class = contain";
			$appe["login[class = contain]"][]																						= "login class = main";
			$appe["login[class = main]"][]																							= "login class = form";
			$appe["login[class = form]"][]																							= "form class = master-login";
			$appe["form[class = master-login]"][]																				= "LIcontainer class = LIcontainer id = a";
			$appe["LIcontainer[class = LIcontainer][id = a]"][]							 						= "login for = username";
			$appe["LIcontainer[class = LIcontainer][id = a]"][]													= "input id = username";
			$appe["form[class = master-login]"][]																				= "LIcontainer class = LIcontainer id = b";
			$appe["LIcontainer[class = LIcontainer][id = b]"][]													= "login for = password";
			$appe["LIcontainer[class = LIcontainer][id = b]"][]								 					= "input id = password";
			$appe["form[class = master-login]"][]																				= "msu-button class = login";
			
			$attr["login[class = caption]"]["insertHtmlText"]														= "授權管理系統";
			$attr["form[class = master-login]"]["name"]																	= "master-login";
			$attr["form[class = master-login]"]["method"]															 	= "POST";
			
			$attr["login[for = username]"]["class"]																			= "label";
			$attr["login[for = username]"]["insertHtmlText"]														= "帳號";
			
			$attr["input[id = username]"]["name"]																				= "username";
			$attr["input[id = username]"]["type"]																				= "text";
			
			$attr["login[for = password]"]["class"]																			= "label";
			$attr["login[for = password]"]["insertHtmlText"]														= "密碼";
			
			$attr["input[id = password]"]["name"]																				= "password";
			$attr["input[id = password]"]["type"]																				= "password";
			
			$attr["msu-button[class = login]"]["id"]																	 	= "login";
			$attr["msu-button[class = login]"]["url"]																		= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{MasterLogin}");
			$attr["msu-button[class = login]"]["insertHtmlText"]												= "Login";
			$attr["msu-button[class = login]"]["type"]																	= "submit";
				
			self::$pubVar["exportJson"]["appendPos"]																		= "workeare";
			self::$pubVar["exportJson"]["appendHtml"]																		= $appe;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attr;
			
		}
		
		/*後台菜單*/
		
		public static function SideMenu()
		{
			
			config::SideMenu();
			$items																																			= config::$pubVar["SideMenu"];
			//print_r($items);
			
			$appe[]																																			= "sideMenu class = sideMenu-container";
			
			foreach($items as $key => $value)
			{
				
				$kkey																																			= $key + 1;
				$appe["sideMenu[class = sideMenu-container]"][]														= "sideMenu class = item-container id = m1_" .$kkey;
				$appe["sideMenu[class = sideMenu-container]"][]														= "detial class = detial-container id = " .$kkey;
				$appe["sideMenu[id = m1_" .$kkey. "]"][]																	= "sideMenu class = item-icon photo = m1_" .$kkey;
				$appe["sideMenu[id = m1_" .$kkey. "]"][]																	= "sideMenu class = item-caption id = m1_" .$kkey. "_" .$kkey;
				$appe["sideMenu[id = m1_" .$kkey. "]"][]																	= "sideMenu class = item-page photo = m1_" .$kkey. "_" .$kkey;
				$attr["sideMenu[id = m1_" .$kkey. "_" .$kkey."]"]["insertHtmlText"]				= explode("," , $value["Main"])[0];
				$value["Icon"] && $attr["sideMenu[photo = m1_" .$kkey. "]"]["insertBase64"]
																																									= $value["Icon"];
				$value["Exece"] && $attr["sideMenu[class = item-container][id = m1_" .$kkey."]"]["Exece"]
																																									= $value["Exece"];
																																									
				if($value["flow"] == "Yes")
				{
					
					$attr["sideMenu[photo = m1_" .$kkey. "_" .$kkey. "]"]["insertHtmlText"]	= "&#xf0da;";
					
				}
																																									
				foreach($value["Item"] as $key2 => $value2)
				{
					
					$kkey2																																	= $key2 + 1;
					//print_r($value2);
						
					list($Name, $Exece)																											= explode("," , $value2);
					$appe["detial[id =" .$kkey. "]"][]																			= "detial class = detial-caption id = " .$kkey. "_" .$kkey2;
					$appe["detial[id = " .$kkey. "_" .$kkey2. "]"][]												= "detial class = detial-name id = " .$kkey. "_" .$kkey2;
					$attr["detial[class = detial-name][id = " .$kkey. "_" .$kkey2."]"]["insertHtmlText"]				
																																									= $Name;
					$attr["detial[class = detial-name][id = " .$kkey. "_" .$kkey2."]"]["Exece"]				
																																									= $Exece;
						
				}																	
				
				
			}
			
			//$appr[]																																			= "";
			
			//self::$pubVar["exportJson"]["appendPos"]																		= "workeare";
			self::$pubVar["sidemenu"]["appendHtml"]																			= $appe;
			self::$pubVar["sidemenu"]["attrHtml"]																				= $attr;
			
		}
		
		public static function masterHome()
		{
			
			self::SideMenu();
			
			config::SideMenu();
			$items																																			= config::$pubVar["SideMenu"];
			
			$appe[]																																			= "main-container class = main-container";
			$appe["main-container[class = main-container]"][]														= "main-container class = home-container";
			$appe["main-container[class = home-container]"][]														= "main-container class = home";
			
			foreach($items as $key => $value)
			{
				
				if(explode(",", $value["Main"])[0] != "登出")
				{
					
					$kkey																																			= $key + 1;
					$appe["main-container[class = home]"][]																		= "home class = home-item function = " .$kkey;
					$appe["home[function = " .$kkey. "]"][]																		= "shortcut class = shortcut-icon function = " .$kkey;
					$appe["shortcut[function = " .$kkey. "]"][]																= "shortcut class = sc-icon id = " .$kkey;
					$appe["shortcut[function = " .$kkey. "]"][]																= "shortcut class = sc-title id = " .$kkey;
					
					$attr["shortcut[class = sc-title][id = " .$kkey. "]"]["insertHtmlText"]		= explode("," , $value["Main"])[0];
					$value["Icon"] && $attr["shortcut[class = sc-icon][id = " .$kkey. "]"]["insertBase64"]
																																										= $value["Icon"];
					$value["Exece"] && $attr["shortcut[class = sc-icon][id = " .$kkey. "]"]["Exece"]
																																										= $value["Exece"];
					
					$appe["home[function = " .$kkey. "]"][]																		= "shortcut class = shortcut id = " .$kkey;
					
					foreach($value["Item"] as $key2 => $value2)
					{
						
						$kkey2																																	= $key2 + 1;
						
						list($Name, $Exece)																											= explode("," , $value2);
						$appe["shortcut[class = shortcut][id = " .$kkey. "]"][]									= "shortcut class = shortcut-name id = " .$kkey. "_" .$kkey2;
						$attr["shortcut[class = shortcut-name][id = " .$kkey. "_" .$kkey2. "]"]["insertHtmlText"]		
																																										= $Name;
						$attr["shortcut[class = shortcut-name][id = " .$kkey. "_" .$kkey2. "]"]["url"]
																																										= $Exece;
				
					}
					
				}
				
			}
			
			self::$pubVar["masterHome"]["appendHtml"]																		= $appe;
			self::$pubVar["masterHome"]["attrHtml"]																			= $attr;
				
			$apper																																			= array_merge_recursive(self::$pubVar["sidemenu"]["appendHtml"],
																																																					self::$pubVar["masterHome"]["appendHtml"]);
			//$attrr																																			= self::$pubVar["sidemenu"]["attrHtml"];
			$attrr																																			= array_merge_recursive(self::$pubVar["sidemenu"]["attrHtml"],
																																																					self::$pubVar["masterHome"]["attrHtml"]);
			
			self::$pubVar["exportJson"]["appendPos"]																		= "workeare";																																						
			self::$pubVar["exportJson"]["appendHtml"]																		= $apper;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attrr;
			
			
		}
		
		/*表單*/
		
		public static function createTable()
		{
			
			Shared::$pubVar["loadVars"]																									= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																				= Shared::$pubVar["loadVars"];
			
			$SQLFunction																																= $args["Option"];
			SQLOption::$SQLFunction();
			self::$pubVar["tableInfo"]																									= SQLOption::$pubVar[$SQLFunction];

			/*製作頁碼*/
			SQLEvent::connectDB();
			SQLEvent::$statement																												= self::$pubVar["tableInfo"]["public"]["SQLCountGrammar"];
			SQLEvent::PDOEvent();
			$total																																			= SQLEvent::$fetch[0]["total"];
			
			$recordsPerPage 																														= 10;
			
			$totalPages 																																= ceil($total / $recordsPerPage);
			$page																																				= $args["page"] ? $args["page"] : 1;
			// 防止用戶輸入非法的頁碼
			$currentPage = max(1, min($totalPages, $page));
			// 計算 OFFSET
			$offset = ($currentPage - 1) * $recordsPerPage;
			
			$replaceRange																																= array("_firstNumber_", "_secondNumber_");
			$selectRange																																= array($offset + 1, $offset + $recordsPerPage);
			
			SQLEvent::$statement																												= str_replace($replaceRange, $selectRange, self::$pubVar["tableInfo"]["public"]["SQLGrammar"]);
			SQLEvent::PDOEvent();
			$data																																				= SQLEvent::$fetch;
	
			//print_r(SQLEvent::$statement);
	
			$appe[]																																			= "main-container class = function-title";
			$appe[]																																			= "main-container class = work-container";
			$appe["main-container[class = work-container]"][]														= "toolBar class = toolBar";
			//$appe["toolBar[class = toolBar]"][]																					= "toolBar class = addData";
			
			self::$pubVar["tableInfo"]["public"]["add_cell"] 
					&& ($appe["toolBar[class = toolBar]"][]																	= "toolBar class = addData");			
			self::$pubVar["tableInfo"]["public"]["add_cell"] 
					&& ($attr["toolBar[class = addData]"]["insertHtmlText"]									= "&#xf067 新增");
			self::$pubVar["tableInfo"]["public"]["add_cell"] 
					&& ($attr["toolBar[class = addData]"]["url"]														= self::$pubVar["tableInfo"]["public"]["add_url"]);
					
			self::$pubVar["tableInfo"]["public"]["deleteAll_cell"] 
					&& ($appe["toolBar[class = toolBar]"][]																	= "toolBar class = deleteAll");	
			self::$pubVar["tableInfo"]["public"]["deleteAll_cell"]
					&& ($attr["toolBar[class = deleteAll]"]["insertHtmlText"]								= "&#xf1f8 刪除所有空白驗證");
			self::$pubVar["tableInfo"]["public"]["deleteAll_cell"]
					&& ($attr["toolBar[class = deleteAll]"]["url"]													= self::$pubVar["tableInfo"]["public"]["deleteAll_url"]);
			
			$appe["toolBar[class = toolBar]"][]																					= "form class = search-box";
			$appe["form[class = search-box]"][]																					= "toolBar class = search";
			$appe["form[class = search-box]"][]																					= "input class = input-search name = search";
						
			$attr["toolBar[class = search]"]["insertHtmlText"]													= "&#xf002 查詢";
			$attr["toolBar[class = search]"]["url"]																			= self::$pubVar["tableInfo"]["public"]["search_url"];
			
			$appe["main-container[class = work-container]"][]														= "tableContent loc = report_table";
			$appe["tableContent[loc = report_table]"][]																	= "tableContent loc = report_tr pos = title";
			
			$attr["main-container[class = function-title]"]["insertHtmlText"]						= self::$pubVar["tableInfo"]["public"]["title"];
			
			if($data)
			{
				
				foreach(self::$pubVar["tableInfo"]["report"] as $key => $value)
				{
					
					if(is_numeric($key))
					{
						
						//print_r($value);
						list($EnName, $CnName)																								= explode("|", $value);
						$appe["tableContent[loc = report_tr][pos = title]"][]							  	= "tableContent loc = report_td pos = title cell =" .($key + 1);
						$attr["tableContent[loc = report_td][pos = title][cell =" .($key + 1). "]"]["insertHtmlText"]
																																									= $CnName;
						
					}
					
				}
				
				self::$pubVar["tableInfo"]["public"]["control_cell"] 
											&& ($appe["tableContent[loc = report_tr][pos = title]"][]  = "tableContent loc = report_td pos = title cell = control");
				self::$pubVar["tableInfo"]["public"]["delete_cell"] 
											&& ($appe["tableContent[loc = report_tr][pos = title]"][]  = "tableContent loc = report_td pos = title cell = delete");
				self::$pubVar["tableInfo"]["public"]["update_cell"] 
											&& ($appe["tableContent[loc = report_tr][pos = title]"][]  = "tableContent loc = report_td pos = title cell = update");
											
				for($i = 0; $i < count($data); $i++)
				{
					
					$j																																			= $i;
					$eachData																																= $data[$i];
					$appe["tableContent[loc = report_table]"][]															= "tableContent loc = report_tr pos = row_" .($i + 1);
					
					foreach(self::$pubVar["tableInfo"]["report"] as $key => $value)
					{
						
						if(is_numeric($key))
						{
							
							list($EnName, $CnName)																								= explode("|", $value);
							
							switch($EnName)
							{
								
								case "Unicode":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["unicode"];
									break;
									
								case "Username":
								case "AccountID":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["accountID"];
									break;
									
								case "E-mail":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["email"];
									break;
									
								case "Password":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["password"];
									break;
									
								case "RegistDate":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["registDate"];
									break;
									
								case "RegistDate":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["registDate"];
									break;
								
								case "ModifyDate":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["modifyDate"];
									break;
									
								case "IsValid":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									
									if($eachData["isValid"] == "1")
									{
										
										$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= "是";
										
									}else{
										
										$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= "否";
										 	
									}
									
									break;
									
								case "ActiveCode":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["activeCode"];
									break;
								
								case "RegistCode":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["registCode"];
									break;
								
								case "MCode":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["MCode"];
									break;
									
								case "MAC":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["MAC"];
									break;
								
								case "IPAddr":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["IPAddr"];
									break;
									
								case "Token":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["token"];
								
									break;
									
								case "Aging":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["aging"];
								
									break;
									
								case "ProductName":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["productName"];
									break;
									
								case "ProductID":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["productID"];
																																										
									break;
									
								case "ProductCName":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["productCName"];
																																										
									break;
									
								case "ProductEName":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["productEName"];
																																										
									break;
								
								case "Version":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["version"];
																																										
									break;
									
								case "Userid":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["userid"];
																																										
									break;
									
								case "User":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["username"];
																																										
									break;
									
								case "Userpwd":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["userpwd"];
																																										
									break;
									
								case "Exeid":
								
									$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][] = "tableContent loc = report_td pos = row_" .($i + 1). " cell = " .($key + 1). " moblie = " .$CnName;
									$attr["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = " .($key + 1). "]"]["insertHtmlText"]
																																										= $eachData["exeid"];
																																										
									break;
									

							}
							
						}
						
					}
					
					if(self::$pubVar["tableInfo"]["public"]["control_cell"])
					{
						
						$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][]				= "tableContent loc = report_td pos = row_" .($i + 1). " cell = control";
						$appe["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = control]"][]
																																											= "detial_button id = open_function functionID = " .self::$pubVar["tableInfo"]["public"]["tablename"]. " openId = m".($i + 1);
						$attr["detial_button[id = open_function][openId = m" .($i + 1). "]"]["insertHtmlText"]
																																											= "詳細";
						$attr["detial_button[id = open_function][openId = m" .($i + 1). "]"]["url"]
																																											= "test";
						
					}
					
					if(self::$pubVar["tableInfo"]["public"]["delete_cell"])
					{
						
						$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][]				= "tableContent loc = report_td pos = row_" .($i + 1). " cell = delete";
						$appe["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = delete]"][]
																																											= "detial_button id = open_function functionID = " .self::$pubVar["tableInfo"]["public"]["tablename"]. " deleteId = m" .($i + 1). " cell = delete";
						$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["insertHtmlText"]
																																											= "刪除";
																																											
						switch($args["Option"])
						{
							
							case "custom_account":
							
								$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:unicode=" .$eachData["unicode"]. ",table=" .$args["Option"]. "}");
								break;
								
							case "MG_custom_product":
							
								$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:unicode=" .$eachData["unicode"]. ",productID=" .$eachData["productID"]. ",table=custom_product}");
								break;
								
							case "user_email":
							
								$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:token=" .$eachData["token"]. ",table=" .$args["Option"]. "}");
								break;
								
							case "product_data":
							
								$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:unicode=" .$eachData["unicode"]. ",productID=" .$eachData["productID"]. ",table=" .$args["Option"]. "}");	
								break;
								
							case "xuser_data":
							
								$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:userid=" .$eachData["userid"]. ",table=" .$args["Option"]. "}");							
								break;
								
						}

					}
					
					if(self::$pubVar["tableInfo"]["public"]["update_cell"])
					{
						
						$appe["tableContent[loc = report_tr][pos = row_" .($i + 1). "]"][]				= "tableContent loc = report_td pos = row_" .($i + 1). " cell = update";
						$appe["tableContent[loc = report_td][pos = row_" .($i + 1). "][cell = update]"][]
																																											= "detial_button id = open_function functionID = " .self::$pubVar["tableInfo"]["public"]["tablename"]. " updateId = m" .($i + 1). " cell = update";
						$attr["detial_button[id = open_function][updateId = m" .($i + 1). "]"]["insertHtmlText"]
																																											= "修改";
						
						switch($args["Option"])
						{
							
							case "custom_account":
							
								$attr["detial_button[id = open_function][updateId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Update:unicode=" .$eachData["unicode"]. ",function=" .$args["Option"]. "}");
								break;
								
							case "MG_custom_product":
							
								$attr["detial_button[id = open_function][updateId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Update:unicode=" .$eachData["unicode"]. ",productID=" .$eachData["productID"]. ",function=custom_product}");
								break;
								
							/*case "user_email":
							
								break;*/
								
							case "product_data":
							
								$attr["detial_button[id = open_function][updateId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Update:unicode=" .$eachData["unicode"]. ",function=" .$args["Option"]. "}");
								break;
								
							case "xuser_data":
							
								$attr["detial_button[id = open_function][updateId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Update:userid=" .$eachData["userid"]. ",function=" .$args["Option"]. "}");
								break;
								
						}
						
					}
					
				}
				
			}
			
			if($totalPages > 1)
			{
				
				$appe[]																																					= "page-container";
				//$attr["page-container"]["insertHtmlText"]																				= "123";
			
				if($currentPage > 1)
				{
			
					$appe["page-container"][]																												= "page page = left"; 
    			$attr["page[page = left]"]["insertHtmlText"]																		= "&#xf053";
    			$attr["page[page = left]"]["url"]																								= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=".$args["Option"].",page=".($currentPage - 1)."}");
    			
    		}

				for ($i = 1; $i <= $totalPages; $i++)
				{
					
					$appe["page-container"][]																											= "page page = ".$i; 
    			$attr["page[page = ".$i."]"]["insertHtmlText"]																= $i;
    			$attr["page[page = ".$i."]"]["url"]																						= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=".$args["Option"].",page=".$i."}");
				
					if($i == $currentPage)
					{
						
						$attr["page[page = ".$i."]"]["style"]																				= "color: red";
						
					}
				
				}
				
				if($currentPage != $totalPages)
				{
				
					$appe["page-container"][]																												= "page page = right"; 
    			$attr["page[page = right]"]["insertHtmlText"]																		= "&#xf054";
					$attr["page[page = right]"]["url"]																							= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=".$args["Option"].",page=".($currentPage + 1)."}");
				
				}
				
			}
			
																																							
			self::$pubVar["exportJson"]["appendHtml"]																		= $appe;
			self::$pubVar["exportJson"]["attrHtml"]																			= $attr;
			
		}
	
}

	$PlantFormAjax = new PlantFormAjax();

?>
