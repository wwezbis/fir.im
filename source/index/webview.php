<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="<?php echo IN_CHARSET; ?>">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
<meta name="keywords" content="<?php echo IN_KEYWORDS; ?>">
<meta name="description" content="<?php echo IN_DESCRIPTION; ?>">
<title>封装价格 - <?php echo IN_NAME; ?></title>
<link href="<?php echo IN_PATH; ?>static/index/icons.css" rel="stylesheet">
<link href="<?php echo IN_PATH; ?>static/index/bootstrap.css" rel="stylesheet">
<link href="<?php echo IN_PATH; ?>static/index/main.css" rel="stylesheet">
<link href="<?php echo IN_PATH; ?>static/pack/colpick/colpick.css" rel="stylesheet">
<link href="<?php echo IN_PATH; ?>static/pack/webview/manage.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/index/main.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/colpick/colpick.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/webview/lib.js"></script>
<script type="text/javascript">
var in_path = '<?php echo IN_PATH; ?>';
var in_login = <?php echo $GLOBALS['userlogined'] ? '1' : '-1'; ?>;
</script>
</head>
<body class="page-Pricing">
<nav class="navbar navbar-transparent" role="navigation">
<div class="navbar-header">
	<a class="navbar-brand" href="<?php echo IN_PATH; ?>"><i class="icon-" style="font-size:<?php echo checkmobile() || strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') ? 30 : 40; ?>px;font-weight:bold"><?php echo $_SERVER['HTTP_HOST']; ?></i></a>
</div>
<div class="collapse navbar-collapse navbar-ex1-collapse" ng-controller="NavbarController">
	<div class="dropdown">
		<div>
			<i class="icon-brace-left"></i>
			<ul class="navbar-bracket">
				<li><a href="<?php echo IN_PATH; ?>">首页</a><i class="icon-comma"></i></li>
				<li><a href="<?php echo IN_PATH.'index.php/install'; ?>">分发价格</a><i class="icon-comma"></i></li>
				<?php if(IN_SIGN){ ?><li><a href="<?php echo IN_PATH.'index.php/sign'; ?>">签名价格</a><i class="icon-comma"></i></li><?php } ?>
				<li><a href="<?php echo IN_PATH.'index.php/webview'; ?>">封装价格</a><i class="icon-comma"></i></li>
				<?php if($GLOBALS['userlogined']){ ?>
				<li><a href="<?php echo IN_PATH.'index.php/home'; ?>">应用管理</a><i class="icon-comma"></i></li>
				<li class="signup"><a href="<?php echo IN_PATH.'index.php/logout'; ?>">退出</a></li>
				<?php }else{ ?>
				<li><a href="<?php echo IN_PATH.'index.php/login'; ?>">立即登录</a><i class="icon-comma"></i></li>
				<li class="signup"><a href="<?php echo IN_PATH.'index.php/reg'; ?>">免费注册</a></li>
				<?php } ?>
			</ul>
			<i class="icon-brace-right"></i>
		</div>
	</div>
</div>
</nav>
<div class="menu-toggle">
	<i class="icon-menu"></i>
</div>
<menu>
<ul>
	<li><a href="<?php echo IN_PATH; ?>">首页</a></li>
	<li><a href="<?php echo IN_PATH.'index.php/install'; ?>">分发价格</a></li>
	<?php if(IN_SIGN){ ?><li><a href="<?php echo IN_PATH.'index.php/sign'; ?>">签名价格</a></li><?php } ?>
	<li><a href="<?php echo IN_PATH.'index.php/webview'; ?>">封装价格</a></li>
	<?php if($GLOBALS['userlogined']){ ?>
	<li><a href="<?php echo IN_PATH.'index.php/home'; ?>">应用管理</a></li>
	<li><a href="<?php echo IN_PATH.'index.php/logout'; ?>">退出</a></li>
	<?php }else{ ?>
	<li><a href="<?php echo IN_PATH.'index.php/reg'; ?>">免费注册</a></li>
	<li><a href="<?php echo IN_PATH.'index.php/login'; ?>">立即登录</a></li>
	<?php } ?>
</ul>
</menu>
<div id="root-packages">
	<div class="banner banner-packages">
		<h1>
		<div class="brackets">
			<i class="icon-brace-left"></i><span>应用封装</span><i class="icon-brace-right"></i>
		</div>
		<small>在线封装</small>
		</h1>
		<div class="pattern-bg"></div>
	</div>
	<div class="section packages-content">
		<section class="ng-scope">
		<div class="page-app app-info">
			<div class="ng-scope">
				<div class="page-tabcontent apps-app-info">
					<div class="middle-wrapper">
						<div class="app-info-form">
							<div class="field app-name">
								<div class="value">
									<input type="text" placeholder="应用名称" id="in_title">
								</div>
							</div>
							<div class="field app-name">
								<div class="value">
									<input type="text" placeholder="域名地址" id="in_url" onkeyup="if(!value.match(/^https?:\/\//)){value='http://'+value}" onblur="if(!value.match(/^https?:\/\//)){value='http://'+value}">
								</div>
							</div>
							<div class="field app-name">
								<div class="value">
									<input type="text" placeholder="顶部颜色" id="in_b_color" onmousedown="$(this).colpick({layout:'hex',submit:0,colorScheme:'dark',onChange:function(hsb,hex,rgb,el,bySetColor){if(!bySetColor)$(el).val(hex);}}).keyup(function(){$(this).colpickSetColor(this.value);})" onkeyup="value=value.replace(/[\W|\_]/g,'')" onblur="value=value.replace(/[\W|\_]/g,'')">
								</div>
							</div>
							<div class="field app-name">
								<div class="value">
									<input type="text" placeholder="标题颜色" id="in_t_color" onmousedown="$(this).colpick({layout:'hex',submit:0,colorScheme:'dark',onChange:function(hsb,hex,rgb,el,bySetColor){if(!bySetColor)$(el).val(hex);}}).keyup(function(){$(this).colpickSetColor(this.value);})" onkeyup="value=value.replace(/[\W|\_]/g,'')" onblur="value=value.replace(/[\W|\_]/g,'')">
								</div>
							</div>
							<div class="field app-short">
								<div class="value">
									<div class="apps-app-security" id="preview_a_icon">
										<input type="file" id="upload_a_icon" onchange="upload_a_icon()" style="display:none">
										<div class="btn-invite-member"  id="tips_a_icon" onclick="$('#upload_a_icon').click()">上传应用图标</div>
									</div>
								</div>
							</div>
							<div class="field app-short">
								<div class="value">
									<div class="apps-app-security" id="preview_l_image">
										<input type="file" id="upload_l_image" onchange="upload_l_image()" style="display:none">
										<div class="btn-invite-member" id="tips_l_image" onclick="$('#upload_l_image').click()">上传启动图片</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="field actions">
								<div class="value">
									<button class="save ng-binding" onclick="web_view()">一键封装</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</section>
	</div>
	<div class="section packages-cert">
		<div class="cert-header">
			<i class="icon icon-users"></i>
		</div>
		<div class="cret-row-wrap">
			<div class="cert-row">
				<div class="half text-right">
					<div class="cert-item">封装方式</div>
					<ul class="list-unstyled cert-list">
						<li>WAP网站生成APP应用</li>
						<li>我的应用中预览</li>
					</ul>
				</div>
				<div class="half text-left">
					<div class="cert-item">收费方式</div>
					<ul class="list-unstyled cert-list">
						<li>单次扣除 <?php echo IN_WEBVIEWPOINTS; ?> 下载点数</li>
						<li>购买点数包获取</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php include 'source/index/faq.php'; ?>
</div>
<?php include 'source/index/bottom.php'; ?>
</body>
</html>