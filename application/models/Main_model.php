<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_model extends CI_Model
{
    const TABLE_SCHOOL_YEAR = 'school_year_tbl';

    public function __construct()
    {
        parent::__construct();
    }

    // Get active school year
    public function getActiveSchoolYear(): string
    {
        $this->db->select('sy_term, sy_id');
        $this->db->from(self::TABLE_SCHOOL_YEAR);
        $this->db->where('sy_status', 'Active');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->sy_term;
        }

        return 'N/A';
    }
    public function getActiveSchoolYearId(): ?int
    {
        $this->db->select('sy_id');
        $this->db->from(self::TABLE_SCHOOL_YEAR);
        $this->db->where('sy_status', 'Active');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return (int) $query->row()->sy_id;
        }

        return null;
    }

    //select option
    public function getAllAcademicYears(): array
    {
        return $this->db
            ->select('sy_id, sy_term, sy_status')
            ->from(self::TABLE_SCHOOL_YEAR)
            ->order_by('sy_term', 'ASC')
            ->get()
            ->result_array();
    }
    public function getAllAcademicYearsWithoutActive(): array
    {
        return $this->db
            ->select('sy_id, sy_term, sy_status')
            ->from(self::TABLE_SCHOOL_YEAR)
            ->where('sy_status', 'Inactive') // ✅ Corrected
            ->order_by('sy_term', 'ASC')
            ->get()
            ->result_array();
    }

    public function getNotificationsWithUser($userId)
    {
        $this->db->select('n.*, u.UserFName, u.UserMName, u.UserLName');
        $this->db->from('notification_tbl AS n');
        $this->db->join('user_tbl AS u', 'n.user_id = u.UserId', 'left');
        $this->db->where("(n.user_id = 0 OR n.user_id = {$this->db->escape_str($userId)})");
        $this->db->order_by('n.created_at', 'DESC');

        return $this->db->get()->result_array();
    }
    public function markAllNotificationsRead($userId)
    {
        $this->db->where("(user_id = 0 OR user_id = {$this->db->escape_str($userId)})");
        return $this->db->update('notification_tbl', ['notif_read' => 1]);
    }
}
