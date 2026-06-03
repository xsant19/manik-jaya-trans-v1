# 🚀 GitHub Actions CI/CD - Deployment Setup

Folder ini berisi workflow GitHub Actions untuk otomatis deploy aplikasi Laravel ke Rumahweb Shared Hosting.

---

## 📁 Workflow Files

### 1. `deploy.yml` - Automatic Deployment
**Trigger:** Push ke branch `main` atau `master`

Workflow ini akan otomatis:
- ✅ Install dependencies (Composer & NPM)
- ✅ Build production assets (Vite)
- ✅ Upload ke Rumahweb via FTP
- ✅ Set proper permissions

### 2. `manual-deploy.yml` - Manual Deployment
**Trigger:** Manual via GitHub UI

Workflow ini bisa dijalankan manual dengan opsi:
- Environment selection (production/staging)
- Clear cache option
- Run migrations option

---

## 🔐 Required GitHub Secrets

Setup secrets di: **Repository Settings → Secrets and variables → Actions**

| Secret Name | Description | Example |
|------------|-------------|---------|
| `FTP_SERVER` | FTP server hostname | `ftp.yourdomain.com` |
| `FTP_USERNAME` | FTP username | `yourdomain.com` |
| `FTP_PASSWORD` | FTP password | `your_ftp_password` |
| `FTP_SERVER_DIR` | Server directory path | `/public_html/` |
| `APP_URL` | Application URL | `https://yourdomain.com` |

### Optional (jika SSH tersedia):
| Secret Name | Description |
|------------|-------------|
| `SSH_HOST` | SSH hostname |
| `SSH_USERNAME` | SSH username |
| `SSH_PASSWORD` | SSH password |
| `SSH_PORT` | SSH port (default: 22) |

---

## 📖 Documentation

Untuk panduan lengkap, lihat file berikut di root project:

- **`DEPLOYMENT.md`** - Panduan deployment lengkap (step-by-step)
- **`DEPLOYMENT_QUICK_REFERENCE.md`** - Cheat sheet cepat
- **`deploy-local.sh`** - Script test deployment (Linux/Mac)
- **`deploy-local.ps1`** - Script test deployment (Windows)

---

## 🚀 Quick Start

### 1. Setup GitHub Secrets
```
1. Buka repository GitHub
2. Settings → Secrets and variables → Actions
3. Tambahkan semua required secrets
```

### 2. Push to GitHub
```bash
git add .
git commit -m "Initial commit"
git push origin main
```

### 3. Monitor Deployment
```
1. Buka tab "Actions" di GitHub
2. Lihat workflow run
3. Cek log untuk troubleshooting
```

---

## 🔄 Workflow Status

Check deployment status badge:

[![Deploy Status](https://github.com/YOUR_USERNAME/manik-jaya-trans-v1/actions/workflows/deploy.yml/badge.svg)](https://github.com/YOUR_USERNAME/manik-jaya-trans-v1/actions/workflows/deploy.yml)

*(Update YOUR_USERNAME dengan GitHub username Anda)*

---

## 📞 Support

Jika ada masalah dengan deployment:

1. **Cek GitHub Actions Log** - Lihat detail error
2. **Cek Laravel Log** - `storage/logs/laravel.log`
3. **Baca Dokumentasi** - `DEPLOYMENT.md`
4. **Test FTP** - Gunakan FileZilla untuk test koneksi

---

**Last Updated:** 2026-06-03
