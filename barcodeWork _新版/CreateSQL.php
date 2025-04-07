<?php
//Database credentials
$servername 																	= "127.0.0.1";
$username 																		= "root";
$password 																		= "t3433433";
$dbname 																			= "eckdb";

// Create connection
$conn 																				= new mysqli($servername, $username, $password);

// Check connection
if ($conn -> connect_error) {
    die("Connection failed: " . $conn -> connect_error);
}

// Create database
$sql 																					= "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql)) {
    //echo "Database created successfully or already exists.<br>";
} else {
    echo "Error creating database: " . $conn -> error . "<br>";
}

// Select database
$conn -> select_db($dbname);

// Create table
//暫存給號
$sql 																					= "CREATE TABLE IF NOT EXISTS GetBarCodeList (
    
    																							id INT AUTO_INCREMENT PRIMARY KEY,
    																							ChartNo varchar(20), PtName varchar(30), Aplseq varchar(20), mCode varchar(5), specimenPan varchar(30), ClinicFlag varchar(5), SpecimenCode varchar(10), 
    																							UrgentFlag varchar(5), orderDate varchar(10), orderTime varchar(10), labCode varchar(20)

																								)";

$conn -> query($sql);

//暫存備管
$sql 																					= "CREATE TABLE IF NOT EXISTS BackupList (
    
    																							id INT AUTO_INCREMENT PRIMARY KEY,
    																							ChartNo varchar(20), PtName varchar(30), Aplseq varchar(20), mCode varchar(5), specimenPan varchar(30), ClinicFlag varchar(5), SpecimenCode varchar(10), 
    																							UrgentFlag varchar(5), specimenName varchar(30), specimenSeq varchar(30), labCode varchar(30)

																								)";

$conn -> query($sql);
																								
//計算張數(用於小包)
/*$sql 																					= "CREATE TABLE IF NOT EXISTS orderCount (
    
    																							id INT AUTO_INCREMENT PRIMARY KEY,
    																							Aplseq varchar(20), orderCount int(20)

																								)";

$conn -> query($sql);*/


//唯一碼放置區
$sql 																					= "CREATE TABLE IF NOT EXISTS token (
    
    																							id INT AUTO_INCREMENT PRIMARY KEY,
    																							unicode varchar(20), listNo varchar(20)

																								)";

$conn -> query($sql);

//小包暫存
$sql 																					= "CREATE TABLE IF NOT EXISTS package (
    
    																							id INT AUTO_INCREMENT PRIMARY KEY,
    																							dicCode varchar(10), ptUnicode varchar(30), bedNo varchar(15), ChartNo varchar(20), PtName varchar(30), sex varchar(2), Aplseq varchar(20), mCode varchar(5), UrgentFlag varchar(5), specimenCode varchar(10), 
    																							specimenName varchar(30), specimenSeq varchar(30), specimenPan varchar(30), specimenDate varchar(10), specimenTime varchar(10), specimenClerk varchar(30),
    																							srorageDate varchar(10)

																								)";

$conn -> query($sql);

//更新小包用
$sql 																					= "CREATE TABLE IF NOT EXISTS updatePackage (
    
    																							id INT AUTO_INCREMENT PRIMARY KEY,
    																							dicCode varchar(10), ptUnicode varchar(30), bedNo varchar(15), ChartNo varchar(20), PtName varchar(30), sex varchar(2), Aplseq varchar(20), mCode varchar(5), UrgentFlag varchar(5), specimenCode varchar(10), 
    																							specimenName varchar(30), specimenSeq varchar(30), specimenPan varchar(30), specimenDate varchar(10), specimenTime varchar(10), specimenClerk varchar(30),
    																							srorageDate varchar(10)

																								)";

$conn -> query($sql);

//暫存QQ備管Output
$sql 																					= "CREATE TABLE IF NOT EXISTS packagedContent (
    
    																							id INT AUTO_INCREMENT PRIMARY KEY,
    																							unicode varchar(20), listNo varchar(20), Aplseq varchar(20), specimenSeq varchar(30), status varchar(1) 

																								)";

$conn -> query($sql);

//error Log
$sql 																					= "CREATE TABLE IF NOT EXISTS Log (
    
    																							id INT AUTO_INCREMENT PRIMARY KEY,
    																							unicode varchar(20), listNo varchar(20), Aplseq varchar(20), specimenSeq varchar(30), date varchar(15), time varchar(10), type varchar(20), log text

																								)";

$conn -> query($sql);


//Close connection
$conn->close();
?>