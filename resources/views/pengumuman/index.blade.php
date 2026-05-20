@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Pengumuman Terbaru</h2>
</div>

@foreach($pengumuman as $item)
<div class="card bg-secondary text-light mb-4 shadow-lg border-0 rounded-4">

    <div class="card-body">

        <h3 class="fw-bold">{{ $item->judul }}</h3>

        <p class="text-light-emphasis">
            {{ $item->isi }}
        </p>

        <hr>

        <form action="/komentar/{{ $item->id }}" method="POST">
            @csrf

            <textarea
                name="isi_komentar"
                class="form-control bg-dark text-light border-0"
                placeholder="Tulis komentar..."
            ></textarea>

            <button class="btn btn-primary mt-3 rounded-pill px-4">
                Kirim Komentar
            </button>
        </form>

    </div>
</div>
@endforeach

@endsection