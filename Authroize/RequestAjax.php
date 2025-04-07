<?php

	class RequestAjax
	{
		
		public static $pubVar = array();
		
		function __construct()
		{
			
		require("PlantFunction.php");
			
		}
		
		public static function CheckLogin()
		{
			
			SQLEvent::connectDB();
			SQLEvent::$statement 																								= "select * from custom_account where email = '" .trim($_POST["email"]). "' AND password = '" .trim($_POST["password"]). "'";
			SQLEvent::PDOEvent();
			
			$state																															= SQLEvent::$fetch;
			//print_r($state[0]["unicode"]);
			
			if(!$state){
				
				$message["status"]																								= "error";
				
			}else{
				
				$message["status"]																								= "success";
				$message["redirect"]																							= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{UserInfo}");
				$_SESSION["user_unicode"]																					= $state[0]["unicode"];
					
			}
			
			
			self::$pubVar["exportJson"]																					= $message;	
			
		}
		
		public static function SignOut()
		{
			
			session_unset();
			$message																														= "reload";
			self::$pubVar["exportJson"]																					= $message;	
			
		}
		
		public static function CheckReg()
		{
			
			SQLEvent::connectDB();
	
			Shared::$pubVar["string_len"]																				= 10;
			Shared::randomString();
			$unicode																														= Shared::$pubVar["random_string"];
			SQLEvent::CheckUnicode($unicode);
			$Unicode																														= SQLEvent::$RealUnicode;
			
			
			/*catch date and time*/
			$currentDate 																												= date('Y-m-d');
			$currentTime 																												= date('H:i:s');
			
			/*checkpassword*/
			SQLEvent::$statement 																								= "select password from custom_account where password = '" .trim($_POST["password"]). "'";
			SQLEvent::PDOEvent();
			$Passwordstate 																											= SQLEvent::$fetch;
			/*checkemail*/
			SQLEvent::$statement 																								= "select email from custom_account where email = '" .trim($_POST["email"]). "'";
			SQLEvent::PDOEvent();
			$Emailstate 																												= SQLEvent::$fetch;
			
			if($Emailstate){
				
				$CheckReg 																												= "email_error";
					
			}else if($Passwordstate){
				
				$CheckReg 																												= "password_error";
				
			}else if(!$Emailstate && !$Passwordstate){
				
				SQLEvent::$statement 																							= "INSERT INTO custom_account (unicode ,accountID, password, email, registDate, registTime, isValid) VALUES ('" .$Unicode. "', '" .trim($_POST["username"]). "', '" .trim($_POST["password"]). "', '" .trim($_POST["email"]). "', '" .$currentDate. "', '" .$currentTime. "', '1')";
				SQLEvent::PDOEvent();
				
				SQLEvent::$statement 																							= "INSERT INTO custom_product (unicode ,accountID, productID, productName, version, process, isValid) VALUES ('" .$Unicode. "', '" .trim($_POST["username"]). "', '2000000', 'LIS', '1.0.1', '0', '1')";
				SQLEvent::PDOEvent();
				
				SQLEvent::$statement 																							= "INSERT INTO custom_product (unicode ,accountID, productID, productName, version, process, isValid) VALUES ('" .$Unicode. "', '" .trim($_POST["username"]). "', '5000000', 'simsTW', '1.0.0', '0', '1')";
				SQLEvent::PDOEvent();
				
				$CheckReg 																												= "success";
				
			}
				
			self::$pubVar["exportJson"]																					= $CheckReg;
	
		}
		
		public static function CheckEmail()
		{
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "select email from custom_account where email = '" .trim($_POST["email"]). "'";
			SQLEvent::PDOEvent();
			$state																															= SQLEvent::$fetch;
	
			if($state){
		
				$message 																													= "error";
		
			}
		
			self::$pubVar["exportJson"]																					= $message;
				
		}
		
		public static function CheckPW()
		{
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "select email from custom_account where password = '" .trim($_POST["password"]). "'";
			SQLEvent::PDOEvent();
			$state																															= SQLEvent::$fetch;
	
			if($state){
		
				$message 																													= "error";
		
			}
		
			self::$pubVar["exportJson"]																					= $message;
				
		}
		
		public static function SendEmail()
		{
			
			SQLEvent::connectDB();  
			Shared::$pubVar["string_len"]																			  = 10;
			Shared::randomString();
			$token																															= Shared::$pubVar["random_string"];
			
   		SQLEvent::$statement																								= "insert into user_email (token, aging) values ('".$token."' ,GETDATE())";
			SQLEvent::PDOevent();
			
			require("sendmail.php");
			
			$Data																																= $token. "|" .$_POST["email"];
			$encryptDate																												= openssl_encrypt($Data, $GLOBALS["sendmail"]["method"], $GLOBALS["sendmail"]["key"], 0, $GLOBALS["sendmail"]["iv"]);
			$BencryptDate																												= base64_encode($encryptDate);
			
			sendmail::$subject																									= "驗證您的信箱";
			sendmail::$thr_title																								= "感謝您加入我們！";
			sendmail::$content																									= "為確保您的權益，請點擊下面的按鈕驗證您的電子信箱：|如果您尚未註冊我們的網站，您可以無視此訊息";
			sendmail::$useremail																								= trim($_POST["email"]);
			
      $verificationLink 																									= "http://192.168.1.173/otherwindow/VerifyEmail.php?verify=".urlencode($BencryptDate);
      sendmail::$maincontent																							= "<a href='" .$verificationLink. "' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #0080FF; color: #fff; text-decoration: none; border-radius: 5px; font-size: 18px;'>撽??靽∠拳</a>";
      sendmail::mailcontent();
      
			
		}
		
		public static function ChangeEmail()
		{
			

			SQLEvent::connectDB();  
			Shared::$pubVar["string_len"]																				= 10;
			Shared::randomString();
			$token																															= Shared::$pubVar["random_string"];
					
   		SQLEvent::$statement																								= "insert into user_email (token, aging) values ('".$token."' ,GETDATE())";
			SQLEvent::PDOevent();
			
			require("sendmail.php");
			
			$Data																																= $token. "|" .$_POST["email"]. "|" .$_SESSION["user_unicode"];
			$encryptDate																												= openssl_encrypt($Data, $GLOBALS["sendmail"]["method"], $GLOBALS["sendmail"]["key"], 0, $GLOBALS["sendmail"]["iv"]);
			$BencryptDate																												= base64_encode($encryptDate);
			
			sendmail::$subject																									= "驗證您的信箱";
			sendmail::$thr_title																								= "您更改了您的信箱";
			sendmail::$content																									= "為確保您的權益，請點擊下面的按鈕驗證您的電子信箱：|如果您並未註冊我們的網站，您可以無視此訊息";
			sendmail::$useremail																								= $_POST["email"];
      $verificationLink 																									= "http://192.168.1.173/otherwindow/VerifyChangeEmail.php?verify=" .$BencryptDate;
      sendmail::$maincontent																							= "<a href='" . $verificationLink . "' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #0080FF; color: #fff; text-decoration: none; border-radius: 5px; font-size: 18px;'>撽??靽∠拳</a>";
      sendmail::mailcontent();
      
			
		}
		
		public static function CheckEmailVerify()
		{
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "select email from user_email where email = '" .$_POST["email"]. "'";
			SQLEvent::PDOEvent();
			$state																															= SQLEvent::$fetch;
			
			
			if($state){
				
				$message["status"]																								= "email is pass!";
				$message["redirect"]																							= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{CheckReg}");
				
			}else{
				
				$message["status"]																								= "error";
				
			}
			
			self::$pubVar["exportJson"]																					=  $message;
			
		}
		
		public static function CheckFGEmail()
		{
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "select email from custom_account where email = '" .trim($_POST["email"]). "'";
			SQLEvent::PDOEvent();
			$state																															= SQLEvent::$fetch;
	
			if(!$state){
		
				$error_message																										= "error";
		
			}else{
				
				SQLEvent::connectDB();  
				Shared::$pubVar["string_len"]																			= 10;
				Shared::randomString();
				$token																														= Shared::$pubVar["random_string"];
	
   			SQLEvent::$statement																							= "update custom_account set password = '" .$token. "' where email = '" .$_POST["email"]. "'";
				SQLEvent::PDOevent();
				
				require("sendmail.php");
				
				sendmail::$subject																								= "您的新密碼";
				sendmail::$thr_title																							= "您忘記密碼了嗎？";
				sendmail::$content																								= "我們修改了您的舊密碼，以下是您的新密碼：|請您使用新密碼登入，並自行修改此密碼";
				sendmail::$useremail																							= $_POST["email"];
				sendmail::$maincontent																						=	"<p style='display: inline-block; margin-top: 20px; color: #0080FF; text-decoration: none; border-radius: 5px; font-size: 24px;'>" .$token. "</p>";		
				sendmail::mailcontent();
	
			}
		
			self::$pubVar["exportJson"]																					= $error_message;
				
		}
		
		public static function ChangeID()
		{
			
			$currentDate 																												= date('Y-m-d');
			$currentTime 																												= date('H:i:s');
			SQLEvent::connectDB();
			SQLEvent::$statement 																								= "update custom_account set accountID = '" .trim($_POST["username"]). "', modifyDate = '" .$currentDate. "', modifyTime = '" .$currentTime. "', modifyMan = '" .$_SESSION["user_email"]. "' where unicode = '" .$_SESSION["user_unicode"]. "'";
			SQLEvent::PDOEvent();
			SQLEvent::$statement 																								= "update custom_product set accountID = '" .trim($_POST["username"]). "', modifyDate = '" .$currentDate. "', modifyTime = '" .$currentTime. "', modifyMan = '" .$_SESSION["user_email"]. "' where unicode = '" .$_SESSION["user_unicode"]. "'";
			SQLEvent::PDOEvent();
			
		}
		
		public static function Download()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			$currentDate 																												= date('Y-m-d');
			$currentTime 																												= date('H:i:s');
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "update custom_product set isRegist = 1, isDownload = 1, downDate = '" .$currentDate. "', downTime = '" .$currentTime. "' where unicode = '" .$_SESSION["user_unicode"]. "' and productID = '" .$args["productID"]. "'";
			SQLEvent::PDOEvent();
			
		}
		
		public static function ChangePassword()
		{ 
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "select * from custom_account where unicode = '" .$_SESSION["user_unicode"]. "' and password = '" .$_POST["SU-password"]. "'";
			SQLEvent::PDOEvent();
			$SUdata																															= SQLEvent::$fetch;
			
			SQLEvent::$statement																								= "select * from custom_account where password = '" .$_POST["new-password"]. "'";
			SQLEvent::PDOEvent();
			$NEWdata																														= SQLEvent::$fetch;
			
			if(!$SUdata){
				
				$message																													= "SU-error";
				
			}else if($NEWdata){
				
				$message																													= "new-error";
				
			}
			
			else if($SUdata && !$NEWdata){
				
				SQLEvent::$statement																							= "update custom_account set password = '" .$_POST["new-password"]. "' where unicode = '" .$_SESSION["user_unicode"]. "'";
				SQLEvent::PDOEvent();
				
			}
			
			self::$pubVar["exportJson"]																					= $message;
			
		}
		
		/*後臺功能*/
		/*後台登入*/
		public static function MasterLogin(){
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "select * from xuser_data where userid = '" .$_POST["username"]. "' and userpwd = '" .$_POST["password"]. "'";
			SQLEvent::PDOEvent();
			$data																																= SQLEvent::$fetch;
			
			$message["username"] = $_POST["username"];
			$message["password"] = $_POST["password"];
			
			if(!$data){
				
				$message["status"]																								= "error";
				
			}else{
				
				$message["status"]																								= "success";
				$message["redirect"]																							= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{masterHome}");
				$_SESSION["userid"]																								= $data[0]["userid"];
				$_SESSION["userpwd"]																							= $data[0]["userpwd"];
					
			}
			
			
			self::$pubVar["exportJson"]																					= $message;	
			
			
		}
		
		/*表單功能*/
		/*刪除*/
		public static function Delete()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			SQLEvent::connectDB();
			
			switch($args["table"])
			{
				
				case "custom_account":
				
					SQLEvent::$statement																						= "delete from " .$args["table"]. " where unicode = '" .$args["unicode"]. "'";
					$reload																													= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=" .$args["table"]. "}");
				
					break;
					
				case "user_email":
				
					if($args["token"])
					{
						
						SQLEvent::$statement																					= "delete from " .$args["table"]. " where token = '" .$args["token"]. "'";
						
					}else{
						
						
						SQLEvent::$statement																					= "delete from " .$args["table"]. " where email is NULL";
						
					}
				
					$reload																													= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=" .$args["table"]. "}");
					
					break;
					
				case "custom_product":
				
					SQLEvent::$statement																						= "delete from " .$args["table"]. " where unicode = '" .$args["unicode"]. "' and productID = '" .$args["productID"]. "'";
					$reload																													= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=MG_custom_product}");
					
					break;
					
				case "product_data":
				
					SQLEvent::$statement																						= "delete from " .$args["table"]. " where unicode = '" .$args["unicode"]. "' and productID = '" .$args["productID"]. "'";
					$reload																													= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=" .$args["table"]. "}");
				
					break;
					
				case "xuser_data":
				
					SQLEvent::$statement																						= "delete from " .$args["table"]. " where userid = '" .$args["userid"]. "'";
					$reload																													= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=" .$args["table"]. "}");
				
					break;
				
			}
			
			SQLEvent::PDOEvent();
	
			self::$pubVar["exportJson"]																					= $reload;
			
		}
		
		/*獲取修改畫面*/
		public static function Update()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			switch($args["function"])
			{
				
				case "custom_account":
				
					PlantFunction::$garmmar																					= "select * from " .$args["function"]. " where unicode = '" .$args["unicode"]. "'";
				
					break;
					
				case "custom_product":
				
					PlantFunction::$garmmar																					= "select * from " .$args["function"]. " where unicode = '" .$args["unicode"]. "' and productID = '" .$args["productID"]. "'";
				
					break;
					
				/*case "user_email":
				
					break;*/
				
				case "product_data":
				
					PlantFunction::$garmmar																					= "select * from " .$args["function"]. " where unicode = '" .$args["unicode"]. "'";
				
					break;
					
				case "xuser_data":
				
					PlantFunction::$garmmar																					= "select * from " .$args["function"]. " where userid = '" .$args["userid"]. "'";
				
					break;
					
			}
			
			PlantFunction::$function																						= $args["function"];
			PlantFunction::Update();
			
			$J["appendHtml"]																										= PlantFunction::$pubVar["Update"]["appendHtml"];
			$J["attrHtml"]																											= PlantFunction::$pubVar["Update"]["attrHtml"];
			$J["status"]																												= "workeare";
			self::$pubVar["exportJson"]																					= $J;
			
		}
		
		/*修改*/
		public static function userUpdate()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			$currentDate 																												= date('Y-m-d');
			$currentTime 																												= date('H:i:s');
			
			
			if($_POST["username"]  && $_POST["password"])
			{
			
				SQLEvent::connectDB();
				SQLEvent::$statement																							= "update " .$args["table"]. " set accountID = '" .$_POST["username"]. "' , password = '" .$_POST["password"]. "', modifyDate = '" .$currentDate. "' , modifyTime = '" .$currentTime. "' where unicode = '" .$_POST["unicode"]. "' and email = '" .$_POST["email"]. "'";
				SQLEvent::PDOEvent();
				SQLEvent::$statement																							= "update custom_product set accountID = '" .$_POST["username"]. "' where unicode = '" .$_POST["unicode"]. "'";
				SQLEvent::PDOEvent();
				
				$J["status"]																											= "success";
				$J["reload"]																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=" .$args["table"]. "}");
				
			}else{
				
				PlantFunction::$error																							= "!! 不可有空白欄位";
				PlantFunction::error();
				
				$J["status"]																											= "error";
				$J["appendHtml"]																									= PlantFunction::$pubVar["Error"]["appendHtml"];
				$J["attrHtml"]																										= PlantFunction::$pubVar["Error"]["attrHtml"];
				
			}
			
			self::$pubVar["exportJson"]																					= $J;
			
		}
		
		public static function userProductUpdata()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			$currentDate 																												= date('Y-m-d');
			$currentTime 																												= date('H:i:s');
			
			if($_POST["username"]  && $_POST["productName"])
			{
			
				SQLEvent::connectDB();
				SQLEvent::$statement																							= "update " .$args["table"]. " set accountID = '" .$_POST["username"]. "' , productName = '" .$_POST["productName"]. "', modifyDate = '" .$currentDate. "' , modifyTime = '" .$currentTime. "', IPAddr = '" .$_POST["IPAddr"]. "' where unicode = '" .$_POST["unicode"]. "' and productID = '" .$_POST["productID"]. "'";
				SQLEvent::PDOEvent();
				
				$J["status"]																											= "success";
				$J["reload"]																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=MG_custom_product}");
				
			}else{
				
				PlantFunction::$error																							= "!! 帳號與產品名稱不可空白";
				PlantFunction::error();
				
				$J["status"]																											= "error";
				$J["appendHtml"]																									= PlantFunction::$pubVar["Error"]["appendHtml"];
				$J["attrHtml"]																										= PlantFunction::$pubVar["Error"]["attrHtml"];
				
			}
			
			self::$pubVar["exportJson"]																					= $J;
	
		}
		
		public static function productUpdata()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			$currentDate 																												= date('Y-m-d');
			$currentTime 																												= date('H:i:s');
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "update " .$args["table"]. " set productCName = '" .$_POST["productCName"]. "' , productEName = '" .$_POST["productEName"]. "' , modifyDate = '" .$currentDate. "' , modifyTime = '" .$currentTime. "' , version = '" .$_POST["version"]. "' where unicode = '" .$_POST["unicode"]. "' and productID = '" .$_POST["productID"]. "'";
			SQLEvent::PDOEvent();
				
			$J["status"]																												= "success";
			$J["reload"]																												= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=" .$args["table"]. "}");
			
			self::$pubVar["exportJson"]																					= $J;
			
			
		}
		
		public static function xuserUpdata()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			$currentDate 																												= date('Y-m-d');
			$currentTime 																												= date('H:i:s');
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "update " .$args["table"]. " set username = '" .$_POST["username"]. "', modifyDate = '" .$currentDate. "' , modifyTime = '" .$currentTime. "' , userpwd = '" .$_POST["userpwd"]. "' , exeid = '" .$_POST["exeid"]. "' where userid = '" .$_POST["userid"]. "'";
			SQLEvent::PDOEvent();
				
			$J["status"]																												= "success";
			$J["reload"]																												= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=" .$args["table"]. "}");
			
			self::$pubVar["exportJson"]																					= $J;
			
		}
		
		/*獲取新增畫面*/
		public static function Add()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			PlantFunction::$function																						= $args["function"];
			PlantFunction::Add();
			
			$J["appendHtml"]																										= PlantFunction::$pubVar["Update"]["appendHtml"];
			$J["attrHtml"]																											= PlantFunction::$pubVar["Update"]["attrHtml"];
			$J["status"]																												= "workeare";
			self::$pubVar["exportJson"]																					= $J;
			
		}
		
		/*新增*/
		public static function userAdd()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			SQLEvent::connectDB();
	
			Shared::$pubVar["string_len"]																				= 10;
			Shared::randomString();
			$unicode																														= Shared::$pubVar["random_string"];
			SQLEvent::CheckUnicode($unicode);
			$Unicode																														= SQLEvent::$RealUnicode;

			$currentDate 																												= date('Y-m-d');
			$currentTime 																												= date('H:i:s');
			
			/*checkpassword*/
			SQLEvent::$statement 																								= "select password from custom_account where password = '" .trim($_POST["password"]). "'";
			SQLEvent::PDOEvent();
			$Passwordstate 																											= SQLEvent::$fetch;
			/*checkemail*/
			SQLEvent::$statement 																								= "select email from custom_account where email = '" .trim($_POST["email"]). "'";
			SQLEvent::PDOEvent();
			$Emailstate 																												= SQLEvent::$fetch;
			
			if($Emailstate){
				
				PlantFunction::$error																							= "!! 信箱已存在";
				PlantFunction::error();
				
				$J["status"]																											= "error";
				$J["appendHtml"]																									= PlantFunction::$pubVar["Error"]["appendHtml"];
				$J["attrHtml"]																										= PlantFunction::$pubVar["Error"]["attrHtml"];
					
			}else if($Passwordstate){
				
				PlantFunction::$error																							= "!! 密碼已存在";
				PlantFunction::error();
				
				$J["status"]																											= "error";
				$J["appendHtml"]																									= PlantFunction::$pubVar["Error"]["appendHtml"];
				$J["attrHtml"]																										= PlantFunction::$pubVar["Error"]["attrHtml"];
				
			}else if(!$Emailstate && !$Passwordstate){
				
				SQLEvent::$statement 																							= "INSERT INTO " .$args["table"]. " (unicode ,accountID, password, email, registDate, registTime, isValid) VALUES ('" .$Unicode. "', '" .trim($_POST["username"]). "', '" .trim($_POST["password"]). "', '" .trim($_POST["email"]). "', '" .$currentDate. "', '" .$currentTime. "', '0')";
				SQLEvent::PDOEvent();
				
				SQLEvent::$statement 																							= "INSERT INTO custom_product (unicode ,accountID, productID, productName, version, process, isValid) VALUES ('" .$Unicode. "', '" .trim($_POST["username"]). "', '2000000', 'LIS', '1.0.1', '0', '1')";
				SQLEvent::PDOEvent();
				
				SQLEvent::$statement 																							= "INSERT INTO custom_product (unicode ,accountID, productID, productName, version, process, isValid) VALUES ('" .$Unicode. "', '" .trim($_POST["username"]). "', '5000000', 'simsTW', '1.0.0', '0', '1')";
				SQLEvent::PDOEvent();
				
				$J["status"] 																											= "success";
				$J["reload"]																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=" .$args["table"]. "}");
				
			}
				
			self::$pubVar["exportJson"]																					= $J;
			
		}
		
		public static function productAdd()
		{
		
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "select * from " .$args["table"]. " where unicode = '" .$_POST["unicode"]. "'";
			SQLEvent::PDOEvent();
			$unicode																														= SQLEvent::$fetch;
			
			SQLEvent::$statement																								= "select * from " .$args["table"]. " where productID = '" .$_POST["productID"]. "'";
			SQLEvent::PDOEvent();
			$productID																													= SQLEvent::$fetch;
			
			if($unicode)
			{
				
				PlantFunction::$error																							= "!! 產品序號已存在";
				PlantFunction::error();
				
				$J["status"]																											= "error";
				$J["appendHtml"]																									= PlantFunction::$pubVar["Error"]["appendHtml"];
				$J["attrHtml"]																										= PlantFunction::$pubVar["Error"]["attrHtml"];
				
			}else if($productID){
				
				PlantFunction::$error																							= "!! 產品編號已存在";
				PlantFunction::error();
				
				$J["status"]																											= "error";
				$J["appendHtml"]																									= PlantFunction::$pubVar["Error"]["appendHtml"];
				$J["attrHtml"]																										= PlantFunction::$pubVar["Error"]["attrHtml"];
				
			}else{
				
				SQLEvent::$statement																							= "insert into " .$args["table"]. " (unicode, productID, productName, productCName, productEName, version) values ('" .$_POST["unicode"]. "', '" .$_POST["productID"]. "', '" .$_POST["productName"]. "', '" .$_POST["productCName"]. "', '" .$_POST["productEName"]. "', '" .$_POST["version"]. "')";
				SQLEvent::PDOEvent();
				
				$J["status"] 																											= "success";
				$J["reload"]																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=" .$args["table"]. "}");
				
			}
			
			self::$pubVar["exportJson"]																					= $J;
			
		}
		
		public static function userProductAdd()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "select * from custom_account where unicode = '" .$_POST["unicode"]. "'";
			SQLEvent::PDOEvent();
			$unicode																														= SQLEvent::$fetch;

			if(!$unicode)
			{
				
				PlantFunction::$error																							= "!! 帳號識別碼不存在";
				PlantFunction::error();
				
				$J["status"]																											= "error";
				$J["appendHtml"]																									= PlantFunction::$pubVar["Error"]["appendHtml"];
				$J["attrHtml"]																										= PlantFunction::$pubVar["Error"]["attrHtml"];
				
			}else{
				
				SQLEvent::$statement																							= "select * from product_data where productID = '" .$_POST["productID"]. "'";
				SQLEvent::PDOEvent();
				$data																															= SQLEvent::$fetch;
				
				SQLEvent::$statement																							= "insert into " .$args["table"]. " (unicode, accountID, productID, productName, version) values ('" .$_POST["unicode"]. "', '" .$_POST["accountID"]. "' ,'" .$_POST["productID"]. "', '" .$_POST["productName"]. "', '" .$data[0]["version"]. "')";
				SQLEvent::PDOEvent();
				
				$J["status"] 																											= "success";
				$J["reload"]																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=MG_custom_product}");
				
			}
			
			self::$pubVar["exportJson"]																					= $J;
			
		}
		
		public static function xuserAdd()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			SQLEvent::connectDB();
			SQLEvent::$statement																								= "insert into " .$args["table"]. " (userid,  username, userpwd, exeid) values ('" .$_POST["userid"]. "', '" .$_POST["username"]. "', '" .$_POST["userpwd"]. "', '" .$_POST["exeid"]. "')";
			SQLEvent::PDOEvent();
			
			$J["reload"]																												= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=xuser_data}");
			
			self::$pubVar["exportJson"]																					= $J;
			
		}
		
		/*搜尋*/
		public static function search()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			switch($args["function"])
			{
				
				case "custom_account":
				
					PlantFunction::$garmmar																					= "select * from " .$args["function"]. " where unicode like '%" .$_POST["search"]. "%' or accountID like '%" .$_POST["search"]. "%' or email like '%" .$_POST["search"]. "%' or password like '%" .$_POST["search"]. "%' or registDate like '%" .$_POST["search"]. "%'";
					PlantFunction::$function																				= $args["function"];
				
					break;
					
				case "user_email":
				
					PlantFunction::$garmmar																					= "select * from " .$args["function"]. " where email like '%" .$_POST["search"]. "%' or token like '%" .$_POST["search"]. "%' or aging like '%" .$_POST["search"]. "%'";
					PlantFunction::$function																				= $args["function"];
				
					break;
					
				case "custom_product":
				
					PlantFunction::$garmmar																					= "select * from " .$args["function"]. " where unicode like '%" .$_POST["search"]. "%' or accountID like '%" .$_POST["search"]. "%' or productID like '%" .$_POST["search"]. "%' or registCode like '%" .$_POST["search"]. "%' or MCode like '%" .$_POST["search"]. "%' or MAC like '%" .$_POST["search"]. "%' or IPAddr like '%" .$_POST["search"]. "%'";
					PlantFunction::$function																				= "MG_custom_product";
				
					break;
					
				case "product_data":
				
					PlantFunction::$garmmar																					= "select * from " .$args["function"]. " where unicode like '%" .$_POST["search"]. "%' or productID like '%" .$_POST["search"]. "%' or productCName like '%" .$_POST["search"]. "%' or productEName like '%" .$_POST["search"]. "%' or version like '%" .$_POST["search"]. "%'";
					PlantFunction::$function																				= $args["function"];
				
					break;
					
				case "xuser_data":
				
					PlantFunction::$garmmar																					= "select * from " .$args["function"]. " where userid like '%" .$_POST["search"]. "%' or username like '%" .$_POST["search"]. "%' or userpwd like '%" .$_POST["search"]. "%' or exeid like '%" .$_POST["search"]. "%' or modifyDate like '%" .$_POST["search"]. "%'";
					PlantFunction::$function																				= $args["function"];
				
					break;
				
			}
			
			PlantFunction::search();
			
			$J["appendHtml"]																										= PlantFunction::$pubVar["search"]["appendHtml"];
			$J["attrHtml"]																											= PlantFunction::$pubVar["search"]["attrHtml"];
			$J["status"]																												= "workeare";
			self::$pubVar["exportJson"]																					= $J;
			
		}
		
		public static function insertInfo()
		{
			
			Shared::$pubVar["loadVars"]																					= self::$pubVar["loadVars"];
			Shared::parseArgs();
			$args																																= Shared::$pubVar["loadVars"];
			
			switch($args["table"])
			{
				
				case "product_data":
				
					SQLEvent::connectDB();
					SQLEvent::$statement																						= "select productName from " .$args["table"]. " where productID = '" .$args["productID"]. "'";
					SQLEvent::PDOEvent();
				
					break;
				
			}
			
			$data																																= SQLEvent::$fetch;
			//print_r($data[0]["productName"]);
			
			self::$pubVar["exportJson"]																					= $data[0]["productName"];
			
		}
		
		/*public static function selectPage()
		{
			
			
			
		}*/
		
	}
	
	$RequestAjax = new RequestAjax();
	
?>
