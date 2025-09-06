<nav class="navbar navbar-vertical navbar-expand-lg" style="display:none;">
  <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <div class="navbar-vertical-content">
      <ul class="navbar-nav flex-column" id="navbarVerticalNav">
        <!-- HOME -->
        <li class="nav-item">
          <div class="nav-item-wrapper">
            <a class="nav-link dropdown-indicator label-1" href="#nv-home" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-home">
              <div class="d-flex align-items-center">
                <div class="dropdown-indicator-icon-wrapper"><span class="fas fa-caret-right dropdown-indicator-icon"></span></div>
                <span class="nav-link-icon"><i class="uil uil-estate"></i></span>
                <span class="nav-link-text">Home</span>
              </div>
            </a>
            <div class="parent-wrapper label-1">
              <ul class="nav collapse parent show" data-bs-parent="#navbarVerticalCollapse" id="nv-home">
                <li class="collapsed-nav-item-title d-none">Home</li>
                <li class="nav-item">
                  <a class="nav-link active nav-ajax" href="<?= base_url('main/loadDashboard') ?>">
                    <div class="d-flex align-items-center"><span class="nav-link-text">Dashboard</span></div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <!-- STUDENT -->
        <li class="nav-item">
          <p class="navbar-vertical-label">Student</p>
          <hr class="navbar-vertical-line" />
          <div class="nav-item-wrapper">
            <a class="nav-link label-1 nav-ajax" href="<?= base_url('main/loadTracer') ?>">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-users-alt"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Alumni Tracer</span></span></div>
            </a>
          </div>
          <div class="nav-item-wrapper">
            <a class="nav-link label-1 nav-ajax" href="<?= base_url('main/loadAnalytics') ?>">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-chart-line"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Student Analytics</span></span></div>
            </a>
          </div>
        </li>
        <!-- ACADEMICS -->
        <li class="nav-item">
          <p class="navbar-vertical-label">Academics</p>
          <hr class="navbar-vertical-line" />
          <div class="nav-item-wrapper"><a class="nav-link label-1 nav-ajax" href="<?= base_url('main/loadASetup') ?>">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-cog"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Setup</span></span></div>
            </a></div>
          <div class="nav-item-wrapper"><a class="nav-link label-1 nav-ajax" href="<?= base_url('main/loadASection') ?>">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-sitemap"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Section</span></span></div>
            </a></div>
          <div class="nav-item-wrapper"><a class="nav-link label-1 nav-ajax" href="<?= base_url('main/loadASubject') ?>">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-book-open"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Subject</span></span></div>
            </a></div>
          <div class="nav-item-wrapper"><a class="nav-link label-1 nav-ajax" href="<?= base_url('main/loadASchoolPersonnel') ?>">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-user-nurse"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">School Personnel</span></span></div>
            </a></div>
        </li>
        <!-- RECORDS -->
        <li class="nav-item">
          <p class="navbar-vertical-label">Records</p>
          <hr class="navbar-vertical-line" />
          <div class="nav-item-wrapper"><a class="nav-link label-1 nav-ajax" href="<?= base_url('main/loadRAttendance') ?>">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-calendar-alt"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Attendance</span></span></div>
            </a></div>
          <div class="nav-item-wrapper"><a class="nav-link label-1" href="#">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-graduation-cap"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Grade</span></span></div>
            </a></div>
          <div class="nav-item-wrapper"><a class="nav-link label-1" href="#">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-file-bookmark-alt"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Learning Material</span></span></div>
            </a></div>
          <div class="nav-item-wrapper"><a class="nav-link label-1" href="#">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-heart-medical"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Health & Nutrition</span></span></div>
            </a></div>
        </li>
        <!-- REPORTS -->
        <li class="nav-item">
          <p class="navbar-vertical-label">Reports</p>
          <hr class="navbar-vertical-line" />
          <div class="nav-item-wrapper">
            <a class="nav-link dropdown-indicator label-1" href="#nv-forms" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-forms">
              <div class="d-flex align-items-center">
                <div class="dropdown-indicator-icon-wrapper"><span class="fas fa-caret-right dropdown-indicator-icon"></span></div>
                <span class="nav-link-icon"><i class="uil uil-file-alt"></i></span>
                <span class="nav-link-text">School Forms</span>
              </div>
            </a>
            <div class="parent-wrapper label-1">
              <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-forms">
                <li class="collapsed-nav-item-title d-none">School Forms</li>
                <li class="nav-item"><a class="nav-link" href="#">
                    <div class="d-flex align-items-center"><span class="nav-link-text">School Forms 1</span></div>
                  </a></li>
                <li class="nav-item"><a class="nav-link" href="#">
                    <div class="d-flex align-items-center"><span class="nav-link-text">School Forms 2</span></div>
                  </a></li>
              </ul>
            </div>
          </div>
        </li>
        <!-- NOTIFICATION -->
        <li class="nav-item">
          <p class="navbar-vertical-label">Notification</p>
          <hr class="navbar-vertical-line" />
          <div class="nav-item-wrapper"><a class="nav-link label-1" href="#">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-envelope-send"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Send Email</span></span></div>
            </a></div>
          <div class="nav-item-wrapper"><a class="nav-link label-1" href="#">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="uil uil-history"></i></span><span class="nav-link-text-wrapper"><span class="nav-link-text">History</span></span></div>
            </a></div>
        </li>
        <!-- ADMIN -->
        <li class="nav-item">
          <p class="navbar-vertical-label">Admin</p>
          <hr class="navbar-vertical-line" />
          <div class="nav-item-wrapper">
            <a class="nav-link label-1" href="#">
              <div class="d-flex align-items-center">
                <span class="nav-link-icon">
                  <i class="fa-solid fa-user-gear"></i>
                </span>
                <span class="nav-link-text-wrapper">
                  <span class="nav-link-text">User Management</span>
                </span>
              </div>
            </a>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <!-- Footer Toggle -->
  <div class="navbar-vertical-footer">
    <button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center">
      <span class="uil uil-left-arrow-to-left fs-8"></span>
      <span class="uil uil-arrow-from-right fs-8"></span>
      <span class="navbar-vertical-footer-text ms-2">Collapsed View</span>
    </button>
  </div>
</nav>