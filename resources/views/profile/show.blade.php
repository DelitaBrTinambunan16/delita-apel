@extends('layouts.admin.app')

@section('content')
<div class="container">

    <h3>Profil Saya</h3>

    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default.png') }}"
         width="150" class="rounded-circle mb-3">

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

</div>
@endsection
