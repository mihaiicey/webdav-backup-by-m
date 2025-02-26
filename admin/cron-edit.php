<?php
function webdav_backup_cron_edit_page() {

require_once dirname(__FILE__) . '/../includes/cron.php';

if (isset($_GET['cron_id'])) {
    $cron_id = $_GET['cron_id'];
    $cron_jobs = webdav_get_cron_jobs();

    if (!isset($cron_jobs[$cron_id])) {
        echo "<div class='error'><p>Cron job-ul nu a fost găsit!</p></div>";
        return;
    }

    $cron = $cron_jobs[$cron_id];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cron_jobs[$cron_id]['folders'] = isset($_POST["folders"]) ? $_POST["folders"] : [];
        $cron_jobs[$cron_id]['include_db'] = isset($_POST["include_db"]);
        $cron_jobs[$cron_id]['frequency'] = intval($_POST["frequency"]);
        $cron_jobs[$cron_id]['start_day'] = intval($_POST["start_day"]);
        $cron_jobs[$cron_id]['interval_days'] = intval($_POST["interval_days"]);

        update_option('webdav_cron_jobs', $cron_jobs);
        echo "<div class='updated'><p>Cron job modificat cu succes!</p></div>";
    }
?>
    <div class="wrap">
        <h2>Editează Cron Job</h2>
        <form method="post">
            <h3>Selectează foldere pentru backup:</h3>
            <label><input type="checkbox" name="folders[]" value="uploads" <?php echo in_array('uploads', $cron['folders']) ? 'checked' : ''; ?>> Uploads</label><br>
            <label><input type="checkbox" name="folders[]" value="themes" <?php echo in_array('themes', $cron['folders']) ? 'checked' : ''; ?>> Themes</label><br>
            <label><input type="checkbox" name="folders[]" value="plugins" <?php echo in_array('plugins', $cron['folders']) ? 'checked' : ''; ?>> Plugins</label><br>

            <h3>Include backup bază de date?</h3>
            <label><input type="checkbox" name="include_db" <?php echo $cron['include_db'] ? 'checked' : ''; ?>> Da</label><br>

            <h3>Ziua de start în lună:</h3>
            <input type="number" name="start_day" min="1" max="31" value="<?php echo $cron['start_day']; ?>"><br>

            <h3>La câte zile diferență să facă backup?</h3>
            <input type="number" name="interval_days" min="1" max="30" value="<?php echo $cron['interval_days']; ?>"><br>

            <h3>Frecvența backup-ului (de câte ori pe lună):</h3>
            <input type="number" name="frequency" min="1" max="30" value="<?php echo $cron['frequency']; ?>"><br><br>

            <input type="submit" class="button-primary" value="Salvează modificările">
        </form>
    </div>
<?php }

}