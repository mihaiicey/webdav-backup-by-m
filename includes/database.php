<?php
function webdav_backup_database() {
    global $wpdb;

    // Obține detaliile bazei de date din wp-config.php
    $db_host = DB_HOST;
    $db_user = DB_USER;
    $db_pass = DB_PASSWORD;
    $db_name = DB_NAME;

    // Creează conexiunea
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("❌ Eroare conexiune MySQL: " . $conn->connect_error);
    }

    // Obține toate tabelele bazei de date
    $tables = array();
    $sql = "SHOW TABLES";
    $result = $conn->query($sql);
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    $backup_sql = "";
    foreach ($tables as $table) {
        $result = $conn->query("SELECT * FROM " . $table);
        $num_fields = $result->field_count;

        $backup_sql .= "DROP TABLE IF EXISTS `$table`;\n";
        $row2 = $conn->query("SHOW CREATE TABLE `$table`")->fetch_row();
        $backup_sql .= $row2[1] . ";\n\n";

        while ($row = $result->fetch_row()) {
            $backup_sql .= "INSERT INTO `$table` VALUES(";
            for ($i = 0; $i < $num_fields; $i++) {
                $row[$i] = isset($row[$i]) ? addslashes($row[$i]) : "NULL";
                $row[$i] = preg_replace("/\n/", "\\n", $row[$i]);
                if (isset($row[$i])) {
                    $backup_sql .= "'" . $row[$i] . "'";
                } else {
                    $backup_sql .= "NULL";
                }
                if ($i < ($num_fields - 1)) $backup_sql .= ",";
            }
            $backup_sql .= ");\n";
        }
        $backup_sql .= "\n\n";
    }

    // Creează folderul de backup dacă nu există
    $backup_folder = WP_CONTENT_DIR . "/backups";
    if (!file_exists($backup_folder)) {
        mkdir($backup_folder, 0755, true);
    }

    // Salvează fișierul SQL
    $timestamp = date("Y-m-d_H-i");
    $site_name = sanitize_title(get_bloginfo('name'));
    $backup_file = "{$backup_folder}/{$site_name}_{$timestamp}.sql";
    
    file_put_contents($backup_file, $backup_sql);

    // Închide conexiunea la baza de date
    $conn->close();

    return $backup_file;
}