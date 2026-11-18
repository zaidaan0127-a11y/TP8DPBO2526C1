<?php
// Tampilan halaman Mata Kuliah
class CourseView
{
    public function render(array $rows, array $lecturers, $edit, string $msg): void
    {
        // Susun baris tabel
        $tr = '';
        foreach ($rows as $i => $r) {
            $tr .= '<tr><td>' . ($i + 1) . '</td><td>' . e($r['code']) . '</td><td>' . e($r['name'])
                 . '</td><td>' . e($r['credits']) . '</td><td>' . e($r['semester'])
                 . '</td><td>' . e($r['lecturer_name']) . '</td><td class="text-nowrap">'
                 . Template::actions('course', (int)$r['id']) . '</td></tr>';
        }
        if ($tr === '') $tr = '<tr><td colspan="7" class="text-center text-muted">Belum ada data</td></tr>';

        // Isi template; SKS default 3 dan semester default 1 untuk data baru
        $content = (new Template('course.html'))->fill([
            'ALERT'    => Template::alert($msg),
            'ID'       => e($edit['id'] ?? ''),
            'CODE'     => e($edit['code'] ?? ''),
            'NAME'     => e($edit['name'] ?? ''),
            'CREDITS'  => e($edit['credits'] ?? 3),
            'SEMESTER' => e($edit['semester'] ?? 1),
            'LEC_OPT'  => Template::options($lecturers, 'id', 'name', $edit['lecturer_id'] ?? '', '-- Pilih Dosen --'),
            'BTN'      => $edit ? 'Update' : 'Simpan',
            'CANCEL'   => $edit ? '<a href="course.php" class="btn btn-secondary">Batal</a>' : '',
            'ROWS'     => $tr,
        ])->render();
        echo Template::page('Mata Kuliah', 'course', $content);
    }
}
