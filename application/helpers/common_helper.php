<?php

// 安全获取$var的元素或者属性： safe_get($arr, 'k1|k2|k3')

function safe_get($var, $k, $default = NULL)
{
	$ks = explode('|', $k);
	$ret = $var;
	foreach ($ks as $k)
	{
		if(is_array($ret) && isset($ret[$k]))
			$ret = $ret[$k];
		elseif(is_object($ret) && isset($ret->$k))
			$ret = $ret->$k;
		else
			return $default;
	}

	return $ret;
}