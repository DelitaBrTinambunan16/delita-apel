@extends('layouts.admin.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between w-100 flex-wrap mb-3">
        <div>
            <h1 class="h4">Edit User</h1>
        </div>
        <div>
            <a href="{{ route('user.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">

                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Foto Profil --}}
                        <div class="mb-3 text-center">
                            <img src="{{ $user->profile_picture && file_exists(storage_path('app/public/photos/' . $user->profile_picture))
                                        ? asset('storage/photos/' . $user->profile_picture)
                                        : 'https://via.placeholder.com/120' }}"
                                 width="120" height="120" class="rounded-circle mb-2" alt="Foto Profil">

                            <input type="file" name="profile_picture" class="form-control mt-2">
                            @error('profile_picture')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label>Password (Kosongkan jika tidak ingin mengganti)</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update User</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
