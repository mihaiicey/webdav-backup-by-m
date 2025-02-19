<?php
function webdav_upload_backup($file_path) {
    $url = get_option('webdav_url'); // URL WebDAV principal
    $user = get_option('webdav_user');
    $pass = get_option('webdav_pass');

    // 🔹 Verifică dacă fișierul există înainte de upload
    if (!file_exists($file_path)) {
        error_log("❌ Eroare: Fișierul de backup nu există - $file_path");
        return false;
    }

    // 🔹 Deschide fișierul pentru upload
    $fileHandle = fopen($file_path, 'r');
    if (!$fileHandle) {
        error_log("❌ Eroare: Nu am putut deschide fișierul de backup pentru citire.");
        return false;
    }

    // 🔹 Setează calea corectă în WebDAV
    $file_name = basename($file_path);
    $remote_url = rtrim($url, '/') . "/serverbackups/" . $file_name; 

    // 🔹 Inițializează cURL pentru upload
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_url);
    curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
    curl_setopt($ch, CURLOPT_PUT, true);
    curl_setopt($ch, CURLOPT_INFILE, $fileHandle);
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file_path));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);
    fclose($fileHandle);

    // 🔹 Verifică dacă upload-ul a fost reușit
    if ($http_code == 201 || $http_code == 204) {
        return true;
    } else {
        error_log("❌ Eroare la încărcare pe WebDAV. Cod HTTP: $http_code | Eroare cURL: $curl_error");
        return false;
    }
}

