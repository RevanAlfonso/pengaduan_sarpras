@extends('adminlte::page')

@section('title', 'Laporan Pengaduan')

@section('content_header')
    <h1>Laporan Pengaduan</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Data Pengaduan</h3>
        </div>

        <div class="card-body">

            <a href="{{ route('cetak_laporan') }}" 
               class="btn btn-danger mb-3" target="_blank">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $key => $complaint)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $complaint->created_at->format('d-m-Y') }}</td>
                                <td>{{ $complaint->user->name }}</td>
                                <td>{{ $complaint->category->nama_kategori }}</td>
                                <td>{{ $complaint->title }}</td>
                                <td>
                                    @if($complaint->status == 'menunggu')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($complaint->status == 'diproses')
                                        <span class="badge badge-info">Diproses</span>
                                    @else
                                        <span class="badge badge-success">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Tidak ada data pengaduan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@stop