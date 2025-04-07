<?php

	class Shared
	{
		
		public static $pubVar 								= array();
		public static $unicode;
		
		function __construct(){}
		
		public static function randomString()
		{
		
			$rand["EngANDNum-UL"] 							= "1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,M,N,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,m,n,p,q,r,s,t,u,v,w,x,y,z";
			$randstr 														= explode(",", $rand["EngANDNum-UL"] );
			for($i = 0 ; $i < self::$pubVar["string_len"] ; $i++)
			{
				$rand 														= rand(0,count($randstr) - 1);
				$result[] 												= $randstr[$rand];
			}
		
			self::$pubVar["random_string"] 			= implode("",$result);

		}
		
		public static function parseArgs()
		{
		
			foreach(self::$pubVar["loadVars"] as $key => $var)
			{
				
				list($argKey, $argVar)					= explode("=", $var);
				$args[$argKey]									= $argVar;
				
			}	
			
			self::$pubVar["loadVars"]					= $args;
			
		}
		
		public static function directory_maker()
		{
			$dirs 															= explode("/",self::$pubVar["create_full_path"]);
			$appendir														= "";
			foreach($dirs as $key => $var)
			{
				if($key > 0)
				{
					$appendir												.= "/".$var;
					(!is_dir($appendir))	&& (mkdir($appendir,0777) AND chmod($appendir,0777));
				}
			}
		}
	
	}
	
	class CryptByOpenSSL
	{
		public static $pubVar = array();
	
		function __construct()
		{
			self::$pubVar["crypt_mode"]					= "AES-256-CBC";
			self::$pubVar["iterations"]					= 999;
		}
	
		public static function encrypt($string)
		{
			$key 																= hash_pbkdf2("sha512","public",$GLOBALS["mcrypt"]["sa"],self::$pubVar["iterations"],64);
			$encrypt														= openssl_encrypt($string,self::$pubVar["crypt_mode"],hex2bin($key),OPENSSL_RAW_DATA,$GLOBALS["mcrypt"]["iv"]);
		
			return base64_encode($encrypt);
		}
		
		public static function decrypt()
		{
    	$Jdata 															= json_decode(self::$pubVar["decrypt_string"],true);
    	try
    	{
				$sa 															= hex2bin($Jdata["sa"]);
				$iv  															= hex2bin($Jdata["iv"]);          
    	} 
    	catch(Exception $e)
    	{ 
    		return null; 
    	}
    	$encrypt 														= base64_decode($Jdata["encrypt"]);
    	$key 																= hash_pbkdf2("sha512","public",$sa,self::$pubVar["iterations"],64);
    	$decrypted													= openssl_decrypt($encrypt,self::$pubVar["crypt_mode"],hex2bin($key),OPENSSL_RAW_DATA,$iv);

    	return $decrypted;
		}
	}
	
	$CryptByOpenSSL = new CryptByOpenSSL();
	$Shared = new Shared();

?>