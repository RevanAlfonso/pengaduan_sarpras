<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ComplaintController extends Controller
{

    /* =====================================================
                        BAGIAN USER / SISWA
    ===================================================== */

    // List pengaduan milik sendiri
    public function userIndex()
    {
        $complaints = Complaint::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.daftar_pengaduan', compact('complaints'));
    }

    // Form buat pengaduan
    public function create()
    {
        $categories = Category::all();
        return view('siswa.buat_pengaduan', compact('categories'));
    }

    // Simpan pengaduan
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        Complaint::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'menunggu',
            'response' => null
        ]);

        return redirect()->route('daftar_pengaduan')
            ->with('success', 'Pengaduan berhasil dikirim.');
    }



    /* =====================================================
                            BAGIAN ADMIN
    ===================================================== */

    // List semua pengaduan + filter
    public function adminIndex(Request $request)
    {
        $query = Complaint::with('user', 'category');

        // Filter per tanggal
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter per bulan
        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter per siswa
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter per kategori
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter per status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest()->get();
        $users = User::where('role', 'siswa')->get();
        $categories = Category::all();

        return view('admin.list_pengaduan', compact('complaints', 'users', 'categories'));
    }


    // Detail pengaduan
    public function show($id)
    {
        $complaint = Complaint::with('user', 'category')->findOrFail($id);

        return view('admin.detail_pengaduan', compact('complaint'));
    }


    // Proses pengaduan (update status + response)
    public function process(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'response' => 'required'
        ]);

        $complaint = Complaint::findOrFail($id);

        $complaint->update([
            'status' => $request->status,
            'response' => $request->response
        ]);

        return redirect()->route('list_pengaduan')
            ->with('success', 'Pengaduan berhasil diproses.');
    }



    /* =====================================================
                            CETAK PDF
    ===================================================== */

    public function laporan(Request $request)
    {
        $query = Complaint::with('user', 'category');

        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $complaints = $query->latest()->get();

        return view('admin.laporan', compact('complaints'));
    }

    public function cetakPdf(Request $request)
    {
        $query = Complaint::with('user', 'category');

        // Optional: ikutkan filter saat cetak
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $complaints = $query->latest()->get();

        $pdf = Pdf::loadView('admin.laporan_pengaduan', compact('complaints'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_pengaduan.pdf');
    }

    // Dashboard
    public function adminDashboard()
    {
        $total = Complaint::count();
        $menunggu = Complaint::where('status', 'menunggu')->count();
        $diproses = Complaint::where('status', 'diproses')->count();
        $selesai = Complaint::where('status', 'selesai')->count();

        $latest = Complaint::with('user', 'category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'total',
            'menunggu',
            'diproses',
            'selesai',
            'latest'
        ));
    }
}