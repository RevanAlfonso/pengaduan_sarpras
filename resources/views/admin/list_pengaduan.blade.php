@extends('adminlte::page')

@section('title', 'List Pengaduan')

@section('content_header')
    <h1>List Pengaduan</h1>
@stop

@section('content')

    {{-- FILTER --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            Filter Data Pengaduan
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('list_pengaduan') }}">
                <div class="row">

                    {{-- Filter Tanggal --}}
                    <div class="col-md-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control"
                               value="{{ request('tanggal') }}">
                    </div>

                    {{-- Filter Bulan --}}
                    <div class="col-md-2">
                        <label>Bulan</label>
                        <select name="bulan" class="form-control">
                            <option value="">-- Pilih --</option>
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}"
                                    {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- Filter Siswa --}}
                    <div class="col-md-3">
                        <label>Siswa</label>
                        <select name="user_id" class="form-control">
                            <option value="">-- Semua Siswa --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Kategori --}}
                    <div class="col-md-2">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Semua --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">-- Semua --</option>
                            <option value="menunggu" {{ request('status')=='menunggu'?'selected':'' }}>Menunggu</option>
                            <option value="diproses" {{ request('status')=='diproses'?'selected':'' }}>Diproses</option>
                            <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
                        </select>
                    </div>

                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('list_pengaduan') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>


    {{-- TABEL DATA --}}
    <div class="card mt-3">
        <div class="card-header bg-info text-white">
            Data Pengaduan
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $key => $complaint)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $complaint->created_at->format('d-m-Y') }}</td>
                            <td>{{ $complaint->user->name }}</td>
                            <td>{{ $complaint->category->nama_kategori }}</td>
                            <td>{{ $complaint->title }}</td>

                            {{-- Badge Status --}}
                            <td class="text-center">
                                @if($complaint->status == 'menunggu')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($complaint->status == 'diproses')
                                    <span class="badge badge-primary">Diproses</span>
                                @elseif($complaint->status == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('detail_pengaduan', $complaint->id) }}"
                                   class="btn btn-sm btn-info">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Tidak ada data pengaduan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@stop