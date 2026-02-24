@extends('adminlte::page')

@section('title', 'Dashboard Siswa')

@section('content_header')
    <h1>Dashboard Siswa</h1>
@stop

@section('content')

<div class="row">

    {{-- Total --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $total }}</h3>
                <p>Total Pengaduan Saya</p>
            </div>
            <div class="icon">
                <i class="fas fa-comments"></i>
            </div>
        </div>
    </div>

    {{-- Menunggu --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $menunggu }}</h3>
                <p>Menunggu</p>
            </div>
            <div class="icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
        </div>
    </div>

    {{-- Diproses --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $diproses }}</h3>
                <p>Diproses</p>
            </div>
            <div class="icon">
                <i class="fas fa-spinner"></i>
            </div>
        </div>
    </div>

    {{-- Selesai --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $selesai }}</h3>
                <p>Selesai</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

</div>

{{-- Tabel Pengaduan Terakhir --}}
<div class="card">
    <div class="card-header bg-dark">
        <h3 class="card-title">Pengaduan Terakhir Saya</h3>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest as $item)
                    <tr>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        <td>{{ $item->category->nama_kategori }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            @if($item->status == 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($item->status == 'diproses')
                                <span class="badge badge-info">Diproses</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada pengaduan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@stop