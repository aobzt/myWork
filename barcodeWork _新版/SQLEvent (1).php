<?php

class SQLEvent{
	
	/*public static $Oracleconn;
	public static $Oraclequery;
	public static $Oraclefetch;
	
	public static $MSSQLconnect;
	public static $MSSQLstatement;
	public static $MSSQLresult;
	public static $MSSQLfetch;*/
	
	public static $MySQLconnect;
	public static $MySQLstatement;
	public static $MySQLresult;
	public static $MySQLfetch;

	function __construct()
	{
		
		//self::DBconnect();
		//self::DBEvent();	
		
	}
	
	public static function MySQLconnect()
	{
		
		$servername = "127.0.0.1";
		$username = "root";
		$password = "t3433433";
		$dbname = "eckdb";

		// Create connection
		self::$MySQLconnect = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if (self::$MySQLconnect->connect_error) {
    	die("Connection failed: " . self::$MySQLconnect->connect_error);
		}
		
	}
	
	public static function MySQLDBEvent()
	{
		
		self::$MySQLresult =  self::$MySQLconnect -> query(self::$MySQLstatement);
		
		foreach(self::$MySQLresult as $key => $var)
		{
			$t[$key]																																				= $var;
			self::$MySQLfetch 																															= $t;
		}
		
	}

	/*public static function MSSQLDBConnect()
	{
		
		//$hoster 																																	  		= "dblib:version=8.0;client charset=UTF-8;host=192.168.1.252:1433;dbname=TCosundb";
		$hoster 																																	  		= "dblib:version=8.0;client charset=UTF-8;host=192.168.1.253:1433;dbname=eckdb";
		self::$MSSQLconnect																														  = new PDO($hoster, "osun", "osun000");
		self::$MSSQLconnect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		
	}
		
	public static function MSSQLDBEvent()
	{
			
		self::$MSSQLresult 																															= self::$MSSQLconnect -> query(self::$MSSQLstatement);
   	foreach(self::$MSSQLresult -> fetchAll(PDO::FETCH_ASSOC) as $key => $var)
		$t[$key]																																				= $var;
		self::$MSSQLfetch 																															= $t;
			
	}

	public static function OracleDBConnect()
	{
		
		$host = '192.168.1.253'; 
		$port = '1521'; 
		$dbname = 'ORCL253-lam'; 
		$username = 'c##lam';
		$password = 'osun000#';
		$SID = 'orcl';
	
		self::$Oracleconn 																															= oci_connect($username, $password, "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SID=$SID)))");
		
		if (!self::$Oracleconn) {
    	$e 																																						= oci_error();
    	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
	
	}

	public static function OracleDBEvent()
	{
		
		//self::$query = 'SELECT * FROM labx1'; 
    $Oraclestatement 																																= oci_parse(self::$Oracleconn, self::$Oraclequery);
    
    if (!$Oraclestatement) {
        $e 																																					= oci_error(self::$Oracleconn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
    $Oracleresult = oci_execute($Oraclestatement);
    if (!$Oracleresult) {
        $e 																																					= oci_error($Oraclestatement);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
   
    while ($row = oci_fetch_assoc($Oraclestatement)) {
        self::$Oraclefetch[]																												= $row; 
    }
    
		//print_r(self::$fetch);
		
	}*/

}

$SQLEvent = new SQLEvent();

?>