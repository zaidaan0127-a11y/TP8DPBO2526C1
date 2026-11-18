<?php
// Model tabel courses
class Course
{
    // Semua mata kuliah + nama dosen pengampu (JOIN), urut semester lalu kode
    public function all(): array
    {
        return DB::select('SELECT c.*, l.name AS lecturer_name
                           FROM courses c JOIN lecturers l ON l.id = c.lecturer_id
                           ORDER BY c.semester, c.code');
    }
    // Satu mata kuliah berdasarkan id
    public function find(int $id) { return DB::one('SELECT * FROM courses WHERE id=?', [$id]); }

    // Tambah mata kuliah
    public function add(array $d)
    {
        return DB::run('INSERT INTO courses (code,name,credits,semester,lecturer_id) VALUES (?,?,?,?,?)',
            [$d['code'], $d['name'], $d['credits'], $d['semester'], $d['lecturer_id']]);
    }
    // Ubah mata kuliah
    public function update(int $id, array $d)
    {
        return DB::run('UPDATE courses SET code=?, name=?, credits=?, semester=?, lecturer_id=? WHERE id=?',
            [$d['code'], $d['name'], $d['credits'], $d['semester'], $d['lecturer_id'], $id]);
    }
    // Hapus mata kuliah
    public function delete(int $id) { return DB::run('DELETE FROM courses WHERE id=?', [$id]); }
}
