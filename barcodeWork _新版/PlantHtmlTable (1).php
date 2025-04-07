<?php

class PlantHtmlTable
{

	public static $pubVar 											= array();
	
	function __construct()
	{
		
		date_default_timezone_set('Asia/Taipei');
			
	}
	
	//註冊帳號
	public static function register()
	{
		
		$response																	= "<register box=title>註冊帳號</register>
				
																									<form box=form option=register>
																									
																										<register box=input>
						
																											<select box=role name=role pos=register>
																											
																												<option>--請選擇您的身份--</option>
																												<option value=NS>護理師</option>
																												<option value=TS>護工</option>
																											
																											</select>
						
																										</register>
																										
																										<register box=input>
						
																											<select box=station name=station pos=register>
																											
																												<option>--請選擇護理站--</option>
																												<option value=10A-01>10A-01</option>
																												<option value=10A-02>10A-02</option>
																												<option value=11A-01>11A-01</option>
																												<option value=11A-02>11A-02</option>
																												<option value=12A-01>12A-01</option>
																												<option value=12A-02>12A-02</option>
																											
																											</select>
						
																										</register>
																									
																										<register box=input>
						
																											<input box=username name=username pos=register type=text placeholder=請輸入您的名稱>
						
																										</register>
					
																										<register box=input>
						
																											<input box=userid name=userid pos=register type=text placeholder=請輸入您的帳號>
						
																										</register>
					
																										<register box=input>
					
																											<input box=username name=password pos=register type=password placeholder=請輸入您的密碼>
						
																										</register>
																										
																										<register box=input>
					
																											<input box=username name=password pos=register type=password placeholder=再次輸入您的密碼>
						
																										</register>
					
																										<register box=error></register>

																										<register box=input pos=bottom>
						
																											<register box=button option=register action=resgister>註冊</login>
						
																										</register>
					
																									</form>";
																									
		print_r(json_encode($response));
		
	}
	
	//註冊護理站
	public static function setIP()
	{
		
		if($_COOKIE["dicCode"])
		{
			
			$dicCode 																= $_COOKIE["dicCode"];
			
		}
		
		if($dicCode == "ER")
		{
			
			$ERinput																= "style='display: flex;'";
			
		}
		
		if($_COOKIE["machineIP"])
		{
			
			$machineIP															= $_COOKIE["machineIP"];
			
		}
		
		
		$response																	= "<login box=title>註冊護理站</login>
				
																											<form box=form option=login>
					
																												<login box=inputIcon>
						
																													<input box=ip name=ip pos=login type=text value=$_POST[ip] readOnly>
						
																												</login>		
					
																												<login box=inputIcon>
																												
																													<input box=dicCode name=dicCode pos=login type=text placeholder=請輸入護理站代碼 value=$dicCode>
																												
																												</login>
					
																												<login box=inputIcon>

																													<select box=mechine>
						
																														<option selected disabled hidden>請選擇列印儀器</option>
																														<option value=TMC>TMC備管機</option>
																														<option value=QQ>條碼列印機</option>

																													</select>
																												
																												</login>
																												
																												<login box=inputIcon>
																												
																													<input box=machineIP name=machineIP pos=login type=text placeholder=請輸入儀器IP value=$machineIP>
																												
																												</login>
																												
																												<login box=inputIcon option=otherIP $ERinput>
																												
																													<input box=otherIP name=otherIP pos=login type=text placeholder=請輸入備用儀器IP value=$machineIP>
																												
																												</login>	

																												<login box=inputIcon pos=bottom>
						
																													<login box=button option=setIP pos=setIP action=setIP>註冊護理站</login>
						
																												</login>
	
																											</form>";
																									
		print_r(json_encode($response));
		
	}
	
	//備管作業
	public static function testTube()
	{
		
		if($_POST["machine"] == "TMC")
		{
			
			$checkbox																= "<input box=IsLabelOnly type=checkbox>只印條碼</input>";
			
		}else{
			 	
			$checkbox																= "<input type=number name=quantity min=1 max=5 stpe=1 value=1>列印張數</input>";
			 	
		}
		
		$response																	= "<errorTube box=bar></errorTube>
																								 <errorTube box=icon>&#xf06a</errorTube>
																								 <errorTube box=content></errorTube>
		
																								 <home box=workarea>
																									<home box=title>
																																															
																										<text>單號備管</text>
																										<printcheck>$checkbox</printcheck>

																										<input box=scan store=testTube action=Filter function=testTubeScan placeholder=檢驗單>
																										<home box=button pos=intoTestTube store=testTube action=Filter function=testTubeScan option=submit>確認輸入</home>
																										<home box=button pos=testTube action=getSpecimenSeq option=submit>備管</home>
																										<reflash go=testTube action=Plant	function=testTube title=重新整理>&#xf021</reflash>								
																								
																										<error></error>
																								
																									</home>
																								
																									<table pos=testTube>
																										<thead pos=testTube>
																											<tr>
																								
																												<th use=number></th>
																												<th use=bedNo>病床號</th>
																												<th use=chartNo>病歷號</th>
																												<th use=ptName>姓名</th>
																												<th use=sex>性別</th>
																												<th use=labNo>單號</th>
																												<th use=specimenPan>管別</th>
																												<th use=specimenSeq>檢體條碼號</th>											
																												<!-- <th use=mCode>管別代碼</th> -->
																												<th use=specimenName>檢體</th>
																												<th use=emgFlag>件別</th>
																												<th use=labOrderDate>開單日</th>
																												<!--<th use=expectCollectionDate>預計採檢日</th>-->
																												<!--<th use=orderDivName>科室</th>-->
																												<!--<th use=labCode>計價碼</th>-->
																												<th use=moreOption></th>
																												<!--<th box=checkbox><tick box=button pos=checkbox>取消</tick></th>-->
																										
																											</tr>
																										</thead>																		
																									</table>
																								
																									<roller box=testTube></roller>

																						 </home>";
																						 
		print_r(json_encode($response));
		
	}
	
	//備管掃描
	public static function testTubeScan()
	{
		
		$allData														 							= self::$pubVar["fetch"];
		$number                                           = $_POST["number"];
 		
		//print_r($allData);
		
		if($allData)
		{
			
			$response["status"]															= "success";
			
			for($i = 0; $i < count($allData); $i++)
			{
			
				$data																					= $allData[$i];
				//$specimenSeq																	= "未給號";
	
				switch($data["emgFlag"])
				{
							
					case "Y":
					
						$emgFlag 																	= "急件";
						
						break;
						
					case "N":
					
						$emgFlag																	= "非急件";		
					
						break;
						
					case "S":
					
						$emgFlag																	= "急件自付";		
					
						break;
							
							
				}
						
				if($data["sex"] == "M")
				{		
				
					$sex																				= "男";
				
				}else if($data["sex"] == "F"){
				
					$sex																				= "女";
				
				}else{
					
					$sex																				= "未設置";
					
				}
						
				$response["html"]														 .= "<table pos=testTube name=$data[labNo] number=$number>
																													<tr>
																								
																														<td use=number>$number</td>
																														<td use=bedNo>$data[bedNo]</td>
																														<td use=chartNo>$data[chartNo]</td>
																														<td use=ptName>$data[ptName]</td>
																														<td use=sex>$sex</td>
																														<td use=labNo>$data[labNo]</td>
																														<td use=specimenPan mCode=$data[mCode]>$data[tubeName]</td>																														
																														<td use=specimenSeq>未給號</td>
																														<!-- <td use=mCode>$data[mCode]</td> -->
																														<td use=specimenName>$data[specimenName]</td>
																														<td use=emgFlag>$emgFlag</td>
																														<td use=labOrderDate>$data[labOrderDate]</td>
																													  <!--<td use=expectCollectionDate>$data[expectCollectionDate]</td>-->
																													  <!--<td use=labCode>$data[labCode]</td>-->
																														<td use=moreOption pos=testTube>
																															
																															<moreOption box=button pos=detial function=testTube number=$number name=$data[labNo]>&#xf07b</moreOption>
																															<moreOption box=button pos=remove number=$number name=$data[labNo] option=testTube>&#xf1f8</moreOption>
																															
																														</td>
																														<!--<td box=checkbox><input type=checkbox box=checkbox name=$data[chartNo] number=$number checked></td>-->
																										
																													</tr>
																								 				</table>
																								 				<labInfo pos=title number=$number name=$data[labNo]><content>檢體別 - 檢體名稱</content></labInfo>
																								 				<labInfo number=$number name=$data[labNo]>";
																								 				
				for($j = 0; $j < count($data["labInfo"]); $j++)
				{
					
					$labInfo																		= $data["labInfo"][$j];
					$response["html"]													 .= "<content>$labInfo</content>";
					
				}
				
				$response["html"]														 .= "</labInfo>";
				$number 																			= $number + 1;

			}
				
		}else{
			
			$response["status"]															= "error";
			
		}
		
		print_r(json_encode($response));
		//print_r($data);
		
	}
	
	//備管紀錄
	public static function HisTestTube()
	{

		$allData																				= self::$pubVar["fetch"];		
		$date                                 					= date("Y-m-d");
		
		
		if($_POST["dicCode"] != "ER")
		{
			
			$tableName																		= "病床號";
			
		}else{
			
			$tableName																		= "備管時間";
			
		}
		
		//print_r($allData);
		
		$response["status"]															= "success";							

		$response["html"]																= "<home box=workarea>
																												<home box=title>
																																															
																													<text>備管紀錄</text>

																													<select>
																										
																														<option value=LabNo>檢驗單</option>
																														<option value=ChartNo>病歷號</option>
																										
																													</select>
									
																													<input box=search pos=HisTestTube action=Filter function=HisTestTube>
																													<input type=date name=start value=$date> 到 <input type=date name=end value=$date>
																										
																													<s-button box=button pos=search action=Filter function=HisTestTube>查詢</s-button>
																													
																													<reflash go=HisTestTube action=Filter function=HisTestTube title=重新整理>&#xf021</reflash>
																								
																													<error></error>

																												</home>
																								
																											<table pos=HisTestTube>
																												<thead pos=HisTestTube>
																													<tr>
																								
																														<th use=number></th>
																														<th use=bedNo>$tableName</th>
																														<th use=chartNo>病歷號</th>
																														<th use=ptName>姓名</th>
																														<th use=sex>性別</th>							
																														<th use=labNo>單號</th>
																														<th use=specimenPan>管別</th>
																														<th use=specimenSeq>檢體條碼號</th>				
																														<th use=specimenName>檢體</th>
																														<th use=emgFlag>件別</th>
																														<th use=expectCollectionDate>預計採檢日</th>
																														<!--<th use=orderDivName>科室</th>-->
																														<!--<th use=labCode>計價碼</th>-->
																														<th use=moreOption></th>

																													</tr>
																												</thead>																		
																											</table>
																								
																										<roller box=HisTestTube>";
																										
	if($allData)
	{
		
		if($_POST["dicCode"] != "ER")
		{
			usort($allData, function($a, $b){
				
				return strcmp($a["bedNo"], $b["bedNo"]);
				
			});	
			
		}else if($_POST["dicCode"] == "ER"){
			
			$currentDate 												= date('Ymd');  // 格式化成同樣的格式，如：20240918
			$currentTime 												= date('Hi');   // 格式化成同樣的格式，如：0657

			// 自定義排序按日期和時間
			usort($allData, function($a, $b) use ($currentDate, $currentTime) {
    
				// 1. 比較日期，越接近今天越前面
				$dateA 														= $a['appointDate']; // 格式化成字符串的數字日期
				$dateB 														= $b['appointDate'];
    
				// 計算日期差異
				$dateDiffA 												= abs((int)$dateA - (int)$currentDate);
				$dateDiffB 												= abs((int)$dateB - (int)$currentDate);

				if ($dateDiffA == $dateDiffB) {
				// 2. 如果日期相同，按時間排序，越接近現在越前面
				$timeA 														= $a['appointTime'];
				$timeB 														= $b['appointTime'];

				// 計算時間差異
				$timeDiffA 												= abs((int)$timeA - (int)$currentTime);
				$timeDiffB 												= abs((int)$timeB - (int)$currentTime);

				return $timeDiffA - $timeDiffB;  // 比較時間
			}

			return $dateDiffA - $dateDiffB;  // 比較日期
			});	

		}	
		
		for($i = 0; $i < count($allData); $i++)
		{

			$j																	= $i + 1;			
			$data																= $allData[$i];
			
			switch($data["emgFlag"])
			{
							
				case "Y":
					
					$emgFlag 												= "急件";
						
					break;
						
				case "N":
					
					$emgFlag												= "非急件";		
					
					break;
						
				case "S":
					
					$emgFlag												= "急件自付";		
					
					break;
												
			}
						
			if($data["sex"] == "M")
			{		
				
				$sex																				= "男";
				
			}else if($data["sex"] == "F"){
				
				$sex																				= "女";
				
			}else{
					
				$sex																				= "未設置";
					
			}
				
			$response["html"]									 .= "<table number=$j name=$data[labNo] seq=$data[specimenSeq]>
																							<tr>
																								
																								<td use=number>$j</th>";
																								
			if($_POST["dicCode"] != "ER")
			{
																								
				$response["html"]								 .=			"<td use=bedNo>$data[bedNo]</td>";
			
			}else{
				
				$response["html"]								 .=			"<td use=appointTime>$data[appointTime]</td>";
				
			}
			$response["html"]									 .=		 "<td use=chartNo>$data[chartNo]</td>
																								<td use=ptName>$data[ptName]</td>
																								<td use=sex>$sex</td>										
																								<td use=labNo>$data[labNo]</td>
																								<td use=specimenPan mCode=$data[mCode]>$data[tubeName]</td>
																								<td use=specimenSeq>$data[specimenSeq]</td>	
																								<td use=specimenName>$data[specimenName]</td>
																								<td use=emgFlag>$emgFlag</th>
																								<td use=expectCollectionDate>$data[expectCollectionDate]</th>
																								<!--<th use=orderDivName>科室</th>-->
																								<!--<th use=labCode>計價碼</th>-->
																								<td use=moreOption>
																									
																									<moreOption box=button pos=detial function=testTube name=$data[labNo] number=$j title=查看詳細>&#xf07b</moreOption>
																										<moreOption pos=showOption name=$data[specimenSeq] number=$j title=開啟功能表>&#xf142</moreOption>
																											
																											<more box=floating-dialog name=$data[specimenSeq] number=$j>
 
    																									<more box=dialog-content name=$data[specimenSeq] number=$j>
    																									
        																								<moreOption use=subMenu box=backup pos=barcode use=HisTestTube action=backup option=OneData name=$data[specimenSeq]>重印條碼</moreOption>
    																										<moreOption use=subMenu box=button pos=deleteBarcode  use=HisTestTube number=$j name=$data[labNo]>刪除條碼</moreOption>
        																								<button id=close-dialog number=$j name=$data[specimenSeq]>Close</button>
        																								
    																									</more>
    																									
																										</more>

																								</td>

																							</tr>
																						</table>
																						<labInfo number=$j name=$data[labNo] pos=title><content>檢體別 - 檢體名稱</content></labInfo>
																						<labInfo number=$j name=$data[labNo]>";
																						
			for($k = 0; $k < count($data["labInfo"]); $k++)
			{
				
				$labInfo													= $data["labInfo"][$k];
				$response["html"]								 .= "<content>$labInfo</content>";
				
			}
			
			$response["html"]									 .= "</labInfo>";
			
		}

	}																									
																										
		$response["html"]						 				 .= "</roller>
																							 </home>";
																						 
		print_r(json_encode($response));
		
	}

	//打包-畫面
	public static function Package()
	{
		
				
		$allData															 = self::$pubVar["fetch"];
		$grey																	 = 0;
		//$red																	 = 0;
		$yellow																 = 0;
		$purple																 = 0;
		$green																 = 0;
		$blue																	 = 0;
		$urine																 = 0;
		$other 																 = 0;
		
		if($allData)
		{
			
			for($i = 0; $i < count($allData); $i++)
			{
			
				$data															 = $allData[$i];
				$pan	 														 = $data["mCode"];
				switch($pan)
				{
					
					case "01":
					
						$grey													 = $grey + 1;
					
						break;
						
					case "02":
					
						/*$red													 = $red + 1;
					
						break;*/
						
					case "03":
					
						$yellow												 = $yellow + 1;
					
						break;
						
					case "04":
					
						$purple												 = $purple + 1;
					
						break;
						
					case "05":
					
						$green												 = $green + 1;
					
						break;
						
					case "06":
					
						$blue													 = $blue + 1;
					
						break;
						
					case "07":
					
						$urine												 = $urine + 1;
						
						break;
						
					default:
					
						$other												 = $other + 1;
					
						break;
					
				}
			}
		}

		if($_POST["pkgbar"] == "1")
		{
			
			$barcheck														= "checked";
			
		}
		
		if($_POST["pkglist"] == "1")
		{
			
			$listcheck													= "checked";
			
		}
		
		$response															= "<home box=workarea>
																							<home box=title>

																								<text>檢體打包</text>
						
																								<printcheck><input type=checkbox box=barcheck $barcheck>條碼貼紙</input></printcheck>
																								<printcheck><input type=checkbox box=listcheck $listcheck>清單</input></printcheck>
																								<printcheck box=button action=remark title=儲存後下次登入生效>儲存列印參數</printcheck>
																								
																								<input box=scan store=package action=ShortData function=packageScan option=insertPackage placeholder=檢體條碼號>
																								<home box=button pos=intoPackage store=package action=ShortData function=packageScan option=insertPackage>確認入袋</home>
																								<home box=button pos=newPackage action=newPackage option=insertPackage>完成打包</home>	

																								<error></error>
																								
																							</home>
																								
																																															
																							<panCount>
																							
																								<pan box=grey pos=panCount>灰蓋：<pan box=grey pos=number>$grey</pan></pan>
																								<!-- <pan box=red pos=panCount>紅蓋：<pan box=red pos=number>$red</pan></pan> -->
																								<pan box=yellow pos=panCount>黃蓋：<pan box=yellow pos=number>$yellow</pan></pan>
																								<pan box=purple pos=panCount>紫蓋：<pan box=purple pos=number>$purple</pan></pan>
																								<pan box=green pos=panCount>綠蓋：<pan box=green pos=number>$green</pan></pan>
																								<pan box=blue pos=panCount>藍蓋：<pan box=blue pos=number>$blue</pan></pan>
																								<pan box=urine pos=panCount>尿管：<pan box=urine pos=number>$urine</pan></pan>
																								<pan box=other pos=panCount>其他：<pan box=other pos=number>$other</pan></pan>
																							
																							</panCount>

																							<table pos=package>
																								<thead pos=package>
																									<tr>
																								
																										<th use=number noData=yes></th>
																										<th use=bedNo>病床號</th>
																										<th use=ptName>姓名</th>
																										<th use=sex>性別</th>
																										<th use=chartNo>病歷號</th>
																										<th use=specimenSeq>檢體條碼號</th>											
																										<th use=labNo>單號</th>
																										<th use=emgFlag>件別</th>
																										<!--<th use=orderDivName>科室</th>-->
																										<!--<th use=specimenCode>管別代碼</th>-->
																										<th use=specimenPan>管別</th>
																										<th use=specimenName>檢體</th>
																										<th use=detele></th>
																										
																									</tr>
																								</thead>																		
																							</table>
																								
																							<roller box=package>";
		if($allData)
		{
				
			for($i = 0; $i < count($allData); $i++)
			{
			
				$data															 = $allData[$i];
				$j																 = $i + 1;
				
				switch($data["UrgentFlag"])
				{
							
					case "Y":
					
						$emgFlag 											 = "急件";
						
						break;
						
					case "N":
					
						$emgFlag											 = "非急件";		
					
						break;
						
					case "S":
					
						$emgFlag											 = "急件自付";		
					
						break;
											
				}
						
				if($data["sex"] == "M")
				{		
				
					$sex																				= "男";
				
				}else if($data["sex"] == "F"){
				
					$sex																				= "女";
				
				}else{
					
					$sex																				= "未設置";
					
				}
				
				$response													.= "<table pos=package name=$data[Aplseq] number=$j>
																								<tr>
																								
																									<td use=number>$j</td>
																									<td use=bedNo>$data[bedNo]</td>
																									<td use=ptName>$data[PtName]</td>
																									<td use=sex>$sex</td>
																									<td use=chartNo>$data[ChartNo]</td>
																									<td use=specimenSeq>$data[specimenSeq]</td>
																									<td use=labNo>$data[Aplseq]</td>
																									<td use=emgFlag>$emgFlag</td>
																									<!-- <td use=specimenCode>$data[specimenCode]</td> -->
																									<td use=specimenPan mcode=$data[mcode]>$data[specimenPan]</td>
																									<td use=specimenName>$data[specimenName]</td>
																									<td use=detele number=$j><moreOption box=button pos=remove option=pan mCode=$data[mCode] name=$data[Aplseq] number=$j>&#xf1f8</moreOption></td>
																										
																								</tr>
																				 			</table>";
			
			}
			
		}
		$response															.= "</roller>
					
																						 </home>";
																						 
		print_r(json_encode($response));
			
	}
	
	//打包-動態加入資料
	public static function packageScan()
	{
		
		$data															 							= self::$pubVar["fetch"];
		
		if($data)
		{
			
			$response["status"]														= "success";

			switch($data["emgFlag"])
			{
							
				case "Y":
					
					$emgFlag 																	= "急件";
						
					break;
						
				case "N":
					
					$emgFlag																	= "非急件";		
					
					break;
						
				case "S":
					
					$emgFlag																	= "急件自付";		
					
					break;
							
							
			}
						
			if($data["sex"] == "M")
			{		
				
				$sex																				= "男";
				
			}else if($data["sex"] == "F"){
				
				$sex																				= "女";
				
			}else{
				
				$sex																				= "未設置";
					
			}
						
			$response["html"]															= "<table pos=package name=$data[labNo] number=$_POST[number]>
																												<tr>
																								
																													<td use=number>$_POST[number]</td>
																													<td use=bedNo>$data[bedNo]</td>
																													<td use=ptName>$data[ptName]</td>
																													<td use=sex>$sex</td>
																													<td use=chartNo>$data[chartNo]</td>
																													<td use=specimenSeq>$_POST[specimenSeq]</td>
																													<td use=labNo>$data[labNo]</td>
																													<td use=emgFlag>$emgFlag</td>
																													<!-- <td use=specimenCode>$data[specimenCode]</td> -->
																													<td use=specimenPan mcode=$data[mcode]>$data[tubeName]</td>
																													<td use=specimenName>$data[specimenName]</td>
																													<td use=detele number=$_POST[number]><moreOption box=button pos=remove option=pan mCode=$data[mCode] name=$data[labNo] number=$_POST[number]>&#xf1f8</moreOption></td>
																										
																												</tr>
																								 			</table>";
						

				
		}else{
			
			$response["status"]										= "error";
			
		}
		
		print_r(json_encode($response));
		//print_r($data);
		
	}
	
	//歷史打包
	public static function HistoryPackage()
	{
		
		$allData															= self::$pubVar["fetch"];
		$date                              		= date("Y-m-d");
		
		if($_POST["pkgbar"] == "1")
		{
			
			$barcheck														= "checked";
			
		}
		
		if($_POST["pkglist"] == "1")
		{
			
			$listcheck													= "checked";
			
		}

		$response["status"] 									= "success";	
		$response["html"]											= "<home box=workarea>
																							<home box=title>
																																															
																								<text>歷史打包</text>
																								<printcheck><input type=checkbox box=barcheck $barcheck>條碼貼紙</input></printcheck>
																								<printcheck><input type=checkbox box=listcheck $listcheck>清單</input></printcheck>
																								<printcheck box=button action=remark title=儲存後下次登入生效>儲存列印參數</printcheck>

																								<select box=select pos=search>
																								 
																									<option value=listNo>小包編號</option>
																									<option value=orderNo>檢驗單號</option>
																									<option value=specimenSeq>條碼號</option>
																								
																								</select>	

																								<input box=search pos=HisPackage action=LongData function=HistoryPackage>
																								<input type=date name=start value=$date> 到 <input type=date name=end value=$date>

																								<s-button box=button pos=search action=LongData function=HistoryPackage>查詢</s-button>
																								<reflash go=HistoryPackage action=ShortData function=HistoryPackage title=重新整理>&#xf021</reflash>
																								
																								<error></error>
																								
																							</home>
																								
																								<table pos=HistoryPackage>
																									<thead pos=HistoryPackage>
																										<tr>
																								
																											<th use=listNo>小包編號</th>
																											<th use=locID>護理站代碼</th>
																											<th use=orderCount>總單數</th>
																											<th use=tubeCount>總管數</th>
																											<th use=sendDateTime>打包日期與時間</th>											
																											<th use=sendMan>打包人</th>
																											<th use=transDateTime>送出日期與時間</th>
																											<th use=transMan>送出人</th>
																											<th use=rcvDateTime>送達日期與時間</th>
																											<th use=rcvMan>送達人</th>
																											<th use=moreOption></th>
																										
																										</tr>
																									</thead>																		
																								</table>
																								
																								<roller box=HistoryPackage>";
		if($allData)
		{								
			
			usort($allData, function($a, $b){
				
				return strcmp($a["listNo"], $b["listNo"]);
				
			});	
															 
			for($i = 0; $i < count($allData); $i++)
			{
			
				$data																= $allData[$i];
			
				$response["html"]									 .= "<table pos=HistoryPackage>
																								<tr pos=HistoryPackage name=$data[listNo] unicode=$data[listUnicode]>
																								
																									<td use=listNo>$data[listNo]</td>
																									<td use=locID>$data[locID]</td>
																									<td use=orderCount>$data[orderCount]</td>
																									<td use=tubeCount>$data[tubeCount]</td>
																									<td use=sendDateTime>$data[sendDate] $data[sendTime]</td>
																									<td use=sendMan>$data[sendMan]</td>
																									<td use=transDateTime>$data[transDate] $data[transTime]</td>
																									<td use=transMan>$data[transMan]</td>
																									<td use=rcvDateTime>$data[rcvDate] $data[rcvTime]</td>
																									<td use=rcvMan>$data[rcvMan]</td>
																									<td use=moreOption>
																								
																										<moreOption box=button pos=detial function=ListB name=$data[listNo] title=查看更多>&#xf07b</moreOption>
																										<moreOption pos=showOption name=$data[listNo] title=開啟功能表>&#xf142</moreOption>
																											
																											<more box=floating-dialog name=$data[listNo]>
 
    																									<more box=dialog-content name=$data[listNo]>
    																									
        																								<moreOption use=subMenu pos=delete action=delPackage function=delPackage name=$data[listNo] unicode=$data[listUnicode] title=刪除此小包>刪除小包</moreOption>
    																										<moreOption use=subMenu pos=update action=Plant function=updatePackage name=$data[listNo] unicode=$data[listUnicode] title=新增管子到此小包>新增管子</moreOption>
    																										<moreOption use=subMenu pos=printlist action=Filter function=PrintBarcode option=updatePackage name=$data[listNo] unicode=$data[listUnicode] title=重新列印小包清單>列印清單</moreOption>
        																								<button id=close-dialog name=$data[listNo]>Close</button>
        																								
    																									</more>
    																									
																										</more>

																									</td>
																								</tr>
																							</table>
																							<table>
																							
																							<table pos=HisTube>
																								<tr pos=HisTube name=$data[listNo]>
																									
																									<th use=bedNo>病床號</th>
																									<th use=subID>病歷號</th>
																									<th use=subInitials>姓名</th>
																									<th use=specimenSeq>檢體條碼號</th>
																									<th use=orderNo>單號</th>
																									<th use=specimenPan>管別</th>
																									<th use=specimenName>檢體</th>
																									<th use=collectDate>採檢日期</th>
																									<th use=collectTime>採檢時間</th>
																									<th use=collectMan>採檢人</th>
																									<th></th>
																									
																								</tr>
																							</table>";
			
				if($data["listB"])
				{
																							
					for($j = 0; $j < count($data["listB"]); $j++)
					{
				
						$listB													= $data["listB"][$j];
				
						$response["html"]							 .= "<table pos=HisTube box=HisTestTube seq=$listB[specimenSeq]>
																								<tr pos=HisTube name=$listB[ordUnicode] clear=$listB[specimenSeq] unicode=$listB[listUnicode]>
																								
																									<td use=bedNo>$listB[bedNo]</td>
																									<td use=chartNo>$listB[subID]</td>
																									<td use=subInitials>$listB[subInitials]</td>
																									<td use=specimenSeq>$listB[specimenSeq]</td>
																									<td use=labNo>$listB[orderNo]</td>
																									<td use=specimenPan mCode=$listB[mCode]>$listB[dicName]</td>
																									<td use=specimenName>$listB[specimenName]</td>
																									<td use=collectDate>$listB[collectDate]</td>
																									<td use=collectTime>$listB[collectTime]</td>
																									<td use=collectMan>$listB[collectMan]</td>
																									<td>
																							
																										<moreOption box=backup pos=barcode action=backup name=$listB[specimenSeq] title=重印條碼>&#xf02a</moreOption>
																										<moreOption box=button pos=delete action=delTube function=delTube name=$listB[specimenSeq] unicode=$listB[listUnicode] ordUnicode=$listB[ordUnicode] title=刪除此管>&#xf1f8</moreOption>
																								
																									</td>
																								
																								</tr>
																								
																							</table>";

					}

				}
			}
		}
		
		$response["html"]											.= "</roller>
																							
																							</home>";
																						 
		print_r(json_encode($response));
			
	}
	
	//更新打包
	public static function updatePackage()
	{
		
		$listUnicode 													= $_POST["listUnicode"];
		$listNo																= $_POST["listNo"];
		
		$response															= "<message box=update>
															
																							<message box=top>
																							
																								
																								<update>小包編號：$listNo</update>
																								<home box=button pos=close-update>關閉</home>
																								<input box=scan action=ShortData store=package function=packageScan option=updatePackage placeholder=檢體條碼號>
																								<home box=button pos=intoPackage store=package action=ShortData function=packageScan option=updatePackage>確認入袋</home>
																								<home box=button pos=updatePackage action=updatePackage unicode=$listUnicode listNo=$listNo option=updatePackage>確認打包</home>
																								
																								<error></error>
																								
																							</message>
																							<panCount>
																							
																								<pan box=grey pos=panCount>灰蓋：<pan box=grey pos=number>0</pan></pan>
																								<!-- <pan box=red pos=panCount>紅蓋：<pan box=red pos=number>0</pan></pan> -->
																								<pan box=yellow pos=panCount>黃蓋：<pan box=yellow pos=number>0</pan></pan>
																								<pan box=purple pos=panCount>紫蓋：<pan box=purple pos=number>0</pan></pan>
																								<pan box=green pos=panCount>綠蓋：<pan box=green pos=number>0</pan></pan>
																								<pan box=blue pos=panCount>藍蓋：<pan box=blue pos=number>0</pan></pan>
																								<pan box=urine pos=panCount>尿管：<pan box=urine pos=number>0</pan></pan>
																								<pan box=other pos=panCount>其他：<pan box=other pos=number>0</pan></pan>
																							
																							</panCount>
																							
																							<table pos=package style='background-color: white;'>
																								<thead pos=package>
																									<tr>
																								
																										<th use=number></th>
																										<th use=bedNo>病床號</th>
																										<th use=ptName>姓名</th>
																										<th use=sex>性別</th>
																										<th use=chartNo>病歷號</th>
																										<th use=specimenSeq>檢驗號</th>											
																										<th use=labNo>單號</th>
																										<th use=emgFlag>件別</th>
																										<!-- <th use=specimenCode>管別代碼</th> -->
																										<th use=specimenPan>管別</th>
																										<th use=specimenName>檢體</th>
																										<th use=detele></th>
																										
																									</tr>
																								</thead>																		
																							</table>
																								
																							<roller box=package style='background-color: white;'></roller>
																						 </message>";
																						 
		print_r(json_encode($response));
		
	}

	//barcode畫面
	/*public static function PrintBarcode()
	{
		
		$username															= $_POST["username"];
		$dicCode															= $_POST["dicCode"];
		$dicName															= $_POST["dicName"];
		$listNo																= $_POST["listNo"];
		$date                                 = date("Y-m-d H:i:s");
		
		$part1 																= substr($listNo, 0, 6);
		$part2 																= substr($listNo, 6, 3);
		$part3 																= substr($listNo, 9, 2);

		// Combine parts with dashes
		$formatted 														= sprintf('%s-%s-%s', $part1, $part2, $part3);
		
		$response															= "<message box=detial>
		
																							 <message box=print_box>
																							 
																							 	<message box=MainTitle >行天宮醫療志業醫療財團法人恩主公醫院 - 檢體清單</message>
																							 
																							 	<message box=subTitle>
																							 	
																							 		<content>
																							 		
																							 			<message box=headline>打包清單</message>
																							 			<message box=caption>小包編號: $formatted</message>
																							 			<message box=caption>護理站代碼：$dicCode 日期時間：$date 打包人：$username</message>
																							 		
																							 		</content>
																							 		<message box=barcode></message>	  

																							 	</message>
																							 	
																									<table pos=title>
																										<tr>
																								
																											<th use=bedNo>病床號</th>
																											<th use=ptName>姓名</th>
																											<th use=sex>性別</th>
																											<th use=chartNo>病歷號</th>
																											<th use=specimenSeq>檢體條碼號</th>											
																											<th use=labNo>檢體單</th>
																											<th use=emgFlag>件別</th>
																											<!-- <th use=specimenCode>管別代碼</th> -->
																											<th use=specimenPan>管別</th>
																											<th use=specimenName>檢體</th>
																											<th use=barcode></th>

																										</tr>		
																							 		</table>

																							 		<message box=packagedetial></message>
																							 	
																							 </message>
																							 
																							 <message box=button>
																							 																						
																							 	<message box=button pos=print>列印</message>
																							 	<message box=button pos=close-print>關閉</message>
																							 	
																							 </message>
																							 
																						 </message>";
																						 
		print_r(json_encode($response));
		
	}*/
	
		
	//列印清單
	public static function PrintBarcode()
	{
		
		$allData 															= self::$pubVar["fetch"];
		//print_r(self::$pubVar["fetch"]);
		$listNo																= $_POST["listNo"];
		$date                                 = date("Y-m-d H:i:s");
		
		if($_POST["option"] == "updatePackage")
		{
			
			$subTitle														= "檢體打包清單-再印";
			
		}else{
			
			$subTitle														= "檢體打包清單";
			
		}
		
		/*$part1 																= substr($listNo, 0, 6);
		$part2 																= substr($listNo, 6, 3);
		$part3 																= substr($listNo, 9, 2);*/
		
		$grey																  = 0;
		//$red																	= 0;
		$yellow															 	= 0;
		$purple															 	= 0;
		$green															 	= 0;
		$blue																 	= 0;
		$urine															 	= 0;
		$other 															 	= 0;
		
		for($i = 0; $i < count($allData); $i++)
		{
			
			$data															 = $allData[$i];
			
			$pan	 														 = $data["mCode"];
			switch($pan)
			{
					
				case "01":
					
					$grey													 = $grey + 1;
					
					break;
						
				case "02":
					
					/*$red													 = $red + 1;
					
					break;*/
						
				case "03":
					
					$yellow												 = $yellow + 1;
					
					break;
						
				case "04":
					
					$purple												 = $purple + 1;
					
					break;
						
				case "05":
					
					$green												 = $green + 1;
					
					break;
						
				case "06":
					
					$blue													 = $blue + 1;
					
					break;
						
				case "07":
					
					$urine												 = $urine + 1;
						
					break;
						
				default:
					
					$other												 = $other + 1;
					
					break;
			}
		}

		// Combine parts with dashes
		//$formatted 														= sprintf('%s-%s-%s', $part1, $part2, $part3);

		$response["html"]											= "<message box=detial>
		
																							 <message box=print_box>
																							 	
																							 	<message box=MainTitle>恩主公醫院$_POST[dicCode]護理站 - $subTitle</message>
																							 	<message box=MainTitle pos=sub>小包編號: $listNo</message>
																							 
																							 	<message box=subTitle>
																							 	
																							 		<listContent>
																							 		
																							 			<message box=caption>
																							 			
																							 				<listCaption>日期時間：$date</listCaption>
																							 				<listCaption>打包人：$_POST[username]</listCaption>
																							 				
																							 			</message>
																							 			
																							 			<pan box=grey pos=panCount>灰蓋：<pan box=grey pos=number>$grey</pan></pan>
																										<!-- <pan box=red pos=panCount>紅蓋：<pan box=red pos=number>$red</pan></pan> -->
																										<pan box=yellow pos=panCount>黃蓋：<pan box=yellow pos=number>$yellow</pan></pan>
																										<pan box=purple pos=panCount>紫蓋：<pan box=purple pos=number>$purple</pan></pan>
																										<pan box=green pos=panCount>綠蓋：<pan box=green pos=number>$green</pan></pan>
																										<pan box=blue pos=panCount>藍蓋：<pan box=blue pos=number>$blue</pan></pan>
																										<pan box=urine pos=panCount>尿管：<pan box=urine pos=number>$urine</pan></pan>
																										<pan box=other pos=panCount>其他：<pan box=other pos=number>$other</pan></pan>
																							 		
																							 		</listContent>
																							 		<message box=barcode></message>	
																							 	
																							 	</message>
																							 		<message box=packagedetial>
																									<table>
																										<tr>
																								
																											<th use=bedNo>病床號</th>
																											<th use=chartNo>病歷號</th>
																											<th use=ptName>姓名</th>
																											<th use=sex>性別</th>
																											<th use=labNo>單號</th>
																											<th use=specimenPan>管別</th>
																											<th use=specimenSeq>檢體條碼號</th>											
																											<th use=specimenName>檢體</th>
																											<th use=emgFlag>件別</th>
																											<!-- <th use=specimenCode>管別代碼</th> -->
																											<th use=barcode></th>

																										</tr>";
																							 		
		for($i = 0; $i < count($allData); $i++)
		{
			
			$data																= $allData[$i];
			$response["specimenSeq"][$i]			  = $data["specimenSeq"];
			
			switch($data["emgFlag"])
			{
							
				case "Y":
					
					$emgFlag 												= "急件";
						
					break;
						
				case "N":
					
					$emgFlag												= "非急件";		
					
					break;
						
				case "S":
					
					$emgFlag												= "急件自付";		
					
					break;
							
							
			}
						
			if($data["sex"] == "M")
			{		
				
				$sex																				= "男";
				
			}else if($data["sex"] == "F"){
				
				$sex																				= "女";
				
			}else{
					
				$sex																				= "未設置";
					
			}
			
			$response["html"]									 .= "<tr name=$data[labNo]>
																								<td use=bedNo>$data[bedNo]</th>
																								<td use=chartNo>$data[chartNo]</th>
																								<td use=ptName>$data[ptName]</th>
																								<td use=sex>$sex</th>
																								<td use=labNo>$data[labNo]</th>
																								<td use=specimenPan>$data[tubeName]</th>
																								<td use=specimenSeq>$data[specimenSeq]</th>											
																								<td use=specimenName>$data[specimenName]</td>
																								<td use=emgFlag>$emgFlag</th>
																								<!-- <th use=specimenCode>$data[specimenCode]</th> -->																																																
																								<td use=barcode number=$i></td>
																							</tr>";
			
		}
	
		$response["html"]										 .= "	</table>
																							</message> 	
																							 </message>
																							 
																							 <message box=button>
																							 																						
																							 	<message box=button pos=print>列印</message>
																							 	<message box=button pos=close-print>關閉</message>
																							 	
																							 </message>
																							 
																						 </message>";
		
		print_r(json_encode($response));

	}
	
	
	//簽出簽入-畫面
	public static function sign()
	{
		
		$option																		= $_POST["option"];
		$AllData																	= self::$pubVar["fetch"];
		$date                                     = date("Y-m-d");
		
		switch($option)
		{
			
			case "signOut":
			
				$title																= "檢體送出";
				$input																= "signOut";
				$button																= "確認送出";

				break;
				
			case "signIn":
			
				$title																= "檢體送達";
				$input																= "signIn";
				$button																= "確認送達";

				break;
			
		}
		
		$response																	= "<home box=workarea>
																									<home box=title>
																							
																										<text>$title</text>
																										
																										<!-- <label class=switch>
																										
																											<input type=checkbox checked>
																											<span class=slider>
																										
																										</label>
																										<labeltext>自動簽收</labeltext> -->
																										
																										<label pos=sign>工號：</label>
																										<input box=userid placeholder=在此掃描或輸入工號>
																										<label pos=sign>小包條碼：</label>
																										<input box=scan action=shortData function=signScan option=$input placeholder=在此掃描或輸入小包條碼>
																										<home box=button pos=intoSign action=shortData function=signScan option=$input>輸入小包</home>
																										<home box=button pos=signPassword action=Plant function=signPassword option=$input>$button</home>
																										<error></error>
																								
																									</home>
																									
																									<table pos=sign>
																										<thead pos=sign>
																											<tr>
																								
																												<th use=listNo>小包編號</th>
																												<th use=locID>護理站</th>
																												<th use=orderCount>總單數</th>
																												<th use=tubeCount>總管數</th>
																												<th use=sendDate>打包日期</th>
																												<th use=sendTime>打包時間</th>
																												<th use=sendMan>打包人</th>";
		if($option == "signIn")
		{
			
			$response																.= "<th use=transDate>送出日期</th>
																									<th use=transTime>送出時間</th>
																									<th use=transMan>送出人</th>";
			
		}
																																																							
		$response																	.= "<th use=detele></th>
																										
																											</tr>
																										</thead>																		
																									</table>
																							
																									<roller box=sign></roller>
																									
																									<input type=date name=start value=$date> 到 <input type=date name=end value=$date>
																									<s-button box=button pos=search action=ShortData function=sign option=$input>查詢</s-button>
																									<reflash go=sign action=ShortData function=sign option=$input title=重新整理>&#xf021</reflash>
																									
																									<table pos=HisSign>
																										<thead pos=HisSign>
																											<tr>
																								
																												<th use=listNo>小包編號</th>
																												<th use=locID>護理站</th>
																												<th use=orderCount>總單數</th>
																												<th use=tubeCount>總管數</th>
																												<th use=sendDate>打包日期</th>
																												<th use=sendTime>打包時間</th>
																												<th use=sendMan>打包人</th>
																												<th use=transDate>送出日期</th>
																												<th use=transTime>送出時間</th>
																												<th use=transMan>送出人</th>
																												<th use=rcvDate>送達日期</th>
																												<th use=rcvTime>送達時間</th>
																												<th use=rcvMan>送達人</th>
																												<th use=detele></th>
																										
																											</tr>
																										</thead>																		
																									</table>
																							
																									<roller box=HisSign>";

		if($AllData)
		{
		
			for($i = 0; $i < count($AllData); $i++)
			{
			
				$data																	= $AllData[$i];
				$j                                    = $i + 1;
			
				$response														 .= "<table pos=HisSign>
																									<tr pos=HisSign name=$data[listNo]>
																								
																										<td use=listNo>$data[listNo]</td>
																										<td use=locID>$data[locID]</td>
																										<td use=orderCount>$data[orderCount]</td>
																										<td use=tubeCount>$data[tubeCount]</td>
																										<td use=sendDate>$data[sendDate]</td>
																										<td use=sendTime>$data[sendTime]</td>
																										<td use=sendMan>$data[sendMan]</td>
																										<td use=transDate>$data[transDate]</td>
																										<td use=transTime>$data[transTime]</td>
																										<td use=transMan>$data[transMan]</td>
																										<td use=rcvDate>$data[rcvDate]</td>
																										<td use=rcvTime>$data[rcvTime]</td>
																										<td use=rcvMan>$data[rcvMan]</td>
																										<td use=detele>
																										
																											<moreOption use=HisSign box=button pos=reSign option=$input name=$data[listNo] title=退簽此包>&#xf1f8</moreOption>
																										
																										</td>
																										
																									</tr>																	
																								</table>";
			
			}
		
		
		}
	
		$response																	.= "</roller></home>";
																									
														 
		print_r(json_encode($response));
			
	}
	
	//簽出簽入-動態加入資料
	public static function signScan()
	{
		
			$data																	= self::$pubVar["fetch"];

			if($data)
			{
				
				$response["html"]										= "<table pos=sign name=$data[listNo]>
			
																								<tr>
																								
																									<td use=listNo>$data[listNo]</td>
																									<td use=locID>$data[locID]</td>
																									<td use=orderCount>$data[orderCount]</td>
																									<td use=tubeCount>$data[tubeCount]</td>
																									<td use=sendDate>$data[sendDate]</td>
																									<td use=sendTime>$data[sendTime]</td>
																									<td use=sendMan>$data[sendMan]</td>";
			if($_POST["option"] == "signIn")
			{
				
				$response["html"]									.= "<td use=transDate>$data[transDate]</td>
																									<td use=transTime>$data[transTime]</td>
																									<td use=transMan>$data[transMan]</td>";
				
			}
			
			$response["html"]										.= "<td use=detele>
																									
																										<moreOption use=sign box=button pos=remove name=$data[listNo] title=退簽此包>&#xf1f8</moreOption>
																									
																									</td>
																									
																								</tr>
																								
																							</table>";
				
				$response["status"]									= "success";
				
			}else{
				
				$response["status"]									= "error";
				
			}

		print_r(json_encode($response));
		
	}
	
	//送出送達的確認
	public static function signPassword()
	{
		
		if($_POST["option"] == "signOut")
		{
			
			$buttonName													  = "確認送出";
			
		}else{
			
			$buttonName													  = "確認送達";
			
		}
		
		$response																= "<message box=detial>
		
																								 <change box=close>&#xf00d</change>
																								 <form box=change>
																							 
																								 	 <text box=change-text>帳號名稱</text>
																								 	 <input name=username pos=sign readonly value=$_POST[userid]>
																								 	 <text box=change-text>請輸入密碼</text>
																								 	 <input type=password name=password pos=sign>
											 
																								 </form>
																								 <message box=change-error></message>
																								 <home box=button pos=sign option=$_POST[option]>$buttonName</home>
																							 
																						 	</message>";
		print_r(json_encode($response));
		
		
	}
		
	//修改密碼-畫面
	public static function change()
	{
		
		$response															= "<message box=detial>
		
																							 <change box=close>&#xf00d</change>
																							 <form box=change>
																							 
																							 	 <text box=change-text>帳號名稱</text>
																							 	 <input name=username pos=change readonly value=$_SESSION[userid]>
																							 	 <text box=change-text>請輸入舊密碼</text>
																							 	 <input name=old-password pos=change>
																							 	 <text box=change-text>請輸入新密碼</text>
																							 	 <input name=new-password pos=change>																				 	 
																							 
																							 </form>
																							 <message box=change-error></message>
																							 <message pos=change>確認修改</message>
																							 
																						 </message>";
		print_r(json_encode($response));
		
	}
	
	//設定畫面
	public static function setting()
	{
		
		$allData																		= self::$pubVar["fetch"];
		
		if($_POST["machine"] == "TMC")
		{
			
			$selectTMC																= "selected";
			
			
		}else if($_POST["machine"] == "QQ"){
			
			$selectQQ																	= "selected";
			
		}
		
		if($_POST["mCode"] == "ER")
		{
			
			$ERinput																	= "style='display: inline;'";
			
		}
		
		//$response["status"]													= "success";
		$response/*["html"]*/													= "<home box=workarea>
		
																										<block box=setIP>
																							
																											<text>新增護理站</text>
																											
																											<setIP>
																											
																												<input box=mCode pos=add placeholder=請輸入IP>
																												<input box=dicCode pos=add placeholder=請輸入護理站代碼>
																												<input box=dicName pos=add placeholder=請輸入護理站名稱>
																												<input box=machineIP pos=add placeholder=請輸入儀器IP>
																												<input box=otherIP pos=add placeholder=請輸入備用儀器IP>
																												<select box=mechine pos=add>
						
																														<option selected disabled hidden>請選擇列印儀器</option>
																														<option value=TMC>TMC備管機</option>
																														<option value=QQ>條碼列印機</option>

																												</select>
																												<set box=button pos=add>存檔</set>
																												
																											</setIP>
																											<error pos=add></error>
																										</block>
																											
																										<block box=setIP>
																							
																											<text>護理站設置</text>
																											
																											<setIP>
																											
																												<input box=mCode pos=update placeholder=請輸入IP value=$_POST[ip]>
																												<input box=dicCode pos=update placeholder=請輸入護理站代碼 value=$_POST[dicCode]>
																												<input box=dicName pos=update placeholder=請輸入護理站名稱 value='$_POST[dicName]'>
																												<input box=machineIP pos=update placeholder=請輸入儀器IP value=$_POST[machineIP]>
																												<input box=otherIP pos=update $ERinput placeholder=請輸入備用儀器IP value=$_POST[otherIP]>
																												<select box=mechine pos=update>
						
																													<option selected disabled hidden>請選擇列印儀器</option>
																													<option value=TMC $selectTMC>TMC備管機</option>
																													<option value=QQ $selectQQ>條碼列印機</option>

																												</select>
																												<set box=button pos=update>存檔</set>
		
																											</setIP>
																											<error pos=update></error>
																										</block>
		
																									</home>";
																																														
		print_r(json_encode($response));
		
	}

	//TAT看板		
	public static function TAT()
	{
		
		$_SESSION["collectData"]											= $_POST["collectData"];
		$_SESSION["notCollectData"]											= $_POST["notCollectData"];
		$_SESSION["oneTubeData"]											= $_POST["oneTubeData"];
		
		if(!$_POST["date"])
		{
			
			$date															= date("Y-m-d");
		
		}else{
			
			$date															= $_POST["date"];
			
		}
		$response 															= "<home box=workarea pos=TAT>
																								
																								<home box=title>
																								
																									<text>TAT看板</text>
																									<input type=date name=date value=$date>
																									<s-button box=button pos=TATsearch action=ShortData function=TAT>查詢</s-button>
																									<reflash go=TAT action=ShortData function=TAT title=重新整理>&#xf021</reflash>
																									
																								</home>
																												
																								<statistics box=pie>
																									
																									<pie>
																									
																										<div class=pie animate=animate style='--p: $_POST[BackupPercentage]; --c: pink;'> $_POST[BackupPercentage]%</div>
																										<tatp box=title>備管率</tatp>
																										<tatp>$_POST[BackupWord]</tatp>
																										<tatp>已備管 / 總單數</tatp>
																									
																									</pie>
																									<pie>
																									
																										<div class=pie animate=animate style='--p: $_POST[collectPercent]; --c: #F4AB2F;'> $_POST[collectPercent]%</div>
																										<tatp box=title>採檢率</tatp>
																										<tatp>$_POST[collectWord]</tatp>
																										<tatp>已採檢 / 全部</tatp>
																										<showtatcellect class=collect>查看明細</showtatcellect>
																										
																									
																									</pie>
																									<pie>
																									
																										<div class=pie animate=animate style='--p: $_POST[PackagePercentage]; --c: #8EF560;'> $_POST[PackagePercentage]%</div>
																										<tatp box=title>打包率</tatp>
																										<tatp>$_POST[packagedWord]</tatp>
																										<tatp>已打包 / 已備管</tatp>
																									
																									</pie>
																									<pie>
																									
																										<div class=pie animate=animate style='--p: $_POST[signOutPercentage]; --c: #4ECDF2;'> $_POST[signOutPercentage]%</div>
																										<tatp box=title>送出率</tatp>
																										<tatp>$_POST[signOutWord]</tatp>
																										<tatp>已送出 / 已打包</tatp>
																									
																									</pie>
																									<pie>
																									
																										<div class=pie animate=animate style='--p: $_POST[signInPercentage]; --c: #4E87F2;'> $_POST[signInPercentage]%</div>
																										<tatp box=title>送達率</tatp>
																										<tatp>$_POST[signInWord]</tatp>
																										<tatp>已送達 / 已送出</tatp>
																									
																									</pie>
																									<pie>
																									
																										<div class=pie animate=animate style='--p: $_POST[oneTubePercent]; --c: #B59EF2;'> $_POST[oneTubePercent]%</div>
																										<tatp box=title>一碼化使用率</tatp>
																										<tatp>$_POST[oneTubeWord]</tatp>
																										<tatp>一碼化 / 全部</tatp>
																										<showtatcellect class=oneTube>查看明細</showtatcellect>
																									
																									</pie>
																									
																								</statistics>
																								<test style='display: grid; grid-template-columns: repeat(2, 1fr); grip-gap: 10px; text-align: center;'>
																								
																									<canvas use=package width=350px height=200px></canvas>
																									<canvas use=Trans width=350px height=200px></canvas>
																								
																								</test></home>";
																				
    print_r(json_encode($response));
			
	}
	
	public static function openTATDetial()
	{
		
		//採檢率
		if($_POST["class"] == "collect")
		{
	
			if(!is_array($_SESSION["collectData"]))
			{
				$_SESSION["collectData"] 												= json_decode($_SESSION["collectData"], true);
				
			}
			
			if(!is_array($_SESSION["notCollectData"]))
			{
				
				$_SESSION["notCollectData"] 											= json_decode($_SESSION["notCollectData"], true);
			
			}
	
			$response 																	= "<message box=detial>
		
																							<change box=close>&#xf00d</change>
																							<tatDetial>
																						
																								<collect pos=content>
																							
																									<text>已採檢</text>
																									<collectDetial pos=collect>
																									<collect pos=title>單號</collect>
																									<collect pos=title>條碼號</collect>";
																								
			for($i = 0; $i < count($_SESSION["collectData"]); $i++)
			{
			
				$collect																= $_SESSION["collectData"][$i];
				$response															   .= "<collect pos=text>$collect[aplSeq]</collect>
																							<collect pos=text>$collect[sid]</collect>";
			
			}
																							
			$response																   .= "</collectDetial></collect>
		
																								<collect pos=content>
																								<text>未採檢</text>
																								<collectDetial pos=collect>
																							
																								<collect pos=title>單號</collect>
																								<collect pos=title>條碼號</collect>";
																								
			for($i = 0; $i < count($_SESSION["notCollectData"]); $i++)
			{
			
				$collect																= $_SESSION["notCollectData"][$i];
				$response															   .= "<collect pos=text>$collect[aplSeq]</collect>
																					   <collect pos=text>$collect[sid]</collect>";
			
			}
																				
			$response																   .= "</collectDetial>
																							</collect>
																							</tatDetial>
																							</message>";	 
		
		//一碼化使用率
		}else if($_POST["class"] == "oneTube"){
			
			//print_r($_SESSION["oneTubeData"]);
			
			if(!is_array($_SESSION["oneTubeData"]))
			{
				
				$_SESSION["oneTubeData"] 													= json_decode($_SESSION["oneTubeData"], true);
			
			}
			
			$notOneTube																	= array_values(array_diff($_SESSION["oneTubeData"]["oracleData"]["labNos"], $_SESSION["oneTubeData"]["sqlServerData"]["aplSeqs"]));
			$OneTube																	= $_SESSION["oneTubeData"]["sqlServerData"]["aplSeqs"];
			
			$response 																	= "<message box=detial>
		
																							<change box=close>&#xf00d</change>
																							<tatDetial>
																						
																								<collect pos=content>
																							
																									<text>使用一碼化</text>
																									<collectDetial pos=oneTube>
																									<collect pos=title>單號</collect>";
																								
			for($i = 0; $i < count($OneTube); $i++)
			{
			
				
				$response															   .= "<collect pos=text>$OneTube[$i]</collect>";
			
			}
																							
			$response																   .= "</collectDetial></collect>
		
																								<collect pos=content>
																								<text>未使用一碼化</text>
																								<collectDetial pos=oneTube>
																							
																								<collect pos=title>單號</collect>";
																								
			for($i = 0; $i < count($notOneTube); $i++)
			{

				$response															   .= "<collect pos=text>$notOneTube[$i]</collect>";
			
			}
																				
			$response																   .= "</collectDetial>
																							</collect>
																							</tatDetial>
																							</message>";	 
			
		}
		
		print_r(json_encode($response));
	}
	
	//混和式備管
	public static function mix()
	{
		
		$allData																	= self::$pubVar["fetch"];
		$count                                    = 0;
		
		if($allData)
		{
			
			/*if($_POST["nsCode"] == "ER")
			{
				usort($allData, function($a, $b){
				
					return strcmp($a["chartNo"], $b["chartNo"]);
				
				});
				
			}else{*/
			
				usort($allData, function($a, $b){
				
					return strcmp($a["bedNo"], $b["bedNo"]);
				
				});
			
			//}
			
			for($i = 0; $i < count($allData); $i++)
			{
				
				$count = $count + 1;
				
			}
			
		}
		
		$date                              				= date("Y-m-d");

		if($_POST["machine"] == "TMC")
		{
			
			$checkbox																= "<input box=IsLabelOnly type=checkbox>只印條碼</input>";
			
		}else{
			 	
			$checkbox																= "<input type=number name=quantity min=1 max=5 stpe=1 value=1>列印張數</input>";
			 	
		}
		
		$response["status"]												= "success";
		$response["html"] 												= "<errorTube box=bar></errorTube>
																								 <errorTube box=icon>&#xf06a</errorTube>
																								 <errorTube box=content></errorTube>
		
																								 <home box=workarea>
		
																								 <home box=title>
																																															
																										<text>病患備管</text>
																										<printcheck>$checkbox</printcheck>

																										<select box=select pos=ipd>
																										
																											<option value=chartNo>病歷號</option>
																								 			<option value=labNo>檢驗單</option>
																											<option value=ptName>姓名</option>
																											<option value=bedNo>病房號</option>
																											<option value=idNo>身分證</option>
																								
																										</select>
																										<input box=search pos=mix action=Filter function=sreachPatient>
																										<!-- <select box=select pos=status>

																											<option value=false>未給號</option>																								 
																											<option value=true>已給號</option>
																											<option value=>全部</option>
																								
																										</select> -->
																										<input type=date name=start value=$date> 到 <input type=date name=end value=$date>
																										<select box=select pos=shift>
																								 
																								 			<option value=>全部</option>
																											<option value=日班>日班</option>
																											<option value=晚班>晚班</option>
																											<option value=夜班>夜班</option>

																										</select>
																										
																										<!--<select box=select pos=nsCode>
																										
																											<option value=$_POST[nsCode]>本站</option>
																											<option value=>全部</option>
																										
																										</select>-->
																										
																										<s-button box=button pos=search action=Filter function=sreachPatient>查詢</s-button>
																										<reflash go=mix action=shortData function=sreachPatient title=重新整理>&#xf021</reflash>	
																										<home box=button pos=testTube action=getSpecimenSeq option=submit>備管</home>					
																								
																										<error></error>

																								</home>
																								
																								<mixSubTitleContent>
																								
																									<mixSubTitle>
																										<mixText>病患清單</mixText> 
																										<!-- <count style='font-size: 14px;'>總計：</count>
																										<count = style='font-size: 14px;'>$count</count> -->
																									</mixSubTitle>
																									
																									<mixSubTitle>
																									
																										<mixText>檢驗單清單</mixText>
																										<!-- <count style='font-size: 14px;'>總計：</count>
																										<count pox=count style='font-size: 14px;'>$count</count> -->
																									
																									</mixSubTitle>
																								
																								</mixSubTitleContent> 
																								
																								<plant box=mix>
																								
																									<plant box=left>
																									
																										<table use=mix>
																											
																											<thead use=left>
																											
																												<th use=number></th>
																												<th use=bedNo>病房號</th>
																												<th use=chartNo>病歷號</th>
																												<th use=ptName>姓名</th>
																												<!--<th use=sex>性別</th>-->
																												<!--<th use=bitrhDate>生日</th>-->
																												<!--<th use=divShortName>科別</th>-->
																												<!--<th use=diagnosisDescription>臨床診斷</th>-->
																												<th use=roller></th>
																												
																											</thead>
																										
																										</table>

																										<roller box=IDP>";

																									
																									
			if($allData)
			{
				
				for($i = 0; $i < count($allData); $i++)
				{
					
					$data																	  = $allData[$i];
					$j																		  = $i + 1;
					
					if($data["sex"] == "M")
					{		
				
						$sex																				= "男";
				
					}else if($data["sex"] == "F"){
				
						$sex																				= "女";
				
					}else{
						
						$sex																				= "未設置";
					
					}
					
					$data["birthDate"]											= ltrim($data["birthDate"], "+");
			
					$response["html"] 									 	 .= "<table use=mix box=IDP pos=default name=$data[chartNo] action=Filter function=showLab>
					
																											<tr box=allTestTube find=$data[chartNo] pos=$j>

																												<td use=number>$j</td>
																												<td use=bedNo>$data[bedNo]</td>
																												<td use=chartNo>$data[chartNo]</td>
																												<td use=ptName>$data[ptName]</td>
																												<!--<td use=sex>$sex</td>-->
																												<!--<td use=birthDate>$data[birthDate]</td>-->
																												<!--<td use=divShortName>$data[divShortName]</td>-->
																												<!--<td use=diagnosisDescription title='$data[diagnosisDescription]'>$data[diagnosisDescription]</td>-->
																									
																						 					</tr>
																						 				</table>";	
					
				}
				
			}
			$response["html"]														.= "</roller>
			
																											</plant>";
																									
																									
			$response["html"] 												.=	"<plant box=right>
																									
																										<table use=mix pos=IDP>
																										
																											<thead use=right>
																										
																												<th use=number></th>
																												<th use=bedNo>病床號</th>
																												<th use=expectCollectionDate>預計採檢日</th>
																												<th use=expectCollectionTime>預計採檢時</th>
																												<th use=chartNo>病歷號</th>
																												<th use=ptName>姓名</th>
																												<!--<th use=sex>性別</th>-->
																												<th use=labNo>單號</th>
																												<th use=specimenPan>管別</th>										
																												<th use=specimenName>檢體</th>
																												<th use=emgFlag>件別</th>
																												<th><clear box=clear>清空</button></th>
																												<th use=roller></th>
																										
																											</thead>
																										
																										</table>
																									
																									<roller box=testTube pos=mix></roller>
																										
																									</plant>
																										
																								</plant>
		
																							</home>";
		
		
			print_r(json_encode($response));
		
	}
	
	//病患備管查詢
	public static function sreachPatient()
	{
		
		$allData																		= self::$pubVar["fetch"];
		
		if(!$_POST["option"])
		{
			
			$pos																			= "default";
			
		}else{
			
			$pos																			= "search";
			
		}
		
		
		if($allData)
		{
				
			usort($allData, function($a, $b){
				
				return strcmp($a["bedNo"], $b["bedNo"]);
				
			});
				
			$response["status"]												= "success";
				
			for($i = 0; $i < count($allData); $i++)
			{
					
				$data																	 	= $allData[$i];
				$j																			= $i + 1;
					
				if($data["sex"] == "M")
				{		
				
					$sex																				= "男";
				
				}else if($data["sex"] == "F"){
				
					$sex																				= "女";
				
				}else{
					
					$sex																				= "未設置";
					
				}
					
				$data["birthDate"]										  = ltrim($data["birthDate"], "+");
			
				$response["html"] 									   .= "<table use=mix box=IDP pos=$pos name=$data[chartNo] action=Filter function=showLab>
					
																										<tr box=allTestTube find=$data[chartNo] pos=$j>

																											<td use=number>$j</td>
																											<td use=bedNo>$data[bedNo]</td>
																											<td use=chartNo>$data[chartNo]</td>
																											<td use=ptName>$data[ptName]</td>
																											<!--<td use=sex>$sex</td>-->
																											<!--<td use=birthDate>$data[birthDate]</td>-->
																											<!--<td use=divShortName>$data[divShortName]</td>-->
																											<!--<td use=diagnosisDescription title='$data[diagnosisDescription]'>$data[diagnosisDescription]</td>-->
																									
																							 			</tr>
																							 		</table>";
																							 		
				$response["count"]											= $j;	
					
			}
				
		}
		
		print_r(json_encode($response));
		
	}
	
	//點table拿檢驗單
	public static function showLab()
	{
		
		$allData														 							= self::$pubVar["fetch"];
		$number                                           = $_POST["number"];
 		
		//print_r($allData);
		
		if($allData)
		{
			
			$response["status"]															= "success";
			
			for($i = 0; $i < count($allData); $i++)
			{
			
				$data																					= $allData[$i];
				//$specimenSeq																	= "未給號";
	
				switch($data["emgFlag"])
				{
							
					case "Y":
					
						$emgFlag 																	= "急件";
						
						break;
						
					case "N":
					
						$emgFlag																	= "非急件";		
					
						break;
						
					case "S":
					
						$emgFlag																	= "急件自付";		
					
						break;
							
							
				}
						
				if($data["sex"] == "M")
				{		
				
					$sex																				= "男";
				
				}else if($data["sex"] == "F"){
				
					$sex																				= "女";
				
				}else{
					
					$sex																				= "未設置";
					
				}
						
				$response["html"]														 .= "<table pos=testTube use=mix name=$data[labNo] number=$number>
																													<tr>
																								
																														<td use=number pos=detial>$number</td>
																														<td use=bedNo>$data[bedNo]</td>
																													  <td use=expectCollectionDate>$data[expectCollectionDate]</td>
																													  <td use=expectCollectionTime>$data[expectCollectionTime]</td>
																														<td use=chartNo title=$data[chartNo]>$data[chartNo]</td>
																														<td use=ptName>$data[ptName]</td>
																														<!--<td use=sex>$sex</td>-->
																														<td use=labNo>$data[labNo]</td>
																														<td use=specimenPan mCode=$data[mCode]>$data[tubeName]</td>																														
																														<td use=specimenName title=$data[specimenName]>$data[specimenName]</td>
																														<td use=emgFlag>$emgFlag</td>
																														<td use=moreOption pos=testTube>
																															
																															<moreOption box=button pos=detial function=testTube number=$number name=$data[labNo]>&#xf07b</moreOption>
																															<moreOption box=button pos=remove number=$number name=$data[labNo] option=testTube>&#xf1f8</moreOption>
																															
																														</td>
																										
																													</tr>
																								 				</table>
																								 				<labInfo pos=title number=$number name=$data[labNo]><content>檢體別 - 檢體名稱</content></labInfo>
																								 				<labInfo number=$number name=$data[labNo]>";
																								 				
				for($j = 0; $j < count($data["labInfo"]); $j++)
				{
					
					$labInfo																		= $data["labInfo"][$j];
					$response["html"]													 .= "<content>$labInfo</content>";
					
				}
				
				$response["html"]														 .= "</labInfo>";
																								 				
				$number																				= $number + 1;
																								 			
			}
		}
			
			print_r(json_encode($response));
		
	}
	
	//抽血稽核
	public static function checkTubeAndPatient()
	{
		
		$response																					= "<home box=workarea>
																													<home box=title>
																																															
																														<text>檢體採檢</text>

																														<input box=scan action=Filter function=checkScan pos=chartNo placeholder=請輸入病患手圈>
																														<home box=button pos=intoCheckScan action=Filter function=checkScan use=chartNo option=submit>輸入病歷號</home>
																														<input box=scan function=checkScan pos=sid placeholder=請輸入管子條碼>
																														<home box=button pos=intoCheckScan use=sid option=submit>輸入條碼號</home>
																														<!-- <home box=button pos=drawBlood>完成採檢</home> -->
																														<reflash go=checkTubeAndPatient action=Plant function=checkTubeAndPatient title=重新整理>&#xf021</reflash>							
																								
																														<error></error>
																								
																													</home>
																								
																													<panitentInfo></panitentInfo>
																								
																													<table pos=testTube>
																														<thead pos=testTube>
																															<tr>

																																<th use=bedNo>病床號</th>
																																<th use=chartNo>病歷號</th>
																																<th use=ptName>姓名</th>
																																<th use=sex>性別</th>
																																<th use=labNo>單號</th>
																																<th use=specimenPan>管別</th>
																																<th use=specimenSeq>檢體條碼號</th>											
																																<th use=specimenName>檢體</th>
																																<th use=emgFlag>件別</th>
																																<th use=roller></th>
																																<!--<th use=moreOption></th>-->
																										
																														</tr>
																													</thead>																		
																												</table>
																								
																												<roller box=checkTubeAndPatient></roller>

																						 					</home>";
																						 
		print_r(json_encode($response));
		
	}
	
	//掃描採檢資料
	public static function checkScan()
	{
		
		$allData																				= self::$pubVar["fetch"];
		
		if($allData){
			
			$response["status"] 																= "success";
		
			for($i = 0; $i < count($allData); $i++)
			{
			
				$data																					= $allData[$i];
				$bedNo																				= $data["bedNo"];
				$chartNo																			= $data["chartNo"];
				$ptName																				= $data["ptName"];
			
				switch($data["emgFlag"])
				{
							
					case "Y":
					
						$emgFlag 																= "急件";
							
						break;
						
					case "N":
					
						$emgFlag																= "非急件";		
					
						break;
						
					case "S":
					
						$emgFlag																= "急件自付";		
				
						break;
		
				}
						
				if($data["sex"] == "M")
				{		
				
					$sex																				= "男";
				
				}else if($data["sex"] == "F"){
				
					$sex																				= "女";
				
				}else{
				
					$sex																				= "未設置";
					
				}
		
				$response["sid"]													 .= "<table name=$data[specimenSeq]>
																											<td use=bedNo>$data[bedNo]</td>
																											<td use=chartNo>$data[chartNo]</td>
																											<td use=ptName>$data[ptName]</td>
																											<td use=sex>$sex</td>
																											<td use=labNo>$data[labNo]</td>
																											<td use=tubeName>$data[tubeName]</td>
																											<td use=specimenSeq>$data[specimenSeq]</td>
																											<td use=specimenName>$data[specimenName]</td>
																											<td use=emgflag>$emgFlag</td>
																											<!--<td use=moreOption>
																									
																												<moreOption box=button pos=remove name=$data[specimenSeq]>&#xf1f8</moreOption>
																									
																											</td>-->
																										</table>";
		
			}
		}else{
			
			$response["status"] 													 = "error";
			
		}
		
		if($_POST["sex"] == "M")
		{		
				
			$sex																				= "男";
				
		}else if($_POST["sex"] == "F"){
				
			$sex																				= "女";
				
		}else{
				
			$sex																				= "未設置";
					
		}
		
		$response["chartNo"]														.= "<IDP use=bedNo>病床號：$_POST[bedNo]</IDP>
																						<IDP use=chartNo name=$_POST[chartNo]>病歷號：<chartNo>$_POST[chartNo]</chertNo></IDP>
																						<IDP use=ptName>姓名：$_POST[ptName]</IDP>
																						<IDP use=sex>性別：$sex</IDP>";
		
		print_r(json_encode($response));
		
	}
	
	//確認刪除備管的條碼號
	public static function checkDelete()
	{
		
		$response																			= "<message box=detial>
		
																								 			<change box=close>&#xf00d</change>
																								 			<wran style='margin: 20px; padding: 10px; font-size: 20px; font-weight: bold; color: red;'>確定要刪除$_POST[labNo]的所有條碼號嗎？</wran>
																								 			<home box=button pos=deleteBarcode option=deleteBarcode name=$_POST[labNo]>確認刪除</home>
																							 
																						 				 </message>";
		print_r(json_encode($response));
		
	}
	
	public static function showTMCError()
	{
		
		$response																			= "<message box=detial>
		
																								 			<change box=close>&#xf00d</change>
																								 			<wran style='margin: 20px; padding: 10px; font-size: 20px; font-weight: bold; color: red;'>備管機連線異常，已改為使用條碼機進行印製</wran>
																								 			<message box=button pos=close>關閉</message>
																							 
																						 				 </message>";
		print_r(json_encode($response));
		
	}
	
	//我的工作清單
	/*public static function workList()
	{
		
		$allData																			= self::$pubVar["fetch"];
		$IDPData																			= self::$pubVar["IDPData"];
		$pastLab																			= self::$pubVar["pastLab"];
		$todayLab																			= self::$pubVar["todayLab"];
		$futureLab																		= self::$pubVar["futureLab"];																	
		$count                                    		= 0;
		
		//病人依照病床排序
		if($IDPData)
		{
			
			usort($IDPData, function($a, $b){
				
				return strcmp($a["bedNo"], $b["bedNo"]);
				
			});
			
			for($i = 0; $i < count($IDPData); $i++)
			{
				
				$count = $count + 1;
				
			}
			
		}
		
		$date                              						= date("Y-m-d");

		if($_POST["machine"] == "TMC")
		{
			
			$checkbox																		= "<input box=IsLabelOnly type=checkbox>只印條碼</input>";
			
		}else{
			 	
			$checkbox																		= "<input type=number name=quantity min=1 max=5 stpe=1 value=1>列印張數</input>";
			 	
		}
		
		$response["status"]														= "success";
		$response["html"] 														= "<errorTube box=bar></errorTube>
																										 <errorTube box=icon>&#xf06a</errorTube>
																										 <errorTube box=content></errorTube>
																										 <home box=workarea>
		
																											<home box=title>
																																															
																												<text>病患備管</text>
																												<printcheck>$checkbox</printcheck>

																												<select box=select pos=ipd>
																										
																													<option value=chartNo>病歷號</option>
																										 			<option value=labNo>檢驗單</option>
																													<option value=ptName>姓名</option>
																													<option value=bedNo>病房號</option>
																													<option value=idNo>身分證</option>
																								
																												</select>
																												<input box=search pos=mix action=Filter function=sreachPatient>
																												<select box=select pos=status>

																													<option value=false>未給號</option>																								 
																													<option value=true>已給號</option>
																													<option value=>全部</option>
																								
																												</select>
																												<input type=date name=start value=$date> 到 <input type=date name=end value=$date>
																												<select box=select pos=shift>
																								 
																										 			<option value=>全部</option>
																													<option value=日班>日班</option>
																													<option value=晚班>晚班</option>
																													<option value=夜班>夜班</option>

																												</select>
																										
																												<!--<select box=select pos=nsCode>
																											
																													<option value=$_POST[nsCode]>本站</option>
																													<option value=>全部</option>
																										
																												</select>-->
																										
																												<s-button box=button pos=search action=Filter function=sreachPatient>查詢</s-button>
																												<reflash go=workList action=filterForWorkList function=workList re=re title=重新整理>&#xf021</reflash>	
																												<home box=button pos=testTube action=getSpecimenSeq option=submit>備管</home>					
																								
																												<error></error>

																										</home>
																								
																										<mixSubTitleContent>
																								
																											<mixSubTitle>
																												<mixText>病患清單</mixText> 
																												<!-- <count style='font-size: 14px;'>總計：</count>
																												<count = style='font-size: 14px;'>$count</count> -->
																											</mixSubTitle>
																									
																											<mixSubTitle>

																												<mixText box=class pos=today class=change-active>現在單</mixText>
																												<mixText box=class pos=past class=change-inactive>過去單</mixText>
																												<mixText box=class pos=future class=change-inactive>未來單</mixText>
																												<mixText box=class pos=all class=change-inactive>全部</mixText>
																												<mixText>檢驗單清單</mixText>
																										
																											</mixSubTitle>
																								
																										</mixSubTitleContent> 
																								
																										<plant box=list>
																								
																											<plant box=left pos=list>
																									
																												<table use=list>
																											
																													<thead use=left pos=list>
																												
																														<th use=number></th>
																														<th use=bedNo>病房號</th>
																														<th use=chartNo>病歷號</th>
																														<th use=ptName>姓名</th>
																														<!--<th use=sex>性別</th>-->
																														<!--<th use=bitrhDate>生日</th>-->
																														<!--<th use=divShortName>科別</th>-->
																														<!--<th use=diagnosisDescription>臨床診斷</th>-->
																														<th use=roller></th>
																												
																													</thead>
																										
																												</table>

																												<roller box=IDP pos=list>";										
																									
			if($IDPData)
			{
				
				for($i = 0; $i < count($IDPData); $i++)
				{
					
					$data																			  = $IDPData[$i];
					$j																				  = $i + 1;

					$data["birthDate"]													= ltrim($data["birthDate"], "+");
			
					$response["html"] 											 	 .= "<table use=list box=IDP pos=default name=$data[chartNo] action=Filter function=showLab>
					
																													<tr box=allTestTube find=$data[chartNo] pos=$j>

																														<td use=number>$j</td>
																														<td use=bedNo>$data[bedNo]</td>
																														<td use=chartNo>$data[chartNo]</td>
																														<td use=ptName>$data[ptName]</td>
																														<!--<td use=sex>$sex</td>-->
																														<!--<td use=birthDate>$data[birthDate]</td>-->
																														<!--<td use=divShortName>$data[divShortName]</td>-->
																														<!--<td use=diagnosisDescription title='$data[diagnosisDescription]'>$data[diagnosisDescription]</td>-->
																									
																								 					</tr>
																								 				</table>";	
					
				}
				
			}
			$response["html"]															.= "</roller>
			
																												</plant>";
																									
																									
			$response["html"] 														.=	"<plant box=right pos=list>
																									
																													<table use=list pos=IDP>
																										
																														<thead use=right pos=list>
																										
																															<th use=number></th>
																															<th use=bedNo>病床號</th>
																															<th use=expectCollectionDate>預計採檢日</th>
																															<th use=expectCollectionTime>預計採檢時</th>
																															<th use=chartNo>病歷號</th>
																															<th use=ptName>姓名</th>
																															<!--<th use=sex>性別</th>-->
																															<th use=labNo>單號</th>
																															<th use=specimenPan>管別</th>										
																															<th use=specimenName>檢體</th>
																															<th use=emgFlag>件別</th>
																															<th><clear box=clear>清空</button></th>
																															<th use=roller></th>
																										
																														</thead>
																										
																													</table>
																									
																												<roller box=testTube pos=list option=today>";
																									
			//現在單
			if($todayLab)
			{
																										
				for($i = 0; $i < count($todayLab); $i++)
				{
				
					$data																			 = $todayLab[$i];
				
					switch($data["emgFlag"])
					{
							
						case "Y":
					
							$emgFlag 															 = "急件";
						
							break;
						
						case "N":
					
							$emgFlag															 = "非急件";		
					
							break;
						
						case "S":
					
							$emgFlag															 = "急件自付";		
				
							break;
		
					}
				
					$number																		 = $i + 1;
					$response["html"]													.= "<table pos=testTube use=list option=today name=$data[labNo] number=$number>
																													<tr>
																									
																														<td use=number pos=detial>$number</td>
																														<td use=bedNo>$data[bedNo]</td>
																													  <td use=expectCollectionDate>$data[expectCollectionDate]</td>
																													  <td use=expectCollectionTime>$data[expectCollectionTime]</td>
																														<td use=chartNo title=$data[chartNo]>$data[chartNo]</td>
																														<td use=ptName>$data[ptName]</td>
																														<!--<td use=sex>$sex</td>-->
																														<td use=labNo>$data[labNo]</td>
																														<td use=specimenPan mCode=$data[mCode]>$data[tubeName]</td>																														
																														<td use=specimenName title=$data[specimenName]>$data[specimenName]</td>
																														<td use=emgFlag>$emgFlag</td>
																														<td use=moreOption pos=testTube>
																																
																															<moreOption box=button pos=detial function=testTube number=$number name=$data[labNo]>&#xf07b</moreOption>
																															<moreOption box=button pos=remove number=$number name=$data[labNo] option=testTube>&#xf1f8</moreOption>
																																
																														</td>
																											
																													</tr>
																									 			</table>
																						 			
																									 			<labInfo pos=title number=$number name=$data[labNo]>
																								 			
																									 				<content>檢體別 - 檢體名稱</content></labInfo>
																											 		<labInfo number=$number name=$data[labNo]>";
																									 		
					for($j = 0; $j < count($data["labInfo"]); $j++)
					{
					
						$labInfo															 	 = $data["labInfo"][$j];
						$response["html"]										 		.= "<content>$labInfo</content>";
					
					}
				
					$response["html"]													.= "</labInfo>";	
				
				}
			
			}
																								
			$response["html"] 														.=	"</roller>
																												<roller box=testTube pos=list option=past>";	
			
			//過去單
			if($pastLab)						
			{																
		
				for($i = 0; $i < count($pastLab); $i++)
				{
					
					$data																			 = $pastLab[$i];
				
					switch($data["emgFlag"])
					{
							
						case "Y":
					
							$emgFlag 															 = "急件";
						
							break;
						
						case "N":
					
							$emgFlag															 = "非急件";		
					
							break;
						
						case "S":
					
							$emgFlag															 = "急件自付";		
				
							break;
		
					}
				
					$number																		 = $i + 1;
					$response["html"]													.= "<table pos=testTube use=list option=past name=$data[labNo] number=$number>
																													<tr>
																										
																														<td use=number pos=detial>$number</td>
																														<td use=bedNo>$data[bedNo]</td>
																													  <td use=expectCollectionDate>$data[expectCollectionDate]</td>
																													  <td use=expectCollectionTime>$data[expectCollectionTime]</td>
																														<td use=chartNo title=$data[chartNo]>$data[chartNo]</td>
																														<td use=ptName>$data[ptName]</td>
																														<!--<td use=sex>$sex</td>-->
																														<td use=labNo>$data[labNo]</td>
																														<td use=specimenPan mCode=$data[mCode]>$data[tubeName]</td>																														
																														<td use=specimenName title=$data[specimenName]>$data[specimenName]</td>
																														<td use=emgFlag>$emgFlag</td>
																														<td use=moreOption pos=testTube>
																																
																															<moreOption box=button pos=detial function=testTube number=$number name=$data[labNo]>&#xf07b</moreOption>
																															<moreOption box=button pos=remove number=$number name=$data[labNo] option=testTube>&#xf1f8</moreOption>
																															
																														</td>
																										
																													</tr>
																									 			</table>
																						 			
																									 			<labInfo pos=title number=$number name=$data[labNo]>
																								 			
																									 				<content>檢體別 - 檢體名稱</content></labInfo>
																											 		<labInfo number=$number name=$data[labNo]>";
																								 		
					for($j = 0; $j < count($data["labInfo"]); $j++)
					{
					
						$labInfo																 = $data["labInfo"][$j];
						$response["html"]											  .= "<content>$labInfo</content>";
					
					}	
				
					$response["html"]													.= "</labInfo>";	
				
				}
			
			}
			
			$response["html"] 														.=	"</roller>
																												<roller box=testTube pos=list option=future>";	
			
			//未來單
			if($futureLab)
			{																						
			
				for($i = 0; $i < count($futureLab); $i++)
				{
				
					$data																			 = $futureLab[$i];
				
					switch($data["emgFlag"])
					{
							
						case "Y":
					
							$emgFlag 															 = "急件";
						
							break;
						
						case "N":
					
							$emgFlag															 = "非急件";		
						
							break;
						
						case "S":
					
							$emgFlag															 = "急件自付";		
				
							break;
		
					}
				
					$number																		 = $i + 1;
					$response["html"]													.= "<table pos=testTube use=list option=future name=$data[labNo] number=$number>
																													<tr>
																									
																														<td use=number pos=detial>$number</td>
																														<td use=bedNo>$data[bedNo]</td>
																													  <td use=expectCollectionDate>$data[expectCollectionDate]</td>
																													  <td use=expectCollectionTime>$data[expectCollectionTime]</td>
																														<td use=chartNo title=$data[chartNo]>$data[chartNo]</td>
																														<td use=ptName>$data[ptName]</td>
																														<!--<td use=sex>$sex</td>-->
																														<td use=labNo>$data[labNo]</td>
																														<td use=specimenPan mCode=$data[mCode]>$data[tubeName]</td>																														
																														<td use=specimenName title=$data[specimenName]>$data[specimenName]</td>
																														<td use=emgFlag>$emgFlag</td>
																														<td use=moreOption pos=testTube>
																															
																															<moreOption box=button pos=detial function=testTube number=$number name=$data[labNo]>&#xf07b</moreOption>
																															<moreOption box=button pos=remove number=$number name=$data[labNo] option=testTube>&#xf1f8</moreOption>
																															
																														</td>
																										
																													</tr>
																									 			</table>
																							 			
																									 			<labInfo pos=title number=$number name=$data[labNo]>
																								 			
																									 				<content>檢體別 - 檢體名稱</content></labInfo>
																											 		<labInfo number=$number name=$data[labNo]>";
																								 		
					for($j = 0; $j < count($data["labInfo"]); $j++)
					{
					
						$labInfo															 = $data["labInfo"][$j];
						$response["html"]										  .= "<content>$labInfo</content>";
					
					}
				
					$response["html"]												.= "</labInfo>";	
				
				}
			
			}
			$response["html"] 													.=	"</roller>
																											<roller box=testTube pos=list option=all>";
			
			//全部
			if($allData)
			{
				
				for($i = 0; $i < count($allData); $i++)
				{
				
					$data																			 = $allData[$i];
				
					switch($data["emgFlag"])
					{
							
						case "Y":
					
							$emgFlag 															 = "急件";
						
							break;
						
						case "N":
					
							$emgFlag															 = "非急件";		
					
							break;
						
						case "S":
					
							$emgFlag															 = "急件自付";		
				
							break;
		
					}
				
					$number																		 = $i + 1;
					$response["html"]													.= "<table pos=testTube use=list option=all name=$data[labNo] number=$number>
																													<tr>
																									
																														<td use=number pos=detial>$number</td>
																														<td use=bedNo>$data[bedNo]</td>
																													  <td use=expectCollectionDate>$data[expectCollectionDate]</td>
																													  <td use=expectCollectionTime>$data[expectCollectionTime]</td>
																														<td use=chartNo title=$data[chartNo]>$data[chartNo]</td>
																														<td use=ptName>$data[ptName]</td>
																														<!--<td use=sex>$sex</td>-->
																														<td use=labNo>$data[labNo]</td>
																														<td use=specimenPan mCode=$data[mCode]>$data[tubeName]</td>																														
																														<td use=specimenName title=$data[specimenName]>$data[specimenName]</td>
																														<td use=emgFlag>$emgFlag</td>
																														<td use=moreOption pos=testTube>
																															
																															<moreOption box=button pos=detial function=testTube number=$number name=$data[labNo]>&#xf07b</moreOption>
																															<moreOption box=button pos=remove number=$number name=$data[labNo] option=testTube>&#xf1f8</moreOption>
																																
																														</td>
																										
																													</tr>
																									 			</table>
																						 			
																									 			<labInfo pos=title number=$number name=$data[labNo]>
																								 			
																									 				<content>檢體別 - 檢體名稱</content></labInfo>
																											 		<labInfo number=$number name=$data[labNo]>";
																								 		
					for($j = 0; $j < count($data["labInfo"]); $j++)
					{
					
						$labInfo															 = $data["labInfo"][$j];
						$response["html"]										  .= "<content>$labInfo</content>";
					
					}
				
					$response["html"]												.= "</labInfo>";	
				
				}																						
			
			}																																											
																									
			$response["html"] 													.=	"</roller>
																											</plant>																									
																											</plant>
																											</home>";
			
		
			print_r(json_encode($response));

	}*/
	
	
	/*public static function recode()
	{
		
				
		$response																					= "<home box=workarea>
																													<home box=title>
																																															
																														<text>過去紀錄</text>

																														<select box=recodeScan>
																														
																															<option value=specimenSeq>條碼號</option>
																															<option value=chartNo>病歷號</option>
																															<option value=labNo>檢驗單號</option>
																														
																														</select>
																														
																														<input box=scan action=shortData function=recodeScan>
																														<home box=button pos=intoRecodeScan action=shortData function=recodekSca>查詢</home>
																														<reflash go=checkTubeAndPatient action=Plant function=checkTubeAndPatient title=重新整理>&#xf021</reflash>							
																								
																														<error></error>
																								
																													</home>
																								
																													<panitentInfo></panitentInfo>
																								
																													<table pos=testTube>
																														<thead pos=testTube>
																															<tr>

																																<th use=bedNo>病床號</th>
																																<th use=chartNo>病歷號</th>
																																<th use=ptName>姓名</th>
																																<th use=sex>性別</th>
																																<th use=labNo>單號</th>
																																<th use=specimenPan>管別</th>
																																<th use=specimenSeq>檢體條碼號</th>											
																																<th use=specimenName>檢體</th>
																																<th use=emgFlag>件別</th>
																																<th use=moreOption></th>
																										
																														</tr>
																													</thead>																		
																												</table>
																								
																												<roller box=checkTubeAndPatient></roller>

																						 					</home>";
																						 
		print_r(json_encode($response));
		
	}*/
			
	//整批備管-畫面
	/*public static function allTestTube()
	{

		$allData																	= self::$pubVar["fetch"];
		$date                                 		= date("Y-m-d");
		
		if($_POST["machine"] == "TMC")
		{
			
			$checkbox																= "<input box=IsLabelOnly type=checkbox  checked>只印條碼</input>";
			
		}
		
		if($allData)
		{
			
			$response["status"]											= "success";
			$response["html"]												= "<home box=workarea>
																									<home box=title>
																							
																										<text>整批備管</text>
																										<select box=select pos=ipd>
																								 
																								 			<option value=labNo>檢驗單</option>
																											<option value=chartNo>病歷號</option>
																											<option value=ptName>姓名</option>
																											<option value=bedNo>病房號</option>
																											<option value=idNo>身分證</option>
																								
																										</select>
																										<input box=search>
																										<select box=select pos=status>

																											<option value=0>未給號</option>																								 
																											<option value=1>已給號</option>
																											<option value=>全部</option>
																								
																										</select>
																										<input type=date name=start value=$date> 到 <input type=date name=end value=$date>
																										<select box=select pos=shift>
																								 
																											<option value=Day>日班</option>
																											<option value=Evening>夜班</option>
																											<option value=Night>大夜班</option>
																											<option value=>全部</option>
																								
																										</select>
																										<s-button box=button pos=search action=ShortData function=allTestTube>查詢</s-button>
																								
																										<printcheck>$checkbox</printcheck>

																										<home box=button pos=allTestTube action=getSpecimenSeq title=將只印條碼取消即可單印條碼>整批備管</home>
																										<error box=error></error>
																								
																									</home>
																									<table pos=allTestTube>
																										<thead pos=allTestTube>
																											<tr pos=allTestTube>
																												<th use=number></th>
																												<th use=BED_NO>病床號</th>
																												<th use=CHART_NO>病歷號</th>
																												<th use=PT_NAME>姓名</th>
																												<th use=SEX>性別</th>
																												<th use=BIRTH_DATE>生日</th>
																												<th use=DIV_SHORT_NAME>科別</th>
																												<th use=ID_NO>身分證</th>
																												<th use=DIAGNOSIS_DESCRIPTION>臨床診斷</th>
																												<th use=moreOption pos=allTesteTube></th>
																												<th box=checkbox><tick box=button pos=checkbox>取消</tick></th>
																											</tr>
																										</thead>
																									</table>
																									<roller box=allTestTube>";
		
		for($i = 0; $i < count($allData); $i++)
		{
			
			$data																	= $allData[$i];
			$j																		= $i + 1;
			
			if($data["sex"] == "M")
			{
				
				$sex																= "男";
				
			}else{
				
				$sex																= "女";
				
			}
			
			$response["html"] 									 .= "<table box=IDP>
																								<tr box=allTestTube find=$data[chartNo] pos=$j>
																									<td use=number>$j</td>
																									<td use=bedNo>$data[bedNo]</td>
																									<td use=chartNo>$data[chartNo]</td>
																									<td use=ptName>$data[ptName]</td>
																									<td use=sex>$sex</td>
																									<td use=birthDate>$data[birthDate]</td>
																									<td use=divShortName>$data[divShortName]</td>
																									<td use=idNo>$data[idNo]</td>
																									<td use=diagnosisDescription title='$data[diagnosisDescription]'>$data[diagnosisDescription]</td>
																									<td use=moreOption pos=allTesteTube>
																									
																										<moreOption pos=detial action=shortData function=Detial name=$data[chartNo] number=$j title=查看更多>&#xf07b</moreOption>
																										<moreOption pos=showOption name=$data[chartNo] title=開啟功能表>&#xf142</moreOption>
																									
																										<more box=floating-dialog name=$data[chartNo] style='display: none;'>
 
    																									<more box=dialog-content>
    																									
        																								<moreOption use=subMenu pos=allTestTubeBarcode action=getSpecimenSeq option=PluralData name=$data[chartNo] number=$j>單筆備管</moreOption>
        																							  <moreOption use=subMenu pos=deleteBarcode action=getData option=PluralData name=$data[chartNo]  number=$j>清空給號</moreOption>
        																								<button id=close-dialog name=$data[chartNo]>Close</button>
        																								
    																									</more>
    																									
																										</more>
																									
																								</td>
																								<td box=checkbox><input class=firstLayer data-group=$data[chartNo] type=checkbox box=checkbox name=$data[chartNo] number=$j checked></td>
																						 	</tr>
																						 </table>
																						 
																						 <table box=detial>
																						 
																						 		<tr box=title name=$data[chartNo] find=$data[chartNo]>
																						 
																						 			<th>單號</th>
																						 			<th>科室</th>
																						 			<th>醫生</th>
																						 			<th>件別</th>
																						 			<th>開單日</th>
																						 			<th>開單時間</th>
																						 			<th>預計採檢日</th>
																						 			<th>狀態</th>
																						 			<th box=button></th>
																						 			<th box=checkbox></th>
																						 
																						 		</tr>
																						 		
																						 </table>";	
			
			//print_r($data);
			
		}
		
		$response["html"]											.= "</roller>
																							
																							</home>";
		}else{
			
			$response["status"]									 = "error";
			
		}
		
		print_r(json_encode($response));
		
	}*/
		
	//備管-詳細內容之畫面
	/*public static function Detial()
	{

		$allData															 		= self::$pubVar["fetch"];
		//print_r($allData);
		
		if($allData)
		{
			
			for($i = 0; $i < count($allData); $i++)
			{
				
				$data 																= $allData[$i];
				$j																		= $i + 1;
				
				switch($data["emgFlag"])
				{
					
					case "Y":
					
						$emgFlag 													= "急件";
						
						break;
						
					case "N":
					
						$emgFlag													= "非急件";		
					
						break;
						
					case "S":
					
						$emgFlag													= "急件自付";		
					
						break;
					
				}
				
				switch($data["labStatus"])
				{
					
					case "0":
					
						$status														= "已開單";
						//$style														= "background-color:#C6DAFF";
	
						break;
						
					case "1":
					
						$status														= "已指派";
						$style														= "background-color:#C6DAFF";

						break;
						
					case "2":
					
						$status														= "已登錄";
					
						break;
						
					case "3":
					
						$status														= "已確認";
					
						break;
						
					case "4":
					
						$status														= "須作廢";
					
						break;
						
					case "5":
					
						$status														= "已作廢";
					
						break;
					
				}
		
				$response[]													 	= "<tr box=detial clear=$data[chartNo] find=$data[chartNo] name=$data[labNo] style='$style'>
																										<td use=labNo name=$data[labNo]>$data[labNo]</td>
																										<td use=orderDivName>$data[divName]</td>
																										<td use=orderDoctorName>$data[doctorName]</td>
																										<td use=emgFlag sendData=yes>$emgFlag</td>
																										<td use=labOrderDate>$data[labOrderDate]</td>
																										<td use=labOrderTime>$data[labOrderTime]</td>
																										<td use=expectCollectionDate>$data[expectCollectionDate]</td>
																										<td use=labStatus>$status</td>
																										<td box=button>
																											<moreOption pos=moreDetial action=Filter function=moreDetial find=$data[chartNo] name=$data[labNo] title=查看詳情>&#xf15c</moreOption>
																											<moreOption pos=showOption name=$data[labNo] title=單筆給號>&#xf142</moreOption>
																											
																											<more box=floating-dialog name=$data[labNo]>
 
    																										<more box=dialog-content>
    																									
        																									<moreOption use=subMenu pos=allTestTubeBarcode action=getSpecimenSeq name=$data[labNo]>單筆備管</moreOption>
    																											<moreOption use=subMenu pos=deleteBarcode action=Barcode option=OneData name=$data[labNo]>清空給號</moreOption>
        																									<button id=close-dialog name=$data[labNo]>Close</button> 
        																								
    																										</more>
    																									
																											</more>
																											
																										</td>
																										<td box=checkbox><input class=secondLayer data-group=$data[chartNo] type=checkbox box=checkbox name=$data[labNo] checked></td>
																									</tr>
																									
																									<tr box=moreDetial pos=title clear=$data[chartNo] find=$data[chartNo] name=$data[labNo]>
																									
																										<th box=moreTitle></th>
																										<th box=moreTitle>管別</th>
																										<th box=moreTitle>檢體條碼號</th>
																										<th box=moreTitle>檢體</th>
																										<th box=moreTitle>計價碼</th>
																										<th box=moreTitle>項目名稱</th>
																										<th box=moreTitle>採檢日期</th>
																										<th box=moreTitle>採檢時間</th>
																										<th box=moreTitle></th>
																										<th box=moreTitle></th>
																									
																									</tr>";
				
			}
			
		}else{
				
				$response[]														 = "<tr>
				
											
				
																									</tr>";
			
			
		}
		
		print_r(json_encode($response));
	
	}*/
	
	//備管-更詳細資料
	/*public static function moreDetial()
	{
		
		$allData															 		= self::$pubVar["fetch"];
		
		if($allData)
		{
			
			for($i = 0; $i < count($allData); $i++)
			{
				
				$data 																= $allData[$i];
				$j																		= $i + 1;
				
				$response														 .= "
																									<tr box=moreDetial pos=moreDetial clear=$data[chartNo] find=$data[chartNo] name=$data[labNo]>
																									
																										<td box=moreDetial></td>
																										<td box=moreDetial use=tubeName>$data[tubeName]</td>
																										<td box=moreDetial use=specimenSeq>$data[specimenSeq]</td>
																										<td box=moreDetial use=specimenName>$data[specimenName]</td>
																										<td box=moreDetial use=labCode>$data[labCode]</td>
																										<td box=moreDetial use=labName>$data[labName]</td>
																										<td box=moreDetial use=specimenDate>$data[labOrderDate]</td>
																										<td box=moreDetial use=specimenTime>$data[labOrderTime]</td>
																										<td box=moreDetial></td>
																										<td box=moreDetial></td>
																		
																									</tr>";
			
			}
		}
										
		print_r(json_encode($response));
		
	}*/
	
														
}

$PlantHtmlTable = new PlantHtmlTable();

?>