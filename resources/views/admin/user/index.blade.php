@extends('layouts.admin.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg></a>
            </li>
            <li class="breadcrumb-item"><a href="#">User</a></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100 flex-wrap mb-3">
        <div>
            <h1 class="h4">Data User</h1>
            <p class="mb-0">List seluruh user</p>
        </div>
        <div>
            <a href="{{ route('user.create') }}" class="btn btn-success text-white">Tambah User</a>
        </div>
    </div>

    {{-- Search Form --}}
    <div class="mb-3">
        <form action="{{ route('user.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau email" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
            @if(request('search'))
                <a href="{{ route('user.index') }}" class="btn btn-secondary ms-2">Clear</a>
            @endif
        </form>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($datauser as $item)
                                    <tr>
                                        <td>
                                            @if ($item->profile_picture && file_exists(storage_path('app/public/' . $item->profile_picture)))
                                                <img src="{{ asset('storage/' . $item->profile_picture) }}" width="50" height="50" class="rounded-circle" style="object-fit:cover;">
                                            @else
                                                <img src="https://via.placeholder.com/50" width="50" height="50" class="rounded-circle">
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <a href="{{ route('user.edit', $item->id) }}" class="btn btn-info btn-sm">Edit</a>
                                            <a href="{{ route('profile.edit', $item->id) }}" class="btn btn-primary btn-sm mt-1">Show</a>
                                            <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline mt-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data user</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $datauser->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
