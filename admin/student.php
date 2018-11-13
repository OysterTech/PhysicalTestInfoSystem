<?php
/**
 * @name 生蚝体测信息管理系统-Web-后台学生管理
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-10
 * @update 2018-11-11
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
<h2 style="text-align: center;color:#6B82FB;">学 生 管 理</h2>

<hr>

<center>
<a href="<?=ROOT_PATH;?>admin/student/byClass.php" class="btn btn-info" style="font-weight:bold;font-size:21px;width:96%"><i class="fa fa-users" aria-hidden="true"></i> 按 年级/班别 显示</a><br><br>
<a href="<?=ROOT_PATH;?>admin/student/byId.php" class="btn btn-primary" style="font-weight:bold;font-size:21px;width:96%"><i class="fa fa-id-card-o" aria-hidden="true"></i> 按 身份证号 查询</a><br><br>
<a href="<?=ROOT_PATH;?>admin/index.php" class="btn btn-default" style="font-weight:bold;font-size:21px;width:96%"><i class="fa fa-home" aria-hidden="true"></i> 返 回 后 台 首 页</a>
</center>

<?php include '../include/footer.php'; ?>

</body>
</html>
