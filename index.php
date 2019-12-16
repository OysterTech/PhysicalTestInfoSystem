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
	<title>生蚝科技-体测信息管理系统</title>
	<?php include 'include/header.php'; ?>
</head>
<body>
	
<?php include 'include/pageHeader.php'; ?>

<!--div style="width:98%;text-align:center;margin: 0 auto;">
	<div class="alert alert-danger">
		<i class="fa fa-info-circle" aria-hidden="true"></i> 应学校要求，即日起身份证尾数查询由<b>8</b>位改为<b>6</b>位，谢谢配合！
	</div>
</div>

<hr-->

<center>
	<a href="scoreByIdNumber.php" class="btn btn-info" style="width:96%;font-weight:bold;font-size:21px;"><i class="fa fa-id-card-o" aria-hidden="true"></i> 按 身 份 证 号 后<font style="font-size:23px;">8</font>位 查 询</a>
	<br><br>
	<a href="scoreByClassName.php" class="btn btn-info" style="width:96%;font-weight:bold;font-size:21px;"><i class="fa fa-user-o" aria-hidden="true"></i> 按 班 级 + 姓 名 查 询</a>
</center>

<?php include 'include/footer.php'; ?>

</body>
</html>
