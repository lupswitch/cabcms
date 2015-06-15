<?php

class Test extends MY_Controller {
	public function index()
	{
		$this->load->view('test/index');
	}

	function auth()
	{
		$id = rand(1, 99);
		$token = $this->restful->sign($id);

		$id = $this->restful->unsign('83.1.N5_z.cafdd00571daf3b05c65eb71d23bc8acfdb75396642251cd1e90188a243d338e');
		echo '<pre>';
		var_dump($token);
		var_dump($id);
		print_r($_POST);
		echo '</pre>';
	}
}