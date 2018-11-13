<?php
/**
 * @name 生蚝体测信息管理系统-Web-后台首页
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-10
 * @update 2018-11-10
 */
	
require_once '../include/public.func.php';
checkLogin();
?>

<html>
<head>
	<title>生蚝体测信息管理系统后台 / 生蚝科技</title>
	<?php include '../include/header.php'; ?>
</head>
<body>

<center><img src="<?=IMG_PATH;?>logo.png" style="display: inline-block;height: auto;max-width: 100%;"></center>
<h2 style="text-align: center;">后 台 首 页</h2>

<hr>

<center>
<a href="<?=ROOT_PATH;?>admin/student.php" class="btn btn-info" style="font-weight:bold;font-size:21px;width:96%"><i class="fa fa-user-o" aria-hidden="true"></i> 学 生 管 理</a><br><br>
<a href="<?=ROOT_PATH;?>admin/score.php" class="btn btn-success" style="font-weight:bold;font-size:21px;width:96%"><i class="fa fa-trophy" aria-hidden="true"></i> 成 绩 管 理</a><br><br>
</center>

<!--br><br><br-->

<?php include '../include/footer.php'; ?>

</body>
</html>
