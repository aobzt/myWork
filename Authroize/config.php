<?php

	class config
	{
		
		public static $pubVar = array();
		
		function __construct()
		{
			
			ini_set("display_errors","on");
			ini_set("memory_limit","256M");
			error_reporting(E_ERROR | E_PARSE);
			session_start();
			require("SQLEvent.php");
			require("SQLOption.php");
			require("public.php");
			self::setGlobal();
			self::setDataToJsonFile();
			
		}
		
		public static function setGlobal()
		{
		
			$mssql["host"]															= "192.168.1.252";
			$mssql["port"]															= "1433";
			$mssql["username"]													= "susan";
			$mssql["password"]													= "susan000";
			$mssql["driver"]														= "dblib:version=8.0";
			
			$bar["Logo"]																= "image/OsunLogo2018.JPG";
			$bar["ch_name"]															= "咸陽科技股份有限公司";
			$bar["en_name"]															= "Osun Technology Co., Ltd.";
			
			//Shared::$pubVar["string_mod"]							= "EngANDNum-UL";
			Shared::$pubVar["string_len"]								= 256;
			Shared::randomString();
			$mcrypt["sa"]																= $_SESSION["crypt_sa"] = $_SESSION["crypt_sa"] ? $_SESSION["crypt_sa"] : Shared::$pubVar["random_string"];
			Shared::$pubVar["string_len"]								= 16;
			Shared::randomString();
			$mcrypt["iv"]																= $_SESSION["crypt_iv"] = $_SESSION["crypt_iv"] ? $_SESSION["crypt_iv"] : Shared::$pubVar["random_string"];
			//make default file
			$file["document_root"]											= dirname(__FILE__);
			$file["connect_time"]												= gettimeofday()["sec"];
			$file["json_tmp_name"]											= $_SESSION["connect_time"] = $_SESSION["connect_time"] ? $_SESSION["connect_time"] : $file["connect_time"];
			$file["json_tmp_file"]											= $file["document_root"]."/json/".$_SESSION["connect_time"].".json";
			Shared::$pubVar["create_full_path"]					= $file["document_root"]."/json/";
			Shared::directory_maker();
			//request gateway
			$request["request_name"]										= "router.".pathinfo($_SERVER["SCRIPT_FILENAME"],PATHINFO_EXTENSION);
			$request["request_args"]										= "load";
			$request["request_path"]										= $request["request_name"]."?".$request["request_args"]."=";
			//for email encrypt
			$sendmail["method"]													= "AES-256-CBC";
			$sendmail["key"]														= "AlienOfBottleZTYEvhuHiDYZTV5m5EynQfkbUTYFBSEbYk";
			$sendmail["iv"]															= "AOBztSpjQ51PeuEzG8s9F";
	
			$GLOBALS["bar"]															= $bar;
			$GLOBALS["db"]															= $mssql;
			$GLOBALS["com"]															= $com;
			$GLOBALS["mcrypt"]													= $mcrypt;
			$GLOBALS["file"]														= $file;
			$GLOBALS["request"]													= $request;
			$GLOBALS["sendmail"]												= $sendmail;
		
		}
		
		public static function UserSideMenu()
		{
			
			$i																					= 0;
			$M[$i]["Main"]															= "我的帳號";
			$M[$i]["Icon"]															= "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABqElEQVR4nO2Zu0oDQRSGFyFeCq18hVSCeQ8FLxBrG/ERtBNtEu18Bm9PIaZJnVKTjdbaiJh4aZZ8cmCURZCN2bN7NmE+GAjZSfb/NjMnJ5sg8Hg8agAlYAu4AtrAmxvy+NIdKwVFBNgEuiQjczaCogBMASf8n7q8tggCo4T/kQgKsGzSsm65YYdZ80k8ANMWAlJRtKhaCEip1OLCQiBUFGhbCPQVBfrjLvBqIdBRFLizEJDeRoszC4GxL6MlpUrUMetQpatMGX4ArJmEj0kcpxComYaPtdP1Ea58rRDt9DfSVQ65J0LzZZOwsavS20htd192Mm6Bc3esmD8pPZ5JBpgDjoB7ICI7IneOQzmnZvgm+dMEZjUE5MpbcaAhIB+pFaGGQJZrPolIQ0D6FisGGgIvhgLPGgI3hgLXGgK7hgI7GgIzRpUoVLtnCizJvZscw/eBikr4mMQq8JFD+HdgRTV8TKKS8XLqAsuZhI9JLLj2oqcYvOcauPlMw/8SWQT2gVaK4C1gT94rt+B/yJSBbeAUaLi/VZ+ATzce3XMNN0fmlk1DezwTwhfZ+kkEBQDqIgAAAABJRU5ErkJggg==";
			$M[$i]["flow"]															= "No";
			$M[$i]["Exece"]															= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{UserInfo}");
			$i++;
			
			$M[$i]["Main"]															= "產品相關";
			$M[$i]["Icon"]															= "data:data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAABJklEQVR4nO3XPUrEUBTF8aPl+LEBR92CbsBWdCsD1hbauBNBsReZRiuD2xDLmUZtbP1L4BXiMEPG95KcgfuDVLm5N4ebV0QKoV/AC92r2gjSC0WQYI5+Dnn5Q48JRZBgBo9Dnn/oMaUIYkaxETOKjZhRbMSMYiNmFBsxo7YBQ2C8xDs9ADtyBOwuEWTo+A9S/erx3eSBkjNn/LPh3xd7b1D+WXLmjJymwF7qcd+g9jHV7ucM1Dw5TYFR6nHU4PM6TbVnjkFegUHqc76g7irVbAJvjkFq18Ba6nUMPAFfwEf9OQEn6d46cEMmtRikdgtsLZixDdyVGKSWg9QmwAVwAGyk6xC4BKalhqiDIJ1QBDGj2IgZxUbMKDayQhupWB3Pc4OEoGJ+AJgdjmn7LJwzAAAAAElFTkSuQmCC";
			$M[$i]["flow"]															= "Yes";
			$M[$i]["Item"][]														= "我的產品," .CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{Myproduct}");
			//$M[$i]["Item"][]														= "儀器連線,test";
			$i++;
			
			self::$pubVar[__FUNCTION__]									= $M;
			
		}
		
		
		public static function SideMenu()
		{
			
			$i																					= 0;
			$M[$i]["Main"]															= "帳號相關";
			$M[$i]["Icon"]															= "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMTYiIHdpZHRoPSIxOCIgdmlld0JveD0iMCAwIDU3NiA1MTIiPjwhLS0hRm9udCBBd2Vzb21lIEZyZWUgNi41LjEgYnkgQGZvbnRhd2Vzb21lIC0gaHR0cHM6Ly9mb250YXdlc29tZS5jb20gTGljZW5zZSAtIGh0dHBzOi8vZm9udGF3ZXNvbWUuY29tL2xpY2Vuc2UvZnJlZSBDb3B5cmlnaHQgMjAyMyBGb250aWNvbnMsIEluYy4tLT48cGF0aCBvcGFjaXR5PSIxIiBmaWxsPSIjZmZmZmZmIiBkPSJNMjkxLjIgMzg4LjRjMzEuMi0xOC44IDY0LjctMzYuNCAxMDEuMS0zNi40SDQ0OGM0LjYgMCA5LjEtLjIgMTMuNi0uN2w4NS4zIDEyMS45YzQgNS43IDExLjMgOC4yIDE3LjkgNi4xczExLjItOC4zIDExLjItMTUuM1YyMjRjMC03MC43LTU3LjMtMTI4LTEyOC0xMjhIMzkyLjNjLTM2LjQgMC02OS45LTE3LjYtMTAxLjEtMzYuNEMyNjIuMyA0Mi4xIDIyOC4zIDMyIDE5MiAzMkM4NiAzMiAwIDExOCAwIDIyNGMwIDcxLjEgMzguNiAxMzMuMSA5NiAxNjYuM1Y0NTZjMCAxMy4zIDEwLjcgMjQgMjQgMjRzMjQtMTAuNyAyNC0yNFY0MTBjMTUuMyAzLjkgMzEuNCA2IDQ4IDZjNS40IDAgMTAuNy0uMiAxNi0uN1Y0NTZjMCAxMy4zIDEwLjcgMjQgMjQgMjRzMjQtMTAuNyAyNC0yNFY0MDUuMWMxMi40LTQuNCAyNC4yLTEwIDM1LjItMTYuN3pNNDQ4IDIwMGEyNCAyNCAwIDEgMSAwIDQ4IDI0IDI0IDAgMSAxIDAtNDh6Ii8+PC9zdmc+";
			$M[$i]["flow"]															= "Yes";
			$M[$i]["Item"][]														= "會員帳號管理," .CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=custom_account}");
			$M[$i]["Item"][]														= "信箱驗證管理," .CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=user_email}");
			$i++;
			
			$M[$i]["Main"]															= "產品相關管理";
			$M[$i]["Icon"]															= "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMTYiIHdpZHRoPSIyMCIgdmlld0JveD0iMCAwIDY0MCA1MTIiPjwhLS0hRm9udCBBd2Vzb21lIEZyZWUgNi41LjEgYnkgQGZvbnRhd2Vzb21lIC0gaHR0cHM6Ly9mb250YXdlc29tZS5jb20gTGljZW5zZSAtIGh0dHBzOi8vZm9udGF3ZXNvbWUuY29tL2xpY2Vuc2UvZnJlZSBDb3B5cmlnaHQgMjAyMyBGb250aWNvbnMsIEluYy4tLT48cGF0aCBvcGFjaXR5PSIxIiBmaWxsPSIjZmZmZmZmIiBkPSJNNDU2IDBjLTQ4LjYgMC04OCAzOS40LTg4IDg4djI5LjJMMTIuNSAzOTAuNmMtMTQgMTAuOC0xNi42IDMwLjktNS45IDQ0LjlzMzAuOSAxNi42IDQ0LjkgNS45TDEyNi4xIDM4NEgyNTkuMmw0Ni42IDExMy4xYzUgMTIuMyAxOS4xIDE4LjEgMzEuMyAxMy4xczE4LjEtMTkuMSAxMy4xLTMxLjNMMzExLjEgMzg0SDM1MmMxLjEgMCAyLjEgMCAzLjIgMGw0Ni42IDExMy4yYzUgMTIuMyAxOS4xIDE4LjEgMzEuMyAxMy4xczE4LjEtMTkuMSAxMy4xLTMxLjNsLTQyLTEwMkM0ODQuOSAzNTQuMSA1NDQgMjgwIDU0NCAxOTJWMTI4di04bDgwLjUtMjAuMWM4LjYtMi4xIDEzLjgtMTAuOCAxMS42LTE5LjRDNjI5IDUyIDYwMy40IDMyIDU3NCAzMkg1MjMuOUM1MDcuNyAxMi41IDQ4My4zIDAgNDU2IDB6bTAgNjRhMjQgMjQgMCAxIDEgMCA0OCAyNCAyNCAwIDEgMSAwLTQ4eiIvPjwvc3ZnPg==";
			$M[$i]["flow"]															= "Yes";
			$M[$i]["Item"][]														= "產品管理," .CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=product_data}");
			$M[$i]["Item"][]														= "用戶產品管理," .CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=MG_custom_product}");
			$i++;
			
			$M[$i]["Main"]															= "後台使用者相關";
			$M[$i]["Icon"]															= "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMTYiIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDUxMiA1MTIiPjwhLS0hRm9udCBBd2Vzb21lIEZyZWUgNi41LjEgYnkgQGZvbnRhd2Vzb21lIC0gaHR0cHM6Ly9mb250YXdlc29tZS5jb20gTGljZW5zZSAtIGh0dHBzOi8vZm9udGF3ZXNvbWUuY29tL2xpY2Vuc2UvZnJlZSBDb3B5cmlnaHQgMjAyMyBGb250aWNvbnMsIEluYy4tLT48cGF0aCBvcGFjaXR5PSIxIiBmaWxsPSIjZmZmZmZmIiBkPSJNMTYwLjggOTYuNWMxNCAxNyAzMSAzMC45IDQ5LjUgNDIuMmMyNS45IDE1LjggNTMuNyAyNS45IDc3LjcgMzEuNlYxMzguOEMyNjUuOCAxMDguNSAyNTAgNzEuNSAyNDguNiAyOGMtLjQtMTEuMy03LjUtMjEuNS0xOC40LTI0LjRjLTcuNi0yLTE1LjgtLjItMjEgNS44Yy0xMy4zIDE1LjQtMzIuNyA0NC42LTQ4LjQgODcuMnpNMzIwIDE0NHYzMC42bDAgMHYxLjNsMCAwIDAgMzIuMWMtNjAuOC01LjEtMTg1LTQzLjgtMjE5LjMtMTU3LjJDOTcuNCA0MCA4Ny45IDMyIDc2LjYgMzJjLTcuOSAwLTE1LjMgMy45LTE4LjggMTFDNDYuOCA2NS45IDMyIDExMi4xIDMyIDE3NmMwIDExNi45IDgwLjEgMTgwLjUgMTE4LjQgMjAyLjhMMTEuOCA0MTYuNkM2LjcgNDE4IDIuNiA0MjEuOCAuOSA0MjYuOHMtLjggMTAuNiAyLjMgMTQuOEMyMS43IDQ2Ni4yIDc3LjMgNTEyIDE2MCA1MTJjMy42IDAgNy4yLTEuMiAxMC0zLjVMMjQ1LjYgNDQ4SDMyMGM4OC40IDAgMTYwLTcxLjYgMTYwLTE2MFYxMjhsMjkuOS00NC45YzEuMy0yIDIuMS00LjQgMi4xLTYuOGMwLTYuOC01LjUtMTIuMy0xMi4zLTEyLjNINDAwYy00NC4yIDAtODAgMzUuOC04MCA4MHptODAtMTZhMTYgMTYgMCAxIDEgMCAzMiAxNiAxNiAwIDEgMSAwLTMyeiIvPjwvc3ZnPg==";
			$M[$i]["flow"]															= "Yes";
			$M[$i]["Item"][]														= "超級使用者管理," .CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "PlantFormAjax{createTable:Option=xuser_data}");
			$i++;
			
			$M[$i]["Main"]															= "登出";
			$M[$i]["Icon"]															= "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMTYiIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDUxMiA1MTIiPjwhLS0hRm9udCBBd2Vzb21lIEZyZWUgNi41LjEgYnkgQGZvbnRhd2Vzb21lIC0gaHR0cHM6Ly9mb250YXdlc29tZS5jb20gTGljZW5zZSAtIGh0dHBzOi8vZm9udGF3ZXNvbWUuY29tL2xpY2Vuc2UvZnJlZSBDb3B5cmlnaHQgMjAyMyBGb250aWNvbnMsIEluYy4tLT48cGF0aCBvcGFjaXR5PSIxIiBmaWxsPSIjZmZmZmZmIiBkPSJNMjE3LjkgMTA1LjlMMzQwLjcgMjI4LjdjNy4yIDcuMiAxMS4zIDE3LjEgMTEuMyAyNy4zcy00LjEgMjAuMS0xMS4zIDI3LjNMMjE3LjkgNDA2LjFjLTYuNCA2LjQtMTUgOS45LTI0IDkuOWMtMTguNyAwLTMzLjktMTUuMi0zMy45LTMzLjlsMC02Mi4xTDMyIDMyMGMtMTcuNyAwLTMyLTE0LjMtMzItMzJsMC02NGMwLTE3LjcgMTQuMy0zMiAzMi0zMmwxMjggMCAwLTYyLjFjMC0xOC43IDE1LjItMzMuOSAzMy45LTMzLjljOSAwIDE3LjYgMy42IDI0IDkuOXpNMzUyIDQxNmw2NCAwYzE3LjcgMCAzMi0xNC4zIDMyLTMybDAtMjU2YzAtMTcuNy0xNC4zLTMyLTMyLTMybC02NCAwYy0xNy43IDAtMzItMTQuMy0zMi0zMnMxNC4zLTMyIDMyLTMybDY0IDBjNTMgMCA5NiA0MyA5NiA5NmwwIDI1NmMwIDUzLTQzIDk2LTk2IDk2bC02NCAwYy0xNy43IDAtMzItMTQuMy0zMi0zMnMxNC4zLTMyIDMyLTMyeiIvPjwvc3ZnPg==";
			$M[$i]["flow"]															= "No";
			$M[$i]["Exece"]															= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{SignOut}");
			
			self::$pubVar[__FUNCTION__] 								= $M;
			
		}
		
		
		public static function JsonMaker()
		{
			$J["reset_url"] 														= CryptByOpenSSL::encrypt($_SESSION["user_unicode"] ? $GLOBALS["request"]["request_path"]."PlantformAjax{UserInfo}" : $GLOBALS["request"]["request_path"]."PlantformAjax{Login}");
			$J["master_url"] 														= CryptByOpenSSL::encrypt($_SESSION["userid"] ? $GLOBALS["request"]["request_path"]."PlantformAjax{masterHome}" : $GLOBALS["request"]["request_path"]."PlantformAjax{Master_Login}");
			$J["iv"]																		= bin2Hex($GLOBALS["mcrypt"]["iv"]);
			$J["sa"]																		= bin2Hex($GLOBALS["mcrypt"]["sa"]);
		
			self::$pubVar["Json"]												= $J;
		}
		
		public static function setDataToJsonFile()
		{
			self::JsonMaker();
			file_put_contents($GLOBALS["file"]["json_tmp_file"],json_encode(self::$pubVar["Json"]));
		}
		
	}
	
	$config = new config();

?>

