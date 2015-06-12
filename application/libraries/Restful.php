<?php

/**
 * POST	新建一个资源
 * GET	读取一个资源
 * PUT	更新一个资源
 * DELETE	删除一个资源
 *
 *
 *
 * 200	OK	确认GET、PUT和DELETE操作成功
 * 201	Created	确认POST操作成功
 * 304	Not Modified	用于条件GET访问，告诉客户端资源没有被修改
 * 400	Bad Request	通常用于POST或者PUT请求，表明请求的内容是非法的
 * 401	Unauthorized	需要授权
 * 403	Forbidden	没有访问权限
 * 404	Not Found	服务器上没有资源
 * 405	Method Not Allowed	请求方法不能被用于请求相应的资源
 * 409	Conflict	访问和当前状态存在冲突
*/

class Restful {

	public function response($cnt, $headers, $http_code)
	{
		if(is_array($cnt))
		{
			if(version_compare(PHP_VERSION, '5.4.0') >= 0)
				$cnt = json_encode($cnt, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
			else
				$cnt = json_encode($cnt);
		}

		if(!isset($headers['Content-Type'])) $headers['Content-Type'] = 'application/json';
		foreach ($headers as $k => $v)
		{
			header($k . ': ' . $v);
		}

		echo $cnt;
	}
}