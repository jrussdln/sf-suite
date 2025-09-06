<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Academic extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_model');
        $this->load->model('Academic_model');
    }
    //academic year
    public function updateActiveAcademicYear()
    {
        $syId = $this->input->post('sy_id');
        if (!$syId) {
            show_error('Invalid input');
            return;
        }
        $this->Academic_model->setAllInactive();
        // Set selected year active
        $this->Academic_model->setActive($syId);
        echo json_encode(['status' => 'success']);
    }
    public function deleteAcademicYear()
    {
        $syId = $this->input->post('sy_id');
        if (empty($syId)) {
            echo json_encode(['success' => false, 'message' => 'Academic year ID is required']);
            return;
        }
        $deleted = $this->Academic_model->deleteAcademicYear($syId);
        if ($deleted) {
            echo json_encode(['success' => true, 'message' => 'Academic year deleted']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete academic year']);
        }
    }
    public function addAcademicYear()
    {
        // Get current year
        $currentYear = (int)date('Y');
        // Get last year from DB
        $lastYear = $this->Academic_model->getLastAcademicYear();
        if ($lastYear) {
            list($start, $end) = explode('-', $lastYear->sy_term);
            $start = (int)$start;
            $end   = (int)$end;
            if ($start >= $currentYear + 2) {
                echo json_encode([
                    'success' => false,
                    'message' => 'You cannot add more than one year ahead of the current year.'
                ]);
                return;
            }
            // Increment by 1 year
            $newStart = $start + 1;
            $newEnd   = $end + 1;
            $newYear  = $newStart . '-' . $newEnd;
        } else {
            // If empty table, default to current year +1
            $newYear = $currentYear . '-' . ($currentYear + 1);
        }
        // Insert into DB
        $inserted = $this->Academic_model->insertAcademicYear($newYear);
        // Return JSON response
        if ($inserted) {
            echo json_encode([
                'success'  => true,
                'message'  => 'Academic year added successfully',
                'newYear'  => $newYear
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add academic year'
            ]);
        }
    }
    //curriculum
    public function toggleCurriculumStatus()
    {
        $curriculumId = $this->input->post('curriculum_id');
        if (empty($curriculumId)) {
            echo json_encode(['success' => false, 'message' => 'Invalid curriculum ID']);
            return;
        }
        // Get current status
        $curriculum = $this->Academic_model->getCurriculumById($curriculumId);
        if (!$curriculum) {
            echo json_encode(['success' => false, 'message' => 'Curriculum not found']);
            return;
        }
        $newStatus = (strtolower($curriculum->curriculum_status) === 'active') ? 'Inactive' : 'Active';
        $updated = $this->Academic_model->updateCurriculumStatus($curriculumId, $newStatus);
        if ($updated) {
            echo json_encode(['success' => true, 'new_status' => $newStatus]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }
    public function getCurriculum($id)
    {
        $curriculum = $this->Academic_model->getCurriculumById($id);
        if ($curriculum) {
            echo json_encode(['success' => true, 'data' => $curriculum]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Curriculum not found']);
        }
    }
    public function saveCurriculum()
    {
        $id = $this->input->post('curriculum_id');
        $data = [
            'curriculum_code'           => $this->input->post('curriculum_code'),
            'curriculum_name'           => $this->input->post('curriculum_name'),
            'curriculum_type'           => $this->input->post('curriculum_type'),
            'strand_track_id'              => $this->input->post('ec_strand_track_id'),
            'grade_level'               => $this->input->post('ec_grade_level'),
            'curriculum_desc'           => $this->input->post('curriculum_desc'),
            'deped_learning_area_code'  => $this->input->post('deped_learning_area_code'),
            'competency_code'           => $this->input->post('competency_code'),
            'competency_desc'           => $this->input->post('competency_desc'),
            'school_year_start'         => $this->input->post('school_year_start'),
            'school_year_end'           => $this->input->post('school_year_end')
        ];
        if ($id) {
            // Update
            $updated = $this->Academic_model->updateCurriculum($id, $data);
            if ($updated) {
                echo json_encode(['success' => true, 'data' => $data, 'message' => 'Curriculum updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update curriculum.']);
            }
        } else {
            // Insert
            $inserted = $this->Academic_model->insertCurriculum($data);
            if ($inserted) {
                // optionally fetch the inserted curriculum with its ID
                $data['curriculum_id'] = $this->db->insert_id(); // Get the last inserted ID
                echo json_encode(['success' => true, 'data' => $data, 'message' => 'Curriculum added successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add curriculum.']);
            }
        }
    }
    public function delete()
    {
        $curriculumId = $this->input->post('curriculum_id');
        if (!$curriculumId) {
            echo json_encode(['success' => false, 'message' => 'Curriculum ID is required']);
            return;
        }
        $deleted = $this->Academic_model->deleteCurriculum($curriculumId);
        if ($deleted) {
            echo json_encode(['success' => true, 'message' => 'Curriculum deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete curriculum.']);
        }
    }
    //strand-track
    public function deleteStrand()
    {
        $strandId = $this->input->post('strand_id');
        if (empty($strandId)) {
            echo json_encode(['success' => false, 'message' => 'Strand ID is required']);
            return;
        }
        $deleted = $this->Academic_model->deleteStrandTrack($strandId);
        if ($deleted) {
            echo json_encode(['success' => true, 'message' => 'Strand deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete strand']);
        }
    }
    public function toggleStrand()
    {
        $strandId = $this->input->post('strand_id');
        $current = $this->Academic_model->getStrandById($strandId);
        if (!$current) {
            echo json_encode(['success' => false, 'message' => 'Strand not found']);
            return;
        }
        $newStatus = (strtolower($current->strand_track_status) === 'active') ? 'Inactive' : 'Active';
        $updated = $this->Academic_model->toggleStrandTrack($strandId, $newStatus);
        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }
    public function getStrandTrack()
    {
        $id = $this->input->get('strand_track_id');
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'No ID provided']);
            return;
        }
        $strand = $this->Academic_model->getStrandTrackById($id);
        if ($strand) {
            echo json_encode($strand);
        } else {
            echo json_encode(['success' => false, 'message' => 'Strand/Track not found']);
        }
    }
    public function saveStrandTrack()
    {
        // Force JSON header so AJAX knows it's JSON
        $this->output->set_content_type('application/json');
        $data = [
            'strand_track_name'   => $this->input->post('strand_track_name'),
            'strand_track_code'   => $this->input->post('strand_track_code'),
            'description'         => $this->input->post('description'),
        ];
        $id = $this->input->post('strand_track_id');
        if ($id) {
            $updated = $this->Academic_model->updateStrandTrack($id, $data);
            if ($updated) {
                echo json_encode(['status' => 'success', 'message' => 'Strand/Track updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update Strand/Track.']);
            }
        } else {
            $inserted = $this->Academic_model->insertStrandTrack($data);
            if ($inserted) {
                echo json_encode(['status' => 'success', 'message' => 'Strand/Track added successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add Strand/Track.']);
            }
        }
    }
    //section
    public function getSection($sectionId)
    {
        $section = $this->Academic_model->get_section($sectionId);
        if ($section) {
            echo json_encode(['success' => true, 'data' => $section]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Section not found.']);
        }
    }
    public function saveSection()
    {
        $data = [
            'section_id'        => $this->input->post('sec_section_id'),
            'section_name'      => $this->input->post('sec_section_name'),
            'curriculum_id'   => $this->input->post('sec_curriculum_id'),
            'grade_level' => $this->input->post('sec_grade_level'),
            'sy_id'   => $this->input->post('sec_school_year'),
            'max_cap'   => $this->input->post('sec_max_cap')
        ];
        $saved = $this->Academic_model->save_section($data);
        if ($saved) {
            echo json_encode(['success' => true, 'message' => 'Section saved successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save section.']);
        }
    }
    public function getGradeLevels()
    {
        $curriculum_id = $this->input->post('curriculum_id');
        if ($curriculum_id) {
            $levels = $this->Academic_model->getGradeLevelsByCurriculum($curriculum_id);
            echo json_encode($levels);
        }
    }
    public function deleteSection()
    {
        $section_id = $this->input->post('section_id');
        if ($section_id) {
            $deleted = $this->Academic_model->deleteSection($section_id);
            if ($deleted) {
                echo json_encode(['status' => 'success', 'message' => 'Section deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete section.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid section ID.']);
        }
    }
    public function toggleSectionStatus()
    {
        $sectionId = $this->input->post('section_id');
        if (empty($sectionId)) {
            echo json_encode(['success' => false, 'message' => 'Invalid section ID']);
            return;
        }
        $section = $this->Academic_model->get_section($sectionId);
        if (!$section) {
            echo json_encode(['success' => false, 'message' => 'Section not found']);
            return;
        }
        $newStatus = (strtolower($section->section_status) === 'active') ? 'Inactive' : 'Active';
        $updated = $this->Academic_model->updateSectionStatus($sectionId, $newStatus);
        if ($updated) {
            echo json_encode(['success' => true, 'new_status' => $newStatus]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }
    public function getStudentsBySection()
    {
        $section_id = $this->input->post('section_id');
        $students = $this->Academic_model->getStudentsBySection($section_id);
        echo json_encode($students);
    }
    //import student
    public function importStudent()
    {
        $user_id = $this->input->post('user_id');
        $section_id = $this->input->post('section_id');
        // Check if section ID is provided
        if (empty($section_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Section ID is required']);
            return;
        }
        // Check if user has pending request
        $pendingCheck = $this->Academic_model->hasPendingRequest($user_id);
        if ($pendingCheck['status'] === 'error') {
            echo json_encode($pendingCheck);
            return;
        }
        // Check if file is uploaded
        if (!isset($_FILES['import_file']['tmp_name']) || $_FILES['import_file']['error'] != 0) {
            echo json_encode(['status' => 'error', 'message' => 'No file uploaded']);
            return;
        }
        $file_path = $_FILES['import_file']['tmp_name'];
        // Try loading the spreadsheet
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
            $sheet = $spreadsheet->getActiveSheet();
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file format']);
            return;
        }
        $rowIndex = 7;
        $emptySexCount = 0;
        $inserted = 0;
        $skipped = [];
        $req_id = rand(1000, 9999);
        $full = false;
        while (true) {
            $sex = trim($sheet->getCell('G' . $rowIndex)->getValue());
            if (empty($sex)) {
                $emptySexCount++;
                if ($emptySexCount >= 2) break;
                $rowIndex++;
                continue;
            }
            $lrn = trim($sheet->getCell('A' . $rowIndex)->getValue());
            $data = [
                'stud_lrn' => $lrn,
                'stud_name' => trim($sheet->getCell('C' . $rowIndex)->getValue()),
                'stud_sex' => $sex,
                'stud_birth_date' => trim($sheet->getCell('H' . $rowIndex)->getValue()),
                'stud_age' => trim($sheet->getCell('J' . $rowIndex)->getValue()),
                'stud_mother_tongue' => trim($sheet->getCell('L' . $rowIndex)->getValue()),
                'stud_ethnic_group' => trim($sheet->getCell('N' . $rowIndex)->getValue()),
                'stud_religion' => trim($sheet->getCell('O' . $rowIndex)->getValue()),
                'stud_barangay' => trim($sheet->getCell('R' . $rowIndex)->getValue()),
                'stud_municipality_city' => trim($sheet->getCell('U' . $rowIndex)->getValue()),
                'stud_province' => trim($sheet->getCell('W' . $rowIndex)->getValue()),
                'stud_father_name' => trim($sheet->getCell('AB' . $rowIndex)->getValue()),
                'stud_mother_maiden_name' => trim($sheet->getCell('AF' . $rowIndex)->getValue()),
                'stud_guardian_name' => trim($sheet->getCell('AK' . $rowIndex)->getValue()),
                'stud_guardian_relationship' => trim($sheet->getCell('AO' . $rowIndex)->getValue()),
                'stud_contact_number' => trim($sheet->getCell('AP' . $rowIndex)->getValue()),
                'stud_learning_modality' => trim($sheet->getCell('AR' . $rowIndex)->getValue()),
                'stud_remarks' => trim($sheet->getCell('AS' . $rowIndex)->getValue()),
                'section_id' => $section_id,
                'req_id' => $req_id
            ];
            $result = $this->Academic_model->insertStudent($data);
            if ($result === true) {
                $inserted++;
            } elseif ($result === 'full') {
                $full = true;
                break; // Stop inserting - section reached max capacity
            } else {
                $skipped[] = $lrn;
            }
            $rowIndex++;
        }
        // Section info
        $section = $this->Academic_model->get_section($section_id);
        $section_name = ($section) ? $section->section_name : 'Unknown Section';
        // Log request only if there was at least one inserted
        if ($inserted > 0) {
            $reqData = [
                'req_id' => $req_id,
                'req_desc' => "Insertion of $inserted student(s) in $section_name",
                'req_sender_id' => $user_id
            ];
            $this->Academic_model->insertRequest($reqData);
        }
        $statusMsg = "$inserted students imported";
        if (!empty($skipped)) {
            $statusMsg .= ", " . count($skipped) . " skipped (duplicates: " . implode(", ", $skipped) . ")";
        }
        if ($full) {
            $statusMsg .= ". Section reached its maximum capacity. Remaining students were not inserted.";
        }
        echo json_encode(['status' => 'success', 'message' => $statusMsg]);
    }
    //request
    public function fetchRequests()
    {
        $requests = $this->Academic_model->getRequests();
        echo json_encode($requests);
    }
    public function approveRequest()
    {
        $req_id = $this->input->post('req_id');
        $receiver_id = $this->session->userdata('user_id');
        if ($this->Academic_model->approveRequest($req_id, $receiver_id)) {
            // Insert notification for the sender
            $notif_desc = "Your insertion request has been approved.";
            $this->Academic_model->insertNotification($req_id, $notif_desc);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    public function rejectRequest()
    {
        $req_id = $this->input->post('req_id');
        $receiver_id = $this->session->userdata('user_id');
        if ($this->Academic_model->rejectRequest($req_id, $receiver_id)) {
            // Insert notification for the sender
            $notif_desc = "Your insertion request has been rejected.";
            $this->Academic_model->insertNotification($req_id, $notif_desc);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    public function getPendingRequestsCount()
    {
        $count = $this->Academic_model->getPendingRequestsCount();
        echo json_encode(['count' => $count]);
    }
    public function ssaveStudent()
    {
        $stud_id = $this->input->post('stud_id');
        $user_id = $this->input->post('user_id'); // make sure this is passed from JS/session
        $section_id = $this->input->post('section_id');
        $birth_date_input = $this->input->post('stud_birth_date'); // mm/dd/yyyy or mm-dd-yyyy
        $birth_date_formatted = null;
        if (!empty($birth_date_input)) {
            // Normalize: replace '/' with '-' 
            $birth_date_input = str_replace('/', '-', trim($birth_date_input));
            // Try parsing
            $birth_date = DateTime::createFromFormat('m-d-Y', $birth_date_input);
            if ($birth_date) {
                $birth_date_formatted = $birth_date->format('m-d-Y'); // mm-dd-yyyy
            } else {
                // fallback: try strtotime
                $timestamp = strtotime($birth_date_input);
                if ($timestamp) {
                    $birth_date_formatted = date('m-d-Y', $timestamp);
                }
            }
        }
        $student_name = $this->input->post('stud_lname') . ', ' .
            $this->input->post('stud_fname') . ', ' .
            $this->input->post('stud_mname') . ', ' .
            $this->input->post('stud_suffix');
        $data = [
            'stud_lrn' => $this->input->post('stud_lrn'),
            'stud_name' => $student_name,
            'stud_sex' => $this->input->post('stud_sex'),
            'stud_birth_date' => $birth_date_formatted,
            'stud_age' => $this->input->post('stud_age'),
            'stud_mother_tongue' => $this->input->post('stud_mother_tongue'),
            'stud_ethnic_group' => $this->input->post('stud_ethnic_group'),
            'stud_religion' => $this->input->post('stud_religion'),
            'stud_hssp' => $this->input->post('stud_hssp'),
            'stud_barangay' => $this->input->post('stud_barangay'),
            'stud_municipality_city' => $this->input->post('stud_municipality_city'),
            'stud_province' => $this->input->post('stud_province'),
            'stud_father_name' => $this->input->post('stud_father_name'),
            'stud_mother_maiden_name' => $this->input->post('stud_mother_maiden_name'),
            'stud_guardian_name' => $this->input->post('stud_guardian_name'),
            'stud_guardian_relationship' => $this->input->post('stud_guardian_relationship'),
            'stud_contact_number' => $this->input->post('stud_contact_number'),
            'stud_learning_modality' => $this->input->post('stud_learning_modality'),
            'stud_remarks' => $this->input->post('stud_remarks'),
            'section_id' => $section_id
        ];
        if (!empty($stud_id)) {
            // Update existing student (no req_id, no request log)
            $result = $this->Academic_model->updateStudent($stud_id, $data);
            $status = $result ? 'success' : 'error';
            $message = $result ? 'Student updated successfully.' : 'Failed to update student.';
        } else {
            // Insert new student (include req_id and log request)
            $req_id = rand(1000, 9999); // generate random request ID
            $data['req_id'] = $req_id;
            $result = $this->Academic_model->addStudent($data);
            $status = $result ? 'success' : 'error';
            $message = $result ? 'Student added successfully.' : 'Failed to add student.';
            if ($result) {
                $section = $this->Academic_model->get_section($section_id);
                $section_name = $section ? $section->section_name : 'Unknown Section';
                $reqData = [
                    'req_id' => $req_id,
                    'req_desc' => "Insertion of $student_name in $section_name",
                    'req_sender_id' => $user_id
                ];
                $this->Academic_model->insertRequest($reqData);
            }
        }
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
    }
    public function saveStudent()
    {
        $stud_id = $this->input->post('stud_id');
        $user_id = $this->input->post('user_id');
        $section_id = $this->input->post('section_id');
        // 1. Validate Section ID
        if (empty($section_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Section ID is required']);
            return;
        }
        // 2. Validate Pending Request (only for ADD, not UPDATE)
        if (empty($stud_id)) {
            $pendingCheck = $this->Academic_model->hasPendingRequest($user_id);
            if ($pendingCheck['status'] === 'error') {
                echo json_encode($pendingCheck);
                return;
            }
        }
        // 3. Normalize Birthdate (mm-dd-yyyy)
        $birth_date_input = $this->input->post('stud_birth_date');
        $birth_date_formatted = null;
        if (!empty($birth_date_input)) {
            $birth_date_input = str_replace('/', '-', trim($birth_date_input));
            $birth_date = DateTime::createFromFormat('Y-m-d', $birth_date_input) ?: DateTime::createFromFormat('m-d-Y', $birth_date_input);
            if ($birth_date) {
                $birth_date_formatted = $birth_date->format('m-d-Y');
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid birth date format']);
                return;
            }
        }
        // 4. Prepare Student Data
        $student_name = $this->input->post('stud_lname') . ', ' .
            $this->input->post('stud_fname') . ', ' .
            $this->input->post('stud_mname') . ', ' .
            $this->input->post('stud_suffix');
        $data = [
            'stud_lrn' => $this->input->post('stud_lrn'),
            'stud_name' => $student_name,
            'stud_sex' => $this->input->post('stud_sex'),
            'stud_birth_date' => $birth_date_formatted,
            'stud_age' => $this->input->post('stud_age'),
            'stud_mother_tongue' => $this->input->post('stud_mother_tongue'),
            'stud_ethnic_group' => $this->input->post('stud_ethnic_group'),
            'stud_religion' => $this->input->post('stud_religion'),
            'stud_hssp' => $this->input->post('stud_hssp'),
            'stud_barangay' => $this->input->post('stud_barangay'),
            'stud_municipality_city' => $this->input->post('stud_municipality_city'),
            'stud_province' => $this->input->post('stud_province'),
            'stud_father_name' => $this->input->post('stud_father_name'),
            'stud_mother_maiden_name' => $this->input->post('stud_mother_maiden_name'),
            'stud_guardian_name' => $this->input->post('stud_guardian_name'),
            'stud_guardian_relationship' => $this->input->post('stud_guardian_relationship'),
            'stud_contact_number' => $this->input->post('stud_contact_number'),
            'stud_learning_modality' => $this->input->post('stud_learning_modality'),
            'stud_remarks' => $this->input->post('stud_remarks'),
            'section_id' => $section_id
        ];
        if (!empty($stud_id)) {
            // 5. UPDATE student
            $result = $this->Academic_model->updateStudent($stud_id, $data);
            $status = $result ? 'success' : 'error';
            $message = $result ? 'Student updated successfully.' : 'Failed to update student.';
        } else {
            // 6. INSERT student
            $req_id = rand(1000, 9999);
            $data['req_id'] = $req_id;
            $result = $this->Academic_model->insertStudent($data);
            if ($result === true) {
                // Log request
                $section = $this->Academic_model->get_section($section_id);
                $section_name = $section ? $section->section_name : 'Unknown Section';
                $reqData = [
                    'req_id' => $req_id,
                    'req_desc' => "Insertion of $student_name in $section_name",
                    'req_sender_id' => $user_id
                ];
                $this->Academic_model->insertRequest($reqData);
                $status = 'success';
                $message = 'Student added successfully.';
            } elseif ($result === 'full') {
                $status = 'error';
                $message = 'Section has reached maximum capacity.';
            } else {
                $status = 'error';
                $message = 'Student already enrolled.';
            }
        }
        echo json_encode(['status' => $status, 'message' => $message]);
    }
    public function getStudentById()
    {
        $stud_id = $this->input->post('stud_id');
        $student = $this->Academic_model->getStudent($stud_id); // Create this function in model
        echo json_encode($student);
    }
    public function transferStudent()
    {
        $stud_id = $this->input->post('stud_id');
        $new_section_id = $this->input->post('transfer_section');
        // Step 1: Get max capacity of the target section
        $section = $this->Academic_model->get_section($new_section_id);
        if (!$section) {
            echo json_encode(['status' => 'error', 'message' => 'Section not found']);
            return;
        }
        $max_cap = $section->max_cap;
        // Step 2: Get current student count in that section
        $current_count = $this->Academic_model->getStudentCountBySection($new_section_id);
        // Step 3: Check if section is full
        if ($current_count >= $max_cap) {
            echo json_encode(['status' => 'error', 'message' => 'This section is full. No slots available']);
            return;
        }
        // Step 4: Proceed with transfer
        $result = $this->Academic_model->transferStudentSection($stud_id, $new_section_id);
        if ($result === true) {
            echo json_encode(['status' => 'success']);
        } elseif ($result === 'no_change') {
            echo json_encode(['status' => 'info']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Student not found']);
        }
    }
    public function bulkTransferStudents()
    {
        $stud_ids = $this->input->post('stud_ids');
        $new_section_id = $this->input->post('transfer_section');
        if (empty($stud_ids) || !$new_section_id) {
            echo json_encode(['status' => 'error', 'message' => 'Missing student IDs or section ID.']);
            return;
        }
        // 🔹 Step 1: Get section details
        $section = $this->Academic_model->get_section($new_section_id);
        if (!$section) {
            echo json_encode(['status' => 'error', 'message' => 'Section not found.']);
            return;
        }
        $max_cap = $section->max_cap;
        // 🔹 Step 2: Get current student count in section
        $current_count = $this->Academic_model->getStudentCountBySection($new_section_id);
        // 🔹 Step 3: Check if enough slots are available
        $slots_available = $max_cap - $current_count;
        if ($slots_available <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'This section is full. No slots available.']);
            return;
        }
        if (count($stud_ids) > $slots_available) {
            echo json_encode([
                'status' => 'error',
                'message' => "Only $slots_available slots available, but " . count($stud_ids) . " students selected."
            ]);
            return;
        }
        // 🔹 Step 4: Proceed with transfers
        $successCount = 0;
        $noChangeCount = 0;
        $errorCount = 0;
        foreach ($stud_ids as $stud_id) {
            $result = $this->Academic_model->transferStudentSection($stud_id, $new_section_id);
            if ($result === true) {
                $successCount++;
            } elseif ($result === 'no_change') {
                $noChangeCount++;
            } else {
                $errorCount++;
            }
        }
        // 🛑 If no students were actually transferred
        if ($successCount === 0) {
            if ($noChangeCount > 0 && $errorCount === 0) {
                echo json_encode([
                    'status' => 'info',
                    'message' => 'All selected students are already in the target section. No changes made.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => "No students were transferred. $errorCount failed."
                ]);
            }
            return;
        }
        // ✅ Success
        $message = "$successCount transferred, $noChangeCount unchanged, $errorCount failed.";
        echo json_encode(['status' => 'success', 'message' => $message]);
    }
    // Fetch subjects based on curriculum_id
    public function fetchSubjects($curriculum_id)
    {
        $subjects = $this->Academic_model->getSubjectsByCurriculum($curriculum_id);
        echo json_encode($subjects); // return data in JSON
    }
    public function getSubjectsByType()
    {
        $subject_type = $this->input->post('subject_type');
        $level        = $this->input->post('level');
        $subjects = $this->Academic_model->getSubjectsByType($subject_type, $level);
        echo json_encode($subjects);
    }
    public function saveSubject()
    {
        $subject_id = $this->input->post('subject_id');
        $data = [
            'curriculum_id'         => $this->input->post('subject_curriculum_id'),
            'subject_code'          => $this->input->post('subject_code'),
            'subject_name'          => $this->input->post('subject_name'),
            'subject_grade'         => $this->input->post('subject_grade'),
            'subject_learning_area' => $this->input->post('subject_learning_area'),
            'subject_semester'      => $this->input->post('subject_semester'),
            'subject_type'          => $this->input->post('subject_type'),
            'subject_status'        => $this->input->post('subject_status'),
        ];
        if (empty($subject_id)) {
            // ADD NEW SUBJECT
            $this->Academic_model->insertSubject($data);
            $response = ['status' => 'success', 'message' => 'Subject added successfully!'];
        } else {
            // UPDATE SUBJECT
            $this->Academic_model->updateSubject($subject_id, $data);
            $response = ['status' => 'success', 'message' => 'Subject updated successfully!'];
        }
        echo json_encode($response);
    }
    public function getCurriculumGrade()
    {
        $curriculum_id = $this->input->post('curriculum_id');
        $grade_level = $this->Academic_model->getCurriculumGrade($curriculum_id);
        if ($grade_level) {
            echo json_encode([
                'success' => true,
                'grade_level' => $grade_level
            ]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    public function getSubject()
    {
        $subject_id = $this->input->post('subject_id');
        if (!$subject_id) {
            echo json_encode(['success' => false, 'message' => 'No subject ID provided']);
            return;
        }
        $subject = $this->Academic_model->get_subject_by_id($subject_id);
        if ($subject) {
            echo json_encode(['success' => true, 'subject' => $subject]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Subject not found']);
        }
    }
    //school personnel
    public function getPersonnelById($id)
    {
        $person = $this->Academic_model->getPersonnelById($id);
        if ($person) {
            echo json_encode($person);
        } else {
            echo json_encode(['error' => 'Personnel not found']);
        }
    }
    public function savePersonnel()
    {
        $sp_id      = $this->input->post('sp_id'); // hidden input
        $section_id = $this->input->post('sp_advisory'); // advisory section
        $sy_id      = $this->Main_model->getActiveSchoolYearId();
        $data = [
            'sp_no'             => $this->input->post('sp_no'),
            'sp_lname'          => $this->input->post('sp_lname'),
            'sp_fname'          => $this->input->post('sp_fname'),
            'sp_mname'          => $this->input->post('sp_mname'),
            'sp_ename'          => $this->input->post('sp_ename'),
            'sp_sex'            => $this->input->post('sp_sex'),
            'sp_fund_source'    => $this->input->post('sp_fund_source'),
            'sp_birth_date'     => $this->input->post('sp_birth_date'),
            'sp_employment_status' => $this->input->post('sp_employment_status'),
            'sp_educ_degree'    => $this->input->post('sp_educ_degree'),
            'sp_educ_major'     => $this->input->post('sp_educ_major'),
            'sp_educ_minor'     => $this->input->post('sp_educ_minor'),
            'sp_email'          => $this->input->post('sp_email'),
            'sp_post_graduate'  => $this->input->post('sp_post_graduate'),
            'sp_specialization' => $this->input->post('sp_specialization'),
            'sp_position'       => $this->input->post('sp_position'),
            'sp_status'         => $this->input->post('sp_status')
        ];
        // ✅ REQUIRED fields
        $requiredFields = ['sp_no', 'sp_lname', 'sp_fname', 'sp_sex', 'sp_birth_date', 'sp_email'];
        if (empty($sp_id)) {
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    echo json_encode([
                        'success' => false,
                        'message' => "Missing required field: " . $field
                    ]);
                    return;
                }
            }
            // Insert personnel
            $inserted_id = $this->Academic_model->insertPersonnel($data);
            if ($inserted_id) {
                // ✅ Insert advisory if section is assigned
                if (!empty($section_id)) {
                    if ($this->Academic_model->isSectionAssigned1($section_id, $sy_id)) {
                        echo json_encode([
                            'success' => false,
                            'message' => "This section already has an adviser."
                        ]);
                        return;
                    }
                    $this->Academic_model->insertAdvisory($section_id, $sy_id, $inserted_id);
                }
                echo json_encode([
                    'success' => true,
                    'message' => 'Personnel registered successfully.',
                    'sp_id'   => $inserted_id
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to register personnel.'
                ]);
            }
            return;
        }
        // ✅ UPDATE existing personnel
        if (!empty($section_id) && $this->Academic_model->isSectionAssigned1($section_id, $sy_id, $sp_id)) {
            echo json_encode([
                'success' => false,
                'message' => "This section already has an adviser."
            ]);
            return;
        }
        $updated = $this->Academic_model->savePersonnel($sp_id, $data);
        if ($updated && !empty($section_id)) {
            $advisory = $this->Academic_model->getAdvisoryByPersonnel($sp_id, $sy_id);
            if ($advisory) {
                $this->Academic_model->updateAdvisory($advisory->ac_id, $section_id);
            } else {
                $this->Academic_model->insertAdvisory($section_id, $sy_id, $sp_id);
            }
        }
        echo json_encode([
            'success' => $updated,
            'message' => $updated ? 'Personnel updated successfully.' : 'Failed to update personnel.'
        ]);
    }
    public function saveAncillaryAssignments()
    {
        $sp_id = $this->input->post('sp_id');
        $aa_ids = $this->input->post('aa_ids'); // expects array
        if (!$sp_id || empty($aa_ids)) {
            echo json_encode(['success' => false, 'message' => 'Missing personnel or assignments.']);
            return;
        }
        $this->load->model('Academic_model');
        $insertedAalId = $this->Academic_model->saveAncillaryAssignments($sp_id, $aa_ids);
        echo json_encode([
            'success' => true,
            'aal_id' => $insertedAalId // return the last inserted or existing aal_id
        ]);
    }
    public function getAssignedAncillary($sp_id)
    {
        $this->load->model('Academic_model');
        $assigned = $this->Academic_model->getAssignedAncillary($sp_id);
        echo json_encode(['success' => true, 'assigned' => $assigned]);
    }
    public function removeAncillaryAssignment()
    {
        $aal_id = $this->input->post('aal_id'); // now use aal_id
        if (!$aal_id) {
            echo json_encode(['success' => false, 'message' => 'Missing assignment ID.']);
            return;
        }
        $this->load->model('Academic_model');
        $removed = $this->Academic_model->removeAncillaryAssignmentById($aal_id);
        echo json_encode(['success' => $removed]);
    }
    public function getTeachingLoads()
    {
        $personnel_id = $this->input->post('sp_id');
        if (!$personnel_id) {
            echo json_encode([]);
            return;
        }
        $teachingLoads = $this->Academic_model->fetchTeachingLoads($personnel_id); // ✅ use different function name
        echo json_encode($teachingLoads);
    }
    public function saveTeachingLoad()
    {
        $active_sy    = $this->Main_model->getActiveSchoolYearId();
        $tl_id        = $this->input->post('tl_id');
        $sp_id        = $this->input->post('sp_id');
        $subject_id   = $this->input->post('subject_id');
        $tl_grade_lvl = $this->input->post('tl_grade_level');
        $tl_start     = $this->input->post('tl_start');
        $tl_end       = $this->input->post('tl_end');
        $days = [
            'tl_mon' => $this->input->post('tl_mon'),
            'tl_tue' => $this->input->post('tl_tue'),
            'tl_wed' => $this->input->post('tl_wed'),
            'tl_thu' => $this->input->post('tl_thu'),
            'tl_fri' => $this->input->post('tl_fri'),
            'tl_sat' => $this->input->post('tl_sat'),
            'tl_sun' => $this->input->post('tl_sun'),
        ];
        // Call model to handle saving
        $response = $this->Academic_model->saveTeachingLoad(
            $active_sy,
            $tl_id,
            $sp_id,
            $subject_id,
            $tl_grade_lvl,
            $tl_start,
            $tl_end,
            $days
        );
        echo json_encode($response);
        exit;
    }
    public function deleteTeachingLoad()
    {
        $tl_id = $this->input->post('tl_id');
        if (!$tl_id) {
            echo json_encode(['status' => 'error', 'message' => 'Teaching load ID is required']);
            return;
        }
        $result = $this->Academic_model->deleteTeachingLoad($tl_id);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Teaching load deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete teaching load']);
        }
    }
    public function getPlantillaList()
    {
        $data = $this->Academic_model->getAllPlantillaPositions();
        echo json_encode($data);
    }
    public function savePlantillaOrder()
    {
        $order = $this->input->post('order'); // expects array of pp_id
        if ($order && is_array($order)) {
            foreach ($order as $rank => $pp_id) {
                $this->Academic_model->updatePlantillaRank($pp_id, $rank + 1);
            }
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    public function savePlantilla()
    {
        $pp_id = $this->input->post('pp_pp_id');
        $data = [
            'pp_desc' => $this->input->post('pp_pp_desc'),
            'pp_rank' => $this->input->post('pp_pp_rank'),
            'pp_code' => $this->input->post('pp_pp_code'),
            'pp_category' => $this->input->post('pp_pp_category')
        ];
        if ($pp_id) {
            // Update existing
            $res = $this->Academic_model->updatePlantilla($pp_id, $data);
        } else {
            // Insert new
            $res = $this->Academic_model->insertPlantilla($data);
        }
        if ($res) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }
    public function deletePlantilla()
    {
        $pp_id = $this->input->post('pp_id');
        if (!$pp_id) {
            echo json_encode(['success' => false, 'message' => 'Plantilla ID is required']);
            return;
        }
        $this->load->model('Academic_model');
        $deleted = $this->Academic_model->deletePlantillaById($pp_id);
        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete plantilla']);
        }
    }
    public function getAllAncillary()
    {
        $ancillary = $this->Academic_model->getAllAncillary();
        echo json_encode($ancillary);
    }
    public function saveAncillary()
    {
        $this->Academic_model->saveAncillary();
    }
    public function deleteAncillary()
    {
        $this->Academic_model->deleteAncillary();
    }
    public function fetchTeachingLoads()
    {
        $data = $this->Academic_model->getTeachingLoadsByActiveSY();
        echo json_encode($data);
    }
    public function fetchAncillaryAssignments()
    {
        $data = $this->Academic_model->getAncillaryAssignmentsByActiveSY();
        echo json_encode($data);
    }
    public function inheritData()
    {
        $sy_id   = $this->input->post('sy_id');
        $sp_ids  = $this->input->post('sp_ids');
        $aa_ids  = $this->input->post('aa_ids');
        if (empty($sy_id) || empty($sp_ids) || empty($aa_ids)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
            return;
        }
        $result = $this->Academic_model->insertInheritedAncillary($sy_id, $sp_ids, $aa_ids);
        if ($result['inserted'] > 0 || $result['skipped'] > 0) {
            echo json_encode([
                'status'   => 'success',
                'inserted' => $result['inserted'],
                'skipped'  => $result['skipped']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data was inherited.']);
        }
    }
    public function inheritDataTl()
    {
        $sy_id  = $this->input->post('sy_id');
        $sp_ids = $this->input->post('sp_ids');
        if (empty($sy_id) || empty($sp_ids)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
            return;
        }
        $result = $this->Academic_model->insertInheritedTeachingLoad($sy_id, $sp_ids);
        if ($result['inserted'] > 0 || $result['skipped'] > 0) {
            echo json_encode([
                'status'   => 'success',
                'inserted' => $result['inserted'],
                'skipped'  => $result['skipped']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data was inherited.']);
        }
    }
    public function getEvents()
    {
        $active_sy = $this->Main_model->getActiveSchoolYearId();
        $this->db->select('tl.*, s.subject_code, s.subject_name, sp.sp_fname, sp.sp_lname');
        $this->db->from('teaching_loads_tbl tl');
        $this->db->join('subjects_tbl s', 'tl.subject_id = s.subject_id', 'left');
        $this->db->join('school_personnel_tbl sp', 'tl.sp_id = sp.sp_id', 'left');
        $this->db->where('tl.sy_id', $active_sy);
        $query = $this->db->get();
        $loads = $query->result();
        $events = [];
        foreach ($loads as $row) {
            $days = [
                'Monday'    => $row->tl_mon,
                'Tuesday'   => $row->tl_tue,
                'Wednesday' => $row->tl_wed,
                'Thursday'  => $row->tl_thu,
                'Friday'    => $row->tl_fri,
                'Saturday'  => $row->tl_sat,
                'Sunday'    => $row->tl_sun,
            ];
            foreach ($days as $dayName => $isActive) {
                if ($isActive) {
                    $events[] = [
                        'title'      => $row->subject_code . " - " . $row->subject_name,
                        'daysOfWeek' => [$this->convertDayToNumber($dayName)], // ✅ works now
                        'startTime'  => $row->tl_start,
                        'endTime'    => $row->tl_end,
                        'extendedProps' => [
                            'professor' => $row->sp_fname . " " . $row->sp_lname
                        ]
                    ];
                }
            }
        }
        echo json_encode($events);
    }
    private function convertDayToNumber($day)
    {
        $map = [
            'Sunday'    => 0,
            'Monday'    => 1,
            'Tuesday'   => 2,
            'Wednesday' => 3,
            'Thursday'  => 4,
            'Friday'    => 5,
            'Saturday'  => 6,
        ];
        return $map[$day];
    }
}
