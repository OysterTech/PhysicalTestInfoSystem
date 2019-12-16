<hr>
<center>	
	<!-- 页脚版权 -->
	<p style="font-weight:bold;font-size:18px;">
		育才中学体育科 保留数据解释权<br>
		&copy;<a href="https://www.xshgzs.com/?from=phyTest" target="_blank">生蚝科技</a><font style="font-size:20px;">(育才高三8 张镜濠)</font> 技术支持<br>
		
		<a style="color:#64DD17" onclick='$("#adminWxModal").modal("show");'><i class="fa fa-weixin fa-lg" aria-hidden="true"></i></a>
		<a style="color:#FF7043" onclick='launchQQ()'><i class="fa fa-qq fa-lg" aria-hidden="true"></i></a>
		<a style="color:#29B6F6" href="mailto:master@xshgzs.com"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></a>
		<a style="color:#AB47BC" href="https://github.com/OysterTech" target="_blank"><i class="fa fa-github fa-lg" aria-hidden="true"></i></a>
		<a href="http://www.miitbeian.gov.cn/" target="_blank" style="color:black;">粤ICP备19018320号-1</a><br>

	</p>
	<!-- ./页脚版权 -->
	
	<!-- 友情链接 -->
	<p style="font-size:15px;line-height:26px;">
		友情链接：<a href="http://swimming.sport.org.cn/" target="_blank" style="color:black;">中国游泳协会</a> | <a href="http://www.gdswim.org/" target="_blank" style="color:black;">广东省游泳协会</a>
		<!-- ./友情链接 -->
		
		<br>
		
		<?php if(strpos($_SERVER['PHP_SELF'],"admin")===FALSE){ ?>
		<a href="<?=ROOT_PATH;?>admin/login.php" target="_blank" style="color:black;">登入管理平台</a>
		<?php }else{ ?>
		<a href="<?=ROOT_PATH;?>admin/logout.php" style="color:green;font-weight:bold;font-size:18px;">退 出 后 台</a>
		<?php } ?>
	</p>
</center>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?=JS_PATH;?>utils.js"></script>

<script>
function launchQQ(){		
	if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
	window.location.href="mqqwpa://im/chat?chat_type=wpa&uin=571339406";
	}else{
		window.open("http://wpa.qq.com/msgrd?v=3&uin=571339406");
	}
}
</script>

<div class="modal fade" id="adminWxModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title">微信联系技术支持</h3>
			</div>
			<div class="modal-body">
				<img src="<?=IMG_PATH.'wxCode.png';?>" style="width:100%;">
				<font color="blue" style="font-weight:bold;font-size:22px;text-align:left;">
					扫码添加技术支持个人微信，或搜索微信号“zjhit0409”<br>
					★ 添加时，请备注：<font color="green">PHY+班级姓名</font>。
				</font>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">关闭 &gt;</button>
			</div>
		</div>
	</div>
</div>
