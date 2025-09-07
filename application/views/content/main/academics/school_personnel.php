<div class="pb-3">
  <div class="row g-4">
    <div class="col-12 col-xxl-6">
      <div class="mb-2 d-flex align-items-center gap-2">
        <i class="uil uil-users-alt text-primary" style="font-size: 1.4rem;"></i>
        <h4 class="fw-semibold mb-0">School Personnel Management</h4>
      </div>
      <hr class="bg-body-secondary mb-0 mt-2" />
    </div>
  </div>
</div>

<div class="row mb-2 align-items-stretch">
  <div class="col-lg-5 col-md-12 mb-2 d-none d-md-block"> <!-- 👈 hide whole column on mobile -->
    <div class="card shadow-sm h-100 w-100">
      <div class="card-header text-white py-1 px-3 bg-primary">
        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
        </h1>
      </div>
      <div class="card-body text-center"
        style="height: calc(85vh - 85px); overflow-y: auto; overflow-x: hidden;">
        <!-- Profile Image -->
        <div class="position-relative d-inline-block mb-1">
          <img id="personnelAvatarCard" class="rounded-circle border border-3 border-primary"
            src="<?= base_url('assets/img/logos/profile_logo.png') ?>"
            alt="Profile Picture" width="100" height="100">

          <!-- Status Dot -->
          <div class="position-absolute bottom-0 end-0 translate-middle 
        bg-success border border-2 border-white rounded-circle"
            style="width: 20px; height: 20px; cursor: pointer;">
          </div>
        </div>
        <div class=" p-4 mb-0">
          <!-- Name & Role -->
          <div class="mb-1 text-center">
            <!-- Personnel Name -->
            <h5 id="personnelNameCard" class="fw-bold mb-1">
              <i class="uil uil-user me-2 text-primary"></i>
              Select a Personnel
            </h5>

            <!-- Role -->
            <p id="personnelRoleCard" class="text-muted small mb-1">
              <i class="uil uil-briefcase-alt me-2 text-secondary"></i>
              ---
            </p>

            <!-- Advisory Section -->
            <p id="personnelAdvisoryCard" class="text-muted small mb-0">
              <i class="uil uil-users-alt me-2 text-secondary"></i>
              ---
            </p>
          </div>

          <!-- Ancillary Profile Section -->
          <div id="selectedAncillaryProfile" class="p-2 rounded mb-1">
            <div id="selectedAncItemsProfile" class="d-flex flex-wrap gap-1 justify-content-center align-items-center">
              ---
            </div>
          </div>

          <!-- Personnel Statistics -->
          <dl class="row g-2 mb-1 text-start">
            <dt class="col-8 text-muted small">User Account Status</dt>
            <dd class="col-4 fw-semibold small text-end" id="personnelAccountStatusCard">---</dd>

            <dt class="col-8 text-muted small">Ancillary Assignments</dt>
            <dd class="col-4 fw-semibold small text-end" id="personnelAncillaryCountCard">---</dd>

            <dt class="col-8 text-muted small">Teaching Loads</dt>
            <dd class="col-4 fw-semibold small text-end" id="personnelLoadsCountCard">---</dd>

            <dt class="col-8 text-muted small">Avg. Teaching Minutes/Week</dt>
            <dd class="col-4 fw-semibold small text-end" id="personnelAverageTeachingCard">---</dd>
          </dl>

          <!-- Action Buttons -->
          <div class="d-grid gap-1 mb-1">
            <button id="personnelDefaultBtn" class="btn btn-success d-flex align-items-center justify-content-center gap-2">
              Select a personnel
            </button>
            <button id="personnelCreateAccountBtn" class="btn btn-success d-flex align-items-center justify-content-center gap-2 d-none">
              <i class="fas fa-user-plus"></i> Create Account
            </button>
            <button id="personnelBlockAccountBtn" class="btn btn-danger d-flex align-items-center justify-content-center gap-2 d-none">
              <i class="fas fa-user-slash"></i> Block
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-7 col-md-12 mb-2">
    <div class="card shadow-sm h-100 w-100 d-flex flex-column">
      <!-- Nav Tabs -->
      <nav class="nav nav-tabs flex-nowrap w-100 d-flex border-bottom">
        <button class="nav-link active flex-fill text-center" type="button" data-tab="sp_list">
          <i class="uil uil-list-ul"></i>
        </button>
        <button class="nav-link flex-fill text-center" type="button" data-tab="account_information" title="Select a personnel.">
          <i class="uil uil-exclamation-circle"></i>
        </button>
        <button class="nav-link flex-fill text-center" type="button" data-tab="settings">
          <i class="uil uil-cog"></i>
        </button>
      </nav>


      <!-- Card Body -->
      <div class="card-body flex-grow-1" style="height: calc(85vh - 85px); overflow-y: auto; overflow-x: hidden;">
        <div class="rounded-xl shadow-md p-1">
          <!-- School Personnel List -->
          <div class="tab-content" id="tab-sp_list">
            <div class="row align-items-center mb-3 sticky-top p-1" style="z-index: 10; top: 0;">
              <!-- Search Box -->
              <div class="col">
                <input type="text"
                  id="searchPersonnel"
                  class="form-control form-control-sm rounded-pill"
                  placeholder="🔍 Search personnel by name, email, or specialization...">
              </div>
              <!-- Register Button -->
              <div class="col-auto">
                <button type="button" class="btn btn-primary rounded-pill px-3" id="addPersonnelBtn">
                  <i class="uil uil-user-plus"></i>
                </button>
              </div>
            </div>
            <?php if (!empty($all_personnel)): ?>
              <?php foreach ($all_personnel as $person): ?>
                <div class="card border rounded-3 shadow-sm mb-2 personnel-card"
                  data-id="<?= $person['sp_id']; ?>"
                  style="cursor: pointer; font-size: 0.8rem;">
                  <div class="card-body py-2 px-2">
                    <div class="d-flex justify-content-between align-items-center">
                      <!-- Avatar + Full Name -->
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-m me-3">
                          <img class="rounded-circle"
                            src="<?= base_url('assets/img/logos/profile_logo.png') ?>"
                            alt="User Avatar" width="48" height="48" />
                        </div>
                        <div class="d-flex flex-column">
                          <span class="fw-semibold personnel-name"><?= htmlspecialchars($person['full_name']); ?></span>
                          <small class="text-muted">
                            <i class="uil uil-envelope-alt me-1"></i> <?= htmlspecialchars($person['sp_email'] ?? 'No email'); ?>
                          </small>
                        </div>
                      </div>

                      <!-- Status & Info -->
                      <div class="d-flex align-items-center gap-2">

                        <small class="text-muted"><i class="uil uil-briefcase-alt me-1"></i><?= htmlspecialchars($person['sp_employment_status'] ?? 'Unknown'); ?></small>
                        <span class="d-inline-block rounded-circle bg-<?= ($person['sp_status'] === 'Active') ? 'success' : 'danger'; ?>"
                          style="width: 10px; height: 10px;" title="<?= $person['sp_status']; ?>">
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <div id="noResults" class="alert border text-center d-none">No personnel found.</div>
            <?php else: ?>
              <div class="alert alert-info m-2">No personnel found.</div>
            <?php endif; ?>

          </div>
          <!-- Contact Info Tab -->
          <div class="tab-content d-none" id="tab-account_information">
            <div class="card border-0 rounded-3 p-1">
              <!-- Stepper Progress -->
              <div id="formStepper" class="d-flex sticky-top justify-content-between align-items-center mb-1"></div>
              <form id="personnelForm" class="row g-3">
                <input type="hidden" id="personnelId" name="sp_id">
                <!-- STEP 1 -->
                <div id="form-step-1" class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">ID No</label>
                    <input type="text" id="sp_no" name="sp_no" class="form-control form-control-sm" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" id="sp_email" name="sp_email" class="form-control form-control-sm" required>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" id="sp_lname" name="sp_lname" class="form-control form-control-sm" required>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" id="sp_fname" name="sp_fname" class="form-control form-control-sm" required>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Middle Name</label>
                    <input type="text" id="sp_mname" name="sp_mname" class="form-control form-control-sm">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Extension</label>
                    <input type="text" id="sp_ename" name="sp_ename" class="form-control form-control-sm">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label">Sex</label>
                    <select id="sp_sex" name="sp_sex" class="form-select form-select-sm" required>
                      <option value="">Select</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label">Fund Source</label>
                    <select id="sp_fund_source" name="sp_fund_source" class="form-select form-select-sm">
                      <option value="">— Select Fund Source —</option>
                      <option value="MOOE">MOOE</option>
                      <option value="SEF">SEF</option>
                      <option value="National">National</option>
                      <option value="LGU">LGU</option>
                      <option value="Others">Others</option>
                    </select>
                  </div>

                  <div class="col-md-4 mb-1">
                    <label class="form-label">Birth Date</label>
                    <input type="date" id="sp_birth_date" name="sp_birth_date" class="form-control form-control-sm" required>
                  </div>

                  <div class="col-12 d-flex justify-content-between sticky-bottom">
                    <div>
                      <button type="button" id="backBtnMain" class="nav-link btn btn-secondary btn-sm px-4" data-tab="sp_list">
                        <i class="uil uil-arrow-left"></i>
                      </button>
                    </div>
                    <div class="d-flex gap-2">
                      <button type="button" id="nextBtn" class="btn btn-primary btn-sm px-4">
                        <i class="uil uil-arrow-right"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <!-- STEP 2 (Hidden by Default) -->
                <div id="form-step-2" class="row g-3 d-none">
                  <div class="col-md-4">
                    <label class="form-label">Employment Status</label>
                    <select id="sp_employment_status" name="sp_employment_status" class="form-select form-select-sm">
                      <option value="">— Select Status —</option>
                      <option value="Permanent">Permanent</option>
                      <option value="Probationary">Probationary</option>
                      <option value="Contractual">Contractual</option>
                      <option value="Part-time">Part-time</option>
                      <option value="Substitute">Substitute</option>
                      <option value="Casual">Casual</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label">Educational Degree</label>
                    <select id="sp_educ_degree" name="sp_educ_degree" class="form-select form-select-sm">
                      <option value="">— Select Degree —</option>
                      <option value="BEEd">BEEd</option>
                      <option value="BSEd">BSEd</option>
                      <option value="AB/BS">AB/BS</option>
                      <option value="MAEd">MAEd</option>
                      <option value="MSEd">MSEd</option>
                      <option value="PhD/EdD">Doctorate</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Advisory Class</label>
                    <select id="sp_advisory" name="sp_advisory" class="form-select form-select-sm border border-warning">
                      <option value="">No Advisory Class</option>
                      <?php foreach ($all_advisory as $sections): ?>
                        <option value="<?= htmlspecialchars($sections['section_id']); ?>"
                          data-has-adviser="<?= !empty($sections['adviser_name']) ? '1' : '0'; ?>">
                          <?= htmlspecialchars($sections['section_name']); ?>
                          <?= !empty($sections['adviser_name']) ? ' - ' . htmlspecialchars($sections['adviser_name']) : ''; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Major</label>
                    <select id="sp_educ_major" name="sp_educ_major" class="form-select form-select-sm">
                      <option value="">— Select Major —</option>
                      <option value="English">English</option>
                      <option value="Filipino">Filipino</option>
                      <option value="Mathematics">Mathematics</option>
                      <option value="Science">Science</option>
                      <option value="Social Studies">Social Studies</option>
                      <option value="MAPEH">MAPEH</option>
                      <option value="TLE">TLE</option>
                      <option value="ICT">ICT</option>
                      <option value="Values Education">Values Education</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Minor</label>
                    <select id="sp_educ_minor" name="sp_educ_minor" class="form-select form-select-sm">
                      <option value="">— Select Minor —</option>
                      <option value="English">English</option>
                      <option value="Filipino">Filipino</option>
                      <option value="Mathematics">Mathematics</option>
                      <option value="Science">Science</option>
                      <option value="Social Studies">Social Studies</option>
                      <option value="MAPEH">MAPEH</option>
                      <option value="TLE">TLE</option>
                      <option value="ICT">ICT</option>
                      <option value="Values Education">Values Education</option>
                      <option value="None">None</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Post Graduate</label>
                    <select id="sp_post_graduate" name="sp_post_graduate" class="form-select form-select-sm">
                      <option value="">— Select Post Graduate —</option>
                      <option value="MAEd">MAEd</option>
                      <option value="MSEd">MSEd</option>
                      <option value="PhD">PhD</option>
                      <option value="EdD">EdD</option>
                      <option value="Others">Others</option>
                      <option value="None">None</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Specialization</label>
                    <select id="sp_specialization" name="sp_specialization" class="form-select form-select-sm">
                      <option value="">— Select Specialization —</option>
                      <option value="Kindergarten">Kindergarten</option>
                      <option value="Elementary">Elementary</option>
                      <option value="Junior High School">Junior High School</option>
                      <option value="Senior High School">Senior High School</option>
                      <option value="SPED">SPED</option>
                      <option value="ALS">ALS</option>
                      <option value="Others">Others</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Plantilla Position</label>
                    <select id="sp_position" name="sp_position" class="form-select form-select-sm">
                      <option value="">— Select Plantilla Position —</option>
                      <?php foreach ($all_plantilla as $positions): ?>
                        <option value="<?= htmlspecialchars($positions['pp_id']); ?>">
                          <?= htmlspecialchars($positions['pp_desc']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select id="sp_status" name="sp_status" class="form-select form-select-sm">
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>

                  <!-- Back, Next & Save Buttons -->
                  <div class="col-12 d-flex justify-content-between mt-3 sticky-bottom">
                    <!-- Left: Back button -->
                    <div>
                      <button type="button" id="backBtn" class="btn btn-secondary btn-sm px-4">
                        <i class="uil uil-arrow-left"></i>
                      </button>
                    </div>
                    <!-- Right: Next and Save buttons -->
                    <div class="d-flex gap-2">
                      <button type="submit" class="btn btn-success btn-sm px-4">
                        <i class="uil uil-save me-1"></i>
                      </button>
                      <button type="button" id="nextBtnAA" class="btn btn-primary btn-sm px-4 d-none">
                        <i class="uil uil-arrow-right"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
              <!-- STEP 3 -->
              <div class="row g-3">
                <div id="form-step-3" class="row g-3 d-none">
                  <!-- Search Box -->
                  <div class="mb-1 sticky-top p-1" style="z-index: 10; top: 0;">
                    <input type="text"
                      id="searchAncillary"
                      class="form-control form-control-sm rounded-pill"
                      placeholder="🔍 Search ancillary assignments">
                  </div>

                  <div id="ancillaryListContainer" class="overflow-hidden position-relative" style="height: 75px;">

                    <!-- Row 1: normal order, scroll left → -->
                    <div id="ancRow1" class="anc-row animate-left d-flex gap-2">
                      <?php foreach ($all_ancillary as $anc): ?>
                        <div class="p-2 border rounded small ancillary-item" data-id="<?= $anc['aa_id']; ?>">
                          <?= htmlspecialchars($anc['aa_desc']); ?>
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <!-- Row 2: reversed order, scroll right ← -->
                    <div id="ancRow2" class="anc-row animate-right d-flex gap-2 mt-1">
                      <?php foreach (array_reverse($all_ancillary) as $anc): ?>
                        <div class="p-2 border rounded small ancillary-item" data-id="<?= $anc['aa_id']; ?>">
                          <?= htmlspecialchars($anc['aa_desc']); ?>
                        </div>
                      <?php endforeach; ?>
                    </div>

                  </div>

                  <!-- Label -->
                  <h6 class="fst-italic text-muted">Selected Ancillary Assignments:</h6>

                  <!-- Selected Ancillary Container -->
                  <div id="selectedAncillary" class="p-1">
                    <!-- Selected Items -->
                    <div id="selectedAncItems" class="d-flex flex-wrap gap-1 justify-content-left align-items-start">
                      <!-- Selected items will be dynamically inserted here -->
                    </div>
                  </div>

                  <!-- Back, Next & Save Buttons -->
                  <div class="col-12 d-flex justify-content-between mt-13 sticky-bottom">
                    <!-- Left: Back button -->
                    <div>
                      <button type="button" id="backBtnAA" class="btn btn-secondary btn-sm px-4">
                        <i class="uil uil-arrow-left"></i>
                      </button>
                    </div>

                    <!-- Save Ancillary Button -->
                    <div class="d-flex gap-2">
                      <button type="button" id="nextBtnTL" class="btn btn-primary btn-sm px-4">
                        <i class="uil uil-arrow-right"></i>
                      </button>
                    </div>

                  </div>
                </div>
                <div id="form-step-4" class="row g-3 d-none">
                  <!-- Teaching Load Add Row -->
                  <div class="card col-12 border-0 d-none sticky-top" id="teachingLoadAddRow">
                    <form id="teachingLoadForm">
                      <!-- Hidden Inputs -->
                      <input type="hidden" name="sp_id" id="sp_id">
                      <input type="hidden" name="tl_id" id="tl_id">

                      <div class="row align-items-center g-2">
                        <!-- Grade Level -->
                        <div class="col-md-4">
                          <!-- Subject Select -->
                          <select name="subject_id" class="form-select form-select-sm" id="subjectSelect" required>
                            <option value="">--</option>
                            <?php foreach ($all_subjects as $subjects): ?>
                              <?php
                              $level = '';
                              $grade_range = '';
                              if ($subjects['subject_grade'] === '7-10') {
                                $level = 'JHS';
                                $grade_range = '7-10';
                              } elseif ($subjects['subject_grade'] === '11-12') {
                                $level = 'SHS';
                                $grade_range = '11-12';
                              } else {
                                $level = $subjects['subject_grade'];
                                $grade_range = $subjects['subject_grade'];
                              }
                              ?>
                              <option value="<?= htmlspecialchars($subjects['subject_id']); ?>" data-grade-range="<?= $grade_range; ?>">
                                <?= htmlspecialchars($subjects['subject_name']); ?> - <?= htmlspecialchars($level); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>

                        </div>

                        <!-- Start -->
                        <div class="col-md-4">
                          <input type="time" name="tl_start" class="form-control form-control-sm" required>
                        </div>

                        <!-- End -->
                        <div class="col-md-4">
                          <input type="time" name="tl_end" class="form-control form-control-sm" required>
                        </div>
                      </div>

                      <!-- Row 2: Days, Grade Level, Submit -->
                      <div class="row align-items-center g-2 mt-2">
                        <!-- Days -->
                        <div class="col-md-6 d-flex justify-content-between">
                          <button type="button" class="btn btn-outline-primary btn-sm rounded-circle day-btn" data-day="mon"
                            style="width:28px; height:28px; font-size:10px; padding:0;">M</button>
                          <button type="button" class="btn btn-outline-primary btn-sm rounded-circle day-btn" data-day="tue"
                            style="width:28px; height:28px; font-size:10px; padding:0;">T</button>
                          <button type="button" class="btn btn-outline-primary btn-sm rounded-circle day-btn" data-day="wed"
                            style="width:28px; height:28px; font-size:10px; padding:0;">W</button>
                          <button type="button" class="btn btn-outline-primary btn-sm rounded-circle day-btn" data-day="thu"
                            style="width:28px; height:28px; font-size:10px; padding:0;">Th</button>
                          <button type="button" class="btn btn-outline-primary btn-sm rounded-circle day-btn" data-day="fri"
                            style="width:28px; height:28px; font-size:10px; padding:0;">F</button>
                          <button type="button" class="btn btn-outline-primary btn-sm rounded-circle day-btn" data-day="sat"
                            style="width:28px; height:28px; font-size:10px; padding:0;">Sat</button>
                          <button type="button" class="btn btn-outline-primary btn-sm rounded-circle day-btn" data-day="sun"
                            style="width:28px; height:28px; font-size:10px; padding:0;">Sun</button>
                        </div>


                        <!-- Grade Level Select -->
                        <div class="col-md-4">
                          <select name="tl_grade_level" class="form-select form-select-sm" id="gradeLevelSelect" required>
                            <option selected disabled>Grade Level</option>
                          </select>
                        </div>


                        <!-- Submit Button -->
                        <div class="col-md-2 d-grid">
                          <button type="button" id="addTeachingLoads" class="btn btn-success btn-sm">Add</button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <!-- Teaching Loads Display Container -->
                  <div class="col-12" id="teachingLoadsContainer">
                    <!-- Teaching loads will be appended here -->
                  </div>

                  <!-- Back, Next & Save Buttons -->
                  <div class="col-12 d-flex justify-content-between mt-10 sticky-bottom">
                    <div>
                      <button type="button" id="backBtnTL" class="btn btn-secondary btn-sm px-4">
                        <i class="uil uil-arrow-left"></i>
                      </button>
                    </div>
                    <div class="d-flex gap-2">
                      <button type="button" id="showAddFormBtn" class="btn btn-primary">+</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Assignments Tab -->
          <div class="tab-content d-none" id="tab-settings">
            <!-- Stepper Progress -->
            <div id="formStepperSettings" class="d-flex justify-content-between align-items-center mb-1"></div>
            <div class="card border-0 rounded-3 p-1">
              <!-- STEP 1 -->
              <div id="form-step-settings-1" class="container-fluid g-3 p-0">
                <!-- Search & Add Button -->
                <div class="sticky-top p-2 bg-white" style="z-index: 10; top: 0;">
                  <div class="d-flex flex-nowrap align-items-center gap-2">
                    <!-- Search Box -->
                    <div class="flex-grow-1">
                      <input type="text"
                        id="searchPlantilla"
                        class="form-control form-control-sm rounded-pill"
                        placeholder="🔍 Search plantilla by description or code...">
                    </div>
                    <!-- Buttons -->
                    <div class="d-flex flex-shrink-0 gap-1">
                      <button type="button" class="btn btn-primary rounded-pill px-3" id="addPlantillaBtn">
                        <i class="uil uil-user-plus"></i>
                      </button>
                      <button type="button" class="btn btn-primary rounded-pill px-3" id="nextBtnPL">
                        <i class="uil uil-arrow-right"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Plantilla Position Form -->
                <form id="plantillaPositionForm" class="mb-3 p-2 border-0 d-none">
                  <div class="row g-2">

                    <input type="hidden" class="form-control form-control-sm" id="pp_pp_id" name="pp_pp_id">

                    <div class="col-md-6">
                      <label for="pp_pp_desc" class="form-label">Description</label>
                      <input type="text" class="form-control form-control-sm" id="pp_pp_desc" name="pp_pp_desc" required>
                    </div>


                    <div class="col-md-6">
                      <label for="pp_pp_code" class="form-label">Code</label>
                      <input type="text" class="form-control form-control-sm" id="pp_pp_code" name="pp_pp_code" required>
                    </div>
                    <div class="col-md-4">
                      <label for="pp_pp_rank" class="form-label">Rank</label>
                      <input type="number" class="form-control form-control-sm" id="pp_pp_rank" name="pp_pp_rank" readonly>
                    </div>
                    <div class="col-md-4">
                      <label for="pp_pp_category" class="form-label">Category</label>
                      <select class="form-select form-select-sm" id="pp_pp_category" name="pp_pp_category" required>
                        <option value="" disabled selected>Select category</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                      </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                      <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="uil uil-check-circle"></i> Save
                      </button>
                    </div>

                  </div>
                </form>
                <!-- Plantilla List -->
                <div id="plantillaList" class="d-flex flex-column gap-2 mt-3"></div>
                <div id="noPlantillaResults" class="d-none text-center p-2">No results found.</div>
              </div>
              <!-- STEP 2 (Hidden by Default) -->
              <div id="form-step-settings-2" class="row g-3 d-none">
                <!-- Search & Add Button -->
                <div class="sticky-top p-2 bg-white" style="z-index: 10; top: 0;">
                  <div class="d-flex flex-nowrap align-items-center gap-2">
                    <!-- Search Box -->
                    <div class="flex-grow-1">
                      <input type="text"
                        id="searchAncillaryList"
                        class="form-control form-control-sm rounded-pill"
                        placeholder="🔍 Search ancillary by description or code...">
                    </div>
                    <!-- Buttons -->
                    <div class="d-flex flex-shrink-0 gap-1">
                      <button type="button" class="btn btn-primary rounded-pill px-3" id="addAncillaryBtn">
                        <i class="uil uil-user-plus"></i>
                      </button>
                      <button type="button" class="btn btn-primary rounded-pill px-3" id="backBtnAL">
                        <i class="uil uil-arrow-left"></i>
                      </button>
                      <button type="button" class="btn btn-primary rounded-pill px-3" id="nextBtnAL">
                        <i class="uil uil-arrow-right"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Plantilla Position Form -->
                <form id="ancillaryAssignmentListForm" class="mb-3 p-2 border-0 d-none">
                  <div class="row g-2">

                    <input type="hidden" class="form-control form-control-sm" id="aa_aa_id" name="aa_aa_id">

                    <div class="col-md-8">
                      <label for="pp_pp_desc" class="form-label">Description</label>
                      <input type="text" class="form-control form-control-sm" id="aa_aa_desc" name="aa_aa_desc" required>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                      <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="uil uil-check-circle"></i> Save
                      </button>
                    </div>

                  </div>
                </form>

                <!-- Plantilla List -->
                <div id="ancillaryAssignmentList" class="d-flex flex-column gap-2"></div>
                <div id="noAncillaryResults" class="d-none text-center p-2">No results found.</div>
              </div>
              <div id="form-step-settings-3" class="row g-3 d-none">
                <div class="d-flex align-items-center mb-0 sticky-top p-2" style="z-index: 10; top: 0; ">
                  <!-- Search Box -->
                  <div class="flex-grow-1 me-2">
                    <input type="text"
                      class="form-control form-control-sm rounded-pill"
                      placeholder="Inheritance of data from Current School Year to Other School Year." disabled>
                  </div>

                  <div>

                    <button type="button" class="btn btn-primary rounded-pill px-3" id="backBtnC">
                      <i class="uil uil-arrow-left"></i>
                    </button>

                  </div>
                </div>
                <!-- Inherit Ancillary -->
                <div class="col-12">
                  <div class="p-3 border rounded shadow-sm mb-0">
                    <!-- Header -->
                    <div class="d-flex align-items-center mb-0 flex-wrap">
                      <i class="uil uil-copy-alt text-primary fs-4 me-2"></i>
                      <div style="line-height: 1.1;"> <!-- reduced line spacing -->
                        <div class="fw-semibold">Inherit Ancillary Assignments</div>
                        <small class="text-muted"><?= isset($active_sy) ? $active_sy : 'N/A'; ?></small>
                      </div>
                    </div>

                    <!-- Controls -->
                    <div class="row g-2 align-items-end">
                      <!-- Select -->
                      <div class="col-12 col-md-9">
                        <label for="iaa_school_year" class="form-label small fw-semibold mb-1">Select School Year</label>
                        <select class="form-select form-select-sm" id="iaa_school_year">
                          <option value="">-- Select School Year--</option>
                          <?php foreach ($academic_years as $year): ?>
                            <option value="<?= htmlspecialchars($year['sy_id']) ?>"><?= htmlspecialchars($year['sy_term']) ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <!-- Buttons -->
                      <div class="col-12 col-md-3 d-flex justify-content-md-end justify-content-start gap-2 mt-2 mt-md-0">
                        <button class="btn btn-outline-primary btn-sm px-3 w-100 w-md-auto" id="iaaCustomizeBtn">Customize</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Inherit Teaching Loads -->
                <div class="col-12">
                  <div class="p-3 border rounded shadow-sm mb-0">
                    <div class="d-flex align-items-center mb-0 flex-wrap">
                      <i class="uil uil-copy-alt text-success fs-4 me-2"></i>
                      <div style="line-height: 1.1;"> <!-- reduced line spacing -->
                        <div class="fw-semibold">Inherit Teaching Loads</div>
                        <small class="text-muted"><?= isset($active_sy) ? $active_sy : 'N/A'; ?></small>
                      </div>
                    </div>


                    <!-- Controls -->
                    <div class="row g-2 align-items-end">
                      <!-- Select -->
                      <div class="col-12 col-md-9">
                        <label for="itl_school_year" class="form-label small fw-semibold mb-1">Select School Year</label>
                        <select class="form-select form-select-sm" id="itl_school_year">
                          <option value="">-- Select School Year--</option>
                          <?php foreach ($academic_years as $year): ?>
                            <option value="<?= htmlspecialchars($year['sy_id']) ?>"><?= htmlspecialchars($year['sy_term']) ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <!-- Buttons -->
                      <div class="col-12 col-md-3 d-flex justify-content-md-end justify-content-start gap-2 mt-2 mt-md-0">
                        <button class="btn btn-outline-success btn-sm px-3 w-100 w-md-auto" id="itlCustomizeBtn">Customize</button>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div id="form-step-settings-4" class="row g-3 d-none">
                <!-- Search & Add Button -->
                <div class="d-flex align-items-center mb-0 sticky-top p-2" style="z-index: 10; top: 0; ">
                  <!-- Search Box -->
                  <div class="flex-grow-1 me-2">
                    <input type="text"
                      id="searchAa"
                      class="form-control form-control-sm rounded-pill"
                      placeholder="🔍 Search ancillary by name or assignment...">
                  </div>
                  <!-- Register Button -->
                  <div>
                    <button type="button" class="btn btn-primary rounded-pill px-3" id="backBtnIC">
                      <i class="uil uil-arrow-left"></i>
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-3" id="iaaInheritBtn">
                      <i class="uil uil-copy-alt"></i>
                    </button>

                  </div>
                </div>
                <div class="col-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle" style="font-size: 12px;" id="customizeTable">
                      <thead class="table-responsive">
                        <tr>
                          <th style="padding: 5px;">#</th>
                          <th style="padding: 5px;">Name</th>
                          <th style="padding: 5px;">Ancillary Assignment</th>
                          <th style="padding: 5px; width: 30px;">
                            <input type="checkbox" id="selectAllInherit">
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
              <div id="form-step-settings-5" class="row g-3 d-none">
                <!-- Search & Add Button -->
                <div class="d-flex align-items-center mb-0 sticky-top p-2" style="z-index: 10; top: 0; ">
                  <!-- Search Box -->
                  <div class="flex-grow-1 me-2">
                    <input type="text"
                      id="searchTl"
                      class="form-control form-control-sm rounded-pill"
                      placeholder="🔍 Search teaching loads by personnel name...">
                  </div>
                  <!-- Register Button -->
                  <div>
                    <button type="button" class="btn btn-success rounded-pill px-3" id="backBtnIC">
                      <i class="uil uil-arrow-left"></i>
                    </button>
                    <button type="button" class="btn btn-success rounded-pill px-3" id="itlInheritBtn">
                      <i class="uil uil-copy-alt"></i>
                    </button>

                  </div>
                </div>

                <div class="col-12">
                  <div class="table-responsive">

                    <table class="table table-bordered table-sm text-center align-middle" style="font-size: 12px;" id="customizeTeachingLoad">
                      <thead class="table-responsive">
                        <tr>
                          <th style="padding: 5px;">#</th>
                          <th style="padding: 5px;">Name</th>
                          <th style="padding: 5px; width: 30px;">
                            <input type="checkbox" id="selectAllInheritTeachingLoad">
                          </th>
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
        </div>
      </div>
    </div>

  </div>

</div>
<script>
  $(document).ready(function() {

    //navlinks
    $(".nav-link").click(function() {
      // Prevent click if disabled or account_information
      if ($(this).is("[disabled]") || $(this).data("tab") === "account_information") {
        return;
      }
      $(".nav-link").removeClass("active");
      $(this).addClass("active");

      $(".tab-content").addClass("d-none");
      let selectedTab = $(this).data("tab");
      $("#tab-" + selectedTab).removeClass("d-none");

      // ✅ Fetch plantilla list only when Settings tab clicked
      if (selectedTab === "settings") { // adjust if your Settings tab uses a different data-tab
        fetchPlantillaList();
        // Initialize first step active
        setActiveSettingsStep(1);

      }
    });
    //stepper main 
    const steps = [
      "Personal Information",
      "Educational Background",
      "Ancillary Assignments",
      "Teaching Loads"
    ];
    const $stepper = $("#formStepper");
    $.each(steps, function(i, label) {
      const $step = $("<div>", {
        class: "step " + (i === 0 ? "active" : "")
      }).html(`
        <div class="step-circle">${i + 1}</div>
        <div class="step-label mt-1">${label}</div>
        ${i < steps.length - 1 ? `<div class="step-line"></div>` : ""}
      `);

      $stepper.append($step);
    });

    function setActiveStep(stepNumber) {
      $("#formStepper .step").each(function(index) {
        $(this).removeClass("active completed");

        if (index + 1 < stepNumber) {
          $(this).addClass("completed");
        } else if (index + 1 === stepNumber) {
          $(this).addClass("active");
        }
      });
    }
    $("#nextBtn").on("click", function() {
      const personnelId = $("#personnelId").val();
      const nextBtnAA = $("#nextBtnAA");

      if (personnelId) {
        nextBtnAA.removeClass("d-none"); // show
      } else {
        nextBtnAA.addClass("d-none"); // keep hidden
      }

      $("#form-step-1").addClass("d-none");
      $("#form-step-2").removeClass("d-none");
      setActiveStep(2);
    });
    $("#backBtn").on("click", function() {
      $("#form-step-2").addClass("d-none");
      $("#form-step-1").removeClass("d-none");
      setActiveStep(1);
    });
    $("#backBtnAA").on("click", function() {
      $("#form-step-3").addClass("d-none");
      $("#form-step-2").removeClass("d-none");
      setActiveStep(2);
    });
    $("#backBtnTL").on("click", function() {
      $("#form-step-4").addClass("d-none");
      $("#form-step-3").removeClass("d-none");
      setActiveStep(3);
    });
    $("#nextBtnAA").on("click", function() {
      const spId = $("#personnelId").val();
      if (!spId) {
        Swal.fire("Select a personnel first!");
        return;
      }
      // Hide previous steps and show step 3
      $("#form-step-1, #form-step-2").addClass("d-none");
      $("#form-step-3").removeClass("d-none");
      setActiveStep(3);
      loadAssignedAncillary(spId);
    });
    $("#nextBtnTL").on("click", function() {
      const spId = $("#personnelId").val();
      if (!spId) {
        Swal.fire("Select a personnel first!");
        return;
      }
      // Hide previous steps
      $("#form-step-1, #form-step-2, #form-step-3").addClass("d-none");
      $("#form-step-4").removeClass("d-none");
      setActiveStep(4);
      // Clear container before loading new data
      $("#teachingLoadsContainer").html(
        `<div class="text-muted small">Loading teaching loads...</div>`
      );
      $("#sp_id").val(spId);
      loadTeachingLoads(spId);
    });
    //stepper settings
    const settingsSteps = [
      "Plantilla List",
      "Ancillary Assignment List",
      "Inheritance"
    ];
    const $settingsStepper = $("#formStepperSettings");
    $.each(settingsSteps, function(i, label) {
      const isActive = i === 0 ? "active" : "";
      const stepHtml = `
        <div class="step ${isActive}">
          <div class="step-circle">${i + 1}</div>
          <div class="step-label mt-1">${label}</div>
          ${i < settingsSteps.length - 1 ? `<div class="step-line"></div>` : ""}
        </div>
      `;
      $settingsStepper.append(stepHtml);
    });
    let currentStep = 1; // Tracks which step is active
    const totalSteps = settingsSteps.length;

    function showStep(step) {
      for (let i = 1; i <= totalSteps; i++) {
        const $stepEl = $(`#form-step-settings-${i}`);
        if ($stepEl.length) {
          $stepEl.toggleClass("d-none", i !== step);
        }
      }
      setActiveStepSettings(step);
    }

    function setActiveStepSettings(stepNumber) {
      $("#formStepperSettings .step").each(function(i) {
        $(this).toggleClass("active", i === stepNumber - 1);
      });
    }
    $("#nextBtnPL").on("click", function() {
      if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
      }
      fetchAncillaryAssignmentList();
    });
    $("#nextBtnAL").on("click", function() {
      if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
      }
      fetchAncillaryAssignmentList();
    });
    $(document).on("click", "#backBtnAL", function() {
      if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
      }
    });
    //search personnel
    $(document).on("input", "#searchPersonnel", function() {
      const searchValue = $(this).val().toLowerCase();
      let visibleCount = 0;

      $(".personnel-card").each(function() {
        const name = $(this).find(".personnel-name").text().toLowerCase();
        const email = $(this).find(".personnel-email").text().toLowerCase();
        const specialization = $(this).find(".personnel-specialization").text().toLowerCase();

        if (name.includes(searchValue) || email.includes(searchValue) || specialization.includes(searchValue)) {
          $(this).css("display", "block"); // ✅ keeps alignment
          visibleCount++;
        } else {
          $(this).css("display", "none");
        }
      });

      $("#noResults").toggleClass("d-none", visibleCount > 0);
    });
    //search ancillary
    const $searchInput = $("#searchAncillary");
    const $rows = $("#ancRow1, #ancRow2");
    $rows.find(".ancillary-item").each(function() {
      $(this).data("original", $(this).text());
    });

    function filterRows(filter) {
      $rows.each(function() {
        $(this).find(".ancillary-item").each(function() {
          const original = $(this).data("original");
          const text = original.toLowerCase();

          if (filter === "" || text.includes(filter)) {
            $(this).css("display", "inline-flex");
            if (filter !== "") {
              const regex = new RegExp(`(${filter})`, "gi");
              $(this).html(original.replace(regex, "<mark>$1</mark>"));
            } else {
              $(this).html(original);
            }
          } else {
            $(this).css("display", "none");
          }
        });
      });
    }
    $searchInput.on("input", function() {
      const filter = $(this).val().toLowerCase();
      filterRows(filter);
    });
    $searchInput.on("blur", function() {
      $(this).val("");
      filterRows("");
    });
    //search plantilla list
    $(document).on("input change", "#searchPlantilla", function() {
      const query = $(this).val().toLowerCase().trim();
      let hasResults = false;

      $("#plantillaList .plantilla-card").each(function() {
        const desc = $(this).data("pp_desc").toLowerCase();
        const code = $(this).data("pp_code").toLowerCase();

        if (desc.includes(query) || code.includes(query)) {
          $(this).removeClass("d-none");
          hasResults = true;
        } else {
          $(this).addClass("d-none");
        }
      });

      // Show/hide "No results found"
      if (hasResults) {
        $("#noPlantillaResults").addClass("d-none");
      } else {
        $("#noPlantillaResults").removeClass("d-none");
      }
    });
    //search ancillary list
    $(document).on("input change", "#searchAncillaryList", function() {
      const query = $(this).val().toLowerCase().trim();
      let hasResults = false;

      $("#ancillaryAssignmentList > div").each(function() {
        const desc = $(this).data("desc")?.toLowerCase() || "";

        if (desc.includes(query)) {
          $(this).removeClass("d-none");
          hasResults = true;
        } else {
          $(this).addClass("d-none");
        }
      });
      // ✅ Toggle no-results message
      $("#noAncillaryResults").toggleClass("d-none", hasResults);
    });
    //personnel card on click
    $(document).on("click", ".personnel-card", function() {
      const personnelId = $(this).data("id");
      loadPersonnel(personnelId);
      updateAccountButtons();
      const spId = $(this).data("id");
      loadAssignedAncillary(spId);
    });

    function loadPersonnel(personnelId) {
      $.ajax({
        url: "<?= base_url('academic/getPersonnelById/'); ?>" + personnelId,
        type: "GET",
        dataType: "json",
        success: function(data) {
          if (data && !data.error) {
            // Hidden ID
            $("#personnelId").val(data.sp_id);

            // Avatar + Header
            $("#personnelAvatarCard").attr(
              "src",
              data.sp_avatar ?? "<?= base_url('assets/img/logos/profile_logo.png') ?>"
            );
            $("#personnelNameCard").text(data.full_name);
            $("#personnelAccountStatusCard").text(data.user_account);
            $("#personnelAncillaryCountCard").text(data.ancillary_count);
            $("#personnelLoadsCountCard").text(data.loads_count);
            $("#personnelAverageTeachingCard").text(data.average_teaching);
            $("#personnelRoleCard").text(data.pp_desc ?? "No plantilla position attached.");
            $("#personnelAdvisoryCard").text(
              data.section_name ?
              data.section_name + " Adviser" :
              "No advisory class."
            );
            // Fill form inputs
            $("#sp_no").val(data.sp_no ?? "");
            $("#sp_lname").val(data.sp_lname ?? "");
            $("#sp_fname").val(data.sp_fname ?? "");
            $("#sp_mname").val(data.sp_mname ?? "");
            $("#sp_ename").val(data.sp_ename ?? "");
            $("#sp_sex").val(data.sp_sex ?? "");
            $("#sp_fund_source").val(data.sp_fund_source ?? "");
            $("#sp_birth_date").val(data.sp_birth_date ?? "");
            $("#sp_employment_status").val(data.sp_employment_status ?? "");
            $("#sp_educ_degree").val(data.sp_educ_degree ?? "");
            $("#sp_educ_major").val(data.sp_educ_major ?? "");
            $("#sp_educ_minor").val(data.sp_educ_minor ?? "");
            $("#sp_email").val(data.sp_email ?? "");
            $("#sp_position").val(data.sp_position ?? "");
            $("#sp_post_graduate").val(data.sp_post_graduate ?? "");
            $("#sp_specialization").val(data.sp_specialization ?? "");
            $("#sp_status").val(data.sp_status ?? "");
            $("#sp_advisory").val(data.section_id ?? "");

            // Switch to Contact Info tab (make form visible)
            $(".nav-link").removeClass("active");
            $('[data-tab="account_information"]').addClass("active");
            $(".tab-content").addClass("d-none");
            $("#tab-account_information").removeClass("d-none");
          } else {
            alert(data.error ?? "Personnel not found.");
          }
        },
        error: function() {
          alert("Could not load personnel details.");
        },
      });
    }

    function updateAccountButtons() {
      const status = $("#personnelAccountStatusCard").text().trim();

      if (status === "Active") {
        // Show Create Account button, hide Block
        $("#personnelCreateAccountBtn").removeClass("d-none");
        $("#personnelBlockAccountBtn").addClass("d-none");
        $("#personnelDefaultBtn").addClass("d-none");
      } else {

        // Show Block button, hide Create Account
        $("#personnelBlockAccountBtn").removeClass("d-none");
        $("#personnelCreateAccountBtn").addClass("d-none");
        $("#personnelDefaultBtn").addClass("d-none");
      }
    }
    $("#addPersonnelBtn").on("click", function() {
      $(".nav-link").removeClass("active");
      $('[data-tab="account_information"]').addClass("active");
      $(".tab-content").addClass("d-none");
      $("#tab-account_information").removeClass("d-none");
      $("#personnelForm")[0].reset();
      $("#personnelId").val('');
      $("#nextBtnAA").addClass("d-none");
    });
    $("#addPlantillaBtn").on("click", function() {
      const $form = $("#plantillaPositionForm");
      $form.toggleClass("d-none");

      if (!$form.hasClass("d-none")) {
        $form[0].reset();
        $("#pp_pp_id").val('');

        // Count plantilla items and add +1
        const nextRank = $("#plantillaList .plantilla-card:not(.d-none)").length + 1;
        $("#pp_pp_rank").val(nextRank);

        console.log("Next Rank (with +1):", nextRank);
      }
    });
    $("#personnelForm").on("submit", function(e) {
      e.preventDefault(); // prevent default form submission

      // List of required fields
      const requiredFields = [{
          id: "#sp_no",
          name: "ID No"
        },
        {
          id: "#sp_email",
          name: "Email"
        },
        {
          id: "#sp_lname",
          name: "Last Name"
        },
        {
          id: "#sp_fname",
          name: "First Name"
        },
        {
          id: "#sp_sex",
          name: "Sex"
        },
        {
          id: "#sp_birth_date",
          name: "Birth Date"
        }
      ];

      // Check if any required field is empty
      for (let field of requiredFields) {
        if ($(field.id).val().trim() === "") {
          Swal.fire({
            icon: 'error',
            title: 'Missing Field',
            text: `Please fill the required field: ${field.name}`,
            confirmButtonColor: '#dc3545'
          });
          $(field.id).focus();
          return; // stop submission
        }
      }

      // All required fields are filled, proceed with AJAX
      const formData = $(this).serialize();
      const personnelId = $("#personnelId").val();

      $.ajax({
        url: "<?= base_url('academic/savePersonnel'); ?>",
        type: "POST",
        dataType: "json",
        data: formData,
        success: function(data) {
          Swal.fire({
            icon: data.success ? 'success' : 'info',
            title: data.success ? 'Saved!' : 'Warning!',
            text: data.message || 'Could not save personnel profile.',
            confirmButtonColor: data.success ? '#0d6efd' : '#1cceffff'
          });

          if (personnelId && data.success) loadPersonnel(personnelId);

          if (!personnelId && data.success) {
            $("#personnelForm")[0].reset();
            $("#personnelId").val('');
            $("#nextBtnAA").addClass("d-none");
          }
        },
        error: function(xhr) {
          console.error(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'AJAX Error',
            text: 'Could not save personnel profile.',
            confirmButtonColor: '#dc3545'
          });
        }
      });
    });

    function loadAssignedAncillary(spId) {
      if (!spId) {
        Swal.fire("Select a personnel first!");
        return;
      }

      const $container = $("#selectedAncItems");
      const $profileContainer = $("#selectedAncItemsProfile");

      // Clear old content and show loading
      $container.html('<span class="text-muted">Loading...</span>');
      $profileContainer.empty();

      $.ajax({
        url: "<?= base_url('academic/getAssignedAncillary/'); ?>" + spId,
        type: "GET",
        dataType: "json",
        cache: false,
        success: function(data) {
          $container.empty(); // clear loading

          if (data.success) {
            let assignedItems = data.assigned;

            // Remove duplicates client-side
            const uniqueItems = [];
            const seenIds = new Set();
            $.each(assignedItems, function(_, item) {
              if (!seenIds.has(item.aa_id)) {
                seenIds.add(item.aa_id);
                uniqueItems.push(item);
              }
            });

            // MAIN LIST
            $.each(uniqueItems, function(_, item) {
              const $badge = $(`
            <span class="badge bg-primary d-inline-flex align-items-center px-2 py-1 me-1" 
                  data-id="${item.aa_id}" 
                  data-aal-id="${item.aal_id}" 
                  style="font-size:0.65rem;">
              ${item.aa_desc}
              <button type="button" class="btn-close btn-close-white btn-sm ms-1" aria-label="Remove"></button>
            </span>
          `);

              // Append badge
              $container.append($badge);

              // Remove badge logic
              $badge.find(".btn-close").on("click", function() {
                $badge.remove();
                if ($badge.data("aal-id")) {
                  $.post("<?= base_url('academic/removeAncillaryAssignment'); ?>", {
                    aal_id: $badge.data("aal-id")
                  });
                }
                updateProfilePreview();
              });
            });

            // PROFILE PREVIEW (first + count)
            updateProfilePreview();

            function updateProfilePreview() {
              $profileContainer.empty();
              const $badges = $container.find("span.badge");

              if ($badges.length > 0) {
                // first badge clone
                const firstText = $badges.first().clone().children().remove().end().text().trim();
                const $firstBadge = $(`<span class="badge bg-primary px-2 py-1 me-1">${firstText}</span>`);
                $profileContainer.append($firstBadge);

                if ($badges.length > 1) {
                  const $moreBadge = $(`
                <span class="bg-primary text-white d-inline-flex justify-content-center align-items-center"
                      style="width:18px;height:18px;border-radius:50%;font-size:0.55rem;">
                  +${$badges.length - 1}
                </span>
              `);
                  $profileContainer.append($moreBadge);
                }
              }
            }
          } else {
            Swal.fire("No assigned ancillary items found.");
          }
        },
        error: function() {
          $container.empty(); // clear loading
          Swal.fire("Error", "Could not fetch assigned ancillary items.", "error");
        }
      });
    }
    $(document).on("click", ".ancillary-item", function() {
      const container = $("#selectedAncItems");
      const profileContainer = $("#selectedAncItemsProfile");
      const spId = $("#personnelId").val();
      const aaId = $(this).data("id");
      const text = $(this).text();

      if (!spId) {
        Swal.fire({
          icon: 'warning',
          title: 'No Personnel Selected',
          text: 'Please select a personnel first.',
          confirmButtonColor: '#0d6efd'
        });
        return;
      }

      if (container.find(`[data-id='${aaId}']`).length === 0) {
        // Create badge
        const badge = $(`
          <span class="badge bg-primary d-inline-flex align-items-center px-2 py-1" 
                data-id="${aaId}" style="font-size:0.65rem;">
            ${text}
            <button type="button" class="btn-close btn-close-white btn-sm ms-1" aria-label="Remove"></button>
          </span>
        `);
        container.append(badge);
        // Save immediately
        $.ajax({
          url: "<?= base_url('academic/saveAncillaryAssignments'); ?>",
          type: "POST",
          dataType: "json",
          data: {
            sp_id: spId,
            'aa_ids[]': [aaId]
          },
          success: function(data) {
            if (data.success && data.aal_id) {
              badge.attr("data-aal-id", data.aal_id);
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Could not save this assignment.',
                confirmButtonColor: '#dc3545'
              });
              badge.remove();
              updateProfileDisplay();
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'AJAX Error',
              text: 'Could not save this assignment.',
              confirmButtonColor: '#dc3545'
            });
            badge.remove();
            updateProfileDisplay();
          }
        });
      }
      updateProfileDisplay();
      // === Remove badge when × clicked === //
      container.on("click", ".btn-close", function() {
        const badge = $(this).closest("span[data-id]");
        const aalId = badge.data("aal-id");

        badge.remove();
        if (aalId) {
          $.ajax({
            url: "<?= base_url('academic/removeAncillaryAssignment'); ?>",
            type: "POST",
            dataType: "json",
            data: {
              aal_id: aalId
            }
          });
        }
        updateProfileDisplay();
      });
      // === Profile updater === //
      function updateProfileDisplay() {
        profileContainer.empty();
        const badges = container.find("span[data-id]");
        if (badges.length === 0) return;

        // First badge only
        const firstBadge = badges.first().clone();
        firstBadge.find(".btn-close").remove();
        profileContainer.append(firstBadge);

        // Circle count for remaining
        if (badges.length > 1) {
          const moreBadge = $(`
        <span class="bg-primary text-white d-inline-flex justify-content-center align-items-center ms-1"
              style="width:18px;height:18px;border-radius:50%;font-size:0.55rem;">
          +${badges.length - 1}
        </span>
      `);
          profileContainer.append(moreBadge);
        }
      }
    });
    // When Add Personnel button is clicked
    $("#addAncillaryBtn").on("click", function() {
      const form = $("#ancillaryAssignmentListForm");

      // Toggle visibility
      form.toggleClass("d-none");

      // If making visible, reset fields
      if (!form.hasClass("d-none")) {
        form[0].reset();
        $("#aa_aa_id").val('');
      }
    });

    function loadTeachingLoads(spId) {
      // Clear container before loading new data
      $("#teachingLoadsContainer").html(`
        <div class="text-muted small">Loading teaching loads...</div>
      `);

      $.ajax({
        url: "<?= base_url('academic/getTeachingLoads'); ?>",
        type: "POST",
        data: {
          sp_id: spId
        },
        dataType: "json",
        success: function(data) {
          let html = "";
          if (data && data.length > 0) {
            data.forEach(function(load) {
              let days = load.days || "";
              if (days === "M,T,W,TH,F,") {
                days = "M-F";
              } else {
                days = days.replace(/,$/, "");
              }

              html += `
          <div class="card shadow-sm mb-1 border rounded-3 teaching-load-card " 
              data-tl_id="${load.tl_id}" 
              data-subject_id="${load.subject_id}" 
              data-tl_start="${load.tl_start}" 
              data-tl_end="${load.tl_end}" 
              data-tl_grade_level="${load.tl_grade_level}"
              data-days="${(load.days || '').replace(/"/g, '&quot;')}">
            <div class="card-body position-relative">
              <div class="position-absolute top-0 end-0 m-2">
                <button class="btn btn-sm p-1 border-0 bg-transparent" type="button" title="Delete" id="deleteTeachingLoads" data-tl_id="${load.tl_id}">
                  <i class="uil uil-trash-alt text-danger fs-8"></i>
                </button>
              </div>
              <h6 class="mb-1 fw-bold">
                <i class="uil uil-book-open me-1 text-primary"></i> ${load.subject_name} - ${load.tl_grade_level}
              </h6>
              <p class="mb-1 text-muted small">
                <i class="uil uil-calendar-alt me-1"></i> ${days} | ${load.per_week} mins per week
              </p>
              <div class="d-flex justify-content-between align-items-center text-muted small">
                <span><i class="uil uil-clock me-1"></i> ${load.tl_start} - ${load.tl_end}</span>
                <span><i class="uil uil-history me-1"></i> ${load.updated_at || "N/A"}</span>
              </div>
            </div>
          </div>`;
            });
          } else {
            html = `<div class="alert text-center m-10">
          <i class="uil uil-exclamation-circle me-1"></i>
          No teaching loads found.
        </div>`;
          }
          $("#teachingLoadsContainer").html(html);
        },
        error: function() {
          $("#teachingLoadsContainer").html(`
        <div class="alert text-center">
          <i class="uil uil-times-circle me-1"></i>
          Error fetching teaching loads.
        </div>
      `);
        }
      });
    }
    // toggle active class
    $(document).on('click', '.day-btn', function() {
      $(this).toggleClass('btn-primary btn-outline-primary active');
    });
    $(document).on('click', '#addTeachingLoads', function(e) {
      e.preventDefault();
      let sp_id = $('#sp_id').val();
      let tl_id = $('#tl_id').val(); // THIS determines insert or update
      let subject_id = $('[name="subject_id"]').val();
      let tl_start = $('[name="tl_start"]').val();
      let tl_end = $('[name="tl_end"]').val();
      let grade_level = $('[name="tl_grade_level"]').val();

      let days = {
        mon: 0,
        tue: 0,
        wed: 0,
        thu: 0,
        fri: 0,
        sat: 0,
        sun: 0
      };
      $('.day-btn.active').each(function() {
        let d = $(this).data('day');
        days[d] = 1;
      });

      if (!subject_id || !tl_start || !tl_end || !grade_level || Object.values(days).every(v => v === 0)) {
        Swal.fire("Missing Fields", "Please fill out all required fields and select at least one day.", "warning");
        return;
      }

      $.ajax({
        url: "<?= base_url('academic/saveTeachingLoad'); ?>",
        type: "POST",
        dataType: "json",
        data: {
          sp_id,
          tl_id, // send the tl_id! if null -> insert, else -> update
          subject_id,
          tl_start,
          tl_end,
          tl_grade_level: grade_level,
          tl_mon: days.mon,
          tl_tue: days.tue,
          tl_wed: days.wed,
          tl_thu: days.thu,
          tl_fri: days.fri,
          tl_sat: days.sat,
          tl_sun: days.sun
        },
        success: function(response) {
          if (response.status === 'success') {
            $('#sp_id').val(sp_id);
            loadTeachingLoads(sp_id);
            $('#teachingLoadAddRow').addClass('d-none');
            $('#tl_id').val(''); // reset after update
            $('[name="subject_id"]').prop('selectedIndex', -1);
            $('[name="tl_start"]').val('');
            $('[name="tl_end"]').val('');
            $('[name="tl_grade_level"]').prop('selectedIndex', 0);
            $('.day-btn').removeClass('btn-primary active').addClass('btn-outline-primary');
          } else {
            Swal.fire("Warning", response.message, "info");
          }
        },
        error: function(xhr, status, error) {
          Swal.fire("AJAX Error", error, "error");
          console.error("AJAX Error:", status, error, "Response:", xhr.responseText);
        }
      });
    });
    // Works even if this block is injected later via AJAX
    $(document).on('click', '#showAddFormBtn', function(e) {
      e.preventDefault();
      // toggle visibility by toggling the d-none class
      $('#teachingLoadAddRow').toggleClass('d-none');
      $('#tl_id').val(''); // reset after update
      $('[name="subject_id"]').prop('selectedIndex', -1);
      $('[name="tl_start"]').val('');
      $('[name="tl_end"]').val('');
      $('[name="tl_grade_level"]').prop('selectedIndex', 0);
      $('.day-btn').removeClass('btn-primary active').addClass('btn-outline-primary');
      // if just shown, scroll into view
      if (!$('#teachingLoadAddRow').hasClass('d-none')) {
        document.getElementById('teachingLoadAddRow')?.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
    // Subject select change handler
    function handleSubjectChange($selectElement, currentGradeLevel = null) {
      const $selectedOption = $selectElement.find("option:selected");
      const gradeRange = $selectedOption.data("grade-range");
      const $gradeSelect = $("#gradeLevelSelect");

      // Clear previous options
      $gradeSelect.html('<option selected disabled>Grade Level</option>');

      let grades = [];
      if (gradeRange === "7-10") {
        grades = [7, 8, 9, 10];
      } else if (gradeRange === "11-12") {
        grades = [11, 12];
      } else {
        grades = [gradeRange]; // fallback
      }

      // Append new options
      $.each(grades, function(_, g) {
        $gradeSelect.append(`<option value="${g}">Grade ${g}</option>`);
      });

      // If currentGradeLevel is provided, select it
      if (currentGradeLevel) {
        $gradeSelect.val(currentGradeLevel);
      }
    }
    // Attach change event with jQuery
    $("#subjectSelect").on("change", function() {
      handleSubjectChange($(this));
    });
    $(document).on('click', '.teaching-load-card', function() {
      const card = $(this);
      const tlGradeLevel = card.data('tl_grade_level');
      // Fill input fields
      $('#tl_id').val(card.data('tl_id')); // This is important
      $('[name="subject_id"]').val(card.data('subject_id')).change();
      $('[name="tl_start"]').val(card.data('tl_start'));
      $('[name="tl_end"]').val(card.data('tl_end'));
      $('[name="tl_grade_level"]').val(tlGradeLevel); // populate grade level

      // Reset all day buttons first
      $('.day-btn').removeClass('btn-primary active').addClass('btn-outline-primary');

      const dayMap = {
        M: 'mon',
        T: 'tue',
        W: 'wed',
        TH: 'thu',
        F: 'fri',
        SAT: 'sat',
        SUN: 'sun'
      };

      const dayNames = {
        mon: 'Monday',
        tue: 'Tuesday',
        wed: 'Wednesday',
        thu: 'Thursday',
        fri: 'Friday',
        sat: 'Saturday',
        sun: 'Sunday'
      };

      const days = (card.data('days') || "").split(',');
      const activeDays = [];

      days.forEach(d => {
        const dayCode = d.trim().toUpperCase(); // M, T, W, TH, F, SAT, SUN
        const btnCode = dayMap[dayCode];
        if (btnCode) {
          $(`.day-btn[data-day="${btnCode}"]`)
            .removeClass('btn-outline-primary')
            .addClass('btn-primary active');
          activeDays.push(dayNames[btnCode]);
        }
      });



      $('#activeDaysDisplay').text(activeDays.length > 0 ? 'Active Days: ' + activeDays.join(', ') : '');

      $('#teachingLoadAddRow').removeClass('d-none');
      $('#teachingLoadAddRow')[0].scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });

      // Trigger the grade level update
      handleSubjectChange(document.getElementById('subjectSelect'), tlGradeLevel);
    });
    // Delete Teaching Load with SweetAlert
    $(document).on('click', '#deleteTeachingLoads', function(e) {
      const tl_id = $(this).data('tl_id');
      if (!tl_id) return;

      Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the teaching load!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= base_url('academic/deleteTeachingLoad'); ?>",
            type: "POST",
            dataType: "json",
            data: {
              tl_id: tl_id
            },
            success: function(response) {
              if (response.status === 'success') {
                Swal.fire(
                  'Deleted!',
                  response.message,
                  'success'
                );
                const sp_id = $('#sp_id').val();
                loadTeachingLoads(sp_id);
              } else {
                Swal.fire('Error', response.message, 'error');
              }
            },
            error: function(xhr, status, error) {
              Swal.fire('AJAX Error', error, 'error');
              console.error("AJAX Error:", status, error, "Response:", xhr.responseText);
            }
          });
        }
      });
    });

    function fetchAncillaryAssignmentList() {
      const $ancillaryList = $("#ancillaryAssignmentList");
      if ($ancillaryList.length === 0) return;

      $.getJSON("<?= base_url('academic/getAllAncillary') ?>", function(data) {
        $ancillaryList.empty();

        $.each(data, function(index, item) {
          const $div = $(`
        <div class="d-flex justify-content-between align-items-center p-2 mb-0 rounded shadow-sm border"
             data-id="${item.aa_id}" data-desc="${item.aa_desc}">
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success fw-semibold d-flex justify-content-center align-items-center"
                  style="font-size:0.55rem; width:18px; height:18px; border-radius:50%;">
              ${index + 1}
            </span>

            <div class="d-flex flex-column">
              <span class="fw-medium" style="font-size:0.85rem;">${item.aa_desc}</span>

              ${item.assigned_personnel && item.assigned_personnel.length > 0 ? (() => {
                const names = item.assigned_personnel.split(",");
                const first = names[0].trim();
                const extra = names.length - 1;
                return `<small class="text-primary" style="font-size:0.75rem;">
                          <i class="uil uil-user"></i> ${first}${extra > 0 ? ` +${extra}` : ""}
                        </small>`;
              })() : ""}

              ${item.updated_at ? `<small class="text-muted" style="font-size:0.7rem;">
                <i class="uil uil-clock"></i> ${item.updated_at}
              </small>` : ""}
            </div>
          </div>

          <div class="d-flex align-items-center gap-3">
            <i class="uil uil-trash-alt text-danger delete-ancillary" style="cursor:pointer;" title="Delete"></i>
          </div>
        </div>
      `);

          // Delete button
          $div.find(".delete-ancillary").on("click", function(e) {
            e.stopPropagation();
            Swal.fire({
              title: "Are you sure?",
              text: `Delete ancillary: ${item.aa_desc}?`,
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, delete it!",
              cancelButtonText: "Cancel"
            }).then((result) => {
              if (result.isConfirmed) {
                $.post("<?= base_url('academic/deleteAncillary') ?>", {
                  aa_id: item.aa_id
                }, function(res) {
                  if (res.success) {
                    Swal.fire("Deleted!", "Ancillary has been deleted.", "success");
                    fetchAncillaryAssignmentList();
                  } else {
                    Swal.fire("Error", res.message || "Could not delete ancillary.", "error");
                  }
                }, "json");
              }
            });
          });

          // Click row to edit
          $div.on("click", function() {
            const $form = $("#ancillaryAssignmentListForm");
            $form.removeClass("d-none")[0].reset();

            $("#aa_aa_id").val(item.aa_id);
            $("#aa_aa_desc").val(item.aa_desc);
          });

          $ancillaryList.append($div);
        });
      });
    }
    $("#ancillaryAssignmentListForm").on("submit", function(e) {
      e.preventDefault(); // prevent default form submission

      const formData = $(this).serialize(); // serialize form data

      $.ajax({
        url: "<?= base_url('academic/saveAncillary') ?>",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(res) {
          if (res.success) {
            Swal.fire({
              icon: 'success',
              title: 'Saved!',
              text: 'Ancillary assignment has been saved.',
              showConfirmButton: true
            });

            // Reset form and hide it
            $("#ancillaryAssignmentListForm").addClass("d-none").trigger("reset");

            // Refresh the ancillary list
            fetchAncillaryAssignmentList();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: res.message || 'Could not save ancillary.'
            });
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred.'
          });
        }
      });
    });

    function fetchPlantillaList() {
      const $plantillaList = $("#plantillaList");
      if (!$plantillaList.length) return;

      $.getJSON("<?= base_url('academic/getPlantillaList') ?>", function(data) {
        $plantillaList.empty();

        $.each(data, function(i, item) {
          const $div = $(`
        <div class="d-flex justify-content-between align-items-center p-2 mb-0 rounded shadow-sm border plantilla-card"
             data-id="${item.pp_id}"
             data-pp_desc="${item.pp_desc}"
             data-pp_rank="${item.pp_rank}"
             data-pp_code="${item.pp_code}"
             data-pp_category="${item.pp_category}">
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success fw-semibold d-flex justify-content-center align-items-center" 
                  style="font-size:0.55rem; width:18px; height:18px; border-radius:50%;">
              ${item.pp_rank}
            </span>

            <div class="d-flex flex-column">
              <span class="fw-medium plantilla-name" style="font-size:0.85rem;">${item.pp_desc}</span>
              <small class="text-muted plantilla-code" style="font-size:0.75rem;">
                <i class="uil uil-list-ul"></i> (${item.pp_category})&nbsp;${item.pp_code}
              </small>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            ${item.updated_at ? `<small class="text-muted" style="font-size:0.7rem;">
              <i class="uil uil-clock"></i> ${item.updated_at}
            </small>` : ''}
            <i class="uil uil-trash-alt text-danger" style="cursor:pointer;" title="Delete"></i>
            <i class="uil uil-arrows-v text-secondary" style="cursor: grab;" title="Drag"></i>
          </div>
        </div>
      `);

          // Delete button
          $div.find(".uil-trash-alt").on("click", function(e) {
            e.stopPropagation();
            Swal.fire({
              title: "Are you sure?",
              text: `Delete plantilla: ${item.pp_desc}?`,
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, delete it!",
              cancelButtonText: "Cancel"
            }).then((result) => {
              if (result.isConfirmed) {
                $.post("<?= base_url('academic/deletePlantilla') ?>", {
                  pp_id: item.pp_id
                }, function(res) {
                  if (res.success) {
                    Swal.fire("Deleted!", "Plantilla has been deleted.", "success");
                    fetchPlantillaList(); // refresh list
                  } else {
                    Swal.fire("Error", res.message || "Could not delete plantilla.", "error");
                  }
                }, "json");
              }
            });
          });

          // Click row → Edit
          $div.on("click", function() {
            const $form = $("#plantillaPositionForm");
            $form.removeClass("d-none")[0].reset();

            $("#pp_pp_id").val(item.pp_id);
            $("#pp_pp_desc").val(item.pp_desc);
            $("#pp_pp_rank").val(item.pp_rank);
            $("#pp_pp_code").val(item.pp_code);
            $("#pp_pp_category").val(item.pp_category);
          });

          $plantillaList.append($div);
        });

        // Make list draggable
        new Sortable($plantillaList[0], {
          animation: 150,
          handle: ".uil-arrows-v",
          onEnd: function() {
            const order = $plantillaList.children().map(function() {
              return $(this).data("id");
            }).get();

            $.post("<?= base_url('academic/savePlantillaOrder') ?>", {
              order: order
            }, function(res) {
              if (res.success) {
                $plantillaList.children().each(function(i) {
                  $(this).find(".badge").text(i + 1);
                });
              } else {
                Swal.fire("Error", "Could not save new order.", "error");
              }
            }, "json");
          }
        });
      });
    }
    $("#plantillaPositionForm").on("submit", function(e) {
      e.preventDefault(); // prevent default form submission
      // Set rank dynamically as number of plantilla items + 1 if creating new
      const rankInput = $("#pp_pp_rank");
      const pp_id = $("#pp_pp_id").val();
      if (!pp_id) { // only set rank for new record
        const plantillaList = $("#plantillaList");
        const nextRank = plantillaList.children().length + 1;
        rankInput.val(nextRank);
      }

      // Serialize form data
      const formData = $(this).serialize();

      $.ajax({
        url: "<?= base_url('academic/savePlantilla') ?>",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(res) {
          if (res.success) {
            Swal.fire("Success", "Plantilla saved successfully!", "success");
            $("#plantillaPositionForm")[0].reset();
            $("#plantillaPositionForm").addClass("d-none"); // hide form
            fetchPlantillaList(); // refresh list
          } else {
            Swal.fire("Error", res.message || "Could not save plantilla.", "error");
          }
        },
        error: function() {
          Swal.fire("Error", "Something went wrong.", "error");
        }
      });
    });
    // Customize Ancillary Button
    $(document).on("click", "#iaaCustomizeBtn", function() {
      const $select = $("#iaa_school_year");
      const schoolYear = $select.val();

      if (!schoolYear) {
        $select.addClass("is-invalid");
        return;
      }
      $select.removeClass("is-invalid");

      // show step 4
      $("#form-step-settings-3").addClass("d-none");
      $("#form-step-settings-6").addClass("d-none");
      $("#form-step-settings-4").removeClass("d-none");

      // load data into table
      $.get("<?= base_url('academic/fetchAncillaryAssignments'); ?>", function(response) {
        let data = JSON.parse(response);
        let tbody = $("#customizeTable tbody");
        tbody.empty();

        if (!data || data.length === 0) {
          tbody.append(`
        <tr>
          <td colspan="4" class="text-center text-muted">No ancillary assignments found.</td>
        </tr>
      `);
          return;
        }

        data.forEach((item, index) => {
          tbody.append(`
        <tr style="font-size: 12px; height: 28px;">
          <td style="padding: 3px; text-align: center;">${index + 1}</td>
          <td style="padding: 3px; text-align: center;">${item.sp_lname}, ${item.sp_fname}</td>
          <td style="padding: 3px; text-align: center;">${item.aa_desc}</td>
          <td style="padding: 3px; text-align: center;">
            <input type="checkbox"
                   class="student-checkbox"
                   data-aa-id="${item.aa_id}"
                   value="${item.sp_id}"
                   checked>
          </td>
        </tr>
      `);
        });
      });
    });

    // Select All
    $(document).on("change", "#selectAllInherit", function() {
      $(".student-checkbox").prop("checked", this.checked);
    });

    // Inherit Button
    $(document).on("click", "#iaaInheritBtn", function() {
      const selectedSchoolYear = $("#iaa_school_year").val();

      if (!selectedSchoolYear) {
        $("#iaa_school_year").addClass("is-invalid");
        return;
      }

      let sp_ids = [];
      let aa_ids = [];

      $("#customizeTable tbody input.student-checkbox:checked").each(function() {
        sp_ids.push($(this).val());
        aa_ids.push($(this).data("aa-id")); // <-- fixed, match attribute
      });

      if (sp_ids.length === 0) {
        Swal.fire({
          icon: "warning",
          title: "No Selection",
          text: "Please check at least one row.",
        });
        return;
      }

      $.post("<?= base_url('academic/inheritData'); ?>", {
        sy_id: selectedSchoolYear,
        sp_ids: sp_ids,
        aa_ids: aa_ids
      }, function(response) {
        let res = JSON.parse(response);
        if (res.status === 'success') {
          Swal.fire({
            icon: "success",
            title: "Success",
            text: `Successfully inherited ${res.inserted} entries to Academic Year ${$("#iaa_school_year option:selected").text()}. Skipped ${res.skipped} duplicate entries.`
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: res.message || "Something went wrong!"
          });
        }
      });

    });

    $(document).on("click", "#itlCustomizeBtn", function() {
      const $select = $("#itl_school_year");
      const schoolYear = $select.val();

      if (!schoolYear) {
        $select.addClass("is-invalid");
        return;
      }
      $select.removeClass("is-invalid");

      // show step 4
      $("#form-step-settings-3").addClass("d-none");
      $("#form-step-settings-4").addClass("d-none");
      $("#form-step-settings-5").removeClass("d-none");

      // load data into table
      $.get("<?= base_url('academic/fetchTeachingLoads'); ?>", function(response) {
        let data = JSON.parse(response);
        let tbody = $("#customizeTeachingLoad tbody");
        tbody.empty();

        if (!data || data.length === 0) {
          tbody.append(`
        <tr>
          <td colspan="4" class="text-center text-muted">No teaching loads found.</td>
        </tr>
      `);
          return;
        }

        data.forEach((item, index) => {
          tbody.append(`
        <tr style="font-size: 12px; height: 28px;">
          <td style="padding: 3px; text-align: center;">${index + 1}</td>
          <td style="padding: 3px; text-align: center;">${item.sp_lname}, ${item.sp_fname}</td>
          <td style="padding: 3px; text-align: center;">
            <input type="checkbox"
                   class="tl-checkbox"
                   value="${item.sp_id}"
                   checked>
          </td>
        </tr>
      `);
        });
      });
    });
    // Inherit Button
    $(document).on("click", "#itlInheritBtn", function() {
      const selectedSchoolYear = $("#itl_school_year").val();

      if (!selectedSchoolYear) {
        $("#itl_school_year").addClass("is-invalid");
        return;
      }

      let sp_ids = [];
      $("#customizeTeachingLoad tbody .tl-checkbox:checked").each(function() {
        sp_ids.push($(this).val());
      });

      if (sp_ids.length === 0) {
        Swal.fire({
          icon: "warning",
          title: "No Selection",
          text: "Please check at least one row.",
        });
        return;
      }

      $.post("<?= base_url('academic/inheritDataTl'); ?>", {
        sy_id: selectedSchoolYear,
        sp_ids: sp_ids
      }, function(response) {
        let res = JSON.parse(response);
        if (res.status === 'success') {
          Swal.fire({
            icon: "success",
            title: "Success",
            text: `Successfully inherited ${res.inserted} entries to Academic Year ${$("#itl_school_year option:selected").text()}. Skipped ${res.skipped} duplicate entries.`
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: res.message || "Something went wrong!"
          });
        }
      });
    });

    // Select all
    $(document).on("change", "#selectAllInheritTeachingLoad", function() {
      $(".tl-checkbox").prop("checked", this.checked);
    });
    // Live search for Teaching Load
    $(document).on("keyup", "#searchTl", function() {
      let value = $(this).val().toLowerCase();

      $("#customizeTeachingLoad tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
    // Live search for Teaching Load
    $(document).on("keyup", "#searchAa", function() {
      let value = $(this).val().toLowerCase();

      $("#customizeTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
    $(document).on("click", "#backBtnIC", function() {
      $("#form-step-settings-4").addClass("d-none");
      $("#form-step-settings-5").addClass("d-none");
      $("#form-step-settings-3").removeClass("d-none");
    });
    $(document).on("click", "#backBtnC", function() {
      $("#form-step-settings-3").addClass("d-none");
      $("#form-step-settings-2").removeClass("d-none");
      if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
      }
    });
  });
</script>