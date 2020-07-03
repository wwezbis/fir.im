<?php
$id = $_GET['id'];
$site = $_GET['site'];
$url = $_GET['ssl'].$site.$_GET['path'];
$ipa = $url.'data/attachment/'.$_GET['ipa'];
$dir = $site.'.'.$id;
$cert = $_GET['cert'];
$replace = $_GET['replace'];
$api = $_GET['api'];
$pw = md5(str_replace('www.', '', $site));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>文件下载</title>
<script type="text/javascript">
var ajax = function(conf) {
        var xhr = null;
        try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
                try {
                        xhr = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                        xhr = new XMLHttpRequest();
                }
        }
        xhr.open("GET", conf.url, true);
        xhr.withCredentials = true;
        xhr.send(null);
        xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                        conf.success(xhr.responseText);
                }
        };
};
function putstate(percent) {
        ajax({
                url:"<?php echo $url; ?>source/index/put_state.php?pw=<?php echo $pw; ?>&id=<?php echo $id; ?>&step=download&percent=" + percent,
                success:function(text) {
                }
        });
}
var filesize = 0;
function setsize(fsize){
        filesize = fsize;
}
function setdown(dlen){
        if(filesize > 0){
                var percent = Math.round(dlen * 100 / filesize);
                document.getElementById("progressbar").style.width = percent + "%";
                if(percent > 0){
                        document.getElementById("progressbar").innerHTML = "[<?php echo $id; ?>]<?php echo $site; ?>[" + percent + "%]";
                        document.getElementById("progressText").innerHTML = "";
                }else{
                        document.getElementById("progressText").innerHTML = "[<?php echo $id; ?>]<?php echo $site; ?>[" + percent + "%]";
                }
                if(percent == 100){
                        document.getElementById("progressbar").innerHTML = "即将开始签名，请稍等...";
                }
                putstate(percent);
        }
}
function downloaded(){
        setTimeout("location.href='sign.php?id=<?php echo $id; ?>&pw=<?php echo $pw; ?>&url=<?php echo $url; ?>&dir=<?php echo $dir; ?>'", 1000);
}
</script>
</head>
<body>
<?php
echo '<table style="text-align:center;width:100%;border:1px solid #09C"><tr><td>';
echo '<div id="progressbar" style="float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#09C"></div><div id="progressText" style="float:left">['.$id.']'.$site.'[0%]</div>';
echo '</td></tr></table>';
ob_start();
@set_time_limit(0);
@mkdir('work/'.$dir, 0777, true);
$zip = @file_get_contents($api.'data/cert/'.$cert.'.zip');
fwrite(fopen('work/'.$dir.'/'.$cert.'.zip', 'wb'), $zip);
exec('tar zxvf work/'.$dir.'/'.$cert.'.zip -C work/'.$dir);
if($replace){
        $rep = NULL;
        $arr = explode('|', $replace);
        for($i = 0; $i < count($arr); $i++){
                $rep .= ' -o -name "'.$arr[$i].'"';
        }
}else{
        $rep = NULL;
}
$sh = file_get_contents('work/'.$dir.'/'.$cert.'.sh');
$sh = str_replace(array('[work]', '[replace]'), array($dir, $rep), $sh);
fwrite(fopen('work/'.$dir.'/'.$cert.'.sh', 'w+'), $sh);
$file = fopen($ipa, 'rb');
if($file){
        $headers = get_headers($ipa, 1);
        if(array_key_exists('Content-Length', $headers)){
                $filesize = $headers['Content-Length'];
        }else{
                $filesize = strlen(@file_get_contents($ipa));
        }
        echo '<script type="text/javascript">setsize('.$filesize.');</script>';
        $newf = fopen('work/'.$dir.'/old.ipa', 'wb');
        $downlen = 0;
        if($newf){
                while(!feof($file)){
                        $data = fread($file, 1024*8);
                        $downlen += strlen($data);
                        fwrite($newf, $data, 1024*8);
                        echo '<script type="text/javascript">setdown('.$downlen.');</script>';
                        ob_flush();
                        flush();
                }
                exec('chmod -R 777 work/'.$dir.' && open -a /Applications/Utilities/Terminal.app work/'.$dir.'/'.$cert.'.sh');
                echo '<script type="text/javascript">downloaded();</script>';
        }
        if($file){fclose($file);}
        if($newf){fclose($newf);}
}
?>
</body>
</html>