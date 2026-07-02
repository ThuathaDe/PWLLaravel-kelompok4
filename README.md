# ☕ Coffee Shop Self-Ordering System

Website ini merupakan project **Ujian Akhir Semester (UAS)** mata kuliah **Pemrograman Web Lanjut**.

Project dikembangkan menggunakan **Laravel Framework** dengan menerapkan konsep **MVC (Model-View-Controller)**, **Eloquent ORM**, **Migration**, dan **Blade Template**.

Repository ini dikerjakan secara **berkelompok** menggunakan **GitHub** sehingga setiap anggota memiliki **branch** masing-masing untuk menghindari konflik saat pengembangan.

---

# 📌 Struktur Project

```
coffee-shop/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   └── Providers/
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── public/
│
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
│
├── routes/
│   └── web.php
│
├── storage/
│
├── .env.example
├── composer.json
├── artisan
└── README.md
```

---

# 👥 Pembagian Tugas

| Anggota   | Fitur                            | Branch              |
| --------- | -------------------------------- | ------------------- |
| Ketua     | Setup Project, Integrasi, Review | `main`              |
| Anggota 1 | Login & Authentication           | `feature-auth`      |
| Anggota 2 | CRUD Menu                        | `feature-menu`      |
| Anggota 3 | Sistem Order & Cart              | `feature-order`     |
| Anggota 4 | Dashboard Admin                  | `feature-dashboard` |
| Anggota 5 | Laporan & Penyempurnaan          | `feature-report`    |

> **Catatan:** Nama branch dapat disesuaikan dengan nama anggota atau nama fitur yang dikerjakan.

---

# 📂 Pembagian Folder

## Authentication

```
app/Http/Controllers/Auth/
resources/views/auth/
routes/web.php
```

---

## CRUD Menu

```
app/Models/Menu.php

app/Http/Controllers/MenuController.php

resources/views/menu/
```

---

## Order

```
app/Models/Order.php

app/Models/OrderDetail.php

app/Http/Controllers/OrderController.php
```

---

## Dashboard

```
app/Http/Controllers/DashboardController.php

resources/views/dashboard/
```

---

# ⚠️ Aturan Pengerjaan

Agar project tetap rapi dan tidak terjadi konflik, setiap anggota wajib mengikuti aturan berikut.

## Jangan Mengubah

❌ Branch `main`

❌ Migration milik anggota lain

❌ Controller milik anggota lain

❌ View yang sedang dikerjakan anggota lain

❌ File `.env`

❌ `composer.json` tanpa persetujuan ketua

❌ Struktur project Laravel

---

## Yang Boleh Dilakukan

✔ Membuat Controller baru sesuai tugas

✔ Membuat View baru

✔ Membuat Migration baru jika diperlukan

✔ Membuat Model baru

✔ Menambahkan Route sesuai fitur

✔ Membuat CSS atau JavaScript khusus fitur masing-masing

---

# 🚀 Clone Repository

Clone repository terlebih dahulu.

```bash
git clone https://github.com/ThuathaDe/PWLLaravel-kelompok4.git
```

Masuk ke folder project.

```bash
cd sistem_coffe-shop
```

Install dependency.

```bash
composer install
```

Copy file environment.

```bash
cp .env.example .env
```

Generate application key.

```bash
php artisan key:generate
```

Konfigurasi database pada file `.env`, kemudian jalankan migration.

```bash
php artisan migrate
```

Menjalankan server Laravel.

```bash
php artisan serve
```

---

# 🔄 Sebelum Mulai Coding

Selalu ambil perubahan terbaru dari repository.

```bash
git checkout main
git pull origin main
```

Hal ini bertujuan agar project lokal selalu menggunakan versi terbaru sebelum mulai mengembangkan fitur.

---

# 🌿 Alur Kerja GitHub

## 1. Buat Branch Sendiri

Jangan pernah langsung bekerja di branch `main`.

Contoh menggunakan nama fitur.

```bash
git checkout -b feature-menu
```

atau menggunakan nama anggota.

```bash
git checkout -b rizky
```

---

## 2. Kerjakan Fitur

Kerjakan hanya fitur yang menjadi tanggung jawab masing-masing.

Contoh:

* Login
* CRUD Menu
* Keranjang
* Checkout
* Dashboard

---

## 3. Cek Perubahan

```bash
git status
```

---

## 4. Simpan Perubahan

Tambahkan seluruh file.

```bash
git add .
```

Commit perubahan.

```bash
git commit -m "feat: menambahkan CRUD menu"
```

---

## 5. Push ke GitHub

```bash
git push origin feature-menu
```

atau

```bash
git push origin rizky
```

---

## 6. Membuat Pull Request

Setelah fitur selesai.

1. Buka repository GitHub.
2. Pilih branch yang telah di-push.
3. Klik **Compare & Pull Request**.
4. Berikan deskripsi perubahan.
5. Tunggu proses review dari ketua kelompok.

---

## 7. Merge

Hanya ketua atau anggota yang ditunjuk yang melakukan merge ke branch `main`.

```
feature-menu
        │
        ▼
Pull Request
        │
        ▼
Code Review
        │
        ▼
Merge
        │
        ▼
main
```

---

# 📝 Penamaan Commit

Gunakan format commit berikut agar riwayat perubahan mudah dipahami.

```
feat: menambahkan fitur login

feat: membuat CRUD menu

fix: memperbaiki validasi checkout

style: memperbaiki tampilan dashboard

refactor: merapikan kode controller
```

---

# 🛠️ Teknologi yang Digunakan

* Laravel
* PHP
* MySQL
* Blade Template
* Bootstrap 5
* JavaScript
* CSS
* Composer
* Git
* GitHub

---

# 📋 Workflow Pengembangan

```
Clone Repository
        │
        ▼
Buat Branch
        │
        ▼
Coding Fitur
        │
        ▼
Testing
        │
        ▼
Commit
        │
        ▼
Push
        │
        ▼
Pull Request
        │
        ▼
Code Review
        │
        ▼
Merge ke main
```

---

# 📖 Aturan Kolaborasi

* Selalu lakukan `git pull origin main` sebelum mulai bekerja.
* Jangan melakukan `push` langsung ke branch `main`.
* Kerjakan hanya fitur sesuai pembagian tugas.
* Jangan menghapus atau mengubah kode milik anggota lain tanpa izin.
* Pastikan fitur sudah diuji sebelum melakukan commit.
* Gunakan pesan commit yang jelas dan sesuai perubahan.
* Jika terjadi konflik (*merge conflict*), komunikasikan dengan ketua kelompok sebelum melakukan merge.

---

# 🎯 Tujuan Project

Project ini bertujuan membangun sistem **Self-Ordering Coffee Shop** berbasis web yang memungkinkan pelanggan melakukan pemesanan secara mandiri melalui perangkat mereka, sementara admin dapat mengelola menu, memantau pesanan, serta mengubah status pesanan melalui dashboard Laravel.

---

<div align="center">

### ☕ Happy Coding & Happy Collaborating! 🚀

**"Satu Repository, Banyak Kontributor, Satu Tujuan."**

</div>
