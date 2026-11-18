<?php
// Model tabel lecturers
class Lecturer
{
    // Semua dosen + nama departemennya (LEFT JOIN: dosen tanpa departemen tetap tampil)
    public function all(): array
    {
        return DB::select('SELECT l.*, d.name AS department_name
                           FROM lecturers l LEFT JOIN departments d ON d.id = l.department_id
                           ORDER BY l.name');
    }
    // Satu dosen berdasarkan id
    public function find(int $id) { return DB::one('SELECT * FROM lecturers WHERE id=?', [$id]); }

    // Tambah dosen
    public function add(array $d)
    {
        return DB::run('INSERT INTO lecturers (name,nidn,phone,join_date,email,department_id)
                        VALUES (?,?,?,?,?,?)',
            [$d['name'], $d['nidn'], $d['phone'], $d['join_date'], $d['email'], $d['department_id']]);
    }
    // Ubah dosen
    public function update(int $id, array $d)
    {
        return DB::run('UPDATE lecturers SET name=?, nidn=?, phone=?, join_date=?, email=?, department_id=? WHERE id=?',
            [$d['name'], $d['nidn'], $d['phone'], $d['join_date'], $d['email'], $d['department_id'], $id]);
    }
    // Hapus dosen (mata kuliahnya ikut terhapus lewat foreign key)
    public function delete(int $id) { return DB::run('DELETE FROM lecturers WHERE id=?', [$id]); }
}
