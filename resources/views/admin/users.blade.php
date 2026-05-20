@extends('layouts.app')

@section('content')

<h2 class="fw-bold mb-4">Kelola User</h2>

<table class="table table-dark table-hover align-middle">

    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>

        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>

            <td>
                <form action="/admin/block/{{ $user->id }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-warning btn-sm rounded-pill">
                        Block
                    </button>
                </form>

                <form action="/admin/delete/{{ $user->id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm rounded-pill">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach

    </tbody>

</table>

@endsection