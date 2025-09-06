<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_model');
        $this->load->model('Main_model');
        $this->load->model('Tracer_model');
        $this->load->model('Academic_model');
        if (!$this->session->userdata('access_level') || !$this->session->userdata('Identifier')) {
            redirect('auth/logout');
            exit;
        }
    }
    public function index()
    {
        $data['all_sections'] = $this->Academic_model->getAllSections();
        $data['academic_years'] = $this->Main_model->getAllAcademicYears();
        $data['all_strands'] = $this->Academic_model->getAllStrandTracks();
        $data['all_curriculums'] = $this->Academic_model->getAllCurriculums();
        $data['all_active_curriculums'] = $this->Academic_model->getAllActiveCurriculums();
        $data['active_sy'] = $this->Main_model->getActiveSchoolYear();
        $this->load->view('main_view', $data);  // Pass $data here!
    }
    public function loadDashboard()
    {
        $this->load->view('content/main/dashboard');
    }
    public function loadASetup()
    {
        $data['academic_years'] = $this->Main_model->getAllAcademicYears();
        $data['all_curriculums'] = $this->Academic_model->getAllCurriculums();
        $data['all_strands'] = $this->Academic_model->getAllStrandTracks();
        $this->load->view('content/main/academics/setup', $data);
    }
    // Load tracer view
    public function loadTracer()
    {
        $active_sy = $this->Main_model->getActiveSchoolYear();
        $all_categories = $this->Tracer_model->getAllCategoriesWithQuestionCount();
        $categories = array_filter($all_categories, function ($category) use ($active_sy) {
            return (is_object($category) && $category->academic_year === $active_sy) ||
                (is_array($category) && $category['academic_year'] === $active_sy);
        });
        $data['categories'] = $categories;
        $data['active_sy'] = $active_sy;
        $data['academic_years'] = $this->Main_model->getAllAcademicYears();
        $this->load->view('content/main/student/tracer', $data);
    }
    public function loadAnalytics()
    {
        $this->load->view('content/main/student/analytics');
    }
    public function loadProfile()
    {
        $this->load->view('content/profile/profile');
    }
    public function loadASection()
    {
        $data['all_sections'] = $this->Academic_model->getAllSections();
        $this->load->view('content/main/academics/section', $data);
    }
    public function loadASubject()
    {
        $data['jhs_subject_types'] = $this->Academic_model->getAllSubjectTypeJHS();
        $data['shs_subject_types'] = $this->Academic_model->getAllSubjectTypeSHS();
        $data['all_curriculums'] = $this->Academic_model->getAllActiveCurriculums();
        $this->load->view('content/main/academics/subject', $data);
    }
    public function loadRAttendance()
    {
        $this->load->view('content/main/record/attendance');
    }
    public function loadASchoolPersonnel()
    {
        $data['active_sy'] = $this->Main_model->getActiveSchoolYear();
        $data['academic_years'] = $this->Main_model->getAllAcademicYearsWithoutActive();
        $data['all_advisory'] = $this->Academic_model->getAllAdvisory();
        $data['all_subjects'] = $this->Academic_model->getAllSubjects();
        $data['all_personnel'] = $this->Academic_model->getAllPersonnel();
        $data['all_plantilla'] = $this->Academic_model->getAllPlantillaPositions();
        $data['all_ancillary'] = $this->Academic_model->getAllAncillary();
        $this->load->view('content/main/academics/school_personnel', $data);
    }
    public function fetchNotifications()
    {
        $userId = $this->session->userdata('user_id');
        $notifications = $this->Main_model->getNotificationsWithUser($userId);
        $unreadCount = 0;
        foreach ($notifications as &$notif) {
            $notif['full_name'] = trim($notif['UserFName'] . ' ' . ($notif['UserMName'] ? $notif['UserMName'] . ' ' : '') . $notif['UserLName']);
            if ($notif['notif_read'] == 0) $unreadCount++;
        }
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
    public function markAllNotificationsRead()
    {
        $userId = $this->session->userdata('user_id');
        // Pass the user ID to Main_model to update notifications
        $result = $this->Main_model->markAllNotificationsRead($userId);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }
}
