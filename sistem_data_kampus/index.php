<?php
// Pintu masuk halaman Dosen
require __DIR__ . '/config.php';
(new LecturerController())->index();
