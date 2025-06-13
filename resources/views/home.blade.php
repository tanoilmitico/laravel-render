@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Card di benvenuto --}}
    <div class="card shadow-sm">
        <div class="card-body">
            
            {{-- Titolo di benvenuto --}}
            @auth
                <h2 class="card-title mb-3">Benvenuto, {{ Auth::user()->name }}!</h2>
            @else
                <h2 class="card-title mb-3">Benvenuto nella Home</h2>
            @endauth

            {{-- Messaggio di successo --}}
            @if (session('success'))
                <div class="alert alert-success d-flex justify-content-between align-items-center mt-3">
                    <span>{{ session('success') }}</span>
                    @auth
                        <a href="{{ route('my.posts') }}" class="btn btn-sm btn-outline-light ms-3">Vai ai tuoi post</a>
                    @endauth
                </div>
            @endif

            <p class="mt-3">Questa è la tua home personale. Usa i pulsanti in basso per navigare.</p>

            {{-- Azioni --}}
            <div class="mt-4">
                @auth
                    <div class="d-flex flex-wrap gap-2">

                        {{-- Crea post --}}
                        <a href="{{ route('posts.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Crea Post
                        </a>

                        {{-- Logout --}}
                        <form action="{{ route('logoutUser') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>

                        {{-- Solo per admin --}}
                        @if (Auth::user()->is_admin)
                            <a href="{{ route('admin.posts') }}" class="btn btn-warning">
                                <i class="bi bi-tools"></i> Gestione Post (Admin)
                            </a>
                        @endif
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                @endauth
            </div>

        </div>
    </div>

</div>
@endsection
