<?php

class MY_Router extends CI_Router {

	// 修改routing逻辑，寻找controller目录时按照api版本递减寻找，便于api升级

	protected function _validate_request($segments)
	{
		$c = count($segments);

		if(0 == $c)
			return parent::_validate_request($segments);

		$dir = $segments[0];
		$pattern = '/^v([0-9]*)$/';
		$ret = preg_match($pattern, $dir, $m);
		if(!$ret)
			return parent::_validate_request($segments);

		$v = $m[1];

		$class = ucfirst(isset($segments[1]) ? $segments[1] : $this->default_controller);

		while($v > 0)
		{
			$dir = 'v' . $v;
			$test = APPPATH . 'controllers/' . $dir . '/' . $class . '.php';
			if(file_exists($test))
			{
				$this->set_directory($dir);
				array_shift($segments);
				break;
			}

			$v--;
		}

		return $segments;
	}
}