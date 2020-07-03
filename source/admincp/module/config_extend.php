<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(2);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>扩展配置</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
function change(type){
        if(type==1){
            $('remote').style.display='';
        }else if(type==2){
            $('remote').style.display='none';
        }
}
</script>
</head>
<body>
<?php
switch($action){
	case 'save':
		save();
		break;
	default:
		main();
		break;
	}
?>
</body>
</html>
<?php function main(){ ?>
<script type="text/javascript">parent.document.title = 'EarCMS Board 管理中心 - 全局 - 扩展配置';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='全局&nbsp;&raquo;&nbsp;扩展配置';</script>
<form method="post" action="?iframe=config_extend&action=save">
<input type="hidden" name="hash" value="<?php echo $_COOKIE['in_adminpassword']; ?>" />
<div class="container">
<div class="floattop"><div class="itemtitle"><h3>扩展配置</h3><ul class="tab1">
<li><a href="?iframe=config"><span>全局配置</span></a></li>
<li class="current"><a href="?iframe=config_extend"><span>扩展配置</span></a></li>
</ul></div></div><div class="floattopempty"></div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">应用分发</th></tr>
<tr><td colspan="2" class="td27">充值汇率:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_RMBPOINTS; ?>" name="IN_RMBPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">下载点数/每元</td></tr>
<tr><td colspan="2" class="td27">每日登录:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_LOGINPOINTS; ?>" name="IN_LOGINPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">下载点数/赠送，只针对当天首次登录</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">应用封装</th></tr>
<tr><td colspan="2" class="td27">单次扣除:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_WEBVIEWPOINTS; ?>" name="IN_WEBVIEWPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">下载点数</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">短链地址</th></tr>
<tr><td colspan="2" class="td27">伪静态:</td></tr>
<tr><td class="vtop rowform">
<select name="IN_REWRITE">
<option value="0">禁用</option>
<option value="1"<?php if(IN_REWRITE==1){echo " selected";} ?>>启用</option>
</select>
</td><td class="vtop tips2">如果您的服务器不支持 Rewrite，请选择“禁用”</td></tr>
</table>
<table class="tb tb2" style="display:none;">
<tr><th colspan="15" class="partition">立即信任</th></tr>
<tr><td colspan="2" class="td27">呈现方式:</td></tr>
<tr><td class="vtop rowform">
<select name="IN_MOBILEPROVISION">
<option value="0">默认方式</option>
<option value="1"<?php if(IN_MOBILEPROVISION==1){echo " selected";} ?>>引导方式</option>
</select>
</td><td class="vtop tips2">安装iOS应用时，立即信任的呈现方式</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">一键切图</th></tr>
<tr><td colspan="2" class="td27">打包格式:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_EXT; ?>" name="IN_EXT"></td><td class="vtop tips2">备用格式：40*40|60*60|58*58|87*87|80*80|120*120|120*120|180*180</td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" value="提交" /></div></td></tr>
</table>
</div>
</form>
<?php }function save(){
if(!submitcheck('hash', 1)){ShowMessage("表单来路不明，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
$str=file_get_contents('source/system/config.inc.php');
$str=preg_replace("/'IN_WXMCHID', '(.*?)'/", "'IN_WXMCHID', '".SafeRequest("IN_WXMCHID","post")."'", $str);
$str=preg_replace("/'IN_WXKEY', '(.*?)'/", "'IN_WXKEY', '".SafeRequest("IN_WXKEY","post")."'", $str);
$str=preg_replace("/'IN_WXAPPID', '(.*?)'/", "'IN_WXAPPID', '".SafeRequest("IN_WXAPPID","post")."'", $str);
$str=preg_replace("/'IN_RMBPOINTS', '(.*?)'/", "'IN_RMBPOINTS', '".SafeRequest("IN_RMBPOINTS","post")."'", $str);
$str=preg_replace("/'IN_LOGINPOINTS', '(.*?)'/", "'IN_LOGINPOINTS', '".SafeRequest("IN_LOGINPOINTS","post")."'", $str);
$str=preg_replace("/'IN_SIGN', '(.*?)'/", "'IN_SIGN', '".SafeRequest("IN_SIGN","post")."'", $str);
$str=preg_replace("/'IN_RESIGN', '(.*?)'/", "'IN_RESIGN', '".SafeRequest("IN_RESIGN","post")."'", $str);
$str=preg_replace("/'IN_LISTEN', '(.*?)'/", "'IN_LISTEN', '".SafeRequest("IN_LISTEN","post")."'", $str);
$str=preg_replace("/'IN_API', '(.*?)'/", "'IN_API', '".SafeRequest("IN_API","post")."'", $str);
$str=preg_replace("/'IN_SECRET', '(.*?)'/", "'IN_SECRET', '".SafeRequest("IN_SECRET","post")."'", $str);
$str=preg_replace("/'IN_WEBVIEWPOINTS', '(.*?)'/", "'IN_WEBVIEWPOINTS', '".SafeRequest("IN_WEBVIEWPOINTS","post")."'", $str);
$str=preg_replace("/'IN_ADPOINTS', '(.*?)'/", "'IN_ADPOINTS', '".SafeRequest("IN_ADPOINTS","post")."'", $str);
$str=preg_replace("/'IN_ADLINK', '(.*?)'/", "'IN_ADLINK', '".SafeRequest("IN_ADLINK","post")."'", $str);
$str=preg_replace("/'IN_ADIMG', '(.*?)'/", "'IN_ADIMG', '".SafeRequest("IN_ADIMG","post")."'", $str);
$str=preg_replace("/'IN_REMOTE', '(.*?)'/", "'IN_REMOTE', '".SafeRequest("IN_REMOTE","post")."'", $str);
$str=preg_replace("/'IN_REMOTEPK', '(.*?)'/", "'IN_REMOTEPK', '".SafeRequest("IN_REMOTEPK","post")."'", $str);
$str=preg_replace("/'IN_REMOTEDK', '(.*?)'/", "'IN_REMOTEDK', '".SafeRequest("IN_REMOTEDK","post")."'", $str);
$str=preg_replace("/'IN_REMOTEBK', '(.*?)'/", "'IN_REMOTEBK', '".SafeRequest("IN_REMOTEBK","post")."'", $str);
$str=preg_replace("/'IN_REMOTEAK', '(.*?)'/", "'IN_REMOTEAK', '".SafeRequest("IN_REMOTEAK","post")."'", $str);
$str=preg_replace("/'IN_REMOTESK', '(.*?)'/", "'IN_REMOTESK', '".SafeRequest("IN_REMOTESK","post")."'", $str);
$str=preg_replace("/'IN_REWRITE', '(.*?)'/", "'IN_REWRITE', '".SafeRequest("IN_REWRITE","post")."'", $str);
$str=preg_replace("/'IN_MOBILEPROVISION', '(.*?)'/", "'IN_MOBILEPROVISION', '".SafeRequest("IN_MOBILEPROVISION","post")."'", $str);
$str=preg_replace("/'IN_EXT', '(.*?)'/", "'IN_EXT', '".SafeRequest("IN_EXT","post")."'", $str);
if(!$fp = fopen('source/system/config.inc.php', 'w')){ShowMessage("保存失败，文件{source/system/config.inc.php}没有写入权限！",$_SERVER['HTTP_REFERER'],"infotitle3",3000,1);}
$ifile=new iFile('source/system/config.inc.php', 'w');
$ifile->WriteFile($str, 3);
ShowMessage("恭喜您，设置保存成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
}
?>