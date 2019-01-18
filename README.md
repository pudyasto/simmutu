# README #

Sistem Informasi Manajemen Mutu Rumah Sakit
Adalah aplikasi untuk memonitor mutu unit pada sebuah instansi rumah sakit.
Dalam tiap unit terdapat indikator-indikator yang nantinya akan dilakukan
penilaian setiap hari terhadap numerator dan denumerator. 
Hasil akhirnya adalah dapat mengetahui nilai rata-rata capaian standar yang telah
ditentukan sebelumnya.

### Informasi Pengembang ###

* SIM - Mutu RS
* Version: Beta 1.0
* Author: 	Pudyasto Adi Wibowo
* Github: 	https://github.com/pudyasto
* Contact: 	mr.pudyasto@gmail.com
* Follow: 	https://twitter.com/pudyastoadi
* Like: 	https://www.facebook.com/dhyaz.cs

### Cara Setup Aplikasi ###

* Import database/db_simmutu.sql ke server mysql
* Copy semua file dengan prefix *.copy.php menjadi *.php
    - config/config.copy.php
    - config/database.copy.php
    - config/ion_auth.copy.php
* Sesuaikan konfigurasi
    - config/config.php
    - config/database.php
    - config/ion_auth.php
* Gunakan VirtualHost dan arahkan ke folder public/
* Jalankan Aplikasi

### Deskripsi komponen yang digunakan ###

* AdminBSB HTML Template - https://github.com/gurayyarar/AdminBSBMaterialDesign
* Codeigniter 3 - https://codeigniter.com/
* HMVC - https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
* Template Engine - https://github.com/philsturgeon/codeigniter-template
* Ion Auth - https://github.com/benedmunds/CodeIgniter-Ion-Auth

### Penting ###
Penggunaan aplikasi ini tidak dipungut biaya sepeserpun (Gratis).
Namun aplikasi ini tidak berhak diperjual-belikan, anda boleh menggunakan untuk keperluan komersial
seperti penggunaan di Rumah Sakit guna keperluan Akreditasi dalam memonitor Penjaminan Mutu Unit.
Jika ingin melakukan donasi untuk mendukung pengembangan aplikasi ini silahkan hubungi pihak pengembang.
Terima Kasih
Salam Hangat




Pudyasto Adi Wibowo
mr.pudyasto@gmail.com