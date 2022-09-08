<?php

    class user_model extends CI_Model
    {

            public function get_email_data($email){
                $this->db->select("*"); 
                $this->db->from('user_details');
                $this->db->where('email', $email);
                $query = $this->db->get();
                return $query->result();
            }

            public function update_user($data,$id){
                $this->db->where('id', $id);
                $this->db->update('user_details', $data);
                $result = $this->db->affected_rows();
                return $result;
            }
    }
    
?>