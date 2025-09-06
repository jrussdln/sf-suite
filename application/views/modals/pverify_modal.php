<!-- Password Verification Modal -->
<div class="modal fade" id="passwordVerifyModal" tabindex="-1" aria-labelledby="passwordVerifyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <!-- Header -->
      <div class="modal-header rounded-top py-2 px-3">
        <h6 class="modal-title fs-9 m-0" id="passwordVerifyModalLabel">
          Password Verification
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form id="passwordVerifyForm" method="post" action="<?= base_url('main/verifyPassword') ?>">
        
        <!-- Body -->
        <div class="modal-body py-3 px-3">
          <div class="mb-3">
            <label for="verifyPasswordInput" class="form-label text-sm fw-semibold">
              Enter Password
            </label>
            <input 
              type="password" 
              id="verifyPasswordInput" 
              name="password" 
              placeholder="Password"
              autocomplete="off"
              required
              class="form-control form-control-sm"
            >
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between py-2 px-3">
          <!-- Left side -->
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
            Cancel
          </button>

          <!-- Right side -->
          <button type="submit" class="btn btn-primary btn-sm">
            Verify
          </button>
        </div>
        
      </form>
    </div>
  </div>
</div>
