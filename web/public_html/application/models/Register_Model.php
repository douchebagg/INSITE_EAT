<?php
class Register_Model extends CI_model{

public function register_user($user){
    $this->db->insert('Account', $user);
}
public function username_check($username){
    $this->db->select('*');
    $this->db->from('Account');
    $this->db->where('USERNAME',$username);
    $query=$this->db->get();

    if($query->num_rows()>0){
        return false;
    }else{
        return true;
    }
}
}
?>