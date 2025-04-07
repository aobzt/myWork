$(document).ready(function(){
	
	function showLoading()
	{
		
		$("mask[box=loading]").css("display", "flex");
		
	}
	
	function hideLoading()
	{
		
		$("mask[box=loading]").css("display", "none");
		
	}
	
	$(document).on("click", "[class]", function(){
		
		$class = $(this).attr("class");
	
		switch($class)
		{
			
			case "collect":

				$.post("Function.php", {class: $class, action: "Plant", function: "openTATDetial"}, function($Json){
							
					console.log($Json);
					$J = JSON.parse($Json);
					//console.log($J);
					$("mask[box=mask]").css("display", "flex");
					$("window").css("display", "block");
					$("window[box=window]").html($J);
							
				});

				break;
				
			case "oneTube":

				$.post("Function.php", {class: $class, action: "Plant", function: "openTATDetial"}, function($Json){
							
					console.log($Json);
					$J = JSON.parse($Json);
					$("mask[box=mask]").css("display", "flex");
					$("window").css("display", "block");
					$("window[box=window]").html($J);
							
				});
				
				break;
			
		}
		
	});

	$(document).on("click", "[pos=TATsearch]", function(){

		action = $(this).attr("action");
		$function = $(this).attr("function");

		$date = $("input[name=date]").val();
		
		var shouldBackup = 0;
		var alreadyBackup = 0;
		var alreadyPackage = 0;
		var allData = [];

		var loadingTimer = setTimeout(showLoading, 0);

		//First AJAX call wrapped in a Promise 應備管數
		var shouldBackupPromise = new Promise(function(resolve, reject) {

			url =  "https://192.168.1.195/api/TAT/ShouldPreparedByNsCode/" + $("[mCode]").attr("mCode");
			requestData = "date=" + $("input[name=date]").val();

    	$.ajax({
  
        url: url,
        method: "GET",
        contentType: "application/json",
		data: requestData,
  
        success: function(response) {
  
            console.log("success:", response);
            shouldBackup = response.count;
            console.log("Should Backup Count:", shouldBackup);
  
            resolve();
        },
  
        error: function(xhr, status, error) {
            console.log("error:", error);
            reject(error);
  
        }
  
    	});
		
		});

		//AJAX call wrapped in a Promise 已被管數
		var alreadyBackupPromise = new Promise(function(resolve, reject) {
  
		url = "https://192.168.1.195/api/TAT/HavePreparedByNsCode/" + $("[mCode]").attr("mCode");
		requestData = "date=" + $("input[name=date]").val();
  
    	$.ajax({
  
        url: url,
        method: "GET",
        contentType: "application/json",
		data: requestData,
  
        success: function(response) {
  
            console.log("success:", response);
            alreadyBackup = response.sameDayCount;
            console.log("Already Backup Count:", alreadyBackup);
            resolve();
  
        },
  
        error: function(xhr, status, error) {
  
            console.log("error:", error);
            reject(error);
  
        }
    	});
	
		});
		
		//AJAX call wrapped in a Promise 已打包數
		var alreadyPackagePromise = new Promise(function(resolve, reject){
			
			url = "https://192.168.1.195/api/TAT/HavePackagedTubesByNsCode/" + $("[mCode]").attr("mCode");
			requestData = "date=" + $("input[name=date]").val();
			
			$.ajax({
				
				url: url,
				method: "GET",
				contentType: "application/json",	
				data: requestData,
				
				success: function(response){
					
					console.log("success:", response);
					alreadyPackage = response.differentDayCount;
					console.log("Already Package Count:", alreadyPackage);
          resolve();
					
				},
				
				error: function(xhr, status, error)
				{
					
					console.log("error", error);
					reject(error);
					
				}
				
			});	
			
		});
		
		//AJAX call wrapped in a Promise 已送達數
		var signInPromise = new Promise(function(resolve, reject){
			
			url = "https://192.168.1.195/api/TAT/HaveCheckedInPackagesByNsCode/" + $("[mCode]").attr("mCode");
			requestData = "date=" + $("input[name=date]").val();
			
			$.ajax({
				
				url: url,
				method: "GET",
				contentType: "application/json",	
				data: requestData,
				
				success: function(response){
					
					console.log("success:", response);
					signIn = response.targetDayCount;
					console.log("SignIn Count:", signIn);
          resolve();
					
				},
				
				error: function(xhr, status, error)
				{
					
					console.log("error", error);
					reject(error);
					
				}
				
			});	
			
		});
		
		//AJAX call wrapped in a Promise 已送出數
		var signOutPromise = new Promise(function(resolve, reject){
			
			url = "https://192.168.1.195/api/TAT/HaveCheckedOutPackagesByNsCode/" + $("[mCode]").attr("mCode");
			requestData = "date=" + $("input[name=date]").val();
			
			$.ajax({
				
				url: url,
				method: "GET",
				contentType: "application/json",	
				data: requestData,
				
				success: function(response){
					
					console.log("success:", response);
					signOut = response.targetDayCount;
					console.log("SignOut Count:", alreadyPackage);
          resolve();
					
				},
				
				error: function(xhr, status, error)
				{
					
					console.log("error", error);
					reject(error);
					
				}
				
			});	
			
		});
		
		//採檢狀態
		var collectPromise = new Promise(function(resolve, reject){
			
			url = "https://192.168.1.195/api/TAT/ConfirmCheckByNsCode/" + $("[mCode]").attr("mCode");
			requestData = "date=" + $("input[name=date]").val();
			
			$.ajax({
				
				url: url,
				method: "GET",
				contentType: "application/json",	
				data: requestData,
				
				success: function(response){
					
					console.log("success:", response);
					collectPercent = (response.confirmedTubes / (response.confirmedTubes + response.notConfirmedTubes)) * 100;
					collectWord = response.confirmedTubes + " / " + (response.confirmedTubes + response.notConfirmedTubes);
					collectData = response.confirmedAplSeqSid;
					notCollectData = response.notConfirmedAplSeqSid;
					collectData = JSON.stringify(collectData);
					notCollectData = JSON.stringify(notCollectData);
					console.log("collectPercent:", collectPercent + "%");
					
          resolve();
					
				},
				
				error: function(xhr, status, error)
				{
					
					console.log("error", error);
					reject(error);
					
				}
				
			});	
			
		});
		
		//一碼化使用率
		var oneTubePromise = new Promise(function(resolve, reject){
			
			url = "https://192.168.1.195/api/TAT/CoverageByNsCode/" + $("[mCode]").attr("mCode");
			requestData = "date=" + $("input[name=date]").val();
			
			$.ajax({
				
				url: url,
				method: "GET",
				contentType: "application/json",	
				data: requestData,
				
				success: function(response){
					
					console.log("success:", response);
					oneTubePercent = (response.sqlServerData.count / response.oracleData.count) * 100;
					oneTubeWord = response.sqlServerData.count + " / " + response.oracleData.count;
					oneTubeData = response;
					oneTubeData = JSON.stringify(oneTubeData);
					console.log("oneTubePercent:", oneTubePercent);
					console.log("oneTubeData:", oneTubeData);
          resolve();
					
				},
				
				error: function(xhr, status, error)
				{
					
					console.log("error", error);
					reject(error);
					
				}
				
			});	
			
		});
		
		//時間差
		var TimePromise = new Promise(function(resolve, reject){
			
			url = "https://192.168.1.195/api/TAT/TimeDifferenceByNsCode/" + $("[mCode]").attr("mCode");
			requestData = "date=" + $("input[name=date]").val();
			
			$.ajax({
				
				url: url,
				method: "GET",
				contentType: "application/json",	
				data: requestData,
				
				success: function(response){
					
					console.log("success:", response);
					Time = response;
					console.log("Time:", Time);
          resolve();
					
				},
				
				error: function(xhr, status, error)
				{
					
					console.log("error", error);
					reject(error);
					
				}
				
			});	
			
		});
		

		// Using Promise.all to ensure both AJAX calls complete
		Promise.all([shouldBackupPromise, alreadyBackupPromise, alreadyPackagePromise, signInPromise, signOutPromise, collectPromise, oneTubePromise, TimePromise]).then(function() {
  
  		console.log(allData);
  
    	//應備管/已備管
    	var percentage = (alreadyBackup / shouldBackup) * 100;

    	if(isNaN(percentage) || percentage == Infinity)
    	{
    		
    		percentage = 0;
    		
    	}else if(percentage > 100){
    		
    		percentage = 100;
    		
    	}
    	
    	var BackupPercentage = percentage.toFixed(0);
    	console.log("Percentage of backups completed:", BackupPercentage + "%");
		
		var BackupWord = alreadyBackup + " / " + shouldBackup;
		
		//採檢率
		if(isNaN(collectPercent) || collectPercent == Infinity)
    	{
    		
			collectPercent = 0;
    		
    	}else if(collectPercent > 100){
			
			collectPercent = 100;
			
		}
		collectPercent = collectPercent.toFixed(0);
		console.log("Percentage of collect completed:", collectPercent+ "%");

    	// Update UI with this percentage using JavaScript
    	//var element = document.querySelector("div[box=alreadyBackup][pos=backupStatus][class=graph]");
    	//element.style.setProperty("--percentage", formattedPercentage);
    	
    	//已備管/已打包
    	var percentage = (alreadyPackage / alreadyBackup) * 100;
    	
    	if(isNaN(percentage) || percentage == Infinity)
    	{
    		
    		percentage = 0;
    		
    	}else if(percentage > 100){
    		
    		percentage = 100;
    		
    	}

    	var PackagePercentage = percentage.toFixed(0);
    	console.log("Percentage of package completed:", PackagePercentage + "%");
		
		var packagedWord = alreadyPackage + " / " + alreadyBackup;
		
		//一碼化使用率
		if(isNaN(oneTubePercent) || oneTubePercent == Infinity)
    	{
    		
			oneTubePercent = 0;
    		
    	}else if(oneTubePercent > 100){
			
			oneTubePercent = 100;
			
		}
		oneTubePercent = oneTubePercent.toFixed(0);
		console.log("Percentage of collect completed:", oneTubePercent+ "%");
    	
    	//全部
    	/*var percentage = (alreadyPackage / shouldBackup) * 100;
    	
    	if(isNaN(percentage) || percentage == Infinity)
    	{
    		
    		percentage = 0;
    		
    	}else if(percentage > 100){
    		
    		percentage = 100;
    		
    	}
    	
    	var AllPercentage = percentage.toFixed(2);
    	console.log("Percentage of all completed:", AllPercentage + "%");*/
    	
    	//簽出
    	var percentage = (signOut / alreadyPackage) * 100;
    	//console.log(percentage);
    	
    	if(isNaN(percentage) || percentage == Infinity)
    	{
    		
    		percentage = 0;
    		
    	}else if(percentage > 100){
    		
    		percentage = 100;
    		
    	}
    	
    	var signOutPercentage = percentage.toFixed(0);
    	console.log("Percentage of sign completed", signOutPercentage + "%");
		
		var signOutWord = signOut + " / " + alreadyPackage;
    	
    	//簽入
    	var percentage = (signIn / signOut) * 100;
    	
    	if(isNaN(percentage) || percentage == Infinity)
    	{
    		
    		percentage = 0;
    		
    	}else if(percentage > 100){
    		
    		percentage = 100;
    		
    	}
    	
    	var signInPercentage = percentage.toFixed(0);
    	console.log("Percentage of sign completed", signInPercentage + "%");
		
		var signInWord = signIn + " / " + signOut;
    	
    	$.post("Function.php", {date: $date, collectPercent: collectPercent/*採檢率*/, collectWord: collectWord, oneTubePercent: oneTubePercent/*一碼率*/, oneTubeWord: oneTubeWord, Time: Time/*時間差*/, BackupPercentage: BackupPercentage/*備管狀態*/, BackupWord: BackupWord, PackagePercentage: PackagePercentage/*打包狀態*/, packagedWord: packagedWord, signInPercentage: signInPercentage/*送達率*/, signInWord: signInWord, signOutPercentage: signOutPercentage/*送出率*/, signOutWord: signOutWord, collectData: collectData/*已採檢*/, notCollectData: notCollectData/*未採檢*/,  oneTubeData: oneTubeData/*一碼化*/, action: action, function: $function}, function($Json){
    		
    		console.log($Json);
    		$J = JSON.parse($Json);
			console.log($J);
			$("home").html("");
			$("home").html($J);
			
			var RcvData = [];
			var InsData = [];
			
			for(var $i = 0; $i < Time.length; $i++)
			{
				
				RcvData.push({"frequency": $i + 1, "Lag": Time[$i]["timeDifferenceRcvTrans"]});
				InsData.push({"frequency": $i + 1, "Lag": Time[$i]["timeDifferenceInsTrans"]});
				
			}
			
			console.log("Rcv:", RcvData);
			console.log("Ins:", InsData);
			
			var ctx = document.querySelector('canvas[use="Trans"]').getContext('2d');
  			var chart = new Chart(ctx, {
          	type: "line",
          	data: {
            	labels: RcvData.map(x=>x.frequency),
            	datasets: [{
            	  label: "送達時間差(送出到送達的時差)",
            	  data: RcvData.map(x => {
              	  var timeParts = x.Lag.split(':');
               	 return parseInt(timeParts[0]) * 3600 + parseInt(timeParts[1]) * 60 + parseInt(timeParts[2]);
              	}),
              	lineTension: 0,
              	backgroundColor: "#FF5376",
              	borderColor: "#FF5376",
              	fill: false,
              	borderWidth: 2,
              	pointRadius: 5,
              	pointHoverRadius: 7,
            	}]
          	},
          	options: {
            	title: {
              	display: true,
              	text: "護理站代碼: " + $("[mCode]").attr("mCode") + " 送出送達時間差",
              	position: "bottom",
              	fontSize: 24,
              	fontStyle: "normal",
              	fontFamily: "Century Gothic"
            	},
            	legend: {
              	display: false
            	},
            	responsive: false,
            	scales: {
              	yAxes: [{
                	ticks: {
                  	callback: function(value) {
                    	var hours = Math.floor(value / 3600);
                    	var minutes = Math.floor((value % 3600) / 60);
                    	var seconds = value % 60;
                    	return hours + ':' + minutes + ':' + seconds;
                  	}
                	}
              	}]
            	}
         	  }
        	});
			
			var ctx = document.querySelector('canvas[use="package"]').getContext('2d');
  			var chart = new Chart(ctx, {
          	type: "line",
          	data: {
            	labels: InsData.map(x=>x.frequency),
            	datasets: [{
            	  label: "送出時間差(打包到送出的時間差)",
            	  data: InsData.map(x => {
              	  var timeParts = x.Lag.split(':');
               	 return parseInt(timeParts[0]) * 3600 + parseInt(timeParts[1]) * 60 + parseInt(timeParts[2]);
              	}),
              	lineTension: 0,
              	backgroundColor: "#FF5376",
              	borderColor: "#FF5376",
              	fill: false,
              	borderWidth: 2,
              	pointRadius: 5,
              	pointHoverRadius: 7,
            	}]
          	},
          	options: {
            	title: {
              	display: true,
              	text: "護理站代碼: " + $("[mCode]").attr("mCode") + " 打包送出時間差",
              	position: "bottom",
              	fontSize: 24,
              	fontStyle: "normal",
              	fontFamily: "Century Gothic"
            	},
            	legend: {
              	display: false
            	},
            	responsive: false,
            	scales: {
              	yAxes: [{
                	ticks: {
                  	callback: function(value) {
                    	var hours = Math.floor(value / 3600);
                    	var minutes = Math.floor((value % 3600) / 60);
                    	var seconds = value % 60;
                    	return hours + ':' + minutes + ':' + seconds;
                  	}
                	}
              	}]
            	}
         	  }
        	});
			
			hideLoading();

    	});

    	// Now get the updated percentage using JavaScript
    	//var computedStyle = getComputedStyle(element);
    	//var updatedPercentage = computedStyle.getPropertyValue("--percentage");
    	//console.log("Updated Percentage:", updatedPercentage);

		}).catch(function(error) {
  
    	console.error("An error occurred:", error);
	
		});

	});
	

});