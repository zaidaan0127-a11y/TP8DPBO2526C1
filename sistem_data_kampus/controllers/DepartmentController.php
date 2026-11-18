<?php
// Controller halaman Departemen
class DepartmentController
{
    public function index(): void
    {
        $m = new Department();
        $msg = $_GET['msg'] ?? ''; // pesan hasil redirect

        // Form dikirim (simpan / ubah / hapus)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (($_POST['action'] ?? '') === 'delete') {
                    $m->delete((int)$_POST['id']);
                    $ok = 'Data dihapus';
                } else {
                    $d = ['name' => trim($_POST['name'] ?? '')];
                    if ($d['name'] === '') throw new RuntimeException('Nama wajib diisi'); // validasi
                    // ada id = ubah, tidak ada id = tambah
                    !empty($_POST['id']) ? $m->update((int)$_POST['id'], $d) : $m->add($d);
                    $ok = 'Data disimpan';
                }
                header('Location: department.php?msg=' . urlencode($ok)); // redirect agar tidak submit ulang saat refresh
                exit;
            } catch (Exception $ex) {
                // kode 23000 = pelanggaran unique / foreign key
                $msg = 'Gagal: ' . ($ex->getCode() == 23000 ? 'data duplikat / masih dipakai' : $ex->getMessage());
            }
        }

        // ?edit=ID -> ambil data untuk mengisi form
        $edit = isset($_GET['edit']) ? $m->find((int)$_GET['edit']) : null;
        (new DepartmentView())->render($m->all(), $edit, $msg);
    }
}
