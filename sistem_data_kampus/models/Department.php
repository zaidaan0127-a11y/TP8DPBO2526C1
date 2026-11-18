<?php
// Model tabel departments
class Department
{
    // Semua departemen, urut nama
    public function all(): array { return DB::select('SELECT * FROM departments ORDER BY name'); }
    // Satu departemen berdasarkan id
    public function find(int $id) { return DB::one('SELECT * FROM departments WHERE id=?', [$id]); }
    // Tambah departemen
    public function add(array $d) { return DB::run('INSERT INTO departments (name) VALUES (?)', [$d['name']]); }
    // Ubah nama departemen
    public function update(int $id, array $d) { return DB::run('UPDATE departments SET name=? WHERE id=?', [$d['name'], $id]); }
    // Hapus departemen
    public function delete(int $id) { return DB::run('DELETE FROM departments WHERE id=?', [$id]); }
}
