<?php
// Pintu masuk halaman Mata Kuliah
require __DIR__ . '/config.php';
(new CourseController())->index();
