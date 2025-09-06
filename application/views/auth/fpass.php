<?php
$this->load->view('partials/header');
?>
<main class="main" id="top">
  <div class="container">
    <div class="row flex-center min-vh-100 py-5">
      <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4"><a class="d-flex flex-center text-decoration-none mb-4" href="<?= base_url('auth') ?>">
          <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img src="<?= base_url('assets/img/school/3.png') ?>" alt="phoenix" width="58" /></div>
        </a>
        <div class="px-xxl-5">
          <div class="text-center mb-6">
            <h4 class="text-body-highlight">FORGOT PASSWORD</h4>
            <p class="text-body-tertiary mb-3">
              Enter your username below and we will send <br class="d-sm-none" />
              you a new password.
            </p>
            <div id="recoverStatus" class="mb-3">
              <?php if ($this->session->flashdata('recover_success')): ?>
                <div style="color: #198754; font-weight: 400; font-size: 0.775rem;">
                  <?= $this->session->flashdata('recover_success') ?>
                </div>
              <?php elseif ($this->session->flashdata('recover_error')): ?>
                <div style="color: #dc3545; font-weight: 400; font-size: 0.775rem;">
                  <?= $this->session->flashdata('recover_error') ?>
                </div>
              <?php endif; ?>
            </div>
            <!-- Forgot Password Form with backend integration -->
            <form id="recoverForm" action="<?= site_url('auth/fpass_process') ?>" method="POST" class="d-flex align-items-center mb-5">
              <input
                class="form-control flex-1"
                type="text"
                name="fp_username"
                id="fp_username"
                placeholder="Username"
                required />
              <button type="submit" id="verifyButton" class="btn btn-primary ms-2">
                Send
                <span class="fas fa-chevron-right ms-2"></span>
              </button>
            </form>
            <a class="fs-9 fw-bold" href="<?= base_url('auth') ?>">LOGIN</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include APPPATH . 'views/modals/main_modal.php'; ?>
</main>
<!--    End of Main Content-->
</main>
<?php $this->load->view('partials/footer'); ?>
</body>
</html>