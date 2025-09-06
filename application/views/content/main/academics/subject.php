<div class="pb-3">
  <div class="row g-4">
    <div class="col-12 col-xxl-6">
      <div class="mb-3">
        <h3 class="mb-2">Subjects</h3>
        <h5 class="text-body-tertiary fw-semibold">Browse and manage active academic year, curriculum, and strand/track offerings.</h5>
      </div>
      <hr class="bg-body-secondary mb-0 mt-1" />
    </div>
  </div>
</div>
<div class="row mb-2 align-items-stretch">

  <!-- JUNIOR HIGH SCHOOL -->
  <div class="col-lg-6 col-md-12 mb-2 d-flex">
    <div class="card shadow-sm h-100 w-100">
      <div class="card-header text-white py-1 px-3 d-flex justify-content-start align-items-center">

        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
          JUNIOR HIGH SCHOOL (JHS) - SUBJECTS
        </h1>

      </div>
      <div class="card-body">
        <?php if (!empty($jhs_subject_types)): ?>
          <div class="accordion" id="subjectTypeAccordionJHS" style="max-height: 350px; overflow-y: auto;">
            <?php foreach ($jhs_subject_types as $index => $subject): ?>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingJHS<?= $index ?>">
                  <button class="accordion-button collapsed d-flex justify-content-between align-items-center"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseJHS<?= $index ?>"
                    aria-expanded="false"
                    aria-controls="collapseJHS<?= $index ?>"
                    data-subject-type="<?= htmlspecialchars($subject['subject_type']) ?>"
                    style="font-size: 14px;">
                    <span><?= htmlspecialchars($subject['subject_type']) ?></span>
                    <span class="badge bg-success rounded-pill ms-2"><?= $subject['subject_count'] ?></span>
                  </button>


                </h2>
                <div id="collapseJHS<?= $index ?>" class="accordion-collapse collapse"
                  aria-labelledby="headingJHS<?= $index ?>" data-bs-parent="#subjectTypeAccordionJHS">
                  <div class="accordion-body p-2">
                    <ul class="list-group" id="subject-list-jhs-<?= $index ?>">
                      <li class="list-group-item text-muted">Loading...</li>
                    </ul>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p>No subject types found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- SENIOR HIGH SCHOOL -->
  <div class="col-lg-6 col-md-12 mb-2 d-flex">
    <div class="card shadow-sm h-100 w-100">
      <div class="card-header text-white py-1 px-3 d-flex justify-content-between align-items-center">
        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
          SENIOR HIGH SCHOOL (SHS) - SUBJECTS
        </h1>

      </div>
      <div class="card-body">
        <?php if (!empty($shs_subject_types)): ?>
          <div class="accordion" id="subjectTypeAccordionSHS" style="max-height: 350px; overflow-y: auto;">
            <?php foreach ($shs_subject_types as $index => $subject): ?>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingSHS<?= $index ?>">
                  <button class="accordion-button collapsed d-flex justify-content-between align-items-center"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseSHS<?= $index ?>"
                    aria-expanded="false"
                    aria-controls="collapseSHS<?= $index ?>"
                    data-subject-type="<?= htmlspecialchars($subject['subject_type']) ?>"
                    style="font-size: 14px;">
                    <span><?= htmlspecialchars($subject['subject_type']) ?></span>
                    <span class="badge bg-success rounded-pill ms-2"><?= $subject['subject_count'] ?></span>
                  </button>
                </h2>
                <div id="collapseSHS<?= $index ?>" class="accordion-collapse collapse"
                  aria-labelledby="headingSHS<?= $index ?>" data-bs-parent="#subjectTypeAccordionSHS">
                  <div class="accordion-body p-2">
                    <ul class="list-group" id="subject-list-shs-<?= $index ?>">
                      <li class="list-group-item text-muted">Loading...</li>
                    </ul>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p>No subject types found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>

<div class="row mb-2" id="sectionList">
  <div class="col-lg-12">
    <div class="card shadow-sm h-100">
      <div class="card-header text-white py-1 px-3 d-flex justify-content-between align-items-center">
        <h1 class="card-title text-uppercase m-0"
          style="font-weight: normal; font-size: 12px; line-height: 2;">
          CURRICULUM LIST
        </h1>
      </div>

      <div class="card-body">
        <div class="row row-cols-1 row-cols-md-2 g-3" style="max-height: 350px; overflow-y: auto;">
          <?php if (!empty($all_curriculums)): ?>
            <?php
            $hasActive = false;
            foreach ($all_curriculums as $curriculum):
              if (strtolower($curriculum['curriculum_status']) === 'active'):
                $hasActive = true;
            ?>
                <div class="col">
                  <div class="border rounded-3 shadow-sm p-3 h-100 position-relative"
                    data-id="<?= $curriculum['curriculum_id'] ?>"
                    style="transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;">

                    <!-- Curriculum Name -->
                    <h6 class="fw-bold text-primary mb-2">
                      <i class="uil uil-books me-1"></i>
                      <?= htmlspecialchars(mb_strimwidth($curriculum['curriculum_name'], 0, 40, '...')) ?>
                    </h6>

                    <!-- Curriculum Code -->
                    <div class="text-muted small mb-1">
                      <i class="uil uil-tag-alt me-1"></i>
                      <?= htmlspecialchars($curriculum['curriculum_code']) ?> - <?= htmlspecialchars($curriculum['subject_count']) ?> Subject(s)
                    </div>

                    <!-- Curriculum Type + Track + Grade -->
                    <div class="text-muted small fst-italic">
                      <i class="uil uil-graduation-cap me-1"></i>
                      <?= htmlspecialchars($curriculum['curriculum_type']) ?>
                      <?php if (!empty($curriculum['strand_track_code'])): ?>
                        - <?= htmlspecialchars($curriculum['strand_track_code']) ?>
                      <?php endif; ?>
                      (<?= htmlspecialchars($curriculum['grade_level']) ?>)
                    </div>

                    <!-- Status + Date -->
                    <div class="d-flex justify-content-between align-items-center mt-2 small">
                      <span class="status-label <?= strtolower($curriculum['curriculum_status']) === 'active' ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                        <i class="uil <?= strtolower($curriculum['curriculum_status']) === 'active' ? 'uil-check-circle' : 'uil-times-circle' ?>"></i>
                        <?= htmlspecialchars($curriculum['curriculum_status']) ?>
                      </span>

                      <span class="text-secondary">
                        <i class="uil uil-clock me-1"></i>
                        <?= date('M d, Y', strtotime($curriculum['created_at'])) ?>
                      </span>
                    </div>
                  </div>
                </div>
              <?php
              endif;
            endforeach;

            if (!$hasActive):
              ?>
              <div class="col">
                <p class="text-muted small fst-italic">No curriculum found.</p>
              </div>
            <?php endif; ?>
          <?php else: ?>
            <div class="col">
              <p class="text-muted">No curriculum found.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>


    </div>
  </div>
</div>
<div class="row mb-2" id="subjectsInCurriculum" style="display:none; max-height: 350px; overflow-y: auto;">
  <div class="col-lg-12">
    <div class="card shadow-sm h-100">
      <div class="card-header py-1 px-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
          <!-- Back button -->
          <span id="backToCurriculum" style="cursor: pointer;">
            <i class="uil uil-arrow-left me-1"></i>
          </span>

          <h1 class="card-title text-uppercase m-0"
            id="sectionPageTitle"
            style="font-weight: normal; font-size: 12px; line-height: 2;">
          </h1>
        </div>

        <div class="d-flex gap-1">
          <!-- Add Subject Button -->
          <button type="button"
            class="btn btn-sm addSubjectBtn"
            title="Add Subject"
            id="addSubjectBtn">
            <i class="uil uil-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body" style="max-height: 350px; overflow-y: auto;">
        <!-- Search Box -->
        <div class="mb-1 sticky-top" style="z-index: 10; top: 0;">
          <input type="text"
            id="searchSubjects"
            class="form-control form-control-sm rounded-pill"
            placeholder="🔍 Search subject by Subject Code or Subject Name">
        </div>
        <table class="table table-bordered table-sm text-center align-middle" style="font-size: 12px;">
          <thead class="table">
            <tr>
              <th style="padding: 5px; width: 30px;">#</th>
              <th style="padding: 5px;">Subject Code</th>
              <th style="padding: 5px;">Subject Name</th>
              <th style="padding: 5px;">Type</th>
              <th style="padding: 5px;">Status</th>
              <th style="padding: 5px;">Action</th>
            </tr>
          </thead>
          <tbody id="subjectsTableBody"></tbody>
        </table>

      </div>
    </div>
  </div>
</div>



</div>

<script>
  $(document).ready(function() {
    const userId = "<?= $this->session->userdata('user_id'); ?>";
    let currentCurriculumId = null;

    $(document).on('click', '#sectionList .col .border', function() {
      const curriculumId = $(this).data("id"); // curriculum_id must be set in card's data-id
      const curriculumName = $(this).find("h6").text().trim();

      currentCurriculumId = curriculumId;
      $("#sectionList").hide();
      $("#subjectsInCurriculum").show();
      $("#sectionPageTitle").text(curriculumName + " - Subject List");

      // Fetch subjects
      $.ajax({
        url: "<?= base_url('academic/fetchSubjects/'); ?>" + curriculumId,
        type: "GET",
        dataType: "json",
        success: function(response) {
          let tbody = $("#subjectsInCurriculum table tbody");
          tbody.empty();

          if (response.length > 0) {
            $.each(response, function(index, subject) {
              let statusDot = subject.subject_status === "active" ?
                `<span class="badge bg-success rounded-circle p-1" style="width:5px;height:5px;">&nbsp;</span>` :
                `<span class="badge bg-danger rounded-circle p-1" style="width:5px;height:5px;">&nbsp;</span>`;

              tbody.append(`
                <tr style="font-size: 12px; height: 28px;">
                  <td style="padding: 3px;">${index + 1}</td>
                  <td style="padding: 3px;">${subject.subject_code}</td>
                  <td style="padding: 3px;">${subject.subject_name}</td>
                  <td style="padding: 3px;">${subject.subject_type}</td>
                  <td style="padding: 3px; text-align:center;">
                    ${statusDot}
                  </td>
                  <td style="padding: 3px; text-align:center;">
                    <button class="btn btn-sm edit-subject" data-id="${subject.subject_id}" style="padding: 2px 6px;">
                      <i class="uil uil-edit"></i>
                    </button>
                  </td>
                </tr>
                <!-- Add this row inside your tbody -->
                <tr id="noSubjectsFound" class="d-none">
                  <td colspan="6" class="text-center">No subjects found</td>
                </tr>

              `);

            });
          } else {
            tbody.append(`<tr><td colspan="6">No subjects found.</td></tr>`);
          }

        }
      });
    });

    function toggleCurriculumFields() {
      const subjectId = $("#subject_id").val();
      const curriculumId = $("#subject_curriculum_id").val();

      if (!subjectId || curriculumId === "0") {
        // Disable ID-based fields, enable class-based ones
        $("#subject_curriculum_id, #subject_grade").prop("disabled", true);
        $(".subject_curriculum_id, .subject_grade").prop("disabled", false);
      } else {
        // Enable ID-based curriculum + class-based grade
        $("#subject_curriculum_id, .subject_grade").prop("disabled", false);
        $(".subject_curriculum_id, #subject_grade").prop("disabled", true);
      }
    }
    // Update hidden input and grade when curriculum select changes
    $("#subject_type").on("change", function() {
      const subject_type = $(this).val();
      if (subject_type !== 'Core') {
        // Enable ID-based curriculum + class-based grade
        // Set current curriculum
        $("#subject_curriculum_id").val(currentCurriculumId);
        $(".subject_curriculum_id").val(currentCurriculumId);
        $("#subject_curriculum_id, .subject_grade").prop("disabled", false);
        $(".subject_curriculum_id, #subject_grade").prop("disabled", true);
      } else {
        // Disable ID-based fields, enable class-based ones
        $("#subject_curriculum_id, #subject_grade").prop("disabled", true);
        $(".subject_curriculum_id, .subject_grade").prop("disabled", false);
        $("#subject_curriculum_id").val(0);
        $(".subject_curriculum_id").val(0);
      }
    });

    // Fetch grade by curriculum_id
    function fetchGrade(curriculumId) {
      if (!curriculumId) return;

      $.ajax({
        url: "academic/getCurriculumGrade",
        type: "POST",
        data: {
          curriculum_id: curriculumId
        },
        dataType: "json",
        success: function(response) {
          if (response.success) {
            $("#subject_grade").val(response.grade_level);
            $(".subject_grade").val(response.grade_level);
          } else {
            $("#subject_grade").val("11-12");
            console.error("Failed to fetch grade level");
          }
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error:", error);
          $("#subject_grade").val("");
        }
      });
    }

    // Add Subject
    $(document).on("click", "#addSubjectBtn", function() {
      $("#editSubjectForm")[0].reset();
      $("#subject_id").val("");
      toggleCurriculumFields();

      // Set current curriculum
      $("#subject_curriculum_id").val(currentCurriculumId);
      $(".subject_curriculum_id").val(currentCurriculumId);
      fetchGrade(currentCurriculumId);

      $("#editSubjectModal").modal("show");
    });

    // Edit Subject
    $(document).on("click", ".edit-subject", function() {
      const subjectId = $(this).data("id");

      $("#editSubjectForm")[0].reset();
      $("#subject_id").val(subjectId);
      toggleCurriculumFields();

      $.ajax({
        url: "academic/getSubject",
        type: "POST",
        data: {
          subject_id: subjectId
        },
        dataType: "json",
        success: function(response) {
          if (response.success) {
            const subject = response.subject;

            // Set fields
            $("#subject_curriculum_id").val(subject.curriculum_id);
            $(".subject_curriculum_id").val(subject.curriculum_id);
            $("#subject_name").val(subject.subject_name || "");
            $("#subject_code").val(subject.subject_code || "");
            $("#subject_learning_area").val(subject.subject_learning_area || "");
            $("#subject_semester").val(subject.subject_semester || "0");
            $("#subject_type").val(subject.subject_type || "");
            $("#subject_status").val(subject.subject_status || "");

            // Fetch grade based on curriculum_id
            fetchGrade(subject.curriculum_id);

            toggleCurriculumFields();
            $("#editSubjectModal").modal("show");
          } else {
            console.error("Failed to fetch subject data");
          }
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error:", error);
        }
      });
    });

    // Update hidden input and grade when curriculum select changes
    $("#subject_curriculum_id").on("change", function() {
      const curriculumId = $(this).val();
      $(".subject_curriculum_id").val(curriculumId);
      $("#subject_curriculum_id").val(curriculumId);
      fetchGrade(curriculumId);
    });
    $("#editSubjectForm").on("submit", function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= base_url('academic/saveSubject') ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.status === "success") {
            Swal.fire({
              icon: "success",
              title: "Success",
              text: response.message,
              showConfirmButton: true
            });
            $("#editSubjectModal").modal("hide");
            location.reload();
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: response.message
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Something went wrong!"
          });
        }
      });
    });
    // Click back arrow
    $(document).on('click', '#backToCurriculum', function() {
      $("#subjectsInCurriculum").hide();
      $("#sectionList").show();
    });
    $(document).on('click', '.accordion-button', function(e) {
      let $button = $(this);
      let $collapse = $button.closest('.accordion-item').find('.accordion-collapse');
      let listContainer = $collapse.find('ul');
      let subjectType = $button.data('subject-type');
      let level = $button.closest('.accordion').attr('id') === "subjectTypeAccordionJHS" ? "JHS" : "SHS";

      // Only fetch data if not loaded yet
      if (!$collapse.data('loaded')) {
        e.preventDefault(); // Stop immediate toggle

        // Show temporary loading text
        listContainer.html('<li class="list-group-item text-muted">Loading...</li>');

        $.ajax({
          url: "<?= base_url('academic/getSubjectsByType') ?>",
          type: "POST",
          data: {
            subject_type: subjectType,
            level: level
          },
          dataType: "json",
          success: function(response) {
            listContainer.empty();

            if (response.length > 0) {
              $.each(response, function(index, subject) {
                listContainer.append(`
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span class="small">${subject.subject_name}</span>
              ${subject.subject_status === "active" 
                ? '<span class="badge bg-success rounded-circle p-1" style="width:5px;height:5px;">&nbsp;</span>' 
                : '<span class="badge bg-danger rounded-circle p-1" style="width:5px;height:5px;">&nbsp;</span>'}
            </li>
          `);

              });
            } else {
              listContainer.html('<li class="list-group-item text-muted">No subjects found.</li>');
            }

            // Mark as loaded to prevent future AJAX calls
            $collapse.data('loaded', true);

            // Trigger collapse open after content is loaded
            let collapseInstance = bootstrap.Collapse.getOrCreateInstance($collapse[0]);
            collapseInstance.show();
          },
          error: function() {
            listContainer.html('<li class="list-group-item text-danger">Failed to load subjects.</li>');
          }
        });
      }
    });


  });
</script>

<script>
  // 🔎 Search filter for subjects
  $('#searchSubjects').on('input', function() {
    var searchText = $(this).val().toLowerCase();
    var visibleCount = 0;

    $('#subjectsInCurriculum table tbody tr').each(function() {
      // Skip the "No subjects found" row
      if (this.id === 'noSubjectsFound') return;

      var subjectCode = $(this).find('td:nth-child(1)').text().toLowerCase();
      var subjectName = $(this).find('td:nth-child(2)').text().toLowerCase();

      if (subjectCode.includes(searchText) || subjectName.includes(searchText)) {
        $(this).show();
        visibleCount++;
      } else {
        $(this).hide();
      }
    });

    // Show "No subjects found" if no visible rows
    $('#noSubjectsFound').toggleClass('d-none', visibleCount > 0);
  });
</script>