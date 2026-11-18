<?php
// Controller halaman Dosen
class LecturerController
{
    public function index(): void
    {
        $m = new Lecturer();
        $msg = $_GET['msg'] ?? ''; // pesan hasil redirect

        // Form dikirim (simpan / ubah / hapus)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (($_POST['action'] ?? '') === 'delete') {
                    $m->delete((int)$_POST['id']);
                    $ok = 'Data dihapus';
                } else {
                    // Kolom opsional dikosongkan menjadi NULL lewat nv()
                    $d = [
                        'name'          => trim($_POST['name'] ?? ''),
                        'nidn'          => nv($_POST['nidn'] ?? ''),
                        'email'         => nv($_POST['email'] ?? ''),
                        'phone'         => nv($_POST['phone'] ?? ''),
                        'join_date'     => nv($_POST['join_date'] ?? ''),
                        'department_id' => nv($_POST['department_id'] ?? ''),
                    ];
                    if ($d['name'] === '') throw new RuntimeException('Nama wajib diisi'); // validasi
                    // ada id = ubah, tidak ada id = tambah
                    !empty($_POST['id']) ? $m->update((int)$_POST['id'], $d) : $m->add($d);
                    $ok = 'Data disimpan';
                }
                header('Location: index.php?msg=' . urlencode($ok)); // redirect setelah POST
                exit;
            } catch (Exception $ex) {
                $msg = 'Gagal: ' . $ex->getMessage();
            }
        }

        // ?edit=ID -> ambil data untuk mengisi form
        $edit = isset($_GET['edit']) ? $m->find((int)$_GET['edit']) : null;
        // Daftar departemen dibutuhkan untuk dropdown
        (new LecturerView())->render($m->all(), (new Department())->all(), $edit, $msg);
    }
}
