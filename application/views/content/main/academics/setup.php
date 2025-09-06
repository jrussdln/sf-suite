<div class="pb-3">
  <div class="row g-4">
    <div class="col-12 col-xxl-6">
      <div class="mb-3">
        <h3 class="mb-2">Setup</h3>
        <h5 class="text-body-tertiary fw-semibold">Browse and manage active academic year, curriculum, and strand/track offerings.</h5>
      </div>
      <hr class="bg-body-secondary mb-0 mt-1" />
    </div>
  </div>
</div>

<div class="row mb-2 align-items-stretch">
  <div class="col-lg-5 col-md-12 mb-2 d-flex">
    <div class="card shadow-sm h-100 w-100">
      <div class="card-header text-white py-1 px-3 d-flex justify-content-between align-items-center">
        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
          SET ACADEMIC YEAR
        </h1>
        <button type="button"
          class="btn btn-sm"
          id="btnAddYear"
          title="Add Academic Year">
          <i class="uil uil-plus"></i>
        </button>
      </div>

      <div class="card-body text-center">
        <div class="list-group" style="max-height: 350px; overflow-y: auto;">
          <?php if (!empty($academic_years)): ?>
            <?php foreach ($academic_years as $row):
              $term = htmlspecialchars($row['sy_term']);
              $status = strtolower($row['sy_status']); // 'active' or 'inactive'
              $sy_id = $row['sy_id'];
            ?>
              <div class="d-flex align-items-center justify-content-between py-1 px-2 border-bottom">
                <!-- status dot -->
                <div style="flex: 1; text-align: center;">
                  <?php if ($status === 'active'): ?>
                    <span class="badge bg-success rounded-circle p-1" style="width:10px;height:10px;">&nbsp;</span>
                  <?php else: ?>
                    <span class="badge bg-danger rounded-circle p-1" style="width:10px;height:10px;">&nbsp;</span>
                  <?php endif; ?>
                </div>
                <!-- sy_term -->
                <div style="flex: 3; font-size: 14px;">
                  <?= $term ?>
                </div>

                <!-- radio button to select active -->
                <div style="flex: 1; text-align: center;">
                  <input type="radio"
                    name="active_sy_id"
                    value="<?= $sy_id ?>"
                    id="active_<?= $sy_id ?>"
                    <?= $status === 'active' ? 'checked' : '' ?>>
                </div>

                <!-- delete button -->
                <div style="flex: 1; text-align: center;">
                  <button type="button" class="btn btn-lg btn-delete-academicyear"
                    title="Delete"
                    data-id="<?= $sy_id; ?>"
                    data-status="<?= $status ?>">
                    <i class="uil uil-trash-alt"></i>
                  </button>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No academic years found.</p>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
  <div class="col-lg-7 col-md-12 mb-2">
    <div class="card shadow-sm h-100 w-100">
      <div class="card-header text-white py-1 px-3 d-flex justify-content-between align-items-center">
        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
          SET CURRICULUM
        </h1>
        <button type="button"
          class="btn btn-sm"
          id="btnAddCurriculum"
          title="Add Academic Year">
          <i class="uil uil-plus"></i>
        </button>
      </div>
      <div class="card-body">
        <div class="list-group" style="max-height: 350px; overflow-y: auto;">
          <?php if (!empty($all_curriculums)): ?>
            <?php foreach ($all_curriculums as $curriculum): ?>
              <div class=" border rounded-3 shadow-sm p-3 mb-3 position-relative curriculum-card"
                style="transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;">

                <!-- Top right buttons -->
                <div class="position-absolute top-0 end-0 mt-2 me-2 d-flex gap-1">
                  <!-- Toggle -->
                  <button class="btn btn-sm p-1 border-0 bg-transparent toggle-btn"
                    data-id="<?= $curriculum['curriculum_id'] ?>"
                    title="Toggle On/Off">
                    <i class="uil <?= strtolower($curriculum['curriculum_status']) === 'active' ? 'uil-toggle-on text-success' : 'uil-toggle-off text-danger' ?>"></i>
                  </button>

                  <!-- Edit -->
                  <button class="btn btn-sm p-1 border-0 bg-transparent edit-btn"
                    data-id="<?= $curriculum['curriculum_id'] ?>"
                    title="Edit"
                    data-bs-toggle="modal"
                    data-bs-target="#editCurriculumModal">
                    <i class="uil uil-edit text-primary"></i>
                  </button>

                  <!-- Delete -->
                  <button class="btn btn-sm p-1 border-0 bg-transparent btnDeleteCurriculum"
                    title="Delete"
                    data-curriculum_id="<?= $curriculum['curriculum_id'] ?>"
                    data-curriculum_status="<?= $curriculum['curriculum_status'] ?>">
                    <i class="uil uil-trash-alt text-danger"></i>
                  </button>
                </div>

                <!-- Curriculum info -->
                <h6 class="fw-bold text-primary mb-1">
                  <i class="uil uil-book-open me-1"></i>
                  <?= htmlspecialchars($curriculum['curriculum_name']) ?>
                </h6>

                <div class="text-muted small mb-1">
                  <i class="uil uil-label  me-1"></i>
                  <?= htmlspecialchars($curriculum['curriculum_code']) ?>
                </div>


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

            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted small fst-italic">No curriculum found.</p>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="row mb-2">
  <div class="col-lg-12">
    <div class="card shadow-sm h-100">
      <div class="card-header text-white py-1 px-3 d-flex justify-content-between align-items-center">
        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
          SET STRAND/TRACK OFFERINGS
        </h1>
        <button type="button"
          class="btn btn-sm"
          id="addStrandTrackBtn"
          title="Add Strand/Track">
          <i class="uil uil-plus"></i>
        </button>
      </div>
      <div class="card-body">
        <div class="list-group" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">
          <?php if (!empty($all_strands)): ?>
            <div class="row g-3"> <!-- Bootstrap row with gap -->
              <?php foreach ($all_strands as $strand): ?>
                <div class="col-12 col-md-6"> <!-- 1 per row on mobile, 2 per row on md+ -->
                  <div class="border rounded-3 shadow-sm p-3 h-100 position-relative strand-card"
                    style="transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;">

                    <!-- Top right buttons -->
                    <div class="position-absolute top-0 end-0 mt-2 me-2 d-flex gap-1">
                      <!-- Toggle -->
                      <button class="btn btn-sm p-1 border-0 bg-transparent toggle-strand-btn"
                        data-id="<?= $strand['strand_track_id'] ?>"
                        title="Toggle On/Off">
                        <i class="uil <?= strtolower($strand['strand_track_status']) === 'active' ? 'uil-toggle-on text-success' : 'uil-toggle-off text-danger' ?>"></i>
                      </button>

                      <!-- Edit -->
                      <button class="btn btn-sm p-1 border-0 bg-transparent edit-strand-btn"
                        data-id="<?= $strand['strand_track_id'] ?>"
                        title="Edit"
                        data-bs-toggle="modal"
                        data-bs-target="#editStrandModal">
                        <i class="uil uil-edit text-primary"></i>
                      </button>

                      <!-- Delete -->
                      <button class="btn btn-sm p-1 border-0 bg-transparent btnDeleteStrand"
                        title="Delete"
                        data-strand_id="<?= $strand['strand_track_id'] ?>"
                        data-strand_status="<?= $strand['strand_track_status'] ?>">
                        <i class="uil uil-trash-alt text-danger"></i>
                      </button>
                    </div>

                    <!-- Strand info -->
                    <h6 class="fw-bold text-primary mb-1">
                      <i class="uil uil-books me-1"></i>
                      <?= htmlspecialchars(mb_strimwidth($strand['strand_track_name'], 0, 40, '...')) ?>
                    </h6>

                    <div class="text-muted small mb-1">
                      <i class="uil uil-label  me-1"></i>
                      <?= htmlspecialchars($strand['strand_track_code']) ?>
                    </div>

                    <div class="text-muted small fst-italic">
                      <i class="uil uil-file-alt me-1"></i>
                      <?= htmlspecialchars($strand['description'] ?? 'No description') ?>
                    </div>

                    <!-- Status + Date -->
                    <div class="d-flex justify-content-between align-items-center mt-2 small">
                      <span class="status-label <?= strtolower($strand['strand_track_status']) === 'active' ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                        <i class="uil <?= strtolower($strand['strand_track_status']) === 'active' ? 'uil-check-circle' : 'uil-times-circle' ?>"></i>
                        <?= htmlspecialchars($strand['strand_track_status']) ?>
                      </span>

                      <span class="text-secondary">
                        <i class="uil uil-clock me-1"></i> <?= date('M d, Y', strtotime($strand['created_at'])) ?>
                      </span>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-muted small fst-italic">No strand/track found.</p>
          <?php endif; ?>
        </div>
      </div>


    </div>
  </div>
</div>

</div>


<script>
  $(document).ready(function() {
    $('input[name="active_sy_id"]').on('change', function() {
      const selectedSyId = $(this).val();

      Swal.fire({
        title: 'Are you sure?',
        text: "Changing the active academic year will affect the whole system.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Proceed with AJAX update
          $.ajax({
            url: '<?= site_url("academic/updateActiveAcademicYear") ?>',
            method: 'POST',
            data: {
              sy_id: selectedSyId
            },
            success: function(response) {
              Swal.fire({
                title: 'Updated!',
                text: 'Academic year updated successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
              }).then(() => {
                // Optionally reload page or update UI here
                location.reload();
              });
            },
            error: function() {
              Swal.fire({
                title: 'Error!',
                text: 'Failed to update academic year. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
          });
        } else {
          // User cancelled: revert radio to previous state
          // Reload page or manually reset radio buttons as needed
          location.reload();
        }
      });
    });

    $('#btnAddYear').on('click', function() {
      $.ajax({
        url: '<?= site_url("academic/addAcademicYear") ?>',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: 'Academic Year Added',
              text: 'New Academic Year: ' + response.newYear
            }).then(() => {
              location.reload(); // refresh page after adding
            });
          } else {
            Swal.fire({
              icon: 'info',
              title: 'Remainder!',
              text: response.message
            });
          }
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Could not connect to server.'
          });
        }
      });
    });
    document.querySelectorAll('.toggle-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const curriculumId = this.getAttribute('data-id');
        const icon = this.querySelector('i');

        fetch('<?= base_url("academic/toggleCurriculumStatus") ?>', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'curriculum_id=' + encodeURIComponent(curriculumId)
          })
          .then(response => response.json())
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
              location.reload();
            } else {
              alert(data.message || 'Error updating status.');
            }
          })
          .catch(err => console.error(err));
      });
    });
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const curriculumId = this.getAttribute('data-id');

        fetch('<?= base_url("academic/getCurriculum/") ?>' + curriculumId)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              const c = data.data;

              document.getElementById('curriculum_id').value = c.curriculum_id;
              document.getElementById('curriculum_code').value = c.curriculum_code;
              document.getElementById('curriculum_name').value = c.curriculum_name;
              document.getElementById('curriculum_type').value = c.curriculum_type;
              document.getElementById('ec_strand_track_id').value = c.strand_track_id || '';
              document.getElementById('ec_grade_level').value = c.grade_level;
              document.getElementById('curriculum_desc').value = c.curriculum_desc || '';
              document.getElementById('deped_learning_area_code').value = c.deped_learning_area_code || '';
              document.getElementById('competency_code').value = c.competency_code || '';
              document.getElementById('competency_desc').value = c.competency_desc || '';
              document.getElementById('school_year_start').value = c.school_year_start;
              document.getElementById('school_year_end').value = c.school_year_end;

              // 👇 Run toggle after values are set
              toggleStrandTrack();
            } else {
              alert(data.message || 'Error loading curriculum.');
            }
          })
          .catch(err => {
            console.error('Error:', err);
            alert('Could not load curriculum data.');
          });
      });
    });

    // Put this outside so both the DOM load and edit-btn can use it
    const gradeLevelSelect = document.getElementById('ec_grade_level');
    const strandTrackSelect = document.getElementById('ec_strand_track_id');

    function toggleStrandTrack() {
      const gradeVal = gradeLevelSelect.value.trim();
      if (gradeVal === '11-12') {
        strandTrackSelect.disabled = false;
      } else {
        strandTrackSelect.disabled = true;
        strandTrackSelect.value = '';
      }
    }
    document.addEventListener('DOMContentLoaded', function() {
      toggleStrandTrack();
      gradeLevelSelect.addEventListener('change', toggleStrandTrack);
    });

    $(document).on('submit', '#editCurriculumForm', function(e) {
      e.preventDefault();

      $.ajax({
        url: '<?= base_url('academic/saveCurriculum'); ?>',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: response.message || 'Curriculum saved successfully.',
              confirmButtonText: 'OK'
            }).then(() => {
              // Close modal if using Bootstrap modal
              $('#editCurriculumModal').modal('hide');
              // Reload table or page
              location.reload();
            });

          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: response.message || 'Something went wrong.'
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Unable to connect to server.'
          });
        }
      });
    });
    $('#btnAddCurriculum').on('click', function() {
      // Clear form fields
      $('#editCurriculumForm')[0].reset();

      // Make sure ID is empty for add mode
      $('#curriculum_id').val('');
      // Show modal
      $('#editCurriculumModal').modal('show');
    });
    // Toggle strand status
    $(document).on('click', '.toggle-strand-btn', function() {
      let strandId = $(this).data('id');
      let btn = $(this);

      $.ajax({
        url: '<?= base_url('academic/toggleStrand'); ?>', // Adjust to your route
        type: 'POST',
        data: {
          strand_id: strandId
        },
        dataType: 'json',
        beforeSend: function() {
          btn.prop('disabled', true);
        },
        success: function(response) {
          if (response.success) {
            // Flip the icon and color without reload
            let icon = btn.find('i');
            if (icon.hasClass('uil-toggle-on')) {
              icon.removeClass('uil-toggle-on text-success')
                .addClass('uil-toggle-off text-danger');
              btn.closest('.border').find('span.text-success')
                .removeClass('text-success')
                .addClass('text-danger')
                .text('Inactive');
            } else {
              icon.removeClass('uil-toggle-off text-danger')
                .addClass('uil-toggle-on text-success');
              btn.closest('.border').find('span.text-danger')
                .removeClass('text-danger')
                .addClass('text-success')
                .text('Active');
            }
            location.reload(); // Optional — replace with table refresh if needed
          } else {
            alert(response.message);
          }
        },
        complete: function() {
          btn.prop('disabled', false);
        }
      });
    });

    let deleteType = null;
    let deleteId = null;
    let elementToRemove = null;

    // Common: open password modal
    $(document).on('click', '.btn-delete-academicyear, .btnDeleteStrand, .btnDeleteCurriculum', function() {
      // Get status from data attributes
      const syStatus = $(this).data('status'); // academic year
      const curriculumStatus = $(this).data('curriculum_status');
      const strandStatus = $(this).data('strand_status');

      // Prevent deletion if any relevant status is active
      if (syStatus && syStatus.toLowerCase() === 'active') {
        Swal.fire('Warning', 'You cannot delete an active school year.', 'warning');
        return;
      }
      if (curriculumStatus && curriculumStatus.toLowerCase() === 'active') {
        Swal.fire('Warning', 'You cannot delete an active curriculum.', 'warning');
        return;
      }
      if (strandStatus && strandStatus.toLowerCase() === 'active') {
        Swal.fire('Warning', 'You cannot delete an active strand/track.', 'warning');
        return;
      }

      // Determine type and ID
      if ($(this).hasClass('btn-delete-academicyear')) {
        deleteType = 'academic_year';
        deleteId = $(this).data('id');
      } else if ($(this).hasClass('btnDeleteStrand')) {
        deleteType = 'strand';
        deleteId = $(this).data('strand_id');
        elementToRemove = $(this).closest('.border');
      } else if ($(this).hasClass('btnDeleteCurriculum')) {
        deleteType = 'curriculum';
        deleteId = $(this).data('curriculum_id');
      }

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
            confirmAndDelete();
          } else {
            Swal.fire('Error', 'Incorrect password.', 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Failed to verify password.', 'error');
        }
      });
    });

    // Confirm + Delete based on type
    function confirmAndDelete() {
      let title, text, url, postData;

      if (deleteType === 'academic_year') {
        title = 'Delete Academic Year?';
        text = "You won't be able to revert this!";
        url = '<?= base_url("academic/deleteAcademicYear"); ?>';
        postData = {
          sy_id: deleteId
        };
      } else if (deleteType === 'strand') {
        title = 'Delete Strand/Track?';
        text = "This will permanently delete the strand/track.";
        url = '<?= base_url("academic/deleteStrand"); ?>';
        postData = {
          strand_id: deleteId
        };
      } else if (deleteType === 'curriculum') {
        title = 'Delete Curriculum?';
        text = "This will permanently delete the curriculum.";
        url = '<?= base_url("academic/delete"); ?>';
        postData = {
          curriculum_id: deleteId
        };
      }

      Swal.fire({
        title,
        text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url,
            method: 'POST',
            data: postData,
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                Swal.fire('Deleted!', response.message || 'Deleted successfully.', 'success')
                  .then(() => {
                    if (deleteType === 'strand' && elementToRemove) {
                      elementToRemove.fadeOut(300, function() {
                        $(this).remove();
                      });
                    } else {
                      location.reload();
                    }
                  });
              } else {
                Swal.fire('Error!', response.message || 'Deletion failed.', 'error');
              }
            },
            error: function() {
              Swal.fire('Error!', 'An error occurred while deleting.', 'error');
            }
          });
        }
      });
    }
    // Add Strand Track button
    $('#addStrandTrackBtn').on('click', function() {
      $('#strand_track_id').val('');
      $('#editStrandForm')[0].reset();
      $('#editStrandModalLabel').text('Add Strand/Track');
      $('#editStrandModal').modal('show');
    });
    // Edit Strand Track butto
    $(document).on('click', '.edit-strand-btn', function() {
      const id = $(this).data('id');

      $.ajax({
        url: '<?= base_url("academic/getStrandTrack") ?>',
        method: 'GET',
        data: {
          strand_track_id: id
        },
        dataType: 'json',
        success: function(data) {
          if (data) {
            $('#strand_track_id').val(data.strand_track_id);
            $('#strand_track_name').val(data.strand_track_name);
            $('#strand_track_code').val(data.strand_track_code);
            $('#description').val(data.description);
            $('#editStrandModalLabel').text('Edit Strand/Track');
            $('#editStrandModal').modal('show');
          } else {
            Swal.fire('Error', 'No data found for this Strand/Track.', 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Unable to load strand/track data.', 'error');
        }
      });
    });
    $('#editStrandForm').on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
          Swal.fire({
            icon: response.status,
            title: response.status === 'success' ? 'Success' : 'Error',
            text: response.message,
            confirmButtonText: 'OK' // ✅ Add OK button
          }).then(() => {
            if (response.status === 'success') {
              $('#editStrandModal').modal('hide');
              location.reload(); // Optional — replace with table refresh if needed
            }
          });
        },
        error: function() {
          Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
        }
      });
    });

  });
</script>