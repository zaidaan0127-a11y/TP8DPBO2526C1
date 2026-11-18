<?php
// Tampilan halaman Departemen
class DepartmentView
{
    public function render(array $rows, $edit, string $msg): void
    {
        // Susun baris tabel
        $tr = '';
        foreach ($rows as $i => $r) {
            $tr .= '<tr><td>' . ($i + 1) . '</td><td>' . e($r['name']) . '</td><td class="text-nowrap">'
                 . Template::actions('department', (int)$r['id']) . '</td></tr>';
        }
        if ($tr === '') $tr = '<tr><td colspan="3" class="text-center text-muted">Belum ada data</td></tr>';

        // Isi template; nilai form terisi jika sedang mode edit
        $content = (new Template('department.html'))->fill([
            'ALERT'  => Template::alert($msg),
            'ID'     => e($edit['id'] ?? ''),
            'NAME'   => e($edit['name'] ?? ''),
            'BTN'    => $edit ? 'Update' : 'Simpan',
            'CANCEL' => $edit ? '<a href="department.php" class="btn btn-secondary">Batal</a>' : '',
            'ROWS'   => $tr,
        ])->render();
        echo Template::page('Departemen', 'department', $content);
    }
}
