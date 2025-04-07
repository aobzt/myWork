/*讓中文生效*/
$(document).ready(function(){
	
	function showLoading()
	{
		
		$("mask[box=loading]").css("display", "flex");
		
	}
	
	function hideLoading()
	{
		
		$("mask[box=loading]").css("display", "none");
		
	}

	function updateClock() { 																			//時間
					
  	var now = new Date();
  	var hours = now.getHours();
  	var minutes = now.getMinutes();
  	var seconds = now.getSeconds();

  	hours = (hours < 10) ? "0" + hours : hours;
  	minutes = (minutes < 10) ? "0" + minutes : minutes;
 		seconds = (seconds < 10) ? "0" + seconds : seconds;

  	var timeString = hours + ":" + minutes + ":" + seconds;
  	
  	$("time").text(timeString);
  			
	}

	setInterval(updateClock, 1000);
	updateClock();
			
	function updateDate() { 																			//日期
		
  	var now = new Date();
  	var year = now.getFullYear();
  	var month = now.getMonth() + 1;
  	var day = now.getDate();

  	month = (month < 10) ? "0" + month : month;
  	day = (day < 10) ? "0" + day : day;

  	var dateString = year + "-" + month + "-" + day;

		$("date").text(dateString);
  	
	}

	setInterval(updateDate, /*60 * 60 * */1000);
	updateDate();
	
	/*click event*/
	/*未登入事件與列印視窗*/
	$(document).on("click", "message[box=button]", function(){
		
		switch($(this).attr("pos"))
		{
			
			case "login":
			
				window.location.href = "http://192.168.1.173";
		
				break;
				
			case "close-message":
			case "close-print":
			case "close":

				$("window").html("");	
				$("window").css("display", "none");		
				$("mask[box=mask]").css("display", "none");

				break;
				
			case "print":
			
				original = $("body").html();
				$("body").html($("message[box=print_box]"));
		
				window.print();
				$("body").html(original);
				$("window").html("");
				$("mask[box=mask]").css("display", "none");
				$("window").css("display", "none");	

				break;

		}

	});
	
	$(document).on("click", "bar[box=logo]", function(){
		
		window.location.reload(true);
		
	});
	
	$(document).on("click", "[openMenu]", function(){
		
		console.log($(this).attr("openMenu"));
		
		var rect = this.getBoundingClientRect();
		
		if($("bar[box=subMenu][pos=" + $(this).attr("openMenu") + "]").css("display") == "none")
		{
			
			$("bar[box=subMenu]").css("display", "none");
			$("bar[box=subMenu][pos=" + $(this).attr("openMenu") + "]").css("display", "flex");
			
			$("bar[box=subMenu][pos=" + $(this).attr("openMenu") + "]").css({
				
				left: rect.left + "px"
				
			});
			
		}else{
			
			$("bar[box=subMenu]").css("display", "none");
			
		}
		
	});

	//首頁功能
	$(document).on("click", "[go]", function(){
	
		$("bar[box=subMenu]").css("display", "none");
	
		switch($(this).attr("go")){
		
			//備管紀錄
			case "HisTestTube":
			
				action = $(this).attr("action");
				$function = $(this).attr("function");
				
				requestData = "nsCode=" + $("space").attr("mcode");
			
				var startGetData = performance.now();
				//console.log(startGetData);

				var loadingTimer = setTimeout(showLoading, 500);
				//showLoading();
			
				//獲取資料
				$.ajax({
   	 	
        	url: "https://192.168.1.195/api/NursingStationOracle/getHistoricalLabRecords",
        	method: "GET",
       		contentType: "application/json",
       		data: requestData,
       		//data: JSON.stringify(requestData), //轉Json
        
        	success: function(response) {
        	
        		var endGetData = performance.now();
        		console.log(endGetData);
        		console.log(startGetData);
        		clearTimeout(loadingTimer);
        		hideLoading();  
        	
           	console.log("Success:", response);
           	console.log("API花費時間: " + (endGetData - startGetData).toFixed(2) + "毫秒");
						response = JSON.stringify(response);
						
           	//顯示畫面 	
           	var startShowData = performance.now();
			
			console.log($("[mCode]").attr("mCode"));
           	
           	$.post("Function.php", {Data: response ,action: action, function: $function, dicCode: $("[mCode]").attr("mCode")}, function($Json){
						
							console.log($Json);
											
							$J = JSON.parse($Json);
								
							if($J.status == "success")
							{
									
								$("home").html("");
								$("home").html($J.html);
								
								var endShowData = performance.now();
								console.log("顯示畫面花費時間: " + (endShowData - startShowData).toFixed(2) + "毫秒");	
									
							}							
							
						});
            
        	},
        
        	error: function(xhr, status, error) {
        	
				   	console.error("Error:", error);
				   	$.post("Function.php", {action: action, function: $function, dicCode: $("[mCode]").attr("mCode")}, function($Json){
						
							console.log($Json);
											
							$J = JSON.parse($Json);
								
							clearTimeout(loadingTimer);
							hideLoading(); 
								
							if($J.status == "success")
							{
									
								$("home").html("");
								$("home").html($J.html);	
									
							}							
							
						});

       		}
        
    		});
    			
    		/*$("bar[pos=menu][go]").css("color", "white");
    		$("bar[pos=menu][go=" + $(this).attr("go") + "]").css("color", "orange");*/
			
				break;
				
			//我的工作清單
			/*case "workList":
			
				action = $(this).attr("action");
				$function = $(this).attr("function");
				
				requestData = "nurseCode=" + $("[userid]").attr("userid");
			
				$.ajax({
					
					url: "https://192.168.1.195/api/NursingStationOracle/MyList",
					method: "GET",
					contentType: "application/json",
					data: requestData,
					
					success: function(response) {
						
						console.log("success:", response);
						
						response = JSON.stringify(response);

						$.post("Function.php", {Data: response, store: "testTube", action: action, function: $function, machine: $("space").attr("machine"), nsCode: $("[mcode]").attr("mcode")}, function($Json){
							
							console.log($Json);
							$J = JSON.parse($Json);
							
							if($J.status == "success")
							{

								$("home").html("");
								$("home").html($J.html);

							}
							
						});
												
					},
					
					error: function(xhr, status, error) {
        	
				    console.error("Error:", error);
				    
				    response = 
				    [
    					{			
       		 			"labNo" : "LI139B0030",
     		   			"chartNo" : "0001224542",
     		   			"labOrderDate" : "1130911",
        	 			"labOrderTime" : "0256",
 		       			"ptName" : "余子清",
    		   			"sex" : "M",
        	 			"birthDate" : "0470609",
 			     			"clinicFlag" : "I",
      		 			"emgFlag" : "Y",
        	 			"specimenName" : "BLOOD",
        	 			"labGroupCode" : "C",
      		 			"bedNo" : "1202-1",
        	 			"orderDivName" : "一般外科",
        	 			"orderDoctorName" : "劉曉東",
        	 			"expectCollectionDate" : "1130911",
        	 			"expectCollectionTime" : "0248",
        	 			"labName" : "Albumin",
        	 			"labCode" : "6309038",
        	 			"diagnosisDescription" : "Other peritonitis",
        	 			"specimenCode" : "02",
        	 			"mCode" : "05",
        	 			"tubeName" : "綠蓋",
       	 	 			"specimenSeq" : "LI139B0030",
        	 			"labStatus" : "0",
        	 			"appointDate" : null,
        	 			"appointTime" : null,
        	 			"labNoteCode" : null,
        	 			"urgentFlag" : null
    					},
    					{
        	 			"labNo" : "LI139B0031",
        	 			"chartNo" : "0001224543",
        	 			"labOrderDate" : "1130909",
        	 			"labOrderTime" : "0310",
        	 			"ptName" : "李華",
        	 			"sex" : "M",
        	 			"birthDate" : "0580510",
        	 			"clinicFlag" : "I",
        	 			"emgFlag" : "N",
        	 			"specimenName" : "BLOOD",
        	 			"labGroupCode" : "C",
        	 			"bedNo" : "1203-1",
        	 			"orderDivName" : "內科",
        	 			"orderDoctorName" : "張美英",
        	 			"expectCollectionDate" : "1130909",
        	 			"expectCollectionTime" : "0300",
        	 			"labName" : "CA",
        	 			"labCode" : "6309011",
        	 			"diagnosisDescription" : "Other peritonitis",
        	 			"specimenCode" : "02",
        	 			"mCode" : "05",
        	 			"tubeName" : "綠蓋",
        	 			"specimenSeq" : "LI139B0031",
        	 			"labStatus" : "0",
        	 			"appointDate" : null,
        	 			"appointTime" : null,
        	 			"labNoteCode" : null,
        	 			"urgentFlag" : null
    					},
    					{
      	   			"labNo" : "LI139B0032",
        	 			"chartNo" : "0001224544",
        	 			"labOrderDate" : "1130911",
        	 			"labOrderTime" : "0400",
        	 			"ptName" : "王小明",
        	 			"sex" : "M",
        	 			"birthDate" : "0730205",
        	 			"clinicFlag" : "I",
        	 			"emgFlag" : "N",
        	 			"specimenName" : "BLOOD",
        	 			"labGroupCode" : "C",
        	 			"bedNo" : "1204-1",
        	 			"orderDivName" : "外科",
        	 			"orderDoctorName" : "陳大明",
        	 			"expectCollectionDate" : "1130911",
        	 			"expectCollectionTime" : "0355",
        	 			"labName" : "CRP",
        	 			"labCode" : "6309051",
        	 			"diagnosisDescription" : "Appendicitis",
        	 			"specimenCode" : "02",
        	 			"mCode" : "05",
         	 			"tubeName" : "紅蓋",
        	 			"specimenSeq" : "LI139B0032",
        	 			"labStatus" : "0",
        	 			"appointDate" : null,
        	 			"appointTime" : null,
        	 			"labNoteCode" : null,
        	 			"urgentFlag" : null
    					},
    					{
        	 			"labNo" : "LI139B0033",
        	 			"chartNo" : "0001224545",
        	 			"labOrderDate" : "1130908",
        	 			"labOrderTime" : "0530",
        	 			"ptName" : "黃美麗",
        	 			"sex" : "F",
        	 			"birthDate" : "0810210",
        	 			"clinicFlag" : "I",
        	 			"emgFlag" : "Y",
        	 			"specimenName" : "URINE",
        	 			"labGroupCode" : "D",
        	 			"bedNo" : "1205-2",
        	 			"orderDivName" : "泌尿科",
        	 			"orderDoctorName" : "葉青",
        	 			"expectCollectionDate" : "1130908",
        	 			"expectCollectionTime" : "0525",
        	 			"labName" : "Urea",
        	 			"labCode" : "6309060",
        	 			"diagnosisDescription" : "Kidney stone",
        	 			"specimenCode" : "03",
        	 			"mCode" : "05",
        	 			"tubeName" : "黃蓋",
        	 			"specimenSeq" : "LI139B0033",
        				"labStatus" : "0",
   			     		"appointDate" : null,
        	 			"appointTime" : null,
        	 			"labNoteCode" : null,
        	 			"urgentFlag" : null
    					}
						];
			
						response = JSON.stringify(response);*/
				    	
				   // $.post("Function.php", {Data: response, action: action /*"Plant"*/, function: $function, machine: $("space").attr("machine"), nsCode: $("[mcode]").attr("mcode")}, function($Json){
							
							/*console.log($Json);
							$J = JSON.parse($Json);
							
							if($J.status == "success")
							{

								$("home").html("");
								$("home").html($J.html);
								
							}

						});

       		}
					
				});
			
				break;*/
				
			//歷史打包
			case "HistoryPackage":
			
					action = $(this).attr("action");
					$function = $(this).attr("function");
					go = $(this).attr("go");

					var startGetData = performance.now();
					var loadingTimer = setTimeout(showLoading, 500);
					
					$.ajax({
   	 	
        		url: "https://192.168.1.195/api/Package/getAllData",
        		method: "GET",
        		contentType: "application/json",
        		//data: requestData,
        		//data: JSON.stringify(requestData), //轉Json
        
        		success: function(response) {
        	
        			var endGetData = performance.now();
        			
					console.log("Success:", response);
					response = JSON.stringify(response);
            	
					console.log("API花費時間: " + (endGetData - startGetData).toFixed(2) + "毫秒");

            	//顯示畫面
							$.post("Function.php", {Data: response ,action: action, function: $function, pkgbar: $("[pkgbar]").attr("pkgbar"), pkglist: $("[pkglist]").attr("pkglist")}, function($Json){
						
								console.log($Json);
										
								$J = JSON.parse($Json);
								
								if($J.status == "success")
								{
									
									$("home").html("");
									$("home").html($J.html);
									clearTimeout(loadingTimer);
									hideLoading();	
									
								}							
							
							});

        		},
        
        		error: function(xhr, status, error) {
        	
				    	console.error("Error:", error);
				    	clearTimeout(loadingTimer);
							hideLoading();
				    	
       			}
        
    			});
    			
    			/*$("bar[pos=menu][go]").css("color", "white");
    			$("bar[pos=menu][go=" + $(this).attr("go") + "]").css("color", "orange");*/
				
				break;
			
			case "mix":
			
				var loadingTimer = setTimeout(showLoading, 500);
			
				$function = $(this).attr("function");
				
				var now = new Date();
				var hours = now.getHours();
        var minutes = now.getMinutes();
        
        hours = (hours < 10 ? '0' : '') + hours;
        minutes = (minutes < 10 ? '0' : '') + minutes;
        
        select = hours + minutes;
        
        if(800 <= select && 1559 >= select)
        {
        	
        	shift = "日班";
        	
        }else if(1600 <= select && 2359 >= select){
        	
        	shift = "晚班";
        	
        }else if(0 <= select && 759 >= select){
        	
        	shift = "夜班";
        	
        }
				
				if($("[mCode]").attr("mCode") == "ER" || $("[mCode]").attr("mCode") == "5310")
				{
					
					url = "https://192.168.1.195/api/NursingStationOracle/getPatientDataByNsCode";
					action = "Filter";
					requestData = "nsCode=" + $("[mCode]").attr("mCode");
					
				}else{
					
					url = "https://192.168.1.195/api/NursingStationOracle/SearchPatient";
					action = $(this).attr("action");
					requestData = "startDate=" + $("date").text() /*"2024-05-30"*/ + "&endDate=" + $("date").text() /*"2024-09-10"*/ + "&Shift=" + shift + "&NsCode=" + $("[mCode]").attr("mCode") + "&isGiven=false";
					//url = "https://192.168.1.195/api/NursingStationOracle/getPatientDataByNsCode";
					//requestData = "nsCode=" + $("[mCode]").attr("mCode");
					
				}
				
				$.ajax({
					
					url: url,
					method: "GET",
					contentType: "application/json",
					data: requestData,
					
					success: function(response) {
						
						console.log("success:", response);
						clearTimeout(loadingTimer);
						hideLoading();
						
						if($("[mCode]").attr("mCode") == "ER"  || $("[mCode]").attr("mCode") == "5310")
						{
							
							response = JSON.stringify(response);
							
						}
						
						if(response.message != "未找到符合條件的病患記錄。")
						{
							$.post("Function.php", {Data: response, action: action, function: $function, machine: $("space").attr("machine"), nsCode: $("[mcode]").attr("mcode")}, function($Json){
							
								console.log($Json);
								$J = JSON.parse($Json);
							
								if($J.status == "success")
								{
								
									if($function != "sreachPatient")
									{
								
										$("home").html("");
										$("home").html($J.html);
								
									}else{
								
										$("select[box=select][pos=ipd]").val("chartNo");
										$("select[box=select][pos=status]").val("false");
										$("select[box=select][pos=shift]").val("");
										$("input[type=date][name=start]").val($("date").text());
										$("input[type=date][name=end]").val($("date").text());
										$("roller[box=IDP]").html("");
										$("roller[box=IDP]").html($J.html);	
										$("error").text("");
										$("count").text($J.count);
								
									}
								
								}
							
							});
						}else{

							$.post("Function.php", {action: action, function: $function, pkgbar: $("[pkgbar]").attr("pkgbar"), pkglist: $("[pkglist]").attr("pkglist") , machine: $("space").attr("machine"), ip: $("ip").attr("ip"), nsCode: $("[mcode]").attr("mcode")}, function($Json){
						
								console.log($Json);
								$J = JSON.parse($Json);
								
								
								if($J.status == "success")
								{
								
									if($function != "sreachPatient")
									{
								
										$("home").html("");
										$("home").html($J.html);
								
									}else{
								
										$("select[box=select][pos=ipd]").val("chartNo");
										$("select[box=select][pos=status]").val("false");
										$("select[box=select][pos=shift]").val("");
										$("input[type=date][name=start]").val($("date").text());
										$("input[type=date][name=end]").val($("date").text());
										$("roller[box=IDP]").html("");
										$("roller[box=IDP]").html($J.html);	
										$("error").text("");
										$("count").text($J.count);
								
									}
								
								}							
							
							});

						}
												
					},
					
					error: function(xhr, status, error) {
        	
				    console.error("Error:", error);
				    clearTimeout(loadingTimer);
						hideLoading();
				    	
				    if($function == "mix")
				    {
				    		
				    	$.post("Function.php", {action: action, function: $function, pkgbar: $("[pkgbar]").attr("pkgbar"), pkglist: $("[pkglist]").attr("pkglist") , machine: $("space").attr("machine"), ip: $("ip").attr("ip"), nsCode: $("[mcode]").attr("mcode")}, function($Json){
						
								console.log($Json);
											
								$J = JSON.parse($Json);
								
								if($J.status == "success")
								{
									
									$("home").html("");
									$("home").html($J.html);	
									
								}							
							
							});
				    		
				    }else if($function == "sreachPatient"){
				    		
				    		$("select[box=select][pos=ipd]").val("chartNo");
								$("select[box=select][pos=status]").val("false");
								$("select[box=select][pos=shift]").val("");
								$("input[type=date][name=start]").val($("date").text());
								$("input[type=date][name=end]").val($("date").text());
				    		$("roller[box=IDP]").html("");
				    		$("count").text("0");
				    		
				    }

       		}
					
				});
			
				break;
				
			case "sign":
			
				var loadingTimer = setTimeout(showLoading, 500);
			
				option = $(this).attr("option");
				action = $(this).attr("action");
				$function = $(this).attr("function");
			
				switch($(this).attr("option"))
				{
					
					case "signOut":
					
						url = "https://192.168.1.195/api/Package/getCheckOutRecords";
					
						break;
						
					case "signIn":
					
						url = "https://192.168.1.195/api/Package/getCheckInRecords";
					
						break;
					
				}
				
				$.ajax({
   	 	
       		url: url,
       		method: "Get",
       		contentType: "application/json",
       		//data: testTube,
       		//data: JSON.stringify(testTube), //轉Json
        
      	 	success: function(response) {
        	
      	 		console.log("Success:", response);
      	 		clearTimeout(loadingTimer);
						hideLoading();
         		//$string = JSON.stringify(response);

         		$.post("Function.php", {Data: response, option: option, action: action, function: $function}, function($Json){ 
         			
         			console.log($Json);
         			$J = JSON.parse($Json);
         			
         			$("home").html("");
							$("home").html($J);

         		});
         	
         	},
         		
         	error: function(xhr, status, error) {
        	
				 		console.error("Error:", error);
				 		clearTimeout(loadingTimer);
						hideLoading();

       		}
         				
        });
         
        /*$("bar[pos=menu][go]").css("color", "white");
    		$("bar[pos=menu][option=" + $(this).attr("option") + "]").css("color", "orange");*/
			
				break;

			case "testTube":
			case "package":
			case "checkTubeAndPatient":
			case "set":
			
				console.log("test");

				$.post("Function.php", {action: $(this).attr("action"), function: $(this).attr("function"), pkgbar: $("[pkgbar]").attr("pkgbar"), pkglist: $("[pkglist]").attr("pkglist"), dicCode: $("[dicCode]").attr("dicCode"), mCode: $("[mCode]").attr("mCode"), dicName: $("[dicName]").attr("dicName"), ip: $("ip").attr("ip"), machine: $("space").attr("machine"), machineIP: $("[machineIP]").attr("machineIP"), otherIP: $("[otherIP]").attr("otherIP")}, function($Json){
					
					console.log($Json);
					$J = JSON.parse($Json);
					$("home").html("");
					$("home").html($J);	
					
				});
				
				/*$("bar[pos=menu][go]").css("color", "white");
				$("bar[pos=menu][go=" + $(this).attr("go") + "]").css("color", "orange");*/
	
				break;

			case "userOption":
			
				
				if($("userOP[box=userOP]").css("display") == "none")
				{
					
					$("userOP[box=userOP]").css("display", "block");
					
				}else{
					
					$("userOP[box=userOP]").css("display", "none");
					
				}
							
				break;
				
			case "logout":

				$.post("Function.php", {action: $(this).attr("action")}, function($Json){
					
					$J = JSON.parse($Json);
        	//console.log($J);	
					
					window.location.href = $J.url;
					
				});
			
				break;

		}
	
	});
	
	//用戶小視窗與修改密碼
	$(document).on("click", "userOP[box=close]", function(){
		
		$("userOP[box=userOP]").css("display", "none");
		
	});
	
	//右上角x關閉
	$(document).on("click", "[box=close]", function(){
		
		$("window[box=window]").html("");	
		$("window").css("display", "none");		
		$("mask[box=mask]").css("display", "none");

	});
	
	$(document).on("click", "userOP[box=change]", function(){
		
		//console.log($(this).attr("box"));	
		
		$.post("Function.php", {action: $(this).attr("action"), function: $(this).attr("function")}, function($Json){
		
			//console.log($Json);	
			
			$J = JSON.parse($Json);
			
			$("mask[box=mask]").css("display", "flex");
			$("window").css("display", "block");
			$("window[box=window]").html($J);	
			
		});
		
	});
	
	$(document).on("click", "message[pos=change]", function() {
		
  	  var requestData = {
  	  	
    	    userId: $("[name=username][pos=change]").val(),
      	  oldPassword: $("[name=old-password][pos=change]").val(),
        	newPassword: $("[name=new-password][pos=change]").val()
    	};
    	
    	//console.log(requestData);

   	 $.ajax({
   	 	
        url: "https://192.168.1.195/api/NursingStation/change_password",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(requestData),
        
        success: function(response) {
        	
            //console.log("Success:", response);
            
            if(response.message = "密碼修改成功")
            {
            	
            	$("message[box=change-error]").css("display", "block");
            	$("message[box=change-error]").css("color", "green");
            	$("message[box=change-error]").text("密碼修改成功，請重新登入，系統將會自動轉跳請耐心等候");
            	
            	setTimeout(function(){
            		
            		window.location.href = "http://192.168.1.173/";
            	
            	}, 2000);
            	
            }
            
        },
        
        error: function(xhr, status, error) {
        	
            console.error("Error:", error);
            
            $("message[box=change-error]").css("display", "block");
           	$("message[box=change-error]").css("color", "red");
            $("message[box=change-error]").text("密碼修改失敗");
            
        }
        
    	});
    	
	});

	//moreOption功能列
	$(document).on("click", "moreOption", function(){
		
		switch($(this).attr("pos"))
		{
			
			//呼叫細項功能列
			case "showOption":
			
				$button = $(this);
        dialog = $('[box=floating-dialog][name=' + $(this).attr("name") + ']');
 
        offset = $button.offset();
        
        dialog.css
        ({
        
            top: offset.top + $button.height(),
            left: offset.left
        
        });

				if($("more[box=floating-dialog][name=" + $(this).attr("name") + "]").css("display") == "none"){
					
					
					dialog.show();
					
				}else{
					
					$("more[box=floating-dialog][name=" + $(this).attr("name") + "]").css("display", "none");
					
				}
  
        break;
			
			//單筆備管
			case "barcode":

				//console.log($(this).attr("pos"));
				specimenSeq = $(this).attr("name");
				action = $(this).attr("action");

				Data = [];
	
				$("roller").find("table[seq=" + specimenSeq + "]").each(function(){
					
					var eachData = {};
					//console.log("test");

       		$(this).find("td[use]").each(function(){

						switch($(this).attr("use"))
						{
							
							case "labNo":
							
								aplseq = $(this).text();
								eachData[$(this).attr("use")] = $(this).text();
							
								break;
								
							case "specimenPan":
							
								//console.log($(this).attr("mCode"));
								tubeName = $(this).text();
								mCode = $(this).attr("mCode");
          			eachData["mCode"] = $(this).attr("mCode");
							
								break;
								
							case "chartNo":
							
								chartNo = $(this).text();
								
								break;
							
							case "bedNo":
							
								bedNo = $(this).text();
								
								break;
							
							case "specimenName":
							
								specimenName = $(this).text();

								break;
								
							case "ptName":
							case "subInitials":
							
								ptName = $(this).text();
								
								break;	
							
						}
           	
          });
          
          console.log(eachData);
					Data.push(eachData);
	
       	});
       	
       	IsLabelOnly = "printTube";
       	
       	console.log(Data);
       	console.log(IsLabelOnly);
       	
       	machine = $("[machine]").attr("machine");
       	ip = $("[machineIP]").attr("machineIP");
       					
				if($("[mCode]").attr("mCode") == "ER")
				{
					
					if($("input[type=checkbox][name=ER]").is(":checked"))
					{
						
						machine = "QQ";
						ip = $("[otherIP]").attr("otherIP");
						
					}
					
				}
       	
       	if(machine == "TMC")
       	{
       	
       		$.post("Function.php", {specimenSeq: specimenSeq, Data: Data, IsLabelOnly: IsLabelOnly, dicCode: $("[dicCode]").attr("dicCode"), action: "backup"}, function($Json){
       	
       			console.log($Json);
       			$J = JSON.parse($Json);
       		
       			//requestData = $J;
       			
       			if($J == "")
						{
					
							$("error").text("非網頁進行備管，無法重新列印");
					
						}
       			/**/
       			//以病歷號為單位呼叫API(配合單號備管)
       			for(let $i = 0; $i < $J.length; $i++)
       			{
       				
       				requestData = $J[$i];
       				console.log(requestData);
       				
       				$.ajax({
                	
             		url: "https://192.168.1.195/api/Robo7/processAndForward",
             		method: "POST",
             		contentType: "application/json",
             		data: JSON.stringify(requestData), //轉Json
             		success: function(response)
             		{
                    	
						console.log("Success:", response);
					
						$("error").text("重新備管成功");
                    
             		},
             		error: function(xhr, status, error)
						 		{
                    	
                	console.error("Error:", error);
                	if(xhr.status == 500)
				 					{
				 				
				 						$("error").text("TMC連線錯誤，重新備管失敗");
				 						//$("error").text("重新備管成功");
										$.post("Function.php", {action: "Plant", function: "showTMCError"}, function($Json){
													
													$("mask[box=mask]").css("display", "flex");
													$("window").css("display", "block");
													$("window[box=window]").html($J);
													
												});
				 					
				 					}else{
				 				
				 						$("error").text("重新備管失敗");
				 				
				 					}
                    
             		}
                    
          		});
       				
       			}
       		
       			/*$.ajax({
                	
             	url: "https://192.168.1.195/api/Robo7/processAndForward",
             	method: "POST",
             	contentType: "application/json",
             	data: JSON.stringify(requestData), //轉Json
             	success: function(response)
             	{
                    	
                console.log("Success:", response);
                $("error").text("重新備管成功");
                    
             	},
             	error: function(xhr, status, error)
						 	{
                    	
                console.error("Error:", error);
                if(xhr.status == 500)
				 				{
				 				
				 					$("error").text("TMC連線錯誤，重新備管失敗");
				 					//$("error").text("重新備管成功");
				 					
				 				}else{
				 				
				 					$("error").text("重新備管失敗");
				 				
				 				}
                    
             	}
                    
          	});*/
       	
       		});
      	
      	}else{
      		
      		requestData = { sid: specimenSeq,
      									 	ip: ip,
      									 	printCount: 1,
      									 	ptName: ptName,
      									 	chartNo: chartNo,
      									 	tubeName: tubeName,
      									 	bedNo: bedNo,
      									 	specimenName: specimenName,
      									 	aplseq: aplseq };
      									 	
      		console.log(requestData);
      									 	
      		$.ajax({
                	
             	url: "https://192.168.1.195/api/Barcode/reprintBarcode",
             	method: "POST",
             	contentType: "application/json",
             	data: JSON.stringify(requestData), //轉Json
             	success: function(response)
             	{
                    	
                console.log("Success:", response);
                $("error").text("重新備管成功");
                    
             	},
             	error: function(xhr, status, error)
						 	{
                    	
                console.error("Error:", error);
                $("error").text("重新備管失敗");
	                    
             	}
                    
          });
      		
      	}
			
				break;

			//展開細項	
			case "detial":
					
					
    			//detial with php
    			action = $(this).attr("action");
					name = $(this).attr("name");
					$function = $(this).attr("function");
					
					//console.log(name);

					switch($function)
					{
						
						case "Detial":
						
							if($("tr[box=title][name=" + name + "]").css("display") == "none"){
								
								requestData = { chartNo: name };
								
								$.ajax({
   	 	
       						url: "https://192.168.1.195/api/NursingStationOracle/getInfoByChartNo",
       						method: "POST",
       						contentType: "application/json",
       						data: requestData,
       						data: JSON.stringify(requestData), //轉Json
        
      	 					success: function(response) {
        	
      	 						console.log("success:", response);
         						//$string = JSON.stringify(response);
         			
         						$.post("Function.php", {Data: response, action: action, function: $function}, function($Json){ 
         							
         							console.log($Json);
         							$J = JSON.parse($Json);
            		
           						$("tr[box=title][name=" + name + "]").css("display", "table-row");
            					$("tr[box=title][name=" + name + "]").after($J);
            					$("tr[box=allTestTube][find=" + name + "]").css("color", "#0055FF");
            	
            					$("moreOption[pos=detial][name=" + name + "]").html("&#xf07c");
         							
         						});
         	
         					},
         		
         					error: function(xhr, status, error) {
        	
				 						console.error("Error:", error);

       						}
         				
         				});
					
								/*$.post("Function.php", {chartNo: name, action: action, function: $function}, function($Json){
						
									//console.log($Json);
									$J = JSON.parse($Json);
            		
           				$("tr[box=title][name=" + name + "]").css("display", "table-row");
            			$("tr[box=title][name=" + name + "]").after($J);
            			$("tr[box=allTestTube][find=" + name + "]").css("color", "#0055FF");
            	
            			$("moreOption[pos=detial][name=" + name + "]").html("&#xf07c");
					
								});*/
						
							}else{
						
								$("tr[box=title][name=" + name + "]").css("display", "none");
            		$("tr[clear=" + name + "]").html("");
           		 	$("tr[box=moreDetial][find=" + name + "]").css("display", "none");
            		$("tr[box=allTestTube][find=" + name + "]").css("color", "black");
            		$("tr[box=moreDetial][clear=" + name + "]").remove();
						
								$("moreOption[pos=detial][name=" + name + "]").html("&#xf07b");
						
							}
						
							break;
							
						case "ListB":
						
							if($("tr[pos=HisTube][name=" + name + "]").css("display") == "none")
							{
								
								$("tr[pos=HisTube][name=" + name + "]").css("display", "table-row");
								$("moreOption[pos=detial][name=" + name + "]").html("&#xf07c");
								
							}else{
								
								$("tr[pos=HisTube][name=" + name + "]").css("display", "none");
								$("moreOption[pos=detial][name=" + name + "]").html("&#xf07b");
								
							}
						
							break;
							
						case "testTube":
						
							if($("labInfo[number=" + $(this).attr("number") + "][name=" + name + "]").css("display") == "none")
							{
								
								$("labInfo[number=" + $(this).attr("number") + "][name=" + name + "]").css("display", "grid");
								$("moreOption[pos=detial][number=" + $(this).attr("number") + "][name=" + name + "]").html("&#xf07c");
								
							}else{
								
								$("labInfo[number=" + $(this).attr("number") + "]").css("display", "none");
								$("moreOption[pos=detial][number=" + $(this).attr("number") + "][name=" + name + "]").html("&#xf07b");
								
							}
						
					}

				break;
				
			case "moreDetial":
							
				action = $(this).attr("action");
				name = $(this).attr("name");
				$function = $(this).attr("function");
				
				requestData = {chartNO: $(this).attr("find")};
				
				console.log(requestData);
				
				if($("tr[box=moreDetial][pos=title][name=" + name + "]").css("display") == "none"){
				
					$.ajax({
   	 	
        		url: "https://192.168.1.195/api/NursingStationOracle/getLabOrdersDetails",
        		method: "POST",
        		contentType: "application/json",
        		data: requestData,
        		data: JSON.stringify(requestData), //轉Json
        
        		success: function(response) {
        	
            	console.log("Success:", response);
            	response = JSON.stringify(response);
            	
            		$.post("Function.php", {Data: response, labNo: name, action: action, function: $function}, function($Json){
            		            		
            			console.log($Json);
            			$J = JSON.parse($Json);
            			//console.log($J);
            		
            			$("tr[box=moreDetial][pos=title][name=" + name + "]").css("display", "table-row");
            			$("tr[box=moreDetial][pos=title][name=" + name + "]").after($J);
            		
            		});
            	
        		},
        
        		error: function(xhr, status, error) {
        	
				    	console.error("Error:", xhr.responseText);

    	   		}
        
    			});
    			
    		}else{
    			
    			console.log(name);
    			$("tr[box=moreDetial][name=" + name + "]").css("display", "none");
    			//$("tr[box=moreDatial][pos=title][name=" + $(this).attr("name") + "]").css("display")
    			//$("tr[box=moreDetial][pos=moreDetial][number=" + number + "]").html("");
    			
    		}
				

				break;
				
				//舊版病患被管的刪除給號
				/*case "deleteBarcode":
				
					switch($(this).attr("option"))
					{
					
						case "OneData":
						
							requestData = {labNo: $(this).attr("name")};
							console.log(JSON.stringify(requestData));
							
							$.ajax({
   	 	
       					url: "https://192.168.1.195/api/Barcode/cancelGeneratedBarcode",
       					method: "POST",
      					contentType: "application/json",
       					data: requestData,
       					data: JSON.stringify(requestData), //轉Json
        
       					success: function(response) {
        	
      	 					console.log("Success:", response);
         					$("error").text("刪除成功");
            
       					},
        
      		 			error: function(xhr, status, error) {
        	
				 					console.error("Error:", error);

       					}
        
    					});
						
							break;
						
						case "PluralData":
						
							console.log($(this).attr("name"));
							
							getLabNo = { chartNo: chartNo }
         						
         			$.ajax({
   	 	
       					url: "https://192.168.1.195/api/NursingStationOracle/getInfoByChartNo",
       					method: "POST",
       					contentType: "application/json",
       					data: getLabNo,
       					data: JSON.stringify(getLabNo), //轉Json
        
      	 				success: function(list) {
        	
      	 					console.log("list:", list);
         					//$string = JSON.stringify(response);
         			
         					for(let $j = 0; $j < list.length; $j++)
         					{
		
										test = list[$j].labNo;
										console.log(test);

        						requestData = {labNo: test};
										console.log(JSON.stringify(requestData));
							
										$.ajax({
   	 	
       								url: "https://192.168.1.195/api/Barcode/cancelGeneratedBarcode",
       								method: "POST",
      								contentType: "application/json",
       								data: requestData,
       								data: JSON.stringify(requestData), //轉Json
        
       								success: function(response) {
        	
      	 								console.log("Success:", response);
         								$("error").text("刪除成功");
            
       								},
        
      		 						error: function(xhr, status, error) {
        	
				 								console.error("Error:", error);

       								}
        
    								});

    							}
								}
						
							});
						
							break;
						
					}

					break;*/
				
				//移除資料
				case "remove":

					switch($(this).attr("option"))
					{
						
						//打包資料移除
						case "pan":

         			switch($(this).attr("mCode"))
         			{
         				
         				case "01":
         				
         					old = parseInt($("[box=grey][pos=number]").text());
         					current =  old - 1;
         					$("[box=grey][pos=number]").text(current);
         				
         					break;
         					
         				case "02":
         				
         					/*old = parseInt($("[box=red][pos=number]").text());
         					current =  old - 1;
         					$("[box=red][pos=number]").text(current);
         				
         					break;*/
         					
         				case "03":
         				
         					old = parseInt($("[box=yellow][pos=number]").text());
         					current =  old - 1;
         					$("[box=yellow][pos=number]").text(current);
         				
         					break;
         					
         				case "04":
         				
         					old = parseInt($("[box=purple][pos=number]").text());
         					current =  old - 1;
         					$("[box=purple][pos=number]").text(current);
         				
         					break;
         					
        				case "05":
         				
        					old = parseInt($("[box=green][pos=number]").text());
         					current =  old - 1;
         					$("[box=green][pos=number]").text(current);
         				
         					break;
         					
      					case "06":
         				
        					old = parseInt($("[box=blue][pos=number]").text());
         					current =  old - 1;
         					$("[box=blue][pos=number]").text(current);
         				
         					break;
         						
         				case "07":
         					
         					old = parseInt($("[box=urine][pos=number]").text());
         					current =  old - 1;
         					$("[box=urine][pos=number]").text(current);
 
 	        				break;
  	       						
    	     			default:
         					
      	   				old = parseInt($("[box=other][pos=number]").text());
        	 				current =  old - 1;
         					$("[box=other][pos=number]").text(current);
         					
         					break;
         				
         			}	

							console.log($(this).attr("name"));
							
							$.post("Function.php", {action: "deleteRecode", dicCode: $("[dicCode]").attr("dicCode"), labNo: $(this).attr("name"), option: $(this).attr("option")}, function($Json){
								
								console.log($Json);
								
							});
							
							break;
							
						//刪除條碼
						/*case "deleteBarcode":
						
							labNo = $(this).attr("name");
							specimenSeq = $(this).attr("seq");
							
							$.post("Function.php", {action: "checkDelete", option: $(this).attr("option"), specimenSeq: specimenSeq}, function($Json){
								
								console.log($Json);
								$J = JSON.parse($Json);
								
								if($J.status == null)
								{
									
									requestData = { labNo: labNo,
																  sid: specimenSeq };
									console.log(JSON.stringify(requestData));
												
									$.ajax({
   	 	
       							url: "https://192.168.1.195/api/Barcode/cancelGeneratedBarcode",
       							method: "POST",
      							contentType: "application/json",
       							data: requestData,
       							data: JSON.stringify(requestData), //轉Json
        
       							success: function(response) {
        	
      	 							console.log("Success:", response);
         							$("error").text("刪除成功");
         							$("table[name=" + labNo + "]").remove();
            
       							}
        
    							});
									
								}else{
									
									$("error").text("此管已打包，無法刪除");
									
								}
								
							});

							break;*/
							
							//備管資料刪除
							case "testTube":
							
								//$("labInfo[number=" + $(this).attr("number") + "][name=" + $(this).attr("name") + "]").remove();
								$("labInfo[name=" + $(this).attr("name") + "]").remove();
								
							break;

					}
					
					//畫面上移除被刪除的資料
					
					$("table[name=" + $(this).attr("name") + "]").remove();

					/*if($(this).attr("number"))
					{
							
						$("table[name=" + $(this).attr("name") + "][number=" + $(this).attr("number") + "]").remove();
						
					}else{
						
						$("table[name=" + $(this).attr("name") + "]").remove();
						
					}*/

					break;
					
				//移除小包或小包管子資料
				case "delete":
				
					/*console.log($(this).attr("name"));
					console.log($(this).attr("unicode"));*/
					
					switch($(this).attr("action"))
					{
						
						//刪除小包
						case "delPackage":
						
							listUnicode = $(this).attr("unicode");
							listNo = $(this).attr("name");
							action = $(this).attr("action");
							
							requestData = { listUnicode: listUnicode,
															listNo: listNo,
															ordUnicode: listNo };
							
							$.post("Function.php", {action: "checkDelete", option: action, Data: listNo}, function($Json){
							
									console.log($Json);
									$J = JSON.parse($Json);
									
									if($J.status == "1" || $J.status == null)
									{
										$.ajax({
   	 	
       								url: "https://192.168.1.195/api/Package/cancelPackage",
       								method: "POST",
      								contentType: "application/json",
       								data: requestData,
       								data: JSON.stringify(requestData), //轉Json
        
       								success: function(response) {
        	
        								/*$.post("Function.php", {listUnicode: listUnicode, listNo: listNo, action: action}, function($Json){
									
													$("tr[pos=HistoryPackage][name=" + listNo + "][unicode=" + listUnicode + "]").remove();
													$("tr[pos=HisTube][name=" + listNo + "]").remove();
								
												});*/
							
        								$.post("Function.php", {action: "updateDeleteStatus", status: "1", Data: listNo}, function($Json){
        								
        									console.log($Json);
        									
        								});
        								
        								$("tr[pos=HistoryPackage][name=" + listNo + "][unicode=" + listUnicode + "]").remove();
												$("tr[pos=HisTube][name=" + listNo + "]").remove();
        	
      	 								console.log("Success:", response);
         								$("error").text("刪除成功");
            
       								},
        
      		 						error: function(xhr, status, error) {
        	
				 								console.error("Error:", error);

       								}
        
    								});
    							
    							}else{
    								
    								$("error").text("此包已送出，無法刪除");
    								
    							}
    				
    							
    					});

							break;
						
						//刪除小包管子
						case "delTube":
						
							action = $(this).attr("action");
							specimenSeq = $(this).attr("name");
							listUnicode = $(this).attr("unicode");
							ordUnicode = $(this).attr("ordUnicode");
							
							$.post("Function.php", {action: "checkDelete", option: action, specimenSeq: specimenSeq, listNo: ordUnicode}, function($Json){
							
								console.log($Json);
								$J = JSON.parse($Json);
							
								if($J.status == "1")
								{
								
									$.post("Function.php", {action: action}, function($Json){
								
										console.log($Json);	
										$J = JSON.parse($Json);
								
										requestData = { listUnicode: listUnicode,
																		specimenSeq: specimenSeq, 
																		ordUnicode: ordUnicode, 
																		listNo: ordUnicode,
																		orderCount: $J };
																
										console.log(requestData);
																
										$.ajax({
   	 	
     		  						url: "https://192.168.1.195/api/Package/deleteListBData",
       								method: "POST",
      								contentType: "application/json",
       								data: requestData,
       								data: JSON.stringify(requestData), //轉Json
        
       								success: function(response) {
        	
      	 								console.log("Success:", response);
         								//$("error").text("刪除成功");
         						
         								console.log("tr[pos=HistoryPackage][name=" + ordUnicode + "]");
         						
         								$("tr[pos=HistoryPackage][name=" + ordUnicode + "]").find("td[use=orderCount], td[use=tubeCount]").each(function(){
											
													//console.log("test");

													old = parseInt($(this).text());
													current =  old - 1;
													$(this).text(current); 
											
													console.log($(this).attr("use"));
								
												});
												
												$.post("Function.php", {action: "updateDeleteStatus", Data: ordUnicode, specimenSeq: specimenSeq, status: "0"}, function($Json){
												
													console.log($Json);	
													
												});
 
       								},
        
      		 						error: function(xhr, status, error) {
        	
				 								console.error("Error:", error);

       								}
        
    								});		
								
									});
							
									$("tr[pos=HisTube][name=" + ordUnicode + "][clear=" + specimenSeq + "][unicode=" + listUnicode + "]").remove();
								
								}else{
									
									$("error").text("此管已送出，無法刪除");
									
								}
							
							});

							break;
						
					}
				
					break;
					
				//更新小包
				case "update":
				
					listUnicode = $(this).attr("unicode");
					listNo = $(this).attr("name");

					$("more[box=floating-dialog][name=" + listNo + "]").css("display", "none");

					$.post("Function.php", {listUnicode: listUnicode, listNo: listNo, action: $(this).attr("action"), function: $(this).attr("function")}, function($Json){
						
						console.log($Json);
						$J = JSON.parse($Json);
						$("mask[box=mask]").css("display", "flex");
						$("window").css("display", "block");
						$("window[box=window]").html($J);
						
					});
					
					break;
					
				//重新列印清單
				case "printlist":

					listUnicode = $(this).attr("unicode");
					listNo = $(this).attr("name");
					action = $(this).attr("action");
					option = $(this).attr("option");
					$function = $(this).attr("function");
					
					machine = $("[machine]").attr("machine");
					ip = $("[machineIP]").attr("machineIP");
				
					if($("[mCode]").attr("mCode") == "ER")
					{
					
						if($("input[type=checkbox][name=ER]").is(":checked"))
						{
						
							machine = "QQ";
							ip = $("[otherIP]").attr("otherIP");
						
						}
					
					}
					
					$("more[box=floating-dialog][name=" + listNo + "]").css("display", "none");
					
					if($("input[box=barcheck]").is(":checked"))
					{
								
						if(machine == "TMC")
						{
										
							$.post("Function.php", {listNo: listNo, userid: $("[go=userOption]").attr("userid"), dicCode: $("[dicCode]").attr("dicCode"), action: "TMCbarcode"}, function($Json){
								
								console.log($Json);	
								$J = JSON.parse($Json);
								
								requestData = $J;
								
								$.ajax({
   	 	
    		   				url: "https://192.168.1.195/api/Robo7/printPackageLabel",
       						method: "POST",
       						contentType: "application/json",
       						data: requestData,
       						data: JSON.stringify(requestData), //轉Json
        
      	 					success: function(response) {
        	
      	 						console.log("Success:", response);
         						//$string = JSON.stringify(response);
            
       						},
        
       						error: function(xhr, status, error) {
        	
				 						console.error("Error:", error);

       						}
        
    						});
								
							});
								
						}else{
										
							requestData = { listNo: listNo, 
															ip: ip,
															printCount: 1 };
																		
							console.log(requestData);
								
							$.ajax({
   	 	
    		   			url: "https://192.168.1.195/api/Package/generateFilesForListNo",
       					method: "POST",
       					contentType: "application/json",
       					data: requestData,
       					data: JSON.stringify(requestData), //轉Json
        
      	 				success: function(response) {
        	
      	 					console.log("Success:", response);
         					//$string = JSON.stringify(response);
            
       					},
        
       					error: function(xhr, status, error) {
        	
				 					console.error("Error:", error);

       					}
        
    					});
										
						}
								
					}
					
					if($("input[box=listcheck]").is(":checked"))
					{
						
						var loadingTimer = setTimeout(showLoading, 0);
					
						requestData = { listUnicode: listUnicode,
														ordUnicode: listNo };
						
						console.log(requestData);
						
						$.ajax({
   	 	
       				url: "https://192.168.1.195/api/Package/addtoPrint",
       				method: "POST",
       				contentType: "application/json",
       				data: requestData,
       				data: JSON.stringify(requestData), //轉Json
        
      				success: function(response) {
        	
      					console.log("Success:", response);
      					response = JSON.stringify(response);
         				$.post("Function.php", {Data: response, username: $("[go=userOption]").text(), dicCode: $("[dicCode]").attr("dicCode"), option: option, action: action, function: $function, listNo: listNo, listUnicode: listUnicode}, function($Json){
						
									console.log($Json);	
									$J = JSON.parse($Json);
						
									var btype = "code128";
									var value = listNo;
						
									$("mask[box=mask]").css("display", "flex");
									$("window").css("display", "block");
									$("window[box=window]").html($J.html);
									$("message[box=barcode]").html("").show().barcode(value, btype);

									console.log($J.specimenSeq[0]);

									for(let $i = 0; $i < $J.specimenSeq.length; $i++)
									{
										
										console.log($J.specimenSeq[$i]);			
										$("td[use=barcode][number=" + $i + "]").html("").show().barcode($J.specimenSeq[$i], btype);
													
									}
									
									clearTimeout(loadingTimer);
									hideLoading();
				
								});
            
       				},
        
       				error: function(xhr, status, error) {
        	
								console.error("Error:", error);
								clearTimeout(loadingTimer);
								hideLoading();

       				}
        
    				});
							
					}
					
					break;
					
				//歷史退簽
				case "reSign":
				
					name = $(this).attr("name");
					userid = $("[go=userOption]").attr("userid");
					username = $("[go=userOption]").text();
					
					switch($(this).attr("option"))
					{
						
						case "signOut":
						
							url = "https://192.168.1.195/api/Package/cancelCheckOut";
							status = "2"
							error = "此包已送達，退簽失敗";
						
							break;
							
						case "signIn":
						
							url = "https://192.168.1.195/api/Package/cancelCheckIn";
							status = "3";
							error = "退簽失敗";
						
							break;
						
					}
					
					requestData = { listNo: name,
													modifyMan: userid, 
													modifyname: username };
													
					console.log(status);
					
					$.post("Function.php", {action: "checkDelete", option: option, Data: name}, function($Json){
						
						console.log($Json);
						$J = JSON.parse($Json);
						
						if($J.status == status)
						{
							
							$.ajax({
   	 	
       					url: url,
       					method: "POST",
       					contentType: "application/json",
       					data: requestData,
       					data: JSON.stringify(requestData), //轉Json
        
      	 				success: function(response) {
        	
      	 					console.log("Success:", response);
      	 					$("error").text("退簽成功");
         					
         					$.post("Function.php", {action: "updateDeleteStatus", status: status, Data: name}, function($Json){
         						
         						console.log($Json);
         						
         					});
            
       					},
        
       					error: function(xhr, status, error) {
        	
				 					console.error("Error:", error);

       					}
        
    					});
    			
    					$("tr[name=" + name + "]").remove();
							
						}else{
							
							$("error").text(error);
							
						}
							
						
					});

					break;
					
				case "deleteBarcode":
				
					console.log($(this).attr("name"));
					
					$.post("Function.php", {action: "Plant", function: "checkDelete", labNo: $(this).attr("name")}, function($Json){
  	
  					console.log($Json);
  					$J = JSON.parse($Json);	
  		
  					$("mask[box=mask]").css("display", "flex");
						$("window").css("display", "block");
						$("window[box=window]").html($J);
  		
  				});
									
					break;
			
		}

	});
	
	//查詢
	$(document).on("click", "s-button[box=button][pos=search]", function(){
		
		//requestData = { data: $("input[box=search]").val() };
		//console.log($("input[box=search]").val());	
		
		switch($(this).attr("function"))
		{
			
			//病患備管查詢
			case "sreachPatient":
			
				var loadingTimer = setTimeout(showLoading, 500);
			
				action = $(this).attr("action");
				$function = $(this).attr("function");
				shift = $("select[box=select][pos=shift]").val();
				NsCode = $("[mcode]").attr("mcode");
		
				requestData = $("select[pos=ipd]").val() + "=" + $("input[box=search]").val() + "&startDate=" + $("input[type=date][name=start]").val() + "&endDate=" + $("input[type=date][name=end]").val() + "&Shift=" + shift + "&NsCode=" + NsCode + "&isGiven=false";

				console.log(requestData);
					
				$.ajax({
   	 	
       		url: "https://192.168.1.195/api/NursingStationOracle/SearchPatient",
      	 	method: "GET",
       		contentType: "application/json",
       		data: requestData,
       		//data: JSON.stringify(requestData), //轉Json
        
       		success: function(response) {
        	
      	 		console.log("Success:", response);
				
         		clearTimeout(loadingTimer);
						hideLoading();
        
				//console.log(response.message);
		
				if(response.message != "No matching patient records found."){
		
					response = JSON.stringify(response);
		
					$.post("Function.php", {action: action, function: $function, Data: response, option: "search"}, function($Json){
						
							console.log($Json);		
							$J = JSON.parse($Json);
							
							if($J.status == "success")
							{
								
								$("roller[box=IDP]").html("");
								$("roller[box=IDP]").html($J.html);	
								$("error").text("");
								$("count").text($J.count);
								
							}else{
								
								$("roller[box=IDP]").html("");
								$("error").text("查無資料");
								$("count").text("0");
								
							}

				 		});
				}else{
					
					$("roller[box=IDP]").html("");
				 	$("error").text("查無資料");
				 	$("count").text("0");
					
				}
       		},
        	
       		error: function(xhr, status, error) {
       			
       			clearTimeout(loadingTimer);
						hideLoading();
        	
				 		console.error("Error:", error);
						$("roller[box=IDP]").html("");
				 		$("error").text("查無資料");
				 		$("count").text("0");

       		}
        
    		});
			
				break;
			
			//歷史打包查詢
			case "HistoryPackage":
				
					var loadingTimer = setTimeout(showLoading, 500);
				
					action = $(this).attr("action");
					$function = $(this).attr("function");
					startDay = $("input[type=date][name=start]").val();
					endDay = $("input[type=date][name=end]").val();
					
					requestData = $("select[pos=search]").val() + "=" + $("input[box=search]").val() + "&startDate=" + startDay + "&endDate=" + endDay;

					console.log(requestData);
					
					$.ajax({
   	 	
       			url: "https://192.168.1.195/api/Package/searchData",
      	 		method: "GET",
       			contentType: "application/json",
       			data: requestData,
       			//data: JSON.stringify(requestData), //轉Json
        
       			success: function(response) {
        	
        			clearTimeout(loadingTimer);
							hideLoading();
      	 			console.log("Success:", response);
         			//$string = JSON.stringify(response);
        
         			$.post("Function.php", {action: action, function: $function, pkgbar: $("[pkgbar]").attr("pkgbar"), pkglist: $("[pkglist]").attr("pkglist"), machine: $("space").attr("machine"), Data: response }, function($Json){
						
								//console.log($Json);
								$J = JSON.parse($Json);
								
								if($J.status == "success")
								{
								
									$("home").html("");
									$("home").html($J.html);	
								
								}else{
								
									$("error").text("查無資料");
									$("roller[box=HistoryPackage]").html("");
								
								}
								
				 			});
            
       			},
        	
       			error: function(xhr, status, error) {
        	
        			clearTimeout(loadingTimer);
							hideLoading();
				 			console.error("Error:", error);

       			}
        
    			});
				
					break;
					
				//簽入簽出查詢
				case "sign":
				
					var loadingTimer = setTimeout(showLoading, 500);
				
					startDay = $("input[type=date][name=start]").val();
					endDay = $("input[type=date][name=end]").val();
					
					action = $(this).attr("action");
					option = $(this).attr("option");
					$function = $(this).attr("function");
				
					switch($(this).attr("option"))
					{
						
						case "signOut":
						
							url = "https://192.168.1.195/api/Package/getCheckOutRecords";
						
							break;
							
						case "signIn":
						
							url	= "https://192.168.1.195/api/Package/getCheckInRecords";
						
							break;
						
					}
					
					requestData = "StartDate=" + startDay + "&EndDate=" + endDay;
					
					$.ajax({
   	 	
       			url: url,
      	 		method: "GET",
       			contentType: "application/json",
       			data: requestData,
       			//data: JSON.stringify(requestData), //轉Json
        
       			success: function(response) {
        	
      	 			console.log("Success:", response);
      	 			clearTimeout(loadingTimer);
							hideLoading(); 
         			//$string = JSON.stringify(response);
        
         			$.post("Function.php", {option: option, action: action, function: $function, Data: response }, function($Json){
						
								//console.log($Json);
								$J = JSON.parse($Json);

									$("home").html("");
									$("home").html($J);	
	
				 			});
            
       			},
        	
       			error: function(xhr, status, error) {
        	
        			clearTimeout(loadingTimer);
							hideLoading(); 
				 			console.error("Error:", error);

       			}
        
    			});
				
					break;
					
				//備管歷史查詢
				case "HisTestTube":
				
					var loadingTimer = setTimeout(showLoading, 500);
				
					startDay = $("input[type=date][name=start]").val();
					endDay = $("input[type=date][name=end]").val();
					input = $("input[box=search]");
					
					action = $(this).attr("action");
					$function = $(this).attr("function");
					
					requestData =  $("select").val() + "=" + $("input[box=search]").val() + "&StartDate=" + startDay + "&EndDate=" + endDay + "&nsCode=" + $("[mcode]").attr("mcode");
					
					console.log(requestData);
					
					$.ajax({
   	 	
       			url: "https://192.168.1.195/api/NursingStationOracle/getHistoricalLabRecords",
      	 		method: "GET",
       			contentType: "application/json",
       			data: requestData,
       			//data: JSON.stringify(requestData), //轉Json
        
       			success: function(response) {
        	
      	 			console.log("Success:", response);
         			response = JSON.stringify(response);
         			
         			clearTimeout(loadingTimer);
							hideLoading();
        
         			$.post("Function.php", { action: action, function: $function, Data: response, dicCode: $("[mCode]").attr("mCode") }, function($Json){
						
								console.log($Json);
								$J = JSON.parse($Json);
								console.log($J);

									$("home").html("");
									$("home").html($J.html);	
	
				 			});
            
       			},
        	
       			error: function(xhr, status, error) {
       				
       				clearTimeout(loadingTimer);
							hideLoading();
        	
				 			$.post("Function.php", { action: action, function: $function }, function($Json){
						
								console.log($Json);
								$J = JSON.parse($Json);
								console.log($J);

								$("home").html("");
								$("home").html($J.html);	
	
				 			});

       			}
        
    			}); 
				
					break;
			
		}
		
	});
	
	//enter查詢
	$(document).on("keypress", "input[box=search]", function(){
		
		if(event.which == "13")
		{
			
			input = $(this).val();
			action = $(this).attr("action");
			$function = $(this).attr("function");
			
			switch($(this).attr("pos"))
			{
				
				case "mix":
				
					var loadingTimer = setTimeout(showLoading, 500);

					shift = $("select[box=select][pos=shift]").val()
					NsCode = $("[mcode]").attr("mcode");;
		
					requestData = $("select[pos=ipd]").val() + "=" + input + "&startDate=" + $("input[type=date][name=start]").val() + "&endDate=" + $("input[type=date][name=end]").val() + "&Shift=" + shift + "&NsCode=" + NsCode + "&isGiven=" + $("select[pos=status]").val();

					console.log(requestData);
					
					$.ajax({
   	 	
       			url: "https://192.168.1.195/api/NursingStationOracle/SearchPatient",
      	 		method: "GET",
       			contentType: "application/json",
       			data: requestData,
       			//data: JSON.stringify(requestData), //轉Json
        
       			success: function(response) {
        	
      	 			console.log("Success:", response);
         			response = JSON.stringify(response);
         			
         			clearTimeout(loadingTimer);
							hideLoading(); 
        
         			$.post("Function.php", {action: action, function: $function, Data: response, option: "search"}, function($Json){
						
								console.log($Json);		
								$J = JSON.parse($Json);
							
								if($J.status == "success")
								{

									$("roller[box=IDP]").html("");
									$("roller[box=IDP]").html($J.html);	
									$("error").text("");
									$("count").text($J.count);
								
								}else{
								
									$("roller[box=IDP]").html("");
									$("error").text("查無資料");
									$("count").text("0");
								
								}

				 			});
            
       			},
        	
       			error: function(xhr, status, error) {
        	
        			clearTimeout(loadingTimer);
							hideLoading(); 
        	
				 			console.error("Error:", error);
							$("roller[box=IDP]").html("");
				 			$("error").text("查無資料");
				 			$("count").text("0");

       			}
        
    			});
    			
    			$("input[box=search]").val("");
				
					break;
					
				case "HisTestTube":
				
					var loadingTimer = setTimeout(showLoading, 500);
				
					startDay = $("input[type=date][name=start]").val();
					endDay = $("input[type=date][name=end]").val();

					requestData =  $("select").val() + "=" + input + "&StartDate=" + startDay + "&EndDate=" + endDay + "&nsCode=" + $("[mcode]").attr("mcode");
					
					console.log(requestData);
					
					$.ajax({
   	 	
       			url: "https://192.168.1.195/api/NursingStationOracle/getHistoricalLabRecords",
      	 		method: "GET",
       			contentType: "application/json",
       			data: requestData,
       			//data: JSON.stringify(requestData), //轉Json
        
       			success: function(response) {
        	
      	 			console.log("Success:", response);
         			response = JSON.stringify(response);
         			clearTimeout(loadingTimer);
							hideLoading(); 
        
         			$.post("Function.php", { action: action, function: $function, Data: response }, function($Json){
						
								console.log($Json);
								$J = JSON.parse($Json);
								console.log($J);

									$("home").html("");
									$("home").html($J.html);	
	
				 			});
            
       			},
        	
       			error: function(xhr, status, error) {
       				
       				clearTimeout(loadingTimer);
							hideLoading(); 
        	
				 			$.post("Function.php", { action: action, function: $function }, function($Json){
						
								console.log($Json);
								$J = JSON.parse($Json);
								console.log($J);

								$("home").html("");
								$("home").html($J.html);	
	
				 			});

       			}
        
    			}); 
				
					break;
					
				case "HisPackage":
				
					var loadingTimer = setTimeout(showLoading, 500);
				
					startDay = $("input[type=date][name=start]").val();
					endDay = $("input[type=date][name=end]").val();
					
					requestData = $("select[pos=search]").val() + "=" + input + "&startDate=" + startDay + "&endDate=" + endDay;

					console.log(requestData);
					
					$.ajax({
   	 	
       			url: "https://192.168.1.195/api/Package/searchData",
      	 		method: "GET",
       			contentType: "application/json",
       			data: requestData,
       			//data: JSON.stringify(requestData), //轉Json
        
       			success: function(response) {
        	
      	 			console.log("Success:", response);
         			//$string = JSON.stringify(response);
         			
         			clearTimeout(loadingTimer);
							hideLoading();
        
         			$.post("Function.php", {action: action, function: $function, pkgbar: $("[pkgbar]").attr("pkgbar"), pkglist: $("[pkglist]").attr("pkglist"), machine: $("space").attr("machine"), Data: response }, function($Json){
						
								//console.log($Json);
								$J = JSON.parse($Json);
								
								if($J.status == "success")
								{
								
									$("home").html("");
									$("home").html($J.html);	
								
								}else{
								
									$("error").text("查無資料");
									$("roller[box=HistoryPackage]").html("");
								
								}
								
				 			});
            
       			},
        	
       			error: function(xhr, status, error) {
        	
        			clearTimeout(loadingTimer);
							hideLoading();
				 			console.error("Error:", error);

       			}
        
    			});
				
					break;
				
			}
			
		}
		
	});

	//各作業之主要按鈕功能
	$(document).on("click", "home[box=button]", function(){ 
		
		switch($(this).attr("pos"))
		{
			
			//掃描備管的確認輸入
			case "intoTestTube":
			
				input = $("input[box=scan]").val().trim();
				input = input.toUpperCase();
				action = $(this).attr("action");
				$function = $(this).attr("function");
											
				console.log(input);							
				
				if($("td[use=number]").last().text() == "")
				{
						
					number = 1;
						
				}else{
						
					console.log($("td[use=number]").text());
					number = parseInt($("td[use=number]").last().text()) + 1;
						
				}

				store = $(this).attr("store");
				console.log(store);

				labNo = input;
					
				requestData = {labNo: labNo};
					
				console.log(requestData);
					
				$.ajax({
   	 	
       		url: "https://192.168.1.195/api/NursingStationOracle/getLabOrderDetailsByLabNo",
       		method: "POST",
       		contentType: "application/json",
     			data: requestData,
       		data: JSON.stringify(requestData), //轉Json
        
       		success: function(response) {
        	
      	 		console.log("Success:", response);
					
				const matchedLabNos = new Set(); //用來存放重複的資料

				const allLabNo = document.querySelectorAll('td[use="labNo"]'); //儲存所有labNo

				allLabNo.forEach(cell => { //歷遍labNo
            
					const labNo = cell.textContent.trim();
					// 如果 cell 的 labNo 在 response 中
            
					if (response.some(item => item.labNo === labNo)) {
					
						console.log("找到匹配的 labNo:", labNo);
						//cell.style.backgroundColor = 'yellow'; // 顯示重複
						matchedLabNos.add(labNo); //將匹配的labNo放入陣列
					}
				});

				const filteredResponse = response.filter(item => !matchedLabNos.has(item.labNo)); //捨棄重複資料

				console.log("filteredResponse:", filteredResponse);

				const ResponseJson = JSON.stringify(filteredResponse);
         			
         		$.post("Function.php", {Data: ResponseJson, labNo: input, number: number, action: action, store: store, function: $function}, function($Json){

							console.log($Json);	
         			$J = JSON.parse($Json);
         			//console.log($J);
         				
         			if($J.status == "success")
         			{
         					
         				$("roller[box=testTube]").append($J.html);
         				$("error").text("");
         				scrollToBottom();
         					
         			}else{
         					
         				$("error").text("重複刷單");
         					
        			}		

						});
         	
         	},
         		
         	error: function(xhr, status, error) {
        	
				 		console.error("Error:", error);
				 		$("error").text("錯誤的條碼或無此筆資料");

       		}
         				
        });
			
				$("[box=scan]").val("");

				break;
			
			//多筆備管
			case "testTube":
			
        var Data = [];
        //pos = $(this).attr("pos");

				//Type: checkbox
				/*$("input[box=checkbox]:checked").each(function(){
       			
       		var eachData = {};

       		$("table[number=" + $(this).attr("number") + "]").find("td[use=labNo], td[use=specimenPan]").each(function(){
 
            if($(this).attr("use") == "specimenPan")
            {
            	
            	eachData["mCode"] = $(this).attr("mCode");
            	
            }else{
            	
            	eachData[$(this).attr("use")] = $(this).text();
            	
            }

        	});
        		
        	Data.push(eachData);

       	});*/
       	
       	$("roller[box=testTube]").find("table").each(function(){
       		
       		//console.log("yes");
       		var eachData = {};
       		
       		$(this).find("td[use=labNo], td[use=specimenPan]").each(function(){
       				
       				
       			if($(this).attr("use") == "specimenPan")
           	{
            	
           		console.log($(this).attr("mCode"));
          		eachData["mCode"] = $(this).attr("mCode");
           	
         		}else{
           	
           		eachData[$(this).attr("use")] = $(this).text();
            	
           	}
	
       		});
       		
        	console.log(eachData);
					Data.push(eachData);       		
       		
       	});
       	
        //Data.push(eachData);
        console.log(Data);
        
        machine = $("[machine]").attr("machine");

        if(machine == "QQ")
    		{
    			
    			ip = $("[machineIP]").attr("machineIP");
    			printCount = $("input[type=number]").val();
    			url = "https://192.168.1.195/api/Barcode/generateAndCreateFile";
    			
    		}else{
    				
    			ip = "";
    			printCount = "";
    			url = "https://192.168.1.195/api/Barcode/generateBatchBarcode";
    			
    		}
    		
    		if($("input[type=checkbox][name=ER]").is(":checked"))
				{

					ip = $("[otherIP]").attr("otherIP");
    			printCount = 1;
    			url = "https://192.168.1.195/api/Barcode/generateAndCreateFile";
    						
    			machine = "QQ";

				}

    		console.log("machine:" + ip);
    		console.log("printCount:" + printCount);
    		console.log("url:" + url);
    		console.log("machine:" + machine);

    		if(Data != "")
    		{
    			
    			var loadingTimer = setTimeout(showLoading, 0);
					//生成給號資料
    			$.post("Function.php", {Data: Data, action: $(this).attr("action"), username: $("[go=userOption]").attr("userid"), dicName: $("[dicName]").attr("dicName"), dicCode: $("[dicCode]").attr("dicCode"), ip: ip, printCount: printCount}, function($Json){
        	
        		console.log($Json);
        		var $J = JSON.parse($Json);
        		console.log("getBarcode:", $J); //檢視傳輸後的非Json格式

        		/*for(let i = 0; i < $J.length; i++)
        		{*/
        		
        		
        		if($("input[box=IsLabelOnly]:checked").length)
    				{
    			
    					IsLabelOnly = "noTube";
    			
    				}else{
    				
    					IsLabelOnly = "printTube";
    				
    				}
          
            requestData = {requests: $J};
            
						console.log(JSON.stringify(requestData));
						
						//給號
            $.ajax({
                    
              url: url,
              method: "POST",
              contentType: "application/json",
              data: JSON.stringify(requestData), //轉Json
                    
              success: function(response) {
                    
               	console.log("Success:", response);
               	
               	//儲存錯誤訊息
               	for(let i = 0; i < response.length; i++)
               	{
               		
               		if(response[i].error)
               		{
               			
               			console.log( "test" + response[i].error);
               			console.log( "test" + $J[i].Orders[0].Aplseq);
               			errorText = "<errorText>" + $J[i].Orders[0].Aplseq + "</errorText>";
               			errorText += "<errorText>" + response[i].error + "</errorText>";
               			$("errorTube[box=content]").append(errorText);
               			$("errorTube[box=icon]").css("display", "block");
               			$("error").text("發生錯誤");
               			
               		}else{
               			
               			$("error").text("給號成功");
               			
               		}
               		
               	}
 
               	if(machine == "QQ")
               	{

                 	//$("error").text("給號成功");
                 	$("roller[box=testTube]").html("");
                 	clearTimeout(loadingTimer);
        					hideLoading();
                
                	//檢驗barcodePrinter是否成功
                	/*$.ajax({
                		
                		url: "https://192.168.1.195/api/Barcode/checkDenyFiles",
                		method: "GET",
                		//contentType: "application/json";
                		
                		success: function(response) {
                			
                			console.log("have .devn need try again", response);
                			$("error").text("備管成功但列印失敗");
                			
                			$("[pos=DAT]").css("display", "block");
                			
                			if(!$("[pos=DAT]").attr("sid"))
                			{
                				
                				$("[pos=DAT]").attr("sid", sid);
                				
               				}else{
                				
               					var nowSid = $("[pos=DAT]").attr("sid") + "|" + sid;
                				$("[pos=DAT]").attr("sid", nowSid);
                				
                			}
                			
                		},
                		
                		error: function(xhr, status, error) {
                			
                			console.log("no .dat");
                			$("error").text("備管且列印成功");
                			$("[pos=DAT]").css("display", "none");

                		}
                		
                	});*/
                
                	//TMC備管        	
               	}else{
                        	
                  //生成備管資料
									$.post("Function.php", {Data: Data, sid: response, action: "Backup", dicCode: $("[dicCode]").attr("dicCode"), IsLabelOnly: IsLabelOnly}, function($Json){
                        		
                		console.log($Json);	
                        		
                  	var $J = JSON.parse($Json);
            				console.log("Backup:", $J); //檢視傳輸後的非Json格式
            				
										//備管
                		//requestData = $J;
                		//console.log(JSON.stringify(requestData));
                		
                		//以病歷號為單位呼叫備管
                		for(let $i = 0; $i < $J.length; $i++)
                		{
                			
                			//console.log($i);
                			requestData = $J[$i];
                			console.log(JSON.stringify(requestData));
                			
                			$.ajax({
                	
                    		url: "https://192.168.1.195/api/Robo7/processAndForward",
                    		method: "POST",
                    		contentType: "application/json",
                   			data: JSON.stringify(requestData), //轉Json
                   			success: function(response)
                   			{
                    							
								console.log("Success:", response);
								
								if(response.code == "1"){
									
									$.post("Function.php", {action: "Plant", function: "showTMCError"}, function($Json){
													
										console.log($Json);
										$J = JSON.parse($Json);
										$("mask[box=mask]").css("display", "flex");
										$("window").css("display", "block");
										$("window[box=window]").html($J);
										
													
									});
								
								}

								$("error").text("備管成功");
								$("roller[box=testTube]").html("");
								clearTimeout(loadingTimer);
								hideLoading();
                    
                    		},
                   	 		error: function(xhr, status, error)
												{
                    	
                       		console.error("Error:", error);
                       		if(xhr.status == 500)
				 									{
				 				
				 										$("error").text("給號成功，但TMC連線錯誤，備管失敗");
				 										clearTimeout(loadingTimer);
														$("roller[box=testTube]").html("");
														hideLoading();

				 									}else{
				 				
				 										errorText = "<errorText>錯誤代碼： " + xhr.status + "</errorText>";
														$("errorTube[box=content]").append(errorText);
														$("errorTube[box=icon]").css("display", "block");
				 										$("error").text("給號成功，但備管失敗");
				 										clearTimeout(loadingTimer);
														hideLoading();
				 				
				 									}
                    
                    		}
                    
                			});
                			
                		}
                
                		//不以病歷號為單位出管(一次出管)
                		/*$.ajax({
                	
                    	url: "https://192.168.1.195/api/Robo7/processAndForward",
                    	method: "POST",
                    	contentType: "application/json",
                   		data: JSON.stringify(requestData), //轉Json
                   		success: function(response)
                   		{
                   	
                     		console.log("Success:", response);
                       	$("error").text("備管成功");
                       	$("roller[box=testTube]").html("");
                    
                    	},
                   	 	error: function(xhr, status, error)
											{
                    	
                      	console.error("Error:", error);
                        if(xhr.status == 500)
				 								{
				 				
				 									$("error").text("給號成功，但TMC連線錯誤，備管失敗");
				 						
				 								}else{
				 				
				 									$("error").text("給號成功，但備管失敗");
				 				
				 								}
                    
                    	}
                    
                		});*/
                		
                	});
                        	
               	}
                    
              },
                    
              error: function(status, error) {
                    
               	console.error("Error:", error);
               	errorText = "<errorText>錯誤代碼： " + xhr.status + "</errorText>";
               	$("errorTube[box=content]").append(errorText);
								$("errorTube[box=icon]").css("display", "block");
               	$("error").text("備管失敗");
               	clearTimeout(loadingTimer);
        				hideLoading();
 
             	},
             	
						});

    			});
    			
    		}else{
    		
    			$("error").text("請勿傳送空白資料");
    		
    		}
    		
        break;  

			//打包	
			case "newPackage":
			
				option = $(this).attr("option");
			
				var Data = [];
				var specimenSeq = [];

				//console.log("test");		
				/*$("roller[box=package]").find("table").each(function(){

					console.log($(this).attr("name"));
					if (Data.indexOf($(this).attr("name")) === -1) {
          	  // 如果不存在，將資料添加到 Data 陣列中
            	Data.push($(this).attr("name"));
            
        	}
				
				});*/
				
				$("roller[box=package]").find("td[use=specimenSeq]").each(function(){

					if (specimenSeq.indexOf($(this).text()) === -1) {
          	  // 如果不存在，將資料添加到 Data 陣列中
						specimenSeq.push($(this).text());
            
					}
								
				});

				//console.log(Data);
				console.log(specimenSeq);
				
				machine = $("[machine]").attr("machine");
				ip = $("[machineIP]").attr("machineIP");
				
				if($("[mCode]").attr("mCode") == "ER")
				{
					
					if($("input[type=checkbox][name=ER]").is(":checked"))
					{
						
						machine = "QQ";
						ip = $("[otherIP]").attr("otherIP");
						
					}
					
				}
			
				//生成打包資料
				$.post("Function.php", {Data: specimenSeq, userid: $("[go=userOption]").attr("userid"), username: $("[go=userOption]").text(), dicCode: $("[dicCode]").attr("dicCode"), IP: $("[ip]").attr("ip"), action: $(this).attr("action")}, function($Json){
				
					console.log($Json);
					$J = JSON.parse($Json);
					//console.log($J);
				
					requestData = $J.Data;
				
					//生成成功後開始以下動作
					if($J.status == "success")
					{
						
						//barcode相關
						var btype = "code128";
						var value = $J.ListNo;
						var unicode = $J.unicode;
						
						//呼叫API打包
						$.ajax({
   	 	
       				url: "https://192.168.1.195/api/Package/saveData",
       				method: "POST",
       				contentType: "application/json",
       				data: requestData,
       				data: JSON.stringify(requestData), //轉Json
        
        			//打包成功後開始以下動作
      	 			success: function(response) {
        	
      	 				console.log("Success:", response);
      	 				
      	 				//儲存打包唯一碼
      	 				$.post("Function.php", {action: "saveUnicode", store: "packagedContent", option: "new", Data: specimenSeq, unicode: unicode, listNo: value}, function($Json){
      	 				
      	 					console.log($Json);	
      	 					
      	 					//清除打包暫存
      	 					$.post("Function.php", {action: "deleteRecode", dicCode: $("[dicCode]").attr("dicCode"), option: option}, function($Json){
      	 				
      	 						console.log($Json);	
      	 					
      	 					});
      	 					
      	 				});

								//列印條碼	
      	 				if($("input[box=barcheck]").is(":checked"))
								{
								
									if(machine == "TMC")
									{
										
										$.post("Function.php", {listNo: value, userid: $("[go=userOption]").attr("userid"), dicCode: $("[dicCode]").attr("dicCode"), action: "TMCbarcode"}, function($Json){
								
											console.log($Json);	
											$J = JSON.parse($Json);
								
											requestData = $J;
								
											$.ajax({
   	 	
    		   							url: "https://192.168.1.195/api/Robo7/printPackageLabel",
       									method: "POST",
       									contentType: "application/json",
       									data: requestData,
       									data: JSON.stringify(requestData), //轉Json
        
      	 								success: function(response) {
        	
      	 									console.log("Success:", response);
         									//$string = JSON.stringify(response);
            
       									},
        
       									error: function(xhr, status, error) {
        	
				 									console.error("Error:", error);

       									}
        
    									});
								
										});
								
									}else{
										
										requestData = { listNo: value, 
																		ip: ip,
																		printCount: 1 };
																		
										console.log(requestData);
								
										$.ajax({
   	 	
    		   						url: "https://192.168.1.195/api/Package/generateFilesForListNo",
       								method: "POST",
       								contentType: "application/json",
       								data: requestData,
       								data: JSON.stringify(requestData), //轉Json
        
      	 							success: function(response) {
        	
      	 								console.log("Success:", response);
         									//$string = JSON.stringify(response);
            
       								},
        
       								error: function(xhr, status, error) {
        	
				 								console.error("Error:", error);

       								}
        
    								});
										
									}
								
								}
					
								//列印清單
								if($("input[box=listcheck]").is(":checked"))
								{
									
															
									var loadingTimer = setTimeout(showLoading, 0);
						
									requestData = { listUnicode: unicode,
																	ordUnicode: value };
						
									console.log(requestData);
						
									$.ajax({
   	 	
     			  				url: "https://192.168.1.195/api/Package/addtoPrint",
       							method: "POST",
       							contentType: "application/json",
       							data: requestData,
       							data: JSON.stringify(requestData), //轉Json
        
      							success: function(response) {
        	
      								console.log("Success:", response);
      								response = JSON.stringify(response);
         							$.post("Function.php", {Data: response, listNo: value, username: $("[go=userOption]").text(), dicCode: $("[dicCode]").attr("dicCode"), option: option, action: "Filter", function: "PrintBarcode"}, function($Json){
						
												console.log($Json);	
												$J = JSON.parse($Json);
						
												var btype = "code128";
						
												$("mask[box=mask]").css("display", "flex");
												$("window").css("display", "block");
												$("window[box=window]").html($J.html);
												$("message[box=barcode]").html("").show().barcode(value, btype);
												
												for(let $i = 0; $i < $J.specimenSeq.length; $i++)
												{
													
													$("td[use=barcode][number=" + $i + "]").html("").show().barcode($J.specimenSeq[$i], btype);
													
												}
												
												clearTimeout(loadingTimer);
        								hideLoading();
				
											});
            
       							},
        
       							error: function(xhr, status, error) {
        	
											console.error("Error:", error);

       							}
        
    							});
							
								}
      	 				
      	 				$("error").text("打包成功");
         				$("roller").html("");
         				$("pan[pos=number]").text("0");
            
       				},
        
       				error: function(xhr, status, error) {
        	
				 				console.error("Error:", error);
				 				$("error").text("打包失敗");
				 				
       				}
        
    				});

					}else{
					
						$("error").text("打包失敗");
					
					}

				});
			
				break;

			//關閉更新小包
			case "close-update":
			
				$("window[box=window]").html("");	
				$("window").css("display", "none");		
				$("mask[box=mask]").css("display", "none");
			
				break;
				
			//更新小包
			case "updatePackage":
			
				listUnicode = $(this).attr("unicode");
				listNo = $(this).attr("listNo");
				option = $(this).attr("option");
				
				var Data = [];
				var eachData = {};
				
				/*$("roller[box=package]").find("table").each(function(){

					if (Data.indexOf($(this).attr("name")) === -1) {
          	  // 如果不存在，將資料添加到 Data 陣列中
            	Data.push($(this).attr("name"));
            
        	}
				
				});*/
				
				$("roller[box=package]").find("td[use=specimenSeq]").each(function(){

					if (Data.indexOf($(this).text()) === -1) {
          	  // 如果不存在，將資料添加到 Data 陣列中
            	Data.push($(this).text());
            
        	}
								
				});
				
				console.log(Data);
				console.log(listNo);
				
				machine = $("[machine]").attr("machine");
				ip = $("[machineIP]").attr("machineIP");
				
				if($("[mCode]").attr("mCode") == "ER")
				{
					
					if($("input[type=checkbox][name=ER]").is(":checked"))
					{
						
						machine = "QQ";
						ip = $("[otherIP]").attr("otherIP");
						
					}
					
				}

				$.post("Function.php", {Data: Data, listUnicode: listUnicode, listNo: listNo, action: $(this).attr("action")}, function($Json){
					
					console.log($Json);	
					$J = JSON.parse($Json);
					
					requestData = $J.Data;
					
					$.ajax({
   	 	
       				url: "https://192.168.1.195/api/Package/addListBData",
       				method: "POST",
       				contentType: "application/json",
       				data: requestData,
       				data: JSON.stringify(requestData), //轉Json
        
      	 			success: function(response) {
        	
      	 				console.log("Success:", response);
      	 				$("mask[box=mask]").css("display", "none");
								$("window").css("display", "none");
      	 				$("window[box=window]").html("");
		
      	 				$.post("Function.php", {action: "packagedContent", option: "update", Data: Data, unicode: listUnicode, listNo: listNo}, function($Json){
      	 				
      	 					console.log($Json);
      	 					
      	 				});

      	 				$.post("Function.php", {action: "deleteRecode", dicCode: $("[dicCode]").attr("dicCode"), option: option}, function($Json){
      	 				
      	 					console.log($Json);	
      	 					
      	 				});

      	 				$("tr[pos=HistoryPackage][name=" + listNo + "]").find("td[use=orderCount], td[use=tubeCount]").each(function(){

									old = parseInt($(this).text());
									console.log(old);

									if($(this).attr("use") == "orderCount")
									{
										current =  old + parseInt($J.orderCount);
         						
									}else{
										
         						current =  old + parseInt($J.tubeCount);
         						
									}
									
									$(this).text(current); 
									console.log($(this).attr("use"));
								
								});
      	 				
      	 				//列印條碼貼紙
								if($("input[box=barcheck]").is(":checked"))
								{
								
									if(machine == "TMC")
									{
										
										$.post("Function.php", {listNo: listNo, userid: $("[go=userOption]").attr("userid"), dicCode: $("[dicCode]").attr("dicCode"), action: "TMCbarcode"}, function($Json){
								
											console.log($Json);	
											$J = JSON.parse($Json);
								
											requestData = $J;
								
											$.ajax({
   	 	
    		   							url: "https://192.168.1.195/api/Robo7/printPackageLabel",
       									method: "POST",
       									contentType: "application/json",
       									data: requestData,
       									data: JSON.stringify(requestData), //轉Json
        
      	 								success: function(response) {
        	
      	 									console.log("Success:", response);
         									//$string = JSON.stringify(response);
            
       									},
        
       									error: function(xhr, status, error) {
        	
				 									console.error("Error:", error);

       									}
        
    									});
								
										});
								
									}else{
										
										requestData = { listNo: listNo, 
																		ip: ip,
																		printCount: 1 };
																		
										console.log(requestData);
								
										$.ajax({
   	 	
    		   						url: "https://192.168.1.195/api/Package/generateFilesForListNo",
       								method: "POST",
       								contentType: "application/json",
       								data: requestData,
       								data: JSON.stringify(requestData), //轉Json
        
      	 							success: function(response) {
        	
      	 								console.log("Success:", response);
         									//$string = JSON.stringify(response);
            
       								},
        
       								error: function(xhr, status, error) {
        	
				 								console.error("Error:", error);

       								}
        
    								});
										
									}
								
								}
      	 				
      	 				//列印清單
      	 				if($("input[box=listcheck]").is(":checked"))
								{
						
									var loadingTimer = setTimeout(showLoading, 0);
						
									requestData = { listUnicode: listUnicode,
																	ordUnicode: listNo };
						
									console.log(requestData);
						
									$.ajax({
   	 	
     			  				url: "https://192.168.1.195/api/Package/addtoPrint",
       							method: "POST",
       							contentType: "application/json",
       							data: requestData,
       							data: JSON.stringify(requestData), //轉Json
        
      							success: function(response) {
        	
      								console.log("Success:", response);
      								response = JSON.stringify(response);
         							$.post("Function.php", {Data: response, username: $("[go=userOption]").text(), dicCode: $("[dicCode]").attr("dicCode"), option: option, action: "Filter", function: "PrintBarcode", listNo: listNo, listUnicode: listUnicode}, function($Json){
						
												console.log($Json);	
												$J = JSON.parse($Json);
						
												var btype = "code128";
												var value = listNo;
						
												$("mask[box=mask]").css("display", "flex");
												$("window").css("display", "block");
												$("window[box=window]").html($J.html);
												$("message[box=barcode]").html("").show().barcode(value, btype);
												
												for(let $i = 0; $i < $J.specimenSeq.length; $i++)
												{
													
													$("td[use=barcode][number=" + $i + "]").html("").show().barcode($J.specimenSeq[$i], btype);
													
												}
												
												clearTimeout(loadingTimer);
												hideLoading();
				
											});
            
       							},
        
       							error: function(xhr, status, error) {
        	
											console.error("Error:", error);
											clearTimeout(loadingTimer);
											hideLoading();

       							}
        
    							});
							
								}
       				},
        
       				error: function(xhr, status, error) {
        	
				 				console.error("Error:", error);
				 				$("error").text("新增失敗");

       				}
        
    			});
					
				});
			
				break;
			
			//掃描條碼要打包的確認入袋
			case "intoPackage":
			
				store = $(this).attr("store");
				action = $(this).attr("action");
				$function	= $(this).attr("function");
				specimenSeq	=	$("input[box=scan]").val().trim();
				specimenSeq = specimenSeq.toUpperCase();
				option = $(this).attr("option");
				
				if($("td[use=number]").last().text() == "")
				{
						
					number = 1;
						
				}else{
						
					console.log($("td[use=number]").text());
					number = parseInt($("td[use=number]").last().text()) + 1;
						
				}
			
				requestData = {specimenSeq: specimenSeq};
				
				console.log(requestData);

				$.ajax({
   	 	
       		url: "https://192.168.1.195/api/Package/getPackedData",
       		method: "POST",
       		contentType: "application/json",
      		data: requestData,
      		data: JSON.stringify(requestData), //轉Json
        
      	 	success: function(response) {
        	
        		labNo = response.labNo;
         						
         		testTube = {labNo: labNo}
         						
         		$.ajax({
   	 	
       				url: "https://192.168.1.195/api/NursingStationOracle/getLabOrderDetailsByLabNo",
       				method: "POST",
       				contentType: "application/json",
       				data: testTube,
       				data: JSON.stringify(testTube), //轉Json
        
      	 			success: function(Tube) {
        	
      	 				console.log("Success:", Tube);
         				Tube = JSON.stringify(Tube);
         			
         				$.post("Function.php", {Data: Tube, labNo: labNo, store: "testTube"}, function($Json){ });
         	
         			},
         		
         			error: function(xhr, status, error) {
        	
				 				console.error("Error:", error);

       				}
         				
         		});
        	
      	 		console.log("Success:", response);
         		//$string = JSON.stringify(response);
         		
         		console.log("Success:", response);
         		//$string = JSON.stringify(response);
         			
         		pan = response.mCode;
         		console.log(pan);
				
				switch(pan)
				{
         				
					case "01":
         				
						old = parseInt($("[box=grey][pos=number]").text());
						current =  old + 1;
						$("[box=grey][pos=number]").text(current);
         		
						break;
         					
					case "02":
         				
						/*old = parseInt($("[box=red][pos=number]").text());
						current =  old + 1;
						$("[box=red][pos=number]").text(current);
         				
						break;*/
         					
					case "03":
         				
						old = parseInt($("[box=yellow][pos=number]").text());
						current =  old + 1;
						$("[box=yellow][pos=number]").text(current);
         				
						break;
         					
					case "04":
         				
						old = parseInt($("[box=purple][pos=number]").text());
						current =  old + 1;
						$("[box=purple][pos=number]").text(current);
         				
						break;
         					
					case "05":
         				
						old = parseInt($("[box=green][pos=number]").text());
						current =  old + 1;
						$("[box=green][pos=number]").text(current);
         				
						break;
         					
					case "06":
         				
						old = parseInt($("[box=blue][pos=number]").text());
						current =  old + 1;
						$("[box=blue][pos=number]").text(current);
         				
						break;
        				
					case "07":
         					
						old = parseInt($("[box=urine][pos=number]").text());
						current =  old + 1;
						$("[box=urine][pos=number]").text(current);
 
						break;
         						
					default:
         					
						old = parseInt($("[box=other][pos=number]").text());
						current =  old + 1;
						$("[box=other][pos=number]").text(current);
         					
						break;

				}

				const allSid = document.querySelectorAll('td[use="specimenSeq"]'); // 儲存所有 specimenSeq

				allSid.forEach(cell => { // 遍歷每? specimenSeq
    
					const sid = cell.textContent.trim();

						// 比較是否與 targetSpecimenSeq 匹配
					if (sid === specimenSeq) {
						console.log("找到匹配的 specimenSeq:", sid);
						//cell.style.backgroundColor = 'yellow'; // 高亮?示匹配的 specimenSeq
						response = null;
						//matchedSid.add(sid); // ?匹配的 specimenSeq 添加到 Set
						switch(pan)
						{
         				
							case "01":
         				
								old = parseInt($("[box=grey][pos=number]").text());
								current =  old - 1;
								$("[box=grey][pos=number]").text(current);
         				
								break;
         					
							case "02":
         				
								/*old = parseInt($("[box=red][pos=number]").text());
								current =  old + 1;
								$("[box=red][pos=number]").text(current);
         				
								break;*/
         					
							case "03":
         				
								old = parseInt($("[box=yellow][pos=number]").text());
								current =  old - 1;
								$("[box=yellow][pos=number]").text(current);
         				
								break;
         					
							case "04":
         				
								old = parseInt($("[box=purple][pos=number]").text());
								current =  old - 1;
								$("[box=purple][pos=number]").text(current);
         				
								break;
         					
							case "05":
         				
								old = parseInt($("[box=green][pos=number]").text());
								current =  old - 1;
								$("[box=green][pos=number]").text(current);
         				
								break;
         					
							case "06":
         				
								old = parseInt($("[box=blue][pos=number]").text());
								current =  old - 1;
								$("[box=blue][pos=number]").text(current);
         				
								break;
        				
							case "07":
         					
								old = parseInt($("[box=urine][pos=number]").text());
								current =  old - 1;
								$("[box=urine][pos=number]").text(current);
 
								break;
         						
							default:
         					
								old = parseInt($("[box=other][pos=number]").text());
								current =  old - 1;
								$("[box=other][pos=number]").text(current);
         					
								break;

						}
							
					}
				});
         			
         		$.post("Function.php", {Data: response, dicCode: $("[dicCode]").attr("dicCode"), specimenSeq: specimenSeq, number: number, store: store, option: option, action: action, function: $function}, function($Json){

							console.log($Json);	
         			$J = JSON.parse($Json);
         			//console.log($J);
         				
         			if($J.status == "success")
         			{
         				
         				//$("th[noData]").attr("noData", "no");
         				$("roller[box=package]").append($J.html);
         				$("error").text("");
         				scrollToBottom();
         					
         			}else{
         					
         				$("error").text("重複刷管");
         					
         			}		

						});
         	
         	},
         		
         	error: function(xhr, status, error) {
        	
				 		console.error("Error:", error);
				 		$("error").text("此管已打包");

       		}
         				
         });
			
				$("[box=scan]").val("");

				break;
				
			//掃描送出送達的確認輸入	
			case "intoSign":
			
				if($("input[box=userid]").val())	
				{				
					
					$("error").text("");

					action = $(this).attr("action");
					$function = $(this).attr("function");
					option = $(this).attr("option");
					userid = $("input[box=userid]").val();
					data	= $("[box=scan]").val();
					data = data.toUpperCase();
						
					//console.log("test1");
					console.log($("[box=scan]").val());
					
					requestData = "listNo=" + data;
					
					$.ajax({
   	 	
						url: "https://192.168.1.195/api/Package/getDataByListNo",
						method: "GET",
						contentType: "application/json",
						data: requestData,
						//data: JSON.stringify(requestData), //轉Json
        
						success: function(response) {
        	
							console.log("Success:", response);
							
							const matchedListNo = new Set(); //用來存放重複的資料

							const allListNo = document.querySelectorAll('td[use="listNo"]'); //儲存所有labNo

							allListNo.forEach(cell => { //歷遍labNo
            
								const listNo = cell.textContent.trim();
								// 如果 cell 的 labNo 在 response 中
            
								if (response.listNo === listNo) {
					
									console.log("找到匹配的 listNo:", listNo);
									//cell.style.backgroundColor = 'yellow'; // 顯示重複
									matchedListNo.add(listNo); //將匹配的labNo放入陣列
									response = null;
								}
									
							});
							//$string = JSON.stringify(response);
         			
							$.post("Function.php", {Data: response, action: action, function: $function, option: option}, function($Json){
         				
								console.log($Json);	
								$J = JSON.parse($Json);
								//console.log($J);
         				
								if($J.status == "success")
								{
         					
									$("roller[box=sign]").append($J.html);
									$("error").text("");
									scrollToBottom();
         					
								}else{

									$("error").text("重複的小包條碼");

								}									
         				
							});
 
						},
						
						error: function(xhr, status, error)
						{
							
							console.log("error:", error);
							$("error").text("不存在的小包條碼");
							
						}
 
					});
    			
					$("[box=scan]").val("");

				}else{
					
					$("error").text("請先輸入工號");
					//$("[box=scan]").val("");
					
				}
			
				break;
				
			//彈出密碼確認
			case "signPassword":
			
				if($("input[box=userid]").val())	
				{
				
					$.post("Function.php", {action: $(this).attr("action"), function: $(this).attr("function"), option: $(this).attr("option"), userid: $("input[box=userid]").val()}, function($Json){
					
						console.log($Json);
						$J = JSON.parse($Json);
					
						$("mask[box=mask]").css("display", "flex");
						$("window").css("display", "block");
						$("window[box=window]").html($J);	

					});
					
				}else{
					
					$("error").text("請先輸入工號");
					
				}
			
				break;
				
			//簽出簽入
			case "sign":
			
				var Data = [];
			
				$("roller[box=sign] table[pos=sign]").each(function(){
				
						Data.push($(this).attr("name"));
						//Data = $(this).attr("name");
					
				});
				
				userid = $("input[name=username]").val();
				password = $("input[name=password]").val();
				option = $(this).attr("option");
				
				console.log(Data);

        switch(option)
        {
         					
         	case "signOut":
         					
         		url = "https://192.168.1.195/api/Package/checkOut";
         		success = "送出成功";
         		error = "送出失敗";
         		
         		requestData = { transMan: userid,
       											password: password };
       											
       			option = "signOut";
         		
         		break;
         					
         	case "signIn":
         					
         		url = "https://192.168.1.195/api/Package/checkIn";
       			success = "送達成功";
     				Error = "送達失敗";
     				
     				requestData = { rcvMan: userid,
       											password: password };
       											
       			option = "signIn";

     				break;
         					
				}
				
				/*if($("input[type=checkbox]").is(":checked"))
				{
					
					requestData.autoReceive = 1;
					
				}else{
					
					requestData.autoReceive = 0;
					
				}*/
				
				requestData.autoReceive = 1;
       	console.log(requestData);
         	
        for(let i = 0; i < Data.length; i++)
        {
          	
          requestData.listNo = Data[i];
         							
         	$.ajax({
         								
         		url: 	url,
         		method: "POST",
         		contentType: "application/json",
         		data: requestData,
       			data: JSON.stringify(requestData), //轉Json
       									
       			success: function(response) {
        	
      	 			console.log("Success:", response);
      	 			$("error").text(success);
      	 			$("roller[box=sign]").html("");
      	 			
      	 			$.post("Function.php", {store: "updateStatus", Data: Data[i], option: option}, function($Json){
      	 			
      	 				console.log($Json);	
      	 			
      	 			});
			
      	 		},
      	 								
      	 		error: function(xhr, status, error) {
        	
				 			console.error("Error:", error);
				 			
				 			if(xhr.status == 401)
				 			{
				 				
				 				$("error").text("密碼錯誤，請重新輸入密碼");
				 				
				 			}else{
				 				
				 				$("error").text(Error);
				 				
				 			}

       			}
         								
         	});
         		
        }
        
        $("mask[box=mask]").css("display", "none");
				$("window").css("display", "none");
				$("window[box=window]").html("");	
            
				break;
				
				//掃描檢體採檢的確認輸入
				case "intoCheckScan":

					action = $(this).attr("action");
					$function = $(this).attr("function");
					//checkString = input.charAt(0);
					//console.log(checkString);
					option = $(this).attr("use");
					
					switch($(this).attr("use"))
					{

						case "chartNo":
						
							if($("input[box=scan][pos=chartNo]").val())
							{
					
								input = $("input[box=scan][pos=chartNo]").val().trim();
				
								if(input.length < 10)
								{

									input = input.padStart(10, "0");

								}
								
								requestData = { chartNo: input };

								$.ajax({
								
									url: "https://192.168.1.195/api/NursingStationOracle/confirmChartNo", 	
									method: "POST",
       						contentType: "application/json",
       						data: requestData, //轉Json
       						data: JSON.stringify(requestData),
        
      		 				success: function(response) {
        	
      	 						console.log("success:", response[0].labNo);
								
										chartNo = response[0].chartNo;
										ptName = response[0].ptName;
										sex = response[0].sex;
										bedNo = response[0].bedNo;
										
										const matchedSid = new Set(); //用來存放重複的資料

										const allSid = document.querySelectorAll('td[use="specimenSeq"]'); //儲存所有labNo

										allSid.forEach(cell => { //歷遍labNo
            
											const sid = cell.textContent.trim();
											// 如果 cell 的 labNo 在 response 中
            
											if (response.some(item => item.specimenSeq === sid)) {
					
												console.log("找到匹配的 specimenSeq:", sid);
												//cell.style.backgroundColor = 'yellow'; // 顯示重複
												matchedSid.add(sid); //將匹配的labNo放入陣列
											}
										});

										const filteredResponse = response.filter(item => !matchedSid.has(item.specimenSeq)); //捨棄重複資料

										console.log("filteredResponse:", filteredResponse);

										const ResponseJson = JSON.stringify(filteredResponse);
										
										//console.log(response);
										//response = JSON.stringify(response);
										$.post("Function.php", {name: input, Data: ResponseJson, action: action, chartNo: chartNo, ptName: ptName, sex: sex, bedNo: bedNo, function: $function}, function($Json){
      	 					
											console.log($Json);
											$J = JSON.parse($Json);
											
											if($J.status == "success")
											{
							
												$("panitentInfo").html("");	
												$("panitentInfo").html($J.chartNo);
												$("roller").append($J.sid);	
												$("[box=scan][pos=chartNo]").val("");
												$("error").text("");
											
											}else{
												
												$("panitentInfo").html("");	
												$("panitentInfo").html($J.chartNo);
												$("error").text("重複刷圈");
												
											}
      	 						
										});
         					},
         		
         					error: function(xhr, status, error) {
        	
				 						console.error("Error:", error);
				 						$("panitentInfo").html("");	
					 					$("error").text("錯誤的條碼或查無資料");

	     	  				}
       					
								});
						
							}else{
								
								$("panitentInfo").html("");
					 			$("error").text("錯誤的條碼或查無資料");
								
							}
					
							break;
						
						case "sid":
							
							input = $("input[box=scan][pos=sid]").val().trim();
							input = input.toUpperCase();
					
							if($("IDP[use=chartNo]").text())
							{

								requestData = { sid: input, 
															  chartNo: $("IDP[use=chartNo]").attr("name"),
															  specimenClerk: $("[userid]").attr("userid") };
									
								console.log(requestData);
									
								//掃描稽核
								$.ajax({
								
									url: "https://192.168.1.195/api/NursingStationOracle/confirmPatient", 	
									method: "POST",
       						contentType: "application/json",
       						data: requestData, 
       						data: JSON.stringify(requestData),
        
     				 	 		success: function(response) {
        	
     			 	 				console.log(response);
     			 		 				
     			 	 				$("roller").find("table[name=" + input + "]").each(function(){
						
											$(this).css("color", "#6DB149");
											$(this).css("font-weight", "bold");
											
										});
										
										$("[box=scan][pos=sid]").val("");
										$("error").text(input + "稽核成功");

         					},
         		
         					error: function(xhr, status, error) {
         							
         						$("error").text("稽核失敗");

     	  					}
       					
								});
					
							}else{
						
								$("error").text("請先掃描病人手圈");
						
							}
								
							break;
							
					}

					break;
				
				//抽血稽核送出
				/*case "drawBlood":
				
					//console.log("test");
				
					$("roller").find("table[use=sid]").each(function(){
						
						if($(this).attr("check") == "Pass")
						{
							
							console.log("Pass: " + $(this).attr("name"));
							
						}else{
							
							console.log("NoPass: " + $(this).attr("name"));
							
						}

						
						console.log("test");
						requestData = { sid: $(this).attr("name"),
													  chartNo: $("chartNo").text(),
													  specimenClerk:  $("[userid]").attr("userid")};
														  
						console.log(requestData);

					});
				
					//console.log(requestData);

					break;*/
					
			//設定護理站
			case "setIP":
			
				requestData = { dic_Code: $("input[box=dicCode]").val(),
											  dic_Name: $("input[box=dicName]").val(),
											  m_Code: $("input[box=mCode]").val() };
	
				console.log(JSON.stringify(requestData));
	
				$.ajax({
         								
         		url: 	"https://192.168.1.195/api/NursingStation/IPandStation",
         		method: "POST",
         		contentType: "application/json",
         		data: requestData,
       			data: JSON.stringify(requestData), //轉Json
       									
       			success: function(response) {
        	
      	 			console.log("Success:", response);
      	 			$("error").text("存檔成功，下次登入生效");
			
      	 		},
      	 								
      	 		error: function(xhr, status, error) {
        	
				 			console.error("Error:", error);
				 			$("error").text("存檔失敗");

       			}
         								
        });
								
				break;
				
			case "deleteBarcode":
			
				labNo = $(this).attr("name");
							
				$.post("Function.php", {action: "checkDelete", option: $(this).attr("option"), labNo: labNo}, function($Json){
								
						console.log($Json);
						$J = JSON.parse($Json);
								
						if($J.status == null)
						{
									
							requestData = { labNo: labNo, 
											insMan: $("[userid]").attr("userid"),
											workstation: $("[dicCode]").attr("dicCode"),
											nurseStation: $("[dicCode]").attr("dicCode"),
											stationName: $("[dicName]").attr("dicName") };
											
							console.log(JSON.stringify(requestData));
												
							$.ajax({
   	 	
       					url: "https://192.168.1.195/api/Barcode/cancelGeneratedBarcode",
       					method: "POST",
      					contentType: "application/json",
       					data: requestData,
       					data: JSON.stringify(requestData), //轉Json
        
       					success: function(response) {
        	
      	 					console.log("Success:", response);
         					$("error").text("刪除成功");
         					$("table[name=" + labNo + "]").remove();
         					$("labInfo[name=" + labNo + "]").remove();
            
       					},
         		
						error: function(xhr, status, error) {
        	
				 			console.error("Error:", error);
				 			$("error").text("刪除失敗");

						}
        
    					});
									
						}else{
									
							$("error").text("已有打包管，無法刪除");
									
						}
								
				});
				
				$("window[box=window]").html("");	
				$("window").css("display", "none");		
				$("mask[box=mask]").css("display", "none");
			
				break;
				
		}
		
	});

	//各作業之掃描功能
	$(document).on("keypress", "[box=scan]", function(){
		
						
		if(event.which === 13)
		{
			
			input = $(this).val().trim();
			input = input.toUpperCase();
			action = $(this).attr("action");
			$function = $(this).attr("function");
			
								
			if($("td[use=number]").last().text() == "")
			{
						
				number = 1;
						
			}else{
						
				//console.log($("td[use=number]").text());
				number = parseInt($("td[use=number]").last().text()) + 1;
						
			}
					
			switch($(this).attr("function"))
			{
				
				//備管的動態新增資料
				case "testTubeScan":

					store = $(this).attr("store");
					console.log(store);

					labNo = input;
					
					requestData = {labNo: labNo};
					
					$.ajax({
   	 	
       			url: "https://192.168.1.195/api/NursingStationOracle/getLabOrderDetailsByLabNo",
       			method: "POST",
       			contentType: "application/json",
       			data: requestData,
       			data: JSON.stringify(requestData), //轉Json
        
      	 		success: function(response) {
        	
      	 			console.log("Success:", response);
					
					const matchedLabNos = new Set(); //用來存放重複的資料

					const allLabNo = document.querySelectorAll('td[use="labNo"]'); //儲存所有labNo

					allLabNo.forEach(cell => { //歷遍labNo
            
						const labNo = cell.textContent.trim();
						// 如果 cell 的 labNo 在 response 中
            
						if (response.some(item => item.labNo === labNo)) {
					
							console.log("找到匹配的 labNo:", labNo);
							//cell.style.backgroundColor = 'yellow'; // 顯示重複
							matchedLabNos.add(labNo); //將匹配的labNo放入陣列
						}
					});

					const filteredResponse = response.filter(item => !matchedLabNos.has(item.labNo)); //捨棄重複資料

					console.log("filteredResponse:", filteredResponse);

					const ResponseJson = JSON.stringify(filteredResponse);
					
         			//response = JSON.stringify(response);
         			
         			$.post("Function.php", {Data: ResponseJson, labNo: input, number: number, action: action, store: store, function: $function}, function($Json){

								console.log($Json);	
         				$J = JSON.parse($Json);
         				//console.log($J);
         				
         				if($J.status == "success")
         				{
         					
         					$("roller[box=testTube]").append($J.html);
         					$("error").text("");
         					scrollToBottom();
         					
         				}else{
         					
         					$("error").text("重複刷單");
         					
         				}		

					});
         	
         		},
         		
         		error: function(xhr, status, error) {
        	
				 			console.error("Error:", error);
				 			$("error").text("錯誤的條碼或無此筆資料");

       			}
         				
         	});
			
					$("[box=scan]").val("");

				
					break;
			
				//打包的動態新增資料
				case "packageScan":

					dicCode = $("[dicCode]").attr("dicCode");
					store = $(this).attr("store");
					option = $(this).attr("option");
					specimenSeq	=	input;
	
					requestData = {specimenSeq: specimenSeq};

					$.ajax({
   	 	
       			url: "https://192.168.1.195/api/Package/getPackedData",
       			method: "POST",
       			contentType: "application/json",
       			data: requestData,
       			data: JSON.stringify(requestData), //轉Json
        
      	 		success: function(response) {

 					console.log("response:", response);
 
         			labNo = response.labNo;
         						
         			testTube = {labNo: labNo}
         						
         			$.ajax({
   	 	
       					url: "https://192.168.1.195/api/NursingStationOracle/getLabOrderDetailsByLabNo",
       					method: "POST",
       					contentType: "application/json",
       					data: testTube,
       					data: JSON.stringify(testTube), //轉Json
        
      	 				success: function(Tube) {
        	
      	 					console.log("Tube:", Tube);
         					Tube = JSON.stringify(Tube);
         			
         					$.post("Function.php", {Data: Tube, labNo: labNo, store: "testTube"}, function($Json){ });
         	
         				},
         		
         				error: function(xhr, status, error) {
        	
				 					console.error("Error:", error);

       					}
         				
         			});

         			//$string = JSON.stringify(response);
         			
         			pan = response.mCode;
					
					switch(pan)
					{
                                                             
						case "01":
         				
							old = parseInt($("[box=grey][pos=number]").text());
							current =  old + 1;
							$("[box=grey][pos=number]").text(current);
         			
							break;
         					
						case "02":
         				
							/*old = parseInt($("[box=red][pos=number]").text());
							current =  old + 1;
							$("[box=red][pos=number]").text(current);
         				
							break;*/
         			
						case "03":
         				
							old = parseInt($("[box=yellow][pos=number]").text());
							current =  old + 1;
							$("[box=yellow][pos=number]").text(current);
         				
							break;
         					
						case "04":
         				
							old = parseInt($("[box=purple][pos=number]").text());
							current =  old + 1;
							$("[box=purple][pos=number]").text(current);
         				
							break;
         					
						case "05":
         				
							old = parseInt($("[box=green][pos=number]").text());
							current =  old + 1;
							$("[box=green][pos=number]").text(current);
         				
							break;
         					
						case "06":
         				
							old = parseInt($("[box=blue][pos=number]").text());
							current =  old + 1;
							$("[box=blue][pos=number]").text(current);
         				
							break;
        				
						case "07":
         					
							old = parseInt($("[box=urine][pos=number]").text());
							current =  old + 1;
							$("[box=urine][pos=number]").text(current);
 
							break;
         						
						default:
         			
							old = parseInt($("[box=other][pos=number]").text());
							current =  old + 1;
							$("[box=other][pos=number]").text(current);
         					
							break;

					}
         			
         			
					//const matchedSid = new Set(); // 用來存放重複的資料

					const allSid = document.querySelectorAll('td[use="specimenSeq"]'); // 儲存所有 specimenSeq

					allSid.forEach(cell => { // 遍歷每? specimenSeq
    
						const sid = cell.textContent.trim();

						// 比較是否與 targetSpecimenSeq 匹配
						if (sid === specimenSeq) {
							console.log("找到匹配的 specimenSeq:", sid);
							//cell.style.backgroundColor = 'yellow'; // 高亮?示匹配的 specimenSeq
							response = null;
							//matchedSid.add(sid); // ?匹配的 specimenSeq 添加到 Set
							
							switch(pan)
							{
                                                             
								case "01":
         				
									old = parseInt($("[box=grey][pos=number]").text());
									current =  old - 1;
									$("[box=grey][pos=number]").text(current);
         				
									break;
         					
								case "02":
         				
									/*old = parseInt($("[box=red][pos=number]").text());
									current =  old + 1;
									$("[box=red][pos=number]").text(current);
         				
									break;*/
         					
								case "03":
         				
									old = parseInt($("[box=yellow][pos=number]").text());
									current =  old - 1;
									$("[box=yellow][pos=number]").text(current);
         				
									break;
         					
								case "04":
         				
									old = parseInt($("[box=purple][pos=number]").text());
									current =  old - 1;
									$("[box=purple][pos=number]").text(current);
         				
									break;
         					
								case "05":
         				
									old = parseInt($("[box=green][pos=number]").text());
									current =  old - 1;
									$("[box=green][pos=number]").text(current);
         				
									break;
         					
								case "06":
         				
									old = parseInt($("[box=blue][pos=number]").text());
									current =  old - 1;
									$("[box=blue][pos=number]").text(current);
         				
									break;
        				
								case "07":
         					
									old = parseInt($("[box=urine][pos=number]").text());
									current =  old - 1;
									$("[box=urine][pos=number]").text(current);
 
									break;
         						
								default:
         					
									old = parseInt($("[box=other][pos=number]").text());
									current =  old - 1;
									$("[box=other][pos=number]").text(current);
         					
									break;

							}
							
						}
						
					});

					//console.log("所有匹配的 specimenSeq:", Array.from(matchedSid));
         			$.post("Function.php", {Data: response, specimenSeq: specimenSeq, number: number, dicCode: dicCode, store: store, option: option, action: action, function: $function}, function($Json){

						console.log($Json);	
         				$J = JSON.parse($Json);
         				//console.log($J);
         				
         				if($J.status == "success")
         				{
         					
         					//$("th[noData]").attr("noData", "no");
         					$("roller[box=package]").append($J.html);
         					$("error").text("");
         					scrollToBottom();
         					
         				}else{
         					
         					$("error").text("重複刷管");
         					
         				}		

							});
         	
         		},
         		
         		error: function(xhr, status, error) {
        	
				 			console.error("Error:", error);
				 			$("error").text("此管已打包");

       			}
         				
         	});
			
					$("[box=scan]").val("");

				break;

				//簽出簽入的動態新增資料
				case "signScan":
			
					if($("input[box=userid]").val())	
					{				
					
						$("error").text("");

						option = $(this).attr("option");
						userid = $("input[box=userid]").val();
						data	= $("[box=scan]").val();
						
						//console.log("test1");
						//console.log($("[box=scan]").val());
					
						requestData = "listNo=" + data;
					
						$.ajax({
   	 	
							url: "https://192.168.1.195/api/Package/getDataByListNo",
							method: "GET",
							contentType: "application/json",
							data: requestData,
							//data: JSON.stringify(requestData), //轉Json
        
							success: function(response) {
        	
								console.log("Success:", response);
								
								//response = JSON.stringify(response);
								
								const matchedListNo = new Set(); //用來存放重複的資料

								const allListNo = document.querySelectorAll('td[use="listNo"]'); //儲存所有labNo

								allListNo.forEach(cell => { //歷遍labNo
            
									const listNo = cell.textContent.trim();
									// 如果 cell 的 labNo 在 response 中
            
									if (response.listNo === listNo) {
					
										console.log("找到匹配的 listNo:", listNo);
										//cell.style.backgroundColor = 'yellow'; // 顯示重複
										matchedListNo.add(listNo); //將匹配的labNo放入陣列
										response = null;
									}
									
								});
								
								//$string = JSON.stringify(response);
         			
								$.post("Function.php", {Data: response, action: action, function: $function, option: option}, function($Json){
         				
									console.log($Json);	
									$J = JSON.parse($Json);
									//console.log($J);
         				
									if($J.status == "success")
									{
         					
										$("roller[box=sign]").append($J.html);
										$("error").text("");
										scrollToBottom();
         					
									}else{
										
										$("error").text("重複的小包條碼");
										
									}		
         				
								});
 
							}, 
         			
							error: function(xhr, status, error) {
        	
								console.error("Error:", error);
								$("error").text("不存在的小包條碼");

							}
 
						});
    			
						$("[box=scan]").val("");

					}else{
					
						$("error").text("請先輸入工號");
						//$("[box=scan]").val("");
					
					}
				
				break;
				
				//動態採體採檢掃描
				case "checkScan":
				
					//checkString = input.charAt(0);
					//console.log(checkString);
					
					option = $(this).attr("pos");
					
					switch($(this).attr("pos"))
					{

						case "chartNo":
						
							if(input)
							{

								if(input.length < 10)
								{
									
									input = input.padStart(10, "0");
									
								}

								requestData = { chartNo: input };
					
								$.ajax({
								
									url: "https://192.168.1.195/api/NursingStationOracle/confirmChartNo", 	
									method: "POST",
									contentType: "application/json",
									data: requestData, //轉Json
									data: JSON.stringify(requestData),
        
									success: function(response) {
										
										console.log("success:", response);
										
										chartNo = response[0].chartNo;
										ptName = response[0].ptName;
										sex = response[0].sex;
										bedNo = response[0].bedNo;
										
										const matchedSid = new Set(); //用來存放重複的資料

										const allSid = document.querySelectorAll('td[use="specimenSeq"]'); //儲存所有labNo

										allSid.forEach(cell => { //歷遍labNo
            
											const sid = cell.textContent.trim();
											// 如果 cell 的 labNo 在 response 中
            
											if (response.some(item => item.specimenSeq === sid)) {
					
												console.log("找到匹配的 specimenSeq:", sid);
												//cell.style.backgroundColor = 'yellow'; // 顯示重複
												matchedSid.add(sid); //將匹配的labNo放入陣列
											}
										});

										const filteredResponse = response.filter(item => !matchedSid.has(item.specimenSeq)); //捨棄重複資料

										console.log("filteredResponse:", filteredResponse);

										const ResponseJson = JSON.stringify(filteredResponse);
										
										var e = performance.now();
										
										//console.log(response);
										//response = JSON.stringify(response);
										$.post("Function.php", {name: input, Data: ResponseJson, action: action, bedNo: bedNo, chartNo: chartNo, ptName: ptName, sex: sex, function: $function}, function($Json){
      	 					
											console.log($Json);
											$J = JSON.parse($Json);
											
											if($J.status == "success")
											{
							
												$("panitentInfo").html("");	
												$("panitentInfo").html($J.chartNo);
												$("roller").append($J.sid);	
												$("[box=scan][pos=chartNo]").val("");
												$("error").text("");
											
											}else{
												
												$("panitentInfo").html("");	
												$("panitentInfo").html($J.chartNo);
												$("error").text("重複刷圈");
												
											}
      	 						
										});
										
									},
         		
									error: function(xhr, status, error) {
        	
				 						console.error("Error:", error);
				 						$("panitentInfo").html("");	
					 					$("error").text("錯誤的條碼或查無資料");

									}
       					
								});
						
							}else{
								
								$("panitentInfo").html("");	
					 			$("error").text("錯誤的條碼或查無資料");
								
							}
					
							break;
						
							//掃描稽核
						case "sid":
					
							if($("IDP[use=chartNo]").text())
							{

								requestData = { sid: input, 
															  chartNo: $("IDP[use=chartNo]").attr("name"),
															  specimenClerk: $("[userid]").attr("userid") };
									
								console.log(requestData);
									
								//掃描稽核
								$.ajax({
								
									url: "https://192.168.1.195/api/NursingStationOracle/confirmPatient", 	
									method: "POST",
       						contentType: "application/json",
       						data: requestData, 
       						data: JSON.stringify(requestData),
        
     				 	 		success: function(response) {
        	
     			 	 				console.log(response);
     			 		 				
     			 	 				$("roller").find("table[name=" + input + "]").each(function(){
						
											$(this).css("color", "#6DB149");
											$(this).css("font-weight", "bold");
											
										});
										
										$("[box=scan][pos=sid]").val("");
										$("error").text(input + "稽核成功");
										

         					},
         		
         					error: function(xhr, status, error) {
         							
         						$("error").text("稽核失敗");

     	  					}
       					
								});
					
							}else{
						
								$("error").text("請先掃描病人手圈");
						
							}
								
							break;
							
					}
					
					break;
				
			}
		}

	});
	
	//輸入工號後enter跳轉下一個input
	/*$(document).on("keypress", "input[box=userid]", function(){
		
		console.log("Keypress event triggered");
		$("input[box=scan]").focus();

	});*/
	
	//畫面自動向下
	function scrollToBottom() {
		
    var roller = document.querySelector('roller');
    
    roller.scrollTop = roller.scrollHeight;
    
	}
	
	//病人備管自動向下
	function scrollToBottomIDP() {
		
    var roller = document.querySelector("roller[box=testTube][pos=mix]");
    
    roller.scrollTop = roller.scrollHeight;
    
	}
	
	//我的清單自動向下
	/*function scrollToBottomList() {
		
    var roller = document.querySelector("roller[box=testTube][pos=list]");
    
    roller.scrollTop = roller.scrollHeight;
    
	}*/
	
	//儲存列印格式
	$(document).on("click", "printcheck[box=button]", function(){
		
		var barcheck;
		var listcheck;
		
		if($("input[box=barcheck]").is(":checked"))
		{
								
			pkgbar = "pkgbar=1";
								
		}else{
			
			pkgbar = "pkgbar=0";
			
		}
							
		if($("input[box=listcheck]").is(":checked"))
		{
								
			pkglist = "pkglist=1";;
								
		}else{
			
			pkglist = "pkglist=0";
			
		}
		
		if($("[mCode]").attr("mCode") == "ER")
		{
			
			remark = $("space[machine]").attr("machine") + "=" + $("[machineIP]").attr("machineIP") + "|" + pkgbar + "^" + pkglist + "|" + $("[otherIP]").attr("otherIP");
			
		}else{
			
		  remark = $("space[machine]").attr("machine") + "=" + $("[machineIP]").attr("machineIP") + "|" + pkgbar + "^" + pkglist;
			
		}

		 ip = $("ip").attr("ip");
		 
		 requestData = { remark: remark,
		 								 mCode: ip };
		 								 
		 console.log(requestData);
		 								 
		 $.ajax({
   	 	
       	url: "https://192.168.1.195/api/NursingStation/updateRemark",
       	method: "POST",
       	contentType: "application/json",
       	data: requestData,
       	data: JSON.stringify(requestData), //轉Json
        
      	success: function(response) {
        	
      	 	console.log("Success:", response);
        	$("error").text("參數儲存成功，下次登入後生效");
 
        },
        
        error: function(xhr, status, error) {
        	
				 	console.error("Error:", error);
				 	$("error").text("儲存失敗");

       	}
 
     });
		
	});

	//關閉更多功能
  $(document).on("click", "button[id=close-dialog]", function(){
   	
   	$("more[box=floating-dialog][name=" + $(this).attr("name") + "]").css("display", "none");
   	
  });
  
  //table展開detial
  $(document).on("click", "table[use=mix][box=IDP], table[use=list][box=IDP]", function(){
  
  	name = $(this).attr("name");
  	action = $(this).attr("action");
  	$function = $(this).attr("function");
  	option = $(this).attr("pos");
  	mCode = $("[mCode]").attr("mCode");
  	
  	if($("td[use=number][pos=detial]").last().text() == "")
		{
						
			number = 1;
						
		}else{
						
			console.log($("td[use=number][pos=detial]").text());
			number = parseInt($("td[use=number][pos=detial]").last().text()) + 1;
						
		}	
  	
  	switch($(this).attr("pos"))
  	{
  		
  		case "default":
  		
  			startDay = "";
  			endDay = "";
  			shift = "";
  			
  			requestData = { chartNo: name,
  								  		nsCode: $("[mCode]").attr("mCode") };
  		
  			break;
  		
  		case "search":
  		
  			var startDay = $("input[type=date][name=start]").val()
  			var endDay = $("input[type=date][name=end]").val()
  			
  			shift = $("select[box=select][pos=shift]").val();
  			
  			requestData = { chartNo: name,
  								  		nsCode: $("[mCode]").attr("mCode"),
  								  		startDate: startDay,
  								  		endDate: endDay };
  			
  			//console.log(startDay);
  		
  			break;
  		
  	}
  	
  	console.log(requestData);
								
		$.ajax({
   	 	
      url: "https://192.168.1.195/api/NursingStationOracle/getInfoByChartNo",
      method: "POST",
      contentType: "application/json",
      data: requestData,
      data: JSON.stringify(requestData), //轉Json
        
      	success: function(response) {
        	
      	 	console.log("success:", response);

			const matchedLabNos = new Set(); //用來存放重複的資料

			const allLabNo = document.querySelectorAll('td[use="labNo"]'); //儲存所有labNo

			allLabNo.forEach(cell => { //歷遍labNo
            
				const labNo = cell.textContent.trim();
				// 如果 cell 的 labNo 在 response 中
            
				if (response.some(item => item.labNo === labNo)) {
                
					console.log("找到匹配的 labNo:", labNo);
					//cell.style.backgroundColor = 'yellow'; // 顯示重複
					matchedLabNos.add(labNo); //將匹配的labNo放入陣列
				}
			});

			const filteredResponse = response.filter(item => !matchedLabNos.has(item.labNo)); //捨棄重複資料

			console.log("filteredResponse:", filteredResponse);

			const ResponseJson = JSON.stringify(filteredResponse);
			
         	//response = JSON.stringify(response);
         			
         	$.post("Function.php", {Data: ResponseJson, action: action, store: "testTube", number: number,  function: $function, option: option, startDay: startDay, endDay: endDay, shift: shift, mCode: mCode}, function($Json){ 
         							
         		console.log($Json);
         		$J = JSON.parse($Json);
            		
           	if($J.status == "success")
         		{
         					
         			$("roller[box=testTube]").append($J.html);
         			$("error").text("");
         			scrollToBottomIDP();
         			//scrollToBottomList();
         					
         		}
         							
         	});
         	
        },
         		
        error: function(xhr, status, error) {
        	
				 	console.error("Error:", error);

       	}
         				
    });
  	
  });
  
  $(document).on("click", "clear[box=clear]", function(){
  	
  	$("roller[box=testTube]").html("");
  	
  });
  
  //設定
  $(document).on("click", "set[box=button]", function(){
  	
  	var regex = /^ER(-\d{2})?$/;
  	
  	switch($(this).attr("pos"))
  	{
  		
  		case "add":

			var otherIPVisible = $("input[box=otherIP][pos=add]").is(':visible');
        var otherIP = otherIPVisible ? $("input[box=otherIP][pos=add]").val().trim() : true;
  		
  			if($("input[box=dicCode][pos=add]").val() && $("input[box=dicName][pos=add]").val() && $("input[box=mCode][pos=add]").val() && $("select[box=mechine][pos=add]").val() && $("input[box=machineIP][pos=add]").val() && otherIP)
  			{
  		
  			if(regex.test($("input[box=dicCode][pos=add]").val()))
  			{
  				
  				remark = $("select[box=mechine][pos=add]").val() + "=" + $("input[box=machineIP][pos=add]").val() + "|other" + "|" + $("input[box=otherIP][pos=add]").val();
  				
  			}else{
  				
  				remark = $("select[box=mechine][pos=add]").val() + "=" + $("input[box=machineIP][pos=add]").val() + "|other";
  				
  			}
  		
  			requestData = { dic_Code: $("input[box=dicCode][pos=add]").val(),
											  dic_Name: $("input[box=dicName][pos=add]").val(),
											  m_Code: $("input[box=mCode][pos=add]").val(),
											  remarkType: remark };
	
				console.log(JSON.stringify(requestData));
	
				$.ajax({
         								
         		url: 	"https://192.168.1.195/api/NursingStation/IPandStation",
         		method: "POST",
         		contentType: "application/json",
         		data: requestData,
       			data: JSON.stringify(requestData), //轉Json
       									
       			success: function(response) {
        	
      	 			console.log("Success:", response);
      	 			$("error[pos=add]").text("新增成功");
			
      	 		},
      	 								
      	 		error: function(xhr, status, error) {
        	
				 			console.error("Error:", error);
				 			$("error[pos=add]").text("新增失敗");

       			}
         								
        });
  	}else{
        	
        	$("error[pos=add]").text("不可有空白欄位");
        	        	
        }
  			break;
  			
  		case "update":

			var otherIPVisible = $("input[box=otherIP][pos=update]").is(':visible');
        		var otherIP = otherIPVisible ? $("input[box=otherIP][pos=update]").val().trim() : true;
  		
  			if($("input[box=dicCode][pos=update]").val() && $("input[box=dicName][pos=update]").val() && $("input[box=mCode][pos=update]").val() && $("select[box=mechine][pos=update]").val() && $("input[box=machineIP][pos=update]").val() && otherIP)
  			{
  		
  				if(regex.test($("input[box=dicCode][pos=update]").val()))
  				{
  				
  					remark = $("select[box=mechine][pos=update]").val() + "=" + $("input[box=machineIP][pos=update]").val() + "|other" + "|" + $("input[box=otherIP][pos=update]").val();
  				
  				}else{
  				
  					remark = $("select[box=mechine][pos=update]").val() + "=" + $("input[box=machineIP][pos=update]").val() + "|other";
  				
  				}
  		
  				requestData = {  mCode: $("input[box=mCode][pos=update]").val(),
    										 newDicCode: $("input[box=dicCode][pos=update]").val(),
											 newDicName: $("input[box=dicName][pos=update]").val(),
    										 workstation: $("input[box=dicName][pos=update]").val(),
    										 insMan: $("[userid]").attr("userid"),
    										 remark: remark };
    										 
    				console.log(requestData);
						 
    				$.ajax({
    			
    					url: "https://192.168.1.195/api/NursingStation/updateDicCode",
    					type: "POST",
    					contentType: "application/json",														//轉換傳輸種類
          				data: JSON.stringify(requestData),
          
          				success: function(response) {


						console.log("success");
        					console.log(response);	
																											//檢視回傳內容
        					$("error[pos=update]").text("修改成功");
        					//location.reload();

    					},
    				
    					error: function(xhr, status, error) {
        		
        				console.error("error", error);
        				$("error[pos=update]").text("修改失敗");
    				
    					},
    			
    				});
		}else{
    			
    			$("error[pos=update]").text("不可有空白欄位");
    			
    		}
  		
  			break;
  		
  	}	
  	
  });
  
  //監視設定的input
  $(document).on("input change", "input[box=dicCode]", function(){
  	
  	var regex = /^ER(-\d{2})?$/;
  	
  	if(regex.test($(this).val()))
  	{
  		
  		$("input[box=otherIP][pos=" + $(this).attr("pos") + "]").css("display", "inline");
  		
  	}else{
  		
  		$("input[box=otherIP][pos=" + $(this).attr("pos") + "]").css("display", "none");
  		
  	}

  });
  
  //給號錯誤站存區
  $(document).on("click", "errorTube", function(){
  	
  	if($("errorTube[box=content]").css("width") == "0px")
  	{
  		
  		$("errorTube[box=content]").css("display", "block");
  		$("errorTube[box=content]").css("width", "300px");	
  		$("errorTube[box=bar]").css("left", "300px");
  		
  		if($("errorTube[box=icon]").css("display") == "block")
  		{
  			
  			$("errorTube[box=icon]").css("display", "none");
  			
  		}
  		
  	}else{
  		
  		$("errorTube[box=content]").css("display", "none");
  		$("errorTube[box=content]").css("width", "0px");
  		$("errorTube[box=bar]").css("left", "0px");	
  		
  	}

  });
  
  //工作清單的切換
  /*$(document).on("click", "[box=class]", function(){
	
		console.log($(this).attr("pos"));
		switch($(this).attr("pos"))
		{
			
			case "today":
			
				$("roller[option=today]").css("display", "block");
				$("roller[option=past]").css("display", "none");
				$("roller[option=future]").css("display", "none");
				$("roller[option=all]").css("display", "none");
				$("mixText[pos=today]").removeClass("change-inactive").addClass("change-active");
				$("mixText[pos=past]").removeClass("change-active").addClass("change-inactive");
        $("mixText[pos=future]").removeClass("change-active").addClass("change-inactive");
        $("mixText[pos=all]").removeClass("change-active").addClass("change-inactive");
        
        break;
        
      case "past":
			
				$("roller[option=today]").css("display", "none");
				$("roller[option=past]").css("display", "block");
				$("roller[option=future]").css("display", "none");
				$("roller[option=all]").css("display", "none");
				$("mixText[pos=today]").removeClass("change-active").addClass("change-inactive");
				$("mixText[pos=past]").removeClass("change-inactive").addClass("change-active");
        $("mixText[pos=future]").removeClass("change-active").addClass("change-inactive");
        $("mixText[pos=all]").removeClass("change-active").addClass("change-inactive");
        
        break;	  
				
			case "future":
			
				$("roller[option=today]").css("display", "none");
				$("roller[option=past]").css("display", "none");
				$("roller[option=future]").css("display", "block");
				$("roller[option=all]").css("display", "none");
				$("mixText[pos=today]").removeClass("change-active").addClass("change-inactive");
				$("mixText[pos=past]").removeClass("change-active").addClass("change-inactive");
        $("mixText[pos=future]").removeClass("change-inactive").addClass("change-active");
        $("mixText[pos=all]").removeClass("change-active").addClass("change-inactive");
        
        break;	
       
      case "all":
			
				$("roller[option=today]").css("display", "none");
				$("roller[option=past]").css("display", "none");
				$("roller[option=future]").css("display", "none");
				$("roller[option=all]").css("display", "block");
				$("mixText[pos=today]").removeClass("change-active").addClass("change-inactive");
				$("mixText[pos=past]").removeClass("change-active").addClass("change-inactive");
        $("mixText[pos=future]").removeClass("change-active").addClass("change-inactive");
        $("mixText[pos=all]").removeClass("change-inactive").addClass("change-active");
        
        break;	
			
		}	
		
	});*/
	
	//加入清單
	/*$(document).on("click", "td[use=add]", function(event){
	
		event.stopPropagation();
		console.log($(this).attr("chartNo"));
		
		requestData	=	{ nurseCode: $("[userid]").attr("userid"),
										bedNo: $(this).attr("bedNo"),
										chartNo: $(this).attr("chartNo") };
		
		$.ajax({
    			
    	url: "https://192.168.1.195/api/NursingStationOracle/AddToMyList",
    	type: "POST",
    	contentType: "application/json",														//轉換傳輸種類
      data: JSON.stringify(requestData),
          
      success: function(response) {

				console.log("success");
        console.log(response);	

    	},
    				
    	error: function(xhr, status, error) {
        		
        console.error("error", error);
        $("error").text("加入失敗");
    				
    	},
    			
    });
		
	});*/
  
  //刪除條碼
  $(document).on("click", "[option=deleteBarcode]", function(){
  	
  	console.log($(this).attr("name"));
  
  	/*$.post("Function.php", {action: "Plant", function: "checkDelete", labNo: $(this).attr("name")}, function($Json){
  	
  		console.log($Json);
  		$J = JSON.parse($Json);	
  		
  		$("mask").css("display", "flex");
			$("window").css("display", "block");
			$("window[box=window]").html($J);
  		
  	});	*/
  	
  });
  	
	//整批備管勾選功能
	/*$(document).on("click", "tr[box=detial]", function(event) {
		
    // 檢查點擊的元素是否是 moreOption 元素
    if ($(event.target).is("moreOption") || $(event.target).is("button[id=close-dialog]")) {
        // 如果是 moreOption 元素，停止事件處理
        return;
    }
    
    //fix click checkbox bug
    if ($(event.target).is("input[type=checkbox]")) {
    	
        var checkbox = $("input[box=checkbox][name='" + $(this).attr("name") + "'][number='" + $(this).attr("number") + "']");
    		checkbox.prop("checked", !checkbox.prop("checked"));
 
    }
    
    // 其他情況下，處理 checkbox 的勾選
    var checkbox = $("input[box=checkbox][name='" + $(this).attr("name") + "'][number='" + $(this).attr("number") + "']");
    checkbox.prop("checked", !checkbox.prop("checked"));
    
    var group = checkbox.attr('data-group');
    var allChecked = $('input[class=secondLayer][data-group="' + group + '"]').length === $('input[class=secondLayer][data-group="' + group + '"]:checked').length;
    $('input[class=firstLayer][data-group="' + group + '"]').prop('checked', allChecked);
    
    
	});
	
	//控制第一層checkbox全選與取消
	$(document).on("change", "input[class=firstLayer]", function(){
		
		$("input[class=secondLayer][data-group=" + $(this).attr("data-group") + "]").prop("checked", $(this).is(":checked"));	
		
	});
	
	//控制第二層checkbox與第一層checkbox的連動
	$(document).on("change", "input[class=secondLayer]", function(){
		
		var group = $(this).attr("data-group");
    // 檢查同組的所有第二層checkbox
    var allChecked = $("input[class=secondLayer][data-group=" + group + "]").length === $("input[class=secondLayer][data-group=" + group + "]:checked").length;
    // 如果有任意一個未勾選，則取消第一層checkbox的勾選
    $("input[class=firstLayer][data-group=" + group + "]").prop("checked", allChecked);
		
	});
	
	
	//全選與取消
	$(document).on("click", "tick", function(){
		
		console.log($(this).attr("pos"));
		
		if($("tick").text() == "取消")
		{
			
			$("input[type=checkbox][box=checkbox]").each(function(){
				
				if ($(this).prop("checked")) {
                        
           $(this).prop("checked", false);
           
        }
        
			});
			
			$(this).text("全選");

		}else if($("tick").text() == "全選"){
			
			$("input[type=checkbox][box=checkbox]").each(function(){
				
				if (!$(this).prop("checked")) {
                        
           $(this).prop("checked", true);
           
        }
        
			});
			
			$(this).text("取消");
			
		}
		
	});*/
	
	
        //整批備管
        /*case "allTestTube":
        
        	action = $(this).attr("action");
        
        	var Data = [];

					$("input[box=checkbox]:checked").each(function() {
						
    				var eachData = {};
    				
    				if ($(this).attr("class") == "firstLayer") {
    					
        			eachData["chartNo"] = $(this).attr("name");
        
    				} else {
    	
        			eachData["labNo"] = $(this).attr("name");
        
    				}
    
    				Data.push(eachData);
    
					});

					async function processChartNo(chartNo) {
    
    				let getLabNo = { chartNo: chartNo };
    				
    				try {
    					
        			let list = await $.ajax({
            	
            		url: "https://192.168.1.195/api/NursingStationOracle/getInfoByChartNo",
            		method: "POST",
            		contentType: "application/json",
            		data: JSON.stringify(getLabNo)
            		
        			});
        			
        			for (let item of list) {
        				
          		  let test = item.labNo;
            
            		if (test) {
              
                	let storeLabNo = { labNo: test };
                	let storeData = await $.ajax({
              
                    url: "https://192.168.1.195/api/NursingStationOracle/getLabOrderDetailsByLabNo",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(storeLabNo)
              
                	});
              
              		console.log("Success:", storeData);
                	storeData = JSON.stringify(storeData);
                	await $.post("Function.php", { Data: storeData, labNo: test, store: "testTube" });
            	
            		}
        			}
    
    				} catch (error) {
        
        			console.error("Error:", error);
        			
    				}
					}

					async function processLabNo(labNo) {
						
    				let storeLabNo = { labNo: labNo };
    			
    				try {
        
        			let storeData = await $.ajax({
            
            		url: "https://192.168.1.195/api/NursingStationOracle/getLabOrderDetailsByLabNo",
            		method: "POST",
            		contentType: "application/json",
            		data: JSON.stringify(storeLabNo)
        
        			});
        			
        			console.log("Success:", storeData);
        			storeData = JSON.stringify(storeData);
        
        			await $.post("Function.php", { Data: storeData, labNo: labNo, store: "testTube" });
    
    				} catch (error) {
    					
        			console.error("Error:", error);
    
    				}
					}

					async function processData() {
    
    				for (let item of Data) {
        
        			if (item.chartNo) {
            
            		await processChartNo(item.chartNo);
        
        			} else {
            
            		await processLabNo(item.labNo);
        			
        			}
    				}
					}

					(async function() {
    
    				await processData();

    				//生成給號資料
    				let ip, url;
    
    				if ($("[machine]").attr("machine") == "QQ") {
        
        			ip = $("ip").attr("ip");
        			url = "https://192.168.1.195/api/Barcode/generateAndCreateFile";
    
    				} else {
    					
        			ip = "";
       	 			url = "https://192.168.1.195/api/Barcode/generateBatchBarcode";
    
    				}

    				$.post("Function.php", { Data: Data, action: $(this).attr("action"), dicName: $("[dicName]").attr("dicName"), ip: ip }, function($Json) {
        		
        			console.log($Json);
        			var $J = JSON.parse($Json);
        			console.log("getBarcode:", $J);

        			for (let i = 0; i < $J.length; i++) {
            
            		let IsLabelOnly = $("input[box=IsLabelOnly]:checked").length ? "noTube" : "printTube";
            		let requestData = $J[i];
            		let Aplseq = requestData.Orders[0].Aplseq;
            		let ChartNo = requestData.ChartNo;
            		let labCode = requestData.Orders[0].LabCodes;

            		$.ajax({
                	
                	url: url,
                	method: "POST",
                	contentType: "application/json",
                	data: JSON.stringify(requestData),
                	success: function(response) {
                  
                    console.log("Success:", response[0].output);
                    if ($("[machine]").attr("machine") == "QQ") {
                  
                        $("error").text("備管成功");
                        $("roller[box=testTube]").html("");
                  
                    } else {
                  
                        $.post("Function.php", { Data: response[0].output, action: "Backup", Aplseq: Aplseq, chartNo: ChartNo, labCode: labCode, IsLabelOnly: IsLabelOnly }, function($Json) {
                  
                           console.log($Json);
                           var $J = JSON.parse($Json);
                           console.log("Backup:", $J);

                           for (let j = 0; j < $J.length; j++) {
               
                                let requestData = [$J[j]];
               
                                $.ajax({
               
                                   url: "https://192.168.1.195/api/Robo7/processAndForward",
                                   method: "POST",
                                   contentType: "application/json",
                                   data: JSON.stringify(requestData),
                                   success: function(response) {
             
                                        console.log("Success:", response);
                                        $("error").text("備管成功");
                                        $("roller[box=testTube]").html("");
             
                                   },
               
                                   error: function(xhr, status, error) {
                 
                                        console.error("Error:", error);
                                        $("error").text("備管失敗");
                
                                   }
                
                                });
                            }
                        });
                    }
                	},
                
                	error: function(xhr, status, error) {
                    
                    console.error("Error:", error);
                    
                    if ($("[machine]").attr("machine") == "QQ") {
                        $("error").text("備管失敗");
                    
                    }
                    
                	}
            		});
        			}
    				});
					})();
        
        break;*/  
        
      /*case "DAT":
      
      allSid = $(this).attr("sid");
      	
      	sid = allSid.split("|");
      	
      	for(let $i = 0; $i < sid.length; $i++)
      	{
      		
      		requestData = {sid: sid[$i]}
      		console.log(requestData);
      		
      		$.ajax({
      			
      			url: "https://192.168.1.195/api/Barcode/reprintBarcode",
      			method: "POST",
      			contentType: "application/json",
      			data: requestData, 
      			data: JSON.stringify(requestData),
      			
      			success: function(response) {
      				
      				console.log("success", response);
      				$("[pos=DAT]").css("display", "none");
      				$("error").text("重新列印成功");
      				
      			},
      			
      			error: function(xhr, status, error) {
      				
      				console.log("error", error);
      				$("error").text("重新列印失敗，請再試一次");
      				
      			}
      			
      		});
      		
      	}

      	break;*/
		

});