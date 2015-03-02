<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wireless extends CI_Controller {

	public function index()
	{
		echo "API 1.0 - Wireless\n";
		return;
	}

	public function ssid( $ssid = '' ) {

		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $ssid != '' ) {

			$raw = $this->db->get_where( 'ssid', array( 'ssid'=>$ssid ) );

			if( $raw->num_rows == 1 ) {

				$data['rcode'] = 200;
				$data['info'] = $raw->result()[0];

			} else {
				$data['rcode'] = 404;
				$data['msg'] = 'Unknow SSID';
			}

		} else {
			$data['msg'] = 'SSID is missing.';
		}

		echo json_encode($data);

	} 

	public function bssid( $bssid = '' ) {

		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $bssid != '' ) {

			$raw = $this->db->get_where( 'ssid', array( 'bssid'=>$bssid ) );

			if( $raw->num_rows == 1 ) {

				$data['rcode'] = 200;
				$data['info'] = $raw->result()[0];

			} else {
				$data['rcode'] = 404;
				$data['msg'] = 'Unknow BSSID';
			}

		} else {
			$data['msg'] = 'BSSID is missing.';
		}

		echo json_encode($data);

	}

	public function place( $place = '' ) {

		$data = array( 'rcode' => 500, 'msg' => '' );

		if( $place != '' ) {

			$raw = $this->db->get_where( 'ssid', array( 'place'=>$place ) );

			if( $raw->num_rows == 1 ) {

				$data['rcode'] = 200;
				$data['info'] = $raw->result()[0];

			} else {
				$data['rcode'] = 404;
				$data['msg'] = 'Unknow Place';
			}

		} else {
			$data['msg'] = 'Place is missing.';
		}

		echo json_encode($data);

	}
}

/* EOF */