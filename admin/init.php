<?php   

include 'connect.php';
// routing

$tpl  = './includes/templates/';
$lang = './includes/language/';
$func = './includes/functions/';
$css  = '/e-commerce/admin/layout/css/';
$js   = './layout/js/';


// include file
include $func  . 'functions.php';
include $lang  . 'eng.php';
include $tpl   . 'header.php'; 

// include navbar on all pages expect the one with $nonavbar

if(!isset($nonavbar)){include $tpl . 'navbar.php';}



?>