<?php
/**
 * @name 生蚝体测信息管理系统-Web-后台首页
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-10
 * @update 2018-11-11
 */
	
require_once '../include/public.func.php';
checkLogin();
?>

<html>
<head>
	<title>生蚝体测信息管理系统 / 生蚝科技</title>
	<?php include '../include/header.php'; ?>
</head>
<body>

<center><img src="<?=IMG_PATH;?>logo.png" style="display: inline-block;height: auto;max-width: 100%;"></center>
<h2 style="text-align: center;">成 绩 管 理</h2>

<hr>

<center>
<a href="<?=ROOT_PATH;?>admin/score/import.php" class="btn btn-success" style="font-weight:bold;font-size:21px;width:96%"><i class="fa fa-upload" aria-hidden="true"></i> Excel 导 入 成 绩</a><br><br>
<a href="<?=ROOT_PATH;?>admin/score/edit.php" class="btn btn-info" style="font-weight:bold;font-size:21px;width:96%"><i class="fa fa-edit" aria-hidden="true"></i> 成 绩 修 改</a><br><br>
<a href="<?=ROOT_PATH;?>admin/index.php" class="btn btn-default" style="font-weight:bold;font-size:21px;width:96%"><i class="fa fa-home" aria-hidden="true"></i> 返 回 后 台 首 页</a>
</center>

<?php include '../include/footer.php'; ?>

</body>
</html>
