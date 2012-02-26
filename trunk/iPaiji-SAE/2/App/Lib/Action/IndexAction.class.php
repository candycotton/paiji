<?php

/**
 * 本页仅供测试
 */
class IndexAction extends Action {

    protected function _initialize() {
        header("Content-Type:text/html; charset=utf-8");
    }

    public function index() {
        $this->display(THINK_PATH . 'Tpl/hello.html');
    }

    //模拟器首页
    public function imit() {
        echo "<h2>Sae服务模拟器功能测试(以下服务在本地也可以运行)：</h2>";
        echo "<div>请结合源码观看效果</div>";
        echo "<h3><a href='" . __URL__ . "/counter' target='_blank'>Counter</a>   <a href='" . __URL__ . "/kv' target='_blank'>KVDB</a>  <a href='" . __URL__ . "/rank' target='_blank'>Rank</a>  <a href='" . __URL__ . "/mc' target='_blank'>Memcache</a>   <a href='" . __URL__ . "/tq' target='_blank'>TaskQueue</a>   <a href='" . __URL__ . "/storage' target='_blank'>Storage</a>    <a href='" . __URL__ . "/mail' target='_blank'>Mail</a>   <a href='" . __URL__ . "/fetchurl' target='_blank'>fetchURL</a>  <a href='" . __URL__ . "/wrappers' target='_blank'> Wrappers</a> <a href='" . __URL__ . "/saeimage' target='_blank'>SaeImage</a>  <a href='" . __URL__ . "/saemysql' target='_blank'>SaeMysql</a></h3>";
    }

    //平滑性测试
    public function pinghua() {
        echo "<h2>平滑性测试(不用特别学习SAE服务，使用ThinkPHP内置功能也使用了SAE服务)：</h2>";
        echo "<div>请结合源码观看效果</div>";
        echo "<h3><a href='" . __URL__ . "/mysql' target='_blank'>数据库</a>  <a href='" . __URL__ . "/scache' target='_blank'>S缓存</a>   <a href='" . __URL__ . "/fcache' target='_blank'>F缓存</a> <a href='" . __URL__ . "/upload' target='_blank'>上传文件</a>  <a href='" . __URL__ . "/image' target='_blank'>图片处理</a>  <a href='" . __URL__ . "/log' target='_blank'>查看日志</a></h3>";
    }
    
    public function mysql(){
        echo '数据操作使用了SaeMysql服务，做到了分布式和读写分离,可以通过查看配置得知,在本地和SAE环境下查看会是不一样的结果：<br />';
        echo '是否分布式连接：';
        dump(C('DB_DEPLOY_TYPE'));
        echo '数据库地址为：';
        dump(C('DB_HOST'));
        echo '是否读写分离:';
        dump(C('DB_RW_SEPARATE'));
    }

    public function log() {
        log::write('写入日志测试');
        echo '日志已写入，在SAE平台请在日志中心查看（选择debug类型）；在本地环境请在' . LOG_PATH . '查看';
    }

    public function image() {
        echo 'ThinkPHP的验证码功能使用SaeVcode服务；水印、缩略图等功能，使用了SaeImage服务，本示例测试验证码<br />';
        echo "<img src='" . __URL__ . "/verify'/>";
    }

    public function verify() {
        import("ORG.Util.Image");
        Image::buildImageVerify();
    }

    //S缓存的平滑性检测
    public function scache() {
        S('test', 'testvalue', 60);
        if (IS_SAE) {
            echo '您正在SAE环境下测试，您的缓存数据将保存在Memcache中<br />';
            $m = memcache_init();
            echo '用Mecache获得的值为：' . $m->get($_SERVER['HTTP_APPVERSION'].'/test') . '<br />';
            echo '用S函数获得的值为：' . S('test') . '<br />';
        } else {
            echo '您正在本地环境进行测试， 你的缓存数据保存在了' . DATA_PATH . '目录下<br />';
            echo '用S函数获得的值为：' . S('test');
        }
    }

    //F缓存的平滑性，使用前需要在SAE平台对KVDB进行初始化
    public function fcache() {
        F('test2', 'testvalue2');
        if (IS_SAE) {
            echo '您正在SAE环境下测试，您的数据将保存在KVDB中<br />';
            $kv = new SaeKvClient();
            $kv->init();
            echo '使用KVDB获得的值：' . $kv->get($_SERVER['HTTP_APPVERSION'].'/test2') . '<br />';
            echo '使用F函数获得值为：' . F('test2');
        } else {
            echo '您正在本地环境下测试，您的数据将保存在' . DATA_PATH . '目录下<br />';
            echo '使用F函数获得值为:' . F('test2');
        }
    }

    //上传文件平滑性测试

    public function upload() {
        if (!empty($_POST)) {
            import("ORG.Net.UploadFile");
            $upload = new UploadFile('', 'jpg,gif,png', '', './Public/upload/', 'time');
            if (!$upload->upload()) {
                $this->error($upload->getErrorMsg());
            } else {
                $info = $upload->getUploadFileInfo();
                $this->assign('filename', $info[0]['savename']);
            }
        }
        $this->display(THINK_PATH . 'Tpl/upload.html');
    }

    //删除图片
    public function unlink() {
        sae_unlink('./Public/upload/' . $_GET['filename']);
        $this->success('删除成功');
    }

    //Counter测试
    public function counter() {
        $c = new SaeCounter(); //实例化
        $c->create("test"); //创建计算器
        $c->set("test", 30); //设置值
        $ret = $c->get("test"); //获得值
        dump($ret);
        $ret = $c->incr("test"); //增加值
        dump($ret);
        $ret = $c->decr("test"); //减少值
        dump($ret);
    }

    //KVDB测试
    public function kv() {
        $k = new SaeKVClient();
        $k->init();
        $k->set('a', 'aaa'); //建立一条字符串数据
        $ret = $k->get('a'); //获得a的值
        dump($ret);
        $k->set('b', array('a', 'b', 'c')); //可存储数组或对象
        $ret = $k->get("b"); //获得b的值
        dump($ret);
        $k->delete("a"); //删除a
    }

    //rank排行榜测试
    public function rank() {
        $r = new SaeRank();
        $r->create("list", 100); //创建一个榜单。
        $r->set("list", "a", 3); //设置值
        $r->set("list", "b", 4);
        $r->set("list", "c", 1);
        $r->increase("list", "c"); //增加值
        $ret = $r->getList("list", true); //获得排行榜
        dump($ret);
        $ret = $r->getRank("list", "a"); //获得某个键的排名,注意是从0开始
        dump($ret);
        $r->clear("list"); //清空排行榜
    }

    //memcache测试
    //内置了memcache模拟器，即使本地环境不支持memcache也能运行。
    public function mc() {
        $m = memcache_init();
        $m->set("a", "aaa"); //设置值
        $ret = $m->get("a"); //获得值
        dump($ret);
    }

    //taskqueue 任务列队测试，本地环境需要配置curl
    public function tq() {
        $t = new SaeTaskQueue("test");
        $t->addTask("http://" . $_SERVER['HTTP_HOST'] . __URL__ . "/tq_test1"); //添加列队任务1
        $t->addTask("http://" . $_SERVER['HTTP_HOST'] . __URL__ . "/tq_test2", "k1=v1&k2=v2", true); //添加列队任务2
        if (!$t->push()) {
            echo '出错:' . $t->errmsg();
        } else {
            echo '执行成功！请查看[' . LOG_PATH . 'sae_debug.log' . ']文件中的日志';
        }
    }

    //列队任务1
    public function tq_test1() {
        sae_debug("列队任务1被执行"); //在本地请查看日志：App\Runtime\Logs\sae_debug.log
    }

    //列队任务2
    public function tq_test2() {
        sae_debug("列队任务2被执行,k1的值：{$_POST['k1']},k2的值:{$_POST['k2']}"); //在本地请查看日志：App\Runtime\Logs\sae_debug.log
    }

    //storage测试
    public function storage() {
        $s = new SaeStorage();
        $s->write('example', 'thebook', 'bookcontent'); //写入文件
        $ret = $s->read('example', 'thebook'); //读取文件
        dump($ret);
        $ret = $s->getUrl('example', 'thebook'); //获得地址
        dump($ret);
    }

    //Mail测试
    public function mail() {
        //现在暂不支持gmail邮箱和附件上传，建议使用新浪邮箱测试。注意需要开启你邮箱的smtp功能。
        $mail = new SaeMail();
        $ret = $mail->quickSend('luofei614@sina.com', '邮件标题', '邮件内容', 'saemailtest@sina.com', '123456');
        if ($ret === false) {
            var_dump($mail->errno(), $mail->errmsg());
        } else {
            echo "邮件发送成功，请更改源码，将邮箱改为自己的测试";
        }
    }

    //fetchURL测试
    public function fetchurl() {
        $f = new SaeFetchurl();
        echo $f->fetch('http://sina.cn');
    }

    //wrappers 测试
    public function wrappers() {
        file_put_contents('saemc://name', 'Memcache');
        echo file_get_contents('saemc://name');
        echo '<br />';
        file_put_contents('saestor://Public/upload/test.txt', 'SaeStorage');
        echo file_get_contents('saestor://Public/upload/test.txt');
    }

    //SaeImage 测试
    public function saeimage() {
        //从网络上抓取要合成的多张图片
        $img1 = file_get_contents('http://ss2.sinaimg.cn/bmiddle/53b05ae9t73817f6bf751&690');
        $img2 = file_get_contents('http://timg.sjs.sinajs.cn/miniblog2style/images/common/logo.png');
        $img3 = file_get_contents('http://i1.sinaimg.cn/home/deco/2009/0330/logo_home.gif');

//实例化SaeImage并取得最大一张图片的大小，稍后用于设定合成后图片的画布大小
        $img = new SaeImage($img1);
        $size = $img->getImageAttr();

//清空$img数据
        $img->clean();

//设定要用于合成的三张图片（如果重叠，排在后面的图片会盖住排在前面的图片）
        $img->setData(array(
            array($img1, 0, 0, 1, SAE_TOP_LEFT),
            array($img2, 0, 0, 0.5, SAE_BOTTOM_RIGHT),
            array($img3, 0, 0, 1, SAE_BOTTOM_LEFT),
        ));

//执行合成
        $img->composite($size[0], $size[1]);

//输出图片
        $img->exec('jpg', true);
    }

    //saemysql,  本地支持SaeMysql，不过建议用ThinkPHP的Model进行对数据库的操作
    public function saemysql() {
        $mysql = new SaeMysql();
        $mysql->runSql('create table saetest(`id` int(11) NOT NULL);');
        echo '在本地时请先配置好数据库，本程序执行完毕后会向数据库中建立名为saetest数据表';
    }

}

?>