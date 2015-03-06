<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function index() {
		echo "API 1.0 - API\n";
		return;
	}

	public function hand_check( $cid ) {
		$data = array( );

		$hand = $this->db->get_where( 'handup', array( 'cid'=>$cid ) );
		$data['hand'] = $hand->result();

		echo json_encode($data);
	}

	public function hand_accept( $hid ) {
		$data = array( );

		$token = time();
		$data['token'] = $token;

		$this->db->where( array( 'hid'=>$hid ) );
		$this->db->update( 'handup', array( 'token'=>$token ) );

		echo json_encode($data);
	}

	public function hand_reject( $hid ) {
		$data = array( );

		$this->db->where( array( 'hid'=>$hid ) );
		$this->db->delete( 'handup', array( 'hid'=>$hid ) );

		echo json_encode($data);
	}

	public function hand_queue( $token, $time ) {
		$data = array( );

		$queue = $this->db->get_where( 'hand_queue', array( 'time >'=>$time, 'token'=>$token ) )->result();
		$data['queue'] = $queue;

		echo json_encode($data);
	}

	public function update_page( $ssid ) {
		$data = array( );
		$page = $this->input->post( 'page' );

		$this->db->where( array( 'ssid'=>$ssid ) );
		$this->db->update( 'session', array( 'page'=>$page ) );

		echo json_encode($data);
	}

	public function rollcall_record( $rcid ) {
		$data = array( );

		$data['record'] = $this->db->get_where( 'rollcall_record', array( 'rcid'=>$rcid ) )->result();

		echo json_encode($data);
	}

	public function rollcall_edit( $rcid ) {

		$data = array( );

		$uid = $this->input->post( 'uid' );
		$status = $this->input->post( 'status' );

		if( $status == 'attend' ) {
			// 插入紀錄
			$this->db->insert( 'rollcall_record', array( 'rcid'=>$rcid, 'uid'=>$uid ) );
		} else {
			// 刪除記錄
			$this->db->delete( 'rollcall_record', array( 'rcid'=>$rcid, 'uid'=>$uid ) );
		}

		echo json_encode($data);

	}

	public function rollcall_start( $cid ) {
		$data = array( );

		$rcid = $this->input->post( 'rcid' );
		$this->db->where( array( 'cid'=>$cid ) );
		$this->db->update( 'course_session', array( 'rollcall'=>$rcid ) );

		echo json_encode($data);
	}

	public function rollcall_stop( $cid ) {
		$data = array( );

		$this->db->where( array( 'cid'=>$cid ) );
		$this->db->update( 'course_session', array( 'rollcall'=>0 ) );

		echo json_encode($data);
	}

}

/* EOF */