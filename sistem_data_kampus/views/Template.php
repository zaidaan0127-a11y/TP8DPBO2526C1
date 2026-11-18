<?php
// Mesin template sederhana: membaca file HTML lalu mengganti {{KEY}}
class Template
{
    private $html; // isi file template

    public function __construct(string $file)
    {
        $this->html = file_get_contents(__DIR__ . '/../templates/' . $file);
    }

    // Ganti semua {{KEY}} sekaligus (satu kali proses, aman dari injeksi placeholder)
    public function fill(array $vars): self
    {
        $map = [];
        foreach ($vars as $k => $v) $map['{{' . $k . '}}'] = $v;
        $this->html = strtr($this->html, $map);
        return $this;
    }

    // Kembalikan HTML hasil akhir
    public function render(): string { return $this->html; }

    // Bungkus konten dengan layout (navbar + Bootstrap)
    public static function page(string $title, string $active, string $content): string
    {
        $nav = '';
        foreach (['index' => 'Dosen', 'department' => 'Departemen', 'course' => 'Mata Kuliah'] as $f => $label) {
            $cls = $f === $active ? ' active' : ''; // tandai menu halaman aktif
            $nav .= '<li class="nav-item' . $cls . '"><a class="nav-link" href="' . $f . '.php">' . $label . '</a></li>';
        }
        return (new self('layout.html'))->fill(['TITLE' => e($title), 'NAV' => $nav, 'CONTENT' => $content])->render();
    }

    // Kotak pesan (kosong jika tidak ada pesan)
    public static function alert(string $msg): string
    {
        return $msg === '' ? '' : '<div class="alert alert-info">' . e($msg) . '</div>';
    }

    // Buat <option> dropdown; $selected menandai pilihan saat mode edit
    public static function options(array $rows, string $valKey, string $textKey, $selected, string $placeholder): string
    {
        $o = '<option value="">' . e($placeholder) . '</option>';
        foreach ($rows as $r) {
            $sel = (string)$r[$valKey] === (string)$selected ? ' selected' : '';
            $o .= '<option value="' . e($r[$valKey]) . '"' . $sel . '>' . e($r[$textKey]) . '</option>';
        }
        return $o;
    }

    // Tombol Edit (link GET) dan Hapus (form POST + konfirmasi)
    public static function actions(string $page, int $id): string
    {
        return '<a class="btn btn-sm btn-warning" href="' . $page . '.php?edit=' . $id . '">Edit</a> '
             . '<form method="post" action="' . $page . '.php" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">'
             . '<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="' . $id . '">'
             . '<button class="btn btn-sm btn-danger">Hapus</button></form>';
    }
}
