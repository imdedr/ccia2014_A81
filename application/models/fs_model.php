<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fs_model extends CI_Model {

    public function getFileInfo( $fid ) {
        
        $fid = (int)$fid;

        $raw = $this->db->get_where( 'course_file', array( 'cfid'=>$fid ) );

        if( $raw->num_rows == 1 ) {
            return $raw->result()[0];
        } else {
            return false;
        }

    }

    public function getTextbookInfo( $fid ) {
        
        $fid = (int)$fid;

        $raw = $this->db->get_where( 'course_textbook', array( 'ctbid'=>$fid ) );

        if( $raw->num_rows == 1 ) {
            $result = $raw->result()[0];
            #$result->file_list = 
            return $result;
        } else {
            return false;
        }

    }

    public function getCourseFiles( $cid ) {
        
        $cid = (int)$cid;

        $raw = $this->db->get_where( 'course_file', array( 'cid'=>$cid ) );

        if( $raw->num_rows != 0 ) {
            return $raw->result();
        } else {
            return [];
        }

    }

    public function getCourseTextBooks( $cid ) {
        
        $cid = (int)$cid;

        $raw = $this->db->get_where( 'course_textbook', array( 'cid'=>$cid ) );

        if( $raw->num_rows != 0 ) {
            return $raw->result();
        } else {
            return [];
        }

    }

}