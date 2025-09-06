<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tracer_model extends CI_Model
{
	const TABLE_QUEST_CAT = 'quest_cat_tbl';
	const TABLE_QUEST = 'quest_tbl';
	const TABLE_QUEST_RESP = 'quest_resp_tbl';
	const TABLE_QUEST_CHOICE = 'quest_choice_tbl';

	public function __construct()
	{
		parent::__construct();
	}

	// Get all categories of tracer questions with question count
	public function getAllCategoriesWithQuestionCount(): array
	{
		$this->db->select('
            qc.qc_id, 
            qc.category_name, 
            qc.academic_year, 
            qc.status, 
            qc.created_at, 
            COUNT(DISTINCT q.quest_id) as question_count,
            COUNT(DISTINCT r.user_id) as response_count
        ');
		$this->db->from(self::TABLE_QUEST_CAT . ' qc');
		$this->db->join(self::TABLE_QUEST . ' q', 'q.qc_id = qc.qc_id', 'left');
		$this->db->join(self::TABLE_QUEST_RESP . ' r', 'r.quest_id = q.quest_id', 'left');
		$this->db->group_by('qc.qc_id');
		$this->db->order_by('qc.status ASC');
		return $this->db->get()->result_array();
	}

	// Get questions by category
	public function getQuestionsByCategory(string $categoryName, string $academicYear): array
	{
		$qcId = $this->getQcId($categoryName, $academicYear);
		if (!$qcId) {
			return [];
		}

		$this->db->select('quest_id, question');
		$this->db->from(self::TABLE_QUEST);
		$this->db->where('qc_id', $qcId);
		$questions = $this->db->get()->result_array();

		foreach ($questions as &$q) {
			$q['choices'] = $this->getChoicesByQuestionId($q['quest_id']);
		}

		return $questions;
	}

	// Get questions and responses by category
	public function getQuestionsAndResponsesByCategory(string $categoryName, string $academicYear): array
	{
		$qcId = $this->getQcId($categoryName, $academicYear);
		if (!$qcId) {
			return [];
		}

		$results = $this->db->select('
                q.quest_id, 
                q.question, 
                c.qchoice_id, 
                c.choice_name, 
                COUNT(r.qr_id) AS resp_count
            ')
			->from(self::TABLE_QUEST . ' q')
			->join(self::TABLE_QUEST_CHOICE . ' c', 'c.quest_id = q.quest_id', 'left')
			->join(self::TABLE_QUEST_RESP . ' r', 'r.qchoice_id = c.qchoice_id', 'left')
			->where('q.qc_id', $qcId)
			->group_by('q.quest_id, c.qchoice_id')
			->order_by('q.quest_id', 'ASC')
			->get()
			->result_array();

		return $this->groupQuestionsWithResponses($results);
	}

	// Update category info
	public function updateCategory(int $qcId, string $categoryName, string $academicYear): bool
	{
		return $this->db->where('qc_id', $qcId)
			->update(self::TABLE_QUEST_CAT, [
				'category_name' => $categoryName,
				'academic_year' => $academicYear
			]);
	}
	// Delete question
	public function deleteQuestion(int $questId): bool
	{
		return $this->db->where('quest_id', $questId)
			->delete(self::TABLE_QUEST);
	}

	// Delete category by ID
	public function deleteCategoryById(int $qcId): bool
	{
		return $this->db->delete(self::TABLE_QUEST_CAT, ['qc_id' => $qcId]);
	}

	// Save the category
	public function saveCategory(array $data): bool
	{
		return $this->db->insert(self::TABLE_QUEST_CAT, $data);
	}

	// Save question
	public function insertQuestion(): void
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

		if ($this->db->insert(self::TABLE_QUEST, $data)) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Database insert failed']);
		}
	}

	public function updateQuestionWithChoices($questId, $question, $choices)
	{
		$this->db->trans_start();

		// Update question
		$this->db->where('quest_id', $questId)
			->update(self::TABLE_QUEST, ['question' => $question]);

		// Delete old choices
		$this->db->delete(self::TABLE_QUEST_CHOICE, ['quest_id' => $questId]);

		// Insert new choices if any
		if (!empty($choices)) {
			$choiceData = [];
			foreach ($choices as $choice) {
				$choiceData[] = [
					'quest_id'    => $questId,
					'choice_name' => $choice
				];
			}
			$this->db->insert_batch(self::TABLE_QUEST_CHOICE, $choiceData);
		}

		$this->db->trans_complete();

		// Return true/false for controller to handle
		return $this->db->trans_status();
	}


	// Helper method to get qc_id
	private function getQcId(string $categoryName, string $academicYear): ?int
	{
		$qc = $this->db->select('qc_id')
			->from(self::TABLE_QUEST_CAT)
			->where('category_name', $categoryName)
			->where('academic_year', $academicYear)
			->get()
			->row();

		return $qc ? $qc->qc_id : null;
	}

	// Helper method to get choices by question ID
	private function getChoicesByQuestionId(int $questId): array
	{
		$this->db->select('choice_name');
		$this->db->from(self::TABLE_QUEST_CHOICE);
		$this->db->where('quest_id', $questId);
		$choices = $this->db->get()->result_array();

		return array_column($choices, 'choice_name'); // Flatten to array of strings
	}

	// Helper method to group questions with responses
	private function groupQuestionsWithResponses(array $results): array
	{
		$questions = [];
		foreach ($results as $row) {
			if (!isset($questions[$row['quest_id']])) {
				$questions[$row['quest_id']] = [
					'quest_id' => $row['quest_id'],
					'question' => $row['question'],
					'total_responses' => 0,
					'choices' => []
				];
			}

			if (!empty($row['choice_name'])) {
				$questions[$row['quest_id']]['choices'][] = [
					'qchoice_id' => $row['qchoice_id'],
					'choice_name' => $row['choice_name'],
					'resp_count' => (int) $row['resp_count']
				];

				$questions[$row['quest_id']]['total_responses'] += (int) $row['resp_count'];
			}
		}

		return array_values($questions);
	}
}
