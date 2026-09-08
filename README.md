# tiket
plugin wordpress tiket. 
buat plugin wordpress aplikasi mobile cms Active Nation CMS
1. Product Vision & Philosophy
Platform ini dirancang untuk menyediakan ekosistem event olahraga digital yang lengkap, andal, dan aman yang menghubungkan Pelanggan, Instruktur, dan Administrator. Kesuksesan sejati tercapai ketika pengguna memahami, memvalidasi, dan dengan percaya diri menggunakan solusi yang telah mereka bangun.
2. Target Audience & Roles
Sistem ini memfasilitasi tiga peran utama (Role-Based Access Control):
● Customer (Pelanggan): Pengguna yang ingin mengeksplorasi event olahraga (Yoga, HIIT, Zumba, dll) di kota mereka, memesan tiket, mengisi form persyaratan kesehatan/data diri, membayar via transfer/QRIS, melakukan check-in via QR code, dan membagikan ulasan serta foto galeri.
● Instructor (Coach): Profesional yang memandu event. Mereka membutuhkan visibilitas terhadap jadwal kelas yang ditugaskan, memantau rasio kehadiran peserta, dan membaca ulasan (feedback) dari peserta.
● Administrator (Admin): Operator sistem yang mengelola seluruh siklus event, kategori, memvalidasi pembayaran manual, mendesain form event dinamis, mengelola instruktur, mengatur metode pembayaran, mengirim automasi WhatsApp, dan memantau log audit sistem.
3. Core Features & Scope
3.1. Authentication System
● Login menggunakan Nomor Handphone / ID Pengguna dan Kata Sandi.
● Registrasi untuk Customer dengan pengisian Nama Kota Domisili sebagai acuan utama filter event.
● Sistem Routing pintar yang langsung mengarahkan pengguna ke panel (dashboard) masing-masing berdasarkan hak akses (Role).
3.2. Customer Panel
● Discovery (Eksplorasi): Halaman awal yang otomatis memfilter Upcoming Events berdasarkan Kota Domisili pengguna. Tersedia fitur pencarian (Search) spesifik dan event
publik/tersembunyi.
● Event Details: Menampilkan banner, instruktur, harga, kapasitas, deskripsi, lokasi (terintegrasi Google Maps), dan batas kuota.
● Checkout Engine:
○ Pemilihan kuantitas tiket (Maksimal 5).
○ Sistem klaim Voucher Diskon (Persentase / Nominal).
○ Pemilihan metode pembayaran dinamis (Transfer Bank / QRIS).
○ Upload bukti transfer.
● Ticket Management & Activities:
○ Tiket Aktif: Menampilkan QR Code untuk check-in.
○ Form Event Dinamis: Wajib mengisi form persyaratan (seperti Google Forms) jika kategori event mewajibkan form (misal: riwayat cedera, tinggi/berat badan).
○ Riwayat (Telah Hadir): Mengakses ulasan Bintang (Star-rating), melihat, dan mengunggah foto ke Galeri Event bersama.
3.3. Instructor Panel
● Dashboard: Menampilkan metrik tingkat tinggi (Total Kelas, Peserta Aktif, Total Hadir).
● Schedule: Daftar event yang ditugaskan kepada mereka dengan progress bar visual kapasitas vs. kehadiran.
● Feedback System: Melihat agregasi ulasan dan komentar dari peserta setelah event selesai.
3.4. Administrator Panel
● Event Management (CRUD): Membuat, mengedit, dan menghapus event. Auto-generate URL Slug.
● Category Management (CRUD): Mengelola kategori event (cth: Zumba Step, Confit, Basket, Padel, Yoga) dan menautkannya dengan Template Form Event.
● Form Builder (CRUD): Membuat Form Template dinamis (Field teks dan Dropdown pilihan majemuk) untuk diisi pelanggan.
● Payment Methods (CRUD): Mengelola opsi pembayaran yang tersedia (Transfer Bank: Nama Bank, Rekening, Atas Nama & QRIS: URL Gambar).
● Order Validation: Memeriksa pesanan yang masuk, melihat bukti transfer, menyetujui (menerbitkan e-ticket), atau menolak pesanan.
● QR Scanner / Check-in: Fitur pindai (simulasi kamera) dan input manual ID Tiket untuk mencatat kehadiran peserta secara real-time.
● Reporting & Automations:
○ Laporan Kehadiran & Form: Memantau daftar tiket aktif, tiket yang telah hadir, dan membaca Form Responses yang telah diisi pelanggan.
○ WhatsApp Automations: Sistem pengiriman pesan dinamis dengan variabel ({name}, {event}, {ticket_id}, {link}, {form_link}).
1. Reminder Check-in & Wajib Isi Form (untuk Tiket Aktif).
2. Thank You & Request Review/Share Social Media (untuk Tiket Telah Hadir).
● System Settings:
○ Manajemen akun Instruktur (CRUD).
○ Manajemen Voucher Diskon (CRUD).
○ Audit Logs (Pemantauan keamanan aktivitas user dan IP).
