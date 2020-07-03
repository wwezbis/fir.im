<?php
ini_set('date.timezone', 'PRC');
$id = $_GET['id'];
$pw = $_GET['pw'];
$url = $_GET['url'];
$dir = $_GET['dir'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>文件上传</title>
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
                url:"<?php echo $url; ?>source/index/put_state.php?pw=<?php echo $pw; ?>&id=<?php echo $id; ?>&step=upload&percent=" + percent,
                success:function(text) {
                }
        });
}
function setuploaded(ufile){
        document.getElementById("progressbar").style.width = "100%";
        document.getElementById("progressbar").innerHTML = ufile;
        document.getElementById("progressText").innerHTML = "";
}
function setupload(usize, ulength){
        if(ulength > 0){
                var percent = Math.round(usize * 100 / ulength);
                document.getElementById("progressbar").style.width = percent + "%";
                if(percent > 0){
                        document.getElementById("progressbar").innerHTML = percent + "%";
                        document.getElementById("progressText").innerHTML = "";
                }else{
                        document.getElementById("progressText").innerHTML = percent + "%";
                }
                if(percent == 100){
                        document.getElementById("progressbar").innerHTML = "文件上传成功，请稍等...";
                }
                putstate(percent);
        }
}
</script>
</head>
<body>
<?php
echo '<table style="text-align:center;width:100%;border:1px solid #09C"><tr><td>';
echo '<div id="progressbar" style="float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#09C"></div><div id="progressText" style="float:left">0%</div>';
echo '</td></tr></table>';
function destroyDir($dir){
        $ds = DIRECTORY_SEPARATOR;
        $dir = substr($dir, -1) == $ds ? substr($dir, 0, -1) : $dir;
        if(is_dir($dir) && $handle = opendir($dir)){
                while($file = readdir($handle)){
                        if($file == '.' || $file == '..'){
                                continue;
                        }elseif(is_dir($dir.$ds.$file)){
                                destroyDir($dir.$ds.$file);
                        }else{
                                unlink($dir.$ds.$file);
                        }
                }
                closedir($handle);
                rmdir($dir);
        }
}
function callback($resource){
        $info = curl_getinfo($resource);
        echo '<script type="text/javascript">setupload('.$info['size_upload'].', '.$info['upload_content_length'].');</script>';
        ob_flush();
        flush();
}
ob_start();
@set_time_limit(0);
$curl = curl_init();
$data['id'] = $id;
$data['pw'] = $pw;
$data['ipa'] = new CurlFile('work/'.$dir.'/new.ipa');
curl_setopt($curl, CURLOPT_URL, $url.'source/index/put_upload.php');
curl_setopt($curl, CURLOPT_NOPROGRESS, false);
curl_setopt($curl, CURLOPT_PROGRESSFUNCTION, 'callback');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($curl);
curl_close($curl);
@destroyDir('work/'.$dir);
echo '<script type="text/javascript">setuploaded(\''.$result.'['.date('Y-m-d H:i:s').']\');</script>';
?>
</body>
</html>