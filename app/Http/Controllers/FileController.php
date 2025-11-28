<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FileModel;
use App\Models\KlasifikasiData;
use App\Exports\KlasifikasiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class FileController extends Controller
{
    public function uploadPage()
    {
        return view('upload');
    }

    // proses upload file HTML dan redirect ke preview
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:html,htm'
        ]);

        $uploaded = $request->file('file');
        $filename = time() . '_' . preg_replace('/\s+/', '_', $uploaded->getClientOriginalName());
        $path = $uploaded->storeAs('html_files', $filename);

        $file = FileModel::create([
            'filename' => $path,
            'original_name' => $uploaded->getClientOriginalName()
        ]);

        return redirect()->route('parse', $file->id);
    }

    // parsing file HTML -> tampil preview (belum disimpan ke DB)
    public function parse($id)
    {
        $file = FileModel::findOrFail($id);
        $html = Storage::get($file->filename);

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NOCDATA);
        $xpath = new \DOMXPath($dom);

        // Atur node yang ingin diambil: p, td, div, li, span (sesuaikan)
        $nodes = $xpath->query('//p | //td | //div | //li | //span');

        $data = [];
        foreach ($nodes as $node) {
            $text = trim($node->textContent);
            // filter: buang string kosong & panjang minimal 3 karakter
            if ($text !== '' && mb_strlen($text) > 2) {
                $data[] = preg_replace("/\s+/", ' ', $text);
            }
        }

        return view('preview', compact('data', 'file'));
    }

    // simpan hasil parsing (dari preview) ke tabel classified_data
    public function save(Request $request, $id)
    {
        $file = FileModel::findOrFail($id);

        // data dikirim sebagai JSON string dari form hidden
        $data = json_decode($request->input('data'), true);
        if (!is_array($data)) {
            return redirect()->back()->with('error', 'Data tidak valid!');
        }

        foreach ($data as $item) {
            $clean = trim(strip_tags($item));
            if ($clean === '') continue;

            KlasifikasiData::create([
                'file_id' => $file->id,
                'content' => $clean,
                'category' => $this->classify($clean)
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan!');
    }

    // dashboard dengan filter + search
    public function dashboard(Request $req)
    {
        $items = KlasifikasiData::query();

        if ($req->filled('category')) {
            $items->where('category', $req->category);
        }

        if ($req->filled('search')) {
            $items->where('content', 'LIKE', '%' . $req->search . '%');
        }

        $items = $items->latest()->paginate(20)->withQueryString();

        // ambil list kategori unik untuk dropdown
        $categories = KlasifikasiData::select('category')->distinct()->pluck('category');

        return view('dashboard', compact('items', 'categories'));
    }

    // fungsi sederhana rule-based classifier (sesuaikan aturan)
    public function classify(string $text): string
    {
        $t = mb_strtolower($text);

        $rules = [
            'Keuangan' => ['uang', 'biaya', 'invoice', 'tagihan', 'transaksi', 'pembayaran', 'rekening'],
            'Akademik' => ['mahasiswa', 'dosen', 'kuliah', 'semester', 'sks', 'tugas akhir', 'skripsi', 'akademik'],
            'Personalia' => ['pegawai', 'karyawan', 'sdm', 'gaji', 'kontrak'],
            'Hukum' => ['peraturan', 'kontrak', 'putusan', 'undang', 'perjanjian'],
            'Teknis' => ['error', 'gagal', 'exception', 'debug', 'log', 'server', 'database']
        ];

        foreach ($rules as $cat => $keywords) {
            foreach ($keywords as $kw) {
                if (mb_stripos($t, $kw) !== false) return $cat;
            }
        }

        return 'Lainnya';
    }

    // EXPORT EXCEL (menggunakan Maatwebsite Excel)
    public function exportExcel()
    {
        $data = KlasifikasiData::all();
        return Excel::download(new KlasifikasiExport($data), 'klasifikasi.xlsx');
    }

    // EXPORT PDF (menggunakan barryvdh/laravel-dompdf)
    public function exportPdf()
    {
        $data = KlasifikasiData::all();
        $pdf = Pdf::loadView('exports.pdf', compact('data'));
        return $pdf->download('klasifikasi.pdf');
    }

    // API JSON
    public function apiAll()
    {
        return response()->json(KlasifikasiData::latest()->get());
    }

    public function apiByCategory($category)
    {
        return response()->json(KlasifikasiData::where('category', $category)->get());
    }
}
