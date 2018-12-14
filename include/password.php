<?php
/**
 * @name 生蚝体测信息管理系统-Web-密码处理
 * @author Jerry Cheung <master@xshgzs.com>
 * @create 2018-11-21
 * @update 2018-12-14
 */
?>

<div class="modal fade" id="inputPwdModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
				<h3 class="modal-title">请输入查询密码</h3>
			</div>
			<div class="modal-body">
				<div class="alert alert-success">
					<center>
						<b style="color:red;">请及时修改初始密码！</b><br>
						<p style="line-height:0.1px;">&nbsp;</p>
						<b>忘记密码请联系技术支持/学校体育科</b><br>
						<p style="line-height:0.1px;">&nbsp;</p>
						如需修改请<a style="font-weight:bold;color:#673AB7;" onclick='$("#changePwdModal").modal("show");'>点击此处</a>
					</center>
				</div>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
					<input id="password" type="password" class="form-control" placeholder="请输入查询密码" onkeyup='if(event.keyCode==13)search();'>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">&lt; 取消</button> <button type="button" class="btn btn-success" onclick="search();">马上查询 &gt;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="changePwdModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
				<h3 class="modal-title">修改查询密码</h3>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					<center>
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 新密码需包含6~20位的字符！
					</center>
				</div>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-unlock" aria-hidden="true"></i></span>
					<input id="oldPwd" type="password" class="form-control" onkeyup='if(event.keyCode==13)$("#newPwd").focus();' placeholder="请输入原密码">
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
					<input id="newPwd" type="password" class="form-control" onkeyup='if(event.keyCode==13)$("#surePwd").focus();' placeholder="请输入新密码">
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-shield" aria-hidden="true"></i></span>
					<input id="surePwd" type="password" class="form-control" placeholder="请再次输入新密码">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">&lt; 取消</button> <button type="button" class="btn btn-success" onclick="toChangePassword();">确认修改 &gt;</button>
			</div>
		</div>
	</div>
</div>

<script>
function toChangePassword(){
	lockScreen();
	oldPwd=$("#oldPwd").val();
	newPwd=$("#newPwd").val();
	surePwd=$("#surePwd").val();
	token=getCookie("phyToken");

	if(oldPwd==""){
	 unlockScreen();
	 showTipsModal("请正确输入旧密码！");
	 return false;
	}
	if(newPwd.length<6 || newPwd.length>20){
	 unlockScreen();
	 showTipsModal("请输入6~20位的新密码！");
	 return false;
	}
	if(surePwd!=newPwd){
	 unlockScreen();
	 showTipsModal("两次输入的新密码不相符！");
	 return false;
	}
	
	$.ajax({
		url:"toChangePassword.php",
		//type:"post",
		dataType:"json",
		data:{"oldPwd":oldPwd,"newPwd":newPwd,"token":token},
		error:function(e){
			unlockScreen();
			console.log(JSON.stringify(e));
			showTipsModal("服务器错误！<br>请将错误码["+e.readyState+"."+e.status+"]至技术支持");
			return false;
		},
		success:function(ret){
			unlockScreen();
		
			if(ret.code==200){
				$("#inputPwdModal").modal("hide");
				$("#changePwdModal").modal("hide");
				showTipsModal("修改查询密码成功！");
				return true;
			}else if(ret.code==1){
				showTipsModal("学生不存在！");
				return true;
			}else if(ret.code==403){
				showTipsModal("旧密码错误！");
				return true;
			}else if(ret.code==2){
				showTipsModal("修改错误！");
				return true;
			}else{
				console.log(JSON.stringify(ret));
				showTipsModal("系统错误！<br>请将错误码["+ret.code+"]至技术支持");
				return false;
			}
		}
	});
}
</script>
