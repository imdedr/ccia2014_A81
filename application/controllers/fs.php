<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fs extends CI_Controller {

	public function index() {
		echo "API 1.0 - File System\n";
		return;
	}

	public function file( $fid = 0 ) {


		$fid = (int)$fid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $fid != 0 ) {

			$this->load->model('fs_model');
			$info = $this->fs_model->getFileInfo( $fid );

			if( $info !== false ) {

				$data['rcode'] = 200;
				$data['info'] = $info;

			} else {
				$data['rcode'] = 404;
				$data['msg'] = 'File not found';
			}

		} else {
			$data['msg'] = 'File id is missing.';
		}

		echo json_encode($data);

	}

	public function textbook( $fid = 0 ) {


		$fid = (int)$fid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $fid != 0 ) {

			$this->load->model('fs_model');
			$info = $this->fs_model->getTextbookInfo( $fid );
			$info->file_list = json_decode( $info->file_list );

			if( $info !== false ) {

				$data['rcode'] = 200;
				$data['info'] = $info;

			} else {
				$data['rcode'] = 404;
				$data['msg'] = 'File not found';
			}

		} else {
			$data['msg'] = 'File id is missing.';
		}

		echo json_encode($data);

	}

	public function course_file( $cid = 0 ) {

		$cid = (int)$cid;
		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $cid != 0 ) {

			$this->load->model('fs_model');

			$file = $this->fs_model->getCourseFiles( $cid );
			$textbook = $this->fs_model->getCourseTextbooks( $cid );

			$data['rcode'] = 200;
			$data['file'] = $file;
			$data['textbook'] = $textbook;

		} else {
			$data['msg'] = 'Course id is missing.';
		}

		echo json_encode($data);
	}
}

/* EOF */