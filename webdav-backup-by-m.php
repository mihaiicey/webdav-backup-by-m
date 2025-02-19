<?php
/**
 * Plugin Name: WebDav Backup by M
 * Plugin URI: https://mihaidev.ro
 * Description: Plugin pentru backup automat/manual pe WebDAV.
 * Version: 1.0
 * Author: Mihai Ciufudean
 * Author URI: https://mihaidev.ro
 * License: GPL2
 */

if (!defined('ABSPATH')) exit;

// Definim constantele pluginului
define('WEBDAV_BACKUP_DIR', plugin_dir_path(__FILE__));
define('WEBDAV_BACKUP_URL', plugin_dir_url(__FILE__));

// Include funcționalitățile
require_once WEBDAV_BACKUP_DIR . 'includes/settings.php';
require_once WEBDAV_BACKUP_DIR . 'includes/backup.php';
require_once WEBDAV_BACKUP_DIR . 'includes/cron.php';
require_once WEBDAV_BACKUP_DIR . 'includes/database.php';
require_once WEBDAV_BACKUP_DIR . 'includes/webdav.php';

// Include paginile din Admin
require_once WEBDAV_BACKUP_DIR . 'admin/settings-page.php';
require_once WEBDAV_BACKUP_DIR . 'admin/backup-page.php';
require_once WEBDAV_BACKUP_DIR . 'admin/cron-page.php';
require_once WEBDAV_BACKUP_DIR . 'admin/cron-add.php';

// Adaugă meniul în admin
// Adaugă meniul în admin
function webdav_backup_menu() {
    add_menu_page(
        'WebDAV Backup',
        'WebDAV Backup',
        'manage_options',
        'webdav-backup',
        'webdav_backup_settings_page',
        'dashicons-cloud'
    );

    add_submenu_page(
        'webdav-backup',
        'Backup Manual',
        'Backup Manual',
        'manage_options',
        'webdav-backup-manual',
        'webdav_backup_manual_page'
    );

    add_submenu_page(
        'webdav-backup',
        'Cron Jobs',
        'Cron Jobs',
        'manage_options',
        'webdav-backup-cron',
        'webdav_backup_cron_page'
    );

    // 🔹 Adăugăm "Adaugă Cron Job" ca pagină de admin, dar nu în meniu
    add_submenu_page(
        'webdav-backup',  // NULL ascunde această pagină din meniu
        'Adaugă Cron Job',
        'Adaugă Cron Job',
        'manage_options',
        'webdav-backup-cron-add',
        'webdav_backup_cron_add_page'
    );
}
add_action('admin_menu', 'webdav_backup_menu');
