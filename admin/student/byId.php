<?php
/**
 * @name 生蚝体测信息管理系统-Web-后台身份证查学生
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-10
 * @update 2018-11-11
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

<center><img src="<?=IMG_PATH;?>logo.png" style="display: inline-block;height: auto;max-width: 100%;" alt="生蚝体测信息管理系统"></center>

<hr>

<h2 style="text-align: center;">按身份证号查询学生</h2>

<hr>

<!-- 身份证号输入框 -->
<div class="input-group">
	<span class="input-group-addon">身份证号</span>
	<input class="form-control" id="idNumber" oninput='if(this.value.length>18){alert("请正确输入身份证号！");}' onkeyup='if(event.keyCode==13)search();'>
</div>
<!-- ./身份证号输入框 -->

<p style="line-height:8px;">&nbsp;</p>

<!-- 提交按钮 -->
<center>
	<a class="btn btn-primary" style="width:48%" href="<?=ROOT_PATH;?>admin/student.php">&lt; 返 回</a> <button class="btn btn-success" style="width:48%" onclick="search();">立 即 查 询 &gt;</button>
</center>
<!-- ./提交按钮 -->

<hr>

<input type="hidden" id="stuId">
<table id="table" class="table table-hover table-striped table-bordered" style="display:none;">
<tr>
	<th style="vertical-align:middle;text-align:center;">姓名</th>
	<td>
		<p id="name_show"></p>
		<input id="name_input" class="form-control" style="display: none;">
	</td>
</tr>
<tr>
	<th style="vertical-align:middle;text-align:center;">班别</th>
	<td>
		<p id="className_show"></p>
		<select id="grade" class="form-control" style="display:none;">
			<option disabled>-------------- 初中 --------------</option>
			<option value="11">1. 初一</option>
			<option value="12">2. 初二</option>
			<option value="13">3. 初三</option>
			<option disabled>-------------- 高中 --------------</option>
			<option value="21">1. 高一</option>
			<option value="22">2. 高二</option>
			<option value="23">3. 高三</option>
		</select>
		<select id="classNum" class="form-control" style="display:none;">
			<option value="1">1 班</option>
			<option value="2">2 班</option>
			<option value="3">3 班</option>
			<option value="4">4 班</option>
			<option value="5">5 班</option>
			<option value="6">6 班</option>
			<option value="7">7 班</option>
			<option value="8">8 班</option>
			<option value="9">9 班</option>
			<option value="10">10 班</option>
			<option value="11">11 班</option>
			<option value="12">12 班</option>
		</select>
	</td>
</tr>
<tr>
	<th style="vertical-align:middle;text-align:center;">身份证号</th>
	<td>
		<p id="idNumber_show"></p>
		<input id="idNumber_input" class="form-control" style="display: none;">
	</td>
</tr>
<tr>
	<td colspan="2">
		<div id="btn_origin">
			<button class="btn btn-info" style="width:48%" onclick="edit()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 编 辑</button>
			&nbsp;&nbsp;
			<button class="btn btn-danger" style="width:48%" onclick="del()"><i class="fa fa-trash-o" aria-hidden="true"></i> 删 除</button>
		</div>
		<div id="btn_edit" style="display: none;">
			<button id="cancelEdit" class="btn btn-default" style="width:48%" onclick="cancelEdit()"><i class="fa fa-ban" aria-hidden="true"></i> 取 消 编 辑</button>
			&nbsp;&nbsp;
			<button id="sureEdit" class="btn btn-success" style="width:48%" onclick="toEdit()"><i class="fa fa-check" aria-hidden="true"></i> 确 认 编 辑</button>
		</div>
	</td>
</tr>
</table>

<?php include '../../include/footer.php'; ?>

<script>
var tableStyle="border-radius:5px;border-collapse:separate;text-align:center;";
var className="";
var name="";

function search(){
	clear();
	lockScreen();

	idNumber=$("#idNumber").val();
	$("#idNumber").blur();
	
	if(idNumber==""){
		unlockScreen();
		showTipsModal("请正确输入身份证号！");
		return false;
	}
	
	$.ajax({
		url:"getStudent.php",
		data:{"orderBy":"idNumber","idNumber":idNumber},
		dataType:"json",
		error:function(e){
			unlockScreen();
			console.log(JSON.stringify(e));
			showTipsModal("服务器错误！<br>请将错误码["+e.readyState+"."+e.status+"]至技术支持");
			return false;
		},
		success:function(ret){
			unlockScreen();

			if(ret.code==200){
				studentList=ret.data['studentList'];

				if(studentList.length!=1){
					showTipsModal("学生信息错误！请联系技术支持！");
					return false;
				}else{
					info=studentList[0];
					name=info['name'];
					type=info['type'];
					enrollYear=info['enroll_year'];
					classNum=info['class_num'];

					grade=getGradeByEnrollYear(enrollYear);
					(type=="1")?typeShow="初":typeShow="高";
					className=typeShow+grade+"("+classNum+")班";

					switch(grade){
						case "一":
							gradeSelectValue="1";
							break;
						case "二":
							gradeSelectValue="2";
							break;
						case "三":
							gradeSelectValue="3";
							break;
					}
					gradeSelectValue=type+gradeSelectValue;
				}

				// 显示信息
				$("#name_show").html(name);
				$("#className_show").html(className);
				$("#idNumber_show").html(idNumber);
				$("#name_show").attr("style","");
				$("#className_show").attr("style","");
				$("#idNumber_show").attr("style","");

				// 准备修改的信息
				$("#name_input").val(info['name']);
				$("#idNumber_input").val(idNumber);
				$("#grade").val(gradeSelectValue);
				$("#classNum").val(classNum);
				$("#stuId").val(info['id']);

				// 显示表格
				$("#table").attr("style",tableStyle);
				return true;
			}else if(ret.code==1){
				showTipsModal("无此学生！");
				return false;
			}else{
				showTipsModal("系统错误！<br>请将错误码["+ret.code+"]至技术支持");
				return false;
			}
		}
	});
}


function edit(){
	$("#name_show").attr("style","display:none;");
	$("#className_show").attr("style","display:none;");
	$("#idNumber_show").attr("style","display:none;");

	$("#name_input").attr("style","");
	$("#idNumber_input").attr("style","");
	$("#grade").attr("style","");
	$("#classNum").attr("style","");

	$("#btn_origin").attr("style","display:none;");
	$("#btn_edit").attr("style","");
}


function cancelEdit(){
	$("#name_show").attr("style","");
	$("#className_show").attr("style","");
	$("#idNumber_show").attr("style","");

	$("#name_input").attr("style","display:none;");
	$("#idNumber_input").attr("style","display:none;");
	$("#grade").attr("style","display:none;");
	$("#classNum").attr("style","display:none;");

	$("#btn_origin").attr("style","");
	$("#btn_edit").attr("style","display:none;");
}

function toEdit(){
	lockScreen();

	id=$("#stuId").val();
	name=$("#name_input").val();
	grade=$("#grade").val();
	classNum=$("#classNum").val();
	idNumber=$("#idNumber_input").val();
	
	type=grade.substr(0,1);
	enrollYear=getEnrollYearByGrade(grade.substr(1));
	
	$.ajax({
		url:"toEdit.php",
		type:"post",
		data:{"id":id,"name":name,"type":type,"enrollYear":enrollYear,"classNum":classNum,"idNumber":idNumber},
		dataType:"json",
		error:function(e){
			unlockScreen();
			console.log(JSON.stringify(e));
			showTipsModal("服务器错误！<br>请将错误码["+e.readyState+"."+e.status+"]至技术支持");
			return false;
		},
		success:function(ret){
			unlockScreen();
			
			if(ret.code==200){
				alert("修改成功！");
				location.reload();
				return true;
			}else if(ret.code==1){
				showTipsModal("修改失败！");
				return false;
			}else{
				showTipsModal("系统错误！<br>请将错误码["+ret.code+"]至技术支持");
				return false;
			}
		}
	});
}


function del(){
	$("#delTips").html("确认要删除此学生吗？<br><font color='blue'>"+className+" "+name+"</font>");
	$("#delModal").modal("show");
}


function toDel(){
	$("#delModal").modal('hide');
	lockScreen();

	id=$("#stuId").val();
	
	$.ajax({
		url:"toDel.php",
		type:"post",
		data:{"id":id},
		dataType:"json",
		error:function(e){
			unlockScreen();
			console.log(JSON.stringify(e));
			showTipsModal("服务器错误！<br>请将错误码["+e.readyState+"."+e.status+"]至技术支持");
			return false;
		},
		success:function(ret){
			unlockScreen();
			
			if(ret.code==200){
				alert("删除成功！");
				location.reload();
				return true;
			}else if(ret.code==1){
				showTipsModal("删除失败！");
				return false;
			}else if(ret.code==403){
				showTipsModal("签名校验失败！");
				return false;
			}else{
				showTipsModal("系统错误！<br>请将错误码["+ret.code+"]至技术支持");
				return false;
			}
		}
	});
}



function clear(){
	$("#table").attr("style","display:none;");
	$("#name_show").attr("style","display:none;");
	$("#className_show").attr("style","display:none;");
	$("#idNumber_show").attr("style","display:none;");
	$("#name_input").attr("style","display:none;");
	$("#idNumber_input").attr("style","display:none;");
	$("#grade").attr("style","display:none;");
	$("#classNum").attr("style","display:none;");

	$("#name_show").html("");
	$("#className_show").html("");
	$("#idNumber_show").html("");
	$("#name_input").val("");
	$("#idNumber_input").val("");
	$("#grade").val("");
	$("#classNum").val("");
	$("#stuId").val("");
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


<div class="modal fade" id="delModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="ModalTitle">警告</h3>
			</div>
			<div class="modal-body">
				<font color="red" style="font-weight:bold;font-size:24px;text-align:center;">
					<p id="delTips"></p>
				</font>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">&lt; 取消</button> <button type="button" class="btn btn-danger" onclick="toDel();">确定 &gt;</button>
			</div>
		</div>
	</div>
</div>

</body>
</html>
