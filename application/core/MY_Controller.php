<?php

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->_check_permission();
	}

	private function _check_permission()
	{
		$method = $this->input->server('REQUEST_METHOD');
		$method = strtolower($method);
		$resource = $this->router->class;
		$current_path = $resource . '/' . $method;

		$paths = config_item('hiddenpaths');

		if(!in_array($current_path, $paths) &&
			('get' == $method || !in_array($resource . '/ppd', $paths)))
		{
			return true;
		}

		$this->_response(array('error'=>'access denied'), 403);
		exit;
	}

	protected function _response($cnt, $http_code = 200, $headers = array())
	{
		$this->restful->response($cnt, $headers, $http_code);
	}
}