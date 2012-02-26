<style>
body{
	background:url("http://qimeng.appsina.com/images/1.jpg");
}
</style>

<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>

<script> 

//弹出授权弹层：
function authLoad(){
 	App.AuthDialog.show({
	client_id : '<?=WB_INSITE_AKEY;?>',
	redirect_uri : 'main_sinawb.php',
	height: 120    //可选，默认距顶端120px
	});
}

authLoad();
</script>