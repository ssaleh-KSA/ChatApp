<?php

$dsn = 'mysql: host=localhost; dbname=id3377573_chatapp';
$user = 'id3377573_chatappuser';
$pass = 'SASA1237895salehalsaleh';
$option = array(

	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

);

try {

	$con = new PDO($dsn, $user, $pass, $option);
	$con-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch (PDOException $e) {

	echo "Faild To Connect" . $e->getMessage();

}