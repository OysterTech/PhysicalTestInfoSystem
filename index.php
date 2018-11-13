<?php
/**
 * @name 生蚝体测信息管理系统-Web-首页
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-07
 * @update 2018-11-08
 */

require_once 'include/public.func.php';
?>

<html>
<head>
	<title>生蚝体测信息管理系统 / 生蚝科技</title>
	<?php include 'include/header.php'; ?>
</head>
<body>
	
<center><img src="https://www.xshgzs.com/resource/index/images/logo.png" style="width:50%;"></center>

<h2 style="text-align:center;">生蚝科技-广州市育才中学<br>学生国家体质测试<br>成绩管理系统</h2>

<hr>

<center>
	<a href="scoreByIdNumber.php" class="btn btn-success" style="width:96%;font-weight:bold;font-size:21px;"><i class="fa fa-id-card-o" aria-hidden="true"></i> 按 身 份 证 号 查 询</a>
	<br><br>
	<a href="scoreByClassName.php" class="btn btn-success" style="width:96%;font-weight:bold;font-size:21px;"><i class="fa fa-user-o" aria-hidden="true"></i> 按 班 级 + 姓 名 查 询</a>
</center>

<?php include 'include/footer.php'; ?>

</body>
</html>
