 # Simvia - Document Management System with OCR

Simvia adalah sistem manajemen dokumen berbasis web yang dibangun dengan Laravel 12 dan Filament 3, dilengkapi dengan kemampuan OCR (Optical Character Recognition) untuk memproses dokumen ijazah dan dokumen pendidikan lainnya.

## 📋 Fitur Utama

- **Manajemen Dokumen**: Upload, penyimpanan, dan pengelolaan dokumen ijazah
- **OCR Integration**: Pemrosesan otomatis dokumen menggunakan n8n workflow
- **Admin Panel**: Interface administrasi berbasis Filament 3
- **WhatsApp Integration**: Notifikasi dan komunikasi via WhatsApp (WAHA)
- **Workflow Automation**: Otomatisasi proses menggunakan n8n

## 🏗️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────────┐
│                        Simvia Architecture                       │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────┐    ┌──────────┐    ┌──────────────────────────┐  │
│  │  Client  │───▶│  Nginx   │───▶│  Laravel Application     │  │
│  │ (Browser)│    │  (443)   │    │  (PHP/Filament)          │  │
│  └──────────┘    └──────────┘    └──────────┬───────────────┘  │
│                                              │                  │
│  ┌──────────┐    ┌──────────┐    ┌──────────▼───────────────┐  │
│  │   n8n    │◀───│ Webhook  │    │  MariaDB Database        │  │
│  │ Workflow │    │          │    │  (Documents, OCR Results)│  │
│  └────┬─────┘    └──────────┘    └──────────────────────────┘  │
│       │                                                         │
│       ▼                                                         │
│  ┌──────────┐    ┌──────────┐                                  │
│  │  OCR     │◀───│ External │                                  │
│  │ Service  │    │ Service  │                                  │
│  └──────────┘    └──────────┘                                  │
│                                                                 │
│  ┌──────────┐                                                  │
│  │   WAHA   │  (WhatsApp HTTP API)                            │
│  │ (3000)   │                                                  │
│  └──────────┘                                                  │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

## 🚀 Teknologi yang Digunakan

### Backend
- **PHP 8.2** - Bahasa pemrograman utama
- **Laravel 12** - Framework PHP modern
- **Filament 3** - Admin panel dan form builder
- **Livewire** - Komponen dinamis untuk Laravel
- **MariaDB 10.11** - Database relasional

### Frontend
- **Tailwind CSS** - Framework CSS utility-first
- **Alpine.js** - JavaScript framework ringan

### DevOps & Tools
- **Docker** - Containerization
- **Nginx** - Web server dengan SSL
- **n8n** - Workflow automation
- **WAHA** - WhatsApp HTTP API

## 📁 Struktur Proyek

```
simvia/
├── docker-compose.yml          # Konfigurasi Docker containers
├── nginx/                      # Konfigurasi Nginx
│   ├── default.conf           # Virtual host config
│   └── ssl/                   # SSL certificates
├── php/                       # PHP Docker configuration
│   ├── Dockerfile
│   ├── docker-entrypoint.sh
│   └── local.ini
├── db/                        # Database configuration
│   ├── conf.d/my.cnf
│   └── data/                  # MariaDB data
├── n8n/                       # n8n workflow data
│   └── data/
├── waha/                      # WhatsApp API data
│   ├── sessions/
│   └── media/
├── arsitektur/               # Dokumentasi arsitektur
│   └── arsitektur_dev.png
└── src/                      # Aplikasi Laravel
    ├── app/
    │   ├── Console/Commands/ # Artisan commands
    │   ├── Filament/         # Filament resources
    │   ├── Http/Controllers/ # API controllers
    │   ├── Livewire/         # Livewire components
    │   ├── Models/           # Eloquent models
    │   └── Providers/        # Service providers
    ├── database/
    │   ├── migrations/       # Database migrations
    │   └── seeders/          # Database seeders
    ├── routes/               # Route definitions
    │   ├── api.php
    │   └── web.php
    ├── config/               # Konfigurasi Laravel
    └── resources/views/      # Blade templates
```

## 🐳 Layanan Docker

| Service | Port | Deskripsi |
|---------|------|-----------|
| **nginx** | 80, 443 | Web server dengan SSL |
| **php** | 9000 (internal) | PHP-FPM application server |
| **db** | 13306 | MariaDB database |
| **n8n** | 5678 | Workflow automation |
| **waha** | 3000 | WhatsApp HTTP API |

## 📦 Library dan Package Utama

### Filament & UI
- `filament/filament` - Admin panel
- `bezhansalleh/filament-shield` - Role-based access control
- `hasnayeen/themes` - Theming support
- `joaopaulolndev/filament-edit-profile` - Profile editing
- `awcodes/light-switch` & `awcodes/overlook` - UI components
- `aymanalhattami/filament-slim-scrollbar` - Custom scrollbar

### OCR & Processing
- `joshembling/image-optimizer` - Image optimization

### Logging & Debugging
- `z3d0x/filament-logger` - Activity logging
- `barryvdh/laravel-debugbar` - Debug toolbar

## 🔧 Konfigurasi Environment

### Environment Variables
```env
PROJECT_NAME=simvia
COMPOSE_PROJECT_NAME=simvia
XDEBUG=false
```

### Default Credentials
- **n8n Admin**: admin / admin123
- **Database Root**: root / p455w0rd
- **Domain**: simvia.test (local development)

## 📝 Alur Kerja Sistem

### 1. Upload Dokumen
```
User → Upload Form → Validasi → Simpan File → Trigger n8n Webhook
```

### 2. Proses OCR
```
n8n Webhook → External OCR Service → Process Document → Callback API
```

### 3. Simpan Hasil
```
Callback → Update Document Status → Save OCR Results → Admin Review
```

## 🔌 API Endpoints

### Document API
```
GET /api/documents/{id}
    - Mengambil detail dokumen
    - Response: Document dengan OCR results

POST /api/ocr/callback
    - Callback dari n8n setelah OCR selesai
    - Body: document_id, nama, nisn, sekolah, tahun_lulus, raw_text
```

## 🎨 Model Database

### Document
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Nama lengkap |
| nisn | varchar | NISN (10 digit) |
| phone | varchar | Nomor WhatsApp |
| file_path | varchar | Path file di storage |
| status | enum | uploaded, review_pending, approved, rejected |
| rejection_reason | text | Alasan penolakan (opsional) |
| created_at | timestamp | Waktu upload |
| updated_at | timestamp | Waktu update |

### OcrResult
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| document_id | bigint | Foreign key ke documents |
| extracted_name | varchar | Nama dari OCR |
| extracted_nisn | varchar | NISN dari OCR |
| extracted_school | varchar | Sekolah dari OCR |
| extracted_year | varchar | Tahun lulus dari OCR |
| raw_text | text | Teks mentah dari OCR |
| confidence_score | float | Skor kepercayaan OCR |
| created_at | timestamp | Waktu pembuatan |
| updated_at | timestamp | Waktu update |

## 🛠️ Cara Menjalankan

### Prasyarat
- Docker & Docker Compose
- Hosts entry untuk `simvia.test`

### Langkah

1. **Tambahkan hosts entry**
```bash
echo "127.0.0.1 simvia.test" | sudo tee -a /etc/hosts
```

2. **Jalankan container**
```bash
docker-compose up -d
```

3. **Akses Aplikasi**
- **Web**: https://simvia.test
- **Admin Panel**: https://simvia.test/admin
- **n8n**: http://localhost:5678
- **WAHA**: http://localhost:3000

### Install Dependencies (Jika diperlukan)
```bash
docker-compose exec php composer install
docker-compose exec php npm install
```

## 📚 Perintah Artisan Useful

```bash
# Cache clear
docker-compose exec php php artisan optimize:clear

# Database migration
docker-compose exec php php artisan migrate

# Create new resource
docker-compose exec php php artisan make:filament-resource ResourceName

# Recache configuration
docker-compose exec php php artisan recache
```

## 🔐 Keamanan

- SSL certificate self-signed untuk development
- HTTP to HTTPS redirect
- Deny all untuk .htaccess
- Filament Shield untuk role-based access

## 📄 Lisensi

Project ini adalah proprietary software.

---

**Simvia v2025** - Document Management System with OCR

