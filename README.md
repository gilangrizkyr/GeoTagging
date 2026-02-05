# GeoTagging DPMPTSP Tanah Bumbu (v2)

![Version](https://img.shields.io/badge/version-2.0.0-blue)
![Framework](https://img.shields.io/badge/framework-CodeIgniter_4-orange)
![Database](https://img.shields.io/badge/database-PostgreSQL-blue)
![Maps](https://img.shields.io/badge/maps-Leaflet.js-green)

A modern Spatial Data Information System developed for the **Department of Investment and Integrated One-Door Service (DPMPTSP)** of Tanah Bumbu Regency. This application facilitates spatial analysis, zoning checks, and business activity validation (KBLI) to support investment transparency and regional planning.

---

## 🚀 Core Features

### 🌍 Public Interactive Portal
- **Interactive Multi-layer Map**: Toggle between RDTR (Rencana Detail Tata Ruang) and RTRW (Rencana Tata Ruang Wilayah) layers.
- **Instant Spatial Analysis**: Click any point on the map to retrieve detailed zoning information instantly.
- **Coordinate-based Search**: Input Latitude and Longitude to inspect specific locations.

### 📋 Zoning & Regulation Details
- **ITBX Parameters**: Comprehensive details on:
  - **KDB** (Building Coverage Ratio)
  - **KLB** (Floor Area Ratio)
  - **GSB/GSL** (Building/Sewer Lines)
  - **Max Height & Floors**
- **Activity Matrices**: View allowed, limited, conditional, and prohibited activities for each zone.

### 🛡️ KBLI Validation
- **Smart Validation**: Integrated KBLI (Standard Classification of Indonesian Business Fields) checker to verify if a business activity aligns with specific zoning regulations.

### ⚙️ Admin & Operator Panel
- **Spatial Data Management**: CRUD interfaces for managing zones with GeoJSON polygon integration.
- **KBLI Template Management**: Manage allowed activities across different zones.
- **Audit Activity Logs**: Full tracking of spatial inquiries and administrative changes.
- **System Configuration**: Manage application name, logos, and theme colors dynamically.

---

## 🛠️ Technology Stack

| Layer | Technology |
|-------|------------|
| **Backend** | PHP 8.2+ (CodeIgniter 4.6.0) |
| **Database** | PostgreSQL + PostGIS (Spatial Extensions) |
| **Frontend** | Bootstrap 5, Vanilla CSS |
| **Mapping** | Leaflet.js, Google Maps API (Aerial/Hybrid) |
| **Typography** | Plus Jakarta Sans, Outfit |
| **Icons** | Bootstrap Icons, FontAwesome |

---

## 📥 Installation

### 1. Requirements
- PHP 8.2 or higher
- PostgreSQL 14+ with PostGIS
- Composer
- Web Server (Apache/Nginx) or use Spark

### 2. Standard Setup
1. Clone the repository.
2. Run `composer install`.
3. Copy `env` to `.env` and configure your database and `app.baseURL`.
4. Ensure your PostgreSQL server is running.

### 3. Automated Database Setup (Linux)
We provide a setup script to automate database creation and extensions:
```bash
chmod +x setup_database.sh
./setup_database.sh
```
*This will create the `geotagging_db`, enable PostGIS, run migrations, and seed the initial admin account.*

---

## 📖 Usage

### Running Locally
```bash
php spark serve
```
Access the application at `http://localhost:8080`.

### Default Admin Credentials
*Refer to `AdminSeeder.php` for initial login details.*

---

## 🗺️ Spatial Data Notice
Informasi yang ditampilkan dalam aplikasi ini bersifat **indikatif** dan bukan merupakan rujukan legal formal. Untuk verifikasi resmi terkait KKPR atau Izin Lokasi, silakan hubungi kantor DPMPTSP Kabupaten Tanah Bumbu secara langsung.

---

**Developed for DPMPTSP Kabupaten Tanah Bumbu**
&copy; 2026 GeoTagging-v2 Team
# GeoTagging-v2
