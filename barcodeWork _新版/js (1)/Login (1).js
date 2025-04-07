/* 讓中文生效 */

$(document).ready(function(){
	
		$.post("Function.php", {action: "getIP"}, function($Json){ //抓取IP檢驗註冊
    		
    	console.log($Json);
    	$J = JSON.parse($Json);
    			
    	var requestData = {ipAddress: $J};
    			
    	$.ajax({

         url: "https://192.168.1.195/api/NursingStation/validateIPAddress",
         type: "POST",			
         contentType: "application/json",														//轉換傳輸種類
         data: JSON.stringify(requestData),													//轉換格式
         /*xhrFields: {
    				withCredentials: true
  				},*/

         success: function(response) {
            
        	 console.log("success");
        	 console.log(response.message);														//檢視回傳內容
        	 
        	 if(response.message == "此IP未進行註冊，以下為已註冊IP清單")
        	 {

        	 		$.ajax({

      		      url: "https://192.168.1.195/api/NursingStation/checkIPandStation",
          		  type: "GET",			
            		//contentType: "application/json",									//轉換傳輸種類
            		//data: JSON.stringify(requestData),								//轉換格式

            		success: function(response) {
            
        					console.log("success");
        					console.log(response);														//檢視回傳內容
        					
        					$.post("Function.php", {ip: $J, action: "Plant", function: "setIP"}, function($Json){
        						
        						console.log($Json);
    								$J = JSON.parse($Json);
    			
    								$("login[box=window]").html("");	
    								$("login[box=window]").html($J);	
        						
        					});
			
								},
    				
    						error: function(xhr, status, error) {
        		
        					console.error("error", error);

    						},
        	 	
        	 		});
        			        			
    		 	 }else{
    		 	 	
    		 	 		console.log(response.jobClassData);
    		 	 		response.jobClassData.forEach(function($item){
    		 	 			
    		 	 			var option = $("<option></option>").attr("value", $item.dicCode).text($item.dicCode);
    		 	 			$("select[box=dicCode]").append(option);	
    		 	 			
    		 	 		});
    		 	 	
    		 	 }
    		 	 
    		 },
    				
    		 error: function(xhr, status, error) {
        		
        	 console.error("error", error);
    				
    		 }
            
      });	
    			
    });
	
		//登入
    $(document).on("click","login[option=login]", function(){					//Login APIversion
    	
    		$action = $(this).attr("action");

        var requestData = {
        	
            userId: $("[name=username]").val(),
            userPwd: $("[name=password]").val(),
            ipAddress: $("ip").attr("ip"),
            dicCode: $("select[box=dicCode]").val()
            
        };																															//轉換格式
        
        //console.log(requestData);																			//檢視格式
        
       	$.ajax({

            url: "https://192.168.1.195/api/NursingStation/login",
            type: "POST",			//URL
            contentType: "application/json",														//轉換傳輸種類
            data: JSON.stringify(requestData),													//轉換格式
           	
           	/*xhrFields: {
    					mozSystem: true
  					}, 												 																	//開啟自簽證
  					
            rejectUnauthorized: false,*/ 																	//關閉SSL驗證
            
            beforeSend: function() {
            
                console.log(requestData);
                
            },																												//檢視傳輸前的格式
            
            success: function(response) {
            
        			console.log("success");
        			console.log(response);										//檢視回傳內容
        			
        			if(response.message == "登入成功")								//呼叫php以導入內頁
        			{

        				$.post("Function.php", {isNurse: response.isNurse, Username: response.username, Userid: requestData.userId, Userpwd: requestData.userPwd, Userdata: response.userPower, JobClass: response.stationData, remark: response.remark, action: $action}, function($Json){ //requestData is API return data
        				
        					console.log($Json);																	//檢視PHP回傳內容
        					$J = JSON.parse($Json);
        					//console.log($J);
        					//console.log("test");	
        					
        					window.location.href = $J.url;
        					//window.location.reload(true);

        					
        				});
        				
        			}
        			        			
    				},
    				
    				error: function(xhr, status, error) {
        		
        			//console.error("error", error);
        			$("login[box=error]").css("display", "block");
    				
    				},
            
        });
    });
    
    /*$(document).on("click","login[pos=register]", function(){				//註冊帳號
    	
    	
    		$.post("Function.php", {action: $(this).attr("action"), function: $(this).attr("function")}, function($Json){
    			
    			console.log($Json);
    			$J = JSON.parse($Json);
    			
    			$("login[box=window]").html("");	
    			$("login[box=window]").html($J);
    			
    		});
    	
    });*/
    
    $(document).on("click","login[pos=setIP]", function(){				//註冊IP與護理站
    	
    		if($("input[name=dicCode]").val() == "ER")
  			{
  				
  				remark = $("select[box=mechine]").val() + "=" + $("input[name=machineIP]").val() + "|other" + "|" + $("input[name=otherIP]").val();
  				
  			}else{
  				
  				remark = $("select[box=mechine]").val() + "=" + $("input[name=machineIP]").val() + "|other";
  				
  			}

    		requestData = {  ipAddress: $("input[name=ip]").val(),
    										 dicCode: $("input[name=dicCode]").val(),
    										 remarkType: remark };
    										 
    		console.log(requestData);
						 
    		$.ajax({
    			
    			url: "https://192.168.1.195/api/NursingStation/settingStation",
    			type: "POST",
    			contentType: "application/json",														//轉換傳輸種類
          data: JSON.stringify(requestData),
          
          success: function(response) {
            
            
    				$.post("Function.php", {action: "saveCookie", dicCode: $("input[name=dicCode]").val(), machineIP: $("input[name=machineIP]").val()}, function($Json){
    			
    					console.log($Json);
    			
    				});

        		console.log("success");
        		console.log(response);																		//檢視回傳內容
        		location.reload();

    			},
    				
    			error: function(xhr, status, error) {
        		
        		console.error("error", error);
        		
    				
    			},
    			
    		});
    	
    });
    
    //監控註冊護理站的代碼輸入
    $(document).on("input change", "input[name=dicCode]", function(){
    	
    	var regex = /^ER(-\d{2})?$/;
    	
    	if(regex.test($(this).val()))
    	{
    		
    		$("login[box=inputIcon][option=otherIP]").css("display", "flex");
    		
    	}else{
    		
    		$("login[box=inputIcon][option=otherIP]").css("display", "none");
    		
    	}	
    	
    });
    
    $(document).on("click", "a[box=URL]", function(){
    
    		window.open("https://192.168.1.195/api/NursingStation/settingStation");
    	
    });
    
    $(document).on("click", "a[box=ill]", function(){
    
    		window.open("allowTheURL.pdf");
    	
    });
    
});
