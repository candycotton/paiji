<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: HtmlCacheBehavior.class.php 349 2012-01-12 08:34:35Z luofei614@126.com $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 静态缓存写入
 +------------------------------------------------------------------------------
 */
class HtmlCacheBehavior extends Behavior {
    // 行为参数定义（默认值） 可在项目配置中覆盖
    public function run(&$content){
        if(C('HTML_CACHE_ON') && defined('HTML_FILE_NAME')) {
            // define('HTML_FILE_NAME',HTML_PATH.__HTML__);
            // 生成静态文件
            $path = dirname(HTML_FILE_NAME);
            if(!is_dir($path))   mk_dir($path);
            if( false === file_put_contents( HTML_FILE_NAME , $content ))
                throw_exception(L('_CACHE_WRITE_ERROR_').':'.HTML_FILE_NAME);
        }
    }

}