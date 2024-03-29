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
// $Id: Log.class.php 488 2012-01-14 07:27:34Z luofei614@126.com $

/**
  +------------------------------------------------------------------------------
 * 日志处理类
  +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: Log.class.php 488 2012-01-14 07:27:34Z luofei614@126.com $
  +------------------------------------------------------------------------------
 */
class Log {
    // 日志级别 从上到下，由低到高
    const EMERG = 'EMERG';  // 严重错误: 导致系统崩溃无法使用
    const ALERT = 'ALERT';  // 警戒性错误: 必须被立即修改的错误
    const CRIT = 'CRIT';  // 临界值错误: 超过临界值的错误，例如一天24小时，而输入的是25小时这样
    const ERR = 'ERR';  // 一般错误: 一般性错误
    const WARN = 'WARN';  // 警告性错误: 需要发出警告的错误
    const NOTICE = 'NOTIC';  // 通知: 程序可以运行但是还不够完美的错误
    const INFO = 'INFO';  // 信息: 程序输出信息
    const DEBUG = 'DEBUG';  // 调试: 调试信息
    const SQL = 'SQL';  // SQL：SQL语句 注意只在调试模式开启时有效
    // 日志记录方式
    const SYSTEM = 0;
    const MAIL = 1;
    const TCP = 2;
    const FILE = 3;

    // 日志信息
    static $log = array();
    // 日期格式
    static $format = '[ c ]';

    /**
      +----------------------------------------------------------
     * 记录日志 并且会过滤未经设置的级别
      +----------------------------------------------------------
     * @static
     * @access public
      +----------------------------------------------------------
     * @param string $message 日志信息
     * @param string $level  日志级别
     * @param boolean $record  是否强制记录
      +----------------------------------------------------------
     * @return void
      +----------------------------------------------------------
     */
    static function record($message, $level=self::ERR, $record=false) {
        if ($record || strpos(C('LOG_RECORD_LEVEL'), $level)) {
            //[sae] 下不记录时间 sae_debug会记录
            self::$log[] = $_SERVER['REQUEST_URI'] . " | {$level}: {$message}";
        }
    }

    /**
      +----------------------------------------------------------
     * 日志保存
      +----------------------------------------------------------
     * @static
     * @access public
      +----------------------------------------------------------
     * @param integer $type 日志记录方式
     * @param string $destination  写入目标
     * @param string $extra 额外参数
      +----------------------------------------------------------
     * @return void
      +----------------------------------------------------------
     */
    static function save($type=self::FILE, $destination='', $extra='') {
        sae_set_display_errors(false);
        foreach (self::$log as $log)
            sae_debug($log);
        // 保存后清空日志缓存
        self::$log = array();
        sae_set_display_errors(true);
        //clearstatcache();
    }

    /**
      +----------------------------------------------------------
     * 日志直接写入
      +----------------------------------------------------------
     * @static
     * @access public
      +----------------------------------------------------------
     * @param string $message 日志信息
     * @param string $level  日志级别
     * @param integer $type 日志记录方式
     * @param string $destination  写入目标
     * @param string $extra 额外参数
      +----------------------------------------------------------
     * @return void
      +----------------------------------------------------------
     */
    //[sae] 下写入日志
    static function write($message, $level=self::ERR, $type=self::FILE, $destination='', $extra='') {
        sae_set_display_errors(false);
        sae_debug($_SERVER['REQUEST_URI'] . " | {$level}: {$message}");
        sae_set_display_errors(true);
        //clearstatcache();
    }

}