# webdav-backup-by-m

Un plugin pentru gestionarea backup-urilor prin WebDAV, optimizat pentru Nextcloud.

## Structura proiectului

```
webdav-backup-by-m/
│-- admin/
│   ├── backup-page.php
│   ├── cron-add.php
│   ├── cron-edit.php
│   ├── cron-page.php
│   ├── settings-page.php
│-- includes/
│   ├── backup.php
│   ├── cron.php
│   ├── database.php
│   ├── settings.php
│   ├── webdav.php
│-- webdav-backup-by-m.php
```

## Descriere

`webdav-backup-by-m` este un plugin pentru WordPress care oferă o soluție de backup utilizând protocolul WebDAV, optimizat pentru Nextcloud. Acesta permite utilizatorilor să configureze și să gestioneze backup-uri automate direct din panoul de administrare WordPress.

## Funcționalități

- Backup automat / manual folosind WebDAV
- Configurare prin panoul de administrare WordPress
- Gestionare și editare a cron job-urilor


## Instalare

1. Clonați sau descărcați acest repository:
   ```sh
   git clone https://github.com/utilizator/webdav-backup-by-m.git
   ```
2. Mutați folderul `webdav-backup-by-m` în directorul `wp-content/plugins/`.
3. Activați pluginul din panoul de administrare WordPress.

## Configurare

1. Accesezi meniul `WebDAV Backup` din WordPress admin .
2. Configurați serverul WebDAV (URL, utilizator, parolă, setezi folderul de încărcare a fișierelor).**Folderul trebuie să fie deja creat pe Nextcloud.**
3. Poți seta frecvența backup-urilor în secțiunea `Cron Jobs`.
4. Poți crea un backup manual în secțiunea `Backup Manual`.

## Dependențe

- PHP  8+
- WordPress 5.8+
- Server Nextcloud cu suport WebDAV

## Dezvoltare

1. După instalare, puteți modifica fișierele sursă în folderul `admin/` și `includes/`.
2. Pentru a adăuga funcționalități suplimentare, editați `webdav-backup-by-m.php`.
3. Contribuțiile sunt binevenite! Puteți face un pull request sau deschide un issue pe GitHub.

## Licență

Acest proiect este distribuit sub licența MIT. Consultați fișierul `LICENSE` pentru mai multe detalii.

---

📌 **Notă:** Acest plugin este în dezvoltare activă. Orice sugestie sau contribuție este binevenită!
