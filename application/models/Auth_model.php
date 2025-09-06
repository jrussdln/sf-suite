<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_by_username($username)
    {
        return $this->db
            ->select('UserId, username, password, access_level, Identifier, user_account_access, email')
            ->from('user_tbl')
            ->where('username', $username)
            ->get()
            ->row();
    }

    public function update_user_status($user_id, $status)
    {
        $this->db->where('UserId', $user_id);
        $this->db->update('user_tbl', ['user_status' => $status]);
    }

    public function update_user_password($user_id, $hashed_password)
    {
        $this->db->where('UserId', $user_id);
        $this->db->update('user_tbl', ['password' => $hashed_password]);
    }

    public function has_requested_reset_today($user_id)
    {
        $today = date('Y-m-d');

        $this->db->where('UserId', $user_id);
        $this->db->where('DATE(created_at)', $today);
        $query = $this->db->get('pass_reset_log_tbl');

        return $query->row(); // returns row if exists, else null
    }
}
