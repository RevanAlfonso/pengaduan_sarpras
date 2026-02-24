@extends('adminlte::page')

@section('title', 'Daftar Pengaduan')

@section('content_header')
    <h1>Daftar Pengaduan</h1>
@stop

@section('content')

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('buat_pengaduan') }}" class="btn btn-primary">
            + Buat Pengaduan
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            Data Pengaduan Saya
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Response Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $key => $complaint)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $complaint->created_at->format('d-m-Y') }}</td>
                            <td>{{ $complaint->category->nama_kategori ?? '-' }}</td>
                            <td>{{ $complaint->title }}</td>

                            {{-- Badge Status --}}
                            <td class="text-center">
                                @if($complaint->status == 'menunggu')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($complaint->status == 'diproses')
                                    <span class="badge badge-primary">Diproses</span>
                                @elseif($complaint->status == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-secondary">
                                        {{ $complaint->status }}
                                    </span>
                                @endif
                            </td>

                            {{-- Response --}}
                            <td>
                                {{ $complaint->response ?? 'Belum ada respon' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada pengaduan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@stop