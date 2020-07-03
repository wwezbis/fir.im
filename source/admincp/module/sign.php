<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(3);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>签名管理</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<link href="static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function s(){
        var k=document.getElementById("search").value;
        if(k==""){
                asyncbox.tips("请输入要查询的关键词！", "wait", 1000);
                document.getElementById("search").focus();
                return false;
        }else{
                document.btnsearch.submit();
        }
}
</script>
</head>
<body>
<?php
switch($action){
	case 'keyword':
		$key = SafeRequest("key","get");
		$sql = "select * from ".tname('sign')." where in_aname like '%".$key."%' or in_site like '%".$key."%' order by in_time desc";
		main($sql,20);
		break;
	default:
		$status = SafeRequest("status","get");
		if(is_numeric($status)){
		        $sql = "select * from ".tname('sign')." where in_status=$status order by in_time desc";
		}else{
		        $sql = "select * from ".tname('sign')." order by in_time desc";
		}
		main($sql,20);
		break;
	}
?>
</body>
</html>
<?php
function main($sql,$size){
	global $db;
	$Arr=getpagerow($sql,$size);
	$result=$Arr[1];
	$count=$Arr[2];
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'EarCMS Board 管理中心 - 应用 - 签名管理';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='应用&nbsp;&raquo;&nbsp;签名管理';</script>
<div class="floattop"><div class="itemtitle"><h3>签名管理</h3></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>可以输入应用名称、来源站点等关键词进行搜索</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<tr><td>
<input type="hidden" name="iframe" value="sign">
<input type="hidden" name="action" value="keyword">
关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<select onchange="location.href=this.options[this.selectedIndex].value;">
<option value="?iframe=sign">不限状态</option>
<option value="?iframe=sign&status=1"<?php if(isset($_GET['status']) && $_GET['status'] == 1){echo " selected";} ?>>正在签名</option>
<option value="?iframe=sign&status=2"<?php if(isset($_GET['status']) && $_GET['status'] == 2){echo " selected";} ?>>签名完成</option>
</select>
<input type="button" value="搜索" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>应用名称</th>
<th>来源站点</th>
<th>签名状态</th>
<th>签名证书</th>
<th>签名时间</th>
</tr>
<?php if($count == 0){ ?>
<tr><td colspan="2" class="td27">没有签名</td></tr>
<?php
}else{
while($row = $db->fetch_array($result)){
?>
<tr class="hover">
<td><?php echo $row['in_id']; ?></td>
<td><a href="<?php echo $row['in_ssl'].$row['in_site'].$row['in_path'].'app.php/'.$row['in_aid']; ?>" target="_blank" class="act"><?php echo str_replace(SafeRequest("key","get"), '<em class="lightnum">'.SafeRequest("key","get").'</em>', $row['in_aname']); ?>[<?php echo $row['in_aid']; ?>]</a></td>
<td><?php echo str_replace(SafeRequest("key","get"), '<em class="lightnum">'.SafeRequest("key","get").'</em>', $row['in_site']); ?></td>
<td><?php echo $row['in_status'] > 1 ? '签名完成' : '<em class="lightnum">正在签名</em>'; ?></td>
<td><?php echo $row['in_cert']; ?></td>
<td><?php if(date('Y-m-d', $row['in_time']) == date('Y-m-d')){echo '<em class="lightnum">'.date('Y-m-d H:i:s', $row['in_time']).'</em>';}else{echo date('Y-m-d', $row['in_time']);} ?></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<?php echo $Arr[0]; ?>
</table>
</div>
<?php } ?>