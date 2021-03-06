﻿<?php
/**
 * @name 生蚝体测信息管理系统-Web-后台登录
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-10
 * @update 2018-11-10
 */

require_once '../include/public.func.php';

if(isset($_SESSION['phyTest_isLogin'])){
	if($_SESSION['phyTest_isLogin']==1){
		header("Location:index.php");
	}
}
?>

<html>
<head>
	<title>登录 / 生蚝体测信息管理系统后台</title>
	<?php include '../include/header.php'; ?>
</head>
<body>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
		<center><img src="<?=IMG_PATH;?>logo.png" style="display: inline-block;height: auto;max-width: 100%;"></center><br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">登录 / 生蚝体测信息管理系统后台</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="userName">用户名</label>
					<input type="text" class="form-control" id="userName" onkeyup='if(event.keyCode==13)$("#password").focus();'>
				</div>
				<br>
				<div class="form-group">
					<label for="password">密码</label>
					<input type="password" class="form-control" id="password" onkeyup='if(event.keyCode==13)toLogin();'>
				</div>
				<button class="btn btn-lg btn-success btn-block" onclick='toLogin();'>登录 / Login &gt;</button>
			</div>
		</div>
	</div>
</div>

<?php include '../include/footer.php'; ?>

<script>
function toLogin(){
	userName=$("#userName").val();
	password=$("#password").val();

	if(userName==""){
		showTipsModal("请输入用户名！");
		return false;
	}
	if(password.length>20 || password==""){
		showTipsModal("请正确输入密码！");
		return false;
	}

	$.ajax({
		url:"<?=ROOT_PATH;?>admin/toLogin.php",
		type:"post",
		data:{"userName":userName,"password":password},
		dataType:'json',
		error:function(e){
			console.log(JSON.stringify(e));
			showTipsModal("<font color='blue'>"+e.status+"</font>");
			$("#tipsModal").modal('show');
			return false;
		},
		success:function(ret){
			if(ret.code=="200"){
				if(getURLParam("returnUrl")!=null){
					window.location.href=decodeURIComponent(getURLParam("returnUrl"));
				}else{
					window.location.href=ret.data['url'];
				}
				return true;
			}else if(ret.message=="failedAuth"){
				showTipsModal("用户名或密码错误！");
				$("#tipsModal").modal('show');
				return false;
			}else{
				showTipsModal("系统错误！请提交错误码至管理员：<br><font color='blue'>"+ret.code+"</font>");
				$("#tipsModal").modal('show');
				return false;
			}
		}
	});
}
</script>

<div class="modal fade" id="tipsModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="ModalTitle">温馨提示</h3>
			</div>
			<div class="modal-body">
				<font color="red" style="font-weight:bold;font-size:24px;text-align:center;">
					<p id="tips"></p>
				</font>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">关闭 &gt;</button>
			</div>
		</div>
	</div>
</div>

</body>

</html>