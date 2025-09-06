<div class="modal fade" id="editQuestCatModal" tabindex="-1" aria-labelledby="editQuestCatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9  m-0" id="editQuestCatModalLabel">
          Edit Category / <span id="editQuestCatModalName"></span>
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>


      <!-- Form -->
      <form id="editQuestCatForm" action="<?= base_url('tracer/updateQuestCategory') ?>" method="post">

        <!-- Scrollable body -->
        <div class="modal-body py-3 px-3" style="max-height: 400px; overflow-y: auto;">
          <div id="editQuestCatModalContent"><!-- Injected via JS --></div>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <!-- Left side -->
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>

          <!-- Right side -->
          <div>
            <button type="button" class="btn btn-success btn-sm me-2 btn-add-question">
              <i class="fas fa-plus"></i> Add Question
            </button>
            <button type="submit" class="btn btn-primary btn-sm">Update Category</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="viewQuestCatModal" tabindex="-1" aria-labelledby="viewQuestCatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="viewQuestCatModalLabel">
          View Tracer Information & Results / <span id="modalCategoryName"></span>
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body py-3 px-3" style="max-height: 400px; overflow-y: auto;">
        <label class="form-label text-sm">Tracer Information & Results</label>
        <ul class="list-group" id="questionViewList"></ul>
      </div>

      <!-- Footer -->
      <div class="modal-footer d-flex justify-content-between py-2 px-3">
        <button type="button" class="btn btn-info btn-sm" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="editQuestionModalLabel">
          Edit Question / <span id="modalEditQuestionName"></span>
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="editQuestionForm" method="post" action="<?= base_url('tracer/updateQuestionAndChoices') ?>">
        <div class="modal-body py-3 px-3" style="max-height: 400px; overflow-y: auto;">
          <input type="hidden" name="quest_id" id="editQuestId">

          <!-- Question input -->
          <div class="mb-3">
            <label for="editQuestionText" class="form-label text-sm fw-semibold">Question</label>
            <textarea class="form-control form-control-sm" name="question" id="editQuestionText" rows="2" required></textarea>
          </div>

          <!-- Hidden Add Choice Row -->
          <div class="row g-2 align-items-center" id="addChoiceRow" style="display:none;">
            <div class="col-md-10">
              <input type="text" class="form-control form-control-sm" id="newChoiceInput" placeholder="Enter new choice">
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-primary btn-sm w-100 btn-save-choice">
                <i class="fas fa-save"></i>
              </button>
            </div>
          </div>

          <!-- Existing choices -->
          <div id="editChoicesWrapper" class="mt-3"></div>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-success btn-sm" id="btnAddChoice">
              <i class="fas fa-plus"></i> Add Choice
            </button>
            <button type="submit" class="btn btn-warning btn-sm">Update Question</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
<div class="modal fade" id="addQuestCatModal" tabindex="-1" aria-labelledby="addQuestCatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="addQuestCatModalLabel">
          Add Category
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="addQuestCatForm" action="<?= base_url('tracer/updateQuestCategory') ?>" method="post">
        <div class="modal-body py-3 px-3" style="max-height: 400px; overflow-y: auto;">
          <div class="row g-3 align-items-center">
            <div class="col-md-6">
              <label for="addCategoryName" class="form-label text-sm">Category Name</label>
              <input type="text" class="form-control form-control-sm" id="addCategoryName" name="category_name" required>
            </div>
            <div class="col-md-6">
              <label for="addAcademicYear" class="form-label text-sm">Academic Year</label>
              <select id="academicYear" name="academic_year" class="form-control form-control-sm select2" required>
                <option value="" disabled selected>Select Academic Year</option>
                <?php foreach ($all_years as $year): ?>
                  <option value="<?= htmlspecialchars($year['sy_id']); ?>">
                    <?= htmlspecialchars($year['sy_term']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm">Add Category</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- Curriculum Modal -->
<div class="modal fade" id="editCurriculumModal" tabindex="-1" aria-labelledby="curriculumModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="curriculumModalLabel">
          Add / Edit Curriculum
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="editCurriculumForm" action="<?= base_url('academic/saveCurriculum') ?>" method="post">
        <input type="hidden" name="curriculum_id" id="curriculum_id">

        <div class="modal-body py-3 px-3" style="max-height: 400px; overflow-y: auto;">
          <div class="row g-3">

            <div class="col-md-4">
              <label class="form-label text-sm">Curriculum Code</label>
              <input type="text" class="form-control form-control-sm" name="curriculum_code" id="curriculum_code" required>
            </div>

            <div class="col-md-4">
              <label class="form-label text-sm">Curriculum Name</label>
              <input type="text" class="form-control form-control-sm" name="curriculum_name" id="curriculum_name" required>
            </div>

            <div class="col-md-4">
              <label class="form-label text-sm">Curriculum Type</label>
              <input type="text" class="form-control form-control-sm" name="curriculum_type" id="curriculum_type" required>
            </div>
            <div class="col-md-6">
              <label class="form-label text-sm">Strand/Track</label>
              <select class="form-select form-select-sm" name="ec_strand_track_id" id="ec_strand_track_id">
                <option value="">-- Select strand_track --</option>
                <?php foreach ($all_strands as $strands): ?>
                  <option value="<?= $strands['strand_track_id'] ?>"><?= $strands['strand_track_code'] ?> - <?= $strands['strand_track_status'] ?></option>
                <?php endforeach; ?>

              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label text-sm">Grade Level</label>
              <select class="form-select form-select-sm" name="ec_grade_level" id="ec_grade_level" required>
                <option value="">-- Select Grade Level --</option>
                <option value="0-3">Kindergarden - Grade 3</option>
                <option value="4-6">Grades 4–6 (Elementary)</option>
                <option value="7-10">Grades 7–10 (Junior High School)</option>
                <option value="11-12">Grades 11–12 (Senior High School)</option>

              </select>
            </div>

            <div class="col-md-12">
              <label class="form-label text-sm">Curriculum Description</label>
              <textarea class="form-control form-control-sm" name="curriculum_desc" id="curriculum_desc" rows="2"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label text-sm">DepEd Learning Area Code</label>
              <input type="text" class="form-control form-control-sm" name="deped_learning_area_code" id="deped_learning_area_code">
            </div>

            <div class="col-md-6">
              <label class="form-label text-sm">Competency Code</label>
              <input type="text" class="form-control form-control-sm" name="competency_code" id="competency_code">
            </div>

            <div class="col-md-12">
              <label class="form-label text-sm">Competency Description</label>
              <textarea class="form-control form-control-sm" name="competency_desc" id="competency_desc" rows="2"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label text-sm">School Year Start</label>
              <select class="form-select form-select-sm" name="school_year_start" id="school_year_start" required>
                <option value="">-- Select Start Year --</option>
                <?php foreach ($academic_years as $year):
                  $parts = explode('-', $year['sy_term']); // ["2024","2025"]
                ?>
                  <option value="<?= htmlspecialchars($parts[0]) ?>">
                    <?= htmlspecialchars($parts[0]) ?> <!-- show and save start year only -->
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label text-sm">School Year End</label>
              <select class="form-select form-select-sm" name="school_year_end" id="school_year_end" required>
                <option value="">-- Select End Year --</option>
                <?php foreach ($academic_years as $year):
                  $parts = explode('-', $year['sy_term']); // ["2024","2025"]
                ?>
                  <option value="<?= htmlspecialchars($parts[1]) ?>">
                    <?= htmlspecialchars($parts[1]) ?> <!-- show and save end year only -->
                  </option>
                <?php endforeach; ?>
              </select>
            </div>



          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm">Save Curriculum</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- Edit Strand/Track Modal -->
<div class="modal fade" id="editStrandModal" tabindex="-1" aria-labelledby="editStrandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="editStrandModalLabel">
          Add / Edit Strand/Track
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="editStrandForm" action="<?= base_url('academic/saveStrandTrack') ?>" method="post">
        <input type="hidden" name="strand_track_id" id="strand_track_id">

        <div class="modal-body py-3 px-3" style="max-height: 400px; overflow-y: auto;">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label text-sm">Strand/Track Name</label>
              <input type="text" class="form-control form-control-sm" name="strand_track_name" id="strand_track_name" required>
            </div>

            <div class="col-md-6">
              <label class="form-label text-sm">Strand/Track Code</label>
              <input type="text" class="form-control form-control-sm" name="strand_track_code" id="strand_track_code" required>
            </div>
            <div class="col-md-12">
              <label class="form-label text-sm">Description</label>
              <textarea class="form-control form-control-sm" name="description" id="description" rows="2"></textarea>
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm">Save Strand/Track</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Section Modal -->
<div class="modal fade" id="editSectionModal" tabindex="-1" aria-labelledby="sectionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="sectionModalLabel">
          Add / Edit Section
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="editSectionForm" action="<?= base_url('academic/saveSection') ?>" method="post">
        <input type="hidden" name="sec_section_id" id="sec_section_id">

        <div class="modal-body py-3 px-3" style="max-height: 400px; overflow-y: auto;">
          <div class="row g-3">

            <!-- Section Name -->
            <div class="col-md-6">
              <label class="form-label text-sm">Section Name</label>
              <input type="text" class="form-control form-control-sm" name="sec_section_name" id="sec_section_name" required>
            </div>
            <!-- Strand / Track -->
            <div class="col-md-6">
              <label class="form-label text-sm">Curriculum</label>
              <select class="form-select form-select-sm" name="sec_curriculum_id" id="sec_curriculum_id">
                <option value="">-- Select Curriculum --</option>
                <?php foreach ($all_curriculums as $curriculum): ?>
                  <option
                    value="<?= $curriculum['curriculum_id'] ?>"
                    <?= strtolower($curriculum['curriculum_status']) === 'inactive' ? 'disabled' : ''; ?>>
                    <?= htmlspecialchars($curriculum['curriculum_name']) ?>
                    <?= strtolower($curriculum['curriculum_status']) === 'inactive' ? '(Inactive)' : ''; ?>
                  </option>
                <?php endforeach; ?>
              </select>

            </div>

            <div class="col-md-4">
              <label class="form-label text-sm">Grade Level</label>
              <select class="form-select form-select-sm" name="sec_grade_level" id="sec_grade_level" required>
                <option value="">-- Select Grade Level --</option>

              </select>
            </div>
            <!-- School Year Start -->
            <div class="col-md-4">
              <label class="form-label text-sm">School Year</label>
              <select class="form-select form-select-sm" name="sec_school_year" id="sec_school_year" required>
                <option value="">-- Select School Year--</option>
                <?php foreach ($academic_years as $year): ?>
                  <option value="<?= htmlspecialchars($year['sy_id']) ?>"><?= htmlspecialchars($year['sy_term']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label text-sm">Max Capacity</label>
              <select class="form-select form-select-sm" name="sec_max_cap" id="sec_max_cap" required>
                <option value="">-- Select Grade Level --</option>
                <option value="25">25</option>
                <option value="35">35</option>
                <option value="45">45</option>
                <option value="55">55</option>
              </select>
            </div>



          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm">Save Section</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Import Student Modal -->
<div class="modal fade" id="importStudentModal" tabindex="-1" aria-labelledby="importStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="importStudentModalLabel">
          Import Sections
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="importSectionForm" action="<?= base_url('academic/importStudent') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body d-flex justify-content-center align-items-center" style="min-height: 300px;">

          <!-- Upload Box -->
          <label for="import_file" id="uploadLabel" class="d-flex flex-column justify-content-center align-items-center border border-2 border-dashed rounded-3 p-5 w-100 text-center" style="cursor:pointer;">
            <i class="uil uil-plus-circle display-4 mb-2 text-primary"></i>
            <p class="mb-1 fw-semibold">Click to upload or drag & drop</p>
            <small class="text-muted">Allowed formats: CSV, XLSX</small>
          </label>
          <input type="file" class="d-none" name="import_file" id="import_file" accept=".csv, .xlsx, .xls" required>

        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Import Request</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Requests Modal -->
<div class="modal fade" id="requestsModal" tabindex="-1" aria-labelledby="requestsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3 p-2 d-flex justify-content-between align-items-center">
        <h6 class="modal-title fs-9 m-0" id="requestsModalLabel">Requests</h6>
        <button class="btn btn-link p-0 fs-9 fw-normal" type="button"></button>
      </div>

      <!-- Body -->
      <div class="modal-body" id="requestsContainer" style="min-height: 300px; max-height: 400px; overflow-y: auto;">
        <div class="text-center text-muted">Loading requests...</div>
      </div>

      <!-- Footer -->
      <div class="modal-footer d-flex justify-content-end py-2 px-3">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="studentModalLabel">
          Add / Edit Student
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="editStudentForm" action="<?= base_url('academic/saveStudent') ?>" method="post">
        <input type="hidden" name="stud_id" id="stud_id">
        <input type="hidden" name="section_id" id="section_id">

        <div class="modal-body py-3 px-3" style="max-height: 500px; overflow-y: auto;">
          <div class="row g-3">

            <!-- LRN -->
            <div class="col-md-2">
              <label class="form-label text-sm">LRN</label>
              <input type="text" class="form-control form-control-sm" name="stud_lrn" id="stud_lrn" required>
            </div>
            <!-- Name Fields -->
            <div class="col-md-3">
              <label class="form-label text-sm">Last Name</label>
              <input type="text" class="form-control form-control-sm text-uppercase" name="stud_lname" id="stud_lname" required>
            </div>

            <div class="col-md-3">
              <label class="form-label text-sm">First Name</label>
              <input type="text" class="form-control form-control-sm text-uppercase" name="stud_fname" id="stud_fname" required>
            </div>

            <div class="col-md-2">
              <label class="form-label text-sm">Middle Name</label>
              <input type="text" class="form-control form-control-sm text-uppercase" name="stud_mname" id="stud_mname">
            </div>

            <div class="col-md-2">
              <label class="form-label text-sm">Suffix</label>
              <input type="text" class="form-control form-control-sm text-uppercase" name="stud_suffix" id="stud_suffix">
            </div>
            <!-- Sex -->
            <div class="col-md-3">
              <label class="form-label text-sm">Sex</label>
              <select class="form-select form-select-sm" name="stud_sex" id="stud_sex" required>
                <option value="">-- Select Sex --</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
              </select>
            </div>

            <!-- Birth Date -->
            <div class="col-md-3">
              <label class="form-label text-sm">Birth Date</label>
              <input type="date" class="form-control form-control-sm" name="stud_birth_date" id="stud_birth_date" required>
            </div>

            <!-- Age -->
            <div class="col-md-3">
              <label class="form-label text-sm">Age</label>
              <input type="number" class="form-control form-control-sm text-uppercase" name="stud_age" id="stud_age" min="0" readonly>
            </div>

            <!-- Mother Tongue -->
            <div class="col-md-3">
              <label class="form-label text-sm">Mother Tongue</label>
              <select class="form-select form-select-sm text-uppercase" name="stud_mother_tongue" id="stud_mother_tongue" required>
                <option value="">-- Select Mother Tongue --</option>
                <option value="Tagalog">Tagalog</option>
                <option value="Bicolano">Bicolano</option>
                <option value="Cebuano">Cebuano</option>
                <option value="Ilokano">Ilokano</option>
                <option value="Hiligaynon">Hiligaynon</option>
                <option value="Waray">Waray</option>
                <option value="Others">Others</option>
              </select>
            </div>


            <!-- Ethnic Group -->
            <div class="col-md-3">
              <label class="form-label text-sm">Ethnic Group</label>
              <select class="form-select form-select-sm" name="stud_ethnic_group" id="stud_ethnic_group">
                <option value="">-- Select Ethnic Group --</option>
                <option value="Tagalog">Tagalog</option>
                <option value="Cebuano">Cebuano</option>
                <option value="Ilocano">Ilocano</option>
                <option value="Bicolano">Bicolano</option>
                <option value="Waray">Waray</option>
                <option value="Hiligaynon">Hiligaynon</option>
                <option value="Kapampangan">Kapampangan</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <!-- Religion -->
            <div class="col-md-3">
              <label class="form-label text-sm">Religion</label>
              <select class="form-select form-select-sm" name="stud_religion" id="stud_religion" required>
                <option value="">-- Select Religion --</option>
                <option value="Christianity">Roman Catholic</option>
                <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                <option value="Protestant">Protestant</option>
                <option value="Evangelical">Evangelical</option>
                <option value="Islam">Islam</option>
                <option value="Others">Others</option>
              </select>
            </div>


            <!-- HSSP -->
            <div class="col-md-6">
              <label class="form-label text-sm">House #/Sitio/Street/Pook</label>
              <input type="text" class="form-control form-control-sm" name="stud_hssp" id="stud_hssp">
            </div>

            <!-- Address: Barangay -->
            <div class="col-md-4">
              <label class="form-label text-sm">Barangay</label>
              <input type="text" class="form-control form-control-sm" name="stud_barangay" id="stud_barangay">
            </div>

            <!-- Municipality/City -->
            <div class="col-md-4">
              <label class="form-label text-sm">Municipality / City</label>
              <input type="text" class="form-control form-control-sm" name="stud_municipality_city" id="stud_municipality_city">
            </div>

            <!-- Province -->
            <div class="col-md-4">
              <label class="form-label text-sm">Province</label>
              <input type="text" class="form-control form-control-sm" name="stud_province" id="stud_province">
            </div>

            <!-- Father's Name -->
            <div class="col-md-6">
              <label class="form-label text-sm">Father's Name</label>
              <input type="text" class="form-control form-control-sm" name="stud_father_name" id="stud_father_name">
            </div>

            <!-- Mother's Maiden Name -->
            <div class="col-md-6">
              <label class="form-label text-sm">Mother's Maiden Name</label>
              <input type="text" class="form-control form-control-sm" name="stud_mother_maiden_name" id="stud_mother_maiden_name">
            </div>

            <!-- Guardian Name -->
            <div class="col-md-6">
              <label class="form-label text-sm">Guardian Name</label>
              <input type="text" class="form-control form-control-sm" name="stud_guardian_name" id="stud_guardian_name">
            </div>
            <!-- Guardian Relationship -->
            <div class="col-md-6">
              <label class="form-label text-sm">Guardian Relationship</label>
              <select class="form-select form-select-sm" name="stud_guardian_relationship" id="stud_guardian_relationship">
                <option value="">-- Select Relationship --</option>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
                <option value="Grandparent">Grandparent</option>
                <option value="Sibling">Sibling</option>
                <option value="Uncle/Aunt">Uncle/Aunt</option>
                <option value="Cousin">Cousin</option>
                <option value="Guardian">Guardian</option>
                <option value="Other">Other</option>
              </select>
            </div>


            <!-- Contact Number -->
            <div class="col-md-4">
              <label class="form-label text-sm">Contact Number</label>
              <input type="text" class="form-control form-control-sm" name="stud_contact_number" id="stud_contact_number">
            </div>

            <!-- Learning Modality -->
            <div class="col-md-4">
              <label class="form-label text-sm">Learning Modality</label>
              <input type="text" class="form-control form-control-sm" name="stud_learning_modality" id="stud_learning_modality">
            </div>

            <!-- Remarks -->
            <div class="col-md-4">
              <label class="form-label text-sm">Remarks</label>
              <input type="text" class="form-control form-control-sm" name="stud_remarks" id="stud_remarks">
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm">Save Student</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- Transfer Student Modal -->
<!-- 🔹 Single Student Transfer Modal -->
<div class="modal fade" id="transferStudentModal" tabindex="-1" aria-labelledby="transferStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header (unchanged) -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="transferStudentModalLabel">
          Transfer Student
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="transferStudentForm" method="post">
        <input type="hidden" name="stud_id" id="transfer_stud_id">

        <div class="modal-body p-3" style="max-height: 400px; overflow-y: auto;">

          <!-- Student Info -->
          <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
            <div class="avatar avatar-m me-3">
              <img class="rounded-circle" src="<?= base_url('assets/img/logos/profile_logo.png') ?>" alt="User Avatar" width="48" height="48" />
            </div>
            <div class="flex-grow-1">
              <strong id="transfer_student_name"></strong>
              <div class="text-muted small">Current Section: <span id="current_section">—</span></div>
            </div>
          </div>

          <!-- Section Dropdown -->
          <div>
            <label for="transfer_section" class="form-label small fw-semibold">Select New Section</label>
            <select class="form-select form-select-sm" name="transfer_section" id="transfer_section" required>
              <option value="" disabled selected>Choose Section</option>
              <?php foreach ($all_sections as $sections): ?>
                <option
                  value="<?= htmlspecialchars($sections['section_id']); ?>"
                  <?= strtolower($sections['section_status']) === 'inactive' ? 'disabled' : ''; ?>>
                  <?= htmlspecialchars($sections['section_name']); ?> - Grade <?= htmlspecialchars($sections['grade_level']); ?>
                  (<?= htmlspecialchars($sections['section_status']); ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <div class="form-text">Only active sections can accept transfers.</div>
          </div>

        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-end py-2 px-3">
          <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Transfer</button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- 🔹 Bulk Transfer Modal -->
<div class="modal fade" id="bulkTransferStudentModal" tabindex="-1" aria-labelledby="bulkTransferStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header (unchanged) -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="bulkTransferStudentModalLabel">
          Bulk Transfer Students
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="bulkTransferStudentForm" method="post">
        <div class="modal-body p-3" style="max-height: 400px; overflow-y: auto;">

          <!-- Students Info -->
          <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
            <div class="avatar avatar-m me-3">
              <img class="rounded-circle" src="<?= base_url('assets/img/logos/profile_logo.png') ?>" alt="Group Icon" width="48" height="48" />
            </div>
            <div class="flex-grow-1">
              <strong id="bulk_transfer_student_count">0 Students Selected</strong>
              <div class="text-muted small">These students will be moved to a new section.</div>
            </div>
          </div>

          <!-- Section Dropdown -->
          <div>
            <label for="bulk_transfer_section" class="form-label small fw-semibold">Select New Section</label>
            <select class="form-select form-select-sm" name="transfer_section" id="bulk_transfer_section" required>
              <option value="" disabled selected>Choose Section</option>
              <?php foreach ($all_sections as $sections): ?>
                <option
                  value="<?= htmlspecialchars($sections['section_id']); ?>"
                  <?= strtolower($sections['section_status']) === 'inactive' ? 'disabled' : ''; ?>>
                  <?= htmlspecialchars($sections['section_name']); ?> - Grade <?= htmlspecialchars($sections['grade_level']); ?>
                  (<?= htmlspecialchars($sections['section_status']); ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <div class="form-text">Inactive sections are disabled and cannot be selected.</div>
          </div>

        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-end py-2 px-3">
          <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Transfer</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="subjectModalLabel">
          Add / Edit Subject
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="editSubjectForm" action="<?= base_url('academic/saveSubject') ?>" method="post">
        <input type="hidden" name="subject_id" id="subject_id">
        <input type="hidden" name="subject_curriculum_id" class="subject_curriculum_id">
        <input type="hidden" name="subject_grade" class="subject_grade">

        <div class="modal-body py-3 px-3" style="max-height: 500px; overflow-y: auto;">
          <div class="row g-3">

            <div class="col-md-4">
              <label class="form-label text-sm">Curriculum</label>
              <select class="form-select form-select-sm" name="subject_curriculum_id" id="subject_curriculum_id" required>
                <?php if (!empty($all_active_curriculums)): ?>
                  <option value="0">SHS - Core Subject</option>
                  <?php foreach ($all_active_curriculums as $curriculum): ?>
                    <option value="<?= $curriculum['curriculum_id'] ?>">
                      <?= htmlspecialchars($curriculum['curriculum_name']) ?>
                      (<?= htmlspecialchars($curriculum['grade_level']) ?>)
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>

            </div>

            <!-- Subject Code -->
            <div class="col-md-4">
              <label class="form-label text-sm">Subject Code</label>
              <input type="text" class="form-control form-control-sm text-uppercase" name="subject_code" id="subject_code" required>
            </div>

            <!-- Subject Name -->
            <div class="col-md-4">
              <label class="form-label text-sm">Subject Name</label>
              <input type="text" class="form-control form-control-sm text-uppercase" name="subject_name" id="subject_name" required>
            </div>

            <div class="col-md-4">
              <label class="form-label text-sm">Grade Level</label>
              <select class="form-select form-select-sm" name="subject_grade" id="subject_grade" required>
                <option value="0-3">Kindergarden - Grade 3</option>
                <option value="4-6">Grades 4–6 (Elementary)</option>
                <option value="7-10">Grades 7–10 (Junior High School)</option>
                <option value="11-12">Grades 11–12 (Senior High School)</option>

              </select>
            </div>
            <!-- Learning Area -->
            <div class="col-md-4">
              <label class="form-label text-sm">Learning Area</label>
              <input type="text" class="form-control form-control-sm text-uppercase" name="subject_learning_area" id="subject_learning_area" required>
            </div>

            <!-- Semester -->
            <div class="col-md-4">
              <label class="form-label text-sm">Semester</label>
              <select class="form-select form-select-sm" name="subject_semester" id="subject_semester">
                <option value="">--</option>
                <option value="0">Full Academic Year</option>
                <option value="1">1st Semester</option>
                <option value="2">2nd Semester</option>
              </select>
            </div>

            <!-- Subject Type -->
            <div class="col-md-6">
              <label class="form-label text-sm">Subject Type</label>
              <select class="form-select form-select-sm" name="subject_type" id="subject_type">
                <option value="">--</option>
                <option value="Core">Core</option>
                <option value="Specialized">Specialized</option>
                <option value="Applied">Applied</option>
                <option value="EPP">EPP</option>
                <option value="TLE">TLE</option>
                <option value="MAPEH">MAPEH</option>
              </select>
            </div>

            <!-- Status -->
            <div class="col-md-6">
              <label class="form-label text-sm">Status</label>
              <select class="form-select form-select-sm" name="subject_status" id="subject_status">
                <option value="">--</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm">Save Subject</button>
        </div>
      </form>

    </div>
  </div>
</div>
