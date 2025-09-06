<div class="pb-3">
  <div class="row g-4">
    <div class="col-12 col-xxl-6">
      <div class="mb-3">
        <h3 class="mb-2">Profile</h3>
        <h5 class="text-body-tertiary fw-semibold">View and analyze student's basic information, academic performance, and summarized insights.</h5>
      </div>
      <hr class="bg-body-secondary mb-0 mt-1" />
    </div>
  </div>
</div>

<div class="row mb-2 align-items-stretch">
  <div class="col-lg-5 col-md-12 mb-2 d-flex">
    <div class="card shadow-sm h-100 w-100">
      <div class="card-header text-white py-1 px-3 bg-primary">
        <h1 class="card-title text-uppercase m-0" style="font-weight: normal; font-size: 12px; line-height: 2;">
        </h1>
      </div>
      <div class="card-body text-center">
        <!-- Profile Image -->
        <div class="position-relative d-inline-block mb-3">
          <img src="https://placehold.co/200x200"
            alt="Portrait of John Russell Dalina, a student with short brown hair wearing glasses"
            class="rounded-circle border border-4 border-primary img-fluid"
            style="width: 120px; height: 120px; object-fit: cover;">
          <div class="position-absolute bottom-0 end-0 bg-primary text-white p-1 rounded-circle"
            style="cursor: pointer;">
            <i class="fas fa-pencil-alt small"></i>
          </div>
        </div>

        <!-- Name & Role -->
        <h5 class="fw-bold text-dark mb-0">John Russell Dalina</h5>
        <p class="text-primary small mb-3">Computer Science Student</p>

        <!-- Status Badges -->
        <div class="mb-4">
          <span class="badge bg-success">Active</span>
          <span class="badge bg-info text-dark">Senior</span>
        </div>

        <!-- Progress Circle -->
        <div class="mb-3">
          <div class="position-relative mx-auto" style="width: 120px; height: 120px;">
            <svg viewBox="0 0 120 120" width="100%" height="100%">
              <circle cx="60" cy="60" r="54" stroke="#e9ecef" stroke-width="8" fill="none"></circle>
              <circle cx="60" cy="60" r="54" stroke="#0d6efd" stroke-width="8"
                fill="none" stroke-linecap="round" stroke-dasharray="340"
                stroke-dashoffset="136"></circle>
            </svg>
            <div class="position-absolute top-50 start-50 translate-middle">
              <span class="fw-bold text-primary fs-4">60%</span>
            </div>
          </div>
          <p class="small text-muted mt-2 mb-0">Academic Progress</p>
        </div>

        <!-- Stats -->
        <dl class="row mb-4 text-start">
          <dt class="col-8 text-muted small">Completed Courses</dt>
          <dd class="col-4 fw-semibold small">24</dd>

          <dt class="col-8 text-muted small">Current GPA</dt>
          <dd class="col-4 fw-semibold small">3.52</dd>

          <dt class="col-8 text-muted small">Credits Earned</dt>
          <dd class="col-4 fw-semibold small">78</dd>

          <dt class="col-8 text-muted small">Expected Graduation</dt>
          <dd class="col-4 fw-semibold small">May 2025</dd>
        </dl>

        <!-- Edit Button -->
        <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
          <i class="fas fa-user-edit"></i>
          Edit Profile
        </button>
      </div>
    </div>  
  </div>

  <div class="col-lg-7 col-md-12 mb-2 d-flex">
    <div class="card shadow-sm h-100 w-100">
      <!-- Card Header -->
      <div class="card-header text-white py-1 px-3">
        <nav class="nav nav-tabs flex-nowrap w-100 d-flex">
          <button class="nav-link active flex-fill text-center" type="button" data-tab="personal">
            <i class="uil uil-user"></i>
          </button>
          <button class="nav-link flex-fill text-center" type="button" data-tab="contact">
            <i class="uil uil-phone"></i>
          </button>
          <button class="nav-link flex-fill text-center" type="button" data-tab="assignments">
            <i class="uil uil-clipboard-notes"></i>
          </button>
          <button class="nav-link flex-fill text-center" type="button" data-tab="teaching">
            <i class="uil uil-book-open"></i>
          </button>
          <button class="nav-link flex-fill text-center" type="button" data-tab="schedule">
            <i class="uil uil-schedule"></i>
          </button>
          <button class="nav-link flex-fill text-center" type="button" data-tab="evaluations">
            <i class="uil uil-chart"></i>
          </button>
          <button class="nav-link flex-fill text-center" type="button" data-tab="account">
            <i class="uil uil-setting"></i>
          </button>
        </nav>
      </div>

      <!-- Card Body -->
      <div class="card-body">
        <div class="rounded-xl shadow-md overflow-hidden p-6">
          <!-- Personal Info Tab -->
          <div class="tab-content" id="tab-personal">
            <h3>Personal Information</h3>
            <p>Content for personal info...</p>
          </div>

          <!-- Contact Info Tab -->
          <div class="tab-content d-none" id="tab-contact">
            <h3>Contact Information</h3>
            <p>Content for contact info...</p>
          </div>

          <!-- Assignments Tab -->
          <div class="tab-content d-none" id="tab-assignments">
            <h3>Assignments</h3>
            <p>Content for assignments...</p>
          </div>

          <!-- Teaching Load -->
          <div class="tab-content d-none" id="tab-teaching">
            <h3>Teaching Load</h3>
            <p>Content for teaching load...</p>
          </div>

          <!-- Schedule -->
          <div class="tab-content d-none" id="tab-schedule">
            <h3>Schedule</h3>
            <p>Content for schedule...</p>
          </div>

          <!-- Evaluations -->
          <div class="tab-content d-none" id="tab-evaluations">
            <h3>Evaluations</h3>
            <p>Content for evaluations...</p>
          </div>

          <!-- Account -->
          <div class="tab-content d-none" id="tab-account">
            <h3>Account</h3>
            <p>Content for account...</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  $(document).ready(function() {
    $(".nav-link").click(function() {
      // Remove active class from all nav links
      $(".nav-link").removeClass("active");
      $(this).addClass("active");

      // Hide all tab content
      $(".tab-content").addClass("d-none");

      // Show the selected tab
      let selectedTab = $(this).data("tab");
      $("#tab-" + selectedTab).removeClass("d-none");
    });
  });
</script>