<?php

/* Copyright 2008 Mohd khazee */

require_once('includes/site.inc.php');


//
$loginurl = parse_url($_GET['loginurl']);
$query = $loginurl['query'];
parse_str($query, $uamopts);

if(isset($_GET['loginurl'])){
	$loginlink = "http://$lanIP/uam/mini?$query";
	$loginlink2 = $_GET['loginurl'];
}else{
	$loginlink = "http://$lanIP/uam/mini";
	$loginlink2 = "http://$lanIP:3990/prelogin";
}

$smarty->assign("user_url", $uamopts['userurl']);

$smarty->assign("loginlink", $loginlink);
$smarty->assign("loginlink2", $loginlink2);

$smarty->display('mini.tpl');

?>
