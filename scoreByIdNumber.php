<?php
/**
 * @name 生蚝体测信息管理系统-Web-按证件号查成绩
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-08
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

<h3 style="text-align:center;">按身份证号后<font style="font-weight:bold;font-size:31px;">8</font>位查询成绩</h3>

<hr>

<!--div style="width:98%;text-align:center;margin: 0 auto;">
	<div class="alert alert-danger">
		<i class="fa fa-info-circle" aria-hidden="true"></i> 应学校要求，即日起身份证尾数查询由<b>8</b>位改为<b>6</b>位，谢谢配合！
	</div>
</div>

<hr-->

<!-- 身份证号输入框 -->
<div class="input-group">
	<span class="input-group-addon">身份证号</span>
	<input class="form-control" id="idNumber" oninput='if(this.value.length>18){alert("请正确输入身份证号！");}' onkeyup='if(event.keyCode==13)inputPassword();' autocomplete="off">
</div>
<!-- ./身份证号输入框 -->

<p style="line-height:8px;">&nbsp;</p>

<!-- 提交按钮 -->
<center>
	<a class="btn btn-primary" style="width:48%" href="<?=ROOT_PATH;?>">&lt; 返 回</a> <button class="btn btn-success" style="width:48%" onclick="inputPassword();">立 即 查 询 &gt;</button>
</center>
<!-- ./提交按钮 -->

<hr>

<div style="width:98%;text-align:center;margin: 0 auto;">
	<div class="alert alert-danger">
		<i class="fa fa-lightbulb-o" aria-hidden="true"></i> 点击项目名称可查看该项目的练习建议
	</div>
</div>

<div id="scoreShow"></div>

<?php include 'include/footer.php'; ?>

<script src="<?=JS_PATH;?>advice.js"></script>
<script>
var tableStyle="border-radius:5px;border-collapse: separate;text-align:center;";
var token="";

function inputPassword(){
	lockScreen();
	idNumber=$("#idNumber").val();
	$("#idNumber").blur();
	
	$("#scoreShow").html("");
	$("#password").val("");
	
	if(idNumber=="" || idNumber.length!=8){
		unlockScreen();
		showTipsModal("请正确输入身份证号后8位！");
		return false;
	}
	
	$.ajax({
		url:"getScoreToken.php",
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
				token=ret.data['token'];
				setCookie("phyToken",token);
				$("#inputPwdModal").modal("show");
				return true;
			}else if(ret.code==1){
				showTipsModal("学生不存在 或 成绩暂未录入！");
				return false;
			}else if(ret.code==0 || ret.code==2){
				showTipsModal("参数缺失！<br>请联系管理员！");
				return false;
			}else{
				showTipsModal("系统错误！<br>请将错误码["+ret.code+"]至技术支持");
				return false;
			}
		}
	});
}

function search(){
	lockScreen();
	password=$("#password").val();
	
	if(password=="" || password.length<6){
		unlockScreen();
		$("#inputPwdModal").modal("hide");
		showTipsModal("请正确输入查询密码！");
		return false;
	}
	
	$.ajax({
		url:"getScore.php",
		data:{"token":token,"password":password},
		dataType:"json",
		error:function(e){
			unlockScreen();
			console.log(JSON.stringify(e));
			showTipsModal("服务器错误！<br>请将错误码["+e.readyState+"."+e.status+"]至技术支持");
			return false;
		},
		success:function(ret){
			unlockScreen();
			$("#inputPwdModal").modal("hide");
			$("#scoreShow").html("");

			if(ret.code==200){
				scoreList=ret.data['scoreList'];
				scoreFieldList=ret.data['scoreFieldList'];
				totalScore=scoreList.length;
				totalField=scoreFieldList.length;
				className=scoreList[0]['class_name'];
				name=scoreList[0]['name'];

				html="<center><h4>"+className+" "+name+"</h4></center>";

				// 显示每年的成绩
				for(i=0;i<totalScore;i++){
					info=scoreList[i];

					html+='<table class="table table-hover table-striped table-bordered" style="border-radius:5px;border-collapse: separate;text-align:center;">'
					    +'<tr>'
					    +'<th colspan="4" style="text-align:center;background-color:#BAF7FD;">'+info['year']+' 学年</th>'
					    +'</tr>'
					    +'<tr>'
					    +'<th style="text-align:center;background-color:#BEFFB1;">项目名称</th>'
					    +'<th style="text-align:center;background-color:#BEFFB1;">成绩</th>'
					    +'<th style="text-align:center;background-color:#BEFFB1;">得分</th>'
					    +'<th style="text-align:center;background-color:#BEFFB1;">等级</th>'
					    +'</tr>';

					// 显示各项目
					for(field in scoreFieldList){
						score=info[field].split("|");
						scoreNum=score[0];
						point=score[1];
						level=score[2];

						html+='<tr>'
						    +'<th style="vertical-align:middle;text-align:center;" onclick="showExerciseAdvice('+"'"+field+"'"+','+"'"+scoreFieldList[field]+"'"+');">'+scoreFieldList[field]+'</th>';
						
						if(info[field]=="||"){
							html+='<td colspan="3">/</td>';
						}else if(field=="height"){
							html+='<td colspan="3">'+scoreNum+'</td>';
						}else{
							html+='<td style="vertical-align:middle;text-align:center;">'+scoreNum+'</td>'
							    +'<td style="vertical-align:middle;text-align:center;">'+point+'</td>'
							    +'<td style="vertical-align:middle;text-align:center;">'+level+'</td>'
							    +'</tr>';
						}
					}

					html+='</table>';
				}

				$("#scoreShow").html(html);
				return true;
			}else if(ret.code==1){
				showTipsModal("无此学生或成绩暂未录入！<br>请耐心等待，谢谢配合！");
				return false;
			}else if(ret.code==403){
				showTipsModal("查询密码错误！");
				return false;
			}else{
				showTipsModal("系统错误！<br>请将错误码["+ret.code+"]至技术支持");
				return false;
			}
		}
	});
}
</script>

<div class="modal fade" id="adviceModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="fieldName"></h3>
			</div>
			<div class="modal-body">
				<font style="font-weight:bold;font-size:20px;">
					<p id="adviceContent"></p>
				</font>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">关闭 &gt;</button>
			</div>
		</div>
	</div>
</div>

<?php include 'include/password.php'; ?>

<?php include 'include/tipsModal.php'; ?>

</body>
</html>
