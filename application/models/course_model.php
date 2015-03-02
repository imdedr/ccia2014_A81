<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_model extends CI_Model {

    public function detail( $cid )
    {

        $cid = (int)$cid;

        $raw = $this->db->get_where( 'course', array( 'cid'=>$cid ) );

        if( $raw->num_rows == 1 ) {
            $course_data = (array)$raw->result()[0];
            $course_data['time'] = json_decode($course_data['time']);
            return $course_data;
        } else {
            return [];
        }

    }

    public function userCourse( $uid )
    {
        $uid = (int)$uid;

        $this->db->select('cid');
        $data = $this->db->get_where( 'course_user', array('uid'=>$uid) );

        if( $data->num_rows != 0 )
        {
            return $data->result();
        } else {
            return [];
        }

    }

    public function sessionStatus( $cid ) {
        $raw = $this->db->get_where( 'course_session', array('cid'=>$cid) );
        if( $raw->num_rows == 1 ) {

            return $raw->result()[0];

        } else {
            return false;
        }
    }

    public function sessionList( $cid ) {
        $this->db->select('ssid, date');
        $raw = $this->db->get_where( 'session', array('cid'=>$cid) );
        return $raw->result();
    }

    public function sessionInfo( $ssid ) {
        $raw = $this->db->get_where( 'session', array('ssid'=>$ssid) );
        if( $raw->num_rows == 1 ) {
            return $raw->result()[0];
        } else {
            return false;
        }
    }

}