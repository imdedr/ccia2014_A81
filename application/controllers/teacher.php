<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teacher extends CI_Controller {

	public function index()
	{
		if( $this->session->userdata( 'uid' ) == NULL ) {
			redirect( '/teacher/login' );
		}


		// 取的課程列表
		$course = $this->db->get_where( 'course', array( 'teacher'=>$this->session->userdata( 'uid' ) ) )->result();

		$this->load->view( 'class_list', array( 'course'=>$course ) );
	}

	public function cla( $cid ) {

		if( $this->session->userdata( 'uid' ) == NULL ) {
			redirect( '/teacher/login' );
		}

		// 取得上課記錄
		$this->db->order_by("ssid", "desc"); 
		$session = $this->db->get_where( 'session', array( 'cid'=>$cid ) )->result();

		// 取得點名紀錄
		$this->db->order_by("rcid", "desc"); 
		$rollcall = $this->db->get_where( 'rollcall', array( 'cid'=>$cid ) )->result();
		// 取得教材
		$textbook = $this->db->get_where( 'course_textbook', array( 'cid'=>$cid ) )->result();
		// 取得檔案
		$file = $this->db->get_where( 'course_file', array( 'cid'=>$cid ) )->result();

		// 上課記錄轉換
		for ($i=0; $i < count( $session ); $i++) { 
			$tmp = (array)$session[$i];

			// 搜尋對應textbook
			for ($j=0; $j < count($textbook); $j++) { 
				if( $tmp['textbook'] == $textbook[$j]->ctbid ) {
					$tmp['textbook'] = $textbook[$j]->name;
					break;
				}
			}
			$session[$i] = (object)$tmp;
		}

		$this->load->view( 'class_detail', array( 'session'=>$session, 'rollcall'=>$rollcall, 'textbook'=>$textbook, 'file'=>$file ) );

	}

	public function create_new_session( $ctbid ) {

		if( $this->session->userdata( 'uid' ) == NULL ) {
			redirect( '/teacher/login' );
		}

		// 抓出課本資料
		$textbook = $this->db->get_where( 'course_textbook', array( 'ctbid'=>$ctbid ) )->result()[0];
		
		// 建立上課記錄
		$this->db->insert( 'session', array( 'cid'=>$textbook->cid, 'textbook'=>$textbook->ctbid, 'page'=>0, 'date'=>time(), 'time'=>time() ) );
		$ssid = $this->db->insert_id();

		// 切換當前課程資訊
		$this->db->where( array( 'cid'=>$textbook->cid ) );
		$this->db->update( 'course_session', array( 'ssid'=>$ssid ) );

		redirect( '/teacher/session_onair/'.$ssid );

	}

	public function session_onair( $ssid ) {

		if( $this->session->userdata( 'uid' ) == NULL ) {
			redirect( '/teacher/login' );
		}

		//取得資料
		$session = $this->db->get_where( 'session', array( 'ssid'=>$ssid ) )->result()[0];

		//取得教材
		$textbook = $this->db->get_where( 'course_textbook', array( 'ctbid'=>$session->textbook ) )->result()[0];

		$textbook->file_list = json_decode( $textbook->file_list );

		$this->load->view( 'session_onair', array( 'cid'=>$session->cid, 'ssid'=>$ssid, 'file_list'=>$textbook->file_list, 'path'=>$textbook->path, 'page'=>$session->page ) );

	}

	public function login()
	{
		if( $this->input->post( 'do' ) == 'login' ) {
			$user = $this->db->get_where( 'user', array( 'username'=>$this->input->post( 'username' ), 'password'=>md5($this->input->post( 'password' )), 'level'=>'teacher' ) );
			if( $user->num_rows == 1 ) {
				$user = $user->result()[0];
				$this->session->set_userdata( array( 'uid'=>$user->uid, 'username'=>$user->username, 'name'=>$user->name ) );
				redirect( '/teacher' );
			}
		}
		$this->load->view( 'login' );
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect( '/teacher/login' );
	}


}

/* EOF */