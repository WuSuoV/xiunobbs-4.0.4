<?php

define('DEBUG', 0); 				// 发布的时候改为 0 
define('APP_NAME', 'bbs');			// 应用的名称

ob_start('ob_gzhandler');

$conf = (@include './conf/conf.php') OR exit(header('Location: install/'));

if(DEBUG) {
	include './xiunophp/xiunophp.php';
} else {
	include './xiunophp/xiunophp.min.php';
}

include './model.inc.php';

// 测试数据库连接
db_connect() OR message(-1, $errstr);

$sid = sess_start();

// 语言包
$lang = include('./lang/zh-cn.php');

// 用户
$uid = intval(_SESSION('uid'));
$user = user_read($uid);

// 用户组
$gid = empty($user) ? 0 : intval($user['gid']);
$grouplist = group_list_cache();
$group = isset($grouplist[$gid]) ? $grouplist[$gid] : $grouplist[0];

// 版块
$fid = 0;
$forumlist = forum_list_cache();
$forumlist_show = forum_list_access_filter($forumlist, $gid);	// 有权限查看的板块

// 头部 header.inc.htm 
$header = array(
	'title'=>$conf['sitename'],
	'keywords'=>'',
	'description'=>'',
	'navs'=>array(),
);

// 运行时数据
$runtime = runtime_init();

// 检测浏览器， 不支持 IE8
$browser = get__browser();
check_browser($browser);

// 检测站点运行级别
check_runlevel();

// 检测 IP 封锁，可以作为自带插件
//check_banip($ip);

// 记录 POST 数据
//DEBUG AND xn_log_post_data();

// 全站的设置数据，站点名称，描述，关键词，页脚代码等
$setting = cache_get('setting', TRUE);

//DEBUG AND ($method == 'POST' || $ajax) AND sleep(1);

$route = param(0, 'index');

// todo: HHVM 不支持动态 include $filename
// 按照使用的频次排序，增加命中率，提高效率
switch ($route) {
	case 'index': 	include './route/index.php'; 	break;
	case 'thread':	include './route/thread.php'; 	break;
	case 'forum': 	include './route/forum.php'; 	break;
	case 'user': 	include './route/user.php'; 	break;
	case 'my': 	include './route/my.php'; 	break;
	case 'search': 	include './route/search.php'; 	break;
	case 'post': 	include './route/post.php'; 	break;
	case 'mod': 	include './route/mod.php'; 	break;
	case 'test': 	include './route/test.php'; 	break;
	case 'browser': include './route/browser.php'; 	break;
	default: http_404();
}

?>