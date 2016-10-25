<?php
// 
//  initialize.php
//  <初始化常量>
//  
//  Created by Administrator on 2016-10-22.
//  Copyright 2016 Administrator. All rights reserved.
// 

// 版本定义
define("STAR_VERSION", '1.0.0');
/**
 * 系统初始化文件
 * 主要定义系统初始化事件,为了兼容thinkphp3.2
 */

// 执行系统初始化
init_system();

/**
 * 系统初始化方法
 * @author 
 */
function init_system()
{
    // 执行定义__ROOT__路径
    rootpath();
}

/**
 * 定义__ROOT__路径
 * @author
 */
function rootpath()
{
    // 当前文件名
    if(!defined('_PHP_FILE_')) {
        $_temp  = explode('.php',$_SERVER['PHP_SELF']);
        define('_PHP_FILE_',    rtrim(str_replace($_SERVER['HTTP_HOST'],'',$_temp[0].'.php'),'/'));
    }
    if(!defined('__ROOT__')) {
        $_root  =   rtrim(dirname(_PHP_FILE_),'/');
        define('__ROOT__',  (($_root=='/' || $_root=='\\')?'':$_root));
    }
}