<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller {

	public function index()
	{
		echo "API 1.0 - Course\n";
		return;
	}

	public function detail( $cid = 0 )
	{
		$cid = (int)$cid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $cid != 0 ) {
			$this->load->model( 'course_model' );
			$data['rcode'] = 200;
			$tmp = $this->course_model->detail( $cid );
			if( $tmp == [] ) {
				$data['rcode'] = 404;
				$data['msg'] = 'Nothing...';
			} else {
				$data['detail'] = $tmp;
				
				//處理老師
				$teacher_id = $data['detail']['teacher'];
				$teacher = $this->db->get_where('user', array('uid'=>(int)$teacher_id))->result()[0];
				$data['detail']['teacher'] = [];
				$data['detail']['teacher']['uid'] = $teacher->uid;
				$data['detail']['teacher']['name'] = $teacher->name;

			}
		} else {
			$data['msg'] = 'Missing parameter.';
		}

		echo json_encode($data);
		
	}

	public function my_course() {
		$token = $this->input->post('token', true);
		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $token != '' )
		{
			//驗證 Token
			$this->load->model( 'token' );

			$user = $this->token->tokenAuth( $token );

			if( $user != false )
			{
				$data['rcode'] = 200;
				$this->load->model( 'course_model' );
				$data['list'] = $this->course_model->userCourse( $user->uid );

			} else {
				$data['rcode'] = 503;
				$data['msg'] = 'Token error';
			}

		} else {
			$data['msg'] = 'Token missing.';
		}

		echo json_encode($data);
	}

	public function session_status( $cid = 0 ) {

		$cid = (int)$cid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $cid != 0 ) {
			
			$this->load->model( 'course_model' );
			$info = $this->course_model->sessionStatus( $cid );

			if( $info !== false ) {

				$data['rcode'] = 200;
				$data['info'] = $info->ssid;
				$data['rollcall'] = $info->rollcall;

			} else {
				$data['rcode'] = 404;
				$data['msg'] = 'Unknow course';
			}

			
		} else {
			$data['msg'] = 'Missing parameter.';
		}

		echo json_encode($data);
		
	}

	public function session_list( $cid = 0 ) {

		$cid = (int)$cid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $cid != 0 ) {
			
			$this->load->model( 'course_model' );
			$info = $this->course_model->sessionList( $cid );

			$data['rcode'] = 200;
			$data['info'] = $info;
			
		} else {
			$data['msg'] = 'Missing parameter.';
		}

		echo json_encode($data);
		
	}

	public function session_info( $ssid = 0 ) {

		$ssid = (int)$ssid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $ssid != 0 ) {
			
			$this->load->model( 'course_model' );
			$info = $this->course_model->sessionInfo( $ssid );

			if( $info !== false ) {
				
				$data['rcode'] = 200;
				$data['info'] = $info;

			} else {
				$data['rcode'] = 404;
				$data['msg'] = 'Unknow Session';
			}
			
		} else {
			$data['msg'] = 'Missing parameter.';
		}

		echo json_encode($data);
		
	}

	public function rollcall( $rcid = 0 ) {

		$rcid = (int)$rcid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		$token = $this->input->post('token');

		if( $rcid != 0 ) {

			if( $token != null ) {

				$this->load->model('token');
				$user = $this->token->tokenAuth( $token );

				if( $user != false ) {

					//判定點名是否存在

					if( $this->db->get_where( 'rollcall', array( 'rcid'=>$rcid ) )->num_rows == 1 ) {

						// 先判定是否已經點過了

						if( $this->db->get_where( 'rollcall_record', array( 'rcid'=>$rcid, 'uid'=>$user->uid ) )->num_rows == 0 ) {

							$this->db->insert( 'rollcall_record', array( 'rcid'=>$rcid, 'uid'=>$user->uid ) );
							$data['rcode'] = 200;

						} else {
							$data['rcode'] = 300;
							$data['msg'] = 'Repeat rollcall';
						}
					} else {
						$data['rcode'] = 404;
						$data['msg'] = 'Unknow Rollcall';
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

	public function rollcall_record( $cid = 0 ) {

		$cid = (int)$cid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		$token = $this->input->post('token');

		if( $cid != 0 ) {

			if( $token != null ) {

				$this->load->model('token');
				$user = $this->token->tokenAuth( $token );

				if( $user != false ) {

					// 取得課程相關的所有點名

					$rc_raw_all = $this->db->get_where( 'rollcall', array( 'cid'=>$cid ) )->result();

					$record = array();

					foreach ($rc_raw_all as $k => $v) {

						if( $this->db->get_where( 'rollcall_record', array( 'uid'=>$user->uid ) )->num_rows == 1 ) {
							$record[] = array( 'time'=>$v->time, 'attend'=>'Y');
						} else {
							$record[] = array( 'time'=>$v->time, 'attend'=>'N');
						}

					}

					$data['rcode'] = 200;
					$data['info'] = $record;

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