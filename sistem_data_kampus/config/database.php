<?php
class Database
{
    public static function connect(): mysqli
    {
        // Koneksi dibuat sekali lalu dipakai ulang (singleton sederhana)
        static $conn = null;
        if ($conn === null) {
            // Sesuaikan host, user, password, dan nama database
            $conn = new mysqli('localhost', 'root', '', 'tp_mvc25');
            $conn->set_charset('utf8mb4');
        }
        return $conn;
    }
}
