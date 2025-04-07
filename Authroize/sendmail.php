<?php

		class sendmail
		{
			
			public static $pubVar																								= array();
			public static $subject;
			public static $content;
			public static $useremail;
			public static $maincontent;
			public static $thr_title;
			
			public static function mailcontent()
			{
				
				header('Content-Type: text/html; charset=utf-8');

				$Logo																															= "src = https://192.168.1.173/image/OsunLogo2018.JPS";
				$companyName 																											= "Osun";
				$subtitle																													= "咸陽科技股份有限公司";
				//$thr_title																												= "感謝您加入我們！";
				$companyinfo																											= "遇到問題? 歡迎聯絡我們：<br>電話：04-24529538<br>傳真：04-24529236<br>Email：osun@mail.7lab.com.tw<br>公司地址：台中市西屯區台灣大道三段650巷16弄9號";
				$fromemail																												= "osun7lab@gmail.com";
				
				
				list($content1, $content2)																				= explode("|", self::$content);	

				$subject 																													= self::$subject;
				$message 																													= '<html><head><meta charset="UTF-8"></head><body>';
				$message 																												 .= '<div style="text-align: center; font-family: Arial, sans-serif; color: #333; width: 600px; margin: 0 auto;">';
				$message 																												 .= '<div style="background-color: #f5f5f5; padding: 30px; border: 2px solid #ccc; border-radius: 10px;">';
				$message 																												 .= '<div style="margin-bottom: 20px;">';
				// $message 																										 .= '<img src="' .$Logo. '" alt="Company Logo" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">';
				$message 																												 .= '<h1 style="display: inline; color:#0090FF; font-size: 30px; margin-bottom: 5px;">' . $companyName . '<br>' .$subtitle. '</h1>';
				$message 																												 .= '</div>';
				$message 																												 .= '<h2 style="color: #009FCC; font-size: 26px;">' .self::$thr_title. '</h2>';
				$message 																												 .= '<p style="font-size: 18px;">' .$content1. '</p>';
				$message 																												 .= self::$maincontent;
				$message 																												 .= '<p style="font-size: 16px; margin-top: 20px;">' .$content2. '<br><br></p>';
				$message 																												 .= '<div id=comapny style="text-align: left;">'; // This line is modified
				$message 																												 .= '<p style="font-size: 14px">' .$companyinfo. '</p>';
				$message 																												 .= '</div>';
				$message 																												 .= '</div>';
				$message 																												 .= '</div>';
				$message 																												 .= '</body></html>';

				$headers 																													= 'MIME-Version: 1.0' . "\r\n";
				$headers 																												 .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers 																												 .= "From: " .$fromemail;

				mail(self::$useremail, $subject, $message, $headers);
		
			}
			
		}

	$sendmail = new sendmail();

?>

