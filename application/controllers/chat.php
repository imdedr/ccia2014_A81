<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function index()
	{
		echo "API 1.0 - Chat\n";
		return;
	}

	public function one2one_send( $tuid = 0 ) {

		$tuid = (int)$tuid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		$token = $this->input->get('token');
		$text = $this->input->get('text');

		if( $text == NULL ) {
			$data['rcode'] = 500;
			$data['msg'] = 'Please say something.';
			echo json_encode($data);
			return;
		}

		if( $tuid != 0 ) {

			if( $token != null ) {

				$this->load->model('token');
				$user = $this->token->tokenAuth( $token );

				if( $user != false ) {

					// 檢查對象是否存在
					if( $this->db->get_where( 'user', array('uid'=>$tuid) )->num_rows == 1 ) {

						$this->db->insert( 'oto_chat', array( 'fuid'=>$user->uid, 'tuid'=>$tuid, 'text'=>$text, 'time'=>time() ) );
						$data['rcode'] = 200;

					} else {
						$data['rcode'] = 404;
						$data['msg'] = 'Unknow user';
					}

				} else {
					$data['msg'] = 'Unavaliable Token.';	
				}

			} else {
				$data['msg'] = 'Token is missing.';
			}
			
		} else {
			$data['msg'] = 'Missing parameter.';
		}

		echo json_encode($data);
		
	}

	public function one2one_msg( $time = 0 ) {

		$time = (int)$time;
		$data = array( 'rcode' => 500, 'msg' => '' );

		$token = $this->input->get('token');

		if( $token != null ) {

			$this->load->model('token');
			$user = $this->token->tokenAuth( $token );

			if( $user != false ) {

				$msg = $this->db->query( 'SELECT oto_chat.*, user.name FROM oto_chat left join user ON oto_chat.fuid = user.uid WHERE oto_chat.tuid = '.$user->uid.' and time > '.$time )->result();
				$data['rcode'] = 200;
				$data['msg'] = $msg;

			} else {
				$data['msg'] = 'Unavaliable Token.';	
			}

		} else {
			$data['msg'] = 'Token is missing.';
		}

		echo json_encode($data);
		
	}

	public function course_send( $cid = 0 ) {

		$cid = (int)$cid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		$token = $this->input->get('token');
		$text = $this->input->get('text');

		if( $text == NULL ) {
			$data['rcode'] = 500;
			$data['msg'] = 'Please say something.';
			echo json_encode($data);
			return;
		}

		if( $cid != 0 ) {

			if( $token != null ) {

				$this->load->model('token');
				$user = $this->token->tokenAuth( $token );

				if( $user != false ) {

					// 檢查對象是否存在
					if( $this->db->get_where( 'course', array('cid'=>$cid) )->num_rows == 1 ) {

						$this->db->insert( 'course_chat', array( 'fuid'=>$user->uid, 'cid'=>$cid, 'text'=>$text, 'time'=>time() ) );
						$data['rcode'] = 200;

					} else {
						$data['rcode'] = 404;
						$data['msg'] = 'Unknow course';
					}

				} else {
					$data['msg'] = 'Unavaliable Token.';	
				}

			} else {
				$data['msg'] = 'Token is missing.';
			}
			
		} else {
			$data['msg'] = 'Missing parameter.';
		}

		echo json_encode($data);
		
	}

	public function course_msg( $cid = 0, $time = 0 ) {

		$time = (int)$time;
		$cid = (int)$cid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		$token = $this->input->get('token');

		if( $cid != 0 ) {

			if( $token != null ) {

				$this->load->model('token');
				$user = $this->token->tokenAuth( $token );

				if( $user != false ) {

					// 檢查對象是否存在
					if( $this->db->get_where( 'course', array('cid'=>$cid) )->num_rows == 1 ) {

						$msg = $this->db->query( 'SELECT course_chat.*, user.name, user.level FROM course_chat left join user ON course_chat.fuid = user.uid WHERE course_chat.cid = '.$cid.' and time > '.$time )->result();
						$data['rcode'] = 200;
						$data['msg'] = $msg;

					} else {
						$data['rcode'] = 404;
						$data['msg'] = 'Unknow course';
					}

				} else {
					$data['msg'] = 'Unavaliable Token.';	
				}

			} else {
				$data['msg'] = 'Token is missing.';
			}
			
		} else {
			$data['msg'] = 'Missing parameter.';
		}

		echo json_encode($data);
		
	}

}

/* EOF */