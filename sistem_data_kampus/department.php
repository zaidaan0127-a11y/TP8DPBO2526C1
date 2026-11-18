<?php
// Pintu masuk halaman Departemen
require __DIR__ . '/config.php';
(new DepartmentController())->index();
