@extends('adminlte::page')

@section('title', 'Detail Pengaduan')

@section('content_header')
    <h1>
        <i class="fas fa-eye"></i>
        Detail Pengaduan
    </h1>
@stop

@section('content')

    {{-- Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>
                <i class="icon fas fa-ban"></i>
                Terjadi Kesalahan!
            </h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Informasi Pengaduan --}}
    <div class="card">
        <div class="card-header bg-info text-white">
            <h3 class="card-title">
                <i class="fas fa-info-circle"></i>
                Informasi Pengaduan
            </h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">
                        <i class="fas fa-user"></i>
                        Nama Siswa
                    </th>
                    <td>{{ $complaint->user->name }}</td>
                </tr>

                <tr>
                    <th>
                        <i class="fas fa-envelope"></i>
                        Email Siswa
                    </th>
                    <td>{{ $complaint->user->email }}</td>
                </tr>

                <tr>
                    <th>
                        <i class="fas fa-tag"></i>
                        Kategori
                    </th>
                    <td>{{ $complaint->category->nama_kategori }}</td>
                </tr>

                <tr>
                    <th>
                        <i class="fas fa-calendar"></i>
                        Tanggal
                    </th>
                    <td>
                        {{ $complaint->created_at->format('d-m-Y H:i') }}
                        <small class="text-muted">
                            ({{ $complaint->created_at->diffForHumans() }})
                        </small>
                    </td>
                </tr>

                <tr>
                    <th>
                        <i class="fas fa-heading"></i>
                        Judul
                    </th>
                    <td>{{ $complaint->title }}</td>
                </tr>

                <tr>
                    <th>
                        <i class="fas fa-align-left"></i>
                        Isi Pengaduan
                    </th>
                    <td>
                        <div class="p-3 bg-light rounded">
                            {{ $complaint->description }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>
                        <i class="fas fa-info-circle"></i>
                        Status
                    </th>
                    <td>
                        @if($complaint->status == 'menunggu')
                            <span class="badge badge-warning badge-lg">
                                <i class="fas fa-clock"></i> Menunggu
                            </span>
                        @elseif($complaint->status == 'diproses')
                            <span class="badge badge-primary badge-lg">
                                <i class="fas fa-spinner fa-spin"></i> Diproses
                            </span>
                        @elseif($complaint->status == 'selesai')
                            <span class="badge badge-success badge-lg">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                        @endif
                    </td>
                </tr>

                @if($complaint->response)
                <tr>
                    <th>
                        <i class="fas fa-reply"></i>
                        Response Sebelumnya
                    </th>
                    <td>
                        <div class="p-3 bg-success-light rounded">
                            {{ $complaint->response }}
                        </div>
                    </td>
                </tr>
                @endif
            </table>
        </div>
    </div>


    {{-- Form Proses Pengaduan --}}
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Proses Pengaduan
            </h3>
        </div>

        <div class="card-body">
            <form 
                action="{{ route('proses_pengaduan', $complaint->id) }}" 
                method="POST"
            >
                @csrf
                @method('PUT')

                {{-- Status --}}
                <div class="form-group">
                    <label>
                        <i class="fas fa-tasks"></i>
                        Ubah Status
                    </label>
                    <select 
                        name="status" 
                        class="form-control" 
                        required
                    >
                        <option 
                            value="menunggu" 
                            {{ $complaint->status == 'menunggu' ? 'selected' : '' }}
                        >Menunggu</option>
                        <option 
                            value="diproses" 
                            {{ $complaint->status == 'diproses' ? 'selected' : '' }}
                        >Diproses</option>
                        <option 
                            value="selesai" 
                            {{ $complaint->status == 'selesai' ? 'selected' : '' }}
                        >Selesai</option>
                    </select>
                </div>

                {{-- Response --}}
                <div class="form-group">
                    <label>
                        <i class="fas fa-reply"></i>
                        Response Admin
                    </label>
                    <textarea 
                        name="response"
                        class="form-control"
                        rows="4"
                        placeholder="Tulis tanggapan admin..."
                        required
                    >{{ old('response', $complaint->response) }}</textarea>
                </div>

                <div class="form-group text-right">
                    <a 
                        href="{{ route('list_pengaduan') }}" 
                        class="btn btn-secondary"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Daftar
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

@stop

@section('js')
    <script>
        // Auto-hide alert after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut('slow');
            }, 5000);
        });
    </script>
@stop