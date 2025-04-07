<?php

	class PlantFunction
	{
	
		public static $pubVar																										= array();
		public static $garmmar;
		public static $function;
		public static $error;
	
		public static function Add()
		{
			
			$appe[]																																= "main-container class = update-container";
			$appe["main-container[class = update-container]"][]										= "form class = user-update";
			$appe["form[class = user-update]"][]																	= "updateForm class = update-form";
			
			switch(self::$function)
			{
				
				case "custom_account":
					
					$appe["updateForm[class = update-form]"][]												= "updateForm class = update-label";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = username";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = username";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = email";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = email";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = password";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = password";
			
					$appe["updateForm[class = update-form]"][]												= "update-button class = update";
		
					$attr["update[for = username]"]["insertHtmlText"]									= "帳號名稱（AccountID）";
					$attr["update[for = email]"]["insertHtmlText"]									  = "電子信箱（E-mail）";
					$attr["update[for = password]"]["insertHtmlText"]									= "密碼（Password）";

					$attr["update-button[class = update]"]["insertHtmlText"]					= "新增";
					$attr["update-button[class = update]"]["url"]											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{userAdd:table=" .self::$function. "}");
				
					break;
					
				case "custom_product":
				
					SQLEvent::connectDB();
					SQLEvent::$statement																							= "select productID, productCName, productEName, version from product_data;";
					SQLEvent::PDOEvent();
					$data																															= SQLEvent::$fetch;
				
					$appe["updateForm[class = update-form]"][]												= "updateForm class = update-label";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = unicode";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = unicode";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = username";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = username";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productID";
					$appe["updateForm[class = update-label]"][]												= "selection class = selection-container";
					$appe["selection[class = selection-container]"][]									= "input class = selection-input name = productID readonly";
					$appe["selection[class = selection-container]"][]									= "selection class = selection-item-container";
					
					for($i = 0; $i < count($data); $i++)
					{
					
						$k																															= $i + 1;
						$productData																										= $data[$i];
						$appe["selection[class = selection-item-container]"][]					= "selection class = selection-item id = " .$k;
						$attr["selection[id = " .$k. "]"]["insertHtmlText"]							= $productData["productID"];
						$attr["selection[id = " .$k. "]"]["url"]												= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{insertInfo:table=product_data,productID=" .$productData["productID"]. "}");
						
					}
					
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productName";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productName readonly";
			
					$appe["updateForm[class = update-form]"][]												= "update-button class = update";
		
					$attr["update[for = unicode]"]["insertHtmlText"]									= "帳號識別碼（Unicode）";
					$attr["update[for = username]"]["insertHtmlText"]									= "帳號名稱（AccountID）";
					$attr["update[for = productID]"]["insertHtmlText"]							  = "產品編號（ProductID）";
					$attr["update[for = productName]"]["insertHtmlText"]							= "產品名稱（ProductName）";

					$attr["input[class = selection-input]"]["value"]									= "請選擇產品編號";

					$attr["update-button[class = update]"]["insertHtmlText"]					= "新增";
					$attr["update-button[class = update]"]["url"]											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{userProductAdd:table=" .self::$function. "}");
					
					break;
					
				/*case "user_email":
				
					break;*/
				
				case "product_data":
				
					$appe["updateForm[class = update-form]"][]												= "updateForm class = update-label";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = unicode";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = unicode";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productID";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productID";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productName";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productName";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productCName";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productCName";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productEName";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productEName";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = version";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = version";
			
					$appe["updateForm[class = update-form]"][]												= "update-button class = update";	

					$attr["update[for = unicode]"]["insertHtmlText"]									= "產品序號（Unicode）";
					$attr["update[for = productID]"]["insertHtmlText"]							  = "產品編號（ProductID）";
					$attr["update[for = productName]"]["insertHtmlText"]							= "產品名稱（ProductName）";
					$attr["update[for = productCName]"]["insertHtmlText"]						  = "產品中文名稱（ProductCName）";
					$attr["update[for = productEName]"]["insertHtmlText"]							= "產品英文名稱（ProductEName）";
					$attr["update[for = version]"]["insertHtmlText"]								  = "產品版本（Version）";

					$attr["update-button[class = update]"]["insertHtmlText"]					= "新增";
					$attr["update-button[class = update]"]["url"]											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{productAdd:table=" .self::$function. "}");
			
					break;
					
				case "xuser_data":
				
					$appe["updateForm[class = update-form]"][]												= "updateForm class = update-label";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = userid";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = userid";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = username";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = username";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = userpwd";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = userpwd";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = exeid";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = exeid";
			
					$appe["updateForm[class = update-form]"][]												= "update-button class = update";	

					$attr["update[for = userid]"]["insertHtmlText"]										= "使用者帳號（Userid）";
					$attr["update[for = username]"]["insertHtmlText"]								  = "使用者名稱（Username）";
					$attr["update[for = userpwd]"]["insertHtmlText"]									= "使用者密碼（Userpwd）";
					$attr["update[for = exeid]"]["insertHtmlText"]									  = "使用者編號（Exeid）";
					
					$attr["update-button[class = update]"]["insertHtmlText"]					= "新增";
					$attr["update-button[class = update]"]["url"]											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{xuserAdd:table=" .self::$function. "}");
				
					break;
				
			}
			
			self::$pubVar["Update"]["appendHtml"]																	= $appe;
			self::$pubVar["Update"]["attrHtml"]																		= $attr;
			
		}
	
		public static function Update()
		{
		
			SQLEvent::connectDB();
			SQLEvent::$statement																									= self::$garmmar;
			SQLEvent::PDOEvent();
			$data																																	= SQLEvent::$fetch;
		
			$appe[]																																= "main-container class = update-container";
			$appe["main-container[class = update-container]"][]										= "form class = user-update";
			$appe["form[class = user-update]"][]																	= "updateForm class = update-form";
			
			switch(self::$function)
			{
			
				case "custom_account":
			
					$appe["updateForm[class = update-form]"][]												= "updateForm class = update-label";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = unicode";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = unicode readonly";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = username";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = username";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = email";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = email readonly";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = password";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = password";
			
					$appe["updateForm[class = update-form]"][]												= "update-button class = update";
		
					$attr["update[for = unicode]"]["insertHtmlText"]									= "帳號識別碼（Unicode）";
					$attr["input[class = update-input][name = unicode]"]["value"]			= $data[0]["unicode"];
					$attr["update[for = username]"]["insertHtmlText"]									= "帳號名稱（AccountID）";
					$attr["input[class = update-input][name = username]"]["value"]		= $data[0]["accountID"];
					$attr["update[for = email]"]["insertHtmlText"]									  = "電子信箱（E-mail）";
					$attr["input[class = update-input][name = email]"]["value"]				= $data[0]["email"];
					$attr["update[for = password]"]["insertHtmlText"]									= "密碼（Password）";
					$attr["input[class = update-input][name = password]"]["value"]		= $data[0]["password"];

					$attr["update-button[class = update]"]["url"]											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{userUpdate:table=" .self::$function. "}");
			
					break;
					
				case "custom_product":
				
					$appe["updateForm[class = update-form]"][]												= "updateForm class = update-label";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = unicode";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = unicode readonly";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = username";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = username";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productID";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productID";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productName";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productName";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = registCode";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = registCode readonly";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = MCode";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = MCode readonly";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = MAC";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = MAC readonly";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = IPAddr";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = IPAddr";
						
					$appe["updateForm[class = update-form]"][]												= "update-button class = update";
		
					$attr["update[for = unicode]"]["insertHtmlText"]									= "帳號識別碼（Unicode）";
					$attr["input[class = update-input][name = unicode]"]["value"]			= $data[0]["unicode"];
					$attr["update[for = username]"]["insertHtmlText"]									= "帳號名稱（AccountID）";
					$attr["input[class = update-input][name = username]"]["value"]		= $data[0]["accountID"];
					$attr["update[for = productID]"]["insertHtmlText"]								= "產品編號（ProductID）";
					$attr["input[class = update-input][name = productID]"]["value"]		= $data[0]["productID"];
					$attr["update[for = productName]"]["insertHtmlText"]							= "產品名稱（ProductName）";
					$attr["input[class = update-input][name = productName]"]["value"]	= $data[0]["productName"];
					$attr["update[for = registCode]"]["insertHtmlText"]								= "註冊碼（RegistCode）";
					$attr["input[class = update-input][name = registCode]"]["value"]	= $data[0]["registCode"];
					$attr["update[for = MCode]"]["insertHtmlText"]										= "MCode（MCode）";
					$attr["input[class = update-input][name = MCode]"]["value"]				= $data[0]["MCode"];
					$attr["update[for = MAC]"]["insertHtmlText"]											= "媒體存取控制位址（MAC）";
					$attr["input[class = update-input][name = MAC]"]["value"]					= $data[0]["MAC"];
					$attr["update[for = IPAddr]"]["insertHtmlText"]										= "IPv4位址（IPAddr）";
					$attr["input[class = update-input][name = IPAddr]"]["value"]			= $data[0]["IPAddr"];

					$attr["update-button[class = update]"]["url"]											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{userProductUpdata:table=" .self::$function. "}");
				
					break;
					
				/*case "user_email":
				
					break;*/
					
				case "product_data":
				
					$appe["updateForm[class = update-form]"][]												= "updateForm class = update-label";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = unicode";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = unicode readonly";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productID";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productID readonly";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productCName";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productCName";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = productEName";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = productEName";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = version";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = version";
			
					$appe["updateForm[class = update-form]"][]												= "update-button class = update";
		
					$attr["update[for = unicode]"]["insertHtmlText"]									= "產品序號（Unicode）";
					$attr["input[class = update-input][name = unicode]"]["value"]			= $data[0]["unicode"];
					$attr["update[for = productID]"]["insertHtmlText"]								= "產品編號（ProductID）";
					$attr["input[class = update-input][name = productID]"]["value"]		= $data[0]["productID"];
					$attr["update[for = productCName]"]["insertHtmlText"]						  = "產品中文名稱（ProductCName）";
					$attr["input[class = update-input][name = productCName]"]["value"]
																																						= $data[0]["productCName"];
					$attr["update[for = productEName]"]["insertHtmlText"]							= "產品英文名稱（ProductEName）";
					$attr["input[class = update-input][name = productEName]"]["value"]
																																						= $data[0]["ProductEName"];
					$attr["update[for = version]"]["insertHtmlText"]									= "產品版本（Version）";
					$attr["input[class = update-input][name = version]"]["value"]			= $data[0]["version"];

					$attr["update-button[class = update]"]["url"]											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{productUpdata:table=" .self::$function. "}");
				
					break;
					
				case "xuser_data":
				
					$appe["updateForm[class = update-form]"][]												= "updateForm class = update-label";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = userid";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = userid readonly";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = username";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = username";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = userpwd";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = userpwd";
					$appe["updateForm[class = update-label]"][]												= "update class = lb-update for = exeid";
					$appe["updateForm[class = update-label]"][]												= "input class = update-input name = exeid";
			
					$appe["updateForm[class = update-form]"][]												= "update-button class = update";
		
					$attr["update[for = userid]"]["insertHtmlText"]										= "使用者帳號（Userid）";
					$attr["input[class = update-input][name = userid]"]["value"]			= $data[0]["userid"];
					$attr["update[for = username]"]["insertHtmlText"]									= "使用者名稱（Username）";
					$attr["input[class = update-input][name = username]"]["value"]		= $data[0]["username"];
					$attr["update[for = userpwd]"]["insertHtmlText"]						  		= "使用者密碼（Userpwd）";
					$attr["input[class = update-input][name = userpwd]"]["value"]			= $data[0]["userpwd"];
					$attr["update[for = exeid]"]["insertHtmlText"]										= "使用者編號（Exeid）";
					$attr["input[class = update-input][name = exeid]"]["value"]				= $data[0]["exeid"];

					$attr["update-button[class = update]"]["url"]											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{xuserUpdata:table=" .self::$function. "}");
				
					break;
			
			}
			
			$attr["update-button[class = update]"]["insertHtmlText"]							= "確認修改";
		
			self::$pubVar["Update"]["appendHtml"]																	= $appe;
			self::$pubVar["Update"]["attrHtml"]																		= $attr;

		}
		
		public static function search()
		{
			
			SQLEvent::connectDB();
			SQLEvent::$statement																									= self::$garmmar;
			SQLEvent::PDOEvent();
			$data																																	= SQLEvent::$fetch;
			
			$SQLFunction																													= self::$function;
			SQLOption::$SQLFunction();
			self::$pubVar["tableInfo"]																						= SQLOption::$pubVar[$SQLFunction];
			
			$appe[]																																= "tableContent loc = report_tr pos = title";
			
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
					$appe[]																																	= "tableContent loc = report_tr pos = row_" .($i + 1);
						
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
																																											
						switch($SQLFunction)
						{
							
							case "custom_account":
							
								$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:unicode=" .$eachData["unicode"]. ",table=" .$SQLFunction. "}");
								break;
								
							case "MG_custom_product":
							
								$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:unicode=" .$eachData["unicode"]. ",productID=" .$eachData["productID"]. ",table=custom_product}");
								break;
								
							case "user_email":
							
								$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:token=" .$eachData["token"]. ",table=" .$SQLFunction. "}");
								break;
								
							case "product_data":
							
								$attr["detial_button[id = open_function][deleteId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Delete:unicode=" .$eachData["unicode"]. ",productID=" .$eachData["productID"]. ",table=" .$SQLFunction. "}");
							
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
						
						switch($SQLFunction)
						{
							
							case "custom_account":
							
								$attr["detial_button[id = open_function][updateId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Update:unicode=" .$eachData["unicode"]. ",function=" .$SQLFunction. "}");
								break;
								
							case "MG_custom_product":
							
								$attr["detial_button[id = open_function][updateId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Update:unicode=" .$eachData["unicode"]. ",productID=" .$eachData["productID"]. ",function=custom_product}");
								break;
								
							/*case "user_email":
							
								break;*/
								
							case "product_data":
							
								$attr["detial_button[id = open_function][updateId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Update:unicode=" .$eachData["unicode"]. ",function=" .$SQLFunction. "}");
							
								break;
								
							case "xuser_data":
							
								$attr["detial_button[id = open_function][updateId = m" .($i + 1). "]"]["url"]
																																											= CryptByOpenSSL::encrypt($GLOBALS["request"]["request_path"]. "RequestAjax{Update:userid=" .$eachData["userid"]. ",function=" .$args["Option"]. "}");
								break;
								
								
						}
						
					}
					
				}
				
			}
																																							
			self::$pubVar["search"]["appendHtml"]																		= $appe;
			self::$pubVar["search"]["attrHtml"]																			= $attr;
			
		}
		
		public static function error()
		{
			
			$appe[]																																= "viewFlow class = ill-container";
			$appe["viewFlow[class = ill-container]"][]														= "viewFlow class = ill-content";
			$appe["viewFlow[class = ill-container]"][]														= "viewFlow class = ill-close";
			
			$attr["viewFlow[class = ill-content]"]["insertHtmlText"]							= self::$error;
			$attr["viewFlow[class = ill-close]"]["insertHtmlText"]								= "關閉";
					
			self::$pubVar["Error"]["appendHtml"]																	= $appe;
			self::$pubVar["Error"]["attrHtml"]																		= $attr;
			
		}
		
	}

	$PlantFunction																														= new PlantFunction();

?>