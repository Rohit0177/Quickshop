# Quickshop

Quickshop is a PHP/MySQL shopping application with a customer-facing storefront and an administration area.

## Requirements

- Apache or another web server configured to run PHP
- PHP with the `mysqli` extension enabled
- MySQL or MariaDB

## Run locally with WampServer

1. Copy or clone this project into the WampServer web root, for example `C:\wamp64\www\Quickshop`.
2. In phpMyAdmin, create a database named `shopping`.
3. Import `SQL file/shopping (1).sql` into that database. **The dump contains `DROP TABLE IF EXISTS` statements**, so use an empty or disposable database; importing it can replace tables with matching names.
4. Configure the database connection in both files:
   - `shopping/includes/config.php`
   - `shopping/admin/includes/config.php`

   Set `DB_SERVER`, `DB_USER`, `DB_PASS`, and `DB_NAME` to match your local MySQL setup. Both files need to use the same database.
5. Start Apache and MySQL in WampServer, then visit:
   - Storefront: `http://localhost/Quickshop/shopping/`
   - Admin area: `http://localhost/Quickshop/shopping/admin/`

The application files are in the `shopping/` directory. If you configure your web server's document root to point directly to that directory, use `/` and `/admin/` as the corresponding paths.

## Publish the source on GitHub

Create a GitHub repository and push this project using Git, or use GitHub's upload interface. GitHub stores and versions the source code, but **GitHub Pages cannot run PHP or provide a MySQL database**. To host the working application online, use a PHP/MySQL hosting provider, upload the contents of `shopping/`, create a database there, import a reviewed database dump, and update both config files with the host's database settings.

Before making the repository public:

- Review the SQL dump and remove or anonymize any real customer, administrator, or other sensitive data. It includes existing database records and should not be assumed safe to publish.
- Do not publish production database credentials. Replace the local example settings in both config files with a secure configuration method before deploying.
- Keep backups of any existing database before importing the dump.

## Project layout

- `shopping/` — storefront, admin area, PHP includes, styles, scripts, and images
- `shopping/admin/` — administration pages
- `SQL file/shopping (1).sql` — MySQL database dump
