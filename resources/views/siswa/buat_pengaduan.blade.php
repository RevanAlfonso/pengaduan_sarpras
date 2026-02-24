@extends('adminlte::page')

@section('title', 'Buat Pengaduan')

@section('content_header')
    <h1>Buat Pengaduan</h1>
@stop

@section('content')

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            Form Pengaduan
        </div>

        <div class="card-body">
            <form action="{{ route('simpan_pengaduan') }}" method="POST">
                @csrf

                {{-- Pilih Kategori --}}
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Judul --}}
                <div class="form-group">
                    <label>Judul Pengaduan</label>
                    <input type="text" 
                           name="title" 
                           class="form-control" 
                           placeholder="Masukkan judul pengaduan"
                           value="{{ old('title') }}"
                           required>
                </div>

                {{-- Isi Pengaduan --}}
                <div class="form-group">
                    <label>Isi Pengaduan</label>
                    <textarea name="description" 
                              class="form-control" 
                              rows="5" 
                              placeholder="Tuliskan isi pengaduan..."
                              required>{{ old('description') }}</textarea>
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('daftar_pengaduan') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-success">
                        Kirim Pengaduan
                    </button>
                </div>

            </form>
        </div>
    </div>

@stop