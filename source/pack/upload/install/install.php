<?php
include '../../../system/db.class.php';
close_browse();
checkmobile() or strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') or exit('Access denied');
$id = intval(SafeRequest("id","get"));
$form = getfield('app', 'in_form', 'in_id', $id);
$plist = getfield('app', 'in_plist', 'in_id', $id);
$uid = getfield('app', 'in_uid', 'in_id', $id);
$points = getfield('user', 'in_points', 'in_userid', $uid);
$points > 0 or exit(header('location:'.getlink($id)));
$GLOBALS['db']->query("update ".tname('app')." set in_hits=in_hits+1 where in_id=".$id);
$GLOBALS['db']->query("update ".tname('user')." set in_points=in_points-1 where in_userid=".$uid);
if($form == 'iOS'){
	header('location:itms-services://?action=download-manifest&url='.$plist);
}else{
	header('location:'.$plist);
}
?>