<?php
/**
 * @name 生蚝体测信息管理系统-Web-首页
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-07
 * @update 2018-12-14
 */

require_once 'include/public.func.php';
?>

<html>
<head>
	<title>生蚝体测信息管理系统 / 生蚝科技</title>
	<?php include 'include/header.php'; ?>
</head>
<body>
	
<?php include 'include/pageHeader.php'; ?>

<center>
	<a href="scoreByIdNumber.php" class="btn btn-info" style="width:96%;font-weight:bold;font-size:21px;"><i class="fa fa-id-card-o" aria-hidden="true"></i> 按 身 份 证 号 后8位 查 询</a>
	<br><br>
	<a href="scoreByClassName.php" class="btn btn-info" style="width:96%;font-weight:bold;font-size:21px;"><i class="fa fa-user-o" aria-hidden="true"></i> 按 班 级 + 姓 名 查 询</a>
</center>

<?php include 'include/footer.php'; ?>

</body>
</html>
