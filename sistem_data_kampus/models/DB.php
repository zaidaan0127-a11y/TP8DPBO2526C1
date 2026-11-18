<?php
// Pembungkus koneksi PDO + fungsi query yang dipakai semua model
class DB
{
    private static $pdo; // koneksi dibuat sekali lalu dipakai ulang

    public static function pdo(): PDO
    {
        if (!self::$pdo) {
            self::$pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER, DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,           // error jadi exception
                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]      // hasil berupa array asosiatif
            );
        }
        return self::$pdo;
    }

    // SELECT banyak baris
    public static function select(string $sql, array $p = []): array
    {
        $s = self::pdo()->prepare($sql); // prepared statement anti SQL injection
        $s->execute($p);
        return $s->fetchAll();
    }

    // SELECT satu baris (null jika tidak ada)
    public static function one(string $sql, array $p = [])
    {
        return self::select($sql, $p)[0] ?? null;
    }

    // INSERT / UPDATE / DELETE
    public static function run(string $sql, array $p = []): bool
    {
        return self::pdo()->prepare($sql)->execute($p);
    }
}
