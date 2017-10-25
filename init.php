<?php

include 'connect.php';

$TempDir = 'Includes/Templates/';
$FuncDir = 'Includes/Functions/';
$CSSDir = 'Layout/CSS/';
$JSDir = 'Layout/JS/';



include $FuncDir . 'functions.php';
include $TempDir . 'header.php';

// Include navabr On All Pages Except The Page Has Variable
if (!isset($noNavbar)) { // if the Page Don't has variable name is $noNavbar include the navbar

	include $TempDir . 'navbar.php';

}


?>