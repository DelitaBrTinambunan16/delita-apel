@extends('layouts.admin.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail User</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100 flex-wrap mb-3">
        <div>
            <h1 class="h4">Detail User</h1>
            <p class="mb-0">Informasi lengkap user.</p>
        </div>
        <div>
            <a href="{{ route('user.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow mb-4 text-center">
                <div class="card-body">
                    {{-- FOTO PROFIL --}}
                    <img src="{{ $user->profile_picture && file_exists(storage_path('app/public/photos/' . $user->profile_picture))
                                ? asset('storage/photos/' . $user->profile_picture)
                                : 'https://via.placeholder.com/120' }}"
                         width="120" height="120" class="rounded-circle mb-3" alt="Foto Profil">

                    <h3>{{ $user->name }}</h3>
                    <p class="text-muted">{{ $user->email }}</p>

                    <hr>

                    <div class="text-start px-4">
                        <p><strong>Nama Lengkap:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>

                    <hr>

                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info w-100 mb-2">Edit User</a>

                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger w-100">Hapus User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
