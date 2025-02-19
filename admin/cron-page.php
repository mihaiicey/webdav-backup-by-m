<?php
function webdav_backup_cron_page() {
    if (isset($_GET['delete_cron'])) {
        webdav_delete_cron_job($_GET['delete_cron']);
        echo '<div class="updated"><p>Cron job șters cu succes!</p></div>';
    }

    $cron_jobs = webdav_get_cron_jobs();
    ?>
    <div class="wrap">
        <h2>Gestionare Cron Jobs</h2>
        <a href="<?php echo admin_url('admin.php?page=webdav-backup-cron-add'); ?>" class="button button-primary">➕ Adaugă Cron Job</a>
        <br><br>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foldere</th>
                    <th>Bază de date</th>
                    <th>Ziua start</th>
                    <th>Interval zile</th>
                    <th>Ultima rulare</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($cron_jobs)): ?>
                    <tr><td colspan="7">Nu există cron jobs active.</td></tr>
                <?php else: ?>
                    <?php foreach ($cron_jobs as $cron): ?>
                        <tr>
                            <td><?php echo esc_html($cron['id']); ?></td>
                            <td><?php echo implode(', ', $cron['folders']); ?></td>
                            <td><?php echo $cron['include_db'] ? '✔️' : '❌'; ?></td>
                            <td><?php echo $cron['start_day']; ?></td>
                            <td><?php echo $cron['interval_days']; ?></td>
                            <td><?php echo $cron['last_run']; ?></td>
                            <td>
                                <a href="?page=webdav-backup-cron&delete_cron=<?php echo esc_attr($cron['id']); ?>" class="button button-secondary">Șterge</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
