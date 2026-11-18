<?php
// Controller halaman Mata Kuliah
class CourseController
{
    public function index(): void
    {
        $m = new Course();
        $msg = $_GET['msg'] ?? ''; // pesan hasil redirect

        // Form dikirim (simpan / ubah / hapus)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (($_POST['action'] ?? '') === 'delete') {
                    $m->delete((int)$_POST['id']);
                    $ok = 'Data dihapus';
                } else {
                    $d = [
                        'code'        => trim($_POST['code'] ?? ''),
                        'name'        => trim($_POST['name'] ?? ''),
                        'credits'     => (int)($_POST['credits'] ?? 3),
                        'semester'    => (int)($_POST['semester'] ?? 1),
                        'lecturer_id' => (int)($_POST['lecturer_id'] ?? 0),
                    ];
                    // validasi: kode, nama, dan dosen wajib
                    if ($d['code'] === '' || $d['name'] === '' || $d['lecturer_id'] === 0)
                        throw new RuntimeException('Kode, nama, dan dosen wajib diisi');
                    // ada id = ubah, tidak ada id = tambah
                    !empty($_POST['id']) ? $m->update((int)$_POST['id'], $d) : $m->add($d);
                    $ok = 'Data disimpan';
                }
                header('Location: course.php?msg=' . urlencode($ok)); // redirect setelah POST
                exit;
            } catch (Exception $ex) {
                // kode 23000 = kode mata kuliah sudah dipakai
                $msg = 'Gagal: ' . ($ex->getCode() == 23000 ? 'kode sudah dipakai' : $ex->getMessage());
            }
        }

        // ?edit=ID -> ambil data untuk mengisi form
        $edit = isset($_GET['edit']) ? $m->find((int)$_GET['edit']) : null;
        // Daftar dosen dibutuhkan untuk dropdown
        (new CourseView())->render($m->all(), (new Lecturer())->all(), $edit, $msg);
    }
}
