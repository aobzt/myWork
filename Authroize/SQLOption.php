<?php

	class SQLOption
	{
		
		public static $pubVar = array();		
		
		function __construct()
		{
			
			//require("SQLEvent.php");
			
		}
		
		public static function custom_product()
		{
			
			$pub["tablename"]															= "custom_product";
			$pub["control_cell"]													= true;
			
			$rep[]																				= "ProductName";
			$rep[]																				= "registCode";
			$rep[]																				= "version";
			$rep[]																				= "expireDate";
			$rep[]																				=	"activeDate";
			
			$det[]																				= "unicode";
			$det[]																				= "accountID";
			$det[]																				= "productName";
			$det[]																				= "productID";
			$det[]																				= "activeCode";
			$det[]																				= "registCode";
			$det[]																				= "version";
			$det[]																				= "expireDate";
			$det[]																				= "activeDate";
			$det[]																				= "process";
			$det[]																				= "isRegist";
			$det[]																				= "downDate";
			$det[]																				= "downTime";
			$det[]																				= "MAC";
			
			self::$pubVar[__FUNCTION__]["report"]					= $rep;
			self::$pubVar[__FUNCTION__]["detial"]					= $det;
			self::$pubVar[__FUNCTION__]["public"]					= $pub;
			
		}
		
		public static function custom_account()
		{
			
			$pub["tablename"]															= "custom_account";
			$pub["SQLCountGrammar"]												= "select count(*) as total from custom_account";
			$pub["SQLGrammar"]														= "SELECT unicode, accountID, password, email, registDate, isValid, modifyDate FROM ( SELECT * , ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) AS RowNum FROM custom_account) AS NumberedRows WHERE RowNum BETWEEN _firstNumber_ AND _secondNumber_";
			$pub["title"]																	= "會員帳號管理";
			$pub["add_url"]																= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Add:function=custom_account}");
			$pub["search_url"]														= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{search:function=custom_account}");
			$pub["add_cell"]															= true;
			$pub["deleteAll_cell"]												= false;
			$pub["control_cell"]													= false;
			$pub["delete_cell"]														= true;
			$pub["update_cell"]														= true;
			
			$rep[]																				= "Unicode|帳號識別碼";
			$rep[]																				= "Username|帳號名稱";
			$rep[]																				= "E-mail|電子信箱";
			$rep[]																				= "Password|密碼";
			$rep[]																				=	"RegistDate|註冊日期";
			$rep[]																				=	"ModifyDate|修改日期";
			$rep[]																				= "IsValid|驗證";
			
			$det[]																				= "unicode";
			$det[]																				= "accountID";
			$det[]																				= "password";
			$det[]																				= "email";
			$det[]																				= "registDate";
			$det[]																				= "registTime";
			$det[]																				= "isValid";
			$det[]																				= "ModifyDate";
			$det[]																				= "MofifyTime";
			$det[]																				= "UserID";
			
			self::$pubVar[__FUNCTION__]["report"]					= $rep;
			self::$pubVar[__FUNCTION__]["detial"]					= $det;
			self::$pubVar[__FUNCTION__]["public"]					= $pub;
			
			
		}
		
		public static function user_email()
		{
			
			$pub["tablename"]															= "user_email";
			$pub["SQLCountGrammar"]												= "select count(*) as total from user_email";
			$pub["SQLGrammar"]														= "SELECT email, token, aging FROM ( SELECT * , ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) AS RowNum FROM user_email) AS NumberedRows WHERE RowNum BETWEEN _firstNumber_ AND _secondNumber_";
			$pub["title"]																	= "信箱驗證管理";
			$pub["deleteAll_url"]													= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:table=user_email}");
			$pub["search_url"]														= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{search:function=user_email}");
			$pub["add_cell"]															= false;
			$pub["deleteAll_cell"]												= false;
			$pub["control_cell"]													= false;
			$pub["delete_cell"]														= true;
			$pub["update_cell"]														= false;
			
			$rep[]																				= "E-mail|電子信箱";
			$rep[]																				= "Token|驗證代碼";
			$rep[]																				= "Aging|驗證日期與時間";
			
			self::$pubVar[__FUNCTION__]["report"]					= $rep;
			//self::$pubVar[__FUNCTION__]["detial"]					= $det;
			self::$pubVar[__FUNCTION__]["public"]					= $pub;
			
			
		}
		
		public static function MG_custom_product()
		{
			
			$pub["tablename"]															= "custom_product";
			$pub["SQLCountGrammar"]												= "select count(*) as total from custom_product";
			$pub["SQLGrammar"]														= "SELECT unicode, accountID, productID, productName, registCode, MCode, MAC, IPAddr FROM ( SELECT * , ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) AS RowNum FROM custom_product) AS NumberedRows WHERE RowNum BETWEEN _firstNumber_ AND _secondNumber_";
			$pub["title"]																	= "用戶產品管理";
			$pub["add_url"]																= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Add:function=custom_product}");
			$pub["search_url"]														= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{search:function=custom_product}");
			$pub["add_cell"]															= true;
			$pub["deleteAll_cell"]												= false;
			$pub["control_cell"]													= false;
			$pub["delete_cell"]														= true;
			$pub["update_cell"]														= true;
			
			$rep[]																				= "Unicode|帳號識別碼";
			$rep[]																				= "AccountID|帳號名稱";	
			$rep[]																				= "ProductName|產品名稱";
			//$rep[]																				= "ActiveCode|啟動碼";
			$rep[]																				= "RegistCode|註冊碼";
			$rep[]																				= "MCode|MCode";
			$rep[]																				= "MAC|MAC位址";
			$rep[]																				= "IPAddr|IP位址";
			
			$det[]																				= "unicode";
			$det[]																				= "accountID";
			$det[]																				= "productName";
			$det[]																				= "productID";
			$det[]																				= "activeCode";
			$det[]																				= "registCode";
			$det[]																				= "version";
			$det[]																				= "expireDate";
			$det[]																				= "activeDate";
			$det[]																				= "activeTime";
			$det[]																				= "process";
			$det[]																				= "isRegist";
			$det[]																				= "downDate";
			$det[]																				= "downTime";
			$det[]																				= "MAC";
			
			self::$pubVar[__FUNCTION__]["report"]					= $rep;
			self::$pubVar[__FUNCTION__]["detial"]					= $det;
			self::$pubVar[__FUNCTION__]["public"]					= $pub;
			
		}
		
		public static function product_data()
		{
			
			$pub["tablename"]															= "product_data";
			$pub["SQLCountGrammar"]												= "select count(*) as total from product_data";
			$pub["SQLGrammar"]														= "SELECT unicode, productID, productName, productCName, productEName, version, modifyDate FROM ( SELECT * , ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) AS RowNum FROM product_data) AS NumberedRows WHERE RowNum BETWEEN _firstNumber_ AND _secondNumber_";
			$pub["title"]																	= "產品管理";
			$pub["add_url"]																= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Add:function=product_data}");
			$pub["search_url"]														= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{search:function=product_data}");
			$pub["add_cell"]															= true;
			$pub["deleteAll_cell"]												= false;
			$pub["control_cell"]													= false;
			$pub["delete_cell"]														= true;
			$pub["update_cell"]														= true;
			
			$rep[]																				= "Unicode|產品序號";
			$rep[]																				= "ProductID|產品編號";	
			$rep[]																				= "ProductCName|產品中文名稱";
			$rep[]																				= "ProductEName|產品英文名稱";
			$rep[]																				= "Version|產品版本";
			$rep[]																				= "ModifyDate|修改日期";
			
			$det[]																				= "unicode";
			$det[]																				= "productID";
			$det[]																				= "productName";
			$det[]																				= "productCName";
			$det[]																				= "roductEName";
			$det[]																				= "version";
			$det[]																				= "expireDate";
			$det[]																				= "insDate";
			$det[]																				= "insTime";
			$det[]																				= "insMan";
			$det[]																				= "modifyDate";
			$det[]																				= "modifyTime";
			$det[]																				= "modifyMan";

			self::$pubVar[__FUNCTION__]["report"]					= $rep;
			self::$pubVar[__FUNCTION__]["detial"]					= $det;
			self::$pubVar[__FUNCTION__]["public"]					= $pub;
			
		}
		
		public static function xuser_data()
		{
			
			$pub["tablename"]															= "xuser_data";
			$pub["SQLCountGrammar"]												= "select count(*) as total from xuser_data";
			$pub["SQLGrammar"]														= "SELECT * FROM ( SELECT * , ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) AS RowNum FROM xuser_data) AS NumberedRows WHERE RowNum BETWEEN _firstNumber_ AND _secondNumber_";
			$pub["title"]																	= "超級使用者管理";
			$pub["add_url"]																= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Add:function=xuser_data}");
			$pub["search_url"]														= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{search:function=xuser_data}");
			$pub["add_cell"]															= true;
			$pub["deleteAll_cell"]												= false;
			$pub["control_cell"]													= false;
			$pub["delete_cell"]														= true;
			$pub["update_cell"]														= true;
			
			$rep[]																				= "Userid|使用者帳號";
			$rep[]																				= "User|使用者名稱";	
			$rep[]																				= "Userpwd|使用者密碼";
			$rep[]																				= "Exeid|使用者編號";
			$rep[]																				= "ModifyDate|修改日期";

			self::$pubVar[__FUNCTION__]["report"]					= $rep;
			self::$pubVar[__FUNCTION__]["public"]					= $pub;
			
		}
		
	}
	
	$SQLOption = new SQLOption();

?>