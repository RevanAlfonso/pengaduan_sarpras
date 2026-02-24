<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Complaint;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    if (Auth::user()->role == 'admin') {

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

    } else {

        $userId = Auth::id();

        $total = Complaint::where('user_id', $userId)->count();
        $menunggu = Complaint::where('user_id', $userId)->where('status', 'menunggu')->count();
        $diproses = Complaint::where('user_id', $userId)->where('status', 'diproses')->count();
        $selesai = Complaint::where('user_id', $userId)->where('status', 'selesai')->count();

        $latest = Complaint::with('category')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact(
            'total',
            'menunggu',
            'diproses',
            'selesai',
            'latest'
        ));
    }
}
}
