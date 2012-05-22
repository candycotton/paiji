<style>
body{
	background:url("http://qimeng.appsina.com/images/1.jpg");
}
</style>

<script> 

//弹出授权弹层：
function authLoad(){
 	App.AuthDialog.show({
	client_id : '<?=WB_INSITE_AKEY;?>',
	redirect_uri : 'http://apps.weibo.com/dstatus',
	height: 120    //可选，默认距顶端120px
	});
}

authLoad();
</script>