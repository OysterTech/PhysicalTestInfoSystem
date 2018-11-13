<?php
/**
 * @name 生蚝体测信息管理系统-Web-后台导入成绩
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-11
 * @update 2018-11-12
 */
	
require_once '../../include/public.func.php';
checkLogin();
?>

<html>
<head>
	<title>生蚝体测信息管理系统后台 / 生蚝科技</title>
	<?php include '../../include/header.php'; ?>
</head>
<body>

<center><img src="<?=IMG_PATH;?>logo.png" style="display: inline-block;height: auto;max-width: 100%;"></center>
<h2 style="text-align: center;color:#6B82FB;">Excel上传成绩</h2>

<hr>

<!-- 查询表单 -->
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<select id="year" name="year" class="form-control">
			<option selected disabled>::: 请选择成绩对应的年度 :::</option>
		</select>
	</div>
	<br>
	<!-- 文件上传框 -->
	<center>
	<div class="input-group" style="width:98%">
		<span class="input-group-addon">上传Excel文件</span>
		<input type="file" name="myfile[]" id="myfile" class="form-control" style="height:40px">
	</div>
	</center>
	<!-- ./文件上传框 -->

	<p style="line-height:8px;">&nbsp;</p>

	<!-- 提交按钮 -->
	<center>
		<a class="btn btn-primary" style="width:49%" onclick="history.go(-1);">< 返 回</a> <button class="btn btn-success" style="width:49%" type="button" onclick="upload();">上 传 文 件 并 导 入 &gt;</button>
	</center>
	<!-- ./提交按钮 -->
</form>
<!-- ./查询表单 -->

<?php include '../../include/footer.php'; ?>

<script>
var date=new Date();
var year=date.getFullYear();

window.onload=function(){
	// 添加可选年度
	for(i=(year-2);i<=(year+8);i++){
		if(i==year){
			$("#year").append('<option value="'+i+'">★ '+i+' 年度</option>');
		}else{
			$("#year").append('<option value="'+i+'">'+i+' 年度</option>');
		}
	}
}


function upload(){
	if($("#myfile").val().length>0){
		var formData = new FormData($('form')[0]);
		formData.append('file',$('#myfile')[0].files[0]);

		$.ajax({
			url:'<?=ROOT_PATH;?>admin/score/toImport.php',
			type: "post",
			data: formData,
			dataType:"json",
			cache: false,
			contentType: false,
			processData: false,
			error:function(e){
				console.log(JSON.stringify(e));
				$("#tips").html("服务器错误！请联系管理员！");
				$("#tipsModal").modal('show');
				return false;
			},
			success:function(ret){
				console.log(ret);
				if(ret.code==200){
					
				}else if(ret.code==2){
					$("#tips").html("导入失败！！！<hr>没有此项目！");
					$("#tipsModal").modal('show');
					return;
				}else{
					$("#tips").html("未知系统错误！<br>请提交错误码["+ret.code+ret.message+"]给管理员");
					$("#tipsModal").modal('show');
					return;
				}
			}
		});
	}else{
		alert("请选择需要上传的成绩Excel文件！");
		$("#file").focus();
		return false;
	}
}
</script>

<div class="modal fade" id="tipsModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="ModalTitle">温馨提示</h3>
			</div>
			<div class="modal-body">
				<form method="post">
					<font color="red" style="font-weight:bolder;font-size:22px;text-align:center;">
						<p id="tips"></p>
					</font>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" onclick='isAjaxing=0;$("#tipsModal").modal("hide");'>返回 &gt;</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>