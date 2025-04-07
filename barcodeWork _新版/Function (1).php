<?php

	class Option{
		
		public static $pubVar 												 = array(); 
		
		function __construct()
		{
		
			date_default_timezone_set('Asia/Taipei');
			ini_set("display_errors","on");
			ini_set("memory_limit","256M");
			error_reporting(E_ERROR | E_PARSE);
			session_start();
			require("SQLEvent.php");
			require("PlantHtmlTable.php");
			require("CreateSQL.php");
			self::CallFunction();	
			
		}

		//呼叫function
		public static function CallFunction()
		{
			
			$Call																						= $_POST["action"];
			$Store																					= $_POST["store"];
				
			if($Call)
			{
			
				self::$Call();	
			
			}
			
			if($Store)
			{
				
				self::$Store();
				
			}
			
		}
		
		public static function getIP()
		{
			
			$ip																						= $_SERVER["REMOTE_ADDR"];
			
			print_r(json_encode($ip));
			
		}

		//登入
		public static function Login() //Login APIversion
		{

			session_start();
			
			//檢驗可用功能
			if($_POST["isNurse"] == true)
			{
				
				$respone["prTube"] 													= $_SESSION["prTube"] = "yes";
				$respone["Package"] 												= $_SESSION["Package"] = "yes";
				$respone["signIn"]													= $_SESSION["signIn"] = "yes";
				$respone["signOut"]													= $_SESSION["signOut"] = "yes";
				$respone["setting"]													= $_SESSION["setting"] = "yes";
				
			}
			
			//檢驗可用功能
			if($_POST["Userdata"])
			{
			
				for($i = 0; $i < count($_POST["Userdata"]); $i++)
				{

					$character																= $_POST["Userdata"][$i];

					switch(trim($character["systemId"]))
					{
						
						case "7010100":
							
							$respone["prTube"] 										= $_SESSION["prTube"] = "yes";
							break;
							
						case "7010200":
						
							$respone["Package"] 									= $_SESSION["Package"] = "yes";
							break;
							
						case "7010300":
						
							$respone["signIn"]										= $_SESSION["signIn"] = "yes";
							break;
							
						case "7010400":
						
							$respone["signOut"]										= $_SESSION["signOut"] = "yes";
							
						case "7010500":
						
							$respone["setting"]										= $_SESSION["setting"] = "yes";
							break;
						
					}
				}
				
			}
			
			//護理站名稱與代碼
			if($_POST["JobClass"])
			{
				
				$JobClass																		= $_POST["JobClass"][0];

				$respone["dicCode"]													= $_SESSION["dicCode"] = $JobClass["dicCode"];
				$respone["dicName"]													= $_SESSION["dicName"] = $JobClass["dicName"];
				
				$Class                                      = explode("-", $JobClass["dicCode"]);
				
				$respone["Class"]														= $_SESSION["Class"] = $Class[0];
				

			}

			//切割字串取出儀器代碼、列印模式
  		$parts																				= explode("=", $_POST["remark"]);
  		$machine																			= $parts[0];
  		$parts																				= explode("|", $_POST["remark"]);
  		$machineIP																		= explode("=", $parts[0]);
  		$print                                        = explode("^", $parts[1]);

  		if($print[0] != "other")
  		{
  			
  			$pkgbar																			= explode("=", $print[0]);
  			$response[$pkgbar[0]]												= $_SESSION[$pkgbar[0]]	= $pkgbar[1];
  			$pkglist																		= explode("=", $print[1]);
  			$response[$pkglist[0]]											= $_SESSION[$pkglist[0]]	= $pkglist[1];
  			
  		}else{
  			
  			$response["pkgbar"]													= $_SESSION["pkgbar"]	= "0";
  			$response["pkglist"]												= $_SESSION["pkglist"] = "0";
  			
  		}

			//儲存為SESSION
			$respone["machine"]														= $_SESSION["machine"] = $machine;
			$respone["machineIP"]													= $_SESSION["machineIP"] = $machineIP[1];
			$respone["otherIP"]														= $_SESSION["otherIP"] = $parts[2];
			$respone["userid"]														= $_SESSION["userid"] = $_POST["Userid"];
			$respone["username"]													= $_SESSION["username"] = $_POST["Username"];
			$respone["userpwd"] 													= $_SESSION["userpwd"] = $_POST["Userpwd"];
			$respone["ip"] 																= $_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];
			$respone["url"] 															= "home.php";
			print_r(json_encode($respone)); 
			
		}
		
		//儲存cookie
		public static function saveCookie()
		{
			
			setcookie("dicCode", $_POST["dicCode"], time() + 365*86400, "/");
			setcookie("machineIP", $_POST["machineIP"], time() + 365*86400, "/");

			//print_r($_POST["dicCode"]);
			//print_r($_COOKIE["dicCode"]);
			
		}
		
		//登出
		public static function Logout()
		{
			
			session_unset();
			$respone["url"]																= "http://192.168.1.173";
			print_r(json_encode($respone)); 
			
		}
		
		//短資料傳送
		public static function ShortData()
		{
		
			$Plant																				= $_POST["function"];
			PlantHtmlTable::$pubVar["fetch"]							= $_POST["Data"];
			PlantHtmlTable::$Plant();

		}
		
		//長資料傳送
		public static function LongData()
		{
			
			$Plant																				= $_POST["function"];
			PlantHtmlTable::$pubVar["fetch"]							= json_decode($_POST["Data"], true);
			PlantHtmlTable::$Plant();

		}

		//畫面呼叫
		public static function Plant()
		{
	
			$Plant																				= $_POST["function"];
			PlantHtmlTable::$Plant();
			
		}
		
		//抓取打包暫存
		public static function recode()
		{
			
			$Plant																				= $_POST["function"];
			
			SQLEvent::MySQLconnect();
			SQLEvent::$MySQLstatement											= "select * from package where dicCode = '$_POST[dicCode]'";
			SQLEvent::MySQLDBEvent();
			
			PlantHtmlTable::$pubVar["fetch"]							= SQLEvent::$MySQLfetch;
			PlantHtmlTable::$Plant();
			
		}
		
		//移除重複資料（用於畫面顯示）
		public static function Filter()
		{

			$labNo 																						= $_POST["labNo"];
			//$dataArray 																				= $_POST["Data"];
			$dataArray 																				= json_decode($_POST["Data"], true);

			$seen 																						= [];
			$uniqueData 																			= [];

			//print_r($_POST["function"]);
			
			//篩選特定數據			
			switch($_POST["function"])
			{
				
				case "moreDetial":
				
					$filteredData 																	= array_filter($dataArray, function($item) use ($labNo) {
				
    				return $item["labNo"] 												== $labNo;
    			
					});
				
					break;
					
				case "showLab":
				
					switch($_POST["option"])
					{
					
						case "default":
						
							
							$date                                           = explode("-", date("Y-m-d"));
					
							$year 																					= intval($date[0]);
    					$year 																					= $year - 1911;
    					$year 																					= strval($year);
    			 
    					$currentDay																			= $year . $date[1] . $date[2];

							//具有當班性質的篩選
							//當前時間
							/*$time																						= explode(":", date("H:i"));
					
							$currentTime																		= $time[0] . $time[1];
							$currentTime																		= intVal($currentTime);
					
							if($currentTime >= 800 && $currentTime <= 1559)
							{
						
								$startTime																		= "0800";
								$endTime																			= "1559";
						
							}else if($currentTime >= 1600 && $currentTime <= 2359){
						
								$startTime                                    = "1600";
								$endTime																			= "2359";
						
							}else{
						
								$startTime																		= "0000";
								$endTime																			= "0759";
						
							}
							
							if($_POST["mCode"] == "ER" || $_POST["mCode"] == "H" || $_POST["mCode"] == "P")
							{

								$startTime																		= "0000";
								$endTime																			= "2359";
							
							}*/

							//資料篩選
							$filteredData 																	= array_filter($dataArray, function($item) use ($currentDay/*, $startTime, $endTime*/) {
				
    						return $item["expectCollectionDate"] 					== $currentDay /*&& $item["expectCollectionTime"] >= $startTime && $item["expectCollectionTime"] <= $endTime*/;
    			
							});

							break;
							
						case "search":
						
							$startDay                                       = explode("-", $_POST["startDay"]);
							$startYear																			= intVal($startDay[0]);
							$startYear																			= $startYear - 1911;
							$startYear																			= strVal($startYear);
							
							$startDay																				= $startYear . $startDay[1] . $startDay[2];
							
							//print_r($startDay);
							
							$endDay                    		                  = explode("-", $_POST["endDay"]);
							$endYear																				= intVal($endDay[0]);
							$endYear																				= $endYear - 1911;
							$endYear																				= strVal($endYear);
							
							$endDay																					= $endYear . $endDay[1] . $endDay[2];
							
							//print_r($endDay);
							
							if($_POST["shift"] == "日班")
							{
								
								$startTime																		= "0800";
								$endTime																			= "1559";
								
							}else if($_POST["shift"] == "晚班"){
								
								$startTime                                    = "1600";
								$endTime																			= "2359";
								
							}else if($_POST["shift"] == "夜班"){
								
								$startTime																		= "0000";
								$endTime																			= "0759";
								
							}else{
								
								$startTime																		= "0000";
								$endTime																			= "2359";
								
							}
							
							if($_POST["mCode"] == "ER" || $_POST["mCode"] == "H" || $_POST["mCode"] == "P")
							{

								$startTime																		= "0000";
								$endTime																			= "2359";
							
							}
							
							//print_r($startTime);
							//print_r($endTime);
							
							$filteredData 																	= array_filter($dataArray, function($item) use ($startDay, $endDay, $startTime, $endTime) {
				
    						return $item["expectCollectionDate"] 					>= $startDay && $item["expectCollectionDate"] <= $endDay && $item["expectCollectionTime"] >= $startTime && $item["expectCollectionTime"] <= $endTime;
    			
							});		
						
							break;	
						
					}

					//print_r($filteredData);
				
					break;
				
				default:
				
					$filteredData 																	= $dataArray;
				
					break;
				
			}

			//合併重複資料
			switch($_POST["function"])
			{
				
				case "testTubeScan":
				case "HisTestTube":
				case "showLab":
				case "checkScan":
				
					if($filteredData)
					{
						
						$filteredData 															= array_unique($filteredData, SORT_REGULAR);

					}

					foreach($filteredData as $data)
					{

						$uniqueKey																	= $data["labNo"] . $data["mcode"] . $data["tubeName"];
						
						if(isset($seen[$uniqueKey]))
						{
							
							$seen[$uniqueKey]["labInfo"][]						= $data["labCode"] . " - " . $data["labName"];
							
						}else{
							
							$data["labInfo"]													= [$data["labCode"] . " - " . $data["labName"]];
							
							unset($data["labCode"]);
							unset($data["diagnosisDescription"]);
							unset($data["labGroupCode"]);
							unset($data["labName"]);
							
							$seen[$uniqueKey]													= $data;
							
						}
						
					}
				
					$uniqueData																		= array_values($seen);
				
					break;
					
				case "sreachPatient":
				
					foreach($filteredData as $data)
					{
						
						unset($data["labNo"]);
						$hash 																			= md5(json_encode($data));
        		if (!in_array($hash, $seen)) {
        	
            	$seen[] 																	= $hash;
            	$uniqueData[] 														= $data;
            
       			}
						
					}
				
					break;
					
				case "mix":
				
					foreach($filteredData as $data)
					{
						
						unset($data["divNo"]);
						unset($data["diagnosisDescription"]);
						unset($data["expectCollectionTime"]);
						unset($data["expectCollectionDate"]);
						unset($data["labNo"]);
						$hash 																			= md5(json_encode($data));
						
						if (!in_array($hash, $seen)) {
        	
							$seen[] 																	= $hash;
							$uniqueData[] 														= $data;
            
						}
						
					}
				
					break;
		
				default:

					foreach ($filteredData as $data) {

						$hash 																			= md5(json_encode($data));
        		if (!in_array($hash, $seen)) {
        	
            	$seen[] 																	= $hash;
            	$uniqueData[] 														= $data;
            
       			}

					}
					
					break;

			}

			//排序
			usort($uniqueData, function($a, $b){
				
				return strcmp($a["labNo"], $b["labNo"]);
				
			});
			
			//print_r($seen);
			//print_r($uniqueData);
			
			$Plant																						= $_POST["function"];
			PlantHtmlTable::$pubVar["fetch"]									= $uniqueData;
			PlantHtmlTable::$Plant();

		}
		
		//我的工作清單
		/*public static function filterForWorkList()
		{
			
			$date                                           	= explode("-", date("Y-m-d"));
					
			$year 																						= intval($date[0]);
    	$year 																						= $year - 1911;
    	$year 																						= strval($year);
    			 
    	$currentDay																				= $year . $date[1] . $date[2];
			
			$dataArray 																				= json_decode($_POST["Data"], true);
			$filteredData																			= $dataArray;
			
			if($filteredData)
			{
						
				$filteredData 																	= array_unique($filteredData, SORT_REGULAR);

			}

			foreach($filteredData as $data)
			{

				$uniqueKey																			= $data["labNo"] . $data["mcode"] . $data["tubeName"];
						
				if(isset($seen[$uniqueKey]))
				{
							
					$seen[$uniqueKey]["labInfo"][]								= $data["labCode"] . " - " . $data["labName"];
							
				}else{
							
					$data["labInfo"]															= [$data["labCode"] . " - " . $data["labName"]];
							
					unset($data["labCode"]);
					unset($data["diagnosisDescription"]);
					unset($data["labGroupCode"]);
					unset($data["labName"]);
							
					$seen[$uniqueKey]															= $data;
							
				}
						
			}

			$uniqueData																			= array_values($seen);

			//儲存全資料(現在單)
			$allData																					= $uniqueData;

			$seen 																						= [];
			$IDPData		 																			= [];
			
			//過濾成為病人資料
			foreach($uniqueData as $item)
			{
				
				$key = $item["bedNo"] . "-" . $item["chartNo"] . "-" . $item["ptName"];
				
				if(!isset($IDPData[$key]))
				{
					
					$IDPData[$key]																= true;
					$seen[]																				= [ "bedNo" => $item["bedNo"], "chartNo" => $item["chartNo"], "ptName" => $item["ptName"] ];
					
				}
				
			}
			
			//過去單
			$pastData																					= array_filter($uniqueData, function($item) use ($today){
				
				return $item["expectColletionDate"]							< $today;
				
			});
			
			//現在單
			$todayData																				= array_filter($uniqueData, function($item) use ($today){
				
				return $item["expectColletionDate"]							== $today;
				
			});
			
			//未來單
			$futureData																				= array_filter($uniqueData, function($item) use ($today){
				
				return $item["expectColletionDate"]							> $today;
				
			});
			
			$Plant																						= $_POST["function"];
			PlantHtmlTable::$pubVar["fetch"]									= $allData;
			PlantHtmlTable::$pubVar["IDPData"]								= $seen;
			PlantHtmlTable::$pubVar["pastLab"]								= $pastData;
			PlantHtmlTable::$pubVar["todayLab"]								= $todayData;
			PlantHtmlTable::$pubVar["futureLab"]							= $futureData;
			PlantHtmlTable::$Plant();
			
		}*/

	 	//備管作業暫存
	 	public static function testTube()
	 	{

	 		SQLEvent::MySQLconnect();

	 		$allData 																					= json_decode($_POST["Data"], true);
	 	
	 		for($i = 0; $i < count($allData); $i++)
	 		{
	 			
	 			$data 																					= $allData[$i];
	 			
	 			SQLEvent::$MySQLstatement												= "select * from GetBarCodeList where chartNo = '$data[chartNo]' and Aplseq = '$data[labNo]' and mCode = '$data[mCode]' and labCode = '$data[labCode]'";
	 			SQLEvent::MySQLDBEvent();
	 			$fetch																					= SQLEvent::$MySQLfetch;
	 			
	 			if(!$fetch)
	 			{
	 				
	 				SQLEvent::$MySQLstatement											= "insert into GetBarCodeList (chartNo, PtName, Aplseq, mCode, specimenPan, ClinicFlag, SpecimenCode, UrgentFlag, orderDate, orderTime, labCode) values ('$data[chartNo]', '$data[ptName]', '$data[labNo]', '$data[mCode]', '$data[tubeName]', '$data[clinicFlag]', '$data[specimenCode]', '$data[emgFlag]', '$data[labOrderDate]', '$data[labOrderTime]', '$data[labCode]')";
	 				SQLEvent::MySQLDBEvent();
	 				
	 			}
	 			
	 			SQLEvent::$MySQLfetch 													= NULL;
				$fetch																					= NULL;
				
				SQLEvent::$MySQLstatement												= "select * from BackupList where chartNo = '$data[chartNo]' and Aplseq = '$data[labNo]' and mCode = '$data[mCode]' and labCode = '$data[labCode]'";
	 			SQLEvent::MySQLDBEvent();
	 			$fetch																					= SQLEvent::$MySQLfetch;
	 			//print_r($fetch);
	 			
	 			if(!$fetch)
	 			{
	 				
	 				SQLEvent::$MySQLstatement											= "insert into BackupList (chartNo, PtName, Aplseq, mCode, specimenPan, ClinicFlag, UrgentFlag, SpecimenCode, SpecimenName, SpecimenSeq, labCode) values ('$data[chartNo]', '$data[ptName]', '$data[labNo]', '$data[mCode]', '$data[tubeName]', '$data[clinicFlag]', '$data[emgFlag]', '$data[specimenCode]', '$data[specimenName]', '$data[specimenSeq]', '$data[labCode]')";
	 				SQLEvent::MySQLDBEvent();
	 				
	 			}

	 			SQLEvent::$MySQLfetch 													= NULL;
				$fetch																					= NULL;

	 		}

	 	}
	 	
	 	//檢體小包暫存
	 	public static function Package()
	 	{
	 		
	 		SQLEvent::MySQLconnect();
	 		
	 		$data 																					= $_POST["Data"];
	 		
			if($data)
			{
				if($_POST["option"] == "insertPackage")
				{
	 			
					$table																				= "package";
	 			
				}else if($_POST["option"] == "updatePackage")
				{
	 			
					$table																				= "updatePackage";
	 			
				}
	 		
				SQLEvent::$MySQLstatement												= "select * from $table where ChartNo = '$data[chartNo]' and Aplseq = '$data[labNo]' and specimenSeq = '$_POST[specimenSeq]' and dicCode = '$_POST[dicCode]'";
				SQLEvent::MySQLDBEvent();
				$fetch																					= SQLEvent::$MySQLfetch;
	 		
				if(!$fetch){
	 			
					SQLEvent::$MySQLstatement											= "insert into $table (dicCode, ptUnicode, bedNo, ChartNo, PtName, sex, Aplseq, mCode, UrgentFlag, specimenCode, specimenName, specimenSeq, specimenPan, specimenDate, specimenTime, specimenClerk, srorageDate) values ('$_POST[dicCode]', '$data[unicode]', '$data[bedNo]', '$data[chartNo]', '$data[ptName]', '$data[sex]', '$data[labNo]', '$data[mCode]', '$data[emgFlag]', '$data[specimenCode]', '$data[specimenName]', '$_POST[specimenSeq]', '$data[tubeName]', '$data[specimenDate]', '$data[specimenTime]', '$data[specimenClerk]', '$data[storageDate]')";
					SQLEvent::MySQLDBEvent();
	 			
				}
	 		
				SQLEvent::$MySQLfetch 													= NULL;
				$fetch																					= NULL;
			}
			//print_r(SQLEvent::$MySQLstatement);

	 	}
	 	
		//給號
	 	public static function getSpecimenSeq()
	 	{
	 		
	 		$k 																							= 0;
	 		$IDP 																						= [];
	 		
	 		SQLEvent::MySQLconnect();

			//print_r($_POST["Data"]);

	 		for($i = 0; $i < count($_POST["Data"]); $i++)
	 		{
	 			
	 			$Data 																				= $_POST["Data"][$i];
	 			
	 			//print_r($Data);
	 			
	 			if($Data["labNo"])
	 			{
	 				
	 				if($Data["labCode"])
	 				{
	 					
	 					$where 																		= "Aplseq = '" .$Data["labNo"]. "' and mCode = '" .$Data["mCode"]. "' and labCode = '" .$Data["labCode"]. "'";
	 					
	 				}else{
	 				
	 					$where 																		= "Aplseq = '" .$Data["labNo"]. "' and mCode = '" .$Data["mCode"]. "'";

	 				}

	 			}else if($Data["chartNo"]){
	 				
	 				$where 																			= "chartNo = '" .$Data["chartNo"]. "'";	
	 				
	 			}
	
	 			SQLEvent::$MySQLstatement 										= "select * from GetBarCodeList where " .$where;
    		SQLEvent::MySQLDBEvent();
        $fetch 																				= SQLEvent::$MySQLfetch;
        
        //print_r(SQLEvent::$MySQLstatement);
        
        if($fetch)
        {
        	
        	for($j = 0; $j < count($fetch); $j++)
        	{
        		
        		$eachData																	= $fetch[$j];
        		$IDP[$k]["mCode"]													= $eachData["mCode"];
        		$IDP[$k]["NurseStation"]									= $_POST["dicName"];
				$IDP[$k]["StationName"]										= $_POST["dicName"];
        		$IDP[$k]["workstation"]										= $_POST["dicCode"];
        		$IDP[$k]["insMan"]												= $_POST["username"];
        		$IDP[$k]["insDate"]												= date("Y-m-d");
        		$IDP[$k]["insTime"]												= date("H:i:s");
        		
        		if($_POST["ip"]) //如果傳送資料有ip，即為QQ備管
        		{
        			
        			$IDP[$k]["ip"]													= $_POST["ip"];
        			$IDP[$k]["printCount"]									= $_POST["printCount"];
        			
        		}
        		
        		$order																		= [];
        		$order["LabCodes"] 												= [];
        		
        		//print_r($eachData);
        		
        		foreach($eachData as $key => $value)
        		{
        			
        			switch($key)
        			{
        				
        				case "ClinicFlag":
            			
            			$order["ClinicFlag"] 								= $value;
            			
            			break;
            					
            		case "SpecimenCode":
            			
            			$order["SpecimenCode"] 							= $value;
            			
            			break;
                    
               	case "UrgentFlag":

                  $order["UrgentFlag"] 								= $value;
                    	
                  break;
                    
                case "Aplseq":
                
                  $order["Aplseq"] 										= $value;
                    
                  break;
                    
                case "orderDate":
                
                  $order["OrderDate"]			  					= $value;
                    
                  break;
                    
                case "orderTime":
                
                  $order["OrderTime"] 								= $value;
                    
                  break;
      
               	case "ChartNo":
                
                  $IDP[$k]["ChartNo"] 								= $value;
                    
                  break;
                    
                case "PtName":
                
                  $IDP[$k]["PtName"] 									= $value;
                    
                  break;
                    	
                case "labCode":
                  
                 	$order["LabCodes"][0] 							= $value;
                  
                  break;
                    
            	}
            	
        		}
        
        		if (!isset($IDP[$k]["Orders"]))
        		{
        	
            		$IDP[$k]["Orders"] 										= [];
            
        		}
        	
        		$IDP[$k]["Orders"][0] 										= $order;
        		//print_r($IDP[$k]);
        		$k = $k + 1;
        		
        	}	
        	
        }			
	 			
	 			$fetch 																				= null;
    		SQLEvent::$MySQLfetch 												= null;
	 			
	 		}
	 		
	 		//相同資料合併（用於以病歷號為單位備管）
	 		$mergedData 																		= [];

			foreach ($IDP as $item) {
				
    		$hash = md5(json_encode($item)); // 使用JSON編碼計算Hash函數相同的資料合併

    		if (!isset($mergedData[$hash])) {
    		
        	$mergedData[$hash] 											  	= $item;
        
    		}	
    	
			}

			//$mergedData 																		= array_values($mergedData);
			//print_r($mergedData);
			
			//合併相同管別的單號		
			$RealData 																			= [];

			foreach ($mergedData as $item) 
			{
				
    		$mCode 																				= $item["mCode"];
    		$aplseq 																			= $item["Orders"][0]["Aplseq"];
  
    		if (!isset($RealData[$mCode])) {
        	
        	//如果mcode不存在在realdata中，則加入其中
        	$RealData[$mCode] 													= [];
    		}
    
    		//找到是否存在已經相同的aplseq
    		$found 																				= false;
    		foreach ($RealData[$mCode] as &$realItem) {
        
        	if ($realItem["Orders"][0]["Aplseq"] === $aplseq) {
          
            //找到相同的aplseq並與其labcode合併
            $realItem["Orders"][0]["LabCodes"] 				= array_merge($realItem["Orders"][0]["LabCodes"], $item["Orders"][0]["LabCodes"]);
            $found 																		= true;
            break;
        
        	}
    		}
    
    		if (!$found) {
        
        	//如果沒有找到相同的aplseq就添加新的項目
        	$RealData[$mCode][] 											 	= $item;
        	
    		}
    		
			}
			
			$finalData 																			= [];
			
			//整理成簡單陣列
			foreach ($RealData as $items) {
    	
    		foreach ($items as $item) {
    			
        	$finalData[] 																= $item;
        	
    		}
			
			}

			//刪除mCode
			foreach ($finalData as &$item) {
				
        unset($item["mCode"]);
        
    	}
    	
    	//排序資料，讓QQ條碼列印機可以排序列印。TMC一定不要排序，會造成條碼混亂
    	if($_POST["ip"]) //如果傳送資料有ip，即為QQ備管
    	{
    		
    		usort($finalData, function($a, $b) {
    
    			return strcmp($a['ChartNo'], $b['ChartNo']);

				});
				
			}

      //$RealData 																		= array_values($RealData);
      print_r(json_encode($finalData));
	  
	  $directoryPath = 'output'; // 指定文件?名?

    // 生成??文件名，使用?前日期和??
    $timestamp = date('Ymd_His'); // 格式? YYYYMMDD_HHMMSS
    $fileName = "finalData_{$timestamp}.json"; // ?合??戳生成文件名
    $filePath = $directoryPath . '/' . $fileName; // 指定文件路?

    // ?查文件?是否存在，如果不存在??建
    if (!is_dir($directoryPath)) {
        mkdir($directoryPath, 0755, true); // ?建文件?，?限?置? 0755
    }

    // ? JSON ?据?入文件
    file_put_contents($filePath, json_encode($finalData, JSON_UNESCAPED_UNICODE));
	 		
	 	}

	 	//備管
	 	public static function Backup()
	 	{

	 		SQLEvent::MySQLconnect();
	 		//print_r($_POST["Data"]);
	 		
	 		$number                                           			= 0;
	 		
	 		if($_POST["IsLabelOnly"] == "printTube")
	 		{
	 				
	 			$IsLabelOnly																					= false;
	 				
	 		}else if($_POST["IsLabelOnly"] == "noTube"){
	 				
	 			$IsLabelOnly																					= true;
	 				
	 		}
	 		
	 		if($_POST["sid"])
	 		{
	 			
	 			for($i = 0; $i < count($_POST["sid"]); $i++)
	 			{

	 				$sid																								= $_POST["sid"][$i];
	 				
	 				if(!$sid["error"])
	 				{
	 					//print_r($sid);
	 					//$Data																								= $_POST["Data"][$i];
	 					$mCode																							= $sid["mCode"];
	 					$outputData																					= explode("|", $sid["output"]);
	 					$outputData																					= explode("^", $outputData[3]);
	 					$specimenSeq																				= $outputData[0];
	 					$labNo																							= $outputData[1];
	 				
	 					//output: 20240909220318943|0000087452|1|B39901G0001^LI138S0082^1^6300060
	 					//print_r($specimenCode);

	 					SQLEvent::$MySQLstatement														= "update BackupList set specimenSeq = '$specimenSeq' where Aplseq = '$labNo' and mCode = '$mCode'";
	 					SQLEvent::MySQLDBEvent();
	 					//print_r(SQLEvent::$MySQLstatement);
	 				}
	 			}
	 		
	 		}
	 		
	 		for($i = 0; $i < count($_POST["Data"]); $i++)
	 		{
	 			
	 			$Data																									= $_POST["Data"][$i];

				SQLEvent::$MySQLstatement															= "select * from BackupList where Aplseq = '$Data[labNo]' and mCode = '$Data[mCode]'";
	 			SQLEvent::MySQLDBEvent();
	 			//print_r(SQLEvent::$MySQLstatement);

				$fetch 																								= SQLEvent::$MySQLfetch;
				//print_r($fetch);
				
				if($fetch)
				{
					
					for($j = 0; $j < count($fetch); $j++)
	 				{
	 				
	 					$data 																						= $fetch[$j];
	 					//$List[$j]["mCode"]																= $data["mCode"];
        		$List[$number]["IsLabelOnly"]											= $IsLabelOnly;
        		$List[$number]["dicCode"]													= $_POST["dicCode"];
        		$List[$number]["labCodes"]												= [];
        	
        		foreach($data as $k => $v)
        		{
        		
        			switch($k)
        			{
        			
        				case "Aplseq":
        			
        					$List[$number]["labNo"]											= $v;
        					break;
        				
        				case "ChartNo":
        			
        					$List[$number]["chartNo"]										= $v;
        					break;
        				
        				case "PtName":
        			
        					$List[$number]["ptName"]										= $v;
        					break;
        				
        				case "specimenSeq":
        			
        					if($_POST["specimenSeq"])
        					{
        						
        						$List[$number]["specimenSeq"]							= $_POST["specimenSeq"];
        					
        					}else{
        					
        						$List[$number]["specimenSeq"]							= $v;
        					
        					}

        					break;
        				
        				case "SpecimenCode":
        		
        					$List[$number]["specimenCode"]							= $v;
        					break;
        				
        				case "specimenName":
        			
        					$List[$number]["specimenName"]							= $v;
        					break;
        				
        				case "ClinicFlag":
        			
        					$List[$number]["clinicFlag"]								= $v;
        					break;
        				
        				case "UrgentFlag":
        			
        					$List[$number]["UrgentFlag"]								= $v;
        					break;
        				
        				case "mCode":
        			
        					$List[$number]["mCode"]											= $v;
        					break;
        			
        				case "specimenPan":
        			
        					$List[$number]["tubeName"]									= $v;
        					break;

        				case "labCode":
        			
        					$List[$number]["labCodes"][0]								= $v;
        					break;
        			
        			}
        		
       			}
	 				
	 					$number																						= $number + 1;
	 				
	 				}
	 				
	 			}
	 			
	 		}	
	 		 	
	 		//print_r($List);	

	 		$mergedData 																						= [];
	 		
			foreach ($List as $item){
	
    		$key 																									= $item["specimenSeq"] . "-" . $item["mCode"];
    		if (!isset($mergedData[$key])){
    			
        	$mergedData[$key] 																	= $item;
        	
    		}else{
    			
        	$mergedData[$key]["labCodes"] 											= array_merge($mergedData[$key]["labCodes"], $item["labCodes"]);
    		
    		}
    
			}

			$mergedData 																						= array_values($mergedData);

			// 整理成簡單陣列
			$finalData 																							= [];
			
			foreach ($mergedData as $item){
				
    		$finalData[] 																					= $item;
    
			}
			
			//排序
			usort($finalData, function($a, $b) {
    
    		return strcmp($a['ChartNo'], $b['ChartNo']);

			});
			
			$groupedData 																						= [];

			//遍歷排序後的finalData
			foreach ($finalData as $item) {
    
    		$chartNo 																							= $item['chartNo'];
    
    		//如果該chartNo的分組不存在，創建一個新的陣列
    		if (!isset($groupedData[$chartNo])) {
        
        	$groupedData[$chartNo] 															= [];
    
    		}
    
    		//item添加到對應的chartNo分組中
    		$groupedData[$chartNo][] 															= $item;

			}

			//將關聯陣列轉換為索引陣列
			$groupedData 																						= array_values($groupedData);

			
			print_r(json_encode($groupedData));
	 				 			
	 	}
	 	
	 	public static function TMCbarcode()
	 	{
	 		
	 		$response["listNo"]																= $_POST["listNo"];
	 		$response["sendDate"]															= date("Y-m-d");
	 		$response["sendTime"]															= date("H:i:s");
	 		$response["sendStation"]													= $_POST["dicCode"];
	 		$response["sendMan"]															= $_POST["userid"];
	 		$response["barcode"]															= $_POST["listNo"];
	 		
	 		print_r(json_encode($response));
	 		
	 	}

	 	//產生Unicode
	 	public static function createUnicode()
	 	{
	 		
	 		$randomEN_NO 																		= "0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,M,N,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,m,n,p,q,r,s,t,u,v,w,x,y,z";
			$randstr 																				= explode(",", $randomEN_NO);
			
			do{
				
				for($i = 0 ; $i < 6 ; $i++)
				{
					$rand 																			= rand(0,count($randstr) - 1);
					$result[] 																	= $randstr[$rand];
				}
		
				$randomString																	= implode("", $result);
				$unicode																			= date("Y").$randomString;

			}while(self::checkUnicode($unicode));
			
			$Unicode								 												= implode("",$result);
			self::$pubVar["listUnicode"]										= date("Y").$Unicode;

	 	}
	 	
	 	//檢驗Unicode唯一性
	 	public static function checkUnicode($unicode)
	 	{
	 		
	 		SQLEvent::MySQLconnect();
			SQLEvent::$MySQLstatement 											= "select COUNT(*) as count from token where unicode = '" .$unicode. "'";
  		SQLEvent::MySQLDBEvent();
  		$fetch 																					= SQLEvent::$MySQLfetch;

	 		return $fetch[0]["count"] > 0;

	 	}
	 	
	 	//生成ListNO
	 	public static function createListNo($dicCode)
		{
			
    	$count 																					= 1;

    	// 不斷生成新的 ListNo 直到沒有相同資料
    	do {
    		
        $str 																					= date("y");
    		$int 																					= intval($str);
    		$year 																				= $int - 11;
    		$str 																					= strval($year);
    		$lastTwoChars 																= substr($str, -2);
    
    		// $count 不足兩位數補0
    		$formattedCount 															= str_pad($count, 2, "0", STR_PAD_LEFT);
    
    		$ListNo 																			= $lastTwoChars . date("md") . $dicCode . $formattedCount;
        $count++;
        
    	} while (self::checkListNo($ListNo));
    
    	// 生成成功的 ListNo，可以在這裡進一步處理或返回
    	self::$pubVar["listNo"]													= $ListNo;
    	
		}

		//檢驗ListNo
		public static function checkListNo($ListNo)
		{
			
   			SQLEvent::MySQLconnect();
    		SQLEvent::$MySQLstatement 										= "select COUNT(*) as count from token where listNo = '" . $ListNo . "'";
    		SQLEvent::MySQLDBEvent();
    		$fetch 																				= SQLEvent::$MySQLfetch;

    		return $fetch[0]["count"] > 0;

		}
	 	
	 	//打包
	 	public static function newPackage()
	 	{
	 		
	 		SQLEvent::MySQLconnect();

			//$aplseq																					= [];
	 		$LocID																					= $_POST["dicCode"];
	 		$LocName																				= $_POST["IP"];
	 		$userMan																				= $_POST["userid"];
	 		$userName																				= $_POST["username"];
	 		
	 		$currentDate																		= date("Y-m-d");
	 		$currentTime																		= date("H:i:s");
	 		
	 		$tubeCount																			= 0;
	 		$orderCount																			= 0;
	 		
	 		$dicCode																				= explode("-", $_POST["dicCode"]);

			self::createUnicode();
			self::createListNo($dicCode[0]);
			
			$listUnicode																		= self::$pubVar["listUnicode"];
			$listNo																					= self::$pubVar["listNo"];
			
			//計算管數與張數
	 		for($i = 0; $i < count($_POST["Data"]); $i++)
	 		{
	 			
	 			$tubeCount																		= $i + 1;
	 			$orderCount																		= $i + 1;
	 			
	 		}
	 		
	 		$ListH["listUnicode"]														= $listUnicode;
	 		$ListH["class"]																	= "0";
	 		$ListH["className"]															= "護理站打包";
	 		$ListH["customID"]															= "00";
	 		$ListH["caseID"]																= "00";
	 		$ListH["locID"]																	= $LocID;
	 		$ListH["Workstation"]														= $LocID;
	 		$ListH["locName"]																= $LocName;
	 		$ListH["process"]																= "0";
	 		$ListH["sendMan"]																= $userMan;
	 		$ListH["sendName"]															= $userName;
	 		$ListH["sendDate"]															= $currentDate;
	 		$ListH["sendTime"]															= $currentTime;
	 		$ListH["orderCount"]														= $orderCount;
	 		$ListH["tubeCount"]															= $tubeCount;
	 		$ListH["listNo"]																= $listNo;
	 		$ListH["isVerified"]														= "0";
	 		$ListH["InsDate"]																= $currentDate;
	 		$ListH["InsTime"]																= $currentTime;
	 		$ListH["InsMan"]																= $userMan;
	 		$ListH["isValid"]																= "1";
	 		$ListH["InsName"]																= $userName;
	 		$ListH["ListB"]																	= [];
	 		
	 		for($i = 0; $i < count($_POST["Data"]); $i++)
	 		{
	 			
	 			$Data																					= $_POST["Data"][$i];
	 			
	 			SQLEvent::$MySQLstatement											= "select * from package where specimenSeq = '$Data'";
	 			SQLEvent::MySQLDBEvent();
	 			$fetch																				= SQLEvent::$MySQLfetch;
	 			
	 			$aplseq[]																			= $fetch[0]["Aplseq"];
	 			
	 			foreach($fetch[0] as $k => $v)
	 			{
	 				
	 				$ListB[$i]["listUnicode"]											= $listUnicode;
	 				$ListB[$i]["ordUnicode"]											= $listNo;
	 				$ListB[$i]["tubeQTY"]													=	"1";
	 				$ListB[$i]["isValid"]													= "1";
	 				
	 				switch($k)
	 				{
	 					
	 					case "ptUnicode":
	 						
	 						$ListB[$i]["ptUnicode"]										= $v;
	 					
	 						break;
	 					
	 					case "ChartNo":
	 						
	 						$ListB[$i]["subID"]												= $v;
	 					
	 						break;
	 						
	 					case "PtName":
	 						
	 						$ListB[$i]["subInitials"]									= $v;
	 					
	 						break;
	 						
	 					case "Aplseq":
	 						
	 						$ListB[$i]["orderNo"]											= $v;
	 					
	 						break;
	 						
	 					case "ptUnicode":
	 						
	 						$ListB[$i]["ptUnicode"]										= $v;
	 					
	 						break;
	 						
	 					case "ptUnicode":
	 						
	 						$ListB[$i]["ptUnicode"]										= $v;
	 					
	 						break;
	 						
	 					case "ptUnicode":
	 						
	 						$ListB[$i]["ptUnicode"]										= $v;
	 					
	 						break;
	 						
	 					case "specimenDate":
	 					
	 						$ListB[$i]["TubeDate"]										= $v;
	 						
	 						break;
	 						
	 					case "specimenTime":
	 					
	 						$ListB[$i]["TubeTime"]										= $v;
	 						
	 						break;
	 					
	 					case "specimenClerk":
	 					
	 						$ListB[$i]["TubeMan"]											= $v;
	 						
	 						break;
	 						
	 					case "srorageDate":
	 					
	 						$ListB[$i]["InsDate"]											= $currentDate;
	 						$ListB[$i]["InsTime"]											= $currentTime;
	 						
	 						break;
	 						
	 					case "specimenSeq":
	 					
	 						$ListB[$i]["specimenSeq"]									= $v;
	 						
	 						break;
	 						
	 					case "mCode":
	 					
	 						$ListB[$i]["mCode"]												= $v;
	 						
	 						break;
	 						
	 					case "specimenPan":
	 					
	 						$ListB[$i]["dicName"]											= $v;
	 						//print_r($v);
	 					
	 						break;
	 					
	 				}
	 				
	 			}													
	 			
	 		}
	 		
	 		//捨棄相同的單號
	 		//$aplseq																					= array_unique($aplseq);
	 		//計算捨棄後的單號數量
	 		//$orderCount																			= count($aplseq);
	 		
	 		$ListH["orderCount"]														= $orderCount;
	 		
	 		$ListH["ListB"]																	= $ListB;
	 		
	 		$response["status"]															= "success";
	 		$response["Data"]																= $ListH;
	 		$response["ListNo"]															= $listNo;
	 		$response["unicode"]														= $listUnicode;
	 		
	 		print_r(json_encode($response));
	 		//print_r(json_encode($ListNo));
	 		
	 	}
	 	
	 	//刪除暫存
	 	public static function deleteRecode()
	 	{
	 		
	 		switch($_POST["option"])
	 		{
	 			
	 			case "insertPackage":
	 			case "pan":
	 			
	 				$table																				= "package";
	 				
	 				break;
	 				
	 			case "updatePackage":
	 			
	 				$table																				= "updatePackage";
	 				
	 				break;
	 			
	 		}

			if($_POST["labNo"])
			{
				
				SQLEvent::MySQLconnect();
	 			SQLEvent::$MySQLstatement 									  = "delete from $table where dicCode = '$_POST[dicCode]' and Aplseq = '$_POST[labNo]'";
    		SQLEvent::MySQLDBEvent();
    		print_r(SQLEvent::$MySQLstatement);
				
			}else{
				
				SQLEvent::MySQLconnect();
	 			SQLEvent::$MySQLstatement 									  = "delete from $table where dicCode = '$_POST[dicCode]'";
    		SQLEvent::MySQLDBEvent();
    		print_r(SQLEvent::$MySQLstatement);
				
			}

	 	}
	 	
	 	//儲存打包唯一碼
	 	public static function saveUnicode()
	 	{
	 		
	 		SQLEvent::MySQLconnect();			
			SQLEvent::$MySQLstatement 									  		= "insert into token (unicode, listNo) values ('$_POST[unicode]', '$_POST[listNo]')";
    	SQLEvent::MySQLDBEvent();
    	print_r(SQLEvent::$MySQLstatement);
	 		
	 	}

	 	//刪除打包token
	 	public static function delPackage()
	 	{

  		SQLEvent::MySQLconnect();
			SQLEvent::$MySQLstatement 									  		= "delete from token where unicode = '$_POST[listUnicode]' and listNo = '$_POST[listNo]'";
    	SQLEvent::MySQLDBEvent();	
	 		
	 	}
	 	
	 	//打包刪除單管
	 	public static function delTube()
	 	{
	 		
	 		$response																				= "1";
	 		
	 		print_r(json_encode($response));

	 	}
	 	
	 	//更新小包
	 	public static function updatePackage()
	 	{

	 		SQLEvent::MySQLconnect();

			$listUnicode																			= $_POST["listUnicode"];
			$listNo																						= $_POST["listNo"];
	 		$modifyMan																				= $_POST["userid"];
	 		$modifyName																				= $_POST["username"];
	 		
	 		$modifyDate																				= date("Y-m-d");
	 		$modifyTime																				= date("H:i:s");
	 		
	 		$tubeCount																				= 0;
	 		$orderCount																				= 0;
	 		
	 		for($i = 0; $i < count($_POST["Data"]); $i++)
	 		{
	 			
	 			$tubeCount																			= $i + 1;
	 			$orderCount																			= $i + 1;
	 			
	 		}
	 		
	 		$ListH["listUnicode"]															= $listUnicode;
	 		$ListH["listNo"]																	= $listNo;
	 		$ListH["ModifyMan"]																= $modifyMan;
	 		$ListH["ModifyName"]															= $modifyName;
	 		$ListH["ModifyDate"]															= $modifyDate;
	 		$ListH["ModifyTime"]															= $modifyTime;
	 		$ListH["tubeCount"]																= $tubeCount;
	 		$ListH["orderCount"]															= $orderCount;
	 		$ListH["listB"]																		= [];
	 		
	 		//抓取MSSQL病患資料
	 		for($i = 0; $i < count($_POST["Data"]); $i++)
	 		{
	 			
	 			$Data																						= $_POST["Data"][$i];
	 			
	 			SQLEvent::$MySQLstatement												= "select * from updatePackage where specimenSeq = '$Data'";
	 			SQLEvent::MySQLDBEvent();
	 			$fetch																					= SQLEvent::$MySQLfetch;
	 			
	 			$aplseq[]																				= $fetch[0]["Aplseq"];
	 			
	 			foreach($fetch[0] as $k => $v)
	 			{
	 				
	 				$ListB[$i]["listUnicode"]											= $listUnicode;
	 				$ListB[$i]["ordUnicode"]											= $listNo;
	 				$ListB[$i]["tubeQTY"]													=	"1";
	 				$ListB[$i]["isValid"]													= "1";
	 				
	 				switch($k)
	 				{
	 					
	 					case "ptUnicode":
	 						
	 						$ListB[$i]["ptUnicode"]										= $v;
	 					
	 						break;
	 					
	 					case "ChartNo":
	 						
	 						$ListB[$i]["subID"]												= $v;
	 					
	 						break;
	 						
	 					case "PtName":
	 						
	 						$ListB[$i]["subInitials"]									= $v;
	 					
	 						break;
	 						
	 					case "Aplseq":
	 						
	 						$ListB[$i]["orderNo"]											= $v;
	 					
	 						break;
	 						
	 					case "ptUnicode":
	 						
	 						$ListB[$i]["ptUnicode"]										= $v;
	 					
	 						break;
	 						
	 					case "ptUnicode":
	 						
	 						$ListB[$i]["ptUnicode"]										= $v;
	 					
	 						break;
	 						
	 					case "ptUnicode":
	 						
	 						$ListB[$i]["ptUnicode"]										= $v;
	 					
	 						break;
	 						
	 					case "specimenDate":
	 					
	 						$ListB[$i]["collectDate"]									= $v;
	 						
	 						break;
	 						
	 					case "specimenTime":
	 					
	 						$ListB[$i]["collectTime"]									= $v;
	 						
	 						break;
	 					
	 					case "specimenClerk":
	 					
	 						$ListB[$i]["collectMan"]									= $v;
	 						
	 						break;
	 						
	 					case "srorageDate":
	 					
	 						$ListB[$i]["InsDate"]											= $v;
	 						
	 						break;
	 						
	 					case "specimenSeq":
	 					
	 						$ListB[$i]["specimenSeq"]									= $v;
	 						
	 						break;
	 						
	 					case "specimenPan":
	 					
	 						$ListB[$i]["tubeName"]										= $v;
	 						
	 						break;
	 					
	 				}
	 				
	 			}													
	 			
	 		}
	 		
	 		//$aplseq																						= array_unique($aplseq);
	 		//$orderCount																				= count($aplseq);
	 			
	 		//$ListH["orderCount"]															= $orderCount;
	 		
	 		$ListH["listB"]																		= $ListB;
	 		
	 		$response["status"]																= "success";
	 		$response["Data"]																	= $ListH;
	 		$response["ListNo"]																= $listNo;
	 		$response["orderCount"]														= $orderCount;
	 		$response["tubeCount"]														= $tubeCount; 
	 		
	 		print_r(json_encode($response));
	 		//print_r(json_encode($ListNo));

	 	}
	 	
	 	public static function updateSpecimenSeq()
	 	{
	 		
	 		$Data																							= explode("|", $_POST["Data"]);
	 		$Data																							= explode("^", $Data[3]);
	 		$specimenCode																			= $Data[0];
	 		
	 		SQLEvent::MySQLconnect();
	 		SQLEvent::$MySQLstatement													= "update BackupList set specimenSeq = '$specimenCode' where chartNo = '$_POST[chartNo]' and Aplseq = '$_POST[Aplseq]' and mCode = '$_POST[mCode]'";
	 		SQLEvent::MySQLDBEvent();
	 		
	 		print_r(SQLEvent::$MySQLstatement);
	 		
	 	}
	 	
	 		 	
	 	//儲存已打包內容物
	 	public static function packagedContent()
	 	{
	 		
	 		SQLEvent::MySQLconnect();
	 		
	 		if($_POST["option"] == "new")
	 		{
	 			
	 			$table																					= "package";
	 			
	 		}else{
	 			
	 			$table																					= "updatePackage";
	 			
	 		}
	 		
	 		for($i = 0; $i < count($_POST["Data"]); $i++)
	 		{
	 			
	 			$specimenSeq																		= $_POST["Data"][$i];
	 			SQLEvent::$MySQLstatement												= "select Aplseq from $table where specimenSeq = '$specimenSeq'";
	 			SQLEvent::MySQLDBEvent();
	 			$fetch																					= SQLEvent::$MySQLfetch;
	 			$Aplseq																					= $fetch[0]["Aplseq"];
	 			print_r($fetch);
	 			print_r($fetch[0]["Aplseq"]);
	 			print_r($Aplseq);
	 			SQLEvent::$MySQLstatement 									  	= "insert into packagedContent (unicode, listNo, Aplseq, specimenSeq, status) values ('$_POST[unicode]', '$_POST[listNo]', '$Aplseq', '$specimenSeq', '1')";
    		SQLEvent::MySQLDBEvent();
    		print_r(SQLEvent::$MySQLstatement);
    		
    		//status = 1 打包 | status = 2 送出 | status = 3 送達 | status = NULL 可在備管記錄中刪除條碼號且可刪除空的小包
	 			
	 		}

	 	}
	 	
	 	//更新狀態
	 	public static function updateStatus()
	 	{
	 		
	 		SQLEvent::MySQLconnect();
	 		
	 		switch($_POST["option"])
	 		{
	 			
	 			case "signOut":
	 			
	 				$status																					= "2";
	 				
	 				break;
	 				
	 			case "signIn":
	 			
	 				$status																					= "3";
	 				
	 				break;
	 			
	 		}

	 		$listNo																					= $_POST["Data"];
	 		SQLEvent::$MySQLstatement												= "update packagedContent set status = '$status' where listNo = '$listNo'";
	 		SQLEvent::MySQLDBEvent();
	 		
	 		
	 	}
	 
	 	//檢查刪除
	 	public static function checkDelete()
	 	{
	 		
	 		SQLEvent::MySQLconnect();
	 		
	 		//print_r($_POST["option"]);
	 		
	 		switch($_POST["option"])
	 		{
	 			
	 			case "signOut":
	 			case "signIn":
	 			case "delPackage":
	 			
	 				$where																			= "listNo = '$_POST[Data]'";
	 			
	 				break;
	 				
	 			case "delTube":
	 			
	 				$where																			= "listNo = '$_POST[listNo]' and specimenSeq = '$_POST[specimenSeq]'";
	 				
	 				break;
	 				
	 			case "deleteBarcode":
	 			
	 				$where																			= "Aplseq = '$_POST[labNo]'";
	 			
	 				break;

	 		}
	 		
	 		SQLEvent::$MySQLstatement												= "select status from packagedContent where $where";
	 		SQLEvent::MySQLDBEvent();
	 		$fetch																					= SQLEvent::$MySQLfetch;
	 		
	 		//print_r(SQLEvent::$MySQLstatement);
	 		
	 		if($fetch)
	 		{
	 			
	 			$response["status"]														= $fetch[0]["status"];
	 			
	 		}else{
	 			
	 			$response["status"]														= NULL;
	 			
	 		}
	 		
	 		print_r(json_encode($response));
	 		
	 	}
	 	
	 	//更新刪除後狀態
	 	public static function updateDeleteStatus()
	 	{
	 		
	 		SQLEvent::MySQLconnect();
	 		
	 		print_r($_POST["status"]);
	 		
	 		switch($_POST["status"])
	 		{
	 			
	 			case "0":
	 			
	 				$status																					= "0";
	 				SQLEvent::$MySQLstatement												= "delete from packagedContent where listNo = '$_POST[Data]' and specimenSeq = '$_POST[specimenSeq]'";
	 				
	 				break;
	 			
	 			case "1":
	 			
	 				SQLEvent::$MySQLstatement												= "delete from packagedContent where listNo = '$_POST[Data]'";
	 			
	 				break;
	 			
	 			case "2":
	 			
	 				$status																					= "1";
	 				SQLEvent::$MySQLstatement												= "update packagedContent set status = '$status' where listNo = '$_POST[Data]'";
	 				
	 				break;
	 				
	 			case "3":
	 			
	 				$status																					= "2";
	 				SQLEvent::$MySQLstatement												= "update packagedContent set status = '$status' where listNo = '$_POST[Data]'";
	 				
	 				break;
	 			
	 		}
	 		
	 		SQLEvent::MySQLDBEvent();
	 		
	 		print_r(SQLEvent::$MySQLstatement);
	 		
	 	}
	 	
	 	public static function Log()
	 	{
	 		
	 		$date                                           		= date("Y-m-d");
			$time																								= date("H:i");
			
			SQLEvent::MySQLconnect();
	 		
	 		switch($_POST["option"])
	 		{
	 			
	 			//給號的Log
	 			case "getSid":
	 			
	 				$store																					= "(labNo, date, time, type, log) values ('$_POST[Data]', '$date', '$time', '$_POST[option]', '$_POST[error]')";
	 			
	 				break;
	 			
	 			//備管的Log
	 			case "backup":
	 			
	 				break;
	 				
	 			/*case "":
	 			
	 				break;
	 				
	 			case*/ 
	 			
	 		}
	 		
	 		SQLEvent::$MySQLstatement														= "insert into Log $store";
	 		//"insert into GetBarCodeList (chartNo, PtName, Aplseq, mCode, specimenPan, ClinicFlag, SpecimenCode, UrgentFlag, orderDate, orderTime, labCode) values ('$data[chartNo]', '$data[ptName]', '$data[labNo]', '$data[mCode]', '$data[tubeName]', '$data[clinicFlag]', '$data[specimenCode]', '$data[emgFlag]', '$data[labOrderDate]', '$data[labOrderTime]', '$data[labCode]')";
	 		
	 	}
	 	
	}
	
	$Option = new Option();
	
	

?>