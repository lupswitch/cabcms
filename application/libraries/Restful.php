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

	private $_key_expiration = 3600; // token过期时间

	public function __construct(){}

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

	public function sign($value)
	{
		$sign = new Sign(config_item('encryption_key'));
		return $sign->sign($value);
	}

	public function unsign($token)
	{
		$sign = new Sign(config_item('encryption_key'));
		return $sign->unsign($token, $this->_key_expiration);
	}
}


// 带过期功能的加密(sign)和解密(unsign)类
// source: https://github.com/mattbasta/itsdangerous-php/blob/master/itsdangerous.php

class Sign {

	const EPOCH = 1430699400; // 北京时间 2015-01-01 00:00:00

	private $_sep = '.';
	private $_key = null;
	private $_salt = '3osCk9dLPQvMFvEAdpwE';

	public function __construct($key)
	{
		$this->_key = $key;
	}

	public function sign($value)
	{
		$t = $this->_get_timestamp();
		$t = $this->_int_to_bytes($t);
		$timestamp = $this->_base64_encode($t);

		$value = strval($value) . $this->_sep . $timestamp;

		return $value . $this->_sep . $this->_get_signature($value);
	}

	public function unsign($token, $max_age = 300)
	{
		$data = array_filter(explode($this->_sep, $token));
		if(count($data) < 3) return false;

		$sig = array_pop($data);
		$sig_ts = array_pop($data);
		$value = implode('.', $data);

		$t = $this->_base64_decode($sig_ts);
		$timestamp = $this->_bytes_to_int($t);

		if(is_null($timestamp)) return false;

		$age = $this->_get_timestamp() - $timestamp;
		if($age > $max_age) return false;

		if($sig === $this->_get_signature($value . $this->_sep . $sig_ts))
			return $value;
		else
			return false;
	}

	private function _get_timestamp()
	{
		return time() - self::EPOCH;
	}

	private function _base64_encode($data)
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	public function _base64_decode($data)
	{
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}

	private function _int_to_bytes($num)
	{
		$output = "";
		while($num > 0)
		{
			$output .= chr($num & 0xff);
			$num >>= 8;
		}
		return strrev($output);
	}

	private function _bytes_to_int($bytes)
	{
		$output = 0;
		foreach(str_split($bytes) as $byte)
		{
			if($output > 0)
			$output <<= 8;
			$output += ord($byte);
		}
		return $output;
	}

	private function _get_signature($value)
	{
		$value = $this->_salt . $value;
		return hash_hmac('sha256', $value, $this->_key);
	}
}