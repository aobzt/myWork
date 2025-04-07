<?php

	class SQLEvent
	{
		
		public static $connect;
		public static $statement;
		public static $result;
		public static $fetch;
		public static $RealUnicode;
		
		function __construct(){}
		
		public static function connectDB()
		{
			$hoster 																																	  = $GLOBALS["db"]["driver"]. ";client charset=UTF-8;host=" .$GLOBALS["db"]["host"]. ":" .$GLOBALS["db"]["port"];
			self::$connect																														  = new PDO($hoster, $GLOBALS["db"]["username"], $GLOBALS["db"]["password"]);
			self::$connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		}
		
		public static function PDOEvent()
		{
			
			    self::$result 																													= self::$connect -> query(self::$statement);
   				foreach(self::$result -> fetchAll(PDO::FETCH_ASSOC) as $key => $var)
						$t[$key]																															= $var;
					self::$fetch 																														= $t;
			
		}
		
		public static function CheckUnicode($unicode)
		{

			self::$statement 																														= "SELECT unicode FROM custom_account";
			self::$result = self::$connect->query(self::$statement);

			if (self::$result !== false) {
    		$data = self::$result->fetchAll(PDO::FETCH_ASSOC);
    
   		 	foreach ($data as $record) {
        	$unicodeValue 																													= $record['unicode'];
        
        	if ($unicodeValue == $unicode) {
            $unicode 																															= "";
            self::createUnicode();
        	}
    		}
			}
			
			self::$RealUnicode 																													= $unicode;
			
		}
		
	}
	
	$SQLEvent = new SQLEvent();
		

?>