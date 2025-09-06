<?php
$this->load->view('partials/header');
?>
<main class="main" id="top">
    <div class="container">
        <div class="row flex-center min-vh-100 py-5">
            <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3">
                <a class="d-flex flex-center text-decoration-none mb-4" href="<?= base_url('auth') ?>">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block">
                        <img src="<?= base_url('assets/img/school/3.png') ?>" alt="phoenix" width="58" />
                    </div>
                </a>
                <div class="text-center mb-4">
                    <h3 class="text-body-highlight">LOG IN</h3>
                    <p class="text-body-tertiary">SF-SUITE: PVPMNHS</p>
                </div>
                <button class="btn btn-phoenix-secondary w-100 mb-1"><span class="fab fa-google text-danger me-2 fs-9"></span>Sign in with google</button>
                <div class="position-relative">
                    <hr class="bg-body-secondary mt-4 mb-3" />
                    <div class="divider-content-center">or use username</div>
                </div>
                <!-- START login form -->
                <form id="formLoginDesktop" action="<?= site_url('auth/login_process') ?>" method="POST">
                    <?php if ($this->session->flashdata('login_error')): ?>
                        <div id="loginStatus" style="color: #ff0505ff; font-weight: 400; font-size: 0.775rem; margin-bottom: 1px; text-align: center;">
                            <?= $this->session->flashdata('login_error') ?>
                        </div>
                    <?php elseif ($this->session->flashdata('redirecting')): ?>
                        <div id="loginStatus" style="color: #28a745; font-weight: 400; font-size: 0.775rem; margin-bottom: 1px; display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                            <span><?= $this->session->flashdata('redirecting') ?></span>
                            <span class="dot-circle-spinner"></span>
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.href = "<?= $this->session->flashdata('redirect_to') ?>";
                            }, 3000);
                        </script>
                    <?php endif; ?>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="username">Username</label>
                        <div class="form-icon-container">
                            <input class="form-control form-icon-input" id="username" name="username" type="text" placeholder="Username" required
                                value="<?= $this->session->flashdata('old_username') ?>" />
                            <span class="fas fa-user text-body fs-9 form-icon"></span>
                        </div>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="passwordInputDesktop">Password</label>
                        <div class="form-icon-container" data-password="data-password">
                            <input class="form-control form-icon-input pe-6" id="passwordInputDesktop" name="password" type="password" placeholder="Password" required data-password-input="data-password-input" />
                            <span class="fas fa-key text-body fs-9 form-icon"></span>
                            <button type="button" class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary" id="togglePasswordIconDesktop" data-password-toggle="data-password-toggle">
                                <span class="uil uil-eye show"></span>
                                <span class="uil uil-eye-slash hide"></span>
                            </button>
                        </div>
                    </div>
                    <div class="row flex-between-center mb-7">
                        <div class="col-auto">
                            <div class="form-check mb-0">
                                <input class="form-check-input" id="agreeCheckboxDesktop" name="agree" type="checkbox" required checked />
                                <label class="form-check-label mb-0" for="agreeCheckboxDesktop">Do you agree to the Privacy Consent Notice?</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a class="fs-9 fw-semibold" href="<?= base_url('auth/load_fpass') ?>">Forgot Password?</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
                </form>
                <!-- END login form -->
            </div>
        </div>
        <script>
            const togglePassword = document.getElementById('togglePasswordIconDesktop');
            const passwordInput = document.getElementById('passwordInputDesktop');
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                // Toggle the eye icons
                togglePassword.querySelector('.uil-eye').classList.toggle('d-none');
                togglePassword.querySelector('.uil-eye-slash').classList.toggle('d-none');
            });
        </script>
    </div>
    <?php include APPPATH . 'views/modals/main_modal.php'; ?>
</main>
<!--    End of Main Content-->
</main>
<?php $this->load->view('partials/footer'); ?>
</body>
</html>