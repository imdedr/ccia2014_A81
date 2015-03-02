<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

	public function index()
	{
		echo "API 1.0 - Schedule\n";
		return;
	}

	public function month( $m = 1 ) {

		$data = array( 'rcode' => 500, 'msg' => '' );
		
		$token = $this->input->post('token', true);

		$this->load->model('token');
		$user = $this->token->tokenAuth( $token );

		if( $user != false ) {

			$data['rcode'] = 200;

			// Get Course List
			$uid = $user->uid;
			$course_list = $this->db->get_where('course_user', array( 'uid'=>$uid ));
			$course_list = $course_list->result();
			$sch_list = array();
			foreach ($course_list as $k => $v) {
				$raw = $this->db->get_where( 'course_schedule', array( 'cid'=>$v->cid, 'm'=>$m ) )->result();
				$sch_list = array_merge( $sch_list, $raw );
			}

			$data['info'] = $sch_list;

		} else {
			$data['msg'] = 'Token error';
		}

		echo json_encode($data);
	}
}

/* EOF */