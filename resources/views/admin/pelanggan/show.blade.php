@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <h3>Detail Pelanggan</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Detail Pelanggan --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Informasi Pelanggan</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td><strong>ID</strong></td>
                        <td>{{ $dataPelanggan->pelanggan_id }}</td>
                    </tr>
                    <tr>
                        <td><strong>First Name</strong></td>
                        <td>{{ $dataPelanggan->first_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Name</strong></td>
                        <td>{{ $dataPelanggan->last_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $dataPelanggan->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone</strong></td>
                        <td>{{ $dataPelanggan->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Gender</strong></td>
                        <td>{{ $dataPelanggan->gender ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Birthday</strong></td>
                        <td>{{ $dataPelanggan->birthday ? date('d-m-Y', strtotime($dataPelanggan->birthday)) : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Upload File Form --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Tambah File Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pelanggan.files.store', $dataPelanggan->pelanggan_id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="files" class="form-label">Pilih File</label>
                        <input type="file" name="files[]" id="files" class="form-control" multiple
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt">
                        <small class="text-muted">Format: JPG, JPEG, PNG, PDF, DOC, DOCX, TXT (Max: 2MB per file)</small>
                    </div>
                    <button type="submit" class="btn btn-success">Upload File</button>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        {{-- Uploaded Files --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Daftar File</h5>
            </div>
            <div class="card-body">
                @if ($files->count() > 0)
                    <ul class="list-group">
                        @foreach ($files as $file)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ asset('storage/uploads/' . $file->filename) }}" target="_blank"
                                        class="text-decoration-none">
                                        📄 {{ $file->filename }}
                                    </a>
                                    <br>
                                    <small class="text-muted">Uploaded:
                                        {{ $file->created_at->format('d-m-Y H:i') }}</small>
                                </div>
                                <form action="{{ route('pelanggan.files.destroy', $file->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus file ini?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Tidak ada file yang di-upload.</p>
                @endif
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mb-4">
            <a href="{{ route('pelanggan.edit', $dataPelanggan->pelanggan_id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            <form action="{{ route('pelanggan.destroy', $dataPelanggan->pelanggan_id) }}" method="POST"
                style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Hapus Pelanggan</button>
            </form>
        </div>
    @endsection
