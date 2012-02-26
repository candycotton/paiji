<?php
// +----------------------------------------------------------------------
// | TOPThink [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://topthink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: config.php 571 2012-01-14 13:04:35Z luofei614@126.com $

return array(
    'REST_METHOD_LIST'           => 'get,post,put,delete', // 允许的请求类型列表
    'REST_DEFAULT_METHOD'     => 'get', // 默认请求类型
    'REST_CONTENT_TYPE_LIST' => 'html,xml,jpg,gif,png,js,json,css,rss,atom,pdf,text,csv', // REST允许请求的资源类型列表
    'REST_DEFAULT_TYPE'          => 'html', // 默认的资源类型
    'REST_OUTPUT_TYPE'           => array(  // REST允许输出的资源类型列表
            'xml' => 'application/xml',
            'rawxml' => 'application/xml',
            'json' => 'application/json',
            'jsonp' => 'application/javascript',
            'serialized' => 'application/vnd.php.serialized',
            'html' => 'text/html',
        ),
);