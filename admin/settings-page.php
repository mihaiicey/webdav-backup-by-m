<?php
function webdav_backup_settings_page() {
    // Salvare setări
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        update_option('webdav_url', sanitize_text_field($_POST["webdav_url"]));
        update_option('webdav_user', sanitize_text_field($_POST["webdav_user"]));
        update_option('webdav_pass', sanitize_text_field($_POST["webdav_pass"]));
        echo '<div class="updated"><p>Setările au fost salvate!</p></div>';
    }

    // Obținere setări
    $webdav_url = get_option('webdav_url', '');
    $webdav_user = get_option('webdav_user', '');
    $webdav_pass = get_option('webdav_pass', '');

    ?>
    <div class="wrap">
        <h2>Setări WebDAV</h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th><label for="webdav_url">URL WebDAV</label></th>
                    <td><input type="text" name="webdav_url" value="<?php echo esc_attr($webdav_url); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="webdav_user">Utilizator</label></th>
                    <td><input type="text" name="webdav_user" value="<?php echo esc_attr($webdav_user); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="webdav_pass">Parolă</label></th>
                    <td><input type="password" name="webdav_pass" value="<?php echo esc_attr($webdav_pass); ?>" class="regular-text"></td>
                </tr>
            </table>
            <p><input type="submit" class="button-primary" value="Salvează"></p>
        </form>
    </div>
    <?php
}
?>
