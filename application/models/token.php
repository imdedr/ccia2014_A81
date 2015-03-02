<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Token extends CI_Model {

    public function login( $user, $pass )
    {
        $data = $this->db->get_where('user', array( 'username' => $user, 'password' => md5($pass) ));

        if( $data->num_rows == 1 ) {
            $user = $data->result()[0];

            // 搜尋Token
            $token_raw = $this->db->get_where( 'token', array( 'uid' => $user->uid ) );

            // 若已經產生過Token, 就直接覆蓋
            if( $token_raw->num_rows == 1 ) {
                
                $old_token = $token_raw->result()[0];

                $new_token = '';
                for( $i=0; $i<32; $i++ ) $new_token .= chr(rand(0, 26) + ord('a'));
                $new_token = md5( $new_token );

                $this->db->where('tid', $old_token->tid);
                $this->db->update( 'token', array('token'=>$new_token) );
                return $new_token;

            } else {

                $new_token = '';
                for( $i=0; $i<32; $i++ ) $new_token .= chr( rand(0, 25) + ord('a') );
                $new_token = md5( $new_token );
                $this->db->insert( 'token', array( 'uid'=>$user->uid, 'token'=>$new_token ) );
                return $new_token;
            }

        } else {
            return false;
        }
    }

    public function logout( $token )
    {
        $this->db->delete( 'token', array( 'token'=>$token ) );
    }

    public function tokenAuth( $token )
    {

        $user = $this->db->get_where('token', array('token'=>$token));
        if( $user->num_rows == 1 ) 
        {
            $user = $user->result()[0];
            $this->db->select('uid, name');
            $user = $this->db->get_where( 'user', array('uid'=>$user->uid) )->result()[0];
            return $user;
        } else {
            return false;
        }

    }

}