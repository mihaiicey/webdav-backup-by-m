<?php
function webdav_backup_cron_add_page() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $folders = isset($_POST["folders"]) ? $_POST["folders"] : [];
        $include_db = isset($_POST["include_db"]);
        $frequency = isset($_POST["frequency"]) ? intval($_POST["frequency"]) : 1;
        $start_day = isset($_POST["start_day"]) ? intval($_POST["start_day"]) : 1;
        $interval_days = isset($_POST["interval_days"]) ? intval($_POST["interval_days"]) : 7;

        webdav_add_cron_job($folders, $include_db, $frequency, $start_day, $interval_days);
        echo '<div class="updated"><p>Cron job adăugat cu succes!</p></div>';
    }
    ?>
    <div class="wrap">
        <h2>Adaugă un nou cron job</h2>
        <form method="post">
            <h3>Selectează foldere pentru backup:</h3>
            <label><input type="checkbox" name="folders[]" value="uploads"> Uploads</label><br>
            <label><input type="checkbox" name="folders[]" value="themes"> Themes</label><br>
            <label><input type="checkbox" name="folders[]" value="plugins"> Plugins</label><br>

            <h3>Include backup bază de date?</h3>
            <label><input type="checkbox" name="include_db"> Da</label><br>

            <h3>Ziua de start în lună:</h3>
            <input type="number" name="start_day" min="1" max="31" value="1"><br>

            <h3>La câte zile diferență să facă backup?</h3>
            <input type="number" name="interval_days" min="1" max="30" value="7"><br><br>

            <h3>Frecvența backup-ului (în zile):</h3>
            <input type="number" name="frequency" min="1" max="30" value="1"><br><br>
            
            <input type="submit" class="button-primary" value="Adaugă Cron Job">
        </form>
    </div>
    <?php
}