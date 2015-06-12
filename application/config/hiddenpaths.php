<?php


/**
 * POST	新建一个资源
 * GET	读取一个资源
 * PUT	更新一个资源
 * DELETE	删除一个资源
 *
 * 资源白名单，需要登录才能访问/操作的资源，^表示取反。
 * 只简单验证是否登录，复杂验证需要自己实现。
 * 方便起见，带影响资源的操作在本项目中合称ppd
*/

$config['hiddenpaths'] = array(
	'news/ppd', // <==> 'news/post' && 'news/put' && 'news/delete'
	'photo/post',
	'photo/put',
	'photo/delete',
);