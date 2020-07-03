<?php
include '../system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
header("Access-Control-Allow-Origin: ".(isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : NULL));
header("Access-Control-Allow-Credentials: true");
$status = SafeRequest("status","get");
$site = SafeRequest("site","get");
$id = intval(SafeRequest("id","get"));
getfield('secret', 'in_id', 'in_site', str_replace('www.', '', $site)) or exit('-1');
if($status < 2){
	$ssl = SafeRequest("ssl","get");
	$path = SafeRequest("path","get");
	$ipa = SafeRequest("ipa","get");
	$replace = SafeRequest("replace","get");
	$charset = SafeRequest("charset","get");
	$name = SafeRequest("name","get");
	$sid = $GLOBALS['db']->getone("select in_id from ".tname('sign')." where in_site='$site' and in_aid=".$id);
	$cert = $GLOBALS['db']->getone("select in_dir from ".tname('cert')." order by rand()");
	$setarr = array(
		'in_aid' => $id,
		'in_aname' => @convert_utf8($name, $charset),
		'in_replace' => $replace,
		'in_ssl' => $ssl,
		'in_site' => $site,
		'in_path' => $path,
		'in_ipa' => $ipa,
		'in_status' => 1,
		'in_cert' => $cert,
		'in_time' => time()
	);
	if($sid){
		updatetable('sign', $setarr, array('in_id' => $sid));
	}else{
		inserttable('sign', $setarr);
	}
	echo '1';
}else{
	$sid = $GLOBALS['db']->getone("select in_id from ".tname('sign')." where in_site='$site' and in_aid=".$id);
	if($sid){
		updatetable('sign', array('in_status' => 2,'in_time' => time()), array('in_id' => $sid));
		echo '1';
	}
}
?>