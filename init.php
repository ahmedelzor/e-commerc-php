<?php


// error

ini_set('display_errors' , 'On');
error_reporting(E_ALL);

include './admin/connect.php';

$sessionUser = '';
if(isset($_SESSION['user'])){
    $sessionUser =$_SESSION['user'];
    
}
// routing

$tpl  = './includes/templates/';
$lang = './includes/language/';
$func = './includes/functions/';
$css  = '/e-commerce/layout/css/';
$js   = './layout/js/';


// include file
include $func  . 'functions.php';
include $lang  . 'eng.php';
include $tpl   . 'header.php'; 



?>