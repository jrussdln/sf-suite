<div class="pb-3">
  <div class="row g-4">
    <div class="col-12 col-xxl-6">
      <div class="mb-3">
        <h3 class="mb-2">Alumni Tracer</h3>
        <h5 class="text-body-tertiary fw-semibold">Send surveys to alumni to collect post-grad insights.</h5>
      </div>
      <hr class="bg-body-secondary mb-0 mt-1" />
    </div>
  </div>
</div>
<!-- Top Row: Recipients Setup + Forward -->
<div class="row mb-2">
  <div class="col-lg-12">
    <div class="card shadow-sm h-100">
      <div class="card-header text-white py-1 px-3">
        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
          Tracer Setup
        </h1>
      </div>
      <div class="card-body">
        <div class="row g-2 align-items-center">
          <!-- Additional Message Input -->
          <div class="col-12 col-md-4">
            <input type="text" id="additionalMessage" class="form-control" placeholder="Additional Message (Optional)">
          </div>
          <!-- Recipient Dropdown -->
          <div class="col-12 col-md-2">
            <select id="recipientSelect" class="form-control select2" style="width: 100%;">
              <option selected disabled>Recipient</option>
              <?php foreach ($academic_years as $year): ?>
                <option value="<?= htmlspecialchars($year['sy_term']); ?>">
                  <?= htmlspecialchars($year['sy_term']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- Category Dropdown -->
          <div class="col-12 col-md-2">
            <select id="setSelect" class="form-control select2" style="width: 100%;">
              <option selected disabled>Category</option>
              <?php foreach ($categories as $category): ?>
                <?php if ($category['status'] === 'Available'): ?>
                  <option value="<?= htmlspecialchars($category['qc_id']); ?>">
                    <?= htmlspecialchars($category['category_name']); ?>
                  </option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Buttons (Desktop: Separate | Mobile: Side-by-side) -->
          <div class="col-12 col-md-4">
            <div class="row g-2">
              <div class="col-6 col-md-6">
                <button class="btn btn-success w-100" title="Send">
                  <i class="fas fa-paper-plane"></i>
                </button>
              </div>
              <div class="col-6 col-md-6">
                <button id="btnToggleHistory" class="btn btn-secondary w-100" title="History">
                  <i class="fas fa-history"></i> <span class="btn-text">History</span>
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>
</div>
<!-- Top Row: Recipients Setup + Forward -->
<div class="row mb-2 questions-row">
  <div class="col-lg-12">
    <div class="card shadow-sm h-100">
      <div class="card-header text-white py-1 px-3">
        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
          Tracer Category
        </h1>
      </div>
      <div class="card-body">
        <div class="row g-2 align-items-center">

          <!-- Hidden Add Category Row -->
          <div class="row mt-1 mb-1 align-items-center g-2" id="addCategoryRow" style="display:none;">
            <div class="col-md-6">
              <input type="text" class="form-control" id="addCategoryInput" placeholder="Enter category name">
            </div>
            <div class="col-md-4">
              <select id="addCategorySelectSy" class="form-control select2" style="width: 100%;">
                <option selected disabled>Select Academic Year</option>
                <?php foreach ($academic_years as $year): ?>
                  <option value="<?= htmlspecialchars($year['sy_term']); ?>">
                    <?= htmlspecialchars($year['sy_term']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-primary btn-save-category w-100">
                <i class="fas fa-save"></i>
              </button>
            </div>
          </div>

          <!-- Categories List -->
          <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 w-100">
            <?php if (!empty($categories)): ?>
              <?php foreach ($categories as $category): ?>
                <div class="col d-flex">
                  <div class="border rounded-3 p-3 shadow-sm position-relative flex-fill category-card"
                    style="transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;">

                    <!-- Edit / View Buttons -->
                    <div class="position-absolute d-flex" style="top: 6px; right: 6px; gap: 0.25rem; z-index: 1;">
                      <?php if ($category['status'] === 'Available'): ?>
                        <button type="button" class="btn btn-sm btn-edit-category p-1"
                          title="Edit"
                          data-bs-toggle="modal"
                          data-bs-target="#editQuestCatModal"
                          data-id="<?= $category['qc_id']; ?>"
                          data-name="<?= htmlspecialchars($category['category_name']); ?>"
                          data-year="<?= htmlspecialchars($category['academic_year']); ?>"
                          data-status="<?= $category['status']; ?>">
                          <i class="uil uil-edit-alt text-primary"></i>
                        </button>

                        <button type="button" class="btn btn-sm btn-delete-category p-1"
                          title="Delete"
                          data-id="<?= $category['qc_id']; ?>">
                          <i class="uil uil-trash-alt text-danger"></i>
                        </button>
                      <?php else: ?>
                        <button type="button" class="btn btn-sm btn-view-category p-1"
                          title="View"
                          data-bs-toggle="modal"
                          data-bs-target="#viewQuestCatModal"
                          data-category="<?= htmlspecialchars($category['category_name']); ?>"
                          data-year="<?= htmlspecialchars($category['academic_year']); ?>">
                          <i class="uil uil-eye text-secondary"></i>
                        </button>
                      <?php endif; ?>
                    </div>


                    <!-- Category Info -->
                    <h6 class="text-primary fw-bold mb-2 text-uppercase pe-4">
                      <i class="uil uil-book-open me-1"></i>
                      <?= htmlspecialchars($category['category_name']); ?>
                    </h6>
                    <ul class="list-unstyled mb-4 small text-muted">
                      <li class="mb-1">
                        <i class="uil uil-question-circle me-1"></i> <?= $category['question_count'] ?? 0; ?> Question(s)
                        <?php if ($category['status'] !== 'Available'): ?>
                          | <i class="uil uil-comment-alt-message me-1"></i> <?= $category['response_count'] ?? 0; ?> Response(s)
                        <?php endif; ?>
                      </li>
                      <li><i class="uil uil-calendar-alt me-1"></i> <strong>A.Y.</strong> <?= htmlspecialchars($category['academic_year']); ?></li>
                    </ul>

                    <!-- Status & Date -->
                    <div class="d-flex justify-content-between align-items-center position-absolute w-100 px-3" style="bottom: 10px; left: 0;">
                      <small class="<?= $category['status'] === 'Available' ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                        <i class="uil <?= $category['status'] === 'Available' ? 'uil-check-circle' : 'uil-times-circle' ?>"></i>
                        <?= $category['status'] === 'Available' ? 'Available' : 'Unavailable'; ?>
                      </small>
                      <small class="text-muted">
                        <i class="uil uil-clock me-1"></i> <?= date('M j, Y', strtotime($category['created_at'])); ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>

              <!-- Add Category Card -->
              <div class="col d-flex">
                <div class="border rounded-3 p-3 shadow-sm flex-fill d-flex flex-column justify-content-center align-items-center text-center add-category-card"
                  id="addCategoryBtn"
                  style="cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                  <i class="uil uil-plus-circle display-4 text-primary"></i>
                  <small class="text-primary fw-semibold mt-2">Add Category</small>
                </div>
              </div>

            <?php else: ?>
              <!-- Empty State: Add Category -->
              <div class="col d-flex">
                <div class="border rounded-3 p-3 shadow-sm flex-fill d-flex flex-column justify-content-center align-items-center bg-light text-center add-category-card"
                  id="addCategoryBtn"
                  style="cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                  <i class="uil uil-plus-circle display-4 text-primary"></i>
                  <small class="text-primary fw-semibold mt-2">Add Category</small>
                </div>
              </div>
            <?php endif; ?>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
<div class="row mb-2 history-row" style="display:none;">
  <div class="col-lg-12">
    <div class="card shadow-sm h-100">
      <div class="card-header text-white py-1 px-3">
        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
          History
        </h1>
      </div>
      <div class="card-body">
        <div class="row g-2 align-items-center">
        </div>
      </div>
    </div>

  </div>
</div>
</div>
<script>
  $(document).ready(function() {
    //view button in question category
    $('.btn-view-category').on('click', function() {
      const category = $(this).data('category');
      const year = $(this).data('year');
      $('#modalCategoryName').text(category);

      // Clear modal content before showing new
      $('#questionViewList').html('<li class="list-group-item text-muted">Loading questions...</li>');

      $.ajax({
        url: '<?= base_url("tracer/fetchQuestionsAndResponsesByCategory"); ?>',
        method: 'POST',
        data: {
          category_name: category,
          academic_year: year
        },
        success: function(response) {
          const questions = JSON.parse(response);
          let html = '';

          if (questions.length > 0) {
            questions.forEach((q, i) => {
              html += `<li class="list-group-item">
                    <strong>${i + 1}. ${q.question}</strong>`;

              if (Array.isArray(q.choices) && q.choices.length > 0) {
                html += `<ul class="mt-2 mb-2">`;
                q.choices.forEach((choice, j) => {
                  const total = q.total_responses || 1;
                  const percent = ((choice.resp_count / total) * 100).toFixed(1);

                  html += `<li style="display:flex; align-items:center; justify-content:space-between;">
                            <span>${String.fromCharCode(65 + j)}. ${choice.choice_name}</span>
                            <div style="flex:1; margin:0 10px; background:#f1f1f1; height:10px; border-radius:5px; position:relative;">
                                <div style="width:${percent}%; background:#007bff; height:100%; border-radius:5px;"></div>
                            </div>
                            <span>${percent}% (${choice.resp_count})</span>
                        </li>`;
                });
                html += `</ul>`;
              } else {
                html += `<p class="text-muted mb-0 ml-3">No choices available</p>`;
              }

              html += `</li>`;
            });
          } else {
            html = '<li class="list-group-item text-danger">No questions found for this category.</li>';
          }

          $('#questionViewList').html(html);
        },

        error: function() {
          $('#questionViewList').html('<li class="list-group-item text-danger">Failed to load questions.</li>');
        }
      });
    });
    //edit button in question category
    $('.btn-edit-category').on('click', function() {
      const id = $(this).data('id');
      const name = $(this).data('name');
      const year = $(this).data('year');

      // Build the form
      const formFields = `
      <input type="hidden" name="qc_id" value="${id}">
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="editCategoryName" class="form-label text-sm">Category Name</label>
                  <input type="text" class="form-control" id="editCategoryName" name="category_name" value="${name}" required>
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label for="editAcademicYear" class="form-label text-sm">Academic Year</label>
                  <input type="text" class="form-control" id="editAcademicYear" name="academic_year" value="${year}" readonly>
              </div>
          </div>
      </div>

      <!-- Hidden Add Question Row -->
      <div class="row mt-2 align-items-center g-2" id="addQuestionRow" style="display:none;">
          <div class="col-md-10">
              <input type="text" class="form-control" id="newQuestionInput" placeholder="Enter new question">
          </div>
          <div class="col-md-2 mt-3">
              <button type="button" class="btn btn-primary btn-save-question w-100" style="padding-top:.375rem; padding-bottom:.375rem; margin-bottom: 10px;">
                  <i class="fas fa-save"></i>
              </button>
          </div>
      </div>

      <ul class="list-group mt-2" id="questionList">
          <li class="list-group-item text-muted">Loading questions...</li>
      </ul>
      `;

      $('#editQuestCatModalName').text(name);
      $('#editQuestCatModal .modal-body').html(formFields);

      // Toggle Add Question Row on button click
      $(document).off('click', '.btn-add-question').on('click', '.btn-add-question', function() {
        $('#addQuestionRow').slideToggle();
      });

      // Fetch questions with choices
      $.ajax({
        url: '<?= base_url("tracer/fetchQuestionsByCategory"); ?>',
        method: 'POST',
        data: {
          category_name: name,
          academic_year: year
        },
        success: function(response) {
          const questions = JSON.parse(response);
          let html = '';
          if (questions.length > 0) {
            questions.forEach((q, i) => {
              html += `
      <li class="list-group-item position-relative">
        <div>
          <strong class="fw-bold small d-block" style="font-size:0.85rem;">
            ${i + 1}. ${q.question}
          </strong>
          ${
            q.choices && q.choices.length > 0
              ? `<ul class="mt-2 mb-2 ps-3" style="font-size:0.8rem;">` +
                q.choices
                  .map((choice, j) => `<li>${String.fromCharCode(65 + j)}. ${choice}</li>`)
                  .join('') +
                `</ul>`
              : `<p class="text-muted mb-0 ps-3" style="font-size:0.8rem;">No choices available</p>`
          }
        </div>

        <div class="position-absolute top-0 end-0 mt-2 me-3">
          <button type="button" class="btn btn-sm btn-link text-primary p-0 me-2 btn-edit-question" title="Edit Question" data-id="${q.quest_id}">
            <i class="fas fa-edit"></i>
          </button>
          <button type="button" class="btn btn-sm btn-link text-danger p-0 btn-delete-question" title="Delete Question" data-id="${q.quest_id}">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </li>`;
            });
          } else {
            html = '<li class="list-group-item text-danger">No questions found for this category.</li>';
          }



          $('#questionList').html(html);
        },
        error: function() {
          $('#questionList').html('<li class="list-group-item text-danger">Failed to load questions.</li>');
        }
      });

      $(document).off('click', '.btn-save-question').on('click', '.btn-save-question', function() {
        const questionText = $('#newQuestionInput').val().trim();

        if (questionText === '') {
          Swal.fire({
            icon: 'warning',
            title: 'Empty Question',
            text: 'Please enter a question before saving.'
          });
          return;
        }

        $.ajax({
          url: '<?= base_url("tracer/insertQuestion"); ?>',
          method: 'POST',
          data: {
            qc_id: id,
            question: questionText
          },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Added',
                text: 'Question added successfully!',
                timer: 1500,
                showConfirmButton: true
              });

              $('#newQuestionInput').val('');
              $('#addQuestionRow').slideUp();

              // Fetch questions again
              $.ajax({
                url: '<?= base_url("tracer/fetchQuestionsByCategory"); ?>',
                method: 'POST',
                data: {
                  category_name: name,
                  academic_year: year
                },
                success: function(response) {
                  const questions = JSON.parse(response);
                  let html = '';

                  if (questions.length > 0) {
                    questions.forEach((q, i) => {
                      html += `
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>${i + 1}. ${q.question}</strong>
                                            ${q.choices && q.choices.length > 0
                                                ? `<ul class="mt-2 mb-2">` + 
                                                    q.choices.map((choice, j) => `<li>${String.fromCharCode(65 + j)}. ${choice}</li>`).join('') + 
                                                  `</ul>`
                                                : `<p class="text-muted mb-0 ml-3">No choices available</p>`
                                            }
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit-question me-1" title="Edit Question" data-id="${q.quest_id}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-question" title="Delete Question" data-id="${q.quest_id}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </li>`;
                    });
                  } else {
                    html = '<li class="list-group-item text-danger">No questions found for this category.</li>';
                  }

                  $('#questionList').html(html);
                }
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Server Error',
              text: 'Something went wrong while adding the question.'
            });
          }
        });
      });
    });

    let categoryToDeleteId = null;
    $(document).on('click', '.btn-delete-category', function() {
      categoryToDeleteId = $(this).data('id');
      $('#verifyPasswordInput').val(''); // clear password field
      $('#passwordVerifyModal').modal('show');
    });
    //show the add category form
    $('#addCategoryBtn').on('click', function() {
      $('#addCategoryRow').slideToggle();
      $('#addCategoryInput').focus();
    });
    //submit the typed category and academic year
    $('.btn-save-category').on('click', function() {
      const categoryName = $('#addCategoryInput').val().trim();
      const selectedSy = $('#addCategorySelectSy').val();
      if (!categoryName) {
        $('#addCategoryInput').addClass('is-invalid').focus();
        return;
      } else {
        $('#addCategoryInput').removeClass('is-invalid');
      }

      if (!selectedSy) {
        $('#addCategorySelectSy').next('.select2-container').find('.select2-selection').addClass('is-invalid').focus();
        return;
      } else {
        $('#addCategorySelectSy').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
      }

      $.ajax({
        url: '<?= base_url("tracer/saveCategory") ?>',
        method: 'POST',
        data: {
          category_name: categoryName,
          academic_year_id: selectedSy
        },
        dataType: 'json',
        beforeSend: function() {
          Swal.showLoading();
        },
        success: function(response) {
          Swal.close();
          if (response.success) {

            Swal.fire({
              icon: 'success',
              title: 'Saved!',
              text: 'Category saved successfully.',
              timer: 2000,
              showConfirmButton: true
            });
            window.location.reload();
            // Clear and hide inputs after success
            $('#addCategoryInput').val('');
            $('#addCategorySelectSy').val(null).trigger('change');
            $('#addCategoryRow').slideUp();

            // Optionally refresh or update the category list here

          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.message || 'Failed to save category.'
            });
          }
        },
        error: function(xhr, status, error) {
          Swal.close();
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while saving category.'
          });
          console.error(error);
        }
      });
    });
    $('#editQuestCatForm').on('submit', function(e) {
      e.preventDefault();

      const form = $(this);
      const formData = form.serialize();

      Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to save these changes?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, save it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: response.message,
                  timer: 1500,
                  showConfirmButton: true
                }).then(() => {
                  window.location.reload();
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: response.message
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Something went wrong. Please try again.'
              });
            }
          });
        }
      });
    });
    $('#editQuestionForm').on('submit', function(e) {
      e.preventDefault();

      const formData = $(this).serialize();

      $.ajax({
        url: '<?= base_url("tracer/updateQuestionAndChoices"); ?>',
        type: 'POST',
        data: formData,
        success: function(response) {
          console.log(response); // Debug raw response
          const res = JSON.parse(response);

          if (res.success) {
            $('#editQuestionModal').modal('hide');
            Swal.fire({
              icon: 'success',
              title: 'Updated',
              text: res.message,
              timer: 1200,
              showConfirmButton: true
            });
          } else {
            Swal.fire('Error', res.message, 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Something went wrong.', 'error');
        }
      });
    });


    //to open the add choices form
    $(document).on('click', '#btnAddChoice', function() {
      $('#addChoiceRow').slideToggle();
    });
    //to save the typed choices
    $(document).on('click', '.btn-save-choice', function() {
      const newChoice = $('#newChoiceInput').val().trim();
      if (newChoice !== '') {
        const index = $('#editChoicesWrapper .choice-row').length;
        const choiceRow = `
        <div class="row mt-2 choice-row">
          <div class="col-11 d-flex align-items-center">
            <label class="me-2 mb-2" style="width: 25px; text-align: center;">
              ${String.fromCharCode(65 + index)}
            </label>
            <input type="text" class="form-control" name="choices[]" value="${newChoice}" required>
          </div>
          <div class="col-1">
            <button type="button" 
              class="btn btn-delete-choice w-100 d-flex justify-content-center align-items-center" 
              style="height: 100%;">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
      `;
        $('#editChoicesWrapper').append(choiceRow);
        $('#newChoiceInput').val('');
        $('#addChoiceRow').hide();
      }
    });
    // Handle delete choice button
    $(document).on('click', '.btn-delete-choice', function() {
      $(this).closest('.choice-row').remove();
    });
    //delete question
    $(document).on('click', '.btn-delete-question', function() {
      const questId = $(this).data('id');
      const name = $('#editCategoryName').val(); // use modal input value for category_name
      const year = $('#editAcademicYear').val(); // use modal input value for academic_year

      Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'This will permanently delete the question and its choices.',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url("tracer/deleteQuestion"); ?>',
            method: 'POST',
            data: {
              quest_id: questId
            },
            success: function() {
              Swal.fire('Deleted!', 'The question has been deleted.', 'success');

              // Refresh the question list without closing modal
              $.ajax({
                url: '<?= base_url("tracer/fetchQuestionsByCategory"); ?>',
                method: 'POST',
                data: {
                  category_name: name,
                  academic_year: year
                },
                success: function(response) {
                  const questions = JSON.parse(response);
                  let html = '';

                  if (questions.length > 0) {
                    questions.forEach((q, i) => {
                      html += `
                                          <li class="list-group-item d-flex justify-content-between align-items-start">
                                              <div>
                                                  <strong>${i + 1}. ${q.question}</strong>
                                                  ${q.choices && q.choices.length > 0
                                                      ? `<ul class="mt-2 mb-2">` +
                                                          q.choices.map((choice, j) => `<li>${String.fromCharCode(65 + j)}. ${choice}</li>`).join('') +
                                                        `</ul>`
                                                      : `<p class="text-muted mb-0 ml-3">No choices available</p>`
                                                  }
                                              </div>
                                              <div>
                                                  <button type="button" class="btn btn-sm btn-outline-primary btn-edit-question me-1" title="Edit Question" data-id="${q.quest_id}">
                                                      <i class="fas fa-edit"></i>
                                                  </button>
                                                  <button type="button" class="btn btn-sm btn-outline-danger btn-delete-question" title="Delete Question" data-id="${q.quest_id}">
                                                      <i class="fas fa-trash"></i>
                                                  </button>
                                              </div>
                                          </li>`;
                    });
                  } else {
                    html = '<li class="list-group-item text-danger">No questions found for this category.</li>';
                  }

                  $('#questionList').html(html);
                },
                error: function() {
                  $('#questionList').html('<li class="list-group-item text-danger">Failed to load questions.</li>');
                }
              });
            },
            error: function() {
              Swal.fire('Error', 'Failed to delete the question.', 'error');
            }
          });
        }
      });
    });
    //edit question
    $(document).on('click', '.btn-edit-question', function() {
      const questId = $(this).data('id');

      // Clear previous values
      $('#editChoicesWrapper').html('');
      $('#editQuestionText').val('');
      $('#editQuestId').val(questId);

      // Fetch question and choices
      $.ajax({
        url: '<?= base_url("tracer/fetchQuestionWithChoices"); ?>',
        type: 'POST',
        data: {
          quest_id: questId
        },
        success: function(response) {
          const data = JSON.parse(response);
          $('#modalEditQuestionName').text(data.question);
          $('#editQuestionText').val(data.question);
          $('#editQuestId').val(data.quest_id);
          if (data.choices && data.choices.length > 0) {
            data.choices.forEach((choice, index) => {
              const choiceRow = $(`
                <div class="row mt-2 choice-row g-2 align-items-center">
                    <!-- Letter -->
                    <div class="col-auto">
                        <label class="form-label mb-0" style="width: 25px; text-align: center;">
                            ${String.fromCharCode(65 + index)}
                        </label>
                    </div>
                    
                    <!-- Input -->
                    <div class="col-9 col-sm-10">
                        <input type="text" class="form-control form-control-sm" name="choices[]" value="${choice}" required>
                    </div>

                    <!-- Delete Button -->
                    <div class="col-auto">
                        <button type="button" 
                            class="btn btn-sm btn-delete-choice d-flex justify-content-center align-items-center">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
              `);

              $('#editChoicesWrapper').append(choiceRow);
            });
          } else {
            $('#editChoicesWrapper').append('<p class="text-muted">No choices available.</p>');
          }

          $('#editQuestionModal').modal('show');
        },
        error: function() {
          alert('Failed to load question details.');
        }
      });
    });
    //history button when clicked becomes return
    $('#btnToggleHistory').on('click', function() {
      const isHistoryVisible = $('.history-row').is(':visible');

      if (!isHistoryVisible) {
        // Show history, hide questions
        $('.questions-row').hide();
        $('.history-row').show();

        // Change button to Return
        $(this).html('<i class="fas fa-arrow-left"></i> <span class="btn-text">Return</span>');
        $(this).attr('title', 'Return');
      } else {
        // Show questions, hide history
        $('.questions-row').show();
        $('.history-row').hide();

        // Change button back to History
        $(this).html('<i class="fas fa-history"></i> <span class="btn-text">History</span>');
        $(this).attr('title', 'History');
      }
    });
    // Handle password verification form submit
    $('#passwordVerifyForm').on('submit', function(e) {
      e.preventDefault();
      const password = $('#verifyPasswordInput').val().trim();

      if (!password) {
        Swal.fire('Error', 'Please enter your password.', 'error');
        return;
      }

      $.ajax({
        url: '<?= base_url("auth/verify_password_confirmation"); ?>',
        method: 'POST',
        data: {
          password: password
        },
        success: function(response) {
          let res = {};
          try {
            res = JSON.parse(response);
          } catch (e) {
            res = {
              success: false
            };
          }

          if (res.success) {
            $('#passwordVerifyModal').modal('hide');

            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, delete it!',
              reverseButtons: true
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url: '<?= base_url("tracer/deleteCategory"); ?>',
                  method: 'POST',
                  data: {
                    qc_id: categoryToDeleteId
                  },
                  success: function(response) {
                    let delRes = {};
                    try {
                      delRes = JSON.parse(response);
                    } catch (e) {
                      delRes = {
                        success: false
                      };
                    }

                    if (delRes.success) {
                      Swal.fire('Deleted!', 'Category has been deleted.', 'success')
                        .then(() => location.reload());
                    } else {
                      Swal.fire('Error!', 'Failed to delete category.', 'error');
                    }
                  },
                  error: function() {
                    Swal.fire('Error!', 'Failed to delete category.', 'error');
                  }
                });
              }
            });
          } else {
            Swal.fire('Error', 'Incorrect password.', 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Failed to verify password.', 'error');
        }
      });
    });
  });
</script>