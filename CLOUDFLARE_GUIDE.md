# Cloudflare D1 & R2 Setup and Usage Guide

This project is configured to use **Cloudflare D1** (serverless SQL database) and **Cloudflare R2** (S3-compatible distributed object storage), complete with a cross-platform setup script for Windows, Linux, and macOS.

---

## 📋 Prerequisites

Before getting started, make sure you have:
1. **PHP 8.2+** and **Composer**
2. **Node.js 18+** and **npm**
3. A free or paid **Cloudflare Account** ([dash.cloudflare.com](https://dash.cloudflare.com))

---

## 🚀 Quick Start

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Run the Setup Wizard

#### Option A: Interactive Wizard (Recommended)
Launches an interactive menu with guided setup, automatic authentication via Wrangler, and `.env` configuration:

```bash
npm run setup:cloudflare
# or
node scripts/setup-cloudflare.mjs
```

#### Option B: Connect to Existing Remote Cloudflare Resources
If you already have a D1 database and R2 bucket created:

```bash
npm run configure:cloudflare
# or
node scripts/setup-cloudflare.mjs --connect
```
*The script will query Cloudflare, display a numbered list of your existing D1 databases and R2 buckets, let you pick which one to use, and automatically save the credentials to your `.env`.*

#### Option C: Non-Interactive / CI/CD Mode
For automated pipelines or scripted environments:

```bash
node scripts/setup-cloudflare.mjs --connect \
  --account-id="YOUR_ACCOUNT_ID" \
  --db-id="YOUR_D1_DATABASE_UUID" \
  --api-token="YOUR_CLOUDFLARE_API_TOKEN" \
  --bucket-name="YOUR_R2_BUCKET" \
  --r2-key="YOUR_R2_ACCESS_KEY_ID" \
  --r2-secret="YOUR_R2_SECRET_ACCESS_KEY" \
  --r2-url="https://pub-xxxx.r2.dev" \
  --yes
```

---

## 🔑 Obtaining Cloudflare Credentials Manually

If you prefer to configure `.env` by hand, you will need the following values:

### 1. Cloudflare Account ID
- Log in to [dash.cloudflare.com](https://dash.cloudflare.com).
- Your **Account ID** is visible in the URL immediately following `dash.cloudflare.com/` (e.g. `dash.cloudflare.com/1234567890abcdef1234567890abcdef/...`), or on the right sidebar under **Account Details**.

### 2. D1 API Token
- Go to [dash.cloudflare.com/profile/api-tokens](https://dash.cloudflare.com/profile/api-tokens).
- Click **Create Token** → **Create Custom Token**.
- Add the permission:
  - **Account** → **D1** → **Edit**
- Click **Continue to summary** and **Create Token**.
- Set in `.env`: `CLOUDFLARE_D1_API_TOKEN=<token>`

### 3. R2 S3 Access Keys (Access Key ID & Secret)
- In the Cloudflare Dashboard, go to **R2** → **Manage R2 API Tokens**.
- Click **Create API Token**.
- Permissions: **Object Read & Write** (or Admin Read & Write).
- Copy the generated **Access Key ID** and **Secret Access Key**.
- Set in `.env`:
  ```env
  FILESYSTEM_DISK=r2
  FILESYSTEM_PRIVATE_DISK=r2-private
  CLOUDFLARE_R2_ACCESS_KEY_ID=<your-access-key-id>
  CLOUDFLARE_R2_SECRET_ACCESS_KEY=<your-secret-access-key>
  CLOUDFLARE_R2_ENDPOINT=https://<your-account-id>.r2.cloudflarestorage.com
  CLOUDFLARE_R2_BUCKET=spp-public
  CLOUDFLARE_R2_PRIVATE_BUCKET=spp-private
  CLOUDFLARE_R2_URL=https://pub-xxxx.r2.dev   # (or custom domain like https://cdn.example.com)
  ```

---

## 🔒 Public vs. Private Storage Architecture

| Bucket / Disk | Access Level | Purpose | URL / Delivery Method |
| :--- | :--- | :--- | :--- |
| **`r2`** (`CLOUDFLARE_R2_BUCKET`) | **Public** (Domain enabled in Cloudflare) | Article cover images, event banners, inline markdown images, avatars. | Direct CDN URLs (`$model->image_url` or `Storage::url()`) with zero egress fees. |
| **`r2-private`** (`CLOUDFLARE_R2_PRIVATE_BUCKET`) | **Private** (No public domain) | Member downloads, confidential documents, manuscripts. | Authorized Laravel routes & **Temporary S3 Presigned URLs** (`$download->getTemporaryDownloadUrl(15)`). |

### Inline Markdown Media Upload
Admins can upload images directly while composing articles:
- **Toolbar Image Button**: Opens a file picker and uploads to `POST /admin/api/media/upload`, automatically inserting `![caption](url)`.
- **Drag & Drop / Paste**: Paste screenshots from clipboard or drag image files onto the Markdown editor to upload directly to R2.

---

## 🗄️ Database Migrations & Seeding

Run Laravel migrations directly on Cloudflare D1:

```bash
# Run database migrations
php artisan migrate --force

# (Optional) Seed initial database data
php artisan db:seed
```

---

## 🧪 Testing & Utilities

### 1. Verify Connectivity
Test Cloudflare D1 queries, public R2 uploads/URLs, and private R2 temporary presigned URLs in one command:

```bash
php artisan cloudflare:test
```

### 2. Sync Local Storage to Cloudflare R2
If you have existing files in local storage that you want to upload to your remote R2 buckets:

```bash
# Sync public storage (storage/app/public -> spp-public)
php artisan cloudflare:sync-storage --dry-run
php artisan cloudflare:sync-storage

# Sync private storage (storage/app/private -> spp-private)
php artisan cloudflare:sync-storage --private --dry-run
php artisan cloudflare:sync-storage --private

# Force overwrite existing files
php artisan cloudflare:sync-storage --force
```

---

## 🔄 Switching Between Local & Cloudflare Drivers

You can switch back and forth between local development and Cloudflare at any time in `.env`:

### Use Cloudflare D1 & R2 (Production / Remote):
```env
DB_CONNECTION=d1
FILESYSTEM_DISK=r2
FILESYSTEM_PRIVATE_DISK=r2-private
```

### Use Local SQLite & Disk (Local Offline Dev):
```env
DB_CONNECTION=sqlite
FILESYSTEM_DISK=public
FILESYSTEM_PRIVATE_DISK=local
```

---

## 💻 Running the Application

Start the local server and Vite asset builder:

```bash
npm run dev
```
