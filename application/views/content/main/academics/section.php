<!-- Section Management -->
<div class="pb-3">
  <div class="row g-4">
    <div class="col-12 col-xxl-6">
      <div class="mb-2 d-flex align-items-center gap-2">
        <i class="uil uil-users-alt text-warning" style="font-size: 1.4rem;"></i>
        <h4 class="fw-semibold mb-0">Section Management</h4>
      </div>
      <hr class="bg-body-secondary mb-0 mt-2" />
    </div>
  </div>
</div>
<div class="row mb-2" id="sectionList">
  <div class="col-lg-12">
    <div class="card shadow-sm h-100">
      <div class="card-header text-white py-1 px-3 d-flex justify-content-between align-items-center">
        <h1 class="card-title text-uppercase m-0"
          style="font-weight: normal; font-size: 12px; line-height: 2;">
          SECTION LIST
        </h1>

        <div class="d-flex align-items-center gap-1">
          <!-- Add Section Button -->
          <button type="button"
            class="btn btn-sm add-section-btn"
            title="Add Section"
            data-bs-toggle="modal"
            data-bs-target="#editSectionModal">
            <i class="uil uil-plus"></i>
          </button>
          <!-- Requests Button -->
          <button type="button"
            class="btn btn-sm requests-btn position-relative"
            title="View Requests"
            data-bs-toggle="modal"
            data-bs-target="#requestsModal">
            <i class="uil uil-envelope-check" style="font-size: 15px;"></i>
            <span id="pendingBadge"
              class="position-absolute top-0 start-100 badge rounded-pill bg-danger d-none"
              style="font-size: 10px; padding: 0.15rem 0.35rem; transform: translate(-110%, -20%);">
            </span>
          </button>
          <!-- Refresh Button -->
          <button type="button"
            class="btn btn-sm refresh-btn"
            title="Refresh"
            onclick="location.reload();">
            <i class="uil uil-refresh"></i>
          </button>
        </div>

      </div>

      <div class="card-body">
        <div class="list-group" style="height: calc(75vh - 75px); overflow-y: auto; overflow-x: hidden;">
          <?php if (!empty($all_sections)): ?>
            <div class="row g-3"> <!-- Bootstrap row with gap -->
              <?php foreach ($all_sections as $section): ?>
                <div class="col-12 col-md-6"> <!-- 1 per row on mobile, 2 per row on md+ -->
                  <div class="border rounded-3 shadow-sm p-3 h-100 position-relative section-card"
                    data-id="<?= $section['section_id'] ?>"
                    data-name="<?= htmlspecialchars($section['section_name']) ?>"
                    data-level="<?= htmlspecialchars($section['grade_level']) ?>"
                    style="transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;">

                    <!-- Top right corner buttons -->
                    <div class="position-absolute top-0 end-0 mt-2 me-2 d-flex gap-1">
                      <!-- Toggle -->
                      <button class="btn btn-sm p-1 border-0 bg-transparent toggle-section-btn"
                        data-id="<?= $section['section_id'] ?>"
                        title="Toggle On/Off">
                        <i class="uil <?= strtolower($section['section_status']) === 'active' ? 'uil-toggle-on text-success' : 'uil-toggle-off text-danger' ?>"></i>
                      </button>

                      <!-- Edit -->
                      <button class="btn btn-sm p-1 border-0 bg-transparent edit-section-btn"
                        data-id="<?= $section['section_id'] ?>"
                        title="Edit"
                        data-bs-toggle="modal"
                        data-bs-target="#editSectionModal">
                        <i class="uil uil-edit text-primary"></i>
                      </button>

                      <!-- Import -->
                      <button class="btn btn-sm p-1 border-0 bg-transparent import-student-btn"
                        data-id="<?= $section['section_id'] ?>"
                        title="Import"
                        data-bs-toggle="modal"
                        data-bs-target="#importStudentModal">
                        <i class="uil uil-import text-warning"></i>
                      </button>

                      <!-- Delete -->
                      <button class="btn btn-sm p-1 border-0 bg-transparent btnDeleteSection"
                        title="Delete"
                        data-section_id="<?= $section['section_id'] ?>"
                        data-section_status="<?= $section['section_status'] ?>">
                        <i class="uil uil-trash-alt text-danger"></i>
                      </button>
                    </div>

                    <!-- Section info -->
                    <h6 class="fw-bold text-primary mb-1">
                      <i class="uil uil-building me-1"></i>
                      <?= htmlspecialchars(mb_strimwidth($section['section_name'], 0, 40, '...')) ?>
                    </h6>

                    <div class="text-muted small mb-1">
                      <i class="uil uil-book-open me-1"></i>
                      <?= htmlspecialchars($section['curriculum_code'] ?? 'No curriculum') ?>
                      - <i class="uil uil-signal-alt-3 ms-1 me-1"></i> Grade
                      <?= htmlspecialchars($section['grade_level'] ?? 'No grade level') ?>
                    </div>

                    <div class="text-muted small fst-italic">
                      <i class="uil uil-users-alt me-1"></i>
                      <?= htmlspecialchars($section['total_students']) ?>/<?= htmlspecialchars($section['max_cap']) ?> Student(s)
                      | <i class="uil uil-calendar-alt me-1"></i> S.Y. <?= htmlspecialchars($section['school_year']) ?>
                    </div>
                    <div class="text-muted small fst-italic">
                      <i class="uil uil-user-square me-1"></i>
                      <?= !empty($section['adviser_name']) ? htmlspecialchars($section['adviser_name']) : 'No adviser' ?>
                    </div>


                    <!-- Status + Date -->
                    <div class="d-flex justify-content-between align-items-center mt-2 small">
                      <span class="status-label <?= strtolower($section['section_status']) === 'active' ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                        <i class="uil <?= strtolower($section['section_status']) === 'active' ? 'uil-check-circle' : 'uil-times-circle' ?>"></i>
                        <?= htmlspecialchars($section['section_status']) ?>
                      </span>

                      <span class="text-secondary">
                        <i class="uil uil-clock me-1"></i> <?= date('M d, Y', strtotime($section['created_at'])) ?>
                      </span>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-muted small fst-italic">No sections found.</p>
          <?php endif; ?>
        </div>
      </div>




    </div>
  </div>
</div>

<div class="row mb-2" id="studentInSection" style="display:none;">
  <div class="col-lg-12">
    <div class="card shadow-sm h-100">
      <div class="card-header text-white py-1 px-3 d-flex justify-content-between align-items-center">
        <h1 id="sectionPageTitle" class="card-title text-uppercase m-0"
          style="font-weight: normal; font-size: 12px; line-height: 2;">
        </h1>

        <!-- Desktop buttons -->
        <div class="d-flex gap-1 d-none d-md-flex">

          <!-- Add Student Button -->
          <button type="button"
            class="btn btn-sm add-student-btn"
            title="Add Student"
            data-bs-toggle="modal"
            data-bs-target="#editStudentModal">
            <i class="uil uil-plus"></i>
          </button>

          <!-- Transfer Button -->
          <button type="button"
            class="btn btn-sm bulk-transfer-btn"
            title="Transfer Student"
            id="bulkTransferBtn">
            <i class="uil uil-exchange-alt"></i>
          </button>

        </div>

        <!-- Mobile dropdown -->
        <div class="dropdown d-md-none">
          <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="uil uil-ellipsis-v"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <button type="button"
                class="dropdown-item add-student-btn"
                data-bs-toggle="modal"
                data-bs-target="#editStudentModal">
                <i class="uil uil-plus"></i> Add Student
              </button>
            </li>
            <li>
              <button type="button"
                class="dropdown-item bulk-transfer-btn"
                id="bulkTransferBtn">
                <i class="uil uil-exchange-alt"></i> Transfer Student
              </button>
            </li>
          </ul>
        </div>

      </div>
      <div class="card-body" style="height: calc(75vh - 75px); overflow-y: auto; overflow-x: hidden;">
        <!-- Search Box -->
        <div class="mb-1 sticky-top" style="z-index: 10; top: 0;">
          <input type="text"
            id="searchStudent"
            class="form-control form-control-sm rounded-pill"
            placeholder="🔍 Search student by LRN or Name">
        </div>

        <table class="table table-bordered table-sm text-center align-middle" style="font-size: 12px;">
          <thead class="table">
            <tr>
              <th style="padding: 5px; width: 30px;">
                <input type="checkbox" id="selectAllStudents">
              </th>
              <th style="padding: 5px;">LRN</th>
              <th style="padding: 5px;">Name</th>
              <th style="padding: 5px;">Sex</th>
              <th style="padding: 5px;">Action</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>


    </div>
  </div>
</div>

</div>

<script>
  $(document).ready(function() {
    const userId = "<?= $this->session->userdata('user_id'); ?>";
    // Reset modal when clicking "Add Section"
    $('.add-section-btn').on('click', function() {
      // Reset all input fields in the form
      $('#editSectionForm')[0].reset();
      $('#sec_section_id').val('');
      $('#sec_grade_level').empty().append('<option value="">-- Select Grade Level --</option>');
    });
    // When curriculum changes, populate grade levels
    $('#sec_curriculum_id').on('change', function() {
      var curriculumId = $(this).val();
      var $gradeLevel = $('#sec_grade_level');

      // Reset dropdown
      $gradeLevel.empty().append('<option value="">-- Select Grade Level --</option>');

      if (curriculumId) {
        $.ajax({
          url: '<?= base_url("academic/getGradeLevels") ?>',
          type: 'POST',
          data: {
            curriculum_id: curriculumId
          },
          dataType: 'json',
          success: function(response) {
            $.each(response, function(index, level) {
              $gradeLevel.append('<option value="' + level + '">' + level + '</option>');
            });
          }
        });
      }
    });
    // When clicking edit section button
    document.querySelectorAll('.edit-section-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const sectionId = this.getAttribute('data-id');

        fetch('<?= base_url("academic/getSection/") ?>' + sectionId)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              const s = data.data;

              // Fill modal fields
              document.getElementById('sec_section_id').value = s.section_id;
              document.getElementById('sec_section_name').value = s.section_name;
              document.getElementById('sec_curriculum_id').value = s.curriculum_id || '';
              document.getElementById('sec_school_year').value = s.sy_id;
              document.getElementById('sec_max_cap').value = s.max_cap;

              // Trigger change to load grade levels
              $('#sec_curriculum_id').trigger('change');

              // Wait a tiny bit for AJAX to populate options, then set the grade_level
              setTimeout(() => {
                $('#sec_grade_level').val(s.grade_level);
              }, 200); // 200ms delay
            } else {
              alert(data.message || 'Error loading section.');
            }
          })
          .catch(err => {
            console.error('Error:', err);
            alert('Could not load section data.');
          });
      });
    });
    document.getElementById('editSectionForm').addEventListener('submit', function(e) {
      e.preventDefault();

      fetch('<?= base_url("academic/saveSection") ?>', {
          method: 'POST',
          body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: data.message || 'Section saved successfully.'
            }).then(() => {
              $('#editSectionModal').modal('hide');
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: data.message || 'Something went wrong.'
            });
          }
        })
        .catch(err => {
          console.error('Error:', err);
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Unable to connect to server.'
          });
        });
    });
    let deleteSectionId = null;
    let deleteElement = null;
    // Open password modal when clicking delete
    $(document).on('click', '.btnDeleteSection', function() {
      const sectionStatus = $(this).data('section_status');
      // Prevent deletion if section is active
      if (sectionStatus && sectionStatus.toLowerCase() === 'active') {
        Swal.fire('Warning', 'You cannot delete an active section.', 'warning');
        return;
      }
      deleteSectionId = $(this).data('section_id');
      deleteElement = $(this).closest('tr'); // adjust if your layout is different
      // Show password modal
      $('#passwordVerifyModal').modal('show');
    });
    // Handle password verification
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
        dataType: 'json',
        success: function(res) {
          if (res.success) {
            $('#passwordVerifyModal').modal('hide');
            deleteSection();
          } else {
            Swal.fire('Error', 'Incorrect password.', 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Failed to verify password.', 'error');
        }
      });
    });
    // Actual deletion
    function deleteSection() {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This will permanently delete this section.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url("academic/deleteSection") ?>',
            type: 'POST',
            data: {
              section_id: deleteSectionId
            },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Deleted!',
                  text: response.message || 'Section deleted successfully.',
                  timer: 1500,
                  showConfirmButton: false
                }).then(() => {
                  // Reload page after success
                  location.reload();
                });
              } else {
                Swal.fire('Error', response.message || 'Could not delete section.', 'error');
              }
            },
            error: function() {
              Swal.fire('Error', 'Server error while deleting section.', 'error');
            }
          });
        }
      });
    }
    //toggle section status
    document.querySelectorAll('.toggle-section-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const sectionId = this.getAttribute('data-id');
        const icon = this.querySelector('i');

        fetch('<?= base_url("academic/toggleSectionStatus") ?>', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'section_id=' + encodeURIComponent(sectionId)
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              if (data.new_status.toLowerCase() === 'active') {
                icon.classList.remove('uil-toggle-off', 'text-danger');
                icon.classList.add('uil-toggle-on', 'text-success');
                this.closest('.border').querySelector('.status-label').textContent = 'Active';
                this.closest('.border').querySelector('.status-label').classList.remove('text-danger');
                this.closest('.border').querySelector('.status-label').classList.add('text-success');
              } else {
                icon.classList.remove('uil-toggle-on', 'text-success');
                icon.classList.add('uil-toggle-off', 'text-danger');
                this.closest('.border').querySelector('.status-label').textContent = 'Inactive';
                this.closest('.border').querySelector('.status-label').classList.remove('text-success');
                this.closest('.border').querySelector('.status-label').classList.add('text-danger');
              }
              location.reload(); // Optional — replace with table refresh if needed
            } else {
              alert(data.message || 'Error updating status.');
            }
          })
          .catch(err => console.error(err));
      });
    });
    //get students by section
    $(document).on('click', '.section-card', function(e) {
      if ($(e.target).closest('button').length) return;
      var sectionId = $(this).data('id');
      var sectionName = $(this).data('name');
      var sectionLevel = $(this).data('level');
      // Hide section list
      $('#sectionList').hide();
      // Show student list
      $('#studentInSection').show();
      $('#sectionPageTitle').html(`
        <i class="uil uil-arrow-left me-1" id="backToSectionList" style="cursor: pointer;"></i>
            Masterlist - Grade ${sectionLevel} ${sectionName}
      `);
      $('.add-student-btn').data('section-id', sectionId);

      // Fetch students in this section
      $.ajax({
        url: '<?= base_url("academic/getStudentsBySection") ?>',
        type: 'POST',
        data: {
          section_id: sectionId
        },
        dataType: 'json',
        success: function(response) {
          var tbody = $('#studentInSection table tbody');
          tbody.empty();
          $('#selectAllStudents').prop('checked', false); // reset select-all checkbox
          if (response.length > 0) {
            $.each(response, function(index, student) {
              tbody.append(`
              <tr style="font-size: 12px; height: 28px;">
                <td style="padding: 3px; text-align: center;">
                  <input type="checkbox" class="student-checkbox" value="${student.stud_id}" data-section="${student.section_id}">
                </td>
                <td style="padding: 3px; text-align: center;">${student.stud_lrn}</td>
                <td style="padding: 3px; text-align: center;">${student.stud_name}</td>
                <td style="padding: 3px; text-align: center;">${student.stud_sex}</td>
                <td style="padding: 3px; text-align: center;">
                  
                  <!-- Desktop buttons -->
                  <div class="d-none d-md-block">
                    <button class="btn btn-sm editStudent" data-id="${student.stud_id}" style="padding: 2px 6px;">
                      <i class="uil uil-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm transfer-btn" style="padding: 2px 6px;" 
                      data-id="${student.stud_id}" data-name="${student.stud_name}"  
                      data-section="${student.section_id}" data-bs-toggle="modal" data-bs-target="#transferStudentModal">
                      <i class="uil uil-exchange-alt"></i>
                    </button>
                    <button type="button" class="btn btn-sm warningStudentButton" style="padding: 2px 6px; color: #ff0000ff;">
                      <i class="uil uil-exclamation-circle"></i>
                    </button>
                  </div>

                  <!-- Mobile dropdown -->
                  <div class="dropdown d-md-none">
                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="uil uil-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <button class="dropdown-item editStudent" data-id="${student.stud_id}">
                          <i class="uil uil-edit"></i> Edit
                        </button>
                      </li>
                      <li>
                        <button class="dropdown-item transfer-btn" data-id="${student.stud_id}" 
                          data-name="${student.stud_name}" data-section="${student.section_id}" 
                          data-bs-toggle="modal" data-bs-target="#transferStudentModal">
                          <i class="uil uil-exchange-alt"></i> Transfer
                        </button>
                      </li>
                      <li>
                        <button class="dropdown-item warningStudentButton" style="color:#ff0000ff;">
                          <i class="uil uil-exclamation-circle"></i> Warning
                        </button>
                      </li>
                    </ul>
                  </div>

                </td>
              </tr>
              `);
            });
          } else {
            tbody.append(`<tr><td colspan="4" class="text-center" style="font-size: 12px; padding: 5px;">No students found</td></tr>`);
          }
        }

      });
    });
    //transfer button
    $(document).on('click', '.transfer-btn', function() {
      var stud_id = $(this).data('id');
      var section_id = $(this).data('section'); // current section_id
      var stud_name = $(this).data('name');

      $('#transfer_stud_id').val(stud_id);
      $('#transfer_student_name').text(stud_name);

      // ✅ Find section name from dropdown
      var section_name = $('#transfer_section option[value="' + section_id + '"]').text();
      $('#current_section').text(section_name);

      // ✅ Preselect in dropdown
      $('#transfer_section').val(section_id);
    });
    //transfer button on submit
    $('#transferStudentForm').on('submit', function(e) {
      e.preventDefault();

      var stud_id = $('#transfer_stud_id').val();
      var new_section_id = $('#transfer_section').val();

      $.ajax({
        url: '<?= base_url("academic/transferStudent") ?>',
        method: 'POST',
        data: {
          stud_id: stud_id,
          transfer_section: new_section_id
        },
        dataType: 'json',
        success: function(res) {
          $('#transferStudentModal').modal('hide'); // Hide modal first
          if (res.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Transferred!',
              text: 'Student transferred successfully.',
              showConfirmButton: true
            }).then(() => {
              // Optionally reload the student list
              location.reload();
            });
          } else if (res.status === 'info') {
            Swal.fire({
              icon: 'info',
              title: 'No changes',
              text: 'No changes were made.',
              showConfirmButton: true
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: res.message || 'Error transferring student'
            });
          }
        },
        error: function() {
          $('#transferStudentModal').modal('hide');
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error transferring student.'
          });
        }
      });
    });
    //bulk transfer button
    $(document).on('click', '#bulkTransferBtn', function() {
      const selectedCheckboxes = $('.student-checkbox:checked');
      const selectedIds = selectedCheckboxes.map(function() {
        return $(this).val();
      }).get();

      if (selectedIds.length === 0) {
        Swal.fire('No students selected', 'Please select at least one student.', 'warning');
        return; // prevents modal from opening
      }

      // Check if all from same section (optional)
      const sectionIds = [...new Set(selectedCheckboxes.map(function() {
        return $(this).data('section');
      }).get())];

      if (sectionIds.length > 1) {
        Swal.fire('Mixed sections selected', 'Please select students from the same section only.', 'warning');
        return;
      }

      const sectionId = sectionIds[0];
      $('#bulkTransferStudentForm').data('selectedIds', selectedIds);
      $('#bulk_transfer_section').val(sectionId);
      $('#bulk_transfer_student_count').text(`${selectedIds.length} Student${selectedIds.length > 1 ? 's' : ''}`);

      // ✅ Manually open modal
      $('#bulkTransferStudentModal').modal('show');
    });
    //bulk transfer on submit
    $('#bulkTransferStudentForm').on('submit', function(e) {
      e.preventDefault();

      const selectedIds = $(this).data('selectedIds') || [];
      const newSectionId = $('#bulk_transfer_section').val();

      if (selectedIds.length === 0) {
        Swal.fire('Error', 'No students selected for transfer.', 'error');
        return;
      }

      if (!newSectionId) {
        Swal.fire('Error', 'Please select a section to transfer to.', 'error');
        return;
      }

      $.ajax({
        url: '<?= base_url("academic/bulkTransferStudents") ?>',
        method: 'POST',
        data: {
          stud_ids: selectedIds,
          transfer_section: newSectionId
        },
        dataType: 'json',
        success: function(res) {
          $('#bulkTransferStudentModal').modal('hide');
          if (res.status === 'success') {
            Swal.fire('Success', res.message, 'success').then(() => location.reload());
          } else {
            Swal.fire('Error', res.message || 'Bulk transfer failed.', 'error');
          }
        },
        error: function() {
          $('#bulkTransferStudentModal').modal('hide');
          Swal.fire('Error', 'Server error during transfer.', 'error');
        }
      });
    });
    //back button
    $(document).on('click', '#backToSectionList', function() {
      $('#studentInSection').hide(); // Hide students table
      $('#sectionList').show(); // Show section list
      $('#sectionPageTitle').text('SECTIONS'); // Reset page title
    });
    // Select/Deselect All Students
    $(document).on('change', '#selectAllStudents', function() {
      const checked = $(this).prop('checked');
      $('.student-checkbox').prop('checked', checked);
    });
    // Sync "select all" when individual checkboxes are changed
    $(document).on('change', '.student-checkbox', function() {
      const allChecked = $('.student-checkbox').length === $('.student-checkbox:checked').length;
      $('#selectAllStudents').prop('checked', allChecked);
    });
    // Display selected file name inside the modal
    document.getElementById('import_file').addEventListener('change', function() {
      let fileName = this.files[0] ? this.files[0].name : null;
      let uploadLabel = document.getElementById('uploadLabel');

      if (fileName) {
        uploadLabel.innerHTML = `
            <i class="uil uil-file-check-alt display-4 mb-2 text-success"></i>
            <p class="mb-1 fw-semibold">${fileName}</p>
            <small class="text-muted">File ready for import</small>
        `;

        Swal.fire({
          icon: 'success',
          title: 'File Selected',
          text: `${fileName} is ready for import`,
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        uploadLabel.innerHTML = `
            <i class="uil uil-plus-circle display-4 mb-2 text-primary"></i>
            <p class="mb-1 fw-semibold">Click to upload or drag & drop</p>
            <small class="text-muted">Allowed formats: CSV, XLSX</small>
        `;
      }
    });
    // Set section_id dynamically when clicking Import button
    $(document).on('click', '.import-student-btn', function() {
      let sectionId = $(this).data('id');
      if ($('#importSectionForm input[name="section_id"]').length === 0) {
        $('<input>').attr({
          type: 'hidden',
          id: 'section_id',
          name: 'section_id',
          value: sectionId
        }).appendTo('#importSectionForm');
      } else {
        $('#section_id').val(sectionId);
      }

      // Ensure user_id exists
      if ($('#importSectionForm input[name="user_id"]').length === 0) {
        $('<input>').attr({
          type: 'hidden',
          id: 'user_id',
          name: 'user_id',
          value: userId
        }).appendTo('#importSectionForm');
      } else {
        $('#user_id').val(userId);
      }
    });
    //import student on submit
    $('#importSectionForm').on('submit', function(e) {
      e.preventDefault();
      var formData = new FormData(this);

      // Show SweetAlert loading while importing
      Swal.fire({
        icon: 'info',
        title: 'Processing...',
        text: 'Please wait while we import your data.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          Swal.close(); // Close loading alert first
          if (response.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Import Successful',
              text: response.message,
              showConfirmButton: true
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Import Failed',
              text: response.message
            });
          }
        },
        error: function() {
          Swal.close();
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Import failed. Please try again.'
          });
        }
      });
    });
    //show  the chosen file
    $('#import_file').on('change', function() {
      let file = this.files[0];
      if (file) {
        let allowedExtensions = /(\.csv|\.xlsx|\.xls)$/i;
        if (!allowedExtensions.exec(file.name)) {
          Swal.fire({
            icon: 'error',
            title: 'Invalid File',
            text: 'Only CSV and XLSX files are allowed.'
          });
          $(this).val(''); // Clear invalid file
        }
      }
    });
    //loading requests when clicked
    function loadRequests() {
      let container = $('#requestsContainer');
      container.html('<div class="text-center text-muted">Loading requests...</div>');
      $.ajax({
        url: '<?= base_url("academic/fetchRequests"); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          if (data.length === 0) {
            container.html('<div class="text-center text-muted py-3"><i class="uil uil-inbox"></i> No requests found.</div>');
            return;
          }
          let html = '';
          data.forEach(req => {
            let actionButtons = `
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm approve-btn d-flex align-items-center" data-id="${req.req_id}">
                        <i class="uil uil-check me-1"></i> Approve
                    </button>
                    <button class="btn btn-danger btn-sm reject-btn d-flex align-items-center" data-id="${req.req_id}">
                        <i class="uil uil-times me-1"></i> Reject
                    </button>
                </div>
            `;

            if (req.req_status && req.req_status.toLowerCase() === 'approved') {
              actionButtons = `
                    <span class="badge bg-success d-flex align-items-center">
                        <i class="uil uil-check-circle me-1"></i> Approved by ${req.ReceiverFName}
                    </span>
                `;
            }

            if (req.req_status && req.req_status.toLowerCase() === 'rejected') {
              actionButtons = `
                    <span class="badge bg-danger d-flex align-items-center">
                        <i class="uil uil-times-circle me-1"></i> Rejected by ${req.ReceiverFName}
                    </span>
                `;
            }

            html += `
                <div class="request-item border rounded-3 shadow-sm p-3 mb-1 position-relative d-flex align-items-start" id="req-${req.req_id}">
                    <input type="checkbox" class="delete-checkbox me-2 d-none" data-id="${req.req_id}">
                    <div class="flex-grow-1">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
                            <div class="mb-2 mb-md-0">
                                <p class="mb-1 fw-semibold">${req.req_desc}</p>
                                <small class="text-muted">
                                    <i class="uil uil-user-circle me-1"></i>
                                    Requested by <span class="fw-bold">${req.SenderFName}</span> - ${timeAgo(req.created_at)}
                                </small>
                            </div>
                            <div class="text-md-end action-buttons">
                                ${actionButtons}
                            </div>
                        </div>
                        <small class="text-muted position-absolute bottom-0 end-0 me-2 mb-1">
                            <i class="uil uil-clock"></i> ${req.created_at}
                        </small>
                    </div>
                </div>
            `;
          });


          container.html(html);
        },

        error: function() {
          container.html('<div class="text-center text-danger">Failed to load requests.</div>');
        }
      });
    }
    //time ago in requests
    function timeAgo(dateString) {
      let date = new Date(dateString);
      console.log(date.toLocaleString('en-US', {
        timeZone: 'Asia/Manila'
      }));

      let now = new Date();
      let diff = Math.floor((now - date) / 1000);

      if (diff < 60) return diff + "s ago";
      if (diff < 3600) return Math.floor(diff / 60) + "m ago";
      if (diff < 86400) return Math.floor(diff / 3600) + "h ago";
      return Math.floor(diff / 86400) + "d ago";
    }
    $('#requestsModal').on('show.bs.modal', function() {
      loadRequests();
    });
    $(document).on('click', '.approve-btn', function() {
      let reqId = $(this).data('id');

      $.ajax({
        url: '<?= base_url("academic/approveRequest"); ?>',
        type: 'POST',
        data: {
          req_id: reqId
        },
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            loadRequests(); // REFRESH LIST
          } else {
            alert('Failed to approve request.');
          }
        },
        error: function() {
          alert('Error approving request.');
        }
      });
    });
    $(document).on('click', '.reject-btn', function() {
      let reqId = $(this).data('id');
      $.ajax({
        url: '<?= base_url("academic/rejectRequest"); ?>',
        type: 'POST',
        data: {
          req_id: reqId
        },
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            loadRequests(); // REFRESH LIST
          } else {
            alert('Failed to reject request.');
          }
        },
        error: function() {
          alert('Error rejecting request.');
        }
      });
    });

    function checkPendingRequests() {
      $.ajax({
        url: '<?= base_url("academic/getPendingRequestsCount"); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.count > 0) {
            $('#pendingBadge')
              .removeClass('d-none') // show badge
              .text(response.count); // set count
          } else {
            $('#pendingBadge').addClass('d-none').text(''); // hide if none
          }
        },
        error: function() {
          console.error('Failed to fetch pending requests count.');
        }
      });
    }
    // Run once when page loads
    checkPendingRequests();
    // Auto-refresh every 30 seconds
    setInterval(checkPendingRequests, 30000);
    // Refresh badge when modal closes
    $('#requestsModal').on('hidden.bs.modal', function() {
      checkPendingRequests();
    });
    $('#editStudentForm').on('submit', function(e) {
      e.preventDefault();
      var form = this;

      // Append user_id dynamically before submit
      if (!$(form).find('input[name="user_id"]').length) {
        $(form).append(`<input type="hidden" name="user_id" value="${userId}">`);
      }

      $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: $(form).serialize(),
        dataType: 'json',
        success: function(response) {
          Swal.fire({
            icon: response.status,
            title: response.status === 'success' ? 'Success' : 'Error',
            text: response.message,
            showConfirmButton: true
          });

          if (response.status === 'success') {
            $('#editStudentModal').modal('hide');
            form.reset(); // Clear form fields
            loadStudents(); // Optional: reload student list
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong!',
          });
        }
      });
    });
    $(document).on('click', '.add-student-btn', function() {
      var sectionId = $(this).data('section-id');

      // Reset form completely
      $('#editStudentForm')[0].reset();

      // Clear stud_id to ensure it's an INSERT
      $('#editStudentForm #stud_id').val('');

      // Remove old hidden fields (except stud_id)
      $('#editStudentForm').find('input[name="section_id"]').remove();
      $('#editStudentForm').find('input[name="user_id"]').remove();

      // Add new hidden fields
      $('#editStudentForm').append(`<input type="hidden" name="section_id" value="${sectionId}">`);
      $('#editStudentForm').append(`<input type="hidden" name="user_id" value="${userId}">`);

      // Open modal
      $('#editStudentModal').modal('show');
    });
    // When Edit button is clicked
    $(document).on('click', '.editStudent', function() {
      var studId = $(this).data('id');

      // Fetch student data from server
      $.ajax({
        url: '<?= base_url("academic/getStudentById") ?>', // create this function in your controller
        type: 'POST',
        data: {
          stud_id: studId
        },
        dataType: 'json',
        success: function(student) {
          var nameParts = student.stud_name.split(',').map(part => part.trim());
          if (student) {
            // Populate the modal fields
            $('#editStudentModal #stud_id').val(student.stud_id);
            $('#editStudentModal #stud_lrn').val(student.stud_lrn);
            $('#editStudentModal #stud_lname').val(nameParts[0] || '');
            $('#editStudentModal #stud_fname').val(nameParts[1] || '');
            $('#editStudentModal #stud_mname').val(nameParts[2] || '');
            $('#editStudentModal #stud_suffix').val(nameParts[3] || '');

            $('#editStudentModal #stud_sex').val(student.stud_sex);
            // Populate birth date
            if (student.stud_birth_date) {
              var parts = student.stud_birth_date.split('-');
              var formattedDate = parts[2] + '-' + parts[0] + '-' + parts[1];
              $('#editStudentModal #stud_birth_date').val(formattedDate);
            } else {
              $('#editStudentModal #stud_birth_date').val('');
            }
            $('#editStudentModal #stud_age').val(student.stud_age);
            $('#editStudentModal #stud_mother_tongue').val(student.stud_mother_tongue);
            $('#editStudentModal #stud_ethnic_group').val(student.stud_ethnic_group);
            $('#editStudentModal #stud_religion').val(student.stud_religion);
            $('#editStudentModal #stud_hssp').val(student.stud_hssp);
            $('#editStudentModal #stud_barangay').val(student.stud_barangay);
            $('#editStudentModal #stud_municipality_city').val(student.stud_municipality_city);
            $('#editStudentModal #stud_province').val(student.stud_province);

            $('#editStudentModal #stud_father_name').val(student.stud_father_name);
            $('#editStudentModal #stud_mother_maiden_name').val(student.stud_mother_name);

            $('#editStudentModal #stud_guardian_name').val(student.stud_guardian_name);
            $('#editStudentModal #stud_guardian_relationship').val(student.stud_guardian_relationship);
            $('#editStudentModal #stud_contact_number').val(student.stud_contact_number);
            $('#editStudentModal #stud_learning_modality').val(student.stud_learning_modality);
            $('#editStudentModal #stud_remarks').val(student.stud_remarks);
            $('#editStudentModal #section_id').val(student.section_id);

            // Show modal
            $('#editStudentModal').modal('show');
          } else {
            Swal.fire('Error', 'Student not found!', 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Something went wrong!', 'error');
        }
      });
    });
    document.getElementById('stud_birth_date').addEventListener('change', function() {
      let birthDate = new Date(this.value);
      let today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      let monthDiff = today.getMonth() - birthDate.getMonth();

      // Adjust if birthday hasn't occurred yet this year
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }

      document.getElementById('stud_age').value = age >= 0 ? age : 0;
    });
    $('#editStudentModal').on('hidden.bs.modal', function() {
      $('#editStudentForm')[0].reset();
      $('#editStudentForm #stud_id').val(''); // Make sure no previous ID lingers
    });

  });
</script>
<script>
  document.getElementById("searchStudent").addEventListener("input", function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#studentInSection table tbody tr');
    let visibleCount = 0;

    rows.forEach(row => {
      // Skip the "No results" row
      if (row.id === 'noResults') return;

      const studentName = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
      const studentLRN = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';

      if (studentName.includes(searchValue) || studentLRN.includes(searchValue)) {
        row.style.display = 'table-row';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    // Show "No students found" if no visible rows
    const noResults = document.getElementById('noResults');
    if (noResults) {
      noResults.classList.toggle('d-none', visibleCount > 0);
    }
  });
</script>