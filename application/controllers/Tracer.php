<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tracer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_model');
        $this->load->model('Tracer_model');
    }
    // Get questions in edit button
    public function fetchQuestionsByCategory()
    {
        $categoryName = $this->input->post('category_name');
        $academicYear = $this->input->post('academic_year');
        $questions = $this->Tracer_model->getQuestionsByCategory($categoryName, $academicYear);
        echo json_encode($questions);
    }
    // Get questions with responses in view button
    public function fetchQuestionsAndResponsesByCategory()
    {
        $categoryName = $this->input->post('category_name');
        $academicYear = $this->input->post('academic_year');
        $questions = $this->Tracer_model->getQuestionsAndResponsesByCategory($categoryName, $academicYear);
        echo json_encode($questions);
    }
    // Update the category
    public function updateQuestCategory()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $qcId = $this->input->post('qc_id');
        $categoryName = $this->input->post('category_name');
        $academicYear = $this->input->post('academic_year');
        if (!$qcId || !$categoryName || !$academicYear) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Please fill out all fields.'
            ]);
            return;
        }
        $updated = $this->Tracer_model->updateCategory($qcId, $categoryName, $academicYear);
        if ($updated) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Category updated successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Update failed. Please try again.'
            ]);
        }
    }
    // Delete question with choices
    public function deleteQuestion()
    {
        $questId = $this->input->post('quest_id');
        $deleted = $this->Tracer_model->deleteQuestion($questId);
        if ($deleted) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Question deleted successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Deletion failed. Please try again.'
            ]);
        }
    }
    // Get question and choices for edit
    public function fetchQuestionWithChoices()
    {
        $questId = $this->input->post('quest_id');
        $question = $this->db->get_where('quest_tbl', ['quest_id' => $questId])->row();
        $choices = $this->db->get_where('quest_choice_tbl', ['quest_id' => $questId])->result();
        $choiceValues = array_map(function ($c) {
            return $c->choice_name;
        }, $choices);
        echo json_encode([
            'quest_id' => $question->quest_id,
            'question' => $question->question,
            'choices' => $choiceValues
        ]);
    }
    public function updateQuestionAndChoices()
    {
        $questId  = $this->input->post('quest_id');
        $question = $this->input->post('question');
        $choices  = $this->input->post('choices');
        $result = $this->Tracer_model->updateQuestionWithChoices($questId, $question, $choices);
        // Always return consistent format
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Question and choices updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update question and choices.']);
        }
    }
    // Insert question
    public function insertQuestion()
    {
        $qcId = $this->input->post('qc_id');
        $question = $this->input->post('question');
        if (empty($qcId) || empty($question)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing data']);
            return;
        }
        $data = [
            'qc_id' => $qcId,
            'question' => $question
        ];
        if ($this->db->insert('quest_tbl', $data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database insert failed']);
        }
    }
    // Delete category
    public function deleteCategory()
    {
        $qcId = $this->input->post('qc_id');
        if (!$qcId) {
            show_error('Invalid request', 400);
            return;
        }
        $deleted = $this->Tracer_model->deleteCategoryById($qcId);
        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    // Save category
    public function saveCategory()
    {
        $categoryName = $this->input->post('category_name');
        $academicYear = $this->input->post('academic_year_id');
        $data = [
            'category_name' => $categoryName,
            'academic_year' => $academicYear,
            'status' => 'Available',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $inserted = $this->Tracer_model->saveCategory($data);
        if ($inserted) {
            echo json_encode([
                'success' => true,
                'message' => 'Category saved successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save category.'
            ]);
        }
    }
}
