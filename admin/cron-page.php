<?php
function webdav_backup_cron_page() {
    if (isset($_GET['delete_cron'])) {
        webdav_delete_cron_job($_GET['delete_cron']);
        echo '<div class="updated"><p>Cron job șters cu succes!</p></div>';
    }

    $cron_jobs = webdav_get_cron_jobs();
    ?>
    <div class="wrap">
    <h2>Lista Cron Jobs</h2>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foldere</th>
                <th>Include DB</th>
                <th>Frecvență</th>
                <th>Ziua de start</th>
                <th>Interval zile</th>
                <th>Ultima rulare</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cron_jobs = webdav_get_cron_jobs();
            foreach ($cron_jobs as $cron) {
                echo "<tr>
                        <td>{$cron['id']}</td>
                        <td>" . implode(", ", $cron['folders']) . "</td>
                        <td>" . ($cron['include_db'] ? 'Da' : 'Nu') . "</td>
                        <td>{$cron['frequency']} ori/lună</td>
                        <td>{$cron['start_day']}</td>
                        <td>{$cron['interval_days']} zile</td>
                        <td>{$cron['last_run']}</td>
                        <td>
                            <a href='?page=cron-edit&cron_id={$cron['id']}' class='button'>Editează</a>
                            <a href='?page=cron-delete&cron_id={$cron['id']}' class='button' onclick='return confirm(\"Sigur ștergi acest cron?\");'>Șterge</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
}