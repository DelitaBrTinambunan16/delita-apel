@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <h3>Edit Pelanggan</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form Edit Pelanggan --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Edit Informasi Pelanggan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pelanggan.update', $dataPelanggan->pelanggan_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $dataPelanggan->first_name }}"
                            class="form-control @error('first_name') is-invalid @enderror">
                        @error('first_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $dataPelanggan->last_name }}"
                            class="form-control @error('last_name') is-invalid @enderror">
                        @error('last_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ $dataPelanggan->email }}"
                            class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ $dataPelanggan->phone ?? '' }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option value="">Pilih Gender</option>
                            <option value="Pria" {{ $dataPelanggan->gender == 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option value="Wanita" {{ $dataPelanggan->gender == 'Wanita' ? 'selected' : '' }}>Wanita
                            </option>
                            <option value="Lain-lain" {{ $dataPelanggan->gender == 'Lain-lain' ? 'selected' : '' }}>
                                Lain-lain</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date" name="birthday" id="birthday" value="{{ $dataPelanggan->birthday ?? '' }}"
                            class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>

        {{-- Form Upload File --}}
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

        {{-- List Files --}}
        <div class="card">
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
    </div>
@endsection
