<?php
function webdav_backup_manual_page() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $include_db = isset($_POST["include_db"]);
        $selected_folders = isset($_POST["folders"]) ? $_POST["folders"] : [];
        $backup_file = webdav_create_backup($include_db, $selected_folders);
        if ($backup_file) {
            $upload_result = webdav_upload_backup($backup_file); // Verificăm return value

            if ($upload_result) {
                echo '<div class="updated"><p>✅ Backup realizat și încărcat cu succes pe server!</p></div>';
            } else {
                echo '<div class="error"><p>❌ Backup-ul a fost creat, dar nu s-a putut încărca pe server!</p></div>';
            }
        } else {
            echo '<div class="error"><p>❌ Eroare la crearea backup-ului!</p></div>';
        }
    }

    ?>
    <div class="wrap">
        <h2>Backup Manual</h2>
        <form method="post">
            <h3>Selectează foldere pentru backup:</h3>
            <label><input type="checkbox" name="folders[]" value="uploads"> Uploads</label><br>
            <label><input type="checkbox" name="folders[]" value="themes"> Themes</label><br>
            <label><input type="checkbox" name="folders[]" value="plugins"> Plugins</label><br>
            <h3>Opțiuni suplimentare:</h3>
            <label><input type="checkbox" name="include_db"> Include backup bază de date</label><br><br>
            <input type="submit" class="button-primary" value="Realizează Backup">
        </form>
    </div>
    <?php
}
?>
