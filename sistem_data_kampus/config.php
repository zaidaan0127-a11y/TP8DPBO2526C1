<?php
// Konfigurasi koneksi database
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_kampus');
define('DB_USER', 'root');
define('DB_PASS', '');

// Autoload: class dicari otomatis di folder models, views, controllers
spl_autoload_register(function ($class) {
    foreach (['models', 'views', 'controllers'] as $dir) {
        $f = __DIR__ . "/$dir/$class.php";          // path file class
        if (is_file($f)) { require $f; return; }    // muat jika ada
    }
});

// Helper: escape output agar aman dari XSS
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

// Helper: string kosong diubah jadi NULL (untuk kolom opsional / foreign key)
function nv($v) { $v = trim((string)$v); return $v === '' ? null : $v; }
