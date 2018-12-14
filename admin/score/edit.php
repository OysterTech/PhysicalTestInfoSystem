<?php
/**
 * @name 生蚝体测信息管理系统-Web-后台修改成绩
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-13
 * @update 2018-11-17
 */
	
require_once '../../include/public.func.php';
?>

<html>
<head>
	<title>生蚝体测信息管理系统 / 生蚝科技</title>
	<?php include '../../include/header.php'; ?>
</head>
<body>

<?php include '../../include/pageHeader.php'; ?>

<h2 style="text-align: center;">成 绩 修 改</h2>

<hr>

<!-- 身份证号输入框 -->
<div class="input-group">
	<span class="input-group-addon">身份证号</span>
	<input class="form-control" id="idNumber" oninput='if(this.value.length>8){alert("请正确输入身份证号！");}' onkeyup='if(event.keyCode==13)search();'>
</div>
<!-- ./身份证号输入框 -->

<p style="line-height:8px;">&nbsp;</p>

<!-- 提交按钮 -->
<center>
	<a class="btn btn-primary" style="width:48%" href="<?=ROOT_PATH;?>admin/score.php">&lt; 返 回</a> <button class="btn btn-success" style="width:48%" onclick="search();">立 即 查 询 &gt;</button>
</center>
<!-- ./提交按钮 -->

<hr>

<div id="scoreShow"></div>

<?php include '../../include/footer.php'; ?>

<script>
var tableStyle="border-radius:5px;border-collapse: separate;text-align:center;";
var idNumber="";

function search(){
	lockScreen();
	idNumber=$("#idNumber").val();
	$("#idNumber").blur();
	
	if(idNumber==""){
		unlockScreen();
		showTipsModal("请正确输入身份证号！");
		return false;
	}
	
	$.ajax({
		url:"<?=ROOT_PATH;?>getScore.php",
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
			$("#scoreShow").html("");

			if(ret.code==200){
				scoreList=ret.data['scoreList'];
				scoreFieldList=ret.data['scoreFieldList'];
				totalScore=scoreList.length;
				totalField=scoreFieldList.length;
				html="";

				// 显示每年的成绩
				for(i=0;i<totalScore;i++){
					info=scoreList[i];

					html+='<table class="table table-hover table-striped table-bordered" style="border-radius:5px;border-collapse: separate;text-align:center;">'
					    +'<tr>'
					    +'<th colspan="4" style="text-align:center;background-color:#BAF7FD;">'+info['year']+' 年度</th>'
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

						html+='<tr onclick="edit('+"'"+field+"','"+scoreFieldList[field]+"','"+scoreNum+"','"+point+"','"+level+"'"+');">'
						    +'<th style="vertical-align:middle;text-align:center;">'+scoreFieldList[field]+'</th>';
						
						if(info[field]=="||"){
							html+='<td colspan="3">/</td>';
						}else if(field=="height"){
							html+='<td colspan="3">'+scoreNum+'</td>';
						}else{
							html+='<td>'+scoreNum+'</td>'
							    +'<td>'+point+'</td>'
							    +'<td>'+level+'</td>'
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
			}else{
				showTipsModal("系统错误！<br>请将错误码["+ret.code+"]至技术支持");
				return false;
			}
		}
	});
}


function edit(name,cnName,score,point,level){
	$("#editFieldName").val(name);
	$("#fieldName").html(cnName);
	$("#score").val(score);
	$("#point").val(point);
	$("#level").val(level);
	$("#editModal").modal("show");
}


function toEdit(){
	lockScreen();
	name=$("#editFieldName").val();
	score=$("#score").val();
	point=$("#point").val();
	level=$("#level").val();
	
	if(score=="" || point==""){
		unlockScreen();
		showTipsModal("请完整输入所有信息！");
		return false;
	}
	
	
	$.ajax({
		url:"toEdit.php",
		type:"post",
		data:{"fieldName":name,"idNumber":idNumber,"score":score,"point":point,"level":level},
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
				alert("修改成功！\n\n如需立即查看修改结果请重新点击查询！");
				return true;
			}else{
				console.log(JSON.stringify(ret));
				showTipsModal("系统错误！<br>请将错误码["+ret.code+"]至技术支持");
				return false;
			}
		}
	});
}


function setLevel(point){
	point=parseFloat(point);
	
	if(point>0 && point<60) level="不及格";
	else if(point>=60 && point<75) level="及格";
	else if(point>=75 && point<85) level="良好";
	else if(point>=85) level="优秀";
	
	$("#level").val(level);
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

<div class="modal fade" id="editModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="fieldName"></h3>
			</div>
			<div class="modal-body">
				<input type="hidden" id="editFieldName">
				<table class="table table-hover table-striped table-bordered" style="border-radius:5px;border-collapse: separate;text-align:center;">
					<tr>
						<th style="vertical-align:middle;text-align:center;">成绩</th>
						<td><input id="score" class="form-control"></td>
					</tr>
					<tr>
						<th style="vertical-align:middle;text-align:center;">评分</th>
						<td><input id="point" class="form-control" onkeyup="if(event.keyCode==13)setLevel(this.value);" onblur="setLevel(this.value);"></td>
					</tr>
					<tr>
						<th style="vertical-align:middle;text-align:center;">等级</th>
						<td><input id="level" class="form-control"></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">&lt; 关闭</button> <button type="button" class="btn btn-success" data-dismiss="modal" onclick="toEdit();">确认修改 &gt;</button>
			</div>
		</div>
	</div>
</div>

</body>
</html>
