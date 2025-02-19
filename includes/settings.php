<?php
// Salvare setări
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["webdav_settings"])) {
    update_option('webdav_url', sanitize_text_field($_POST["webdav_url"]));
    update_option('webdav_user', sanitize_text_field($_POST["webdav_user"]));
    update_option('webdav_pass', sanitize_text_field($_POST["webdav_pass"]));
}

// Obținere setări salvate
$webdav_url = get_option('webdav_url', '');
$webdav_user = get_option('webdav_user', '');
$webdav_pass = get_option('webdav_pass', '');
