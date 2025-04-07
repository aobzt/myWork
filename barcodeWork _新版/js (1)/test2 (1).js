$(document).ready(function() {
	
    labNo = "LI132D0023";
		specimenSeq = "B39301S0003";
							
		requestData = { chartNo: "0009898417" };
		
					console.log(JSON.stringify(requestData));
												
					$.ajax({
   	 	
       			url: "https://192.168.1.195/api/NursingStationOracle/confirmChartNo",
       			method: "POST",
      			contentType: "application/json",
       			data: requestData,
       			data: JSON.stringify(requestData), //轉Json
        
       			success: function(response) {
        	
      	 			console.log("Success:", response);
         			//$("error").text("刪除成功");
         			//$("table[name=" + labNo + "]").remove();
            
       			}
        
    			});

});