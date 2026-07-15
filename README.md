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

|        Anggota         | 
|       ---------        | 
| Tessar Febriansyah     | 
| Muhammad Rasyiq Abiyyu | 
| Damar Saputra          | 


> **Catatan:** UJI COBA DAHULU SEBELUM PUSH PROJECT KE GITHUB.

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

## 1. Push 


Contoh menggunakan nama fitur.

```bash
git push -u origin main
```

atau menggunakan nama anggota.



---

## 2. Kerjakan Fitur

Kerjakan fitur yang menjadi kekurangan project (bicarakan dengan teman project).

Contoh:
* Login
* CRUD Menu
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

atau
```bash
git add <nama_file>
```

Commit perubahan.

```bash
git commit -m "feat: menambahkan CRUD menu"
```
atau
---

## 5. Push ke GitHub

```bash
git push origin main
```

---

# 📝 Penamaan Commit

Gunakan format commit yang jelas agar diketahui anggota lain sehingga perubahan mudah dipahami.

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
Push Ke Main
```

---

# 📖 Aturan Kolaborasi

* Selalu lakukan `git pull origin main` sebelum mulai bekerja.
* Jangan menghapus atau mengubah kode milik anggota lain tanpa izin.
* Pastikan fitur sudah diuji sebelum melakukan commit.
* Gunakan pesan commit yang jelas dan sesuai perubahan.

---

# 🎯 Tujuan Project

Project ini bertujuan membangun sistem **Self-Ordering Coffee Shop** berbasis web yang memungkinkan pelanggan melakukan pemesanan secara mandiri melalui perangkat mereka, sementara admin dapat mengelola menu, memantau pesanan, serta mengubah status pesanan melalui dashboard Laravel.

---

<div align="center">

### ☕ Happy Coding & Happy Collaborating! 🚀

**"Satu Repository, Banyak Kontributor, Satu Tujuan."**

</div>
