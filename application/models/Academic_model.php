<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Academic_model extends CI_Model
{
    const TABLE_SCHOOL_YEAR = 'school_year_tbl';
    const TABLE_CURRICULUM = 'curriculum_tbl';
    const TABLE_STRAND_TRACK = 'strand_track_tbl';
    const TABLE_STUDENT = 'student_tbl';
    const TABLE_REQUEST = 'request_tbl';
    const TABLE_SECTION = 'section_tbl';
    const TABLE_USER = 'user_tbl';
    const TABLE_NOTIF = 'notification_tbl';
    const TABLE_PERSONNEL = 'school_personnel_tbl';
    const TABLE_ADVISORY  = 'advisory_class_tbl';
    const TABLE_SUBJECT  = 'subjects_tbl';
    const TABLE_TLOADS  = 'teaching_loads_tbl';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
    }
    //academic year
    public function setAllInactive(): bool
    {
        return $this->db->update(self::TABLE_SCHOOL_YEAR, ['sy_status' => 'Inactive']);
    }
    public function setActive(int $syId): bool
    {
        $this->db->where('sy_id', $syId);
        return $this->db->update(self::TABLE_SCHOOL_YEAR, ['sy_status' => 'Active']);
    }
    public function deleteAcademicYear(int $syId): bool
    {
        return $this->db->delete(self::TABLE_SCHOOL_YEAR, ['sy_id' => $syId]);
    }
    public function getLastAcademicYear()
    {
        return $this->db
            ->select('sy_term')
            ->from(self::TABLE_SCHOOL_YEAR)
            ->order_by('sy_term', 'DESC')
            ->limit(1)
            ->get()
            ->row();
    }
    public function insertAcademicYear(string $syTerm, string $status = 'Inactive'): bool
    {
        return $this->db->insert(self::TABLE_SCHOOL_YEAR, [
            'sy_term'   => $syTerm,
            'sy_status' => $status
        ]);
    }
    //curiculum
    public function getAllCurriculums(): array
    {
        $this->db->select('c.*, st.strand_track_code'); // select all curriculum columns + strand_track_code
        $this->db->from(self::TABLE_CURRICULUM . ' c');
        $this->db->join(
            self::TABLE_STRAND_TRACK . ' st',
            'c.strand_track_id = st.strand_track_id',
            'left' // left join so it still returns if no strand/track assigned
        );
        $this->db->order_by('c.curriculum_status', 'ASC');
        $this->db->order_by('c.grade_level', 'DESC');

        return $this->db->get()->result_array();
    }
    public function getAllActiveCurriculums(): array
    {
        $this->db->where('curriculum_status', 'Active');
        $this->db->order_by('grade_level', 'DESC');
        $curriculums = $this->db->get(self::TABLE_CURRICULUM)->result_array();

        foreach ($curriculums as &$curriculum) {
            // Count subjects for this curriculum
            $subjects = $this->getSubjectsByCurriculum($curriculum['curriculum_id']);
            $curriculum['subject_count'] = count($subjects);
        }

        return $curriculums;
    }

    public function getCurriculumById(int $id)
    {
        return $this->db->get_where(self::TABLE_CURRICULUM, ['curriculum_id' => $id])->row();
    }
    public function updateCurriculumStatus(int $id, string $status): bool
    {
        return $this->db->where('curriculum_id', $id)
            ->update(self::TABLE_CURRICULUM, ['curriculum_status' => $status]);
    }
    public function insertCurriculum(array $data): bool
    {
        return $this->db->insert(self::TABLE_CURRICULUM, $data);
    }
    public function updateCurriculum(int $id, array $data): bool
    {
        return $this->db->where('curriculum_id', $id)
            ->update(self::TABLE_CURRICULUM, $data);
    }
    public function deleteCurriculum(int $curriculumId): bool
    {
        return $this->db->where('curriculum_id', $curriculumId)
            ->delete(self::TABLE_CURRICULUM);
    }
    //strand-track
    public function getAllStrandTracks(): array
    {
        return $this->db->order_by('strand_track_status', 'ASC')->get(self::TABLE_STRAND_TRACK)->result_array();
    }
    public function getAllActiveStrandTracks(): array
    {
        $this->db->where('strand_track_status', 'Active');
        return $this->db->order_by('created_at', 'DESC')->get(self::TABLE_STRAND_TRACK)->result_array();
    }
    public function getStrandById(int $strandId)
    {
        return $this->db->where('strand_track_id', $strandId)
            ->get(self::TABLE_STRAND_TRACK)
            ->row();
    }
    public function deleteStrandTrack(int $strandId): bool
    {
        return $this->db->where('strand_track_id', $strandId)
            ->delete(self::TABLE_STRAND_TRACK);
    }
    public function toggleStrandTrack(int $strandId, string $status): bool
    {
        return $this->db->where('strand_track_id', $strandId)
            ->update(self::TABLE_STRAND_TRACK, ['strand_track_status' => $status]);
    }
    public function getStrandTrackById(int $id)
    {
        return $this->db->get_where(self::TABLE_STRAND_TRACK, ['strand_track_id' => $id])->row_array();
    }
    public function insertStrandTrack(array $data): bool
    {
        return $this->db->insert(self::TABLE_STRAND_TRACK, $data);
    }
    public function updateStrandTrack(int $id, array $data): bool
    {
        $this->db->where('strand_track_id', $id);
        return $this->db->update(self::TABLE_STRAND_TRACK, $data);
    }
    // section
    public function getAllSections()
    {
        // active sy id (int)
        $active_sy_id = (int) $this->Main_model->getActiveSchoolYearId();

        $this->db->select('
        s.*,
        c.curriculum_code,
        sy.sy_term AS school_year,
        CONCAT(p.sp_lname, ", ", p.sp_fname, " ", p.sp_mname) AS adviser_name,
        COUNT(CASE WHEN r.req_status = "approved" THEN st.stud_id END) AS total_students
    ');
        $this->db->from(self::TABLE_SECTION . ' AS s');
        $this->db->join(self::TABLE_CURRICULUM . ' AS c', 's.curriculum_id = c.curriculum_id', 'left');
        $this->db->join(self::TABLE_STUDENT . ' AS st', 'st.section_id = s.section_id', 'left');
        $this->db->join(self::TABLE_REQUEST . ' AS r', 'r.req_id = st.req_id', 'left');

        // link section -> school_year via sy_desc (because s.school_year stores sy_desc)
        $this->db->join(self::TABLE_SCHOOL_YEAR . ' AS sy', 'sy.sy_id = s.sy_id', 'inner');

        // advisory_class_tbl for adviser assignment in that sy
        $this->db->join(
            self::TABLE_ADVISORY . ' AS ac',
            'ac.section_id = s.section_id AND ac.sy_id = ' . $active_sy_id,
            'left'
        );

        // adviser pulled from advisory_class_tbl (if any)
        $this->db->join(self::TABLE_PERSONNEL . ' AS p', 'p.sp_id = ac.sp_id', 'left');

        // ensure we only return sections for the active school year
        $this->db->where('sy.sy_id', $active_sy_id);

        // group / order
        $this->db->group_by('s.section_id');
        $this->db->order_by('s.grade_level', 'ASC');
        $this->db->order_by('s.section_status', 'ASC');

        return $this->db->get()->result_array();
    }


    public function save_section($data)
    {
        if (!empty($data['section_id'])) {
            // Update existing
            $this->db->where('section_id', $data['section_id']);
            return $this->db->update(self::TABLE_SECTION, $data);
        } else {
            // Insert new
            unset($data['section_id']);
            return $this->db->insert(self::TABLE_SECTION, $data);
        }
    }
    public function getGradeLevelsByCurriculum($curriculum_id)
    {
        $curriculum = $this->db->get_where(self::TABLE_CURRICULUM, ['curriculum_id' => $curriculum_id])->row_array();
        $levels = [];

        if ($curriculum && !empty($curriculum['grade_level'])) {
            // Example: grade_level = "0-3"
            $parts = explode('-', $curriculum['grade_level']);
            if (count($parts) == 2) {
                $start = (int)$parts[0];
                $end = (int)$parts[1];
                for ($i = $start; $i <= $end; $i++) {
                    $levels[] = $i;
                }
            }
        }

        return $levels;
    }
    public function deleteSection($section_id)
    {
        $this->db->where('section_id', $section_id);
        return $this->db->delete(self::TABLE_SECTION); // Replace with your table name
    }
    public function get_section(int $id)
    {
        return $this->db->get_where(self::TABLE_SECTION, ['section_id' => $id])->row();
    }
    public function updateSectionStatus(int $id, string $status): bool
    {
        return $this->db->where('section_id', $id)
            ->update(self::TABLE_SECTION, ['section_status' => $status]);
    }
    public function getStudentsBySection($section_id)
    {
        // Join STUDENT with REQUEST to ensure req_id status is approved
        $this->db->select('s.*');
        $this->db->from(self::TABLE_STUDENT . ' s');
        $this->db->join(self::TABLE_REQUEST . ' r', 's.req_id = r.req_id', 'inner');
        $this->db->where('s.section_id', $section_id);
        $this->db->where('r.req_status', 'approved');

        return $this->db->get()->result_array();
    }
    //import
    public function insertStudent($data)
    {
        // Check if section exists and get max_cap
        $section = $this->get_section($data['section_id']);
        if (!$section) {
            return 'section_not_found';
        }

        // Check current number of students in the section
        $current_count = $this->db->where('section_id', $data['section_id'])
            ->count_all_results(self::TABLE_STUDENT);

        if ($current_count >= (int)$section->max_cap) {
            return 'full'; // Section is full
        }

        // Check if LRN already exists in this section
        $this->db->where('stud_lrn', $data['stud_lrn']);
        $this->db->where('section_id', $data['section_id']);
        $query = $this->db->get(self::TABLE_STUDENT);

        if ($query->num_rows() > 0) {
            return false; // Already exists
        }

        return $this->db->insert(self::TABLE_STUDENT, $data);
    }
    public function hasPendingRequest($user_id)
    {
        $pending = $this->db->where('req_sender_id', $user_id)
            ->where('req_status', 'pending')
            ->get(self::TABLE_REQUEST)
            ->row();

        if ($pending) {
            return [
                'status' => 'error',
                'message' => 'You still have a pending request. Please contact the admin.'
            ];
        }

        return ['status' => 'success'];
    }
    //request
    public function insertRequest($reqData)
    {
        return $this->db->insert(self::TABLE_REQUEST, $reqData);
    }
    public function getRequests()
    {
        $this->db->select('r.*, sender.UserFName as SenderFName, receiver.UserFName as ReceiverFName');
        $this->db->from(self::TABLE_REQUEST . ' r');
        $this->db->join(self::TABLE_USER . ' sender', 'r.req_sender_id = sender.UserId', 'left');
        $this->db->join(self::TABLE_USER . ' receiver', 'r.req_receiver_id = receiver.UserId', 'left');
        $this->db->order_by('r.created_at', 'DESC');
        return $this->db->get()->result_array();
    }
    public function approveRequest($req_id, $receiver_id)
    {
        $data = [
            'req_status' => 'approved',
            'req_receiver_id' => $receiver_id
        ];
        $this->db->where('req_id', $req_id);
        return $this->db->update(self::TABLE_REQUEST, $data);
    }
    public function rejectRequest($req_id, $receiver_id)
    {
        $this->db->trans_start();

        // 1. Update request_tbl status to 'rejected'
        $this->db->where('req_id', $req_id);
        $this->db->update(self::TABLE_REQUEST, [
            'req_status' => 'rejected',
            'req_receiver_id' => $receiver_id
        ]);

        // 2. Delete from student_tbl where req_id matches
        $this->db->where('req_id', $req_id);
        $this->db->delete(self::TABLE_STUDENT);

        $this->db->trans_complete();

        return $this->db->trans_status(); // Returns TRUE if both succeeded
    }
    public function getPendingRequestsCount()
    {
        return $this->db->where('req_status', 'pending')
            ->from(self::TABLE_REQUEST)
            ->count_all_results();
    }
    public function insertNotification($req_id, $notif_desc)
    {
        // Get the sender of the request using req_sender_id
        $request = $this->db->get_where(self::TABLE_REQUEST, ['req_id' => $req_id])->row();
        if ($request) {
            $data = [
                'notif_desc' => $notif_desc,
                'notif_read' => 0, // 0 = Unread
                'user_id'    => $request->req_sender_id
            ];
            $this->db->insert(self::TABLE_NOTIF, $data);
        }
    }
    public function addStudent($data)
    {
        return $this->db->insert(self::TABLE_STUDENT, $data);
    }

    // Update existing student
    public function updateStudent($stud_id, $data)
    {
        $this->db->where('stud_id', $stud_id);
        return $this->db->update(self::TABLE_STUDENT, $data);
    }

    public function getStudent($stud_id)
    {
        $this->db->where('stud_id', $stud_id);
        return $this->db->get(self::TABLE_STUDENT)->row_array(); // returns single student
    }

    public function getStudentCountBySection($section_id)
    {
        return $this->db->where('section_id', $section_id)
            ->count_all_results(self::TABLE_STUDENT);
    }

    public function transferStudentSection($stud_id, $new_section_id)
    {
        // Check if student exists
        $student = $this->db->get_where(self::TABLE_STUDENT, ['stud_id' => $stud_id])->row();
        if (!$student) {
            return false; // student not found
        }

        // Check if already in the same section
        if ($student->section_id == $new_section_id) {
            return 'no_change';
        }

        // Update section
        $this->db->where('stud_id', $stud_id);
        return $this->db->update(self::TABLE_STUDENT, ['section_id' => $new_section_id]);
    }
    // Fetch subjects by curriculum_id with condition for grade 11-12
    public function getSubjectsByCurriculum($curriculum_id)
    {
        // Get the grade_level of the curriculum
        $curriculum = $this->db->select('grade_level')
            ->where('curriculum_id', $curriculum_id)
            ->get(self::TABLE_CURRICULUM)
            ->row();

        $grade_level = $curriculum ? $curriculum->grade_level : null;

        $this->db->group_start()
            ->where('curriculum_id', $curriculum_id) // Always fetch the given curriculum
            ->or_group_start()
            ->where('curriculum_id', 0);          // Allow fallback
        if ($grade_level !== null) {
            $this->db->where('subject_grade', $grade_level); // Match grade level
        }
        $this->db->group_end()
            ->group_end();
        $this->db->order_by('subject_type', 'ASC');

        $query = $this->db->get(self::TABLE_SUBJECT);
        return $query->result_array();
    }

    public function getAllSubjects()
    {
        $this->db->select('s.*, COUNT(tl.subject_id) as subject_count');
        $this->db->from(self::TABLE_SUBJECT . ' s');
        $this->db->join(self::TABLE_TLOADS . ' tl', 's.subject_id = tl.subject_id', 'left');
        $this->db->where('s.subject_status', 'active');
        $this->db->group_by('s.subject_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllSubjectTypeJHS()
    {
        $this->db->select('subject_type, COUNT(*) as subject_count');
        $this->db->where('subject_grade', '7-10');
        $this->db->order_by('subject_type', 'ASC');
        $this->db->order_by('subject_status', 'ASC');
        $this->db->group_by('subject_type');

        $query = $this->db->get(self::TABLE_SUBJECT);
        return $query->result_array();
    }

    public function getAllSubjectTypeSHS()
    {
        $this->db->select('subject_type, COUNT(*) as subject_count');
        $this->db->where('subject_grade', '11-12');
        $this->db->order_by('subject_type', 'ASC');
        $this->db->order_by('subject_status', 'ASC');
        $this->db->group_by('subject_type');

        $query = $this->db->get(self::TABLE_SUBJECT);
        return $query->result_array();
    }

    public function getSubjectsByType($subject_type, $level)
    {
        $this->db->where('subject_type', $subject_type);

        if ($level === "JHS") {
            $this->db->where('subject_grade =', '7-10');
        } elseif ($level === "SHS") {
            $this->db->where('subject_grade =', '11-12');
        }
        $this->db->order_by('subject_status', 'ASC');

        return $this->db->get(self::TABLE_SUBJECT)->result_array();
    }
    // Insert new subject
    public function insertSubject($data)
    {
        return $this->db->insert(self::TABLE_SUBJECT, $data);
    }

    // Update existing subject
    public function updateSubject($subject_id, $data)
    {
        return $this->db->where('subject_id', $subject_id)->update(self::TABLE_SUBJECT, $data);
    }
    public function getCurriculumGrade($curriculum_id)
    {
        $this->db->select('grade_level');
        $this->db->from(self::TABLE_CURRICULUM);
        $this->db->where('curriculum_id', $curriculum_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->grade_level;
        }
        return false;
    }
    // Get single subject by ID
    public function get_subject_by_id($subject_id)
    {
        $this->db->where('subject_id', $subject_id);
        $query = $this->db->get(self::TABLE_SUBJECT); // change 'subjects' to your actual table
        return $query->row_array(); // returns single row as array
    }
    public function getAllPersonnel()
    {
        $this->db->select("
        *,
        CONCAT(sp_fname, ' ', sp_mname, ' ', sp_lname, ' ', IFNULL(sp_ename, '')) AS full_name
    ");
        $this->db->from(self::TABLE_PERSONNEL);
        $this->db->order_by('sp_id', 'ASC');
        return $this->db->get()->result_array();
    }
    public function getPersonnelById($id)
    {
        $active_sy_id = $this->Main_model->getActiveSchoolYearId();

        $this->db->select("
        school_personnel_tbl.*,
        COALESCE(NULLIF(school_personnel_tbl.sp_employment_status, ''), 'Unknown') AS sp_employment_status,
        section_tbl.section_id,
        CONCAT_WS(' ', sp_fname, sp_mname, sp_lname, sp_ename) AS full_name,
        plantilla_pos_tbl.pp_desc,
        section_tbl.section_name,
        CASE 
            WHEN user_tbl.Identifier IS NULL THEN 'No Account'
            WHEN user_tbl.Identifier = school_personnel_tbl.sp_no AND user_tbl.user_account_access = 0 THEN 'Active'
            WHEN user_tbl.Identifier = school_personnel_tbl.sp_no AND user_tbl.user_account_access = 1 THEN 'Blocked'
            ELSE 'No Account'
        END AS user_account,
        (
            SELECT COUNT(*) 
            FROM anc_ass_log_tbl 
            WHERE anc_ass_log_tbl.sp_id = school_personnel_tbl.sp_id
              AND anc_ass_log_tbl.sy_id = {$active_sy_id}
        ) AS ancillary_count,
        (
            SELECT COUNT(*) 
            FROM teaching_loads_tbl 
            WHERE teaching_loads_tbl.sp_id = school_personnel_tbl.sp_id 
              AND teaching_loads_tbl.sy_id = {$active_sy_id}
        ) AS loads_count,
        (
            SELECT CONCAT(
                ROUND(
                    AVG(
                        TIMESTAMPDIFF(MINUTE, tl_start, tl_end) * 
                        (tl_mon + tl_tue + tl_wed + tl_thu + tl_fri + tl_sat + tl_sun)
                    )
                ),
                ' min'
            )
            FROM teaching_loads_tbl 
            WHERE teaching_loads_tbl.sp_id = school_personnel_tbl.sp_id
              AND teaching_loads_tbl.sy_id = {$active_sy_id}
        ) AS average_teaching
    ");
        $this->db->from("school_personnel_tbl");
        $this->db->join("plantilla_pos_tbl", "school_personnel_tbl.sp_position = plantilla_pos_tbl.pp_id", "left");

        // ✅ Join advisory_class_tbl only for active school year
        $this->db->join(
            "advisory_class_tbl",
            "advisory_class_tbl.sp_id = school_personnel_tbl.sp_id 
         AND advisory_class_tbl.sy_id = " . (int)$active_sy_id,
            "left"
        );

        $this->db->join("section_tbl", "advisory_class_tbl.section_id = section_tbl.section_id", "left");
        $this->db->join("school_year_tbl", "school_year_tbl.sy_id = section_tbl.sy_id", "left");
        $this->db->join("user_tbl", "user_tbl.Identifier = school_personnel_tbl.sp_no", "left");

        $this->db->where("school_personnel_tbl.sp_id", $id);

        return $this->db->get()->row_array();
    }
    public function saveTeachingLoad($active_sy, $tl_id, $sp_id, $subject_id, $tl_grade_level, $tl_start, $tl_end, $days)
    {
        // 1. Check for conflicts
        $this->db->from('teaching_loads_tbl');
        $this->db->where('sp_id', $sp_id);
        if ($tl_id) {
            $this->db->where('tl_id !=', $tl_id); // exclude current if updating
        }
        $query = $this->db->get();
        $existingLoads = $query->result_array();

        foreach ($existingLoads as $load) {
            foreach ($days as $day => $active) {
                if ($active == 1 && $load[$day] == 1) {
                    $existingStart = strtotime($load['tl_start']);
                    $existingEnd   = strtotime($load['tl_end']);
                    $newStart      = strtotime($tl_start);
                    $newEnd        = strtotime($tl_end);

                    if (($newStart < $existingEnd) && ($newEnd > $existingStart)) {
                        return [
                            'status'  => 'conflict',
                            'message' => "Time conflict detected with existing load ({$load['tl_start']} - {$load['tl_end']}) on " . ucfirst(str_replace('tl_', '', $day))
                        ];
                    }
                }
            }
        }

        // 2. Prepare data
        $data = array_merge([
            'sp_id'          => $sp_id,
            'subject_id'     => $subject_id,
            'tl_grade_level' => $tl_grade_level,
            'tl_start'       => $tl_start,
            'tl_end'         => $tl_end
        ], $days);

        // 3. Insert or update
        if ($tl_id) {
            $this->db->where('tl_id', $tl_id);
            $result = $this->db->update('teaching_loads_tbl', $data);
            $action = 'updated';
        } else {
            $data['sy_id'] = $active_sy;
            $result = $this->db->insert('teaching_loads_tbl', $data);
            $action = 'added';
        }

        if ($result) {
            return ['status' => 'success', 'message' => "Teaching load $action successfully"];
        } else {
            $error = $this->db->error();
            return ['status' => 'error', 'message' => "Failed to $action teaching load", 'db_error' => $error['message']];
        }
    }

    // ✅ Insert advisory record
    public function insertAdvisory($section_id, $sy_id, $sp_id)
    {
        return $this->db->insert(self::TABLE_ADVISORY, [
            'section_id' => $section_id,
            'sy_id'      => $sy_id,
            'sp_id'      => $sp_id
        ]);
    }

    // ✅ Update advisory record
    public function updateAdvisory($ac_id, $section_id)
    {
        return $this->db->where('ac_id', $ac_id)
            ->update(self::TABLE_ADVISORY, [
                'section_id' => $section_id,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
    }
    // ✅ Check if section already has an adviser in active SY
    public function isSectionAssigned1($section_id, $sy_id, $exclude_sp_id = null)
    {
        $this->db->from(self::TABLE_ADVISORY);
        $this->db->where('section_id', $section_id);
        $this->db->where('sy_id', $sy_id);

        if ($exclude_sp_id) {
            $this->db->where('sp_id !=', $exclude_sp_id);
        }

        return $this->db->count_all_results() > 0;
    }

    // ✅ Get advisory record for a teacher in active SY
    public function getAdvisoryByPersonnel($sp_id, $sy_id)
    {
        return $this->db->get_where(self::TABLE_ADVISORY, [
            'sp_id' => $sp_id,
            'sy_id' => $sy_id
        ])->row();
    }
    public function insertPersonnel($data)
    {
        $this->db->insert('school_personnel_tbl', $data);
        return $this->db->insert_id(); // return new ID
    }


    // Update personnel profile
    public function savePersonnel($sp_id, $data)
    {
        $this->db->where('sp_id', $sp_id);
        return $this->db->update('school_personnel_tbl', $data); // replace 'sp_tbl' with your table name
    }
    public function getAllPlantillaPositions()
    {
        $this->db->order_by('pp_rank', 'ASC'); // Optional: order by rank
        $query = $this->db->get('plantilla_pos_tbl');
        return $query->result_array(); // Returns as array for dropdowns, etc.
    }
    // Update rank after drag-and-drop
    public function updatePlantillaRank($pp_id, $pp_rank)
    {
        $this->db->where('pp_id', $pp_id);
        return $this->db->update('plantilla_pos_tbl', ['pp_rank' => $pp_rank]);
    }
    public function insertPlantilla($data)
    {
        return $this->db->insert('plantilla_pos_tbl', $data);
    }

    public function updatePlantilla($pp_id, $data)
    {
        $this->db->where('pp_id', $pp_id);
        return $this->db->update('plantilla_pos_tbl', $data);
    }
    public function deletePlantillaById($pp_id)
    {
        $this->db->where('pp_id', $pp_id);
        return $this->db->delete('plantilla_pos_tbl'); // Returns true if deleted
    }

    public function getAllAncillary()
    {
        // Get active school year (string like "2024-2025")
        $activeSy = $this->Main_model->getActiveSchoolYearId();

        $this->db->select('
            a.*,
            GROUP_CONCAT(CONCAT(sp.sp_lname, " ", sp.sp_fname) SEPARATOR ", ") AS assigned_personnel
        ');
        $this->db->from('anc_ass_tbl a');
        $this->db->join('anc_ass_log_tbl l', 'l.aa_id = a.aa_id', 'left');

        if ($activeSy !== null) {
            $this->db->join(
                'school_personnel_tbl sp',
                'sp.sp_id = l.sp_id AND l.sy_id = ' . $this->db->escape($activeSy),
                'left'
            );
        } else {
            // fallback if no active SY
            $this->db->join('school_personnel_tbl sp', 'sp.sp_id = l.sp_id', 'left');
        }

        // 👇 Important: group by ancillary id so GROUP_CONCAT works
        $this->db->group_by('a.aa_id');

        $query = $this->db->get();
        return $query->result_array();
    }
    public function saveAncillary()
    {
        $data = [
            'aa_desc' => $this->input->post('aa_aa_desc')
        ];

        $aa_id = $this->input->post('aa_aa_id');

        if ($aa_id) {
            // Update existing
            $this->db->where('aa_id', $aa_id);
            $success = $this->db->update('anc_ass_tbl', $data);
        } else {
            // Insert new
            $success = $this->db->insert('anc_ass_tbl', $data);
        }

        echo json_encode(['success' => $success]);
    }

    public function deleteAncillary()
    {
        $aa_id = $this->input->post('aa_id');
        if (!$aa_id) {
            echo json_encode(['success' => false, 'message' => 'No ID provided']);
            return;
        }

        $this->db->where('aa_id', $aa_id);
        $success = $this->db->delete('anc_ass_tbl');

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Deleted successfully' : 'Failed to delete'
        ]);
    }
    public function saveAncillaryAssignments($sp_id, $aa_ids)
    {
        $lastAalId = null;

        // ✅ Get active school year first
        $active_sy = $this->Main_model->getActiveSchoolYearId();

        foreach ($aa_ids as $aa_id) {
            // Check if assignment already exists for this sp_id, aa_id, and school year
            $exists = $this->db->get_where('anc_ass_log_tbl', [
                'sp_id' => $sp_id,
                'aa_id' => $aa_id,
                'sy_id' => $active_sy
            ])->row();

            if (!$exists) {
                $this->db->insert('anc_ass_log_tbl', [
                    'sp_id' => $sp_id,
                    'aa_id' => $aa_id,
                    'sy_id' => $active_sy
                ]);
                $lastAalId = $this->db->insert_id(); // new inserted aal_id
            } else {
                $lastAalId = $exists->aal_id; // use existing aal_id if already assigned
            }
        }

        return $lastAalId;
    }
    public function removeAncillaryAssignmentById($aal_id)
    {
        $this->db->where('aal_id', $aal_id);
        return $this->db->delete('anc_ass_log_tbl');
    }
    public function getAssignedAncillary($sp_id)
    {
        // Step 1: Get active school year
        $active_sy = $this->Main_model->getActiveSchoolYearId();

        // Step 2: Query with validation for active_sy
        $this->db->select('a.aa_id, a.aa_desc, l.aal_id, l.sy_id AS aal_school_year');
        $this->db->from('anc_ass_log_tbl l');
        $this->db->join('anc_ass_tbl a', 'l.aa_id = a.aa_id');
        $this->db->where('l.sp_id', $sp_id);
        $this->db->where('l.sy_id', $active_sy); // ✅ filter by active SY
        $query = $this->db->get();

        return $query->result_array();
    }
    public function fetchTeachingLoads($personnel_id)
    {
        // Step 1: Get Active School Year (e.g., "2024-2025")
        $active_sy = $this->Main_model->getActiveSchoolYearId();
        if ($active_sy === 'N/A') {
            return []; // No active school year, return empty
        }

        // Step 3: Build Query with extra joins & filters
        $this->db->select('
        tl.subject_id,
        tl.tl_id, 
        tl.tl_start, 
        tl.tl_end, 
        tl.tl_grade_level,
        tl.updated_at,
        s.subject_name,
        TRIM(BOTH "," FROM CONCAT(
            IF(tl.tl_mon=1, "M,", ""),
            IF(tl.tl_tue=1, "T,", ""),
            IF(tl.tl_wed=1, "W,", ""),
            IF(tl.tl_thu=1, "TH,", ""),
            IF(tl.tl_fri=1, "F,", ""),
            IF(tl.tl_sat=1, "Sat,", ""),
            IF(tl.tl_sun=1, "Sun,", "")
        )) as days', FALSE);
        $this->db->from('teaching_loads_tbl tl');
        $this->db->join('subjects_tbl s', 's.subject_id = tl.subject_id', 'left');
        $this->db->join('curriculum_tbl c', 'c.curriculum_id = s.curriculum_id', 'left');
        $this->db->where('tl.sp_id', $personnel_id);

        // Step 4: Filter by active school year
        $this->db->where('tl.sy_id', $active_sy);

        $this->db->order_by('tl.updated_at', 'DESC');

        $loads = $this->db->get()->result_array();

        // Step 5: Calculate per_week minutes
        foreach ($loads as &$load) {
            $start = strtotime($load['tl_start']);
            $end   = strtotime($load['tl_end']);
            $durationMinutes = ($end - $start) / 60;

            // Count active days
            $daysArray = explode(',', $load['days']);
            $activeDays = count(array_filter($daysArray)); // avoid empty values

            // Total minutes per week
            $load['per_week'] = $durationMinutes * $activeDays;
        }

        return $loads;
    }

    public function deleteTeachingLoad($tl_id)
    {
        $this->db->where('tl_id', $tl_id);
        return $this->db->delete('teaching_loads_tbl');
    }
    public function getAllAdvisory()
    {
        $active_sy = $this->Main_model->getActiveSchoolYearId();

        $this->db->select("
        s.section_id,
        s.section_name,
        CONCAT(sp.sp_lname, ' ', sp.sp_fname) AS adviser_name,
        sy.sy_term AS school_year
    ");
        $this->db->from(self::TABLE_SECTION . ' AS s');
        $this->db->join('advisory_class_tbl AS ac', 's.section_id = ac.section_id', 'left');
        $this->db->join('school_personnel_tbl AS sp', 'ac.sp_id = sp.sp_id', 'left');
        $this->db->join('school_year_tbl AS sy', 'sy.sy_id = s.sy_id', 'left');
        $this->db->where('CAST(s.sy_id AS UNSIGNED) =', $active_sy, false); // false = don't escape
        $this->db->order_by('s.section_name', 'ASC');

        return $this->db->get()->result_array();
    }



    public function getTeachingLoadsByActiveSY()
    {
        $active_sy = $this->Main_model->getActiveSchoolYearId();

        return $this->db->select('tl.tl_id, sp.sp_id, sp.sp_lname, sp.sp_fname')
            ->from('teaching_loads_tbl AS tl')
            ->join('school_personnel_tbl AS sp', 'sp.sp_id = tl.sp_id')
            ->where('tl.sy_id', $active_sy)
            ->get()
            ->result_array();
    }
    public function getAncillaryAssignmentsByActiveSY()
    {
        $active_sy = $this->Main_model->getActiveSchoolYearId();

        return $this->db->select('
            aal.aal_id, 
            sp.sp_id, 
            sp.sp_lname, 
            sp.sp_fname, 
            aa.aa_id,
            aa.aa_desc
        ')
            ->from('anc_ass_log_tbl AS aal')
            ->join('school_personnel_tbl AS sp', 'sp.sp_id = aal.sp_id')
            ->join('anc_ass_tbl AS aa', 'aa.aa_id = aal.aa_id')
            ->where('aal.sy_id', $active_sy)
            ->get()
            ->result_array();
    }

    public function insertInheritedAncillary($sy_id, $sp_ids, $aa_ids)
    {
        if (empty($sy_id) || empty($sp_ids) || empty($aa_ids)) {
            return ['inserted' => 0, 'skipped' => 0];
        }

        $inserted = 0;
        $skipped  = 0;

        foreach ($sp_ids as $index => $sp_id) {
            $aa_id = isset($aa_ids[$index]) ? $aa_ids[$index] : 0;

            // Check for duplicate
            $exists = $this->db->select('1')
                ->from('anc_ass_log_tbl')
                ->where('sy_id', $sy_id)
                ->where('sp_id', $sp_id)
                ->where('aa_id', $aa_id)
                ->get()
                ->num_rows();

            if ($exists == 0) {
                $this->db->insert('anc_ass_log_tbl', [
                    'sy_id' => $sy_id,
                    'aa_id' => $aa_id,
                    'sp_id' => $sp_id
                ]);
                $inserted++;
            } else {
                $skipped++;
            }
        }

        return ['inserted' => $inserted, 'skipped' => $skipped];
    }

    public function insertInheritedTeachingLoad($sy_id, $sp_ids)
    {
        if (empty($sy_id) || empty($sp_ids)) {
            return ['inserted' => 0, 'skipped' => 0];
        }

        $active_sy = $this->Main_model->getActiveSchoolYearId();
        $inserted  = 0;
        $skipped   = 0;

        foreach ($sp_ids as $sp_id) {
            // 🔹 Get all teaching loads of this personnel in the ACTIVE school year
            $teaching_loads = $this->db->get_where('teaching_loads_tbl', [
                'sp_id' => $sp_id,
                'sy_id' => $active_sy
            ])->result_array();

            foreach ($teaching_loads as $load) {
                // 🔹 Check if the same load already exists for the new sy_id
                $exists = $this->db->get_where('teaching_loads_tbl', [
                    'sp_id'          => $sp_id,
                    'sy_id'          => $sy_id,
                    'tl_grade_level' => $load['tl_grade_level'],
                    'subject_id'     => $load['subject_id'],
                    'tl_start'       => $load['tl_start'],
                    'tl_end'         => $load['tl_end'],
                    'tl_mon'         => $load['tl_mon'],
                    'tl_tue'         => $load['tl_tue'],
                    'tl_wed'         => $load['tl_wed'],
                    'tl_thu'         => $load['tl_thu'],
                    'tl_fri'         => $load['tl_fri'],
                    'tl_sat'         => $load['tl_sat'],
                    'tl_sun'         => $load['tl_sun']
                ])->num_rows();

                if ($exists == 0) {
                    // 🔹 Insert new teaching load with the new sy_id
                    unset($load['tl_id']); // remove PK if it exists
                    $load['sy_id'] = $sy_id;

                    $this->db->insert('teaching_loads_tbl', $load);
                    $inserted++;
                } else {
                    $skipped++;
                }
            }
        }

        return ['inserted' => $inserted, 'skipped' => $skipped];
    }
}
