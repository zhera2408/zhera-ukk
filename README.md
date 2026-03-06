# Panduan Hosting Vercel + Aiven MySQL

Berikut adalah langkah-langkah untuk meng-hosting aplikasi **Peminjaman Buku** Anda.

## 1. Persiapan Database (Aiven)
1.  Daftar/Login di [Aiven.io](https://aiven.io/).
2.  Buat layanan **MySQL** baru (pilih "Free Plan" jika tersedia).
3.  Setelah layanan aktif, salin informasi koneksi berikut dari dashboard Aiven:
    -   `Host`
    -   `Port`
    -   `User` (biasanya `avnadmin`)
    -   `Password`
    -   `Database Name` (pilih `defaultdb` atau buat database baru bernama `library_ukk`)

### Impor Database
Gunakan MySQL Client (seperti HeidiSQL, DBeaver, atau Command Line) untuk mengimpor file `database.sql` yang ada di folder proyek Anda ke database Aiven.

## 2. Persiapan Kode (Vercel)
Saya telah menambahkan file `vercel.json` dan memperbarui `config.php` agar mendukung variabel lingkungan (Environment Variables).

### Upload ke GitHub
1.  Buat repositori baru di GitHub.
2.  Push kode Anda ke GitHub:
    ```bash
    git init
    git add .
    git commit -m "Siap untuk deployment"
    git branch -M main
    git remote add origin https://github.com/username/peminjamanbuku_zhera.git
    git push -u origin main
    ```

## 3. Deployment ke Vercel
1.  Login ke [Vercel](https://vercel.com/).
2.  Klik **"Add New"** > **"Project"**.
3.  Impor repositori dari GitHub Anda.
4.  Di bagian **Environment Variables**, tambahkan variabel berikut:
    -   `DB_HOST`: Alamat host dari Aiven.
    -   `DB_PORT`: Port dari Aiven (biasanya `10000+`).
    -   `DB_USER`: Username dari Aiven.
    -   `DB_PASS`: Password dari Aiven.
    -   `DB_NAME`: Nama database (misal: `defaultdb`).
    -   `BASE_URL`: URL aplikasi Anda di Vercel (misal: `https://peminjamanbuku-zhera.vercel.app/`).
    -   `DB_SSL_CA` (Opsional): Input value sertifikat SSL jika database Aiven Anda mewajibkan SSL.

5.  Klik **Deploy**.

## Catatan Penting
-   **File Uploads**: Karena Vercel adalah platform serverless, file yang diunggah (seperti cover buku) akan bersifat **sementara**.
-   **Folder Assets**: Pastikan folder `assets/img/` ikut ter-upload.
-   **Case Sensitivity**: Vercel berjalan di Linux yang bersifat case-sensitive.
-   **Path File**: Gunakan fungsi `base_url()` untuk memanggil aset.
