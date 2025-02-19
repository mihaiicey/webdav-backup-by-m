<?php
function webdav_create_backup($include_db = false, $selected_folders = []) {
    $timestamp = date("Y-m-d_H-i");
    $site_name = sanitize_title(get_bloginfo('name'));
    $backup_folder = WP_CONTENT_DIR . "/backups";
    $backup_name = "{$site_name}_{$timestamp}.zip";
    $backup_path = "{$backup_folder}/{$backup_name}";

    // 🔹 Creează folderul de backup dacă nu există
    if (!file_exists($backup_folder)) {
        mkdir($backup_folder, 0755, true);
    }

    // 🔹 Inițializează arhivarea
    $zip = new ZipArchive();
    if ($zip->open($backup_path, ZipArchive::CREATE) !== TRUE) {
        return false;
    }

    // 🔹 Adaugă folderele selectate în arhivă
    foreach ($selected_folders as $folder) {
        $folder_path = WP_CONTENT_DIR . '/' . $folder;
        if (is_dir($folder_path)) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder_path, RecursiveDirectoryIterator::SKIP_DOTS));
            foreach ($files as $file) {
                if ($file->isFile()) {
                    $relativePath = str_replace(WP_CONTENT_DIR . '/', '', $file->getRealPath());
                    $zip->addFile($file->getRealPath(), $relativePath);
                }
            }
        }
    }

    // 🔹 Include backup-ul bazei de date, dacă este selectat
    if ($include_db) {
        require_once "database.php";
        $db_backup = webdav_backup_database();
        if ($db_backup) {
            $zip->addFile($db_backup, basename($db_backup));
        }
    }

    $zip->close();
    return $backup_path;
}