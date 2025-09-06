<?php $this->load->view('partials/header'); ?>
<main class="main" id="top">
    <?php
    $this->load->view('partials/left-navbar');
    $this->load->view('partials/top-navbar');
    ?>
    <div class="content" id="content">
        <div id="dynamic-content" style="margin:0;"></div>
        <?php $this->load->view('partials/bot-navbar'); ?>
    </div>
    <?php
    $this->load->view('modals/main_modal');
    $this->load->view('modals/pverify_modal'); // pass variables if needed
    $this->load->view('modals/academic_modal', [
        'all_curriculums' => $all_curriculums ?? [],
        'all_active_curriculums' => $all_active_curriculums ?? [],
        'all_strands' => $all_strands ?? [],
        'all_years' => $all_years ?? []
    ]);
    ?>
</main>
<?php $this->load->view('partials/footer'); ?>
<script>
    $(document).ready(function() {
        function loadContent(url) {
            // Highlight active menu item based on url
            $('.nav-ajax').removeClass('active');
            $('.nav-ajax[href="' + url + '"]').addClass('active');
            // Load content immediately without fade out
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#dynamic-content').html(response);
                },
                error: function() {
                    $('#dynamic-content').html('<p class="p-3 text-danger">Failed to load content.</p>');
                }
            });
        }
        // On nav-ajax click
        $(document).on('click', '.nav-ajax', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            // Save the URL to localStorage
            localStorage.setItem('lastNavUrl', url);
            loadContent(url);
        });
        // On page load, load saved URL or default first nav link
        var savedUrl = localStorage.getItem('lastNavUrl');
        if (savedUrl) {
            loadContent(savedUrl);
        } else {
            var firstUrl = $('.nav-ajax').first().attr('href');
            if (firstUrl) {
                loadContent(firstUrl);
            }
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
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
        // Run on page load (in case Grade Level is already selected)
        toggleStrandTrack();
        // Run every time Grade Level changes
        gradeLevelSelect.addEventListener('change', toggleStrandTrack);
    });
    const userId = "<?= $this->session->userdata('user_id'); ?>";
    function loadNotifications() {
        $.ajax({
            url: "<?= base_url('main/fetchNotifications'); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                let notifications = response.notifications;
                let unreadCount = response.unread_count;
                let container = $(".scrollbar-overlay");
                container.html("");
                // Update badge on bell icon
                if (unreadCount > 0) {
                    $("#notifCountBadge").text(unreadCount).show();
                } else {
                    $("#notifCountBadge").hide();
                }
                if (notifications.length === 0) {
                    container.html('<div class="text-center text-muted py-3">No notifications found.</div>');
                    return;
                }
                // Populate notifications list
                notifications.forEach(n => {
                    let fullName = n.full_name || 'System Notice';
                    let readClass = n.notif_read == 1 ? "read" : "unread";
                    container.append(`
                    <div class="px-2 px-sm-3 py-3 notification-card position-relative ${readClass} border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex">
                                <div class="avatar avatar-m me-3">
                                    <img class="rounded-circle" src="<?= base_url('assets/img/logos/profile_logo.png') ?>" alt="User Avatar" />
                                </div>
                                <div class="flex-1 me-sm-3">
                                    <h4 class="fs-9 text-body-emphasis mb-1">${fullName}</h4>
                                    <p class="fs-9 text-body-highlight mb-2 fw-normal">
                                        ${n.notif_desc}
                                        <span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">${timeAgo(n.created_at)}</span>
                                    </p>
                                    <p class="text-body-secondary fs-9 mb-0">
                                        <span class="me-1 fas fa-clock"></span>
                                        <span class="fw-bold">${formatDateTime(n.created_at)}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                });
            },
            error: function() {
                $(".scrollbar-overlay").html('<div class="text-center text-danger py-3">Failed to load notifications.</div>');
            }
        });
    }
    function timeAgo(dateString) {
        let date = new Date(dateString);
        let now = new Date();
        let diff = Math.floor((now - date) / 1000);
        if (diff < 60) return diff + "s ago";
        if (diff < 3600) return Math.floor(diff / 60) + "m ago";
        if (diff < 86400) return Math.floor(diff / 3600) + "h ago";
        return date.toLocaleDateString();
    }
    function formatDateTime(dateString) {
        let date = new Date(dateString);
        return date.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        }) + " " + date.toLocaleDateString();
    }
    // Load notifications on page load
    loadNotifications();
    $("#markAllRead").on("click", function() {
        $.post("<?= base_url('main/markAllNotificationsRead'); ?>", function() {
            loadNotifications();
        });
    });
    
</script>
</body>
</html>