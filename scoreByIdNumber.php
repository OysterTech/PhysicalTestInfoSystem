<?php
/**
 * @name 生蚝体测信息管理系统-Web-按身份证号查成绩
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-08
 * @update 2018-11-13
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

<h2 style="text-align: center;">按身份证号查询成绩</h2>

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
	<a class="btn btn-primary" style="width:48%" href="<?=ROOT_PATH;?>">&lt; 返 回</a> <button class="btn btn-success" style="width:48%" onclick="search();">立 即 查 询 &gt;</button>
</center>
<!-- ./提交按钮 -->

<hr>

<div style="width:98%;text-align:center;margin: 0 auto;">
	<div class="alert alert-info">
		<i class="fa fa-lightbulb-o" aria-hidden="true"></i> 点击项目名称可查看该项目的练习建议
	</div>
</div>

<div id="scoreShow"></div>

<?php include 'include/footer.php'; ?>

<script src="<?=JS_PATH;?>advice.js"></script>
<script>
var tableStyle="border-radius:5px;border-collapse: separate;text-align:center;";

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
		url:"getScore.php",
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
				className=scoreList[0]['class_name'];
				name=scoreList[0]['name'];

				html="<center><h3>"+className+" "+name+"</h3></center>";

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
			}else{
				showTipsModal("系统错误！<br>请将错误码["+ret.code+"]至技术支持");
				return false;
			}
		}
	});
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

</body>
</html>
