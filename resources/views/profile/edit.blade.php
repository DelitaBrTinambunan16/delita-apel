@extends('layouts.admin.app')

@section('content')
<div class="container">

    <h3>Edit Profile</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Update --}}
    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Foto Profil</label><br>

            @if ($user->profile_picture && file_exists(storage_path('app/public/' . $user->profile_picture)))
                <img src="{{ asset('storage/' . $user->profile_picture) }}"
                     width="120" height="120" class="rounded mb-2" style="object-fit:cover; border:3px solid #ddd;">
            @else
                <img src="https://via.placeholder.com/120"
                     width="120" height="120" class="rounded mb-2" alt="Belum ada foto">
            @endif

            <input type="file" name="profile_picture" class="form-control mt-2">

            @error('profile_picture')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn btn-primary">Update</button>
    </form>

    {{-- Form Delete --}}
    @if ($user->profile_picture)
        <form action="{{ route('profile.destroy', $user->id) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Hapus Foto Profil</button>
        </form>
    @endif

</div>
@endsection
