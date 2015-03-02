<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model {


    public function get( $nid ) {
        $this->load->database();

        $data = $this->db
          ->select('post_title, post_content')
          ->where( array('id' => $nid, 'post_status' => 'publish') )
          ->get( 'wp_posts' );

        return $data;
    }

}