<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheets/main.css"> 
		<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
		<script> 

		//弹出授权弹层：
		function authLoad(){
			App.AuthDialog.show({
			client_id : '<?=WB_INSITE_AKEY;?>',
			redirect_uri : 'http://apps.weibo.com/dstatus',
			height: 60    //可选，默认距顶端120px
			});
		}

		authLoad();
		</script>	
	</head>

	<body class="wb_body">
		<table align=center>
			<tr>
				<td style="padding: 0px 10px"><image src="../images/icon80.png"></td>
				<td><H1>云淡风暗黑小助手</H1></td>
			</tr>
			<tr>
				<td colspan=2 align="center"><hr>© 云淡风工作室 2012</td>
			</tr>
		</table>
	</body>
</html>
		
