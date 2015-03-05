<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teach extends CI_Controller {

	public function index()
	{
		echo 'Teach';
		return;
	}

	public function course( $cid ) {
		$this->load->view( 'teach' );
	}
}

/* EOF */