<?php
$id = $_GET['id'];
$pw = $_GET['pw'];
$url = $_GET['url'];
$dir = $_GET['dir'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>文件签名</title>
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
                url:"<?php echo $url; ?>source/index/put_state.php?pw=<?php echo $pw; ?>&id=<?php echo $id; ?>&step=sign&percent=" + percent,
                success:function(text) {
                }
        });
}
function listen(dir) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "listen.php?dir=" + dir, true);
        xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText == 1) {
                        document.getElementById("_msg").innerHTML = "即将开始上传，请稍等...";
                        setTimeout("location.href='upload.php?id=<?php echo $id; ?>&pw=<?php echo $pw; ?>&url=<?php echo $url; ?>&dir=<?php echo $dir; ?>'", 1000);
                        putstate(100);
                } else {
                        putstate(99);
                }
        };
        xhr.send(null);
}
setInterval("listen('<?php echo $dir; ?>')", 3000);
</script>
</head>
<body>
<table style="text-align:center;width:100%;border:1px solid #09C"><tr><td>
<div id="_msg" style="width:100%;text-align:center;color:#FFFFFF;background-color:#09C">正在进行签名，请稍等...</div>
</td></tr></table>
</body>
</html>