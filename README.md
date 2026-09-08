# The Fashion Frame — WordPress Website

This repository contains the complete codebase, custom luxury theme (`the-fashion-frame`), WooCommerce templates, uploads, plugins, and database export for **The Fashion Frame**.

---

## 📁 Repository Structure

- `wp-content/themes/the-fashion-frame/`: Custom luxury WordPress theme.
- `wp-content/plugins/`: WooCommerce and required plugins.
- `wp-content/uploads/`: All product photos, category cards, logo, banners, and media assets.
- `database/latest-db-backup.sql`: Complete MySQL database export (products, categories, prices, options, site settings).
- `wp-config-production.sample.php`: Sample database configuration for Hostinger.

---

## 🚀 Hostinger Deployment Guide

### Step 1: Connect Git Repository in Hostinger
1. Log in to **Hostinger hPanel**.
2. Navigate to **Advanced** → **Git**.
3. Under **Create a New Repository**:
   - **Repository URL**: `https://github.com/adityasinghseo/thefashionframe.git`
   - **Branch**: `main`
   - **Install Directory**: `/public_html` (or leave default root)
4. Click **Create** to automatically deploy the files.

### Step 2: Set Up the Database
1. In Hostinger hPanel, go to **Databases** → **Management**.
2. Create a new MySQL Database and Database User (note down Database Name, Username, and Password).
3. Open **phpMyAdmin** for your new database.
4. Click **Import** and select `database/latest-db-backup.sql`.
5. Once imported, update the `siteurl` and `home` options in the `wp_options` table to match your live domain (e.g. `https://yourdomain.com`).

### Step 3: Configure Database Credentials
1. In Hostinger File Manager inside `/public_html`:
2. Copy `wp-config-production.sample.php` to `wp-config-production.php`.
3. Update `DB_NAME`, `DB_USER`, and `DB_PASSWORD` with your Hostinger database details.
*(Note: `wp-config-production.php` is ignored by git so future `git pull` updates will never overwrite your server credentials or conflict).*

---

## 🔄 Automatic Live Updates
When connected via Hostinger Git, any changes pushed to the `main` branch (theme design, templates, styles, media) can be pulled automatically or with a single click via **Auto Deployment** or **Deploy** in Hostinger hPanel.
