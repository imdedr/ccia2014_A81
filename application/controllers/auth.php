<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		echo "API 1.0 - Auth\n";
		return;
	}

	public function login()
	{
		$data = array( 'rcode' => 500, 'msg' => '' );

		$user = $this->input->post('username', true);
		$pass = $this->input->post('password', true);

		if( $user != '' && $pass != '' ) {

			$this->load->model('token');

			$token = $this->token->login( $user, $pass );

			if( $token != false ) {
				$data['rcode'] = 200;
				$data['token'] = $token;
				$data['user'] = $this->token->tokenAuth( $token );
			} else {
				$data['rcode'] = 404;
				$data['msg'] = 'Username or Password is wrong.';	
			}

		} else {
			// 帳號或密碼空白
			$data['msg'] = 'Username or Password could not be empty!';
		}

		echo json_encode($data);
	}

	public function logout()
	{
		$token = $this->input->post('token', true);

		$data = array( 'rcode' => 200, 'msg' => '' );

		if( $token != '' )
		{
			$this->load->model('token');
			$this->token->logout( $token );
		} else {
			$data['rcode'] = 500;
			$data['msg'] = 'Token is empty';
		}

		echo json_encode($data);
	}
}

/* EOF */