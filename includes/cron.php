<?php
// Funcție pentru listarea cronurilor salvate
function webdav_get_cron_jobs() {
    $cron_jobs = get_option('webdav_cron_jobs', []);
    return is_array($cron_jobs) ? $cron_jobs : [];
}

// Funcție pentru salvarea unui nou cron job
function webdav_add_cron_job($folders, $include_db, $frequency, $start_day, $interval_days) {
    $cron_jobs = webdav_get_cron_jobs();
    $cron_id = uniqid('cron_', true);

    $cron_jobs[$cron_id] = [
        'id' => $cron_id,
        'folders' => $folders,
        'include_db' => $include_db,
        'frequency' => $frequency,
        'start_day' => $start_day,
        'interval_days' => $interval_days,
        'last_run' => 'Niciodată'
    ];

    update_option('webdav_cron_jobs', $cron_jobs);
    return true;
}

// Funcție pentru ștergerea unui cron job
function webdav_delete_cron_job($cron_id) {
    $cron_jobs = webdav_get_cron_jobs();
    if (isset($cron_jobs[$cron_id])) {
        unset($cron_jobs[$cron_id]);
        update_option('webdav_cron_jobs', $cron_jobs);
        return true;
    }
    return false;
}

// Funcție pentru rularea cronurilor programate
function webdav_run_scheduled_backups() {
    $cron_jobs = webdav_get_cron_jobs();
    $current_day = date('j'); // Ziua curentă a lunii

    foreach ($cron_jobs as $cron_id => $cron) {
        if ($current_day >= $cron['start_day']) {
            $days_since_last_run = (strtotime(date("Y-m-d")) - strtotime($cron['last_run'])) / 86400;

            if ($days_since_last_run >= $cron['interval_days'] || $cron['last_run'] == 'Niciodată') {
                $backup_path = webdav_create_backup($cron['include_db'], $cron['folders']);
                webdav_upload_backup($backup_path);
                $cron_jobs[$cron_id]['last_run'] = date("Y-m-d");
            }
        }
    }
    update_option('webdav_cron_jobs', $cron_jobs);
}

// Rulează cron job-urile programate
add_action('webdav_run_scheduled_backups', 'webdav_run_scheduled_backups');

// Adaugă cron job în WordPress Scheduler
if (!wp_next_scheduled('webdav_run_scheduled_backups')) {
    wp_schedule_event(time(), 'daily', 'webdav_run_scheduled_backups');
}
