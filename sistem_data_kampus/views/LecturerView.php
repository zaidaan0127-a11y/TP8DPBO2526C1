<?php
// Tampilan halaman Dosen
class LecturerView
{
    public function render(array $rows, array $depts, $edit, string $msg): void
    {
        // Susun baris tabel
        $tr = '';
        foreach ($rows as $i => $r) {
            $tr .= '<tr><td>' . ($i + 1) . '</td><td>' . e($r['name']) . '</td><td>' . e($r['nidn'])
                 . '</td><td>' . e($r['email']) . '</td><td>' . e($r['phone']) . '</td><td>' . e($r['join_date'])
                 . '</td><td>' . e($r['department_name']) . '</td><td class="text-nowrap">'
                 . Template::actions('index', (int)$r['id']) . '</td></tr>';
        }
        if ($tr === '') $tr = '<tr><td colspan="8" class="text-center text-muted">Belum ada data</td></tr>';

        // Isi template; nilai form terisi jika sedang mode edit
        $content = (new Template('lecturer.html'))->fill([
            'ALERT'     => Template::alert($msg),
            'ID'        => e($edit['id'] ?? ''),
            'NAME'      => e($edit['name'] ?? ''),
            'NIDN'      => e($edit['nidn'] ?? ''),
            'EMAIL'     => e($edit['email'] ?? ''),
            'PHONE'     => e($edit['phone'] ?? ''),
            'JOIN_DATE' => e($edit['join_date'] ?? ''),
            'DEPT_OPT'  => Template::options($depts, 'id', 'name', $edit['department_id'] ?? '', '-- Pilih Departemen --'),
            'BTN'       => $edit ? 'Update' : 'Simpan',
            'CANCEL'    => $edit ? '<a href="index.php" class="btn btn-secondary">Batal</a>' : '',
            'ROWS'      => $tr,
        ])->render();
        echo Template::page('Dosen', 'index', $content);
    }
}
